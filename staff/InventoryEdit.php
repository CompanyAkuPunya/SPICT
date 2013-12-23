<?php require_once('../Connections/dataconn.php'); ?>
<?php require_once('StaffSession.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE peralatan SET Peralatan=%s, Jenis=%s, NoSiri=%s, Pengeluar=%s, Model=%s, Spesifikasi=%s, Kaedah=%s, TahunBeli=%s, DeskripsiProjek=%s, MulaSewa=%s, TamatSewa=%s, IdStaf=%s, IdSyarikat=%s WHERE Id=%s",
                       GetSQLValueString($_POST['Peralatan'], "text"),
                       GetSQLValueString($_POST['Jenis'], "text"),
                       GetSQLValueString($_POST['NoSiri'], "text"),
                       GetSQLValueString($_POST['Pengeluar'], "text"),
                       GetSQLValueString($_POST['Model'], "text"),
                       GetSQLValueString($_POST['Spesifikasi'], "text"),
                       GetSQLValueString($_POST['beliSewa'], "int"),
                       GetSQLValueString($_POST['TahunBeli'], "date"),
                       GetSQLValueString($_POST['DeskripsiProjek'], "text"),
                       GetSQLValueString($_POST['MulaSewa'], "date"),
                       GetSQLValueString($_POST['TamatSewa'], "date"),
                       GetSQLValueString($_POST['IdStaf'], "int"),
                       GetSQLValueString($_POST['IdSyarikat'], "int"),
                       GetSQLValueString($_POST['Id'], "int"));

  mysql_select_db($database_dataconn, $dataconn);
  $Result1 = mysql_query($updateSQL, $dataconn) or die(mysql_error());

  $updateGoTo = "InventoryMain.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rcd_EditInventory = "-1";
if (isset($_GET['IdInventory'])) {
  $colname_rcd_EditInventory = $_GET['IdInventory'];
}
mysql_select_db($database_dataconn, $dataconn);
$query_rcd_EditInventory = sprintf("SELECT * FROM peralatan WHERE Id = %s", GetSQLValueString($colname_rcd_EditInventory, "int"));
$rcd_EditInventory = mysql_query($query_rcd_EditInventory, $dataconn) or die(mysql_error());
$row_rcd_EditInventory = mysql_fetch_assoc($rcd_EditInventory);
$totalRows_rcd_EditInventory = mysql_num_rows($rcd_EditInventory);

mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Staff = "SELECT Id, Nama FROM staf ORDER BY Nama ASC";
$rcd_Staff = mysql_query($query_rcd_Staff, $dataconn) or die(mysql_error());
$row_rcd_Staff = mysql_fetch_assoc($rcd_Staff);
$totalRows_rcd_Staff = mysql_num_rows($rcd_Staff);

mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Company = "SELECT Id, Nama FROM syarikat ORDER BY Nama ASC";
$rcd_Company = mysql_query($query_rcd_Company, $dataconn) or die(mysql_error());
$row_rcd_Company = mysql_fetch_assoc($rcd_Company);
$totalRows_rcd_Company = mysql_num_rows($rcd_Company);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/staff.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>JABATAN PENERANGAN MALAYSIA</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/table_style.css"/>
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
			.calendar {
				font-family: 'Trebuchet MS', Tahoma, Verdana, Arial, sans-serif;
				font-size: 0.9em;
				background-color: #EEE;
				color: #333;
				border: 1px solid #DDD;
				-moz-border-radius: 4px;
				-webkit-border-radius: 4px;
				border-radius: 4px;
				padding: 0.2em;
				width: 14em;
			}
			
			.calendar .months {
				background-color: #F6AF3A;
				border: 1px solid #E78F08;
				-moz-border-radius: 4px;
				-webkit-border-radius: 4px;
				border-radius: 4px;
				color: #FFF;
				padding: 0.2em;
				text-align: center;
			}
			
			.calendar .prev-month,
			.calendar .next-month {
				padding: 0;
			}
			
			.calendar .prev-month {
				float: left;
			}
			
			.calendar .next-month {
				float: right;
			}
			
			.calendar .current-month {
				margin: 0 auto;
			}
			
			.calendar .months .prev-month,
			.calendar .months .next-month {
				color: #FFF;
				text-decoration: none;
				padding: 0 0.4em;
				-moz-border-radius: 4px;
				-webkit-border-radius: 4px;
				border-radius: 4px;
				cursor: pointer;
			}
			
			.calendar .months .prev-month:hover,
			.calendar .months .next-month:hover {
				background-color: #FDF5CE;
				color: #C77405;
			}
			
			.calendar table {
				border-collapse: collapse;
				padding: 0;
				font-size: 0.8em;
				width: 100%;
			}
			
			.calendar th {
				text-align: center;
			}
			
			.calendar td {
				text-align: right;
				padding: 1px;
				width: 14.3%;
			}
			
			.calendar td span {
				display: block;
				color: #1C94C4;
				background-color: #F6F6F6;
				border: 1px solid #CCC;
				text-decoration: none;
				padding: 0.2em;
				cursor: pointer;
			}
			
			.calendar td span:hover {
				color: #C77405;
				background-color: #FDF5CE;
				border: 1px solid #FBCB09;
			}
			
			.calendar td.today span {
				background-color: #FFF0A5;
				border: 1px solid #FED22F;
				color: #363636;
			}
		</style>
<!-- InstanceEndEditable -->
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 onload="MM_preloadImages('../images/menu_staf_profil2.png','../images/menu_staf_peralatan2.png','../images/menu_staf_laporan2.png')">
<center>
  <table width="980" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" valign="top"><a href="ProfileMain.php"><img src="../images/banner_SPICT.png" alt="" /></a>
          <table width="20%" border="0">
            </table>
          <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <!--<td><a href="#"><IMG SRC="../images/top_menu_1.gif" ALT="" WIDTH=23 HEIGHT=16 border="0"></a></td>-->
                <!--<td><a href="#"><IMG SRC="../images/top_menu_2.gif" ALT="" WIDTH=26 HEIGHT=16 border="0"></a></td>-->
                <!--<td><a href="#"><IMG SRC="../images/top_menu_3.gif" ALT="" WIDTH=24 HEIGHT=16 border="0"></a></td>-->
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF"><a href="staff_logout.php">
    <img src="../images/nav_logout1.png" width="64" height="14" /></a></td>
  </tr>
  <tr>
    <td><!--<IMG SRC="../images/header_top.gif" WIDTH=978 HEIGHT=21 ALT="">--></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#3399FF">
      <tr>
        <td align="center" width="33%" height="40"><a href="ProfileMain.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('profil','','../images/menu_profil2.png',1)"><img src="../images/menu_profil.png" name="profil" width="102" height="58" border="0" id="profil" /></a></td>
        <td align="center" width="33%" height="40"><a href="InventoryMain.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('peralatan','','../images/menu_peralatan2.png',1)"><img src="../images/menu_peralatan.png" name="peralatan" width="102" height="58" border="0" id="peralatan" /></a>     
        </td>
        <td align="center" width="33%" height="40"><a href="ReportMain.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('laporan','','../images/menu_laporan2.png',1)"><img src="../images/menu_laporan.png" name="laporan" width="102" height="58" border="0" id="laporan" /></a>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="padding: 10px 10px 10px 10px;">
    <table width="100%" border="0" cellspacing="10" cellpadding="0">
      <tr>
        <td >
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td align="left" bgcolor="#97CBFF" colspan="3">
		<!-- InstanceBeginEditable name="Content" -->
  <br /><br />
      <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
            <table width="50%" border="0" align="center">
              <tr>
                <td><table width="100%" align="center" id="formtable">
              <tr>
                <th scope="col" class="toplef">&nbsp;</th>
                <th colspan="3" scope="col">&nbsp;</th>
                <th scope="col" class="toprig">&nbsp;</th>
              </tr>
              <tr>
                <th width="3%" rowspan="17" scope="col" class="cenlef">&nbsp;</th>
                <th colspan="3" scope="col">KEMASKINI MAKLUMAT PERALATAN</th>
                <th width="3%" rowspan="17" scope="col" class="cenrig">&nbsp;</th>
              </tr>
              <tr>
                <th colspan="3" scope="col"><hr /></th>
                </tr>
              <tr>
                <th colspan="3" scope="col">&nbsp;</th>
                </tr>           
              <tr>
                <td><strong>Jenis Peralatan</strong></td>
                <td><strong>:</strong></td>
                <td><span id="spryselect1">
                  <select name="Jenis" id="Jenis">
                    <option value="-1" <?php if (!(strcmp(-1, $row_rcd_EditInventory['Jenis']))) {echo "selected=\"selected\"";} ?>>Sila Pilih Jenis Peralatan</option>
                    <option value="Software" <?php if (!(strcmp("Software", $row_rcd_EditInventory['Jenis']))) {echo "selected=\"selected\"";} ?>>Software</option>
                    <option value="Hardware" <?php if (!(strcmp("Hardware", $row_rcd_EditInventory['Jenis']))) {echo "selected=\"selected\"";} ?>>Hardware</option>
                    </select>
                  <br /><span class="selectInvalidMsg">Sila Pilih Jenis Peralatan</span>
                  <span class="selectRequiredMsg">Sila Pilih Jenis Peralatan</span></span></td>
                </tr>
                 <tr>
                 <td><strong>Peralatan</strong></td>
                <td><strong>:</strong></td>
                <td><span id="sprytextfield1">
                  <input name="Peralatan" type="text" class="text" id="Peralatan" value="<?php echo $row_rcd_EditInventory['Peralatan']; ?>" />
                  <br /><span class="textfieldRequiredMsg">Sila Masukkan Peralatan</span></span></td>
                </tr>
                 <tr>
                <td><strong>No Siri</strong></td>
                <td><strong>:</strong></td>
                <td><span id="sprytextfield4">
                  <input name="NoSiri" type="text" class="text" id="NoSiri" value="<?php echo $row_rcd_EditInventory['NoSiri']; ?>" /><br/>
                  <span class="textfieldRequiredMsg">Sila Masukkan No Siri</span></span></td>
                </tr>
              <tr>
                <td><strong>Pengeluar</strong></td>
                <td><strong>:</strong></td>
                <td><span id="sprytextfield2">
                  <label>
                    <input name="Pengeluar" type="text" id="Pengeluar" value="<?php echo $row_rcd_EditInventory['Pengeluar']; ?>"  class="text" />
                    </label>
                  <br /><span class="textfieldRequiredMsg">Sila Masukkan Pengeluar</span></span></td>
                </tr>
              <tr>
                <td><strong>Model</strong></td>
                <td><strong>:</strong></td>
                <td><span id="sprytextfield3">
                  <label>
                    <input name="Model" type="text" id="Model" value="<?php echo $row_rcd_EditInventory['Model']; ?>"  class="text"/>
                    </label>
                  <br /><span class="textfieldRequiredMsg">Sila Masukkan Model</span></span></td>
                </tr>
              <tr>
                <td><strong>Spesifikasi</strong></td>
                <td><strong>:</strong></td>
                <td><span id="sprytextarea1">
                  <label>
                    <textarea name="Spesifikasi" id="Spesifikasi" width="250"><?php echo $row_rcd_EditInventory['Spesifikasi']; ?></textarea>
                    </label>
                  <br /><span class="textareaRequiredMsg">Sila Masukkan Spesifikasi</span></span></td>
                </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
                </tr>
              <tr>
                <td><strong>Kaedah</strong></td>
                <td><strong>:</strong></td>
                <td>
                 <input type="radio" name="beliSewa" id="radioBeli" value="1" onClick="validateBeliSewa();"/>
                  Pembelian</label>
                  <input type="radio" name="beliSewa" id="radioSewa" value="2" onClick="validateBeliSewa();"/>
                  Sewaan
                  <input type="radio" name="beliSewa" id="radioProjek" value="3" onClick="validateBeliSewa();"/>
                  Projek</td>
                </tr>
              <tr>
                <td><strong>Tahun Beli/Sewa</strong></td>
                <td><strong>:</strong></td>
                <td>
                <input name="TahunBeli" type="text" id="TahunBeli" class="text" disabled="disabled" 
                value="<?php echo $row_rcd_EditInventory['TahunBeli']; ?>" />
                </td>
                </tr>
              <tr>
                <td><strong>Deskripsi Projek</strong></td>
                <td><strong>:</strong></td>
                <td><textarea name="DeskripsiProjek" id="DeskripsiProjek" class="text" disabled="disabled" ></textarea></td>
                </tr>
               <tr>
                 <td><strong>Mula Sewa</strong></td>
                <td><strong>:</strong></td>
                <td>
                <input name="MulaSewa" type="text" class="text" id="MulaSewa" disabled="disabled"
                value="<?php echo $row_rcd_EditInventory['MulaSewa']; ?>" /></td>
                </tr>
              <tr>
                <td><strong>Tamat Sewa</strong></td>
                <td><strong>:</strong></td>
                <td>
                <input name="TamatSewa" type="text" class="text" id="TamatSewa"  disabled="disabled"
                value="<?php echo $row_rcd_EditInventory['TamatSewa']; ?>" /></td>
                </tr>
             <tr>
               <td colspan="3" align="center"><input name="IdStaf" type="hidden" id="IdStaf" value="<?php echo $_SESSION['IdStaff']; ?>" /></td>
               </tr>
              <tr>
                <td><strong>Syarikat Selenggara</strong></td>
                <td><strong>:</strong></td>
                <td><span id="spryselect3">
                  <select name="IdSyarikat" id="IdSyarikat">
                    <option value="-1" <?php if (!(strcmp(-1, $row_rcd_EditInventory['IdSyarikat']))) {echo "selected=\"selected\"";} ?>>Sila Pilih Syarikat Selenggara</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_rcd_Company['Id']?>"<?php if (!(strcmp($row_rcd_Company['Id'], $row_rcd_EditInventory['IdSyarikat']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rcd_Company['Nama']?></option>
                    <?php
} while ($row_rcd_Company = mysql_fetch_assoc($rcd_Company));
  $rows = mysql_num_rows($rcd_Company);
  if($rows > 0) {
      mysql_data_seek($rcd_Company, 0);
	  $row_rcd_Company = mysql_fetch_assoc($rcd_Company);
  }
?>
                  </select>
                  <br /><span class="selectInvalidMsg">Sila Pilih Syarikat Selenggara</span>
                  <span class="selectRequiredMsg">Sila Pilih Syarikat Selenggara</span></span></td>
                </tr>
              <tr>
                <td colspan="3" align="center">&nbsp;</td>
                </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td colspan="3" align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
                </tr>
            </table></td>
                </tr>
              <tr>
                <td align="center"><input type="submit" name="save" id="save" value="Save" width="100" class="button"  />
                  <input type="button" name="bck_bttn" id="bck_bttn" value="Back" class="button" onclick="parent.location='InventoryMain.php'"/></td>
                </tr>
            </table>
            <input name="Id" type="hidden" id="Id" value="<?php echo $row_rcd_EditInventory['Id']; ?>" />
            <input type="hidden" name="MM_update" value="form1" />
      </form>
      <br /><br />
        <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", {invalidValue:"-1"});
//-->
        </script>
         <script type="text/javascript" src="../js/datepickr/datepickr.js"></script>
<script type="text/javascript">
new datepickr('MulaSewa', {
				'dateFormat': 'Y/m/d'
			});
			new datepickr('TamatSewa', {
				'dateFormat': 'Y/m/d'
			});
			
			function validateBeliSewa() {
				if(document.getElementById('radioBeli').checked == true) {
					document.getElementById('TahunBeli').disabled = false
					document.getElementById('DeskripsiProjek').disabled = true
					document.getElementById('MulaSewa').disabled = true
					document.getElementById('TamatSewa').disabled = true
				}
				else if(document.getElementById('radioProjek').checked == true) {
					document.getElementById('TahunBeli').disabled = true
					document.getElementById('DeskripsiProjek').disabled = false
					document.getElementById('MulaSewa').disabled = false
					document.getElementById('TamatSewa').disabled = false
				}
				else if(document.getElementById('radioSewa').checked == true) {
					document.getElementById('TahunBeli').disabled = true
					document.getElementById('DeskripsiProjek').disabled = true
					document.getElementById('MulaSewa').disabled = false
					document.getElementById('TamatSewa').disabled = false
				}
			}
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
        </script>
        <!-- InstanceEndEditable -->
          </td>
        </tr>
        </table>       
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td><!--<img src="../images/footer_line.gif" width="978" height="6">--></td>
  </tr>
  <tr>
     <td align="center" class="white" style="padding: 20px;">Copyright &copy;  Jabatan Penerangan Malaysia. All rights reserved.</td>
  </tr>
</table>
</center>
</BODY>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rcd_EditInventory);

mysql_free_result($rcd_Staff);

mysql_free_result($rcd_Company);
?>


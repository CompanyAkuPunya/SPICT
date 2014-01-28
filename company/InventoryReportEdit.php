<?php require_once('../Connections/dataconn.php'); ?>
<?php require_once('CompanySession.php'); ?>
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
  $updateSQL = sprintf("UPDATE laporanselenggara SET IdPeralatan=%s, JenisKerosakan=%s, TarikhLaporan=%s, KeteranganKerosakan=%s, TarikhSelenggara=%s, NotaSelenggara=%s, Status=%s, SLA=%s, Penyelenggara=%s WHERE Id=%s",
                       GetSQLValueString($_POST['IdPeralatan'], "int"),
                       GetSQLValueString($_POST['JenisKerosakan'], "text"),
                       GetSQLValueString($_POST['TarikhLaporan'], "date"),
                       GetSQLValueString($_POST['KeteranganKerosakan'], "text"),
                       GetSQLValueString($_POST['TarikhSelenggara'], "date"),
                       GetSQLValueString($_POST['NotaSelenggara'], "text"),
                       GetSQLValueString($_POST['Status'], "text"),
                       GetSQLValueString($_POST['sla'], "int"),
                       GetSQLValueString($_POST['penyelenggara'], "text"),
                       GetSQLValueString($_POST['IdLaporan'], "int"));

  mysql_select_db($database_dataconn, $dataconn);
  $Result1 = mysql_query($updateSQL, $dataconn) or die(mysql_error());

  $updateGoTo = "ReportMain.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

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

$colname_rcd_Inventory = "-1";
if (isset($_GET['IdInventory'])) {
  $colname_rcd_Inventory = $_GET['IdInventory'];
}
mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Inventory = sprintf("SELECT * FROM peralatan WHERE Id = %s", GetSQLValueString($colname_rcd_Inventory, "int"));
$rcd_Inventory = mysql_query($query_rcd_Inventory, $dataconn) or die(mysql_error());
$row_rcd_Inventory = mysql_fetch_assoc($rcd_Inventory);
$totalRows_rcd_Inventory = mysql_num_rows($rcd_Inventory);

$colname_rcd_Report = "-1";
if (isset($_GET['IdReport'])) {
  $colname_rcd_Report = $_GET['IdReport'];
}
mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Report = sprintf("SELECT * FROM laporanselenggara WHERE Id = %s", GetSQLValueString($colname_rcd_Report, "int"));
$rcd_Report = mysql_query($query_rcd_Report, $dataconn) or die(mysql_error());
$row_rcd_Report = mysql_fetch_assoc($rcd_Report);
$totalRows_rcd_Report = mysql_num_rows($rcd_Report);

mysql_select_db($database_dataconn, $dataconn);
$query_rcd_JenisKerosakan = "SELECT * FROM jeniskerosakan ORDER BY Keterangan ASC";
$rcd_JenisKerosakan = mysql_query($query_rcd_JenisKerosakan, $dataconn) or die(mysql_error());
$row_rcd_JenisKerosakan = mysql_fetch_assoc($rcd_JenisKerosakan);
$totalRows_rcd_JenisKerosakan = mysql_num_rows($rcd_JenisKerosakan);

mysql_select_db($database_dataconn, $dataconn);
$query_rcd_StatusSelenggara = "SELECT * FROM statusselenggara ORDER BY Keterangan ASC";
$rcd_StatusSelenggara = mysql_query($query_rcd_StatusSelenggara, $dataconn) or die(mysql_error());
$row_rcd_StatusSelenggara = mysql_fetch_assoc($rcd_StatusSelenggara);
$totalRows_rcd_StatusSelenggara = mysql_num_rows($rcd_StatusSelenggara);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/company.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>INVENTORY</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/table_style.css"/>
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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

<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 onload="MM_preloadImages('../images/menu_profil2.png','../images/menu_peralatan2.png','../images/menu_laporan2.png')">
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
    <td align="right" bgcolor="#FFFFFF"><a href="../staff/staff_logout.php">
    <img src="../images/nav_logout1.png" width="64" height="14" /></a></td>
  </tr>
  <tr>
    <td><!--<IMG SRC="../images/header_top.gif" WIDTH=978 HEIGHT=21 ALT="">--></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#3399FF">
      <tr>
        <td align="center" width="33%" height="40"><a href="ProfileMain.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('profil','','../images/menu_profil2.png',1)"><img src="../images/menu_profil.png" name="profil" width="102" height="58" border="0" id="profil" /></a>
        </td>
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
                    <td class="toplef">&nbsp;</td>
                    <td colspan="3" class="topmid">&nbsp;</td>
                    <td class="toprig">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="3%" rowspan="21" class="cenlef">&nbsp;</td>
                    <th colspan="3" align="center">KEMASKINI LAPORAN PENYELENGGARAAN</th>
                    <td width="3%" rowspan="21" class="cenrig">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><hr /></td>
                    </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="22%"><strong>Jenis Peralatan</strong></td>
                    <td width="3%"><strong>:</strong></td>
                    <td width="69%"><?php echo $row_rcd_Inventory['Jenis']; ?></td>
                    </tr>
                     <tr>
                       <td><strong>Pengeluar</strong></td>
                       <td><strong>:</strong></td>
                       <td><?php echo $row_rcd_Inventory['Pengeluar']; ?></td>
                     </tr>
                     <tr>
                       <td><strong>Model</strong></td>
                       <td><strong>:</strong></td>
                       <td><?php echo $row_rcd_Inventory['Model']; ?></td>
                     </tr>
                     <tr>
                    <td width="22%"><strong>No. Siri</strong></td>
                    <td width="3%"><strong>:</strong></td>
                    <td width="69%"><?php echo $row_rcd_Inventory['NoSiri']; ?></td>
                    </tr>
                     <tr>
                       <td><strong>Pengguna</strong></td>
                       <td><strong>:</strong></td>
                       <td><select name="IdStaf" id="IdStaf" disabled="disabled">
                         <option value="-1" <?php if (!(strcmp(-1, $row_rcd_Inventory['IdStaf']))) {echo "selected=\"selected\"";} ?>>Sila Pilih Staf</option>
                         <?php
do {  
?>
                         <option value="<?php echo $row_rcd_Staff['Id']?>"<?php if (!(strcmp($row_rcd_Staff['Id'], $row_rcd_Inventory['IdStaf']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rcd_Staff['Nama']?></option>
                         <?php
} while ($row_rcd_Staff = mysql_fetch_assoc($rcd_Staff));
  $rows = mysql_num_rows($rcd_Staff);
  if($rows > 0) {
      mysql_data_seek($rcd_Staff, 0);
	  $row_rcd_Staff = mysql_fetch_assoc($rcd_Staff);
  }
?>
                       </select></td>
                     </tr>
                     <tr>
                    <td><strong>Syarikat Selenggara</strong> </td>
                    <td><strong>:</strong></td>
                    <td><select name="IdSyarikat" id="IdSyarikat" disabled="disabled">
                      <option value="-1" <?php if (!(strcmp(-1, $row_rcd_Inventory['IdSyarikat']))) {echo "selected=\"selected\"";} ?>>Sila Pilih Syarikat</option>
                      <?php
do {  
?>
<option value="<?php echo $row_rcd_Company['Id']?>"<?php if (!(strcmp($row_rcd_Company['Id'], $row_rcd_Inventory['IdSyarikat']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rcd_Company['Nama']?></option>
                      <?php
} while ($row_rcd_Company = mysql_fetch_assoc($rcd_Company));
  $rows = mysql_num_rows($rcd_Company);
  if($rows > 0) {
      mysql_data_seek($rcd_Company, 0);
	  $row_rcd_Company = mysql_fetch_assoc($rcd_Company);
  }
?>
                    </select></td>
                  </tr>
                     <tr>
                    <td colspan="3">&nbsp;<hr/>&nbsp;</td>
                    </tr>
                  <tr>
                    <td colspan="3"><input name="IdLaporan" type="hidden" id="IdLaporan" value="<?php echo $row_rcd_Report['Id']; ?>" />                      <input name="IdPeralatan" type="hidden" id="IdPeralatan" value="<?php echo $row_rcd_Report['IdPeralatan']; ?>" /></td>
                    </tr>
                  <tr>
                    <td><strong>Tarikh Laporan</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield1">
                      <input name="TarikhLaporan" type="text" class="text" id="TarikhLaporan" disabled="disabled" value="<?php echo $row_rcd_Report['TarikhLaporan']; ?>" />
                      <span class="textfieldRequiredMsg">Sila Masukkan Tarikh Laporan</span></span></td>
                    </tr>
                    <tr>
                    <td><strong>Jenis Kerosakan</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="spryselect1">
                      <select name="JenisKerosakan" id="JenisKerosakan" disabled="disabled">
                        <option value="-1" <?php if (!(strcmp(-1, $row_rcd_Report['JenisKerosakan']))) {echo "selected=\"selected\"";} ?>>Sila Pilih Jenis Kerosakan</option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_rcd_JenisKerosakan['Id']?>"<?php if (!(strcmp($row_rcd_JenisKerosakan['Id'], $row_rcd_Report['JenisKerosakan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rcd_JenisKerosakan['Keterangan']?></option>
                        <?php
} while ($row_rcd_JenisKerosakan = mysql_fetch_assoc($rcd_JenisKerosakan));
  $rows = mysql_num_rows($rcd_JenisKerosakan);
  if($rows > 0) {
      mysql_data_seek($rcd_JenisKerosakan, 0);
	  $row_rcd_JenisKerosakan = mysql_fetch_assoc($rcd_JenisKerosakan);
  }
?>
                      </select>
                      <span class="selectInvalidMsg">Sila Pilih Jenis Kerosakan</span>
                      <span class="selectRequiredMsg">Sila Pilih Jenis Kerosakan</span></span></td>
                    </tr>
                    <tr>
                      <td><strong>Keterangan Kerosakan</strong></td>
                      <td><strong>:</strong></td>
                      <td><textarea name="KeteranganKerosakan" id="KeteranganKerosakan" cols="45" rows="5" disabled="disabled"><?php echo $row_rcd_Report['KeteranganKerosakan']; ?></textarea></td>
                    </tr>
                    <tr>
                    <td colspan="3">&nbsp;<hr/>&nbsp;</td>
                    </tr>
                    <tr>
                    <td><strong>Tarikh Selenggara</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield2">
                      <input name="TarikhSelenggara" type="text" class="text" id="TarikhSelenggara" value="<?php echo $row_rcd_Report['TarikhSelenggara']; ?>" />
                      <span class="textfieldRequiredMsg">Sila Masukkan Tarikh Selenggara</span></span></td>
                    </tr>
                  <tr>
                    <td><strong>Status</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="spryselect2">
                      <select name="Status" id="Status" title="<?php echo $row_rcd_Report['Status']; ?>">
                        <option value="-1" <?php if (!(strcmp(-1, $row_rcd_Report['Status']))) {echo "selected=\"selected\"";} ?>>Sila Pilih Status</option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_rcd_StatusSelenggara['Id']?>"<?php if (!(strcmp($row_rcd_StatusSelenggara['Id'], $row_rcd_Report['Status']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rcd_StatusSelenggara['Keterangan']?></option>
                        <?php
} while ($row_rcd_StatusSelenggara = mysql_fetch_assoc($rcd_StatusSelenggara));
  $rows = mysql_num_rows($rcd_StatusSelenggara);
  if($rows > 0) {
      mysql_data_seek($rcd_StatusSelenggara, 0);
	  $row_rcd_StatusSelenggara = mysql_fetch_assoc($rcd_StatusSelenggara);
  }
?>

                      </select>
                      <span class="selectInvalidMsg">Sila Pilih Status</span>
                      <span class="selectRequiredMsg">Sila Pilih Status</span></span></td>
                    </tr>
                    <tr>
                    <td><strong>Nota</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextarea1">
                      <textarea name="NotaSelenggara" class="text" id="NotaSelenggara"><?php echo $row_rcd_Report['NotaSelenggara']; ?></textarea>
<span class="textareaRequiredMsg">Sila Masukkan Nota Selenggara</span></span></td>
                    </tr>
                    <tr>
                       <td>SLA (Hari Bekerja)</td>
                       <td>:</td>
                       <td><select name="sla" id="sla">
                         <option value="5">5</option>
                         <option value="10">10</option>
                         <option value="15">15</option>
                         <option value="20">20</option>
                         <option value="25">25</option>
                         <option value="30">30</option>
                         <option value="35">35</option>
                         <option value="40">40</option>
                         <option value="45">45</option>
                         <option value="50">50</option>
                       </select></td>
                     </tr>
                     <tr>
                       <td>Penyelenggara</td>
                       <td>:</td>
                       <td> <input type="text" name="penyelenggara" id="penyelenggara" class="text" /></td>
                     </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td class="botlef">&nbsp;</td>
                    <td colspan="3" class="botmid">&nbsp;</td>
                    <td class="botrig">&nbsp;</td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td align="center">
                <input type="submit" name="save_bttn" id="save_bttn" value="Save" class="button" />
                <input type="button" name="bck_bttn" id="bck_bttn" value="Back" class="button" onclick="parent.location='InventoryMain.php'"/></td>
                </tr>
            </table>
          <input type="hidden" name="MM_update" value="form1" />
          </form>
          <br /><br />
        <script type="text/javascript" src="../js/datepickr/datepickr.js"></script>
<script type="text/javascript">
new datepickr('TarikhLaporan', {
				'dateFormat': 'Y/m/d'
			});
			new datepickr('TarikhSelenggara', {
				'dateFormat': 'Y/m/d'
			});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1"});
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
mysql_free_result($rcd_Staff);

mysql_free_result($rcd_Company);

mysql_free_result($rcd_Inventory);

mysql_free_result($rcd_Report);

mysql_free_result($rcd_JenisKerosakan);

mysql_free_result($rcd_StatusSelenggara);
?>
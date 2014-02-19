<?php require_once('../Connections/dataconn.php'); ?>
<?php require_once('AdminSession.php'); ?>
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
  $updateSQL = sprintf("UPDATE staf SET Nama=%s, NoMykad=%s, Jantina=%s, TarikhLahir=%s, NoTel=%s, NoHp=%s, Email=%s, Alamat=%s, Poskod=%s, Facebook=%s, Twitter=%s, Pejabat=%s, Negeri=%s, Cawangan=%s, Bahagian=%s, Jawatan=%s, NoBilik=%s, Username=%s, Password=%s WHERE Id=%s",
                       GetSQLValueString($_POST['Nama'], "text"),
                       GetSQLValueString($_POST['NoMykad'], "text"),
                       GetSQLValueString($_POST['Jantina'], "int"),
                       GetSQLValueString($_POST['TarikhLahir'], "date"),
                       GetSQLValueString($_POST['NoTel'], "int"),
                       GetSQLValueString($_POST['NoHp'], "int"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['Poskod'], "int"),
                       GetSQLValueString($_POST['Facebook'], "text"),
                       GetSQLValueString($_POST['Twitter'], "text"),
                       GetSQLValueString($_POST['Pejabat'], "int"),
                       GetSQLValueString($_POST['Negeri'], "int"),
                       GetSQLValueString($_POST['Cawangan'], "int"),
                       GetSQLValueString($_POST['Bahagian'], "text"),
                       GetSQLValueString($_POST['Jawatan'], "text"),
                       GetSQLValueString($_POST['NoBilik'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['NoMykad'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_dataconn, $dataconn);
  $Result1 = mysql_query($updateSQL, $dataconn) or die(mysql_error());

  $updateGoTo = "StaffMain.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rcd_EditStaf = "-1";
if (isset($_GET['Id'])) {
  $colname_rcd_EditStaf = $_GET['Id'];
}
mysql_select_db($database_dataconn, $dataconn);
$query_rcd_EditStaf = sprintf("SELECT * FROM staf WHERE Id = %s", GetSQLValueString($colname_rcd_EditStaf, "int"));
$rcd_EditStaf = mysql_query($query_rcd_EditStaf, $dataconn) or die(mysql_error());
$row_rcd_EditStaf = mysql_fetch_assoc($rcd_EditStaf);
$totalRows_rcd_EditStaf = mysql_num_rows($rcd_EditStaf);

mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Negeri = "SELECT * FROM negeri";
$rcd_Negeri = mysql_query($query_rcd_Negeri, $dataconn) or die(mysql_error());
$row_rcd_Negeri = mysql_fetch_assoc($rcd_Negeri);
$totalRows_rcd_Negeri = mysql_num_rows($rcd_Negeri);

mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Cawangan = "SELECT * FROM cawangan";
$rcd_Cawangan = mysql_query($query_rcd_Cawangan, $dataconn) or die(mysql_error());
$row_rcd_Cawangan = mysql_fetch_assoc($rcd_Cawangan);
$totalRows_rcd_Cawangan = mysql_num_rows($rcd_Cawangan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Jabatan Penerangan Malaysia</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/table_style.css"/>
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css" />
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
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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

<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 onload="MM_preloadImages('../images/menu_laporan2.png','../images/menu_staf2.png','../images/menu_peralatan2.png','../images/menu_syarikat2.png')">
<center>
  <table width="980" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" valign="top"><a href="ReportMain.php"><img src="../images/banner_SPICT.png" alt="" /></a>
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
    <td align="right" bgcolor="#FFFFFF" ><a href="admin_logout.php">
    <img src="../images/nav_logout1.png" width="64" height="14" /></a></td>
  </tr>
  <tr>
    <td><!--<img src="../images/header_top2.gif" width=978 height=21 alt="" />--></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#3399FF">
      <tr>
        <td align="center" width="20%" height="40"><a href="ReportMain.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('laporan','','../images/menu_laporan2.png',1)"><img src="../images/menu_laporan.png" name="laporan" width="102" height="58" border="0" id="laporan" /></a>
        </td>
        <td align="center" width="20%" height="40"><a href="StaffMain.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('staf','','../images/menu_staf2.png',1)"><img src="../images/menu_staf.png" name="staf" width="102" height="58" border="0" id="staf" /></a>
        </td>
        <td align="center" width="20%" height="40"><a href="InventoryMain.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('peralatan','','../images/menu_peralatan2.png',1)"><img src="../images/menu_peralatan.png" name="peralatan" width="102" height="58" border="0" id="peralatan" /></a>
        </td>
        <td align="center" width="20%" height="40"><a href="CompanyMain.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('syarikat','','../images/menu_syarikat2.png',1)"><img src="../images/menu_syarikat.png" name="syarikat" width="102" height="58" border="0" id="syarikat" /></a>
        </td>
        <td align="center" width="20%" height="40"><a href="DataMain.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('data','','../images/menu_data2.png',1)"><img src="../images/menu_data.png" name="data" width="102" height="58" border="0" id="data" /></a>
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
        <td  align="left" bgcolor="#97CBFF" colspan="3">
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
                    <th colspan="3" align="center">KEMASKINI MAKLUMAT STAF</th>
                    <td width="3%" rowspan="21" class="cenrig">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><hr /></td>
                    </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
                     <tr>
                      <td>Pejabat</td>
                      <td>:</td>
                      <td><input <?php if (!(strcmp($row_rcd_EditStaf['Pejabat'],"1"))) {echo "checked=\"checked\"";} ?> type="radio" name="Pejabat" id="PejabatUtama" value="1" onClick="validatePejabat();"/>
                  Ibu Pejabat</label>
                  <input <?php if (!(strcmp($row_rcd_EditStaf['Pejabat'],"2"))) {echo "checked=\"checked\"";} ?> type="radio" name="Pejabat" id="PejabatNegeri" value="2" onClick="validatePejabat();"/>
                  Pejabat Negeri</td>
                    </tr>
                    <tr>
                    <td><strong>Negeri</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="spryselect1">
                      <select name="Negeri" id="Negeri" disabled="disabled">
                        <option value="-1" <?php if (!(strcmp(-1, $row_rcd_EditStaf['Negeri']))) {echo "selected=\"selected\"";} ?>>Sila Pilih Negeri</option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_rcd_Negeri['Id']?>"<?php if (!(strcmp($row_rcd_Negeri['Id'], $row_rcd_EditStaf['Negeri']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rcd_Negeri['Keterangan']?></option>
                        <?php
} while ($row_rcd_Negeri = mysql_fetch_assoc($rcd_Negeri));
  $rows = mysql_num_rows($rcd_Negeri);
  if($rows > 0) {
      mysql_data_seek($rcd_Negeri, 0);
	  $row_rcd_Negeri = mysql_fetch_assoc($rcd_Negeri);
  }
?>
                      </select>
                      <span class="selectInvalidMsg">Sila Pilih Negeri</span>
                      <span class="selectRequiredMsg">Sila Pilih Negeri</span></span></td>
                  </tr>
                     <tr>
                    <td><strong>Cawangan</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="spryselect2">
                      <select name="Cawangan" id="Cawangan" disabled="disabled">
                        <option value="-1" <?php if (!(strcmp(-1, $row_rcd_EditStaf['Cawangan']))) {echo "selected=\"selected\"";} ?>>Sila Pilih Cawangan</option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_rcd_Cawangan['Id']?>"<?php if (!(strcmp($row_rcd_Cawangan['Id'], $row_rcd_EditStaf['Cawangan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rcd_Cawangan['Keterangan']?></option>
                        <?php
} while ($row_rcd_Cawangan = mysql_fetch_assoc($rcd_Cawangan));
  $rows = mysql_num_rows($rcd_Cawangan);
  if($rows > 0) {
      mysql_data_seek($rcd_Cawangan, 0);
	  $row_rcd_Cawangan = mysql_fetch_assoc($rcd_Cawangan);
  }
?>
                      </select>
                      <span class="selectInvalidMsg">Sila Pilih Cawangan</span>
                      <span class="selectRequiredMsg">Sila Pilih Cawangan</span></span></td>
                  </tr>
                  <tr>
                    <td><strong>Unit/Bahagian</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield3">
                      <input name="Bahagian" type="text" class="text" id="Bahagian" value="<?php echo $row_rcd_EditStaf['Bahagian']; ?>" />
                      <span class="textfieldRequiredMsg">Sila Masukkan Unit/Bahagian</span></span></td>
                    </tr>
                  <tr>
                    <td><strong>Jawatan</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield4">
                      <input name="Jawatan" type="text" class="text" id="Jawatan" value="<?php echo $row_rcd_EditStaf['Jawatan']; ?>" />
                      <span class="textfieldRequiredMsg">Sila masukkan Jawatan</span></span></td>
                    </tr>
                  <tr>
                    <td><strong>No Bilik</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield8">
                      <input name="NoBilik" type="text" class="text" id="NoBilik" value="<?php echo $row_rcd_EditStaf['NoBilik']; ?>" />
                      <span class="textfieldRequiredMsg">Sila masukkan No. Bilik</span></span></td>
                    </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="22%"><strong>Nama</strong></td>
                    <td width="3%"><strong>:</strong></td>
                    <td width="69%"><span id="sprytextfield1">
                      <input name="Nama" type="text" class="text" id="Nama" value="<?php echo $row_rcd_EditStaf['Nama']; ?>" width="250" />
                      <span class="textfieldRequiredMsg">Sila masukkan Nama</span></span></td>
                    </tr>
                  <tr>
                    <td><strong>No MyKad</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield2">
                    <input name="NoMykad" type="text" class="text" id="NoMykad" value="<?php echo $row_rcd_EditStaf['NoMykad']; ?>" width="250" />
                    <span class="textfieldRequiredMsg">Sila masukkan No MyKad</span></span><br />
                      </td>
                    </tr>
                  <tr>
                    <td><strong>Jantina</strong> </td>
                    <td><strong>:</strong></td>
                    <td><span id="spryradio1">
                    	<input <?php if (!(strcmp($row_rcd_EditStaf['Jantina'],"1"))) {echo "checked=\"checked\"";} ?> type="radio" name="Jantina" value="1" id="Jantina_0" />Lelaki
                        <input <?php if (!(strcmp($row_rcd_EditStaf['Jantina'],"2"))) {echo "checked=\"checked\"";} ?> type="radio" name="Jantina" value="2" id="Jantina_1" />Perempuan
                        <span class="radioRequiredMsg">Please make a selection.</span></span>
                        </td>
                    </tr>
                    <tr>
                    <td><strong>Tarikh Lahir</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield9">
                      <input name="TarikhLahir" type="text" class="text" id="TarikhLahir" value="<?php echo $row_rcd_EditStaf['TarikhLahir']; ?>" />
                      <span class="textfieldRequiredMsg">Sila Masukkan Tarikh Lahir</span></span></td>
                  </tr>
                   <tr>
                    <td><strong>No. Tel. Pejabat</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield5">
                      <input name="NoTel" type="text" class="text" id="NoTel" value="<?php echo $row_rcd_EditStaf['NoTel']; ?>" />
                      <span class="textfieldRequiredMsg">Sila masukkan No. Telefon Pejabat</span></span></td>
                    </tr>
                  <tr>
                    <td><strong>No. Tel. Bimbit</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield6">
                      <input name="NoHp" type="text" class="text" id="NoHp" value="<?php echo $row_rcd_EditStaf['NoHp']; ?>" />
                      <span class="textfieldRequiredMsg">Sila masukkan No. Telefon Bimbit</span></span></td>
                    </tr>
                  <tr>
                    <td><strong>Email</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield7">
                    <input name="Email" type="text" class="text" id="Email" value="<?php echo $row_rcd_EditStaf['Email']; ?>" />
                    <span class="textfieldRequiredMsg">Sila masukkan Email</span>
                    <span class="textfieldInvalidFormatMsg">Format email Salah</span></span></td>
                    </tr>
                    <tr>
                    <td><strong>Alamat</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextarea1">
                      <textarea name="alamat" id="alamat" cols="45" rows="5"><?php echo $row_rcd_EditStaf['Alamat']; ?></textarea>
                      <span class="textareaRequiredMsg">Sila Masukkan Alamat</span></span></td>
                  </tr>
                  <tr>
                    <td><strong>Poskod</strong></td>
                    <td><strong>:</strong></td>
                    <td><span id="sprytextfield11">
                      <input name="Poskod" type="text" class="text" id="Poskod" value="<?php echo $row_rcd_EditStaf['Poskod']; ?>" />
                      <span class="textfieldRequiredMsg">Sila Masukkan Poskod</span></span></td>
                  </tr>
                  <tr>
                    <td><strong>Facebook</strong></td>
                    <td><strong>:</strong></td>
                    <td><input name="Facebook" type="text" class="text" id="Facebook" value="<?php echo $row_rcd_EditStaf['Facebook']; ?>" /></td>
                  </tr>
                  <tr>
                    <td><strong>Twitter</strong></td>
                    <td><strong>:</strong></td>
                    <td><input name="Twitter" type="text" class="text" id="Twitter" value="<?php echo $row_rcd_EditStaf['Twitter']; ?>" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="3" >&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td class="botlef">&nbsp;</td>
                    <td colspan="3" class="botmid">&nbsp;</td>
                    <td class="botrig">&nbsp;</td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td align="center"><input type="submit" name="save_bttn" id="save_bttn" value="Save" class="button" />
                  <input type="button" name="bck_bttn" id="bck_bttn" value="Back" class="button" onclick="parent.location='StaffMain.php'"/></td>
                </tr>
            </table>
             <input name="id" type="hidden" id="id" value="<?php echo $row_rcd_EditStaf['Id']; ?>" />
             <input type="hidden" name="MM_update" value="form1" />
         </form>
         <br /><br />
         <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "email");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var spryradio1 = new Spry.Widget.ValidationRadio("spryradio1");
//-->
         </script>
	<script type="text/javascript" src="../js/datepickr/datepickr.js"></script>
<script type="text/javascript">
new datepickr('TarikhLahir', {
			'dateFormat': 'Y/m/d'
		});
		
		if(document.getElementById('PejabatUtama').checked == true) {
			document.getElementById('Negeri').disabled = true
			document.getElementById('Cawangan').disabled = true
		}else if(document.getElementById('PejabatNegeri').checked == true) {
			document.getElementById('Negeri').disabled = false
			document.getElementById('Cawangan').disabled = false
		}
		function validatePejabat() {
			if(document.getElementById('PejabatUtama').checked == true) {
				document.getElementById('Negeri').disabled = true
				document.getElementById('Cawangan').disabled = true
			}else if(document.getElementById('PejabatNegeri').checked == true) {
				document.getElementById('Negeri').disabled = false
				document.getElementById('Cawangan').disabled = false
			}
		}
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1"});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
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
mysql_free_result($rcd_EditStaf);

mysql_free_result($rcd_Negeri);

mysql_free_result($rcd_Cawangan);
?>

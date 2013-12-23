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
  $updateSQL = sprintf("UPDATE syarikat SET Nama=%s, Alamat=%s, NoTel=%s, Email=%s, Contact1_Nama=%s, Contact1_NoTel=%s, Contact1_NoHp=%s, Contact1_Email=%s, Contact2_Nama=%s, Contact2_NoTel=%s, Contact2_NoHp=%s, Contact2_Email=%s, Contact3_Nama=%s, Contact3_NoTel=%s, Contact3_NoHp=%s, Contact3_Email=%s WHERE Id=%s",
                       GetSQLValueString($_POST['Nama'], "text"),
                       GetSQLValueString($_POST['Alamat'], "text"),
                       GetSQLValueString($_POST['NoTel'], "int"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Contact1_Nama'], "text"),
                       GetSQLValueString($_POST['Contact1_NoTel'], "int"),
                       GetSQLValueString($_POST['Contact1_NoHp'], "int"),
                       GetSQLValueString($_POST['Contact1_Email'], "text"),
                       GetSQLValueString($_POST['Contact2_Nama'], "text"),
                       GetSQLValueString($_POST['Contact2_NoTel'], "int"),
                       GetSQLValueString($_POST['Contact2_NoHp'], "int"),
                       GetSQLValueString($_POST['Contact2_Email'], "text"),
                       GetSQLValueString($_POST['Contact3_Nama'], "text"),
                       GetSQLValueString($_POST['Contact3_NoTel'], "int"),
                       GetSQLValueString($_POST['Contact3_NoHp'], "int"),
                       GetSQLValueString($_POST['Contact3_Email'], "text"),
                       GetSQLValueString($_POST['Id'], "int"));

  mysql_select_db($database_dataconn, $dataconn);
  $Result1 = mysql_query($updateSQL, $dataconn) or die(mysql_error());

  $updateGoTo = "CompanyMain.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rcd_EditCompany = "-1";
if (isset($_GET['Id'])) {
  $colname_rcd_EditCompany = $_GET['Id'];
}
mysql_select_db($database_dataconn, $dataconn);
$query_rcd_EditCompany = sprintf("SELECT * FROM syarikat WHERE Id = %s", GetSQLValueString($colname_rcd_EditCompany, "int"));
$rcd_EditCompany = mysql_query($query_rcd_EditCompany, $dataconn) or die(mysql_error());
$row_rcd_EditCompany = mysql_fetch_assoc($rcd_EditCompany);
$totalRows_rcd_EditCompany = mysql_num_rows($rcd_EditCompany);
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
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
                <th scope="col">&nbsp;</th>
                <th colspan="3" scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th width="3%" rowspan="23" scope="col">&nbsp;</th>
                <th colspan="3" scope="col">KEMASKINI MAKLUMAT SYARIKAT SELENGGARA</th>
                <th width="3%" rowspan="23" scope="col">&nbsp;</th>
                </tr>
              <tr>
                <th colspan="3" scope="col">&nbsp;</th>
                </tr>
              <tr>
                <th colspan="3" scope="col">&nbsp;</th>
                </tr>
              <tr>
                <td>Nama Syarikat</td>
                <td>:</td>
                <td><span id="sprytextfield1">
                  <label>
                    <input name="Nama" type="text" id="Nama" value="<?php echo $row_rcd_EditCompany['Nama']; ?>" class="text" />
                    </label>
                  <span class="textfieldRequiredMsg">Sila Masukkan Nama Syarikat</span></span></td>
                </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><span id="sprytextarea1">
                  <label>
                    <textarea name="Alamat" id="Alamat" width="250"><?php echo $row_rcd_EditCompany['Alamat']; ?></textarea>
                    </label>
                  <span class="textareaRequiredMsg">Sila Masukkan Alamat Syarikat</span></span></td>
                </tr>
              <tr>
                <td>No Tel</td>
                <td>:</td>
                <td><span id="sprytextfield2">
                  <label>
                    <input name="NoTel" type="text" id="NoTel" value="<?php echo $row_rcd_EditCompany['NoTel']; ?>"  class="text"/>
                    </label>
                  <span class="textfieldRequiredMsg">Sila Masukkan No Telefon</span></span></td>
                </tr>
              <tr>
                <td>Email</td>
                <td>:</td>
                <td><span id="sprytextfield3">
                  <input name="Email" type="text" id="Email" value="<?php echo $row_rcd_EditCompany['Email']; ?>"  class="text"/><br />
                  <span class="textfieldRequiredMsg">Sila Masukkan Email</span></span></td>
                </tr>
              <tr>
                <td colspan="3" align="center">Contact Person 1</td>
                </tr>
              <tr>
                <td>Nama</td>
                <td>:</td>
                <td><span id="sprytextfield4">
                <input name="Contact1_Nama" type="text" id="Contact1_Nama" value="<?php echo $row_rcd_EditCompany['Contact1_Nama']; ?>"  class="text" /><br />
                  <span class="textfieldRequiredMsg">Sila Masukkan Nama</span></span></td>
                </tr>
              <tr>
                <td>No Tel Pejabat</td>
                <td>:</td>
                <td><span id="sprytextfield5">
                  <label>
                    <input name="Contact1_NoTel" type="text" id="Contact1_NoTel" value="<?php echo $row_rcd_EditCompany['Contact1_NoTel']; ?>" class="text"/>
                    </label><br />
                  <span class="textfieldRequiredMsg">Sila Masukkan No Telefon</span></span></td>
                </tr>
              <tr>
                <td>No Tel Bimbit</td>
                <td>:</td>
                <td><span id="sprytextfield6">
                  <label>
                    <input name="Contact1_NoHp" type="text" id="Contact1_NoHp" value="<?php echo $row_rcd_EditCompany['Contact1_NoHp']; ?>"  class="text" />
                    </label><br />
                  <span class="textfieldRequiredMsg">Sila Masukkan No Telefon Bimbit</span></span></td>
                </tr>
              <tr>
                <td>Email</td>
                <td>:</td>
                <td><span id="sprytextfield7">
                  <label>
                    <input name="Contact1_Email" type="text" id="Contact1_Email" value="<?php echo $row_rcd_EditCompany['Contact1_Email']; ?>"  class="text" />
                    </label><br />
                  <span class="textfieldRequiredMsg">Sila Masukkan Email</span></span></td>
                </tr>
                <tr>
                <td colspan="3" align="center">Contact Person 2</td>
                </tr>
              <tr>
                <td>Nama</td>
                <td>:</td>
                <td><label>
                  <input name="Contact2_Nama" type="text" id="Contact2_Nama" value="<?php echo $row_rcd_EditCompany['Contact2_Nama']; ?>"  class="text" />
                </label></td>
                </tr>
              <tr>
                <td>No Tel Pejabat</td>
                <td>:</td>
                <td><label>
                  <input name="Contact2_NoTel" type="text" id="Contact2_NoTel" value="<?php echo $row_rcd_EditCompany['Contact2_NoTel']; ?>"  class="text" />
                </label></td>
                </tr>
              <tr>
                <td>No Tel Bimbit</td>
                <td>:</td>
                <td><label>
                  <input name="Contact2_NoHp" type="text" id="Contact2_NoHp" value="<?php echo $row_rcd_EditCompany['Contact2_NoHp']; ?>"  class="text"/>
                </label></td>
                </tr>
              <tr>
                <td>Email</td>
                <td>:</td>
                <td><label>
                  <input name="Contact2_Email" type="text" id="Contact2_Email" value="<?php echo $row_rcd_EditCompany['Contact2_Email']; ?>"  class="text" />
                </label></td>
                </tr>
                <tr>
                <td colspan="3" align="center">Contact Person 3</td>
                </tr>
              <tr>
                <td>Nama</td>
                <td>:</td>
                <td><label>
                  <input name="Contact3_Nama" type="text" id="Contact3_Nama" value="<?php echo $row_rcd_EditCompany['Contact3_Nama']; ?>"  class="text" />
                </label></td>
                </tr>

              <tr>
                <td>No Tel Pejabat</td>
                <td>:</td>
                <td><label>
                  <input name="Contact3_NoTel" type="text" id="Contact3_NoTel" value="<?php echo $row_rcd_EditCompany['Contact3_NoTel']; ?>"  class="text"/>
                </label></td>
                </tr>
              <tr>
                <td>No Tel Bimbit</td>
                <td>:</td>
                <td><label>
                  <input name="Contact3_NoHp" type="text" id="Contact3_NoHp" value="<?php echo $row_rcd_EditCompany['Contact3_NoHp']; ?>" class="text" />
                </label></td>
                </tr>
              <tr>
                <td>Email</td>
                <td>:</td>
                <td><label>
                  <input name="Contact3_Email" type="text" id="Contact3_Email" value="<?php echo $row_rcd_EditCompany['Contact3_Email']; ?>" class="text" />
                </label></td>
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
                <td align="center"><input type="submit" name="add" id="add" value="Save" width="100" class="button" />
                  <input type="button" name="bck_bttn" id="bck_bttn" value="Back" class="button" onclick="parent.location='CompanyMain.php'"/></td>
                </tr>
            </table>
            <input name="Id" type="hidden" id="Id" value="<?php echo $row_rcd_EditCompany['Id']; ?>" />
            <input type="hidden" name="MM_update" value="form1" />
           </form>
           <br /><br />
           <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
//-->
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
mysql_free_result($rcd_EditCompany);
?>

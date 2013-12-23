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
  $updateSQL = sprintf("UPDATE syarikat SET Nama=%s, Alamat=%s, NoTel=%s, Email=%s, Contact1_Nama=%s, Contact1_NoTel=%s, Contact1_NoHp=%s, Contact1_Email=%s, Contact2_Nama=%s, Contact2_NoTel=%s, Contact2_NoHp=%s, Contact2_Email=%s, Contact3_Nama=%s, Contact3_NoTel=%s, Contact3_NoHp=%s, Contact3_Email=%s WHERE Id=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['notel'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
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
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_dataconn, $dataconn);
  $Result1 = mysql_query($updateSQL, $dataconn) or die(mysql_error());

  $updateGoTo = "ProfileMain.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rcd_Company = "-1";
if (isset($_SESSION['IdCompany'])) {
  $colname_rcd_Company = $_SESSION['IdCompany'];
}
mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Company = sprintf("SELECT * FROM syarikat WHERE Id = %s", GetSQLValueString($colname_rcd_Company, "int"));
$rcd_Company = mysql_query($query_rcd_Company, $dataconn) or die(mysql_error());
$row_rcd_Company = mysql_fetch_assoc($rcd_Company);
$totalRows_rcd_Company = mysql_num_rows($rcd_Company);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/company.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Jabatan Penerangan Malaysia</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/table_style.css"/>
<!-- InstanceBeginEditable name="head" -->
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
         <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
			<table width="50%" border="0" align="center">
              <tr>
                <td><table width="100%" align="center" id="formtable">
                  <tr>
                    <td colspan="3" align="center"><table width="100%" align="center" id="formtable2">
                      <tr>
                        <td class="toplef">&nbsp;</td>
                        <td colspan="3" class="topmid">&nbsp;</td>
                        <td class="toprig">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="3%" rowspan="23" class="cenlef">&nbsp;</td>
                        <td colspan="3" align="center"><strong>Profil Syarikat</strong></td>
                        <td width="3%" rowspan="23" class="cenrig">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3"><hr /></td>
                      </tr>
                      <tr>
                        <td colspan="3"><input name="id" type="hidden" id="id" value="<?php echo $row_rcd_Company['Id']; ?>" /></td>
                      </tr>
                      <tr>
                        <td width="22%"><strong>Nama Syarikat</strong></td>
                        <td width="3%"><strong>:</strong></td>
                        <td width="69%"><input name="nama" type="text" class="text" id="nama" value="<?php echo $row_rcd_Company['Nama']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>Alamat</strong></td>
                        <td><strong>:</strong></td>
                        <td><textarea name="alamat" id="alamat" cols="45" rows="5"><?php echo $row_rcd_Company['Alamat']; ?></textarea></td>
                      </tr>
                      <tr>
                        <td><strong>No. Tel.</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="notel" type="text"  class="text" id="notel" value="<?php echo $row_rcd_Company['NoTel']; ?>"/></td>
                      </tr>
                      <tr>
                        <td><strong>Email</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="email" type="text" class="text" id="email" value="<?php echo $row_rcd_Company['Email']; ?>" /></td>
                      </tr>
                      <tr>
                        <td colspan="3" align="center"><hr /><strong>Contact Person 1</strong><hr /></td>
                      </tr>
                      <tr>
                        <td><strong>Nama</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact1_Nama" type="text" class="text" id="textfield4" value="<?php echo $row_rcd_Company['Contact1_Nama']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>No. Tel. Pejabat</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact1_NoTel" type="text" class="text" id="textfield5" value="<?php echo $row_rcd_Company['Contact1_NoTel']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>No. Tel. Bimbit</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact1_NoHp" type="text" class="text" id="textfield6" value="<?php echo $row_rcd_Company['Contact1_NoHp']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>Email</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact1_Email" type="text" class="text" id="textfield7" value="<?php echo $row_rcd_Company['Contact1_Email']; ?>" /></td>
                      </tr>
                      <tr>
                        <td colspan="3" align="center"><hr /><strong>Contact Person 2</strong><hr /></td>
                      </tr>
                      <tr>
                        <td><strong>Nama</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact2_Nama" type="text" class="text" id="textfield8" value="<?php echo $row_rcd_Company['Contact2_Nama']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>No. Tel. Pejabat</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact2_NoTel" type="text" class="text" id="textfield9" value="<?php echo $row_rcd_Company['Contact2_NoTel']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>No. Tel. Bimbit</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact2_NoHp" type="text" class="text" id="textfield10" value="<?php echo $row_rcd_Company['Contact2_NoHp']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>Email</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact2_Email" type="text" class="text" id="textfield11" value="<?php echo $row_rcd_Company['Contact2_Email']; ?>" /></td>
                      </tr> <tr>
                        <td colspan="3" align="center"><hr /><strong>Contact Person 3</strong><hr /></td>
                      </tr>
                      <tr>
                        <td><strong>Nama</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact3_Nama" type="text" class="text" id="textfield12" value="<?php echo $row_rcd_Company['Contact3_Nama']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>No. Tel. Pejabat</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact3_NoTel" type="text" class="text" id="textfield13" value="<?php echo $row_rcd_Company['Contact3_NoTel']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>No. Tel. Bimbit</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact3_NoHp" type="text" class="text" id="textfield14" value="<?php echo $row_rcd_Company['Contact3_NoHp']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><strong>Email</strong></td>
                        <td><strong>:</strong></td>
                        <td><input name="Contact3_Email" type="text" class="text" id="textfield15" value="<?php echo $row_rcd_Company['Contact3_Email']; ?>" /></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="botlef">&nbsp;</td>
                        <td colspan="3" class="botmid">&nbsp;</td>
                        <td class="botrig">&nbsp;</td>
                      </tr>
                    </table>                 </td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td align="center"><input type="submit" name="save_bttn" id="save_bttn" value="Save" class="button" />
                  <input type="button" name="bck_bttn" id="bck_bttn" value="Back" onclick="parent.location='ProfileMain.php'" class="button"/></td>
                </tr>
            </table>
			<input type="hidden" name="MM_update" value="form1" />
         </form>
        <br /><br />
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
mysql_free_result($rcd_Company);
?>

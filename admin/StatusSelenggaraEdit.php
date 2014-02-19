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
  $updateSQL = sprintf("UPDATE statusselenggara SET Keterangan=%s WHERE Id=%s",
                       GetSQLValueString($_POST['Status'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_dataconn, $dataconn);
  $Result1 = mysql_query($updateSQL, $dataconn) or die(mysql_error());

  $updateGoTo = "/spict/admin/StatusSelenggaraMain.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rcd_Status = "-1";
if (isset($_GET['Id'])) {
  $colname_rcd_Status = $_GET['Id'];
}
mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Status = sprintf("SELECT * FROM statusselenggara WHERE Id = %s", GetSQLValueString($colname_rcd_Status, "int"));
$rcd_Status = mysql_query($query_rcd_Status, $dataconn) or die(mysql_error());
$row_rcd_Status = mysql_fetch_assoc($rcd_Status);
$totalRows_rcd_Status = mysql_num_rows($rcd_Status);
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

<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
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
                <th scope="col" class="toplef">&nbsp;</th>
                <th colspan="3" scope="col">&nbsp;</th>
                <th scope="col" class="toprig">&nbsp;</th>
              </tr>
              <tr>
                <th width="3%" rowspan="5" scope="col" class="cenlef">&nbsp;</th>
                <th colspan="3" scope="col">KEMASKINI  STATUS SELENGGARA</th>
                <th width="3%" rowspan="5" scope="col" class="cenrig">&nbsp;</th>
                </tr>
              <tr>
                <th colspan="3" scope="col"><hr /></th>
                </tr>
              <tr>
                <th colspan="3" scope="col"><input name="id" type="hidden" id="id" value="<?php echo $row_rcd_Status['Id']; ?>" /></th>
                </tr>
              <tr>
                <td>Status Selenggara</td>
                <td><strong>:</strong></td>
                <td><span id="sprytextarea1">
                  <textarea name="Status" id="Status" class="text"><?php echo $row_rcd_Status['Keterangan']; ?></textarea>
                  <span class="textareaRequiredMsg">Sila Masukkan Status Selenggara</span></span></td>
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
            	<input type="button" name="bck_bttn" id="bck_bttn" value="Back" class="button" onclick="parent.location='StatusSelenggaraMain.php'"/></td>
                </tr>
            </table>
          <input type="hidden" name="MM_update" value="form1" />
          </form>
        <br /><br />
		<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
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
mysql_free_result($rcd_Status);
?>

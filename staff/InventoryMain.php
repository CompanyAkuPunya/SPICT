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
if (isset($_POST['Search'])) {
  $Search = $_POST['Search'];
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rcd_Inventory = 20;
$pageNum_rcd_Inventory = 0;
if (isset($_GET['pageNum_rcd_Inventory'])) {
  $pageNum_rcd_Inventory = $_GET['pageNum_rcd_Inventory'];
}
$startRow_rcd_Inventory = $pageNum_rcd_Inventory * $maxRows_rcd_Inventory;

mysql_select_db($database_dataconn, $dataconn);
if (isset($_POST['Search'])) {
$query_rcd_Inventory = sprintf("SELECT peralatan.Id, peralatan.Peralatan, peralatan.Jenis, peralatan.Pengeluar, peralatan.Model 
							   	FROM peralatan LEFT JOIN staf ON peralatan.IdStaf = staf.Id
							   	WHERE Peralatan like %s AND staf.Id = %s
								ORDER BY Jenis ASC",
								GetSQLValueString("%" .$Search. "%", "text"),
								GetSQLValueString($_SESSION['IdStaff'], "int"));
}else{
$query_rcd_Inventory = sprintf("SELECT peralatan.Id, peralatan.Peralatan, peralatan.Jenis, peralatan.Pengeluar, peralatan.Model 
							   	FROM peralatan LEFT JOIN staf ON peralatan.IdStaf = staf.Id
							   	WHERE staf.Id = %s
								ORDER BY Jenis ASC",
								GetSQLValueString($_SESSION['IdStaff'], "int"));
}
$query_limit_rcd_Inventory = sprintf("%s LIMIT %d, %d", $query_rcd_Inventory, $startRow_rcd_Inventory, $maxRows_rcd_Inventory);
$rcd_Inventory = mysql_query($query_limit_rcd_Inventory, $dataconn) or die(mysql_error());
$row_rcd_Inventory = mysql_fetch_assoc($rcd_Inventory);

if (isset($_GET['totalRows_rcd_Inventory'])) {
  $totalRows_rcd_Inventory = $_GET['totalRows_rcd_Inventory'];
} else {
  $all_rcd_Inventory = mysql_query($query_rcd_Inventory);
  $totalRows_rcd_Inventory = mysql_num_rows($all_rcd_Inventory);
}
$totalPages_rcd_Inventory = ceil($totalRows_rcd_Inventory/$maxRows_rcd_Inventory)-1;

$queryString_rcd_Inventory = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rcd_Inventory") == false && 
        stristr($param, "totalRows_rcd_Inventory") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rcd_Inventory = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rcd_Inventory = sprintf("&totalRows_rcd_Inventory=%d%s", $totalRows_rcd_Inventory, $queryString_rcd_Inventory);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/staff.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
        <form id="form1" name="form1" method="post" action="InventoryMain.php">
         <table width="90%" border="0" align="center">
           <tr>
                <td align="center"><h3>SENARAI PERALATAN</h3></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</tr>
               <tr>
                <td align="center">
                <input name="Search" type="text" class="text" id="Search" value="<?php 
				if (isset($_POST['Search'])) {
					 echo $_POST['Search'];
				}; ?>" />
                <input type="submit" name="btn" id="btn" value="Carian" /></td>
              </tr>
              <tr>
                <td align="right"><a href="InventoryAdd.php"><img src="../images/add.gif" width="16" height="16" /> Tambah Peralatan</a></td>
              </tr>
          </table>
        
           <table width="90%" border="1" align="center"  id="newspaper-b">
          	<thead>
              <tr>
              <th scope="col" align="center" width="50px">Bil</th>
                <th scope="col" align="center">Peralatan</th>
                <th scope="col" align="center">Jenis Peralatan</th>
                <th scope="col" align="center">Pengeluar</th>
                <th scope="col" align="center">Model</th>
                <th scope="col" align="center" width="50px">&nbsp;</th>
              </tr>
              </thead>
              <?php  $counter = ($startRow_rcd_Inventory + 1); do { ?>
                <tr>
    <td align="center"><?php echo $counter ?></td>
    <td><?php echo $row_rcd_Inventory['Peralatan']; ?></td>
    <td><?php echo $row_rcd_Inventory['Jenis']; ?></td>
    <td><?php echo $row_rcd_Inventory['Pengeluar']; ?></td>
    <td><?php echo $row_rcd_Inventory['Model']; ?></td>
    <td align="center"><a href="InventoryEdit.php?IdInventory=<?php echo $row_rcd_Inventory['Id']; ?>">
    <img src="../images/edit.png"  width="16" height="16" /></a>|
    <a href="InventoryReport.php?IdInventory=<?php echo $row_rcd_Inventory['Id']; ?>">
    <img src="../images/report.png" width="16" height="16" /></a></td>
  </tr>
                <?php $counter++; } while ($row_rcd_Inventory = mysql_fetch_assoc($rcd_Inventory)); ?>
            </table>
 <p align="center" ><span class="px10">Rekod <?php echo ($startRow_rcd_Inventory + 1) ?> 
 Hingga <?php echo min($startRow_rcd_Inventory + $maxRows_rcd_Inventory, $totalRows_rcd_Inventory) ?> 
 Daripada </span>
      <?php echo $totalRows_rcd_Inventory ?></p>

<table width="20%" border="0" cellpadding="1" align="center">
    <tr>
    <td align="center" width="25%"><a href="<?php printf("%s?pageNum_rcd_Inventory=%d%s", $currentPage, 0, $queryString_rcd_Inventory); ?>"><img src=	"../images/paging_far_left.png" name="first" width="24" height="24" border="0" id="first" /></a></td>
    <td align="center" width="25%"><a href="<?php printf("%s?pageNum_rcd_Inventory=%d%s", $currentPage, max(0, $pageNum_rcd_Inventory - 1), $queryString_rcd_Inventory); ?>"><img src="../images/paging_left.png" name="previous" width="24" height="24" border="0" id="previous" /></a></td>
    <td align="center" width="25%"><a href="<?php printf("%s?pageNum_rcd_Inventory=%d%s", $currentPage, min($totalPages_rcd_Inventory, $pageNum_rcd_Inventory + 1), $queryString_rcd_Inventory); ?>"><img src="../images/paging_right.png" name="next" width="24" height="24" border="0" id="next" /></a></td>
    <td align="center" width="25%"><a href="<?php printf("%s?pageNum_rcd_Inventory=%d%s", $currentPage, $totalPages_rcd_Inventory, $queryString_rcd_Inventory); ?>"><img src="../images/paging_far_right.png" alt="" name="last" width="24" height="24" border="0" id="last" /></a></td>
    </tr>
</table>
<br /><br />
          </form>
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
mysql_free_result($rcd_Inventory);
?>

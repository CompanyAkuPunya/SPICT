<?php require_once('Connections/dataconn.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "staff/ProfileMain.php";
  $MM_redirectLoginFailed = "Login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_dataconn, $dataconn);
  
  $LoginRS__query=sprintf("SELECT Username, Password FROM staf WHERE Username=%s AND Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $dataconn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/before.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Jabatan Penerangan Malaysia</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/table_style.css"/>

<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<center>
<table width="980" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" valign="top"><a href="index.php"><img src="images/banner_SPICT.png" alt="" /></a>
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
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#3399FF">
      <tr>
        <td>&nbsp;</td>
        <td align="center" width="20%" height="40"><a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('staf','','images/menu_staf2.png',1)"><img src="images/menu_staf.png" name="staf" width="102" height="58" border="0" id="staf" /></a></td>
        <td align="center" width="20%" height="40"><a href="company_login.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('syarikat','','images/menu_syarikat2.png',1)"><img src="images/menu_syarikat.png" name="syarikat" width="102" height="58" border="0" id="syarikat" /></a></td>
        <td align="center" width="20%" height="40"><a href="admin_login.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('admin','','images/menu_admin2.png',1)"><img src="images/menu_admin.png" name="admin" width="102" height="58" border="0" id="admin" /></a></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="padding: 10px 10px 10px 10px;">
    <table width="100%" border="0" cellspacing="10" cellpadding="0">
      <tr>
        <td width="100%" valign="top" class="border" bgcolor="#3399CC">
        <table width="100%">
        <tr>
        <td align="center">
		<!-- InstanceBeginEditable name="Content" -->
         <br />
           <br />
          <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>"> 
            <table width="40%" id="formtable" >
              <tr>
                <td scope="col" class="toplef" width="3%">&nbsp;</td>
                <td scope="col"  colspan="3" class="topmid" width="92%">&nbsp;</td>
                <td scope="col" class="toprig" width="3%">&nbsp;</td>
              </tr>
              <tr>
                <td rowspan="6" class="cenlef">&nbsp;</td>
                <td scope="col"  colspan="3" align="center"><strong>STAFF LOGIN</strong><br />
                  <br />
                  <span class="RED">
                  <!--Invalid Password and Username-->
                  </span></td>
                <td rowspan="6" scope="col" class="cenrig">&nbsp;</td>
                </tr>
            
            <tr>
              <td align="right">Username</td>
              <td>:</td>
              <td>
                <input type="text" name="username" id="username"/>
              </td>
              </tr>
            <tr>
              <td align="right">Password</td>
              <td>:</td>
              <td>
                <input type="password" name="password" id="password"/>
                </td>
              </tr>
              <tr>
                <td align="center" colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" colspan="3">
                <input type="submit" name="btn_ok" id="btn_ok" value="  OK  " />
                <input type="reset" name="reset" id="reset" value="  Reset  " />
                </td>
                </tr>
              <tr>
                <td align="right" colspan="3">&nbsp;</td>
                </tr>
              <tr>
                <td  class="botlef">&nbsp;</td>
                <td align="right" colspan="3" class="botmid">&nbsp;</td>
                <td class="botrig">&nbsp;</td>
              </tr>
            </table>
           </form>
        <br />
        <br />
        <!-- InstanceEndEditable -->
          </td>
        </tr>
        </table>
        </td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td><!--<img src="../images/footer_line.gif" width="978" height="6">--></td>
  </tr>
  <tr>
     <td align="center" class="white" style="padding: 20px;">
     Copyright &copy;  Jabatan Penerangan Malaysia. All rights reserved.<br /><br /><br /></td>
  </tr>
</table>
</center>
</BODY>
<!-- InstanceEnd --></html>

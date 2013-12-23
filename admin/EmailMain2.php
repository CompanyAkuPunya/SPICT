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

mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Server = "SELECT * FROM server";
$rcd_Server = mysql_query($query_rcd_Server, $dataconn) or die(mysql_error());
$row_rcd_Server = mysql_fetch_assoc($rcd_Server);
$totalRows_rcd_Server = mysql_num_rows($rcd_Server);

$idReport = "-1";
if (isset($_GET['IdReport'])) {
  $idReport = $_GET['IdReport'];
}
mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Report = sprintf("SELECT A.JenisKerosakan, A.TarikhLaporan, A.KeteranganKerosakan, 
							B. Peralatan, B.Jenis, B.Pengeluar, B.Model,
							C.Nama As NamaStaf, C.Email as EmailStaf,
							D.Nama As NamaSyarikat, D.Email As EmailSyarikat
							FROM laporanselenggara A LEFT JOIN peralatan B ON A.IdPeralatan = B.Id
							LEFT JOIN staf C ON B.IdStaf = C.Id
							LEFT JOIN syarikat D ON B.IdSyarikat = D.Id
							ORDER BY A.Id DESC LIMIT 1");
$rcd_Report = mysql_query($query_rcd_Report, $dataconn) or die(mysql_error());
$row_rcd_Report = mysql_fetch_assoc($rcd_Report);
$totalRows_rcd_Report = mysql_num_rows($rcd_Report);

//include the file
require_once('../include/class.phpmailer.php');

$phpmailer          = new PHPMailer();

//$phpmailer->IsSMTP(); // telling the class to use SMTP
//$phpmailer->Host       = "ssl://smtp.gmail.com"; // SMTP server
//$phpmailer->SMTPAuth   = true;                  // enable SMTP authentication
//$phpmailer->Port       = 465;          // set the SMTP port for the GMAIL server; 465 for ssl and 587 for tls
//$phpmailer->Username   = "zakwanfata@gmail.com"; // Gmail account username
//$phpmailer->Password   = "";        // Gmail account password
//$phpmailer->SetFrom('zakwan.fata@gmail.com', 'Zakwan Fata'); //set from name

$phpmailer->IsSMTP(); // telling the class to use SMTP
$phpmailer->Host       = $row_rcd_Server['SMTP']; // SMTP server
$phpmailer->SMTPAuth   = true;                  // enable SMTP authentication
$phpmailer->Port       = $row_rcd_Server['Port'];          // set the SMTP port for the mail server;
$phpmailer->Username   = $row_rcd_Server['Username']; // account username
$phpmailer->Password   = $row_rcd_Server['Password'];        // account password
$phpmailer->SetFrom($row_rcd_Server['Email'], 'SPICT JPM'); //set from name

$phpmailer->Subject    = "Penyelenggaraan Peralatan JPM";
$phpmailer->MsgHTML("SALAM SEJAHTERA <br/>
Berikut adalah butiran peralatan yang perlu diselenggara <br/><br/>
Staf                : " . $row_rcd_Report['NamaStaf'] . "<br/><br/>
Peralatan           : " . $row_rcd_Report['Peralatan'] . "<br/>
Jenis Peralatan     : " . $row_rcd_Report['Jenis'] . "<br/>
Pengeluar           : " . $row_rcd_Report['Pengeluar'] . "<br/>
Model               : " . $row_rcd_Report['Model'] . "<br/><br/>
Jenis Peralatan     : " . $row_rcd_Report['JenisKerosakan'] . "<br/>
Tarikh Laporan      : " . $row_rcd_Report['TarikhLaporan'] . "<br/>
KeteranganKerosakan : " . $row_rcd_Report['KeteranganKerosakan'] . "<br/><br/><br/>
Sekian Terima Kasih,<br/>
Sistem Penyelenggaraan ICT,<br/>
JABATAN PENERANGAN MALAYSIA
");

$phpmailer->AddAddress($row_rcd_Report['EmailSyarikat'], $row_rcd_Report['NamaSyarikat']);
$phpmailer->AddCC($row_rcd_Report['EmailStaf'], $row_rcd_Report['NamaStaf']);
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
		<!-- InstanceBeginEditable name="Content" --><br/><br/>
        <table width="50%" border="0" align="center">
			<tr>
                <td align="center">
				<?php if(!$phpmailer->Send()) { ?>
  					<strong><span class="RED">Email Notifikasi tidak dapat dihantar ke Syarikat Selenggara</span></strong><br /><br />
				<?php echo "Mailer Error: " . $phpmailer->ErrorInfo; } else { ?>
  				 	<strong>Email Notifikasi telah dihantar ke Syarikat Selenggara</strong>
				<?php } ?>
                </td>
            </tr>
			<tr>
			  <td align="center">&nbsp;</td>
			  </tr>
            <tr>
                <td align="center">
                <input type="button" name="bck_bttn" id="bck_bttn" value="Back" class="button" onclick="parent.location='ReportMain.php'"/>
                </td>
			</tr>
       	</table>
       
        <br/><br/>
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
mysql_free_result($rcd_Report);
mysql_free_result($rcd_Server);
?>
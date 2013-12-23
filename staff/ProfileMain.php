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

$colname_rcd_Staff = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rcd_Staff = $_SESSION['MM_Username'];
}
mysql_select_db($database_dataconn, $dataconn);
$query_rcd_Staff = sprintf("SELECT A.Id,A.Pejabat, A.Bahagian, A.Jawatan, A.NoBilik, A.Nama, A.NoMykad, A.Jantina, A.TarikhLahir,
						   A.NoTel, A.NoHp, A.Email, A.Alamat, A.Poskod, A.Facebook, A.Twitter, 
						   B.Keterangan As NamaNegeri, C.Keterangan As NamaCawangan
						   FROM staf  A 
						   LEFT JOIN negeri B ON A.Negeri=B.Id 
						   LEFT JOIN Cawangan C ON A.Cawangan=C.Id 
						   WHERE A.Username = %s", GetSQLValueString($colname_rcd_Staff, "text"));
$rcd_Staff = mysql_query($query_rcd_Staff, $dataconn) or die(mysql_error());
$row_rcd_Staff = mysql_fetch_assoc($rcd_Staff);
$totalRows_rcd_Staff = mysql_num_rows($rcd_Staff);


// store session data
if(isset($_SESSION['IdStaff'])){
	$_SESSION['IdStaff']=$row_rcd_Staff['Id'];
}
else{
	$_SESSION['IdStaff']=$row_rcd_Staff['Id'];
}
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
                    <td width="3%" rowspan="25" class="cenlef">&nbsp;</td>
                    <th colspan="3" align="center">PROFIL STAF</th>
                    <td width="3%" rowspan="25" class="cenrig">&nbsp;</td>
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
                      <td><?php if ($row_rcd_Staff['Pejabat']== 1) {?> IBU PEJABAT
						  <?php } if ($row_rcd_Staff['Pejabat']== 2) {?> PEJABAT NEGERI <?php } ?>
                      </td>
                    </tr>
                    <tr>
                    <td><strong>Negeri</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['NamaNegeri']; ?></td>
                  </tr>
                     <tr>
                    <td><strong>Cawangan</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['NamaCawangan']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Unit/Bahagian</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['Bahagian']; ?></td>
                    </tr>
                  <tr>
                    <td><strong>Jawatan</strong></td>
                    <td>&nbsp;</td>
                    <td><?php echo $row_rcd_Staff['Jawatan']; ?></td>
                    </tr>
                  <tr>
                    <td><strong>No Bilik</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['NoBilik']; ?></td>
                    </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="22%"><strong>Nama</strong></td>
                    <td width="3%"><strong>:</strong></td>
                    <td width="69%"><?php echo $row_rcd_Staff['Nama']; ?></td>
                    </tr>
                  <tr>
                    <td><strong>No MyKad</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['NoMykad']; ?></td>
                    </tr>
                  <tr>
                    <td><strong>Jantina</strong> </td>
                    <td><strong>:</strong></td>
                    <td><?php if ($row_rcd_Staff['Jantina']== 1) {?> LELAKI 
						<?php } if ($row_rcd_Staff['Jantina']== 2) {?> PEREMPUAN <?php } ?>
                    </td>
                    </tr>
                    <tr>
                    <td><strong>Tarikh Lahir</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['TarikhLahir']; ?></td>
                  </tr>
                   <tr>
                    <td><strong>No. Tel. Pejabat</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['NoTel']; ?></td>
                    </tr>
                  <tr>
                    <td><strong>No. Tel. Bimbit</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['NoHp']; ?></td>
                    </tr>
                  <tr>
                    <td><strong>Email</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['Email']; ?></td>
                    </tr>
                    <tr>
                    <td><strong>Alamat</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['Alamat']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Poskod</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['Poskod']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Facebook</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['Facebook']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Twitter</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['Twitter']; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td><strong>Password</strong></td>
                    <td><strong>:</strong></td>
                    <td><?php echo $row_rcd_Staff['Password']; ?></td>
                    </tr>
                    <tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                    <td><strong>Gambar</strong></td>
                    <td><strong>:</strong></td>
                    <td>&nbsp;</td>
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
                <td align="center"><input type="button" name="bck_bttn" id="bck_bttn" value="Edit" class="button" onclick="parent.location='ProfileEdit.php'"/></td>
                </tr>
            </table>
             <input name="id" type="hidden" id="id" value="<?php echo $row_rcd_EditStaf['Id']; ?>" />
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
mysql_free_result($rcd_Staff);
?>

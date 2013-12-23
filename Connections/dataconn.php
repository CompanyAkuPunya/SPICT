<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dataconn = "localhost";
$database_dataconn = "spict";
$username_dataconn = "root";
$password_dataconn = "";
$dataconn = mysql_pconnect($hostname_dataconn, $username_dataconn, $password_dataconn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
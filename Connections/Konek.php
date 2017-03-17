<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
error_reporting(0);
$hostname_Konek = "localhost";
$database_Konek = "futsalgold";
$username_Konek = "root";
$password_Konek = "";
$Konek = mysql_pconnect($hostname_Konek, $username_Konek, $password_Konek) or trigger_error(mysql_error(),E_USER_ERROR); 

?>
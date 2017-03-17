<?php include "konek.php" ?>
<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_DS = $hostname_Konek;
$database_DS = $database_Konek;
$username_DS = $username_Konek;
$password_DS = $password_Konek;
$DS = mysql_pconnect($hostname_DS, $username_DS, $password_DS) or trigger_error(mysql_error(),E_USER_ERROR);

?>
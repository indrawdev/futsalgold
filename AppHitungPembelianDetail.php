<?php require_once('Connections/Konek.php'); ?>
<?php
include ("function.php");

mysql_select_db($database_Konek, $Konek);
$query_RX = "SELECT * FROM `pembelian - master`";
$RX = mysql_query($query_RX, $Konek) or die(mysql_error());
$row_RX = mysql_fetch_assoc($RX);
$totalRows_RX = mysql_num_rows($RX);

echo "waiting...";

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

mysql_select_db($database_Konek, $Konek);
$query_RA = "SELECT * FROM `pembelian - master` WHERE ID=".$_GET['id'];
$RA = mysql_query($query_RA, $Konek) or die(mysql_error());
$row_RA = mysql_fetch_assoc($RA);
$totalRows_RA = mysql_num_rows($RA);

mysql_select_db($database_Konek, $Konek);
$query_RB = "SELECT * FROM `pembelian - detail` WHERE `IDM`=".$row_RA['ID'];
$RB = mysql_query($query_RB, $Konek) or die(mysql_error());
$row_RB = mysql_fetch_assoc($RB);
$totalRows_RB = mysql_num_rows($RB);

//      
 do {

$TotalHP = $row_RB['Harga Beli'] * $row_RB['Jumlah'];
		
		$updateSQLM = "UPDATE `pembelian - detail` SET `Total HP`=$TotalHP WHERE ID=".$row_RB['ID'];                                                                        
        mysql_query($updateSQLM, $Konek) or die(mysql_error());		
		
} while ($row_RB = mysql_fetch_assoc($RB)); 		
//

echo "<meta http-equiv=refresh content=0;URL=AppHitungPembelian.php?id=".$_GET['id']."&go=".$_GET['go'].">";
?>
<?php
mysql_free_result($RA);
mysql_free_result($RB);
mysql_free_result($RX);
?>

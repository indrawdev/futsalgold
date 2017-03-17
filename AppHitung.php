<?php include('Connections/Konek.php'); ?>
<?php
include ("function.php");

mysql_select_db($database_Konek, $Konek);
$query_RX = "SELECT * FROM `persewaan lapangan - master`";
$RX = mysql_query($query_RX, $Konek) or die(mysql_error());
$row_RX = mysql_fetch_assoc($RX);
$totalRows_RX = mysql_num_rows($RX);

echo "update total...";

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
$query_RA = "SELECT * FROM `persewaan lapangan - master` WHERE ID=".$_GET['id'];
$RA = mysql_query($query_RA, $Konek) or die(mysql_error());
$row_RA = mysql_fetch_assoc($RA);
$totalRows_RA = mysql_num_rows($RA);

mysql_select_db($database_Konek, $Konek);
$query_RB = "SELECT Sum(HargaSewa) as SubTotal FROM `persewaan lapangan - detail` WHERE `IDM`=".$row_RA['ID'];
$RB = mysql_query($query_RB, $Konek) or die(mysql_error());
$row_RB = mysql_fetch_assoc($RB);
$totalRows_RB = mysql_num_rows($RB);

mysql_select_db($database_Konek, $Konek);
$query_RC = "SELECT * FROM `persewaan lapangan - detail` WHERE `IDM`=".$row_RA['ID'];
$RC = mysql_query($query_RC, $Konek) or die(mysql_error());
$row_RC = mysql_fetch_assoc($RC);
$totalRows_RC = mysql_num_rows($RC);

//
$Sisa = 0;
$SubTotal = 0;
$GrandTotal = 0;

if ($totalRows_RC>0 AND $row_RA['Status']<>"Batal"){
if ($row_RA['Bayar']>=$row_RB['SubTotal']){
$Sisa = 0;
}else{
$Sisa = $row_RB['SubTotal']-$row_RA['Bayar'];
}
$SubTotal = $row_RB['SubTotal'];
$GrandTotal = ($row_RB['SubTotal'] * (1 - $row_RA['Diskon']/100)) - $row_RA['Potongan'];
}      
	  
$updateSQLM = "UPDATE `persewaan lapangan - master` SET `Sisa`=$Sisa, `Sub Total`=$SubTotal, `Grand Total`=$GrandTotal WHERE ID=".$_GET['id'];                                                                        

mysql_query($updateSQLM, $Konek) or die(mysql_error());	
//
if ($_GET['go']){
echo "<meta http-equiv=refresh content=0;URL=".$_GET['go'].">";
}else{
echo "<meta http-equiv=refresh content=0;URL=persewaan_lapangan_2D_detaillist.php?showmaster=persewaan_lapangan_2D_master&ID=".$_GET['id'].">";
}
?>
<?php
mysql_free_result($RA);
mysql_free_result($RB);
mysql_free_result($RC);
mysql_free_result($RX);
?>

<?php include('Connections/Konek.php'); ?>
<?php
include ("function.php");

mysql_select_db($database_Konek, $Konek);
$query_RX = "SELECT * FROM `persewaan lapangan - master`";
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
$query_RA = "SELECT * FROM `persewaan lapangan - master` WHERE ID=".$_GET['id'];
$RA = mysql_query($query_RA, $Konek) or die(mysql_error());
$row_RA = mysql_fetch_assoc($RA);
$totalRows_RA = mysql_num_rows($RA);

mysql_select_db($database_Konek, $Konek);
$query_RB = "SELECT * FROM `persewaan lapangan - detail` WHERE `IDM`=".$row_RA['ID'];
$RB = mysql_query($query_RB, $Konek) or die(mysql_error());
$row_RB = mysql_fetch_assoc($RB);
$totalRows_RB = mysql_num_rows($RB);

//      
 do {
 
		mysql_select_db($database_Konek, $Konek);
		$query_RC = "SELECT * FROM `daftar lapangan` WHERE Kode='".$row_RB['Kode']."'";
		$RC = mysql_query($query_RC, $Konek) or die(mysql_error());
		$row_RC = mysql_fetch_assoc($RC);
		$totalRows_RC = mysql_num_rows($RC);		
 
		if (strtotime($row_RB['JamSewa'])<=strtotime("18:00:00")){		
        
		// Harga Malam Member
		if ($row_RA['Kode']<>""){
		$HargaSewa = $row_RC['HargaSewa3'];
		}else{
		// Harga Malam Non Member
		$HargaSewa = $row_RC['HargaSewa4'];
		}	
        
		
		}else{

		// Harga Pagi Member
		if ($row_RA['Kode']<>""){
		$HargaSewa = $row_RC['HargaSewa1'];
		}else{
		// Harga Pagi Non Member
		$HargaSewa = $row_RC['HargaSewa2'];	
		}
		
		}
		
		$updateSQLM = "UPDATE `persewaan lapangan - detail` SET `HargaSewa`=$HargaSewa WHERE ID=".$row_RB['ID'];                                                                        
        mysql_query($updateSQLM, $Konek) or die(mysql_error());	
		
	    
   
		
} while ($row_RB = mysql_fetch_assoc($RB)); 		
//
 echo "<meta http-equiv=refresh content=0;URL=AppHitung.php?id=".$_GET['id']."&go=".$_GET['go'].">";
?>
<?php
mysql_free_result($RA);
mysql_free_result($RB);
mysql_free_result($RC);
mysql_free_result($RX);
?>

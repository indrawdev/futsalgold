<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "persewaan_lapangan_2D_masterinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "persewaan_lapangan_2D_detailgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "header.php" ?>

<? if (CurrentUserLevel()==-1){ ?>

<?php require_once('Connections/Konek.php'); ?>
<?php include "function.php" ?>
<?=FBR(2);?>
<link rel="stylesheet" href="system.css" type="text/css" media="screen" />

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

$Status = "";

if ($_POST['Persewaan']) {
		
mysql_select_db($database_Konek, $Konek); 
$query_RA = "TRUNCATE TABLE `persewaan lapangan - master`";
mysql_query($query_RA, $Konek) or die(mysql_error());

$query_DA = "TRUNCATE TABLE `persewaan lapangan - detail`";
mysql_query($query_DA, $Konek) or die(mysql_error());							
	
$Status = "Transaksi persewaan sukses terhapus";	
}

if ($_POST['Penjualan']) {
		
mysql_select_db($database_Konek, $Konek); 
$query_RB = "TRUNCATE TABLE `penjualan - master`";
mysql_query($query_RB, $Konek) or die(mysql_error());

$query_DB = "TRUNCATE TABLE `penjualan - detail`";
mysql_query($query_DB, $Konek) or die(mysql_error());							
	
$Status = "Transaksi penjualan sukses terhapus";	
}

if ($_POST['Pembelian']) {
		
mysql_select_db($database_Konek, $Konek); 
$query_RC = "TRUNCATE TABLE `pembelian - master`";
mysql_query($query_RC, $Konek) or die(mysql_error());

$query_DB = "TRUNCATE TABLE `pembelian - detail`";
mysql_query($query_DB, $Konek) or die(mysql_error());							
	
$Status = "Transaksi pembelian sukses terhapus";	
}


?>
    
  </p>
  <div align="center"><?=$Status;?></div>
<form action="" method="POST" name="Form1">
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="ins">
  <tr>
    <th class="tleftright" colspan="2" align="center">RESET TRANSAKSI</th>
  </tr>
  <tr>
    <td width="251" align="right">Persewaan:</td>
    <td width="264"><input type="submit" name="Persewaan" id="Persewaan" value="Persewaan" class="tombol" onclick="return confirm('Anda yakin hapus semua transaksi persewaan? \nData terhapus tidak dapat dikembalikan. \nBackup data Anda terlebih dahulu. \nKlik Cancel untuk membatalkan penghapusan. \nKlik Oke untuk menghapus transaksi.')" /></td>
  </tr> 
   <tr>
    <td width="251" align="right">Penjualan:</td>
    <td width="264"><input type="submit" name="Penjualan" id="Penjualan" value="Penjualan" class="tombol" onclick="return confirm('Anda yakin hapus semua transaksi penjualan? \nData terhapus tidak dapat dikembalikan. \nBackup data Anda terlebih dahulu. \nKlik Cancel untuk membatalkan penghapusan. \nKlik Oke untuk menghapus transaksi.')" /></td>
  </tr> 
   <tr>
    <td width="251" align="right">Pembelian:</td>
    <td width="264"><input type="submit" name="Pembelian" id="Pembelian" value="Pembelian" class="tombol" onclick="return confirm('Anda yakin hapus semua transaksi pembelian? \nData terhapus tidak dapat dikembalikan. \nBackup data Anda terlebih dahulu. \nKlik Cancel untuk membatalkan penghapusan. \nKlik Oke untuk menghapus transaksi.')" /></td>
  </tr> 
  <tr>
    <th class="bleftright" colspan="2" align="center">&nbsp;</th>
  </tr>
</table>
</form>
<? } ?>
<?php include "footer.php" ?>

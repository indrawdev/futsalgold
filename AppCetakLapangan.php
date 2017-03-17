<?php include('Connections/Konek.php'); ?>
<?php
include ("function.php");

mysql_select_db($database_Konek, $Konek);
$query_RA = "SELECT * FROM `persewaan lapangan - master` WHERE ID = ".$_GET['id'];
$RA = mysql_query($query_RA, $Konek) or die(mysql_error());
$row_RA = mysql_fetch_assoc($RA);
$totalRows_RA = mysql_num_rows($RA);

mysql_select_db($database_Konek, $Konek);
$query_RB = "SELECT * FROM profile";
$RB = mysql_query($query_RB, $Konek) or die(mysql_error());
$row_RB = mysql_fetch_assoc($RB);
$totalRows_RB = mysql_num_rows($RB);

mysql_select_db($database_Konek, $Konek);
$query_RC = "SELECT * FROM `persewaan lapangan - detail` WHERE IDM = ".$_GET['id'];
$RC = mysql_query($query_RC, $Konek) or die(mysql_error());
$row_RC = mysql_fetch_assoc($RC);
$totalRows_RC = mysql_num_rows($RC);
?>
<?php
$data .= "$row_RB[NamaToko]
$row_RB[Alamat]
$row_RB[Kota] - $row_RB[Telepon]
======================
No. Struk : ".$row_RA['No Faktur']."
".FTgl($row_RA['Tgl'])."
";

do {
$data .= "======================
".$row_RC['NamaLapangan']."
Tgl Sewa.: ".$row_RC['TglSewa']." Buah
Jam Sewa: ".$row_RC['JamSewa']."
Harga Sewa: ".FStruk($row_RC['HargaSewa'])."
";

} while ($row_RC = mysql_fetch_assoc($RC));

$data .= "======================
Sub Total: ".FStruk($row_RA['Sub Total'])."
Disk.%: $row_RA[Diskon]
Potongan: $row_RA[Potongan]
Grand Total: ".FStruk($row_RA['Grand Total'])."
======================
TERIMAKASIH ATAS
KUNJUNGAN ANDA";
?>
<?php
//$data = "This is the data";

// Open the file and erase the contents if any

$fp = fopen("log.dat", "w");

// Write the data to the file

fwrite($fp, $data);



// Close the file

fclose($fp);

shell_exec('cetak.exe');

FGO(FUrlRef());

?>
<?php
mysql_free_result($RA);

mysql_free_result($RB);

mysql_free_result($RC);
?>

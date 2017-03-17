<?php require_once('Connections/Konek.php'); ?>
<?php
include("function.php");

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
$query_RX = "SELECT * FROM `profile`";
$RX = mysql_query($query_RX, $Konek) or die(mysql_error());
$row_RX = mysql_fetch_assoc($RX);
$totalRows_RX = mysql_num_rows($RX);

mysql_select_db($database_Konek, $Konek);
$query_RA = "SELECT Kode, `Nama Barang`, Isi, Satuan, Berat, `Harga Pokok`, `Harga Jual`, Jumlah, `Jumlah Total`, Supplier FROM `daftar produk` ORDER BY Kode ASC";
$RA = mysql_query($query_RA, $Konek) or die(mysql_error());
$row_RA = mysql_fetch_assoc($RA);
$totalRows_RA = mysql_num_rows($RA);

mysql_select_db($database_Konek, $Konek);
$query_RB = "SELECT * FROM `lapstok`";
$RB = mysql_query($query_RB, $Konek) or die(mysql_error());
$row_RB = mysql_fetch_assoc($RB);
$totalRows_RB = mysql_num_rows($RB);
?>
<style type="text/css">
<!--
table.morpion
{
	border: dashed 1px #444444;
	color: #000;
	text-align: right;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}

table.morpion td
{
    font-size:    9pt;
    font-weight:  bold;
    border:       solid 1px #000000;
    padding:      8px;
    text-align:   center;
    
}

table.morpion td.j1 {
	color: #000;
}
table.morpion td.j2 { color: #A00; }
.tabel2 {
	border: thin solid #CCC;
}
.table2 td {


    font-size:    9pt;
    font-weight:  bold;
    border:       solid 1px #000000;
    padding:      1px;
    text-align:   center;
    width:        25px;
	
}

-->
</style>



<? $Dari = $row_RB['TglDari'];?>
<? $Ke = $row_RB['TglKe'];?> 

 
 <? $i=1;?>
   
    <table border="0" align="center" cellpadding="8" class="morpion" >
      <tr>
        <td colspan="8" class="j1"><span class="j1">STOK BARANG KANTIN<br />
Periode:
    <?=date("d-m-Y", strtotime($Dari));?> - <?=date("d-m-Y", strtotime($Ke));?>
    </span></td>
      </tr>
      <tr>
        <td colspan="8" class="j1"><? echo $row_RX['NamaRX'].", ". $row_RX['Alamat'].", ".$row_RX['Kota'].", ". $row_RX['Telepon'].", E-mail : ". $row_RX['Email'];?></td>
      </tr>
      <tr>
        <td class="j1">No</td>
        <td class="j1">Kode</td>
        <td class="j1">Nama Barang</td>
        <td class="j1">Stok Awal</td>
        <td class="j1">Satuan</td>        
        <td class="j1">Pembelian</td>
        <td class="j1">Penjualan</td>        
        <td class="j1">Sisa Stok</td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo $row_RA['Kode']; ?></td>
          <td><?php echo $row_RA['Nama Barang']; ?></td>
          <td><?php echo $row_RA['Jumlah']; ?></td>
          <td><?php echo $row_RA['Satuan']; ?></td>          
          <td>
<?         
$query_Beli = 
"SELECT
   `pembelian - master`.`ID`
    , `pembelian - master`.`Tgl`
    , `pembelian - detail`.`IDM`
    , `pembelian - detail`.`Jumlah` AS `SJumBeli`
    , `pembelian - detail`.`Kode`
FROM
    `pembelian - master`
    INNER JOIN `pembelian - detail` 
        ON (`pembelian - master`.`ID` = `pembelian - detail`.`IDM`)
WHERE (`pembelian - master`.`Tgl` BETWEEN '".$Dari."' AND '".$Ke."' AND `pembelian - detail`.`Kode`='".$row_RA['Kode']."')
GROUP BY `pembelian - detail`.`IDM`, `pembelian - detail`.`Kode`";
$Beli = mysql_query($query_Beli, $Konek) or die(mysql_error());
$row_Beli = mysql_fetch_assoc($Beli);
$SBeli=0;
?>          
  <?php do { ?> 
   <?
   $SBeli = $SBeli + $row_Beli['SJumBeli'];   
   ?> 
    <?php } while ($row_Beli = mysql_fetch_assoc($Beli)); ?>
    
	<?=$SBeli;?>      
          
          </td>
          <td>
          
          <?         
$query_Jual = 
"SELECT
    `penjualan - master`.`ID`
    , `penjualan - master`.`Tgl`
    , `penjualan - detail`.`IDM`
    , `penjualan - detail`.`Jumlah` AS `SJumJual`
    , `penjualan - detail`.`Kode`
FROM
    `penjualan - master`
    INNER JOIN `penjualan - detail` 
        ON (`penjualan - master`.`ID` = `penjualan - detail`.`IDM`)
WHERE (`penjualan - master`.`Tgl` BETWEEN '".$Dari."' AND '".$Ke."' AND `penjualan - detail`.`Kode`='".$row_RA['Kode']."')
GROUP BY `penjualan - detail`.`IDM`";
$Jual = mysql_query($query_Jual, $Konek) or die(mysql_error());
$row_Jual = mysql_fetch_assoc($Jual);
$SJual=0;
?>          
  <?php do { ?> 
   <?
   $SJual = $SJual + $row_Jual['SJumJual'];   
   ?> 
    <?php } while ($row_Jual = mysql_fetch_assoc($Jual)); ?>
    
	<?=$SJual;?>      
 
          
          
          </td> 
         
          <td><?=(($row_RA['Jumlah']+$SBeli+$SMasuk)-($SJual+$SKeluar));?></td>
        </tr>
        <?php } while ($row_RA = mysql_fetch_assoc($RA)); ?>
    </table>
<p>&nbsp;</p>


      


<?php
mysql_free_result($RA);
?>

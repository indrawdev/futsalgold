<?php require_once('Connections/POS.php'); ?>
<?php
include("function.php");
?>
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
?>
<?
function Tgl2db($Tgl){
$et =explode("/",trim($Tgl));
return ($et[2]."-".$et[1]."-".$et[0]);	
}

?>


<? $Dari = Tgl2db($_POST['Dari']);?>
<? $Ke = Tgl2db($_POST['Ke']);?>
<?php
mysql_select_db($database_POS, $POS);
$query_Toko = "SELECT * FROM `profile`";
$Toko = mysql_query($query_Toko, $POS) or die(mysql_error());
$row_Toko = mysql_fetch_assoc($Toko);
$totalRows_Toko = mysql_num_rows($Toko);

mysql_select_db($database_POS, $POS);
$query_TP = "SELECT * FROM `penjualan - master` WHERE `Tgl` BETWEEN '".$Dari."' AND '".$Ke."'";
$TP = mysql_query($query_TP, $POS) or die(mysql_error());
$row_TP = mysql_fetch_assoc($TP);
$totalRows_TP = mysql_num_rows($TP);

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

<? if ($totalRows_TP>0){ ?>

<table width="900" border="0" align="center" class="morpion">
  <tr>
    <td colspan="10" align="center"><span class="j1">DETAIL LAPORAN HARIAN PENJUALAN <br />
Periode:
    <?=$_POST['Dari'];?>
-
<?=$_POST['Ke'];?>
    </span></td>
  </tr>
  <tr>
    <td colspan="10" align="center"><? echo $row_Toko['NamaToko'].", ". $row_Toko['Alamat'].", ".$row_Toko['Kota'].", ". $row_Toko['Telepon'].", E-mail : ". $row_Toko['Email'];?></td>
  </tr>
   
  
   <?php do { ?>    
  
    <tr>
    <td width="89" bgcolor="#FFFFFF" class="j1">Faktur</td>
    <td width="95" bgcolor="#FFFFFF" class="j1">Total HP</td>
    <td width="91" bgcolor="#FFFFFF" class="j1">Disk.%</td>
    <td width="99" bgcolor="#FFFFFF" class="j1">( Total HJ * Disk )</td>
    <td colspan="4" bgcolor="#FFFFFF" class="j1">&nbsp;</td>
    <td width="60" bgcolor="#FFFFFF" class="j1">Grand Total HJ</td>
    <td width="36" bgcolor="#FFFFFF" class="j1">Tgl</td>
  </tr>
  <tr>
    <td><?php echo $row_TP['Faktur']; ?></td>
    <td><?php echo FMoney($row_TP['Total HP']); ?></td>
    <td><?php echo $row_TP['Diskon']; ?></td>
    <td><?php 
	$HJD = $HJD + $row_TP['Total HJ']*(1-$row_TP['Diskon']/100);
	echo FMoney($row_TP['Total HJ']*(1-$row_TP['Diskon']/100)); 
	?></td>
    <td colspan="4">&nbsp;</td>
    <td><?php echo FMoney($row_TP['Grand Total']); ?></td>
    <td><?php echo str_replace("-","/",FDate($row_TP['Tgl'])); ?></td>
  </tr>
  <tr>
    <td colspan="10">
    
 <?        
//mysql_select_db($database_POS, $POS);
$query_BT = "SELECT * FROM `penjualan - detail` Where IDM=".$row_TP['ID'];
$BT = mysql_query($query_BT, $POS) or die(mysql_error());
$row_BT = mysql_fetch_assoc($BT);
//$totalRows_BT = mysql_num_rows($BT);        
?>   
    
    <table width="900" border="1" align="center">
      <tr class="morpion">
        <td class="j1">Kode</td>
        <td class="j1">Nama Barang</td>
        <td class="j1">Jumlah</td>
        <td class="j1">Satuan</td>
        <td class="j1" align="right">@Harga Pokok</td>
        <td class="j1" align="right">@Harga Jual</td>
        <td class="j1">Total Jumlah</td>
        <td class="j1">Disk.%</td>
        <td align="center" class="j1">Total HP</td>
        <td class="j1"align="right">Total HJ</td>
        </tr>
      
       <? $TotalHP=0; ?>
   <? $TotalHJ=0; ?>
   <? $Berat=0; ?>
   <? $HPP=0; ?>
   <? $HJ=0; ?>       
  
  <?php do { ?>
      
      <tr class="morpion">
        <td><?php echo $row_BT['Kode']; ?></td>
        <td align="left"><?php echo $row_BT['Nama Barang']; ?></td>
        <td><?php echo $row_BT['Jumlah']; ?></td>
        <td><?php echo $row_BT['Satuan']; ?></td>
        <td align="right"><?php echo FMoney($row_BT['Harga Pokok']); ?></td>
        <td align="right"><?php echo FMoney($row_BT['Harga Jual']); ?></td>
        <td><?php echo FMoney($row_BT['Jumlah']*abs($row_BT['Isi'])); ?></td>
        <td><?php echo $row_BT['Diskon']; ?></td>
        <td><?php	  		 	
	  		  
             			  
			  $SubTotalHP = ($row_BT['Jumlah']*abs($row_BT['Harga Pokok']));
			  
			  
			  
			  
			  $TotalHP = $TotalHP + $SubTotalHP;
			  $GTotalHP = $GTotalHP + $SubTotalHP; 
			  echo FMoney($SubTotalHP); 
			  ?></td>
        <td align="right"><?php	  		 	
	  		  $HPP = $HPP + $row_BT['Harga Pokok'];
			  $HJ = $HJ + $RHJ;	
              $Berat = $Berat + $row_BT['Berat'];			  
			  $SubTotalHJ = (($row_BT['Jumlah']*abs($row_BT['Harga Jual']))*(1-$row_BT['Diskon']/100));
			  
			  
			  
			  
			  $TotalHJ = $TotalHJ + $SubTotalHJ;
			  $GTotalHJ = $GTotalHJ + $SubTotalHJ;  
			  echo FMoney($SubTotalHJ); 
			  ?></td>
        </tr>
        <?php } while ($row_BT = mysql_fetch_assoc($BT)); ?>
      <tr>
        <td class="j1" colspan="8" align="center">Sub Total</td>
        <td><? echo FMoney($TotalHP); ?></td>
        <td><? echo FMoney($TotalHJ); ?></td>
        </tr>
    </table></td>
  </tr>
  
  
  
  <tr>
    <td colspan="5" bgcolor="#FFFFFF" class="j1">&nbsp;</td>
    <td width="90" bgcolor="#FFFFFF" class="j1"><span class="j1">Kode Kasir</span></td>
    <td colspan="4" bgcolor="#FFFFFF"><span class="j1"><?php echo $row_TP['Kode Kasir']; ?></span></td>
    </tr>
  <tr>
    <td colspan="10" align="center"><hr /></td>
  </tr>
   <? $GT = $GT + $row_TP['Grand Total']; ?>
   <?php } while ($row_TP = mysql_fetch_assoc($TP)); ?>
  <tr>
    <td colspan="7" rowspan="4" align="center">&nbsp;</td>
    <td width="88" align="right" class="j1"><span class="j1">Sum ( Total HP )</span></td>
    <td align="right"><span class="j1">
      <?=FMoney($GTotalHP);?>
    </span></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="j1"><span class="j1">Sum ( Total HJ * Disk )</span></td>
    <td align="right"><span class="j1">
      <?=FMoney($HJD);?>
    </span></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="j1"><span class="j1">Sum ( Grand Total HJ )</span></td>
    <td align="right"><span class="j1">
      <?	 
	  echo FMoney($GT);?>
    </span></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="j1">LABA</td>
    <td align="right"><span class="j1">
      <?=FMoney($HJD-$GTotalHP);?>
    </span></td>
    <td align="center">&nbsp;</td>
  </tr>
  
  
</table>

<? 
mysql_free_result($BT);
?>

<? } ?>

</page>

<?php
mysql_free_result($TP);

?>

<?php

// Tgl
// No Faktur
// Total HJ
// Diskon
// Grand Total
// Dibayar
// SisaDibayar
// Kode Pelanggan
// Kode Kasir
// Hitung
// CetakStruk

?>
<?php if ($penjualan_2D_master->Visible) { ?>
<table cellspacing="0" id="t_penjualan_2D_master" class="ewGrid"><tr><td>
<table id="tbl_penjualan_2D_mastermaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($penjualan_2D_master->Tgl->Visible) { // Tgl ?>
		<tr id="r_Tgl">
			<td><?php echo $penjualan_2D_master->Tgl->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->Tgl->CellAttributes() ?>><span id="el_penjualan_2D_master_Tgl" class="control-group">
<span<?php echo $penjualan_2D_master->Tgl->ViewAttributes() ?>>
<?php echo $penjualan_2D_master->Tgl->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->No_Faktur->Visible) { // No Faktur ?>
		<tr id="r_No_Faktur">
			<td><?php echo $penjualan_2D_master->No_Faktur->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->No_Faktur->CellAttributes() ?>><span id="el_penjualan_2D_master_No_Faktur" class="control-group">
<span<?php echo $penjualan_2D_master->No_Faktur->ViewAttributes() ?>>
<?php echo $penjualan_2D_master->No_Faktur->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Total_HJ->Visible) { // Total HJ ?>
		<tr id="r_Total_HJ">
			<td><?php echo $penjualan_2D_master->Total_HJ->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->Total_HJ->CellAttributes() ?>><span id="el_penjualan_2D_master_Total_HJ" class="control-group">
<span<?php echo $penjualan_2D_master->Total_HJ->ViewAttributes() ?>>
<?php echo $penjualan_2D_master->Total_HJ->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Diskon->Visible) { // Diskon ?>
		<tr id="r_Diskon">
			<td><?php echo $penjualan_2D_master->Diskon->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->Diskon->CellAttributes() ?>><span id="el_penjualan_2D_master_Diskon" class="control-group">
<span<?php echo $penjualan_2D_master->Diskon->ViewAttributes() ?>>
<?php echo $penjualan_2D_master->Diskon->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Grand_Total->Visible) { // Grand Total ?>
		<tr id="r_Grand_Total">
			<td><?php echo $penjualan_2D_master->Grand_Total->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->Grand_Total->CellAttributes() ?>><span id="el_penjualan_2D_master_Grand_Total" class="control-group">
<span<?php echo $penjualan_2D_master->Grand_Total->ViewAttributes() ?>>
<?php echo $penjualan_2D_master->Grand_Total->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Dibayar->Visible) { // Dibayar ?>
		<tr id="r_Dibayar">
			<td><?php echo $penjualan_2D_master->Dibayar->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->Dibayar->CellAttributes() ?>><span id="el_penjualan_2D_master_Dibayar" class="control-group">
<span<?php echo $penjualan_2D_master->Dibayar->ViewAttributes() ?>>
<?php echo $penjualan_2D_master->Dibayar->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->SisaDibayar->Visible) { // SisaDibayar ?>
		<tr id="r_SisaDibayar">
			<td><?php echo $penjualan_2D_master->SisaDibayar->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->SisaDibayar->CellAttributes() ?>><span id="el_penjualan_2D_master_SisaDibayar" class="control-group">
<span<?php echo $penjualan_2D_master->SisaDibayar->ViewAttributes() ?>>
<?php echo $penjualan_2D_master->SisaDibayar->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Kode_Pelanggan->Visible) { // Kode Pelanggan ?>
		<tr id="r_Kode_Pelanggan">
			<td><?php echo $penjualan_2D_master->Kode_Pelanggan->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->Kode_Pelanggan->CellAttributes() ?>><span id="el_penjualan_2D_master_Kode_Pelanggan" class="control-group">
<span<?php echo $penjualan_2D_master->Kode_Pelanggan->ViewAttributes() ?>>
<?php echo $penjualan_2D_master->Kode_Pelanggan->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Kode_Kasir->Visible) { // Kode Kasir ?>
		<tr id="r_Kode_Kasir">
			<td><?php echo $penjualan_2D_master->Kode_Kasir->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->Kode_Kasir->CellAttributes() ?>><span id="el_penjualan_2D_master_Kode_Kasir" class="control-group">
<span<?php echo $penjualan_2D_master->Kode_Kasir->ViewAttributes() ?>>
<?php echo $penjualan_2D_master->Kode_Kasir->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Hitung->Visible) { // Hitung ?>
		<tr id="r_Hitung">
			<td><?php echo $penjualan_2D_master->Hitung->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->Hitung->CellAttributes() ?>><span id="el_penjualan_2D_master_Hitung" class="control-group">
<span<?php echo $penjualan_2D_master->Hitung->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($penjualan_2D_master->Hitung->ListViewValue()) && $penjualan_2D_master->Hitung->LinkAttributes() <> "") { ?>
<a<?php echo $penjualan_2D_master->Hitung->LinkAttributes() ?>><?php echo $penjualan_2D_master->Hitung->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $penjualan_2D_master->Hitung->ListViewValue() ?>
<?php } ?>
</span>
</span></td>
		</tr>
<?php } ?>
<?php if ($penjualan_2D_master->CetakStruk->Visible) { // CetakStruk ?>
		<tr id="r_CetakStruk">
			<td><?php echo $penjualan_2D_master->CetakStruk->FldCaption() ?></td>
			<td<?php echo $penjualan_2D_master->CetakStruk->CellAttributes() ?>><span id="el_penjualan_2D_master_CetakStruk" class="control-group">
<span<?php echo $penjualan_2D_master->CetakStruk->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($penjualan_2D_master->CetakStruk->ListViewValue()) && $penjualan_2D_master->CetakStruk->LinkAttributes() <> "") { ?>
<a<?php echo $penjualan_2D_master->CetakStruk->LinkAttributes() ?>><?php echo $penjualan_2D_master->CetakStruk->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $penjualan_2D_master->CetakStruk->ListViewValue() ?>
<?php } ?>
</span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>

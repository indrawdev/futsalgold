<?php

// Tgl
// No Faktur
// Grand Total
// Dibayar
// SisaDibayar
// Kode Kasir
// Kode Supplier
// Hitung

?>
<?php if ($pembelian_2D_master->Visible) { ?>
<table cellspacing="0" id="t_pembelian_2D_master" class="ewGrid"><tr><td>
<table id="tbl_pembelian_2D_mastermaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($pembelian_2D_master->Tgl->Visible) { // Tgl ?>
		<tr id="r_Tgl">
			<td><?php echo $pembelian_2D_master->Tgl->FldCaption() ?></td>
			<td<?php echo $pembelian_2D_master->Tgl->CellAttributes() ?>><span id="el_pembelian_2D_master_Tgl" class="control-group">
<span<?php echo $pembelian_2D_master->Tgl->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Tgl->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($pembelian_2D_master->No_Faktur->Visible) { // No Faktur ?>
		<tr id="r_No_Faktur">
			<td><?php echo $pembelian_2D_master->No_Faktur->FldCaption() ?></td>
			<td<?php echo $pembelian_2D_master->No_Faktur->CellAttributes() ?>><span id="el_pembelian_2D_master_No_Faktur" class="control-group">
<span<?php echo $pembelian_2D_master->No_Faktur->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->No_Faktur->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($pembelian_2D_master->Grand_Total->Visible) { // Grand Total ?>
		<tr id="r_Grand_Total">
			<td><?php echo $pembelian_2D_master->Grand_Total->FldCaption() ?></td>
			<td<?php echo $pembelian_2D_master->Grand_Total->CellAttributes() ?>><span id="el_pembelian_2D_master_Grand_Total" class="control-group">
<span<?php echo $pembelian_2D_master->Grand_Total->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Grand_Total->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($pembelian_2D_master->Dibayar->Visible) { // Dibayar ?>
		<tr id="r_Dibayar">
			<td><?php echo $pembelian_2D_master->Dibayar->FldCaption() ?></td>
			<td<?php echo $pembelian_2D_master->Dibayar->CellAttributes() ?>><span id="el_pembelian_2D_master_Dibayar" class="control-group">
<span<?php echo $pembelian_2D_master->Dibayar->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Dibayar->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($pembelian_2D_master->SisaDibayar->Visible) { // SisaDibayar ?>
		<tr id="r_SisaDibayar">
			<td><?php echo $pembelian_2D_master->SisaDibayar->FldCaption() ?></td>
			<td<?php echo $pembelian_2D_master->SisaDibayar->CellAttributes() ?>><span id="el_pembelian_2D_master_SisaDibayar" class="control-group">
<span<?php echo $pembelian_2D_master->SisaDibayar->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->SisaDibayar->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($pembelian_2D_master->Kode_Kasir->Visible) { // Kode Kasir ?>
		<tr id="r_Kode_Kasir">
			<td><?php echo $pembelian_2D_master->Kode_Kasir->FldCaption() ?></td>
			<td<?php echo $pembelian_2D_master->Kode_Kasir->CellAttributes() ?>><span id="el_pembelian_2D_master_Kode_Kasir" class="control-group">
<span<?php echo $pembelian_2D_master->Kode_Kasir->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Kode_Kasir->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($pembelian_2D_master->Kode_Supplier->Visible) { // Kode Supplier ?>
		<tr id="r_Kode_Supplier">
			<td><?php echo $pembelian_2D_master->Kode_Supplier->FldCaption() ?></td>
			<td<?php echo $pembelian_2D_master->Kode_Supplier->CellAttributes() ?>><span id="el_pembelian_2D_master_Kode_Supplier" class="control-group">
<span<?php echo $pembelian_2D_master->Kode_Supplier->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Kode_Supplier->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($pembelian_2D_master->Hitung->Visible) { // Hitung ?>
		<tr id="r_Hitung">
			<td><?php echo $pembelian_2D_master->Hitung->FldCaption() ?></td>
			<td<?php echo $pembelian_2D_master->Hitung->CellAttributes() ?>><span id="el_pembelian_2D_master_Hitung" class="control-group">
<span<?php echo $pembelian_2D_master->Hitung->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($pembelian_2D_master->Hitung->ListViewValue()) && $pembelian_2D_master->Hitung->LinkAttributes() <> "") { ?>
<a<?php echo $pembelian_2D_master->Hitung->LinkAttributes() ?>><?php echo $pembelian_2D_master->Hitung->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $pembelian_2D_master->Hitung->ListViewValue() ?>
<?php } ?>
</span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>

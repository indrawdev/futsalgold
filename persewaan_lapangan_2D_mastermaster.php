<?php

// No Faktur
// Tgl
// Kode
// Nama
// Bayar
// Sisa
// Sub Total
// Diskon
// Potongan
// Grand Total
// Kode Kasir
// Status
// Hitung
// Cetak Struk

?>
<?php if ($persewaan_lapangan_2D_master->Visible) { ?>
<table cellspacing="0" id="t_persewaan_lapangan_2D_master" class="ewGrid"><tr><td>
<table id="tbl_persewaan_lapangan_2D_mastermaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($persewaan_lapangan_2D_master->No_Faktur->Visible) { // No Faktur ?>
		<tr id="r_No_Faktur">
			<td><?php echo $persewaan_lapangan_2D_master->No_Faktur->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->No_Faktur->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_No_Faktur" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->No_Faktur->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->No_Faktur->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Tgl->Visible) { // Tgl ?>
		<tr id="r_Tgl">
			<td><?php echo $persewaan_lapangan_2D_master->Tgl->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Tgl->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Tgl" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Tgl->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Tgl->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Kode->Visible) { // Kode ?>
		<tr id="r_Kode">
			<td><?php echo $persewaan_lapangan_2D_master->Kode->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Kode->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Kode" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Kode->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Kode->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Nama->Visible) { // Nama ?>
		<tr id="r_Nama">
			<td><?php echo $persewaan_lapangan_2D_master->Nama->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Nama->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Nama" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Nama->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Nama->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Bayar->Visible) { // Bayar ?>
		<tr id="r_Bayar">
			<td><?php echo $persewaan_lapangan_2D_master->Bayar->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Bayar->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Bayar" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Bayar->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Bayar->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Sisa->Visible) { // Sisa ?>
		<tr id="r_Sisa">
			<td><?php echo $persewaan_lapangan_2D_master->Sisa->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Sisa->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Sisa" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Sisa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Sisa->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Sub_Total->Visible) { // Sub Total ?>
		<tr id="r_Sub_Total">
			<td><?php echo $persewaan_lapangan_2D_master->Sub_Total->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Sub_Total->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Sub_Total" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Sub_Total->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Sub_Total->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Diskon->Visible) { // Diskon ?>
		<tr id="r_Diskon">
			<td><?php echo $persewaan_lapangan_2D_master->Diskon->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Diskon->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Diskon" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Diskon->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Diskon->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Potongan->Visible) { // Potongan ?>
		<tr id="r_Potongan">
			<td><?php echo $persewaan_lapangan_2D_master->Potongan->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Potongan->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Potongan" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Potongan->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Potongan->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Grand_Total->Visible) { // Grand Total ?>
		<tr id="r_Grand_Total">
			<td><?php echo $persewaan_lapangan_2D_master->Grand_Total->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Grand_Total->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Grand_Total" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Grand_Total->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Grand_Total->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Kode_Kasir->Visible) { // Kode Kasir ?>
		<tr id="r_Kode_Kasir">
			<td><?php echo $persewaan_lapangan_2D_master->Kode_Kasir->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Kode_Kasir->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Kode_Kasir" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Kode_Kasir->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Kode_Kasir->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Status->Visible) { // Status ?>
		<tr id="r_Status">
			<td><?php echo $persewaan_lapangan_2D_master->Status->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Status->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Status" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Status->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Status->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Hitung->Visible) { // Hitung ?>
		<tr id="r_Hitung">
			<td><?php echo $persewaan_lapangan_2D_master->Hitung->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Hitung->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Hitung" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Hitung->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($persewaan_lapangan_2D_master->Hitung->ListViewValue()) && $persewaan_lapangan_2D_master->Hitung->LinkAttributes() <> "") { ?>
<a<?php echo $persewaan_lapangan_2D_master->Hitung->LinkAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Hitung->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $persewaan_lapangan_2D_master->Hitung->ListViewValue() ?>
<?php } ?>
</span>
</span></td>
		</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Cetak_Struk->Visible) { // Cetak Struk ?>
		<tr id="r_Cetak_Struk">
			<td><?php echo $persewaan_lapangan_2D_master->Cetak_Struk->FldCaption() ?></td>
			<td<?php echo $persewaan_lapangan_2D_master->Cetak_Struk->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Cetak_Struk" class="control-group">
<span<?php echo $persewaan_lapangan_2D_master->Cetak_Struk->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($persewaan_lapangan_2D_master->Cetak_Struk->ListViewValue()) && $persewaan_lapangan_2D_master->Cetak_Struk->LinkAttributes() <> "") { ?>
<a<?php echo $persewaan_lapangan_2D_master->Cetak_Struk->LinkAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Cetak_Struk->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $persewaan_lapangan_2D_master->Cetak_Struk->ListViewValue() ?>
<?php } ?>
</span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>

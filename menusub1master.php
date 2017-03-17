<?php

// Menu
// Link
// Parent
// No
// Akses

?>
<?php if ($menusub1->Visible) { ?>
<table cellspacing="0" id="t_menusub1" class="ewGrid"><tr><td>
<table id="tbl_menusub1master" class="table table-bordered table-striped">
	<tbody>
<?php if ($menusub1->_Menu->Visible) { // Menu ?>
		<tr id="r__Menu">
			<td><?php echo $menusub1->_Menu->FldCaption() ?></td>
			<td<?php echo $menusub1->_Menu->CellAttributes() ?>><span id="el_menusub1__Menu" class="control-group">
<span<?php echo $menusub1->_Menu->ViewAttributes() ?>>
<?php echo $menusub1->_Menu->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($menusub1->Link->Visible) { // Link ?>
		<tr id="r_Link">
			<td><?php echo $menusub1->Link->FldCaption() ?></td>
			<td<?php echo $menusub1->Link->CellAttributes() ?>><span id="el_menusub1_Link" class="control-group">
<span<?php echo $menusub1->Link->ViewAttributes() ?>>
<?php echo $menusub1->Link->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($menusub1->Parent->Visible) { // Parent ?>
		<tr id="r_Parent">
			<td><?php echo $menusub1->Parent->FldCaption() ?></td>
			<td<?php echo $menusub1->Parent->CellAttributes() ?>><span id="el_menusub1_Parent" class="control-group">
<span<?php echo $menusub1->Parent->ViewAttributes() ?>>
<?php echo $menusub1->Parent->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($menusub1->No->Visible) { // No ?>
		<tr id="r_No">
			<td><?php echo $menusub1->No->FldCaption() ?></td>
			<td<?php echo $menusub1->No->CellAttributes() ?>><span id="el_menusub1_No" class="control-group">
<span<?php echo $menusub1->No->ViewAttributes() ?>>
<?php echo $menusub1->No->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($menusub1->Akses->Visible) { // Akses ?>
		<tr id="r_Akses">
			<td><?php echo $menusub1->Akses->FldCaption() ?></td>
			<td<?php echo $menusub1->Akses->CellAttributes() ?>><span id="el_menusub1_Akses" class="control-group">
<span<?php echo $menusub1->Akses->ViewAttributes() ?>>
<?php echo $menusub1->Akses->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>

<?php

// MainMenu
// Link
// No
// Akses

?>
<?php if ($_menu->Visible) { ?>
<table cellspacing="0" id="t__menu" class="ewGrid"><tr><td>
<table id="tbl__menumaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($_menu->MainMenu->Visible) { // MainMenu ?>
		<tr id="r_MainMenu">
			<td><?php echo $_menu->MainMenu->FldCaption() ?></td>
			<td<?php echo $_menu->MainMenu->CellAttributes() ?>><span id="el__menu_MainMenu" class="control-group">
<span<?php echo $_menu->MainMenu->ViewAttributes() ?>>
<?php echo $_menu->MainMenu->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($_menu->Link->Visible) { // Link ?>
		<tr id="r_Link">
			<td><?php echo $_menu->Link->FldCaption() ?></td>
			<td<?php echo $_menu->Link->CellAttributes() ?>><span id="el__menu_Link" class="control-group">
<span<?php echo $_menu->Link->ViewAttributes() ?>>
<?php echo $_menu->Link->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($_menu->No->Visible) { // No ?>
		<tr id="r_No">
			<td><?php echo $_menu->No->FldCaption() ?></td>
			<td<?php echo $_menu->No->CellAttributes() ?>><span id="el__menu_No" class="control-group">
<span<?php echo $_menu->No->ViewAttributes() ?>>
<?php echo $_menu->No->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($_menu->Akses->Visible) { // Akses ?>
		<tr id="r_Akses">
			<td><?php echo $_menu->Akses->FldCaption() ?></td>
			<td<?php echo $_menu->Akses->CellAttributes() ?>><span id="el__menu_Akses" class="control-group">
<span<?php echo $_menu->Akses->ViewAttributes() ?>>
<?php echo $_menu->Akses->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>

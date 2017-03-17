<?php include_once "_2padmininfo.php" ?>
<?php

// Create page object
if (!isset($pembelian_2D_detail_grid)) $pembelian_2D_detail_grid = new cpembelian_2D_detail_grid();

// Page init
$pembelian_2D_detail_grid->Page_Init();

// Page main
$pembelian_2D_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pembelian_2D_detail_grid->Page_Render();
?>
<?php if ($pembelian_2D_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var pembelian_2D_detail_grid = new ew_Page("pembelian_2D_detail_grid");
pembelian_2D_detail_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = pembelian_2D_detail_grid.PageID; // For backward compatibility

// Form object
var fpembelian_2D_detailgrid = new ew_Form("fpembelian_2D_detailgrid");
fpembelian_2D_detailgrid.FormKeyCountName = '<?php echo $pembelian_2D_detail_grid->FormKeyCountName ?>';

// Validate form
fpembelian_2D_detailgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_Kode");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Kode->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Nama_Barang");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Nama_Barang->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Satuan");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Satuan->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Harga_Beli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Harga_Beli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Harga_Beli");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pembelian_2D_detail->Harga_Beli->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Jumlah->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pembelian_2D_detail->Jumlah->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fpembelian_2D_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Kode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nama_Barang", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Satuan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Harga_Beli", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Jumlah", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Total_HP", false)) return false;
	return true;
}

// Form_CustomValidate event
fpembelian_2D_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpembelian_2D_detailgrid.ValidateRequired = true;
<?php } else { ?>
fpembelian_2D_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpembelian_2D_detailgrid.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":true,"DisplayFields":["x_Kode","x_Nama_Barang","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php if ($pembelian_2D_detail->getCurrentMasterTable() == "" && $pembelian_2D_detail_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $pembelian_2D_detail_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($pembelian_2D_detail->CurrentAction == "gridadd") {
	if ($pembelian_2D_detail->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$pembelian_2D_detail_grid->TotalRecs = $pembelian_2D_detail->SelectRecordCount();
			$pembelian_2D_detail_grid->Recordset = $pembelian_2D_detail_grid->LoadRecordset($pembelian_2D_detail_grid->StartRec-1, $pembelian_2D_detail_grid->DisplayRecs);
		} else {
			if ($pembelian_2D_detail_grid->Recordset = $pembelian_2D_detail_grid->LoadRecordset())
				$pembelian_2D_detail_grid->TotalRecs = $pembelian_2D_detail_grid->Recordset->RecordCount();
		}
		$pembelian_2D_detail_grid->StartRec = 1;
		$pembelian_2D_detail_grid->DisplayRecs = $pembelian_2D_detail_grid->TotalRecs;
	} else {
		$pembelian_2D_detail->CurrentFilter = "0=1";
		$pembelian_2D_detail_grid->StartRec = 1;
		$pembelian_2D_detail_grid->DisplayRecs = $pembelian_2D_detail->GridAddRowCount;
	}
	$pembelian_2D_detail_grid->TotalRecs = $pembelian_2D_detail_grid->DisplayRecs;
	$pembelian_2D_detail_grid->StopRec = $pembelian_2D_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$pembelian_2D_detail_grid->TotalRecs = $pembelian_2D_detail->SelectRecordCount();
	} else {
		if ($pembelian_2D_detail_grid->Recordset = $pembelian_2D_detail_grid->LoadRecordset())
			$pembelian_2D_detail_grid->TotalRecs = $pembelian_2D_detail_grid->Recordset->RecordCount();
	}
	$pembelian_2D_detail_grid->StartRec = 1;
	$pembelian_2D_detail_grid->DisplayRecs = $pembelian_2D_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$pembelian_2D_detail_grid->Recordset = $pembelian_2D_detail_grid->LoadRecordset($pembelian_2D_detail_grid->StartRec-1, $pembelian_2D_detail_grid->DisplayRecs);
}
$pembelian_2D_detail_grid->RenderOtherOptions();
?>
<?php $pembelian_2D_detail_grid->ShowPageHeader(); ?>
<?php
$pembelian_2D_detail_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fpembelian_2D_detailgrid" class="ewForm form-horizontal">
<div id="gmp_pembelian_2D_detail" class="ewGridMiddlePanel">
<table id="tbl_pembelian_2D_detailgrid" class="ewTable ewTableSeparate">
<?php echo $pembelian_2D_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$pembelian_2D_detail_grid->RenderListOptions();

// Render list options (header, left)
$pembelian_2D_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($pembelian_2D_detail->Kode->Visible) { // Kode ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Kode) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Kode" class="pembelian_2D_detail_Kode"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Kode->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_pembelian_2D_detail_Kode" class="pembelian_2D_detail_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Nama_Barang->Visible) { // Nama Barang ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Nama_Barang) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Nama_Barang" class="pembelian_2D_detail_Nama_Barang"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Nama_Barang->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_pembelian_2D_detail_Nama_Barang" class="pembelian_2D_detail_Nama_Barang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Nama_Barang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Nama_Barang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Nama_Barang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Satuan->Visible) { // Satuan ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Satuan) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Satuan" class="pembelian_2D_detail_Satuan"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Satuan->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_pembelian_2D_detail_Satuan" class="pembelian_2D_detail_Satuan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Satuan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Satuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Satuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Harga_Beli->Visible) { // Harga Beli ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Harga_Beli) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Harga_Beli" class="pembelian_2D_detail_Harga_Beli"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Harga_Beli->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_pembelian_2D_detail_Harga_Beli" class="pembelian_2D_detail_Harga_Beli">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Harga_Beli->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Harga_Beli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Harga_Beli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Jumlah->Visible) { // Jumlah ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Jumlah) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Jumlah" class="pembelian_2D_detail_Jumlah"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Jumlah->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_pembelian_2D_detail_Jumlah" class="pembelian_2D_detail_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Total_HP->Visible) { // Total HP ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Total_HP) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Total_HP" class="pembelian_2D_detail_Total_HP"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Total_HP->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_pembelian_2D_detail_Total_HP" class="pembelian_2D_detail_Total_HP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Total_HP->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Total_HP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Total_HP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pembelian_2D_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$pembelian_2D_detail_grid->StartRec = 1;
$pembelian_2D_detail_grid->StopRec = $pembelian_2D_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($pembelian_2D_detail_grid->FormKeyCountName) && ($pembelian_2D_detail->CurrentAction == "gridadd" || $pembelian_2D_detail->CurrentAction == "gridedit" || $pembelian_2D_detail->CurrentAction == "F")) {
		$pembelian_2D_detail_grid->KeyCount = $objForm->GetValue($pembelian_2D_detail_grid->FormKeyCountName);
		$pembelian_2D_detail_grid->StopRec = $pembelian_2D_detail_grid->StartRec + $pembelian_2D_detail_grid->KeyCount - 1;
	}
}
$pembelian_2D_detail_grid->RecCnt = $pembelian_2D_detail_grid->StartRec - 1;
if ($pembelian_2D_detail_grid->Recordset && !$pembelian_2D_detail_grid->Recordset->EOF) {
	$pembelian_2D_detail_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $pembelian_2D_detail_grid->StartRec > 1)
		$pembelian_2D_detail_grid->Recordset->Move($pembelian_2D_detail_grid->StartRec - 1);
} elseif (!$pembelian_2D_detail->AllowAddDeleteRow && $pembelian_2D_detail_grid->StopRec == 0) {
	$pembelian_2D_detail_grid->StopRec = $pembelian_2D_detail->GridAddRowCount;
}

// Initialize aggregate
$pembelian_2D_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pembelian_2D_detail->ResetAttrs();
$pembelian_2D_detail_grid->RenderRow();
if ($pembelian_2D_detail->CurrentAction == "gridadd")
	$pembelian_2D_detail_grid->RowIndex = 0;
if ($pembelian_2D_detail->CurrentAction == "gridedit")
	$pembelian_2D_detail_grid->RowIndex = 0;
while ($pembelian_2D_detail_grid->RecCnt < $pembelian_2D_detail_grid->StopRec) {
	$pembelian_2D_detail_grid->RecCnt++;
	if (intval($pembelian_2D_detail_grid->RecCnt) >= intval($pembelian_2D_detail_grid->StartRec)) {
		$pembelian_2D_detail_grid->RowCnt++;
		if ($pembelian_2D_detail->CurrentAction == "gridadd" || $pembelian_2D_detail->CurrentAction == "gridedit" || $pembelian_2D_detail->CurrentAction == "F") {
			$pembelian_2D_detail_grid->RowIndex++;
			$objForm->Index = $pembelian_2D_detail_grid->RowIndex;
			if ($objForm->HasValue($pembelian_2D_detail_grid->FormActionName))
				$pembelian_2D_detail_grid->RowAction = strval($objForm->GetValue($pembelian_2D_detail_grid->FormActionName));
			elseif ($pembelian_2D_detail->CurrentAction == "gridadd")
				$pembelian_2D_detail_grid->RowAction = "insert";
			else
				$pembelian_2D_detail_grid->RowAction = "";
		}

		// Set up key count
		$pembelian_2D_detail_grid->KeyCount = $pembelian_2D_detail_grid->RowIndex;

		// Init row class and style
		$pembelian_2D_detail->ResetAttrs();
		$pembelian_2D_detail->CssClass = "";
		if ($pembelian_2D_detail->CurrentAction == "gridadd") {
			if ($pembelian_2D_detail->CurrentMode == "copy") {
				$pembelian_2D_detail_grid->LoadRowValues($pembelian_2D_detail_grid->Recordset); // Load row values
				$pembelian_2D_detail_grid->SetRecordKey($pembelian_2D_detail_grid->RowOldKey, $pembelian_2D_detail_grid->Recordset); // Set old record key
			} else {
				$pembelian_2D_detail_grid->LoadDefaultValues(); // Load default values
				$pembelian_2D_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$pembelian_2D_detail_grid->LoadRowValues($pembelian_2D_detail_grid->Recordset); // Load row values
		}
		$pembelian_2D_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($pembelian_2D_detail->CurrentAction == "gridadd") // Grid add
			$pembelian_2D_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($pembelian_2D_detail->CurrentAction == "gridadd" && $pembelian_2D_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$pembelian_2D_detail_grid->RestoreCurrentRowFormValues($pembelian_2D_detail_grid->RowIndex); // Restore form values
		if ($pembelian_2D_detail->CurrentAction == "gridedit") { // Grid edit
			if ($pembelian_2D_detail->EventCancelled) {
				$pembelian_2D_detail_grid->RestoreCurrentRowFormValues($pembelian_2D_detail_grid->RowIndex); // Restore form values
			}
			if ($pembelian_2D_detail_grid->RowAction == "insert")
				$pembelian_2D_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$pembelian_2D_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($pembelian_2D_detail->CurrentAction == "gridedit" && ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT || $pembelian_2D_detail->RowType == EW_ROWTYPE_ADD) && $pembelian_2D_detail->EventCancelled) // Update failed
			$pembelian_2D_detail_grid->RestoreCurrentRowFormValues($pembelian_2D_detail_grid->RowIndex); // Restore form values
		if ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$pembelian_2D_detail_grid->EditRowCnt++;
		if ($pembelian_2D_detail->CurrentAction == "F") // Confirm row
			$pembelian_2D_detail_grid->RestoreCurrentRowFormValues($pembelian_2D_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$pembelian_2D_detail->RowAttrs = array_merge($pembelian_2D_detail->RowAttrs, array('data-rowindex'=>$pembelian_2D_detail_grid->RowCnt, 'id'=>'r' . $pembelian_2D_detail_grid->RowCnt . '_pembelian_2D_detail', 'data-rowtype'=>$pembelian_2D_detail->RowType));

		// Render row
		$pembelian_2D_detail_grid->RenderRow();

		// Render list options
		$pembelian_2D_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pembelian_2D_detail_grid->RowAction <> "delete" && $pembelian_2D_detail_grid->RowAction <> "insertdelete" && !($pembelian_2D_detail_grid->RowAction == "insert" && $pembelian_2D_detail->CurrentAction == "F" && $pembelian_2D_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $pembelian_2D_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pembelian_2D_detail_grid->ListOptions->Render("body", "left", $pembelian_2D_detail_grid->RowCnt);
?>
	<?php if ($pembelian_2D_detail->Kode->Visible) { // Kode ?>
		<td<?php echo $pembelian_2D_detail->Kode->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_grid->RowCnt ?>_pembelian_2D_detail_Kode" class="control-group pembelian_2D_detail_Kode">
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php $pembelian_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$pembelian_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode"<?php echo $pembelian_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($pembelian_2D_detail->Kode->EditValue)) {
	$arwrk = $pembelian_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pembelian_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pembelian_2D_detail->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $pembelian_2D_detail->Kode->OldValue = "";
?>
</select>
<script type="text/javascript">
fpembelian_2D_detailgrid.Lists["x_Kode"].Options = <?php echo (is_array($pembelian_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($pembelian_2D_detail->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `Kode` AS FIELD0, `Nama Barang` AS FIELD1, `Satuan` AS FIELD2, `Harga Pokok` AS FIELD3 FROM `daftar produk`";
 $sWhereWrk = "(`Kode` = '{query_value}')";

 // Call Lookup selecting
 $pembelian_2D_detail->Lookup_Selecting($pembelian_2D_detail->Kode, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="sf_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="ln_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode,x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang,x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan,x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli">
<input type="hidden" data-field="x_Kode" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Kode->OldValue) ?>">
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $pembelian_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$pembelian_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode"<?php echo $pembelian_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($pembelian_2D_detail->Kode->EditValue)) {
	$arwrk = $pembelian_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pembelian_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pembelian_2D_detail->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $pembelian_2D_detail->Kode->OldValue = "";
?>
</select>
<script type="text/javascript">
fpembelian_2D_detailgrid.Lists["x_Kode"].Options = <?php echo (is_array($pembelian_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($pembelian_2D_detail->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `Kode` AS FIELD0, `Nama Barang` AS FIELD1, `Satuan` AS FIELD2, `Harga Pokok` AS FIELD3 FROM `daftar produk`";
 $sWhereWrk = "(`Kode` = '{query_value}')";

 // Call Lookup selecting
 $pembelian_2D_detail->Lookup_Selecting($pembelian_2D_detail->Kode, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="sf_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="ln_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode,x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang,x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan,x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli">
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pembelian_2D_detail->Kode->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Kode->ListViewValue() ?></span>
<input type="hidden" data-field="x_Kode" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Kode->FormValue) ?>">
<input type="hidden" data-field="x_Kode" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Kode->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $pembelian_2D_detail_grid->PageObjName . "_row_" . $pembelian_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_ID" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->ID->CurrentValue) ?>">
<input type="hidden" data-field="x_ID" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_ID" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->ID->OldValue) ?>">
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT || $pembelian_2D_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_ID" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($pembelian_2D_detail->Nama_Barang->Visible) { // Nama Barang ?>
		<td<?php echo $pembelian_2D_detail->Nama_Barang->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_grid->RowCnt ?>_pembelian_2D_detail_Nama_Barang" class="control-group pembelian_2D_detail_Nama_Barang">
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Nama_Barang" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" size="30" maxlength="255" placeholder="<?php echo $pembelian_2D_detail->Nama_Barang->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Nama_Barang->EditValue ?>"<?php echo $pembelian_2D_detail->Nama_Barang->EditAttributes() ?>>
<input type="hidden" data-field="x_Nama_Barang" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Nama_Barang->OldValue) ?>">
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Nama_Barang" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" size="30" maxlength="255" placeholder="<?php echo $pembelian_2D_detail->Nama_Barang->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Nama_Barang->EditValue ?>"<?php echo $pembelian_2D_detail->Nama_Barang->EditAttributes() ?>>
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pembelian_2D_detail->Nama_Barang->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Nama_Barang->ListViewValue() ?></span>
<input type="hidden" data-field="x_Nama_Barang" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Nama_Barang->FormValue) ?>">
<input type="hidden" data-field="x_Nama_Barang" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Nama_Barang->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $pembelian_2D_detail_grid->PageObjName . "_row_" . $pembelian_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Satuan->Visible) { // Satuan ?>
		<td<?php echo $pembelian_2D_detail->Satuan->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_grid->RowCnt ?>_pembelian_2D_detail_Satuan" class="control-group pembelian_2D_detail_Satuan">
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Satuan" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" size="30" maxlength="255" placeholder="<?php echo $pembelian_2D_detail->Satuan->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Satuan->EditValue ?>"<?php echo $pembelian_2D_detail->Satuan->EditAttributes() ?>>
<input type="hidden" data-field="x_Satuan" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Satuan->OldValue) ?>">
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Satuan" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" size="30" maxlength="255" placeholder="<?php echo $pembelian_2D_detail->Satuan->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Satuan->EditValue ?>"<?php echo $pembelian_2D_detail->Satuan->EditAttributes() ?>>
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pembelian_2D_detail->Satuan->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Satuan->ListViewValue() ?></span>
<input type="hidden" data-field="x_Satuan" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Satuan->FormValue) ?>">
<input type="hidden" data-field="x_Satuan" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Satuan->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $pembelian_2D_detail_grid->PageObjName . "_row_" . $pembelian_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Harga_Beli->Visible) { // Harga Beli ?>
		<td<?php echo $pembelian_2D_detail->Harga_Beli->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_grid->RowCnt ?>_pembelian_2D_detail_Harga_Beli" class="control-group pembelian_2D_detail_Harga_Beli">
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Harga_Beli" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" size="30" placeholder="<?php echo $pembelian_2D_detail->Harga_Beli->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Harga_Beli->EditValue ?>"<?php echo $pembelian_2D_detail->Harga_Beli->EditAttributes() ?>>
<input type="hidden" data-field="x_Harga_Beli" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Harga_Beli->OldValue) ?>">
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Harga_Beli" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" size="30" placeholder="<?php echo $pembelian_2D_detail->Harga_Beli->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Harga_Beli->EditValue ?>"<?php echo $pembelian_2D_detail->Harga_Beli->EditAttributes() ?>>
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pembelian_2D_detail->Harga_Beli->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Harga_Beli->ListViewValue() ?></span>
<input type="hidden" data-field="x_Harga_Beli" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Harga_Beli->FormValue) ?>">
<input type="hidden" data-field="x_Harga_Beli" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Harga_Beli->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $pembelian_2D_detail_grid->PageObjName . "_row_" . $pembelian_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Jumlah->Visible) { // Jumlah ?>
		<td<?php echo $pembelian_2D_detail->Jumlah->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_grid->RowCnt ?>_pembelian_2D_detail_Jumlah" class="control-group pembelian_2D_detail_Jumlah">
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Jumlah" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo $pembelian_2D_detail->Jumlah->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Jumlah->EditValue ?>"<?php echo $pembelian_2D_detail->Jumlah->EditAttributes() ?>>
<input type="hidden" data-field="x_Jumlah" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Jumlah->OldValue) ?>">
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Jumlah" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo $pembelian_2D_detail->Jumlah->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Jumlah->EditValue ?>"<?php echo $pembelian_2D_detail->Jumlah->EditAttributes() ?>>
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pembelian_2D_detail->Jumlah->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Jumlah->ListViewValue() ?></span>
<input type="hidden" data-field="x_Jumlah" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Jumlah->FormValue) ?>">
<input type="hidden" data-field="x_Jumlah" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Jumlah->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $pembelian_2D_detail_grid->PageObjName . "_row_" . $pembelian_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Total_HP->Visible) { // Total HP ?>
		<td<?php echo $pembelian_2D_detail->Total_HP->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_grid->RowCnt ?>_pembelian_2D_detail_Total_HP" class="control-group pembelian_2D_detail_Total_HP">
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Total_HP" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" size="30" placeholder="<?php echo $pembelian_2D_detail->Total_HP->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Total_HP->EditValue ?>"<?php echo $pembelian_2D_detail->Total_HP->EditAttributes() ?>>
<input type="hidden" data-field="x_Total_HP" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Total_HP->OldValue) ?>">
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $pembelian_2D_detail->Total_HP->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Total_HP->EditValue ?></span>
<input type="hidden" data-field="x_Total_HP" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Total_HP->CurrentValue) ?>">
<?php } ?>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pembelian_2D_detail->Total_HP->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Total_HP->ListViewValue() ?></span>
<input type="hidden" data-field="x_Total_HP" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Total_HP->FormValue) ?>">
<input type="hidden" data-field="x_Total_HP" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Total_HP->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $pembelian_2D_detail_grid->PageObjName . "_row_" . $pembelian_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$pembelian_2D_detail_grid->ListOptions->Render("body", "right", $pembelian_2D_detail_grid->RowCnt);
?>
	</tr>
<?php if ($pembelian_2D_detail->RowType == EW_ROWTYPE_ADD || $pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpembelian_2D_detailgrid.UpdateOpts(<?php echo $pembelian_2D_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($pembelian_2D_detail->CurrentAction <> "gridadd" || $pembelian_2D_detail->CurrentMode == "copy")
		if (!$pembelian_2D_detail_grid->Recordset->EOF) $pembelian_2D_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($pembelian_2D_detail->CurrentMode == "add" || $pembelian_2D_detail->CurrentMode == "copy" || $pembelian_2D_detail->CurrentMode == "edit") {
		$pembelian_2D_detail_grid->RowIndex = '$rowindex$';
		$pembelian_2D_detail_grid->LoadDefaultValues();

		// Set row properties
		$pembelian_2D_detail->ResetAttrs();
		$pembelian_2D_detail->RowAttrs = array_merge($pembelian_2D_detail->RowAttrs, array('data-rowindex'=>$pembelian_2D_detail_grid->RowIndex, 'id'=>'r0_pembelian_2D_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($pembelian_2D_detail->RowAttrs["class"], "ewTemplate");
		$pembelian_2D_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$pembelian_2D_detail_grid->RenderRow();

		// Render list options
		$pembelian_2D_detail_grid->RenderListOptions();
		$pembelian_2D_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $pembelian_2D_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pembelian_2D_detail_grid->ListOptions->Render("body", "left", $pembelian_2D_detail_grid->RowIndex);
?>
	<?php if ($pembelian_2D_detail->Kode->Visible) { // Kode ?>
		<td><span id="el$rowindex$_pembelian_2D_detail_Kode" class="control-group pembelian_2D_detail_Kode">
<?php if ($pembelian_2D_detail->CurrentAction <> "F") { ?>
<?php $pembelian_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$pembelian_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode"<?php echo $pembelian_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($pembelian_2D_detail->Kode->EditValue)) {
	$arwrk = $pembelian_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pembelian_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pembelian_2D_detail->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $pembelian_2D_detail->Kode->OldValue = "";
?>
</select>
<script type="text/javascript">
fpembelian_2D_detailgrid.Lists["x_Kode"].Options = <?php echo (is_array($pembelian_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($pembelian_2D_detail->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `Kode` AS FIELD0, `Nama Barang` AS FIELD1, `Satuan` AS FIELD2, `Harga Pokok` AS FIELD3 FROM `daftar produk`";
 $sWhereWrk = "(`Kode` = '{query_value}')";

 // Call Lookup selecting
 $pembelian_2D_detail->Lookup_Selecting($pembelian_2D_detail->Kode, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="sf_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="ln_x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode,x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang,x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan,x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli">
<?php } else { ?>
<span<?php echo $pembelian_2D_detail->Kode->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Kode->ViewValue ?></span>
<input type="hidden" data-field="x_Kode" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Kode" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Kode->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Nama_Barang->Visible) { // Nama Barang ?>
		<td><span id="el$rowindex$_pembelian_2D_detail_Nama_Barang" class="control-group pembelian_2D_detail_Nama_Barang">
<?php if ($pembelian_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Nama_Barang" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" size="30" maxlength="255" placeholder="<?php echo $pembelian_2D_detail->Nama_Barang->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Nama_Barang->EditValue ?>"<?php echo $pembelian_2D_detail->Nama_Barang->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $pembelian_2D_detail->Nama_Barang->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Nama_Barang->ViewValue ?></span>
<input type="hidden" data-field="x_Nama_Barang" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Nama_Barang->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Nama_Barang" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Nama_Barang" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Nama_Barang->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Satuan->Visible) { // Satuan ?>
		<td><span id="el$rowindex$_pembelian_2D_detail_Satuan" class="control-group pembelian_2D_detail_Satuan">
<?php if ($pembelian_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Satuan" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" size="30" maxlength="255" placeholder="<?php echo $pembelian_2D_detail->Satuan->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Satuan->EditValue ?>"<?php echo $pembelian_2D_detail->Satuan->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $pembelian_2D_detail->Satuan->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Satuan->ViewValue ?></span>
<input type="hidden" data-field="x_Satuan" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Satuan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Satuan" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Satuan->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Harga_Beli->Visible) { // Harga Beli ?>
		<td><span id="el$rowindex$_pembelian_2D_detail_Harga_Beli" class="control-group pembelian_2D_detail_Harga_Beli">
<?php if ($pembelian_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Harga_Beli" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" size="30" placeholder="<?php echo $pembelian_2D_detail->Harga_Beli->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Harga_Beli->EditValue ?>"<?php echo $pembelian_2D_detail->Harga_Beli->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $pembelian_2D_detail->Harga_Beli->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Harga_Beli->ViewValue ?></span>
<input type="hidden" data-field="x_Harga_Beli" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Harga_Beli->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Harga_Beli" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Harga_Beli" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Harga_Beli->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Jumlah->Visible) { // Jumlah ?>
		<td><span id="el$rowindex$_pembelian_2D_detail_Jumlah" class="control-group pembelian_2D_detail_Jumlah">
<?php if ($pembelian_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Jumlah" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo $pembelian_2D_detail->Jumlah->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Jumlah->EditValue ?>"<?php echo $pembelian_2D_detail->Jumlah->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $pembelian_2D_detail->Jumlah->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Jumlah->ViewValue ?></span>
<input type="hidden" data-field="x_Jumlah" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Jumlah" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Jumlah->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Total_HP->Visible) { // Total HP ?>
		<td><span id="el$rowindex$_pembelian_2D_detail_Total_HP" class="control-group pembelian_2D_detail_Total_HP">
<?php if ($pembelian_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Total_HP" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" size="30" placeholder="<?php echo $pembelian_2D_detail->Total_HP->PlaceHolder ?>" value="<?php echo $pembelian_2D_detail->Total_HP->EditValue ?>"<?php echo $pembelian_2D_detail->Total_HP->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $pembelian_2D_detail->Total_HP->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Total_HP->ViewValue ?></span>
<input type="hidden" data-field="x_Total_HP" name="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" id="x<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Total_HP->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Total_HP" name="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" id="o<?php echo $pembelian_2D_detail_grid->RowIndex ?>_Total_HP" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->Total_HP->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$pembelian_2D_detail_grid->ListOptions->Render("body", "right", $pembelian_2D_detail_grid->RowCnt);
?>
<script type="text/javascript">
fpembelian_2D_detailgrid.UpdateOpts(<?php echo $pembelian_2D_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($pembelian_2D_detail->CurrentMode == "add" || $pembelian_2D_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $pembelian_2D_detail_grid->FormKeyCountName ?>" id="<?php echo $pembelian_2D_detail_grid->FormKeyCountName ?>" value="<?php echo $pembelian_2D_detail_grid->KeyCount ?>">
<?php echo $pembelian_2D_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($pembelian_2D_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $pembelian_2D_detail_grid->FormKeyCountName ?>" id="<?php echo $pembelian_2D_detail_grid->FormKeyCountName ?>" value="<?php echo $pembelian_2D_detail_grid->KeyCount ?>">
<?php echo $pembelian_2D_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($pembelian_2D_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpembelian_2D_detailgrid">
</div>
<?php

// Close recordset
if ($pembelian_2D_detail_grid->Recordset)
	$pembelian_2D_detail_grid->Recordset->Close();
?>
<?php if ($pembelian_2D_detail_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($pembelian_2D_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($pembelian_2D_detail->Export == "") { ?>
<script type="text/javascript">
fpembelian_2D_detailgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$pembelian_2D_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$pembelian_2D_detail_grid->Page_Terminate();
?>

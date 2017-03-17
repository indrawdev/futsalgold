<?php include_once "_2padmininfo.php" ?>
<?php

// Create page object
if (!isset($penjualan_2D_detail_grid)) $penjualan_2D_detail_grid = new cpenjualan_2D_detail_grid();

// Page init
$penjualan_2D_detail_grid->Page_Init();

// Page main
$penjualan_2D_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$penjualan_2D_detail_grid->Page_Render();
?>
<?php if ($penjualan_2D_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var penjualan_2D_detail_grid = new ew_Page("penjualan_2D_detail_grid");
penjualan_2D_detail_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = penjualan_2D_detail_grid.PageID; // For backward compatibility

// Form object
var fpenjualan_2D_detailgrid = new ew_Form("fpenjualan_2D_detailgrid");
fpenjualan_2D_detailgrid.FormKeyCountName = '<?php echo $penjualan_2D_detail_grid->FormKeyCountName ?>';

// Validate form
fpenjualan_2D_detailgrid.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_detail->Kode->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Satuan");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_detail->Satuan->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Harga_Jual");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_detail->Harga_Jual->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Harga_Jual");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($penjualan_2D_detail->Harga_Jual->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_detail->Jumlah->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($penjualan_2D_detail->Jumlah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Diskon");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_detail->Diskon->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Diskon");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($penjualan_2D_detail->Diskon->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Total_HJ");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($penjualan_2D_detail->Total_HJ->FldErrMsg()) ?>");

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
fpenjualan_2D_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Kode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Satuan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Harga_Jual", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Jumlah", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Diskon", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Total_HJ", false)) return false;
	return true;
}

// Form_CustomValidate event
fpenjualan_2D_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpenjualan_2D_detailgrid.ValidateRequired = true;
<?php } else { ?>
fpenjualan_2D_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpenjualan_2D_detailgrid.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":true,"DisplayFields":["x_Kode","x_Nama_Barang","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php if ($penjualan_2D_detail->getCurrentMasterTable() == "" && $penjualan_2D_detail_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $penjualan_2D_detail_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($penjualan_2D_detail->CurrentAction == "gridadd") {
	if ($penjualan_2D_detail->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$penjualan_2D_detail_grid->TotalRecs = $penjualan_2D_detail->SelectRecordCount();
			$penjualan_2D_detail_grid->Recordset = $penjualan_2D_detail_grid->LoadRecordset($penjualan_2D_detail_grid->StartRec-1, $penjualan_2D_detail_grid->DisplayRecs);
		} else {
			if ($penjualan_2D_detail_grid->Recordset = $penjualan_2D_detail_grid->LoadRecordset())
				$penjualan_2D_detail_grid->TotalRecs = $penjualan_2D_detail_grid->Recordset->RecordCount();
		}
		$penjualan_2D_detail_grid->StartRec = 1;
		$penjualan_2D_detail_grid->DisplayRecs = $penjualan_2D_detail_grid->TotalRecs;
	} else {
		$penjualan_2D_detail->CurrentFilter = "0=1";
		$penjualan_2D_detail_grid->StartRec = 1;
		$penjualan_2D_detail_grid->DisplayRecs = $penjualan_2D_detail->GridAddRowCount;
	}
	$penjualan_2D_detail_grid->TotalRecs = $penjualan_2D_detail_grid->DisplayRecs;
	$penjualan_2D_detail_grid->StopRec = $penjualan_2D_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$penjualan_2D_detail_grid->TotalRecs = $penjualan_2D_detail->SelectRecordCount();
	} else {
		if ($penjualan_2D_detail_grid->Recordset = $penjualan_2D_detail_grid->LoadRecordset())
			$penjualan_2D_detail_grid->TotalRecs = $penjualan_2D_detail_grid->Recordset->RecordCount();
	}
	$penjualan_2D_detail_grid->StartRec = 1;
	$penjualan_2D_detail_grid->DisplayRecs = $penjualan_2D_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$penjualan_2D_detail_grid->Recordset = $penjualan_2D_detail_grid->LoadRecordset($penjualan_2D_detail_grid->StartRec-1, $penjualan_2D_detail_grid->DisplayRecs);
}
$penjualan_2D_detail_grid->RenderOtherOptions();
?>
<?php $penjualan_2D_detail_grid->ShowPageHeader(); ?>
<?php
$penjualan_2D_detail_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fpenjualan_2D_detailgrid" class="ewForm form-horizontal">
<div id="gmp_penjualan_2D_detail" class="ewGridMiddlePanel">
<table id="tbl_penjualan_2D_detailgrid" class="ewTable ewTableSeparate">
<?php echo $penjualan_2D_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$penjualan_2D_detail_grid->RenderListOptions();

// Render list options (header, left)
$penjualan_2D_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($penjualan_2D_detail->Kode->Visible) { // Kode ?>
	<?php if ($penjualan_2D_detail->SortUrl($penjualan_2D_detail->Kode) == "") { ?>
		<td><div id="elh_penjualan_2D_detail_Kode" class="penjualan_2D_detail_Kode"><div class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Kode->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_penjualan_2D_detail_Kode" class="penjualan_2D_detail_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penjualan_2D_detail->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($penjualan_2D_detail->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($penjualan_2D_detail->Satuan->Visible) { // Satuan ?>
	<?php if ($penjualan_2D_detail->SortUrl($penjualan_2D_detail->Satuan) == "") { ?>
		<td><div id="elh_penjualan_2D_detail_Satuan" class="penjualan_2D_detail_Satuan"><div class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Satuan->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_penjualan_2D_detail_Satuan" class="penjualan_2D_detail_Satuan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Satuan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penjualan_2D_detail->Satuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($penjualan_2D_detail->Satuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($penjualan_2D_detail->Harga_Jual->Visible) { // Harga Jual ?>
	<?php if ($penjualan_2D_detail->SortUrl($penjualan_2D_detail->Harga_Jual) == "") { ?>
		<td><div id="elh_penjualan_2D_detail_Harga_Jual" class="penjualan_2D_detail_Harga_Jual"><div class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Harga_Jual->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_penjualan_2D_detail_Harga_Jual" class="penjualan_2D_detail_Harga_Jual">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Harga_Jual->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penjualan_2D_detail->Harga_Jual->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($penjualan_2D_detail->Harga_Jual->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($penjualan_2D_detail->Jumlah->Visible) { // Jumlah ?>
	<?php if ($penjualan_2D_detail->SortUrl($penjualan_2D_detail->Jumlah) == "") { ?>
		<td><div id="elh_penjualan_2D_detail_Jumlah" class="penjualan_2D_detail_Jumlah"><div class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Jumlah->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_penjualan_2D_detail_Jumlah" class="penjualan_2D_detail_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penjualan_2D_detail->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($penjualan_2D_detail->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($penjualan_2D_detail->Diskon->Visible) { // Diskon ?>
	<?php if ($penjualan_2D_detail->SortUrl($penjualan_2D_detail->Diskon) == "") { ?>
		<td><div id="elh_penjualan_2D_detail_Diskon" class="penjualan_2D_detail_Diskon"><div class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Diskon->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_penjualan_2D_detail_Diskon" class="penjualan_2D_detail_Diskon">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Diskon->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penjualan_2D_detail->Diskon->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($penjualan_2D_detail->Diskon->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($penjualan_2D_detail->Total_HJ->Visible) { // Total HJ ?>
	<?php if ($penjualan_2D_detail->SortUrl($penjualan_2D_detail->Total_HJ) == "") { ?>
		<td><div id="elh_penjualan_2D_detail_Total_HJ" class="penjualan_2D_detail_Total_HJ"><div class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Total_HJ->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_penjualan_2D_detail_Total_HJ" class="penjualan_2D_detail_Total_HJ">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penjualan_2D_detail->Total_HJ->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penjualan_2D_detail->Total_HJ->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($penjualan_2D_detail->Total_HJ->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$penjualan_2D_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$penjualan_2D_detail_grid->StartRec = 1;
$penjualan_2D_detail_grid->StopRec = $penjualan_2D_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($penjualan_2D_detail_grid->FormKeyCountName) && ($penjualan_2D_detail->CurrentAction == "gridadd" || $penjualan_2D_detail->CurrentAction == "gridedit" || $penjualan_2D_detail->CurrentAction == "F")) {
		$penjualan_2D_detail_grid->KeyCount = $objForm->GetValue($penjualan_2D_detail_grid->FormKeyCountName);
		$penjualan_2D_detail_grid->StopRec = $penjualan_2D_detail_grid->StartRec + $penjualan_2D_detail_grid->KeyCount - 1;
	}
}
$penjualan_2D_detail_grid->RecCnt = $penjualan_2D_detail_grid->StartRec - 1;
if ($penjualan_2D_detail_grid->Recordset && !$penjualan_2D_detail_grid->Recordset->EOF) {
	$penjualan_2D_detail_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $penjualan_2D_detail_grid->StartRec > 1)
		$penjualan_2D_detail_grid->Recordset->Move($penjualan_2D_detail_grid->StartRec - 1);
} elseif (!$penjualan_2D_detail->AllowAddDeleteRow && $penjualan_2D_detail_grid->StopRec == 0) {
	$penjualan_2D_detail_grid->StopRec = $penjualan_2D_detail->GridAddRowCount;
}

// Initialize aggregate
$penjualan_2D_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$penjualan_2D_detail->ResetAttrs();
$penjualan_2D_detail_grid->RenderRow();
if ($penjualan_2D_detail->CurrentAction == "gridadd")
	$penjualan_2D_detail_grid->RowIndex = 0;
if ($penjualan_2D_detail->CurrentAction == "gridedit")
	$penjualan_2D_detail_grid->RowIndex = 0;
while ($penjualan_2D_detail_grid->RecCnt < $penjualan_2D_detail_grid->StopRec) {
	$penjualan_2D_detail_grid->RecCnt++;
	if (intval($penjualan_2D_detail_grid->RecCnt) >= intval($penjualan_2D_detail_grid->StartRec)) {
		$penjualan_2D_detail_grid->RowCnt++;
		if ($penjualan_2D_detail->CurrentAction == "gridadd" || $penjualan_2D_detail->CurrentAction == "gridedit" || $penjualan_2D_detail->CurrentAction == "F") {
			$penjualan_2D_detail_grid->RowIndex++;
			$objForm->Index = $penjualan_2D_detail_grid->RowIndex;
			if ($objForm->HasValue($penjualan_2D_detail_grid->FormActionName))
				$penjualan_2D_detail_grid->RowAction = strval($objForm->GetValue($penjualan_2D_detail_grid->FormActionName));
			elseif ($penjualan_2D_detail->CurrentAction == "gridadd")
				$penjualan_2D_detail_grid->RowAction = "insert";
			else
				$penjualan_2D_detail_grid->RowAction = "";
		}

		// Set up key count
		$penjualan_2D_detail_grid->KeyCount = $penjualan_2D_detail_grid->RowIndex;

		// Init row class and style
		$penjualan_2D_detail->ResetAttrs();
		$penjualan_2D_detail->CssClass = "";
		if ($penjualan_2D_detail->CurrentAction == "gridadd") {
			if ($penjualan_2D_detail->CurrentMode == "copy") {
				$penjualan_2D_detail_grid->LoadRowValues($penjualan_2D_detail_grid->Recordset); // Load row values
				$penjualan_2D_detail_grid->SetRecordKey($penjualan_2D_detail_grid->RowOldKey, $penjualan_2D_detail_grid->Recordset); // Set old record key
			} else {
				$penjualan_2D_detail_grid->LoadDefaultValues(); // Load default values
				$penjualan_2D_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$penjualan_2D_detail_grid->LoadRowValues($penjualan_2D_detail_grid->Recordset); // Load row values
		}
		$penjualan_2D_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($penjualan_2D_detail->CurrentAction == "gridadd") // Grid add
			$penjualan_2D_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($penjualan_2D_detail->CurrentAction == "gridadd" && $penjualan_2D_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$penjualan_2D_detail_grid->RestoreCurrentRowFormValues($penjualan_2D_detail_grid->RowIndex); // Restore form values
		if ($penjualan_2D_detail->CurrentAction == "gridedit") { // Grid edit
			if ($penjualan_2D_detail->EventCancelled) {
				$penjualan_2D_detail_grid->RestoreCurrentRowFormValues($penjualan_2D_detail_grid->RowIndex); // Restore form values
			}
			if ($penjualan_2D_detail_grid->RowAction == "insert")
				$penjualan_2D_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$penjualan_2D_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($penjualan_2D_detail->CurrentAction == "gridedit" && ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT || $penjualan_2D_detail->RowType == EW_ROWTYPE_ADD) && $penjualan_2D_detail->EventCancelled) // Update failed
			$penjualan_2D_detail_grid->RestoreCurrentRowFormValues($penjualan_2D_detail_grid->RowIndex); // Restore form values
		if ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$penjualan_2D_detail_grid->EditRowCnt++;
		if ($penjualan_2D_detail->CurrentAction == "F") // Confirm row
			$penjualan_2D_detail_grid->RestoreCurrentRowFormValues($penjualan_2D_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$penjualan_2D_detail->RowAttrs = array_merge($penjualan_2D_detail->RowAttrs, array('data-rowindex'=>$penjualan_2D_detail_grid->RowCnt, 'id'=>'r' . $penjualan_2D_detail_grid->RowCnt . '_penjualan_2D_detail', 'data-rowtype'=>$penjualan_2D_detail->RowType));

		// Render row
		$penjualan_2D_detail_grid->RenderRow();

		// Render list options
		$penjualan_2D_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($penjualan_2D_detail_grid->RowAction <> "delete" && $penjualan_2D_detail_grid->RowAction <> "insertdelete" && !($penjualan_2D_detail_grid->RowAction == "insert" && $penjualan_2D_detail->CurrentAction == "F" && $penjualan_2D_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $penjualan_2D_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$penjualan_2D_detail_grid->ListOptions->Render("body", "left", $penjualan_2D_detail_grid->RowCnt);
?>
	<?php if ($penjualan_2D_detail->Kode->Visible) { // Kode ?>
		<td<?php echo $penjualan_2D_detail->Kode->CellAttributes() ?>><span id="el<?php echo $penjualan_2D_detail_grid->RowCnt ?>_penjualan_2D_detail_Kode" class="control-group penjualan_2D_detail_Kode">
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php $penjualan_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$penjualan_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode"<?php echo $penjualan_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($penjualan_2D_detail->Kode->EditValue)) {
	$arwrk = $penjualan_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($penjualan_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$penjualan_2D_detail->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $penjualan_2D_detail->Kode->OldValue = "";
?>
</select>
<script type="text/javascript">
fpenjualan_2D_detailgrid.Lists["x_Kode"].Options = <?php echo (is_array($penjualan_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($penjualan_2D_detail->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `Kode` AS FIELD0, `Satuan` AS FIELD1, `Harga Jual` AS FIELD2 FROM `daftar produk`";
 $sWhereWrk = "(`Kode` = '{query_value}')";

 // Call Lookup selecting
 $penjualan_2D_detail->Lookup_Selecting($penjualan_2D_detail->Kode, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="sf_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="ln_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode,x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan,x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual">
<input type="hidden" data-field="x_Kode" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Kode->OldValue) ?>">
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $penjualan_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$penjualan_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode"<?php echo $penjualan_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($penjualan_2D_detail->Kode->EditValue)) {
	$arwrk = $penjualan_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($penjualan_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$penjualan_2D_detail->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $penjualan_2D_detail->Kode->OldValue = "";
?>
</select>
<script type="text/javascript">
fpenjualan_2D_detailgrid.Lists["x_Kode"].Options = <?php echo (is_array($penjualan_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($penjualan_2D_detail->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `Kode` AS FIELD0, `Satuan` AS FIELD1, `Harga Jual` AS FIELD2 FROM `daftar produk`";
 $sWhereWrk = "(`Kode` = '{query_value}')";

 // Call Lookup selecting
 $penjualan_2D_detail->Lookup_Selecting($penjualan_2D_detail->Kode, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="sf_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="ln_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode,x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan,x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual">
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $penjualan_2D_detail->Kode->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Kode->ListViewValue() ?></span>
<input type="hidden" data-field="x_Kode" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Kode->FormValue) ?>">
<input type="hidden" data-field="x_Kode" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Kode->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $penjualan_2D_detail_grid->PageObjName . "_row_" . $penjualan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_ID" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->ID->CurrentValue) ?>">
<input type="hidden" data-field="x_ID" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_ID" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->ID->OldValue) ?>">
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT || $penjualan_2D_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_ID" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($penjualan_2D_detail->Satuan->Visible) { // Satuan ?>
		<td<?php echo $penjualan_2D_detail->Satuan->CellAttributes() ?>><span id="el<?php echo $penjualan_2D_detail_grid->RowCnt ?>_penjualan_2D_detail_Satuan" class="control-group penjualan_2D_detail_Satuan">
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Satuan" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" size="30" maxlength="255" placeholder="<?php echo $penjualan_2D_detail->Satuan->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Satuan->EditValue ?>"<?php echo $penjualan_2D_detail->Satuan->EditAttributes() ?>>
<input type="hidden" data-field="x_Satuan" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Satuan->OldValue) ?>">
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Satuan" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" size="30" maxlength="255" placeholder="<?php echo $penjualan_2D_detail->Satuan->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Satuan->EditValue ?>"<?php echo $penjualan_2D_detail->Satuan->EditAttributes() ?>>
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $penjualan_2D_detail->Satuan->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Satuan->ListViewValue() ?></span>
<input type="hidden" data-field="x_Satuan" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Satuan->FormValue) ?>">
<input type="hidden" data-field="x_Satuan" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Satuan->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $penjualan_2D_detail_grid->PageObjName . "_row_" . $penjualan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($penjualan_2D_detail->Harga_Jual->Visible) { // Harga Jual ?>
		<td<?php echo $penjualan_2D_detail->Harga_Jual->CellAttributes() ?>><span id="el<?php echo $penjualan_2D_detail_grid->RowCnt ?>_penjualan_2D_detail_Harga_Jual" class="control-group penjualan_2D_detail_Harga_Jual">
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Harga_Jual" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" size="30" placeholder="<?php echo $penjualan_2D_detail->Harga_Jual->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Harga_Jual->EditValue ?>"<?php echo $penjualan_2D_detail->Harga_Jual->EditAttributes() ?>>
<input type="hidden" data-field="x_Harga_Jual" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Harga_Jual->OldValue) ?>">
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Harga_Jual" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" size="30" placeholder="<?php echo $penjualan_2D_detail->Harga_Jual->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Harga_Jual->EditValue ?>"<?php echo $penjualan_2D_detail->Harga_Jual->EditAttributes() ?>>
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $penjualan_2D_detail->Harga_Jual->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Harga_Jual->ListViewValue() ?></span>
<input type="hidden" data-field="x_Harga_Jual" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Harga_Jual->FormValue) ?>">
<input type="hidden" data-field="x_Harga_Jual" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Harga_Jual->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $penjualan_2D_detail_grid->PageObjName . "_row_" . $penjualan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($penjualan_2D_detail->Jumlah->Visible) { // Jumlah ?>
		<td<?php echo $penjualan_2D_detail->Jumlah->CellAttributes() ?>><span id="el<?php echo $penjualan_2D_detail_grid->RowCnt ?>_penjualan_2D_detail_Jumlah" class="control-group penjualan_2D_detail_Jumlah">
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Jumlah" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo $penjualan_2D_detail->Jumlah->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Jumlah->EditValue ?>"<?php echo $penjualan_2D_detail->Jumlah->EditAttributes() ?>>
<input type="hidden" data-field="x_Jumlah" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Jumlah->OldValue) ?>">
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Jumlah" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo $penjualan_2D_detail->Jumlah->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Jumlah->EditValue ?>"<?php echo $penjualan_2D_detail->Jumlah->EditAttributes() ?>>
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $penjualan_2D_detail->Jumlah->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Jumlah->ListViewValue() ?></span>
<input type="hidden" data-field="x_Jumlah" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Jumlah->FormValue) ?>">
<input type="hidden" data-field="x_Jumlah" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Jumlah->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $penjualan_2D_detail_grid->PageObjName . "_row_" . $penjualan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($penjualan_2D_detail->Diskon->Visible) { // Diskon ?>
		<td<?php echo $penjualan_2D_detail->Diskon->CellAttributes() ?>><span id="el<?php echo $penjualan_2D_detail_grid->RowCnt ?>_penjualan_2D_detail_Diskon" class="control-group penjualan_2D_detail_Diskon">
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Diskon" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" size="30" placeholder="<?php echo $penjualan_2D_detail->Diskon->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Diskon->EditValue ?>"<?php echo $penjualan_2D_detail->Diskon->EditAttributes() ?>>
<input type="hidden" data-field="x_Diskon" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Diskon->OldValue) ?>">
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Diskon" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" size="30" placeholder="<?php echo $penjualan_2D_detail->Diskon->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Diskon->EditValue ?>"<?php echo $penjualan_2D_detail->Diskon->EditAttributes() ?>>
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $penjualan_2D_detail->Diskon->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Diskon->ListViewValue() ?></span>
<input type="hidden" data-field="x_Diskon" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Diskon->FormValue) ?>">
<input type="hidden" data-field="x_Diskon" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Diskon->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $penjualan_2D_detail_grid->PageObjName . "_row_" . $penjualan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($penjualan_2D_detail->Total_HJ->Visible) { // Total HJ ?>
		<td<?php echo $penjualan_2D_detail->Total_HJ->CellAttributes() ?>><span id="el<?php echo $penjualan_2D_detail_grid->RowCnt ?>_penjualan_2D_detail_Total_HJ" class="control-group penjualan_2D_detail_Total_HJ">
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Total_HJ" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" size="30" placeholder="<?php echo $penjualan_2D_detail->Total_HJ->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Total_HJ->EditValue ?>"<?php echo $penjualan_2D_detail->Total_HJ->EditAttributes() ?>>
<input type="hidden" data-field="x_Total_HJ" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Total_HJ->OldValue) ?>">
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Total_HJ" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" size="30" placeholder="<?php echo $penjualan_2D_detail->Total_HJ->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Total_HJ->EditValue ?>"<?php echo $penjualan_2D_detail->Total_HJ->EditAttributes() ?>>
<?php } ?>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $penjualan_2D_detail->Total_HJ->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Total_HJ->ListViewValue() ?></span>
<input type="hidden" data-field="x_Total_HJ" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Total_HJ->FormValue) ?>">
<input type="hidden" data-field="x_Total_HJ" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Total_HJ->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $penjualan_2D_detail_grid->PageObjName . "_row_" . $penjualan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$penjualan_2D_detail_grid->ListOptions->Render("body", "right", $penjualan_2D_detail_grid->RowCnt);
?>
	</tr>
<?php if ($penjualan_2D_detail->RowType == EW_ROWTYPE_ADD || $penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpenjualan_2D_detailgrid.UpdateOpts(<?php echo $penjualan_2D_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($penjualan_2D_detail->CurrentAction <> "gridadd" || $penjualan_2D_detail->CurrentMode == "copy")
		if (!$penjualan_2D_detail_grid->Recordset->EOF) $penjualan_2D_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($penjualan_2D_detail->CurrentMode == "add" || $penjualan_2D_detail->CurrentMode == "copy" || $penjualan_2D_detail->CurrentMode == "edit") {
		$penjualan_2D_detail_grid->RowIndex = '$rowindex$';
		$penjualan_2D_detail_grid->LoadDefaultValues();

		// Set row properties
		$penjualan_2D_detail->ResetAttrs();
		$penjualan_2D_detail->RowAttrs = array_merge($penjualan_2D_detail->RowAttrs, array('data-rowindex'=>$penjualan_2D_detail_grid->RowIndex, 'id'=>'r0_penjualan_2D_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($penjualan_2D_detail->RowAttrs["class"], "ewTemplate");
		$penjualan_2D_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$penjualan_2D_detail_grid->RenderRow();

		// Render list options
		$penjualan_2D_detail_grid->RenderListOptions();
		$penjualan_2D_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $penjualan_2D_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$penjualan_2D_detail_grid->ListOptions->Render("body", "left", $penjualan_2D_detail_grid->RowIndex);
?>
	<?php if ($penjualan_2D_detail->Kode->Visible) { // Kode ?>
		<td><span id="el$rowindex$_penjualan_2D_detail_Kode" class="control-group penjualan_2D_detail_Kode">
<?php if ($penjualan_2D_detail->CurrentAction <> "F") { ?>
<?php $penjualan_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$penjualan_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode"<?php echo $penjualan_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($penjualan_2D_detail->Kode->EditValue)) {
	$arwrk = $penjualan_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($penjualan_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$penjualan_2D_detail->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $penjualan_2D_detail->Kode->OldValue = "";
?>
</select>
<script type="text/javascript">
fpenjualan_2D_detailgrid.Lists["x_Kode"].Options = <?php echo (is_array($penjualan_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($penjualan_2D_detail->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `Kode` AS FIELD0, `Satuan` AS FIELD1, `Harga Jual` AS FIELD2 FROM `daftar produk`";
 $sWhereWrk = "(`Kode` = '{query_value}')";

 // Call Lookup selecting
 $penjualan_2D_detail->Lookup_Selecting($penjualan_2D_detail->Kode, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="sf_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="ln_x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode,x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan,x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual">
<?php } else { ?>
<span<?php echo $penjualan_2D_detail->Kode->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Kode->ViewValue ?></span>
<input type="hidden" data-field="x_Kode" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Kode" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Kode->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($penjualan_2D_detail->Satuan->Visible) { // Satuan ?>
		<td><span id="el$rowindex$_penjualan_2D_detail_Satuan" class="control-group penjualan_2D_detail_Satuan">
<?php if ($penjualan_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Satuan" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" size="30" maxlength="255" placeholder="<?php echo $penjualan_2D_detail->Satuan->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Satuan->EditValue ?>"<?php echo $penjualan_2D_detail->Satuan->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $penjualan_2D_detail->Satuan->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Satuan->ViewValue ?></span>
<input type="hidden" data-field="x_Satuan" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Satuan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Satuan" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Satuan->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($penjualan_2D_detail->Harga_Jual->Visible) { // Harga Jual ?>
		<td><span id="el$rowindex$_penjualan_2D_detail_Harga_Jual" class="control-group penjualan_2D_detail_Harga_Jual">
<?php if ($penjualan_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Harga_Jual" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" size="30" placeholder="<?php echo $penjualan_2D_detail->Harga_Jual->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Harga_Jual->EditValue ?>"<?php echo $penjualan_2D_detail->Harga_Jual->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $penjualan_2D_detail->Harga_Jual->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Harga_Jual->ViewValue ?></span>
<input type="hidden" data-field="x_Harga_Jual" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Harga_Jual->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Harga_Jual" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Harga_Jual" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Harga_Jual->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($penjualan_2D_detail->Jumlah->Visible) { // Jumlah ?>
		<td><span id="el$rowindex$_penjualan_2D_detail_Jumlah" class="control-group penjualan_2D_detail_Jumlah">
<?php if ($penjualan_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Jumlah" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo $penjualan_2D_detail->Jumlah->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Jumlah->EditValue ?>"<?php echo $penjualan_2D_detail->Jumlah->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $penjualan_2D_detail->Jumlah->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Jumlah->ViewValue ?></span>
<input type="hidden" data-field="x_Jumlah" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Jumlah" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Jumlah->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($penjualan_2D_detail->Diskon->Visible) { // Diskon ?>
		<td><span id="el$rowindex$_penjualan_2D_detail_Diskon" class="control-group penjualan_2D_detail_Diskon">
<?php if ($penjualan_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Diskon" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" size="30" placeholder="<?php echo $penjualan_2D_detail->Diskon->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Diskon->EditValue ?>"<?php echo $penjualan_2D_detail->Diskon->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $penjualan_2D_detail->Diskon->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Diskon->ViewValue ?></span>
<input type="hidden" data-field="x_Diskon" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Diskon->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Diskon" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Diskon" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Diskon->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($penjualan_2D_detail->Total_HJ->Visible) { // Total HJ ?>
		<td><span id="el$rowindex$_penjualan_2D_detail_Total_HJ" class="control-group penjualan_2D_detail_Total_HJ">
<?php if ($penjualan_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Total_HJ" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" size="30" placeholder="<?php echo $penjualan_2D_detail->Total_HJ->PlaceHolder ?>" value="<?php echo $penjualan_2D_detail->Total_HJ->EditValue ?>"<?php echo $penjualan_2D_detail->Total_HJ->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $penjualan_2D_detail->Total_HJ->ViewAttributes() ?>>
<?php echo $penjualan_2D_detail->Total_HJ->ViewValue ?></span>
<input type="hidden" data-field="x_Total_HJ" name="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" id="x<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Total_HJ->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Total_HJ" name="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" id="o<?php echo $penjualan_2D_detail_grid->RowIndex ?>_Total_HJ" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->Total_HJ->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$penjualan_2D_detail_grid->ListOptions->Render("body", "right", $penjualan_2D_detail_grid->RowCnt);
?>
<script type="text/javascript">
fpenjualan_2D_detailgrid.UpdateOpts(<?php echo $penjualan_2D_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($penjualan_2D_detail->CurrentMode == "add" || $penjualan_2D_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $penjualan_2D_detail_grid->FormKeyCountName ?>" id="<?php echo $penjualan_2D_detail_grid->FormKeyCountName ?>" value="<?php echo $penjualan_2D_detail_grid->KeyCount ?>">
<?php echo $penjualan_2D_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($penjualan_2D_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $penjualan_2D_detail_grid->FormKeyCountName ?>" id="<?php echo $penjualan_2D_detail_grid->FormKeyCountName ?>" value="<?php echo $penjualan_2D_detail_grid->KeyCount ?>">
<?php echo $penjualan_2D_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($penjualan_2D_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpenjualan_2D_detailgrid">
</div>
<?php

// Close recordset
if ($penjualan_2D_detail_grid->Recordset)
	$penjualan_2D_detail_grid->Recordset->Close();
?>
<?php if ($penjualan_2D_detail_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($penjualan_2D_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($penjualan_2D_detail->Export == "") { ?>
<script type="text/javascript">
fpenjualan_2D_detailgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$penjualan_2D_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$penjualan_2D_detail_grid->Page_Terminate();
?>

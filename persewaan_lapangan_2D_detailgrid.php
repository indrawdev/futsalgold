<?php include_once "_2padmininfo.php" ?>
<?php

// Create page object
if (!isset($persewaan_lapangan_2D_detail_grid)) $persewaan_lapangan_2D_detail_grid = new cpersewaan_lapangan_2D_detail_grid();

// Page init
$persewaan_lapangan_2D_detail_grid->Page_Init();

// Page main
$persewaan_lapangan_2D_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persewaan_lapangan_2D_detail_grid->Page_Render();
?>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var persewaan_lapangan_2D_detail_grid = new ew_Page("persewaan_lapangan_2D_detail_grid");
persewaan_lapangan_2D_detail_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = persewaan_lapangan_2D_detail_grid.PageID; // For backward compatibility

// Form object
var fpersewaan_lapangan_2D_detailgrid = new ew_Form("fpersewaan_lapangan_2D_detailgrid");
fpersewaan_lapangan_2D_detailgrid.FormKeyCountName = '<?php echo $persewaan_lapangan_2D_detail_grid->FormKeyCountName ?>';

// Validate form
fpersewaan_lapangan_2D_detailgrid.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->Kode->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_NamaLapangan");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->NamaLapangan->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_TglSewa");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->TglSewa->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_TglSewa");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->TglSewa->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_JamSewa");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->JamSewa->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_HargaSewa");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->HargaSewa->FldErrMsg()) ?>");

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
fpersewaan_lapangan_2D_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Kode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NamaLapangan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "TglSewa", false)) return false;
	if (ew_ValueChanged(fobj, infix, "JamSewa", false)) return false;
	if (ew_ValueChanged(fobj, infix, "HargaSewa", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Hitung", false)) return false;
	return true;
}

// Form_CustomValidate event
fpersewaan_lapangan_2D_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersewaan_lapangan_2D_detailgrid.ValidateRequired = true;
<?php } else { ?>
fpersewaan_lapangan_2D_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersewaan_lapangan_2D_detailgrid.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":true,"DisplayFields":["x_Kode","x_NamaLapangan","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->getCurrentMasterTable() == "" && $persewaan_lapangan_2D_detail_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $persewaan_lapangan_2D_detail_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($persewaan_lapangan_2D_detail->CurrentAction == "gridadd") {
	if ($persewaan_lapangan_2D_detail->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$persewaan_lapangan_2D_detail_grid->TotalRecs = $persewaan_lapangan_2D_detail->SelectRecordCount();
			$persewaan_lapangan_2D_detail_grid->Recordset = $persewaan_lapangan_2D_detail_grid->LoadRecordset($persewaan_lapangan_2D_detail_grid->StartRec-1, $persewaan_lapangan_2D_detail_grid->DisplayRecs);
		} else {
			if ($persewaan_lapangan_2D_detail_grid->Recordset = $persewaan_lapangan_2D_detail_grid->LoadRecordset())
				$persewaan_lapangan_2D_detail_grid->TotalRecs = $persewaan_lapangan_2D_detail_grid->Recordset->RecordCount();
		}
		$persewaan_lapangan_2D_detail_grid->StartRec = 1;
		$persewaan_lapangan_2D_detail_grid->DisplayRecs = $persewaan_lapangan_2D_detail_grid->TotalRecs;
	} else {
		$persewaan_lapangan_2D_detail->CurrentFilter = "0=1";
		$persewaan_lapangan_2D_detail_grid->StartRec = 1;
		$persewaan_lapangan_2D_detail_grid->DisplayRecs = $persewaan_lapangan_2D_detail->GridAddRowCount;
	}
	$persewaan_lapangan_2D_detail_grid->TotalRecs = $persewaan_lapangan_2D_detail_grid->DisplayRecs;
	$persewaan_lapangan_2D_detail_grid->StopRec = $persewaan_lapangan_2D_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$persewaan_lapangan_2D_detail_grid->TotalRecs = $persewaan_lapangan_2D_detail->SelectRecordCount();
	} else {
		if ($persewaan_lapangan_2D_detail_grid->Recordset = $persewaan_lapangan_2D_detail_grid->LoadRecordset())
			$persewaan_lapangan_2D_detail_grid->TotalRecs = $persewaan_lapangan_2D_detail_grid->Recordset->RecordCount();
	}
	$persewaan_lapangan_2D_detail_grid->StartRec = 1;
	$persewaan_lapangan_2D_detail_grid->DisplayRecs = $persewaan_lapangan_2D_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$persewaan_lapangan_2D_detail_grid->Recordset = $persewaan_lapangan_2D_detail_grid->LoadRecordset($persewaan_lapangan_2D_detail_grid->StartRec-1, $persewaan_lapangan_2D_detail_grid->DisplayRecs);
}
$persewaan_lapangan_2D_detail_grid->RenderOtherOptions();
?>
<?php $persewaan_lapangan_2D_detail_grid->ShowPageHeader(); ?>
<?php
$persewaan_lapangan_2D_detail_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fpersewaan_lapangan_2D_detailgrid" class="ewForm form-horizontal">
<div id="gmp_persewaan_lapangan_2D_detail" class="ewGridMiddlePanel">
<table id="tbl_persewaan_lapangan_2D_detailgrid" class="ewTable ewTableSeparate">
<?php echo $persewaan_lapangan_2D_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$persewaan_lapangan_2D_detail_grid->RenderListOptions();

// Render list options (header, left)
$persewaan_lapangan_2D_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($persewaan_lapangan_2D_detail->Kode->Visible) { // Kode ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->Kode) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_Kode" class="persewaan_lapangan_2D_detail_Kode"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->Kode->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_persewaan_lapangan_2D_detail_Kode" class="persewaan_lapangan_2D_detail_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->NamaLapangan->Visible) { // NamaLapangan ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->NamaLapangan) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_NamaLapangan" class="persewaan_lapangan_2D_detail_NamaLapangan"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_persewaan_lapangan_2D_detail_NamaLapangan" class="persewaan_lapangan_2D_detail_NamaLapangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->NamaLapangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->NamaLapangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->TglSewa->Visible) { // TglSewa ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->TglSewa) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_TglSewa" class="persewaan_lapangan_2D_detail_TglSewa"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->TglSewa->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_persewaan_lapangan_2D_detail_TglSewa" class="persewaan_lapangan_2D_detail_TglSewa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->TglSewa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->TglSewa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->TglSewa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->JamSewa->Visible) { // JamSewa ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->JamSewa) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_JamSewa" class="persewaan_lapangan_2D_detail_JamSewa"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->JamSewa->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_persewaan_lapangan_2D_detail_JamSewa" class="persewaan_lapangan_2D_detail_JamSewa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->JamSewa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->JamSewa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->JamSewa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->HargaSewa->Visible) { // HargaSewa ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->HargaSewa) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_HargaSewa" class="persewaan_lapangan_2D_detail_HargaSewa"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->HargaSewa->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_persewaan_lapangan_2D_detail_HargaSewa" class="persewaan_lapangan_2D_detail_HargaSewa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->HargaSewa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->HargaSewa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->HargaSewa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->Hitung->Visible) { // Hitung ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->Hitung) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_Hitung" class="persewaan_lapangan_2D_detail_Hitung"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $persewaan_lapangan_2D_detail->Hitung->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_persewaan_lapangan_2D_detail_Hitung" class="persewaan_lapangan_2D_detail_Hitung">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->Hitung->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->Hitung->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->Hitung->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$persewaan_lapangan_2D_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$persewaan_lapangan_2D_detail_grid->StartRec = 1;
$persewaan_lapangan_2D_detail_grid->StopRec = $persewaan_lapangan_2D_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($persewaan_lapangan_2D_detail_grid->FormKeyCountName) && ($persewaan_lapangan_2D_detail->CurrentAction == "gridadd" || $persewaan_lapangan_2D_detail->CurrentAction == "gridedit" || $persewaan_lapangan_2D_detail->CurrentAction == "F")) {
		$persewaan_lapangan_2D_detail_grid->KeyCount = $objForm->GetValue($persewaan_lapangan_2D_detail_grid->FormKeyCountName);
		$persewaan_lapangan_2D_detail_grid->StopRec = $persewaan_lapangan_2D_detail_grid->StartRec + $persewaan_lapangan_2D_detail_grid->KeyCount - 1;
	}
}
$persewaan_lapangan_2D_detail_grid->RecCnt = $persewaan_lapangan_2D_detail_grid->StartRec - 1;
if ($persewaan_lapangan_2D_detail_grid->Recordset && !$persewaan_lapangan_2D_detail_grid->Recordset->EOF) {
	$persewaan_lapangan_2D_detail_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $persewaan_lapangan_2D_detail_grid->StartRec > 1)
		$persewaan_lapangan_2D_detail_grid->Recordset->Move($persewaan_lapangan_2D_detail_grid->StartRec - 1);
} elseif (!$persewaan_lapangan_2D_detail->AllowAddDeleteRow && $persewaan_lapangan_2D_detail_grid->StopRec == 0) {
	$persewaan_lapangan_2D_detail_grid->StopRec = $persewaan_lapangan_2D_detail->GridAddRowCount;
}

// Initialize aggregate
$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$persewaan_lapangan_2D_detail->ResetAttrs();
$persewaan_lapangan_2D_detail_grid->RenderRow();
if ($persewaan_lapangan_2D_detail->CurrentAction == "gridadd")
	$persewaan_lapangan_2D_detail_grid->RowIndex = 0;
if ($persewaan_lapangan_2D_detail->CurrentAction == "gridedit")
	$persewaan_lapangan_2D_detail_grid->RowIndex = 0;
while ($persewaan_lapangan_2D_detail_grid->RecCnt < $persewaan_lapangan_2D_detail_grid->StopRec) {
	$persewaan_lapangan_2D_detail_grid->RecCnt++;
	if (intval($persewaan_lapangan_2D_detail_grid->RecCnt) >= intval($persewaan_lapangan_2D_detail_grid->StartRec)) {
		$persewaan_lapangan_2D_detail_grid->RowCnt++;
		if ($persewaan_lapangan_2D_detail->CurrentAction == "gridadd" || $persewaan_lapangan_2D_detail->CurrentAction == "gridedit" || $persewaan_lapangan_2D_detail->CurrentAction == "F") {
			$persewaan_lapangan_2D_detail_grid->RowIndex++;
			$objForm->Index = $persewaan_lapangan_2D_detail_grid->RowIndex;
			if ($objForm->HasValue($persewaan_lapangan_2D_detail_grid->FormActionName))
				$persewaan_lapangan_2D_detail_grid->RowAction = strval($objForm->GetValue($persewaan_lapangan_2D_detail_grid->FormActionName));
			elseif ($persewaan_lapangan_2D_detail->CurrentAction == "gridadd")
				$persewaan_lapangan_2D_detail_grid->RowAction = "insert";
			else
				$persewaan_lapangan_2D_detail_grid->RowAction = "";
		}

		// Set up key count
		$persewaan_lapangan_2D_detail_grid->KeyCount = $persewaan_lapangan_2D_detail_grid->RowIndex;

		// Init row class and style
		$persewaan_lapangan_2D_detail->ResetAttrs();
		$persewaan_lapangan_2D_detail->CssClass = "";
		if ($persewaan_lapangan_2D_detail->CurrentAction == "gridadd") {
			if ($persewaan_lapangan_2D_detail->CurrentMode == "copy") {
				$persewaan_lapangan_2D_detail_grid->LoadRowValues($persewaan_lapangan_2D_detail_grid->Recordset); // Load row values
				$persewaan_lapangan_2D_detail_grid->SetRecordKey($persewaan_lapangan_2D_detail_grid->RowOldKey, $persewaan_lapangan_2D_detail_grid->Recordset); // Set old record key
			} else {
				$persewaan_lapangan_2D_detail_grid->LoadDefaultValues(); // Load default values
				$persewaan_lapangan_2D_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$persewaan_lapangan_2D_detail_grid->LoadRowValues($persewaan_lapangan_2D_detail_grid->Recordset); // Load row values
		}
		$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($persewaan_lapangan_2D_detail->CurrentAction == "gridadd") // Grid add
			$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($persewaan_lapangan_2D_detail->CurrentAction == "gridadd" && $persewaan_lapangan_2D_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$persewaan_lapangan_2D_detail_grid->RestoreCurrentRowFormValues($persewaan_lapangan_2D_detail_grid->RowIndex); // Restore form values
		if ($persewaan_lapangan_2D_detail->CurrentAction == "gridedit") { // Grid edit
			if ($persewaan_lapangan_2D_detail->EventCancelled) {
				$persewaan_lapangan_2D_detail_grid->RestoreCurrentRowFormValues($persewaan_lapangan_2D_detail_grid->RowIndex); // Restore form values
			}
			if ($persewaan_lapangan_2D_detail_grid->RowAction == "insert")
				$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($persewaan_lapangan_2D_detail->CurrentAction == "gridedit" && ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT || $persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_ADD) && $persewaan_lapangan_2D_detail->EventCancelled) // Update failed
			$persewaan_lapangan_2D_detail_grid->RestoreCurrentRowFormValues($persewaan_lapangan_2D_detail_grid->RowIndex); // Restore form values
		if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$persewaan_lapangan_2D_detail_grid->EditRowCnt++;
		if ($persewaan_lapangan_2D_detail->CurrentAction == "F") // Confirm row
			$persewaan_lapangan_2D_detail_grid->RestoreCurrentRowFormValues($persewaan_lapangan_2D_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$persewaan_lapangan_2D_detail->RowAttrs = array_merge($persewaan_lapangan_2D_detail->RowAttrs, array('data-rowindex'=>$persewaan_lapangan_2D_detail_grid->RowCnt, 'id'=>'r' . $persewaan_lapangan_2D_detail_grid->RowCnt . '_persewaan_lapangan_2D_detail', 'data-rowtype'=>$persewaan_lapangan_2D_detail->RowType));

		// Render row
		$persewaan_lapangan_2D_detail_grid->RenderRow();

		// Render list options
		$persewaan_lapangan_2D_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($persewaan_lapangan_2D_detail_grid->RowAction <> "delete" && $persewaan_lapangan_2D_detail_grid->RowAction <> "insertdelete" && !($persewaan_lapangan_2D_detail_grid->RowAction == "insert" && $persewaan_lapangan_2D_detail->CurrentAction == "F" && $persewaan_lapangan_2D_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $persewaan_lapangan_2D_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$persewaan_lapangan_2D_detail_grid->ListOptions->Render("body", "left", $persewaan_lapangan_2D_detail_grid->RowCnt);
?>
	<?php if ($persewaan_lapangan_2D_detail->Kode->Visible) { // Kode ?>
		<td<?php echo $persewaan_lapangan_2D_detail->Kode->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_grid->RowCnt ?>_persewaan_lapangan_2D_detail_Kode" class="control-group persewaan_lapangan_2D_detail_Kode">
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php $persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode"<?php echo $persewaan_lapangan_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_detail->Kode->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$persewaan_lapangan_2D_detail->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $persewaan_lapangan_2D_detail->Kode->OldValue = "";
?>
</select>
<script type="text/javascript">
fpersewaan_lapangan_2D_detailgrid.Lists["x_Kode"].Options = <?php echo (is_array($persewaan_lapangan_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($persewaan_lapangan_2D_detail->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `NamaLapangan` AS FIELD0 FROM `daftar lapangan`";
 $sWhereWrk = "(`Kode` = '{query_value}')";

 // Call Lookup selecting
 $persewaan_lapangan_2D_detail->Lookup_Selecting($persewaan_lapangan_2D_detail->Kode, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="sf_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="ln_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan">
<input type="hidden" data-field="x_Kode" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Kode->OldValue) ?>">
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode"<?php echo $persewaan_lapangan_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_detail->Kode->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$persewaan_lapangan_2D_detail->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $persewaan_lapangan_2D_detail->Kode->OldValue = "";
?>
</select>
<script type="text/javascript">
fpersewaan_lapangan_2D_detailgrid.Lists["x_Kode"].Options = <?php echo (is_array($persewaan_lapangan_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($persewaan_lapangan_2D_detail->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `NamaLapangan` AS FIELD0 FROM `daftar lapangan`";
 $sWhereWrk = "(`Kode` = '{query_value}')";

 // Call Lookup selecting
 $persewaan_lapangan_2D_detail->Lookup_Selecting($persewaan_lapangan_2D_detail->Kode, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="sf_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="ln_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan">
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $persewaan_lapangan_2D_detail->Kode->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->Kode->ListViewValue() ?></span>
<input type="hidden" data-field="x_Kode" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Kode->FormValue) ?>">
<input type="hidden" data-field="x_Kode" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Kode->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_grid->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_ID" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->ID->CurrentValue) ?>">
<input type="hidden" data-field="x_ID" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_ID" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->ID->OldValue) ?>">
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT || $persewaan_lapangan_2D_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_ID" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->NamaLapangan->Visible) { // NamaLapangan ?>
		<td<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_grid->RowCnt ?>_persewaan_lapangan_2D_detail_NamaLapangan" class="control-group persewaan_lapangan_2D_detail_NamaLapangan">
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_NamaLapangan" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" size="30" maxlength="100" placeholder="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditAttributes() ?>>
<input type="hidden" data-field="x_NamaLapangan" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->NamaLapangan->OldValue) ?>">
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_NamaLapangan" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" size="30" maxlength="100" placeholder="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditAttributes() ?>>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ListViewValue() ?></span>
<input type="hidden" data-field="x_NamaLapangan" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->NamaLapangan->FormValue) ?>">
<input type="hidden" data-field="x_NamaLapangan" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->NamaLapangan->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_grid->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->TglSewa->Visible) { // TglSewa ?>
		<td<?php echo $persewaan_lapangan_2D_detail->TglSewa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_grid->RowCnt ?>_persewaan_lapangan_2D_detail_TglSewa" class="control-group persewaan_lapangan_2D_detail_TglSewa">
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_TglSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" size="30" maxlength="50" placeholder="<?php echo $persewaan_lapangan_2D_detail->TglSewa->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditAttributes() ?>>
<?php if (!$persewaan_lapangan_2D_detail->TglSewa->ReadOnly && !$persewaan_lapangan_2D_detail->TglSewa->Disabled && @$persewaan_lapangan_2D_detail->TglSewa->EditAttrs["readonly"] == "" && @$persewaan_lapangan_2D_detail->TglSewa->EditAttrs["disabled"] == "") { ?>
<button id="cal_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" name="cal_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fpersewaan_lapangan_2D_detailgrid", "x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa", "%d/%m/%Y");
</script>
<?php } ?>
<input type="hidden" data-field="x_TglSewa" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->TglSewa->OldValue) ?>">
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_TglSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" size="30" maxlength="50" placeholder="<?php echo $persewaan_lapangan_2D_detail->TglSewa->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditAttributes() ?>>
<?php if (!$persewaan_lapangan_2D_detail->TglSewa->ReadOnly && !$persewaan_lapangan_2D_detail->TglSewa->Disabled && @$persewaan_lapangan_2D_detail->TglSewa->EditAttrs["readonly"] == "" && @$persewaan_lapangan_2D_detail->TglSewa->EditAttrs["disabled"] == "") { ?>
<button id="cal_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" name="cal_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fpersewaan_lapangan_2D_detailgrid", "x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa", "%d/%m/%Y");
</script>
<?php } ?>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $persewaan_lapangan_2D_detail->TglSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->TglSewa->ListViewValue() ?></span>
<input type="hidden" data-field="x_TglSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->TglSewa->FormValue) ?>">
<input type="hidden" data-field="x_TglSewa" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->TglSewa->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_grid->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->JamSewa->Visible) { // JamSewa ?>
		<td<?php echo $persewaan_lapangan_2D_detail->JamSewa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_grid->RowCnt ?>_persewaan_lapangan_2D_detail_JamSewa" class="control-group persewaan_lapangan_2D_detail_JamSewa">
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select data-field="x_JamSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa"<?php echo $persewaan_lapangan_2D_detail->JamSewa->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_detail->JamSewa->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_detail->JamSewa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_detail->JamSewa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $persewaan_lapangan_2D_detail->JamSewa->OldValue = "";
?>
</select>
<input type="hidden" data-field="x_JamSewa" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->JamSewa->OldValue) ?>">
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select data-field="x_JamSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa"<?php echo $persewaan_lapangan_2D_detail->JamSewa->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_detail->JamSewa->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_detail->JamSewa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_detail->JamSewa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $persewaan_lapangan_2D_detail->JamSewa->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $persewaan_lapangan_2D_detail->JamSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->JamSewa->ListViewValue() ?></span>
<input type="hidden" data-field="x_JamSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->JamSewa->FormValue) ?>">
<input type="hidden" data-field="x_JamSewa" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->JamSewa->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_grid->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->HargaSewa->Visible) { // HargaSewa ?>
		<td<?php echo $persewaan_lapangan_2D_detail->HargaSewa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_grid->RowCnt ?>_persewaan_lapangan_2D_detail_HargaSewa" class="control-group persewaan_lapangan_2D_detail_HargaSewa">
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_HargaSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" size="30" placeholder="<?php echo $persewaan_lapangan_2D_detail->HargaSewa->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->HargaSewa->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->HargaSewa->EditAttributes() ?>>
<input type="hidden" data-field="x_HargaSewa" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->HargaSewa->OldValue) ?>">
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_HargaSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" size="30" placeholder="<?php echo $persewaan_lapangan_2D_detail->HargaSewa->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->HargaSewa->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->HargaSewa->EditAttributes() ?>>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ListViewValue() ?></span>
<input type="hidden" data-field="x_HargaSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->HargaSewa->FormValue) ?>">
<input type="hidden" data-field="x_HargaSewa" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->HargaSewa->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_grid->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->Hitung->Visible) { // Hitung ?>
		<td<?php echo $persewaan_lapangan_2D_detail->Hitung->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_grid->RowCnt ?>_persewaan_lapangan_2D_detail_Hitung" class="control-group persewaan_lapangan_2D_detail_Hitung">
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Hitung" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" size="30" maxlength="50" placeholder="<?php echo $persewaan_lapangan_2D_detail->Hitung->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->Hitung->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->Hitung->EditAttributes() ?>>
<input type="hidden" data-field="x_Hitung" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Hitung->OldValue) ?>">
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Hitung" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" size="30" maxlength="50" placeholder="<?php echo $persewaan_lapangan_2D_detail->Hitung->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->Hitung->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->Hitung->EditAttributes() ?>>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $persewaan_lapangan_2D_detail->Hitung->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($persewaan_lapangan_2D_detail->Hitung->ListViewValue()) && $persewaan_lapangan_2D_detail->Hitung->LinkAttributes() <> "") { ?>
<a<?php echo $persewaan_lapangan_2D_detail->Hitung->LinkAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->Hitung->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $persewaan_lapangan_2D_detail->Hitung->ListViewValue() ?>
<?php } ?>
</span>
<input type="hidden" data-field="x_Hitung" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Hitung->FormValue) ?>">
<input type="hidden" data-field="x_Hitung" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Hitung->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_grid->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$persewaan_lapangan_2D_detail_grid->ListOptions->Render("body", "right", $persewaan_lapangan_2D_detail_grid->RowCnt);
?>
	</tr>
<?php if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_ADD || $persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpersewaan_lapangan_2D_detailgrid.UpdateOpts(<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($persewaan_lapangan_2D_detail->CurrentAction <> "gridadd" || $persewaan_lapangan_2D_detail->CurrentMode == "copy")
		if (!$persewaan_lapangan_2D_detail_grid->Recordset->EOF) $persewaan_lapangan_2D_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($persewaan_lapangan_2D_detail->CurrentMode == "add" || $persewaan_lapangan_2D_detail->CurrentMode == "copy" || $persewaan_lapangan_2D_detail->CurrentMode == "edit") {
		$persewaan_lapangan_2D_detail_grid->RowIndex = '$rowindex$';
		$persewaan_lapangan_2D_detail_grid->LoadDefaultValues();

		// Set row properties
		$persewaan_lapangan_2D_detail->ResetAttrs();
		$persewaan_lapangan_2D_detail->RowAttrs = array_merge($persewaan_lapangan_2D_detail->RowAttrs, array('data-rowindex'=>$persewaan_lapangan_2D_detail_grid->RowIndex, 'id'=>'r0_persewaan_lapangan_2D_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($persewaan_lapangan_2D_detail->RowAttrs["class"], "ewTemplate");
		$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$persewaan_lapangan_2D_detail_grid->RenderRow();

		// Render list options
		$persewaan_lapangan_2D_detail_grid->RenderListOptions();
		$persewaan_lapangan_2D_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $persewaan_lapangan_2D_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$persewaan_lapangan_2D_detail_grid->ListOptions->Render("body", "left", $persewaan_lapangan_2D_detail_grid->RowIndex);
?>
	<?php if ($persewaan_lapangan_2D_detail->Kode->Visible) { // Kode ?>
		<td><span id="el$rowindex$_persewaan_lapangan_2D_detail_Kode" class="control-group persewaan_lapangan_2D_detail_Kode">
<?php if ($persewaan_lapangan_2D_detail->CurrentAction <> "F") { ?>
<?php $persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode"<?php echo $persewaan_lapangan_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_detail->Kode->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$persewaan_lapangan_2D_detail->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $persewaan_lapangan_2D_detail->Kode->OldValue = "";
?>
</select>
<script type="text/javascript">
fpersewaan_lapangan_2D_detailgrid.Lists["x_Kode"].Options = <?php echo (is_array($persewaan_lapangan_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($persewaan_lapangan_2D_detail->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `NamaLapangan` AS FIELD0 FROM `daftar lapangan`";
 $sWhereWrk = "(`Kode` = '{query_value}')";

 // Call Lookup selecting
 $persewaan_lapangan_2D_detail->Lookup_Selecting($persewaan_lapangan_2D_detail->Kode, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="sf_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="ln_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan">
<?php } else { ?>
<span<?php echo $persewaan_lapangan_2D_detail->Kode->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->Kode->ViewValue ?></span>
<input type="hidden" data-field="x_Kode" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Kode" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Kode->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->NamaLapangan->Visible) { // NamaLapangan ?>
		<td><span id="el$rowindex$_persewaan_lapangan_2D_detail_NamaLapangan" class="control-group persewaan_lapangan_2D_detail_NamaLapangan">
<?php if ($persewaan_lapangan_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_NamaLapangan" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" size="30" maxlength="100" placeholder="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ViewValue ?></span>
<input type="hidden" data-field="x_NamaLapangan" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->NamaLapangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_NamaLapangan" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_NamaLapangan" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->NamaLapangan->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->TglSewa->Visible) { // TglSewa ?>
		<td><span id="el$rowindex$_persewaan_lapangan_2D_detail_TglSewa" class="control-group persewaan_lapangan_2D_detail_TglSewa">
<?php if ($persewaan_lapangan_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_TglSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" size="30" maxlength="50" placeholder="<?php echo $persewaan_lapangan_2D_detail->TglSewa->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditAttributes() ?>>
<?php if (!$persewaan_lapangan_2D_detail->TglSewa->ReadOnly && !$persewaan_lapangan_2D_detail->TglSewa->Disabled && @$persewaan_lapangan_2D_detail->TglSewa->EditAttrs["readonly"] == "" && @$persewaan_lapangan_2D_detail->TglSewa->EditAttrs["disabled"] == "") { ?>
<button id="cal_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" name="cal_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fpersewaan_lapangan_2D_detailgrid", "x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa", "%d/%m/%Y");
</script>
<?php } ?>
<?php } else { ?>
<span<?php echo $persewaan_lapangan_2D_detail->TglSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->TglSewa->ViewValue ?></span>
<input type="hidden" data-field="x_TglSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->TglSewa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_TglSewa" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_TglSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->TglSewa->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->JamSewa->Visible) { // JamSewa ?>
		<td><span id="el$rowindex$_persewaan_lapangan_2D_detail_JamSewa" class="control-group persewaan_lapangan_2D_detail_JamSewa">
<?php if ($persewaan_lapangan_2D_detail->CurrentAction <> "F") { ?>
<select data-field="x_JamSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa"<?php echo $persewaan_lapangan_2D_detail->JamSewa->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_detail->JamSewa->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_detail->JamSewa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_detail->JamSewa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $persewaan_lapangan_2D_detail->JamSewa->OldValue = "";
?>
</select>
<?php } else { ?>
<span<?php echo $persewaan_lapangan_2D_detail->JamSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->JamSewa->ViewValue ?></span>
<input type="hidden" data-field="x_JamSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->JamSewa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_JamSewa" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_JamSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->JamSewa->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->HargaSewa->Visible) { // HargaSewa ?>
		<td><span id="el$rowindex$_persewaan_lapangan_2D_detail_HargaSewa" class="control-group persewaan_lapangan_2D_detail_HargaSewa">
<?php if ($persewaan_lapangan_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_HargaSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" size="30" placeholder="<?php echo $persewaan_lapangan_2D_detail->HargaSewa->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->HargaSewa->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->HargaSewa->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ViewValue ?></span>
<input type="hidden" data-field="x_HargaSewa" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->HargaSewa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_HargaSewa" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_HargaSewa" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->HargaSewa->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->Hitung->Visible) { // Hitung ?>
		<td><span id="el$rowindex$_persewaan_lapangan_2D_detail_Hitung" class="control-group persewaan_lapangan_2D_detail_Hitung">
<?php if ($persewaan_lapangan_2D_detail->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Hitung" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" size="30" maxlength="50" placeholder="<?php echo $persewaan_lapangan_2D_detail->Hitung->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->Hitung->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->Hitung->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $persewaan_lapangan_2D_detail->Hitung->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($persewaan_lapangan_2D_detail->Hitung->ViewValue) && $persewaan_lapangan_2D_detail->Hitung->LinkAttributes() <> "") { ?>
<a<?php echo $persewaan_lapangan_2D_detail->Hitung->LinkAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->Hitung->ViewValue ?></a>
<?php } else { ?>
<?php echo $persewaan_lapangan_2D_detail->Hitung->ViewValue ?>
<?php } ?>
</span>
<input type="hidden" data-field="x_Hitung" name="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" id="x<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Hitung->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Hitung" name="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" id="o<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>_Hitung" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->Hitung->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$persewaan_lapangan_2D_detail_grid->ListOptions->Render("body", "right", $persewaan_lapangan_2D_detail_grid->RowCnt);
?>
<script type="text/javascript">
fpersewaan_lapangan_2D_detailgrid.UpdateOpts(<?php echo $persewaan_lapangan_2D_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($persewaan_lapangan_2D_detail->CurrentMode == "add" || $persewaan_lapangan_2D_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $persewaan_lapangan_2D_detail_grid->FormKeyCountName ?>" id="<?php echo $persewaan_lapangan_2D_detail_grid->FormKeyCountName ?>" value="<?php echo $persewaan_lapangan_2D_detail_grid->KeyCount ?>">
<?php echo $persewaan_lapangan_2D_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $persewaan_lapangan_2D_detail_grid->FormKeyCountName ?>" id="<?php echo $persewaan_lapangan_2D_detail_grid->FormKeyCountName ?>" value="<?php echo $persewaan_lapangan_2D_detail_grid->KeyCount ?>">
<?php echo $persewaan_lapangan_2D_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpersewaan_lapangan_2D_detailgrid">
</div>
<?php

// Close recordset
if ($persewaan_lapangan_2D_detail_grid->Recordset)
	$persewaan_lapangan_2D_detail_grid->Recordset->Close();
?>
<?php if ($persewaan_lapangan_2D_detail_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($persewaan_lapangan_2D_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<script type="text/javascript">
fpersewaan_lapangan_2D_detailgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$persewaan_lapangan_2D_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$persewaan_lapangan_2D_detail_grid->Page_Terminate();
?>

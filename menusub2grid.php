<?php include_once "_2padmininfo.php" ?>
<?php

// Create page object
if (!isset($menusub2_grid)) $menusub2_grid = new cmenusub2_grid();

// Page init
$menusub2_grid->Page_Init();

// Page main
$menusub2_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$menusub2_grid->Page_Render();
?>
<?php if ($menusub2->Export == "") { ?>
<script type="text/javascript">

// Page object
var menusub2_grid = new ew_Page("menusub2_grid");
menusub2_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = menusub2_grid.PageID; // For backward compatibility

// Form object
var fmenusub2grid = new ew_Form("fmenusub2grid");
fmenusub2grid.FormKeyCountName = '<?php echo $menusub2_grid->FormKeyCountName ?>';

// Validate form
fmenusub2grid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "__Menu");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub2->_Menu->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Link");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub2->Link->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Parent");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub2->Parent->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_No");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub2->No->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_No");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($menusub2->No->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Akses[]");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub2->Akses->FldCaption()) ?>");

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
fmenusub2grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "_Menu", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Link", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Parent", false)) return false;
	if (ew_ValueChanged(fobj, infix, "No", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Akses[]", false)) return false;
	return true;
}

// Form_CustomValidate event
fmenusub2grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmenusub2grid.ValidateRequired = true;
<?php } else { ?>
fmenusub2grid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($menusub2->getCurrentMasterTable() == "" && $menusub2_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $menusub2_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($menusub2->CurrentAction == "gridadd") {
	if ($menusub2->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$menusub2_grid->TotalRecs = $menusub2->SelectRecordCount();
			$menusub2_grid->Recordset = $menusub2_grid->LoadRecordset($menusub2_grid->StartRec-1, $menusub2_grid->DisplayRecs);
		} else {
			if ($menusub2_grid->Recordset = $menusub2_grid->LoadRecordset())
				$menusub2_grid->TotalRecs = $menusub2_grid->Recordset->RecordCount();
		}
		$menusub2_grid->StartRec = 1;
		$menusub2_grid->DisplayRecs = $menusub2_grid->TotalRecs;
	} else {
		$menusub2->CurrentFilter = "0=1";
		$menusub2_grid->StartRec = 1;
		$menusub2_grid->DisplayRecs = $menusub2->GridAddRowCount;
	}
	$menusub2_grid->TotalRecs = $menusub2_grid->DisplayRecs;
	$menusub2_grid->StopRec = $menusub2_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$menusub2_grid->TotalRecs = $menusub2->SelectRecordCount();
	} else {
		if ($menusub2_grid->Recordset = $menusub2_grid->LoadRecordset())
			$menusub2_grid->TotalRecs = $menusub2_grid->Recordset->RecordCount();
	}
	$menusub2_grid->StartRec = 1;
	$menusub2_grid->DisplayRecs = $menusub2_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$menusub2_grid->Recordset = $menusub2_grid->LoadRecordset($menusub2_grid->StartRec-1, $menusub2_grid->DisplayRecs);
}
$menusub2_grid->RenderOtherOptions();
?>
<?php $menusub2_grid->ShowPageHeader(); ?>
<?php
$menusub2_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fmenusub2grid" class="ewForm form-horizontal">
<div id="gmp_menusub2" class="ewGridMiddlePanel">
<table id="tbl_menusub2grid" class="ewTable ewTableSeparate">
<?php echo $menusub2->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$menusub2_grid->RenderListOptions();

// Render list options (header, left)
$menusub2_grid->ListOptions->Render("header", "left");
?>
<?php if ($menusub2->ID->Visible) { // ID ?>
	<?php if ($menusub2->SortUrl($menusub2->ID) == "") { ?>
		<td><div id="elh_menusub2_ID" class="menusub2_ID"><div class="ewTableHeaderCaption"><?php echo $menusub2->ID->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub2_ID" class="menusub2_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub2->ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub2->ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub2->ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($menusub2->_Menu->Visible) { // Menu ?>
	<?php if ($menusub2->SortUrl($menusub2->_Menu) == "") { ?>
		<td><div id="elh_menusub2__Menu" class="menusub2__Menu"><div class="ewTableHeaderCaption"><?php echo $menusub2->_Menu->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub2__Menu" class="menusub2__Menu">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub2->_Menu->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub2->_Menu->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub2->_Menu->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($menusub2->Link->Visible) { // Link ?>
	<?php if ($menusub2->SortUrl($menusub2->Link) == "") { ?>
		<td><div id="elh_menusub2_Link" class="menusub2_Link"><div class="ewTableHeaderCaption"><?php echo $menusub2->Link->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub2_Link" class="menusub2_Link">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub2->Link->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub2->Link->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub2->Link->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($menusub2->Parent->Visible) { // Parent ?>
	<?php if ($menusub2->SortUrl($menusub2->Parent) == "") { ?>
		<td><div id="elh_menusub2_Parent" class="menusub2_Parent"><div class="ewTableHeaderCaption"><?php echo $menusub2->Parent->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub2_Parent" class="menusub2_Parent">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub2->Parent->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub2->Parent->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub2->Parent->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($menusub2->No->Visible) { // No ?>
	<?php if ($menusub2->SortUrl($menusub2->No) == "") { ?>
		<td><div id="elh_menusub2_No" class="menusub2_No"><div class="ewTableHeaderCaption"><?php echo $menusub2->No->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub2_No" class="menusub2_No">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub2->No->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub2->No->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub2->No->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($menusub2->Akses->Visible) { // Akses ?>
	<?php if ($menusub2->SortUrl($menusub2->Akses) == "") { ?>
		<td><div id="elh_menusub2_Akses" class="menusub2_Akses"><div class="ewTableHeaderCaption"><?php echo $menusub2->Akses->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub2_Akses" class="menusub2_Akses">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub2->Akses->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub2->Akses->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub2->Akses->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$menusub2_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$menusub2_grid->StartRec = 1;
$menusub2_grid->StopRec = $menusub2_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($menusub2_grid->FormKeyCountName) && ($menusub2->CurrentAction == "gridadd" || $menusub2->CurrentAction == "gridedit" || $menusub2->CurrentAction == "F")) {
		$menusub2_grid->KeyCount = $objForm->GetValue($menusub2_grid->FormKeyCountName);
		$menusub2_grid->StopRec = $menusub2_grid->StartRec + $menusub2_grid->KeyCount - 1;
	}
}
$menusub2_grid->RecCnt = $menusub2_grid->StartRec - 1;
if ($menusub2_grid->Recordset && !$menusub2_grid->Recordset->EOF) {
	$menusub2_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $menusub2_grid->StartRec > 1)
		$menusub2_grid->Recordset->Move($menusub2_grid->StartRec - 1);
} elseif (!$menusub2->AllowAddDeleteRow && $menusub2_grid->StopRec == 0) {
	$menusub2_grid->StopRec = $menusub2->GridAddRowCount;
}

// Initialize aggregate
$menusub2->RowType = EW_ROWTYPE_AGGREGATEINIT;
$menusub2->ResetAttrs();
$menusub2_grid->RenderRow();
if ($menusub2->CurrentAction == "gridadd")
	$menusub2_grid->RowIndex = 0;
if ($menusub2->CurrentAction == "gridedit")
	$menusub2_grid->RowIndex = 0;
while ($menusub2_grid->RecCnt < $menusub2_grid->StopRec) {
	$menusub2_grid->RecCnt++;
	if (intval($menusub2_grid->RecCnt) >= intval($menusub2_grid->StartRec)) {
		$menusub2_grid->RowCnt++;
		if ($menusub2->CurrentAction == "gridadd" || $menusub2->CurrentAction == "gridedit" || $menusub2->CurrentAction == "F") {
			$menusub2_grid->RowIndex++;
			$objForm->Index = $menusub2_grid->RowIndex;
			if ($objForm->HasValue($menusub2_grid->FormActionName))
				$menusub2_grid->RowAction = strval($objForm->GetValue($menusub2_grid->FormActionName));
			elseif ($menusub2->CurrentAction == "gridadd")
				$menusub2_grid->RowAction = "insert";
			else
				$menusub2_grid->RowAction = "";
		}

		// Set up key count
		$menusub2_grid->KeyCount = $menusub2_grid->RowIndex;

		// Init row class and style
		$menusub2->ResetAttrs();
		$menusub2->CssClass = "";
		if ($menusub2->CurrentAction == "gridadd") {
			if ($menusub2->CurrentMode == "copy") {
				$menusub2_grid->LoadRowValues($menusub2_grid->Recordset); // Load row values
				$menusub2_grid->SetRecordKey($menusub2_grid->RowOldKey, $menusub2_grid->Recordset); // Set old record key
			} else {
				$menusub2_grid->LoadDefaultValues(); // Load default values
				$menusub2_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$menusub2_grid->LoadRowValues($menusub2_grid->Recordset); // Load row values
		}
		$menusub2->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($menusub2->CurrentAction == "gridadd") // Grid add
			$menusub2->RowType = EW_ROWTYPE_ADD; // Render add
		if ($menusub2->CurrentAction == "gridadd" && $menusub2->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$menusub2_grid->RestoreCurrentRowFormValues($menusub2_grid->RowIndex); // Restore form values
		if ($menusub2->CurrentAction == "gridedit") { // Grid edit
			if ($menusub2->EventCancelled) {
				$menusub2_grid->RestoreCurrentRowFormValues($menusub2_grid->RowIndex); // Restore form values
			}
			if ($menusub2_grid->RowAction == "insert")
				$menusub2->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$menusub2->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($menusub2->CurrentAction == "gridedit" && ($menusub2->RowType == EW_ROWTYPE_EDIT || $menusub2->RowType == EW_ROWTYPE_ADD) && $menusub2->EventCancelled) // Update failed
			$menusub2_grid->RestoreCurrentRowFormValues($menusub2_grid->RowIndex); // Restore form values
		if ($menusub2->RowType == EW_ROWTYPE_EDIT) // Edit row
			$menusub2_grid->EditRowCnt++;
		if ($menusub2->CurrentAction == "F") // Confirm row
			$menusub2_grid->RestoreCurrentRowFormValues($menusub2_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$menusub2->RowAttrs = array_merge($menusub2->RowAttrs, array('data-rowindex'=>$menusub2_grid->RowCnt, 'id'=>'r' . $menusub2_grid->RowCnt . '_menusub2', 'data-rowtype'=>$menusub2->RowType));

		// Render row
		$menusub2_grid->RenderRow();

		// Render list options
		$menusub2_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($menusub2_grid->RowAction <> "delete" && $menusub2_grid->RowAction <> "insertdelete" && !($menusub2_grid->RowAction == "insert" && $menusub2->CurrentAction == "F" && $menusub2_grid->EmptyRow())) {
?>
	<tr<?php echo $menusub2->RowAttributes() ?>>
<?php

// Render list options (body, left)
$menusub2_grid->ListOptions->Render("body", "left", $menusub2_grid->RowCnt);
?>
	<?php if ($menusub2->ID->Visible) { // ID ?>
		<td<?php echo $menusub2->ID->CellAttributes() ?>><span id="el<?php echo $menusub2_grid->RowCnt ?>_menusub2_ID" class="control-group menusub2_ID">
<?php if ($menusub2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_ID" name="o<?php echo $menusub2_grid->RowIndex ?>_ID" id="o<?php echo $menusub2_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($menusub2->ID->OldValue) ?>">
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $menusub2->ID->ViewAttributes() ?>>
<?php echo $menusub2->ID->EditValue ?></span>
<input type="hidden" data-field="x_ID" name="x<?php echo $menusub2_grid->RowIndex ?>_ID" id="x<?php echo $menusub2_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($menusub2->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub2->ID->ViewAttributes() ?>>
<?php echo $menusub2->ID->ListViewValue() ?></span>
<input type="hidden" data-field="x_ID" name="x<?php echo $menusub2_grid->RowIndex ?>_ID" id="x<?php echo $menusub2_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($menusub2->ID->FormValue) ?>">
<input type="hidden" data-field="x_ID" name="o<?php echo $menusub2_grid->RowIndex ?>_ID" id="o<?php echo $menusub2_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($menusub2->ID->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub2_grid->PageObjName . "_row_" . $menusub2_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($menusub2->_Menu->Visible) { // Menu ?>
		<td<?php echo $menusub2->_Menu->CellAttributes() ?>><span id="el<?php echo $menusub2_grid->RowCnt ?>_menusub2__Menu" class="control-group menusub2__Menu">
<?php if ($menusub2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x__Menu" name="x<?php echo $menusub2_grid->RowIndex ?>__Menu" id="x<?php echo $menusub2_grid->RowIndex ?>__Menu" size="30" maxlength="100" placeholder="<?php echo $menusub2->_Menu->PlaceHolder ?>" value="<?php echo $menusub2->_Menu->EditValue ?>"<?php echo $menusub2->_Menu->EditAttributes() ?>>
<input type="hidden" data-field="x__Menu" name="o<?php echo $menusub2_grid->RowIndex ?>__Menu" id="o<?php echo $menusub2_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub2->_Menu->OldValue) ?>">
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x__Menu" name="x<?php echo $menusub2_grid->RowIndex ?>__Menu" id="x<?php echo $menusub2_grid->RowIndex ?>__Menu" size="30" maxlength="100" placeholder="<?php echo $menusub2->_Menu->PlaceHolder ?>" value="<?php echo $menusub2->_Menu->EditValue ?>"<?php echo $menusub2->_Menu->EditAttributes() ?>>
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub2->_Menu->ViewAttributes() ?>>
<?php echo $menusub2->_Menu->ListViewValue() ?></span>
<input type="hidden" data-field="x__Menu" name="x<?php echo $menusub2_grid->RowIndex ?>__Menu" id="x<?php echo $menusub2_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub2->_Menu->FormValue) ?>">
<input type="hidden" data-field="x__Menu" name="o<?php echo $menusub2_grid->RowIndex ?>__Menu" id="o<?php echo $menusub2_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub2->_Menu->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub2_grid->PageObjName . "_row_" . $menusub2_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($menusub2->Link->Visible) { // Link ?>
		<td<?php echo $menusub2->Link->CellAttributes() ?>><span id="el<?php echo $menusub2_grid->RowCnt ?>_menusub2_Link" class="control-group menusub2_Link">
<?php if ($menusub2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Link" name="x<?php echo $menusub2_grid->RowIndex ?>_Link" id="x<?php echo $menusub2_grid->RowIndex ?>_Link" size="30" maxlength="255" placeholder="<?php echo $menusub2->Link->PlaceHolder ?>" value="<?php echo $menusub2->Link->EditValue ?>"<?php echo $menusub2->Link->EditAttributes() ?>>
<input type="hidden" data-field="x_Link" name="o<?php echo $menusub2_grid->RowIndex ?>_Link" id="o<?php echo $menusub2_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub2->Link->OldValue) ?>">
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Link" name="x<?php echo $menusub2_grid->RowIndex ?>_Link" id="x<?php echo $menusub2_grid->RowIndex ?>_Link" size="30" maxlength="255" placeholder="<?php echo $menusub2->Link->PlaceHolder ?>" value="<?php echo $menusub2->Link->EditValue ?>"<?php echo $menusub2->Link->EditAttributes() ?>>
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub2->Link->ViewAttributes() ?>>
<?php echo $menusub2->Link->ListViewValue() ?></span>
<input type="hidden" data-field="x_Link" name="x<?php echo $menusub2_grid->RowIndex ?>_Link" id="x<?php echo $menusub2_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub2->Link->FormValue) ?>">
<input type="hidden" data-field="x_Link" name="o<?php echo $menusub2_grid->RowIndex ?>_Link" id="o<?php echo $menusub2_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub2->Link->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub2_grid->PageObjName . "_row_" . $menusub2_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($menusub2->Parent->Visible) { // Parent ?>
		<td<?php echo $menusub2->Parent->CellAttributes() ?>><span id="el<?php echo $menusub2_grid->RowCnt ?>_menusub2_Parent" class="control-group menusub2_Parent">
<?php if ($menusub2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($menusub2->Parent->getSessionValue() <> "") { ?>
<span<?php echo $menusub2->Parent->ViewAttributes() ?>>
<?php echo $menusub2->Parent->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $menusub2_grid->RowIndex ?>_Parent" name="x<?php echo $menusub2_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub2->Parent->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Parent" name="x<?php echo $menusub2_grid->RowIndex ?>_Parent" id="x<?php echo $menusub2_grid->RowIndex ?>_Parent" size="30" maxlength="100" placeholder="<?php echo $menusub2->Parent->PlaceHolder ?>" value="<?php echo $menusub2->Parent->EditValue ?>"<?php echo $menusub2->Parent->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_Parent" name="o<?php echo $menusub2_grid->RowIndex ?>_Parent" id="o<?php echo $menusub2_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub2->Parent->OldValue) ?>">
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($menusub2->Parent->getSessionValue() <> "") { ?>
<span<?php echo $menusub2->Parent->ViewAttributes() ?>>
<?php echo $menusub2->Parent->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $menusub2_grid->RowIndex ?>_Parent" name="x<?php echo $menusub2_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub2->Parent->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Parent" name="x<?php echo $menusub2_grid->RowIndex ?>_Parent" id="x<?php echo $menusub2_grid->RowIndex ?>_Parent" size="30" maxlength="100" placeholder="<?php echo $menusub2->Parent->PlaceHolder ?>" value="<?php echo $menusub2->Parent->EditValue ?>"<?php echo $menusub2->Parent->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub2->Parent->ViewAttributes() ?>>
<?php echo $menusub2->Parent->ListViewValue() ?></span>
<input type="hidden" data-field="x_Parent" name="x<?php echo $menusub2_grid->RowIndex ?>_Parent" id="x<?php echo $menusub2_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub2->Parent->FormValue) ?>">
<input type="hidden" data-field="x_Parent" name="o<?php echo $menusub2_grid->RowIndex ?>_Parent" id="o<?php echo $menusub2_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub2->Parent->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub2_grid->PageObjName . "_row_" . $menusub2_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($menusub2->No->Visible) { // No ?>
		<td<?php echo $menusub2->No->CellAttributes() ?>><span id="el<?php echo $menusub2_grid->RowCnt ?>_menusub2_No" class="control-group menusub2_No">
<?php if ($menusub2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_No" name="x<?php echo $menusub2_grid->RowIndex ?>_No" id="x<?php echo $menusub2_grid->RowIndex ?>_No" size="30" placeholder="<?php echo $menusub2->No->PlaceHolder ?>" value="<?php echo $menusub2->No->EditValue ?>"<?php echo $menusub2->No->EditAttributes() ?>>
<input type="hidden" data-field="x_No" name="o<?php echo $menusub2_grid->RowIndex ?>_No" id="o<?php echo $menusub2_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub2->No->OldValue) ?>">
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_No" name="x<?php echo $menusub2_grid->RowIndex ?>_No" id="x<?php echo $menusub2_grid->RowIndex ?>_No" size="30" placeholder="<?php echo $menusub2->No->PlaceHolder ?>" value="<?php echo $menusub2->No->EditValue ?>"<?php echo $menusub2->No->EditAttributes() ?>>
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub2->No->ViewAttributes() ?>>
<?php echo $menusub2->No->ListViewValue() ?></span>
<input type="hidden" data-field="x_No" name="x<?php echo $menusub2_grid->RowIndex ?>_No" id="x<?php echo $menusub2_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub2->No->FormValue) ?>">
<input type="hidden" data-field="x_No" name="o<?php echo $menusub2_grid->RowIndex ?>_No" id="o<?php echo $menusub2_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub2->No->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub2_grid->PageObjName . "_row_" . $menusub2_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($menusub2->Akses->Visible) { // Akses ?>
		<td<?php echo $menusub2->Akses->CellAttributes() ?>><span id="el<?php echo $menusub2_grid->RowCnt ?>_menusub2_Akses" class="control-group menusub2_Akses">
<?php if ($menusub2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select data-field="x_Akses" id="x<?php echo $menusub2_grid->RowIndex ?>_Akses[]" name="x<?php echo $menusub2_grid->RowIndex ?>_Akses[]" multiple="multiple"<?php echo $menusub2->Akses->EditAttributes() ?>>
<?php
if (is_array($menusub2->Akses->EditValue)) {
	$arwrk = $menusub2->Akses->EditValue;
	$armultiwrk= explode(",", strval($menusub2->Akses->CurrentValue));
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = "";
		$cnt = count($armultiwrk);
		for ($ari = 0; $ari < $cnt; $ari++) {
			if (strval($arwrk[$rowcntwrk][0]) == trim(strval($armultiwrk[$ari]))) {
				$selwrk = " selected=\"selected\"";
				if ($selwrk <> "") $emptywrk = FALSE;
				break;
			}
		}	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $menusub2->Akses->OldValue = "";
?>
</select>
<input type="hidden" data-field="x_Akses" name="o<?php echo $menusub2_grid->RowIndex ?>_Akses[]" id="o<?php echo $menusub2_grid->RowIndex ?>_Akses[]" value="<?php echo ew_HtmlEncode($menusub2->Akses->OldValue) ?>">
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select data-field="x_Akses" id="x<?php echo $menusub2_grid->RowIndex ?>_Akses[]" name="x<?php echo $menusub2_grid->RowIndex ?>_Akses[]" multiple="multiple"<?php echo $menusub2->Akses->EditAttributes() ?>>
<?php
if (is_array($menusub2->Akses->EditValue)) {
	$arwrk = $menusub2->Akses->EditValue;
	$armultiwrk= explode(",", strval($menusub2->Akses->CurrentValue));
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = "";
		$cnt = count($armultiwrk);
		for ($ari = 0; $ari < $cnt; $ari++) {
			if (strval($arwrk[$rowcntwrk][0]) == trim(strval($armultiwrk[$ari]))) {
				$selwrk = " selected=\"selected\"";
				if ($selwrk <> "") $emptywrk = FALSE;
				break;
			}
		}	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $menusub2->Akses->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($menusub2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub2->Akses->ViewAttributes() ?>>
<?php echo $menusub2->Akses->ListViewValue() ?></span>
<input type="hidden" data-field="x_Akses" name="x<?php echo $menusub2_grid->RowIndex ?>_Akses" id="x<?php echo $menusub2_grid->RowIndex ?>_Akses" value="<?php echo ew_HtmlEncode($menusub2->Akses->FormValue) ?>">
<input type="hidden" data-field="x_Akses" name="o<?php echo $menusub2_grid->RowIndex ?>_Akses[]" id="o<?php echo $menusub2_grid->RowIndex ?>_Akses[]" value="<?php echo ew_HtmlEncode($menusub2->Akses->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub2_grid->PageObjName . "_row_" . $menusub2_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$menusub2_grid->ListOptions->Render("body", "right", $menusub2_grid->RowCnt);
?>
	</tr>
<?php if ($menusub2->RowType == EW_ROWTYPE_ADD || $menusub2->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmenusub2grid.UpdateOpts(<?php echo $menusub2_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($menusub2->CurrentAction <> "gridadd" || $menusub2->CurrentMode == "copy")
		if (!$menusub2_grid->Recordset->EOF) $menusub2_grid->Recordset->MoveNext();
}
?>
<?php
	if ($menusub2->CurrentMode == "add" || $menusub2->CurrentMode == "copy" || $menusub2->CurrentMode == "edit") {
		$menusub2_grid->RowIndex = '$rowindex$';
		$menusub2_grid->LoadDefaultValues();

		// Set row properties
		$menusub2->ResetAttrs();
		$menusub2->RowAttrs = array_merge($menusub2->RowAttrs, array('data-rowindex'=>$menusub2_grid->RowIndex, 'id'=>'r0_menusub2', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($menusub2->RowAttrs["class"], "ewTemplate");
		$menusub2->RowType = EW_ROWTYPE_ADD;

		// Render row
		$menusub2_grid->RenderRow();

		// Render list options
		$menusub2_grid->RenderListOptions();
		$menusub2_grid->StartRowCnt = 0;
?>
	<tr<?php echo $menusub2->RowAttributes() ?>>
<?php

// Render list options (body, left)
$menusub2_grid->ListOptions->Render("body", "left", $menusub2_grid->RowIndex);
?>
	<?php if ($menusub2->ID->Visible) { // ID ?>
		<td><span id="el$rowindex$_menusub2_ID" class="control-group menusub2_ID">
<?php if ($menusub2->CurrentAction <> "F") { ?>
<?php } else { ?>
<span<?php echo $menusub2->ID->ViewAttributes() ?>>
<?php echo $menusub2->ID->ViewValue ?></span>
<input type="hidden" data-field="x_ID" name="x<?php echo $menusub2_grid->RowIndex ?>_ID" id="x<?php echo $menusub2_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($menusub2->ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_ID" name="o<?php echo $menusub2_grid->RowIndex ?>_ID" id="o<?php echo $menusub2_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($menusub2->ID->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($menusub2->_Menu->Visible) { // Menu ?>
		<td><span id="el$rowindex$_menusub2__Menu" class="control-group menusub2__Menu">
<?php if ($menusub2->CurrentAction <> "F") { ?>
<input type="text" data-field="x__Menu" name="x<?php echo $menusub2_grid->RowIndex ?>__Menu" id="x<?php echo $menusub2_grid->RowIndex ?>__Menu" size="30" maxlength="100" placeholder="<?php echo $menusub2->_Menu->PlaceHolder ?>" value="<?php echo $menusub2->_Menu->EditValue ?>"<?php echo $menusub2->_Menu->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $menusub2->_Menu->ViewAttributes() ?>>
<?php echo $menusub2->_Menu->ViewValue ?></span>
<input type="hidden" data-field="x__Menu" name="x<?php echo $menusub2_grid->RowIndex ?>__Menu" id="x<?php echo $menusub2_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub2->_Menu->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__Menu" name="o<?php echo $menusub2_grid->RowIndex ?>__Menu" id="o<?php echo $menusub2_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub2->_Menu->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($menusub2->Link->Visible) { // Link ?>
		<td><span id="el$rowindex$_menusub2_Link" class="control-group menusub2_Link">
<?php if ($menusub2->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Link" name="x<?php echo $menusub2_grid->RowIndex ?>_Link" id="x<?php echo $menusub2_grid->RowIndex ?>_Link" size="30" maxlength="255" placeholder="<?php echo $menusub2->Link->PlaceHolder ?>" value="<?php echo $menusub2->Link->EditValue ?>"<?php echo $menusub2->Link->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $menusub2->Link->ViewAttributes() ?>>
<?php echo $menusub2->Link->ViewValue ?></span>
<input type="hidden" data-field="x_Link" name="x<?php echo $menusub2_grid->RowIndex ?>_Link" id="x<?php echo $menusub2_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub2->Link->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Link" name="o<?php echo $menusub2_grid->RowIndex ?>_Link" id="o<?php echo $menusub2_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub2->Link->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($menusub2->Parent->Visible) { // Parent ?>
		<td><span id="el$rowindex$_menusub2_Parent" class="control-group menusub2_Parent">
<?php if ($menusub2->CurrentAction <> "F") { ?>
<?php if ($menusub2->Parent->getSessionValue() <> "") { ?>
<span<?php echo $menusub2->Parent->ViewAttributes() ?>>
<?php echo $menusub2->Parent->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $menusub2_grid->RowIndex ?>_Parent" name="x<?php echo $menusub2_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub2->Parent->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Parent" name="x<?php echo $menusub2_grid->RowIndex ?>_Parent" id="x<?php echo $menusub2_grid->RowIndex ?>_Parent" size="30" maxlength="100" placeholder="<?php echo $menusub2->Parent->PlaceHolder ?>" value="<?php echo $menusub2->Parent->EditValue ?>"<?php echo $menusub2->Parent->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $menusub2->Parent->ViewAttributes() ?>>
<?php echo $menusub2->Parent->ViewValue ?></span>
<input type="hidden" data-field="x_Parent" name="x<?php echo $menusub2_grid->RowIndex ?>_Parent" id="x<?php echo $menusub2_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub2->Parent->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Parent" name="o<?php echo $menusub2_grid->RowIndex ?>_Parent" id="o<?php echo $menusub2_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub2->Parent->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($menusub2->No->Visible) { // No ?>
		<td><span id="el$rowindex$_menusub2_No" class="control-group menusub2_No">
<?php if ($menusub2->CurrentAction <> "F") { ?>
<input type="text" data-field="x_No" name="x<?php echo $menusub2_grid->RowIndex ?>_No" id="x<?php echo $menusub2_grid->RowIndex ?>_No" size="30" placeholder="<?php echo $menusub2->No->PlaceHolder ?>" value="<?php echo $menusub2->No->EditValue ?>"<?php echo $menusub2->No->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $menusub2->No->ViewAttributes() ?>>
<?php echo $menusub2->No->ViewValue ?></span>
<input type="hidden" data-field="x_No" name="x<?php echo $menusub2_grid->RowIndex ?>_No" id="x<?php echo $menusub2_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub2->No->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_No" name="o<?php echo $menusub2_grid->RowIndex ?>_No" id="o<?php echo $menusub2_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub2->No->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($menusub2->Akses->Visible) { // Akses ?>
		<td><span id="el$rowindex$_menusub2_Akses" class="control-group menusub2_Akses">
<?php if ($menusub2->CurrentAction <> "F") { ?>
<select data-field="x_Akses" id="x<?php echo $menusub2_grid->RowIndex ?>_Akses[]" name="x<?php echo $menusub2_grid->RowIndex ?>_Akses[]" multiple="multiple"<?php echo $menusub2->Akses->EditAttributes() ?>>
<?php
if (is_array($menusub2->Akses->EditValue)) {
	$arwrk = $menusub2->Akses->EditValue;
	$armultiwrk= explode(",", strval($menusub2->Akses->CurrentValue));
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = "";
		$cnt = count($armultiwrk);
		for ($ari = 0; $ari < $cnt; $ari++) {
			if (strval($arwrk[$rowcntwrk][0]) == trim(strval($armultiwrk[$ari]))) {
				$selwrk = " selected=\"selected\"";
				if ($selwrk <> "") $emptywrk = FALSE;
				break;
			}
		}	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $menusub2->Akses->OldValue = "";
?>
</select>
<?php } else { ?>
<span<?php echo $menusub2->Akses->ViewAttributes() ?>>
<?php echo $menusub2->Akses->ViewValue ?></span>
<input type="hidden" data-field="x_Akses" name="x<?php echo $menusub2_grid->RowIndex ?>_Akses" id="x<?php echo $menusub2_grid->RowIndex ?>_Akses" value="<?php echo ew_HtmlEncode($menusub2->Akses->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Akses" name="o<?php echo $menusub2_grid->RowIndex ?>_Akses[]" id="o<?php echo $menusub2_grid->RowIndex ?>_Akses[]" value="<?php echo ew_HtmlEncode($menusub2->Akses->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$menusub2_grid->ListOptions->Render("body", "right", $menusub2_grid->RowCnt);
?>
<script type="text/javascript">
fmenusub2grid.UpdateOpts(<?php echo $menusub2_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($menusub2->CurrentMode == "add" || $menusub2->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $menusub2_grid->FormKeyCountName ?>" id="<?php echo $menusub2_grid->FormKeyCountName ?>" value="<?php echo $menusub2_grid->KeyCount ?>">
<?php echo $menusub2_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($menusub2->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $menusub2_grid->FormKeyCountName ?>" id="<?php echo $menusub2_grid->FormKeyCountName ?>" value="<?php echo $menusub2_grid->KeyCount ?>">
<?php echo $menusub2_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($menusub2->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmenusub2grid">
</div>
<?php

// Close recordset
if ($menusub2_grid->Recordset)
	$menusub2_grid->Recordset->Close();
?>
<?php if ($menusub2_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($menusub2_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($menusub2->Export == "") { ?>
<script type="text/javascript">
fmenusub2grid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$menusub2_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$menusub2_grid->Page_Terminate();
?>

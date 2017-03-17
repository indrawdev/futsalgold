<?php include_once "_2padmininfo.php" ?>
<?php

// Create page object
if (!isset($menusub1_grid)) $menusub1_grid = new cmenusub1_grid();

// Page init
$menusub1_grid->Page_Init();

// Page main
$menusub1_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$menusub1_grid->Page_Render();
?>
<?php if ($menusub1->Export == "") { ?>
<script type="text/javascript">

// Page object
var menusub1_grid = new ew_Page("menusub1_grid");
menusub1_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = menusub1_grid.PageID; // For backward compatibility

// Form object
var fmenusub1grid = new ew_Form("fmenusub1grid");
fmenusub1grid.FormKeyCountName = '<?php echo $menusub1_grid->FormKeyCountName ?>';

// Validate form
fmenusub1grid.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->_Menu->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Link");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->Link->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Parent");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->Parent->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_No");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->No->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_No");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($menusub1->No->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Akses[]");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->Akses->FldCaption()) ?>");

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
fmenusub1grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "_Menu", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Link", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Parent", false)) return false;
	if (ew_ValueChanged(fobj, infix, "No", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Akses[]", false)) return false;
	return true;
}

// Form_CustomValidate event
fmenusub1grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmenusub1grid.ValidateRequired = true;
<?php } else { ?>
fmenusub1grid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($menusub1->getCurrentMasterTable() == "" && $menusub1_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $menusub1_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($menusub1->CurrentAction == "gridadd") {
	if ($menusub1->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$menusub1_grid->TotalRecs = $menusub1->SelectRecordCount();
			$menusub1_grid->Recordset = $menusub1_grid->LoadRecordset($menusub1_grid->StartRec-1, $menusub1_grid->DisplayRecs);
		} else {
			if ($menusub1_grid->Recordset = $menusub1_grid->LoadRecordset())
				$menusub1_grid->TotalRecs = $menusub1_grid->Recordset->RecordCount();
		}
		$menusub1_grid->StartRec = 1;
		$menusub1_grid->DisplayRecs = $menusub1_grid->TotalRecs;
	} else {
		$menusub1->CurrentFilter = "0=1";
		$menusub1_grid->StartRec = 1;
		$menusub1_grid->DisplayRecs = $menusub1->GridAddRowCount;
	}
	$menusub1_grid->TotalRecs = $menusub1_grid->DisplayRecs;
	$menusub1_grid->StopRec = $menusub1_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$menusub1_grid->TotalRecs = $menusub1->SelectRecordCount();
	} else {
		if ($menusub1_grid->Recordset = $menusub1_grid->LoadRecordset())
			$menusub1_grid->TotalRecs = $menusub1_grid->Recordset->RecordCount();
	}
	$menusub1_grid->StartRec = 1;
	$menusub1_grid->DisplayRecs = $menusub1_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$menusub1_grid->Recordset = $menusub1_grid->LoadRecordset($menusub1_grid->StartRec-1, $menusub1_grid->DisplayRecs);
}
$menusub1_grid->RenderOtherOptions();
?>
<?php $menusub1_grid->ShowPageHeader(); ?>
<?php
$menusub1_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fmenusub1grid" class="ewForm form-horizontal">
<div id="gmp_menusub1" class="ewGridMiddlePanel">
<table id="tbl_menusub1grid" class="ewTable ewTableSeparate">
<?php echo $menusub1->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$menusub1_grid->RenderListOptions();

// Render list options (header, left)
$menusub1_grid->ListOptions->Render("header", "left");
?>
<?php if ($menusub1->_Menu->Visible) { // Menu ?>
	<?php if ($menusub1->SortUrl($menusub1->_Menu) == "") { ?>
		<td><div id="elh_menusub1__Menu" class="menusub1__Menu"><div class="ewTableHeaderCaption"><?php echo $menusub1->_Menu->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub1__Menu" class="menusub1__Menu">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub1->_Menu->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub1->_Menu->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub1->_Menu->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($menusub1->Link->Visible) { // Link ?>
	<?php if ($menusub1->SortUrl($menusub1->Link) == "") { ?>
		<td><div id="elh_menusub1_Link" class="menusub1_Link"><div class="ewTableHeaderCaption"><?php echo $menusub1->Link->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub1_Link" class="menusub1_Link">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub1->Link->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub1->Link->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub1->Link->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($menusub1->Parent->Visible) { // Parent ?>
	<?php if ($menusub1->SortUrl($menusub1->Parent) == "") { ?>
		<td><div id="elh_menusub1_Parent" class="menusub1_Parent"><div class="ewTableHeaderCaption"><?php echo $menusub1->Parent->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub1_Parent" class="menusub1_Parent">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub1->Parent->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub1->Parent->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub1->Parent->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($menusub1->No->Visible) { // No ?>
	<?php if ($menusub1->SortUrl($menusub1->No) == "") { ?>
		<td><div id="elh_menusub1_No" class="menusub1_No"><div class="ewTableHeaderCaption"><?php echo $menusub1->No->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub1_No" class="menusub1_No">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub1->No->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub1->No->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub1->No->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($menusub1->Akses->Visible) { // Akses ?>
	<?php if ($menusub1->SortUrl($menusub1->Akses) == "") { ?>
		<td><div id="elh_menusub1_Akses" class="menusub1_Akses"><div class="ewTableHeaderCaption"><?php echo $menusub1->Akses->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_menusub1_Akses" class="menusub1_Akses">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $menusub1->Akses->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($menusub1->Akses->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($menusub1->Akses->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$menusub1_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$menusub1_grid->StartRec = 1;
$menusub1_grid->StopRec = $menusub1_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($menusub1_grid->FormKeyCountName) && ($menusub1->CurrentAction == "gridadd" || $menusub1->CurrentAction == "gridedit" || $menusub1->CurrentAction == "F")) {
		$menusub1_grid->KeyCount = $objForm->GetValue($menusub1_grid->FormKeyCountName);
		$menusub1_grid->StopRec = $menusub1_grid->StartRec + $menusub1_grid->KeyCount - 1;
	}
}
$menusub1_grid->RecCnt = $menusub1_grid->StartRec - 1;
if ($menusub1_grid->Recordset && !$menusub1_grid->Recordset->EOF) {
	$menusub1_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $menusub1_grid->StartRec > 1)
		$menusub1_grid->Recordset->Move($menusub1_grid->StartRec - 1);
} elseif (!$menusub1->AllowAddDeleteRow && $menusub1_grid->StopRec == 0) {
	$menusub1_grid->StopRec = $menusub1->GridAddRowCount;
}

// Initialize aggregate
$menusub1->RowType = EW_ROWTYPE_AGGREGATEINIT;
$menusub1->ResetAttrs();
$menusub1_grid->RenderRow();
if ($menusub1->CurrentAction == "gridadd")
	$menusub1_grid->RowIndex = 0;
if ($menusub1->CurrentAction == "gridedit")
	$menusub1_grid->RowIndex = 0;
while ($menusub1_grid->RecCnt < $menusub1_grid->StopRec) {
	$menusub1_grid->RecCnt++;
	if (intval($menusub1_grid->RecCnt) >= intval($menusub1_grid->StartRec)) {
		$menusub1_grid->RowCnt++;
		if ($menusub1->CurrentAction == "gridadd" || $menusub1->CurrentAction == "gridedit" || $menusub1->CurrentAction == "F") {
			$menusub1_grid->RowIndex++;
			$objForm->Index = $menusub1_grid->RowIndex;
			if ($objForm->HasValue($menusub1_grid->FormActionName))
				$menusub1_grid->RowAction = strval($objForm->GetValue($menusub1_grid->FormActionName));
			elseif ($menusub1->CurrentAction == "gridadd")
				$menusub1_grid->RowAction = "insert";
			else
				$menusub1_grid->RowAction = "";
		}

		// Set up key count
		$menusub1_grid->KeyCount = $menusub1_grid->RowIndex;

		// Init row class and style
		$menusub1->ResetAttrs();
		$menusub1->CssClass = "";
		if ($menusub1->CurrentAction == "gridadd") {
			if ($menusub1->CurrentMode == "copy") {
				$menusub1_grid->LoadRowValues($menusub1_grid->Recordset); // Load row values
				$menusub1_grid->SetRecordKey($menusub1_grid->RowOldKey, $menusub1_grid->Recordset); // Set old record key
			} else {
				$menusub1_grid->LoadDefaultValues(); // Load default values
				$menusub1_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$menusub1_grid->LoadRowValues($menusub1_grid->Recordset); // Load row values
		}
		$menusub1->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($menusub1->CurrentAction == "gridadd") // Grid add
			$menusub1->RowType = EW_ROWTYPE_ADD; // Render add
		if ($menusub1->CurrentAction == "gridadd" && $menusub1->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$menusub1_grid->RestoreCurrentRowFormValues($menusub1_grid->RowIndex); // Restore form values
		if ($menusub1->CurrentAction == "gridedit") { // Grid edit
			if ($menusub1->EventCancelled) {
				$menusub1_grid->RestoreCurrentRowFormValues($menusub1_grid->RowIndex); // Restore form values
			}
			if ($menusub1_grid->RowAction == "insert")
				$menusub1->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$menusub1->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($menusub1->CurrentAction == "gridedit" && ($menusub1->RowType == EW_ROWTYPE_EDIT || $menusub1->RowType == EW_ROWTYPE_ADD) && $menusub1->EventCancelled) // Update failed
			$menusub1_grid->RestoreCurrentRowFormValues($menusub1_grid->RowIndex); // Restore form values
		if ($menusub1->RowType == EW_ROWTYPE_EDIT) // Edit row
			$menusub1_grid->EditRowCnt++;
		if ($menusub1->CurrentAction == "F") // Confirm row
			$menusub1_grid->RestoreCurrentRowFormValues($menusub1_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$menusub1->RowAttrs = array_merge($menusub1->RowAttrs, array('data-rowindex'=>$menusub1_grid->RowCnt, 'id'=>'r' . $menusub1_grid->RowCnt . '_menusub1', 'data-rowtype'=>$menusub1->RowType));

		// Render row
		$menusub1_grid->RenderRow();

		// Render list options
		$menusub1_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($menusub1_grid->RowAction <> "delete" && $menusub1_grid->RowAction <> "insertdelete" && !($menusub1_grid->RowAction == "insert" && $menusub1->CurrentAction == "F" && $menusub1_grid->EmptyRow())) {
?>
	<tr<?php echo $menusub1->RowAttributes() ?>>
<?php

// Render list options (body, left)
$menusub1_grid->ListOptions->Render("body", "left", $menusub1_grid->RowCnt);
?>
	<?php if ($menusub1->_Menu->Visible) { // Menu ?>
		<td<?php echo $menusub1->_Menu->CellAttributes() ?>><span id="el<?php echo $menusub1_grid->RowCnt ?>_menusub1__Menu" class="control-group menusub1__Menu">
<?php if ($menusub1->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x__Menu" name="x<?php echo $menusub1_grid->RowIndex ?>__Menu" id="x<?php echo $menusub1_grid->RowIndex ?>__Menu" size="30" maxlength="100" placeholder="<?php echo $menusub1->_Menu->PlaceHolder ?>" value="<?php echo $menusub1->_Menu->EditValue ?>"<?php echo $menusub1->_Menu->EditAttributes() ?>>
<input type="hidden" data-field="x__Menu" name="o<?php echo $menusub1_grid->RowIndex ?>__Menu" id="o<?php echo $menusub1_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub1->_Menu->OldValue) ?>">
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x__Menu" name="x<?php echo $menusub1_grid->RowIndex ?>__Menu" id="x<?php echo $menusub1_grid->RowIndex ?>__Menu" size="30" maxlength="100" placeholder="<?php echo $menusub1->_Menu->PlaceHolder ?>" value="<?php echo $menusub1->_Menu->EditValue ?>"<?php echo $menusub1->_Menu->EditAttributes() ?>>
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub1->_Menu->ViewAttributes() ?>>
<?php echo $menusub1->_Menu->ListViewValue() ?></span>
<input type="hidden" data-field="x__Menu" name="x<?php echo $menusub1_grid->RowIndex ?>__Menu" id="x<?php echo $menusub1_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub1->_Menu->FormValue) ?>">
<input type="hidden" data-field="x__Menu" name="o<?php echo $menusub1_grid->RowIndex ?>__Menu" id="o<?php echo $menusub1_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub1->_Menu->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub1_grid->PageObjName . "_row_" . $menusub1_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $menusub1_grid->RowIndex ?>_ID" id="x<?php echo $menusub1_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($menusub1->ID->CurrentValue) ?>">
<input type="hidden" data-field="x_ID" name="o<?php echo $menusub1_grid->RowIndex ?>_ID" id="o<?php echo $menusub1_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($menusub1->ID->OldValue) ?>">
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_EDIT || $menusub1->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $menusub1_grid->RowIndex ?>_ID" id="x<?php echo $menusub1_grid->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($menusub1->ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($menusub1->Link->Visible) { // Link ?>
		<td<?php echo $menusub1->Link->CellAttributes() ?>><span id="el<?php echo $menusub1_grid->RowCnt ?>_menusub1_Link" class="control-group menusub1_Link">
<?php if ($menusub1->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Link" name="x<?php echo $menusub1_grid->RowIndex ?>_Link" id="x<?php echo $menusub1_grid->RowIndex ?>_Link" size="30" maxlength="255" placeholder="<?php echo $menusub1->Link->PlaceHolder ?>" value="<?php echo $menusub1->Link->EditValue ?>"<?php echo $menusub1->Link->EditAttributes() ?>>
<input type="hidden" data-field="x_Link" name="o<?php echo $menusub1_grid->RowIndex ?>_Link" id="o<?php echo $menusub1_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub1->Link->OldValue) ?>">
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Link" name="x<?php echo $menusub1_grid->RowIndex ?>_Link" id="x<?php echo $menusub1_grid->RowIndex ?>_Link" size="30" maxlength="255" placeholder="<?php echo $menusub1->Link->PlaceHolder ?>" value="<?php echo $menusub1->Link->EditValue ?>"<?php echo $menusub1->Link->EditAttributes() ?>>
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub1->Link->ViewAttributes() ?>>
<?php echo $menusub1->Link->ListViewValue() ?></span>
<input type="hidden" data-field="x_Link" name="x<?php echo $menusub1_grid->RowIndex ?>_Link" id="x<?php echo $menusub1_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub1->Link->FormValue) ?>">
<input type="hidden" data-field="x_Link" name="o<?php echo $menusub1_grid->RowIndex ?>_Link" id="o<?php echo $menusub1_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub1->Link->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub1_grid->PageObjName . "_row_" . $menusub1_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($menusub1->Parent->Visible) { // Parent ?>
		<td<?php echo $menusub1->Parent->CellAttributes() ?>><span id="el<?php echo $menusub1_grid->RowCnt ?>_menusub1_Parent" class="control-group menusub1_Parent">
<?php if ($menusub1->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($menusub1->Parent->getSessionValue() <> "") { ?>
<span<?php echo $menusub1->Parent->ViewAttributes() ?>>
<?php echo $menusub1->Parent->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $menusub1_grid->RowIndex ?>_Parent" name="x<?php echo $menusub1_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub1->Parent->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Parent" name="x<?php echo $menusub1_grid->RowIndex ?>_Parent" id="x<?php echo $menusub1_grid->RowIndex ?>_Parent" size="30" maxlength="100" placeholder="<?php echo $menusub1->Parent->PlaceHolder ?>" value="<?php echo $menusub1->Parent->EditValue ?>"<?php echo $menusub1->Parent->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_Parent" name="o<?php echo $menusub1_grid->RowIndex ?>_Parent" id="o<?php echo $menusub1_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub1->Parent->OldValue) ?>">
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($menusub1->Parent->getSessionValue() <> "") { ?>
<span<?php echo $menusub1->Parent->ViewAttributes() ?>>
<?php echo $menusub1->Parent->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $menusub1_grid->RowIndex ?>_Parent" name="x<?php echo $menusub1_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub1->Parent->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Parent" name="x<?php echo $menusub1_grid->RowIndex ?>_Parent" id="x<?php echo $menusub1_grid->RowIndex ?>_Parent" size="30" maxlength="100" placeholder="<?php echo $menusub1->Parent->PlaceHolder ?>" value="<?php echo $menusub1->Parent->EditValue ?>"<?php echo $menusub1->Parent->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub1->Parent->ViewAttributes() ?>>
<?php echo $menusub1->Parent->ListViewValue() ?></span>
<input type="hidden" data-field="x_Parent" name="x<?php echo $menusub1_grid->RowIndex ?>_Parent" id="x<?php echo $menusub1_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub1->Parent->FormValue) ?>">
<input type="hidden" data-field="x_Parent" name="o<?php echo $menusub1_grid->RowIndex ?>_Parent" id="o<?php echo $menusub1_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub1->Parent->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub1_grid->PageObjName . "_row_" . $menusub1_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($menusub1->No->Visible) { // No ?>
		<td<?php echo $menusub1->No->CellAttributes() ?>><span id="el<?php echo $menusub1_grid->RowCnt ?>_menusub1_No" class="control-group menusub1_No">
<?php if ($menusub1->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_No" name="x<?php echo $menusub1_grid->RowIndex ?>_No" id="x<?php echo $menusub1_grid->RowIndex ?>_No" size="30" placeholder="<?php echo $menusub1->No->PlaceHolder ?>" value="<?php echo $menusub1->No->EditValue ?>"<?php echo $menusub1->No->EditAttributes() ?>>
<input type="hidden" data-field="x_No" name="o<?php echo $menusub1_grid->RowIndex ?>_No" id="o<?php echo $menusub1_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub1->No->OldValue) ?>">
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_No" name="x<?php echo $menusub1_grid->RowIndex ?>_No" id="x<?php echo $menusub1_grid->RowIndex ?>_No" size="30" placeholder="<?php echo $menusub1->No->PlaceHolder ?>" value="<?php echo $menusub1->No->EditValue ?>"<?php echo $menusub1->No->EditAttributes() ?>>
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub1->No->ViewAttributes() ?>>
<?php echo $menusub1->No->ListViewValue() ?></span>
<input type="hidden" data-field="x_No" name="x<?php echo $menusub1_grid->RowIndex ?>_No" id="x<?php echo $menusub1_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub1->No->FormValue) ?>">
<input type="hidden" data-field="x_No" name="o<?php echo $menusub1_grid->RowIndex ?>_No" id="o<?php echo $menusub1_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub1->No->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub1_grid->PageObjName . "_row_" . $menusub1_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($menusub1->Akses->Visible) { // Akses ?>
		<td<?php echo $menusub1->Akses->CellAttributes() ?>><span id="el<?php echo $menusub1_grid->RowCnt ?>_menusub1_Akses" class="control-group menusub1_Akses">
<?php if ($menusub1->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select data-field="x_Akses" id="x<?php echo $menusub1_grid->RowIndex ?>_Akses[]" name="x<?php echo $menusub1_grid->RowIndex ?>_Akses[]" multiple="multiple"<?php echo $menusub1->Akses->EditAttributes() ?>>
<?php
if (is_array($menusub1->Akses->EditValue)) {
	$arwrk = $menusub1->Akses->EditValue;
	$armultiwrk= explode(",", strval($menusub1->Akses->CurrentValue));
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
if (@$emptywrk) $menusub1->Akses->OldValue = "";
?>
</select>
<input type="hidden" data-field="x_Akses" name="o<?php echo $menusub1_grid->RowIndex ?>_Akses[]" id="o<?php echo $menusub1_grid->RowIndex ?>_Akses[]" value="<?php echo ew_HtmlEncode($menusub1->Akses->OldValue) ?>">
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select data-field="x_Akses" id="x<?php echo $menusub1_grid->RowIndex ?>_Akses[]" name="x<?php echo $menusub1_grid->RowIndex ?>_Akses[]" multiple="multiple"<?php echo $menusub1->Akses->EditAttributes() ?>>
<?php
if (is_array($menusub1->Akses->EditValue)) {
	$arwrk = $menusub1->Akses->EditValue;
	$armultiwrk= explode(",", strval($menusub1->Akses->CurrentValue));
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
if (@$emptywrk) $menusub1->Akses->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($menusub1->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $menusub1->Akses->ViewAttributes() ?>>
<?php echo $menusub1->Akses->ListViewValue() ?></span>
<input type="hidden" data-field="x_Akses" name="x<?php echo $menusub1_grid->RowIndex ?>_Akses" id="x<?php echo $menusub1_grid->RowIndex ?>_Akses" value="<?php echo ew_HtmlEncode($menusub1->Akses->FormValue) ?>">
<input type="hidden" data-field="x_Akses" name="o<?php echo $menusub1_grid->RowIndex ?>_Akses[]" id="o<?php echo $menusub1_grid->RowIndex ?>_Akses[]" value="<?php echo ew_HtmlEncode($menusub1->Akses->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $menusub1_grid->PageObjName . "_row_" . $menusub1_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$menusub1_grid->ListOptions->Render("body", "right", $menusub1_grid->RowCnt);
?>
	</tr>
<?php if ($menusub1->RowType == EW_ROWTYPE_ADD || $menusub1->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmenusub1grid.UpdateOpts(<?php echo $menusub1_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($menusub1->CurrentAction <> "gridadd" || $menusub1->CurrentMode == "copy")
		if (!$menusub1_grid->Recordset->EOF) $menusub1_grid->Recordset->MoveNext();
}
?>
<?php
	if ($menusub1->CurrentMode == "add" || $menusub1->CurrentMode == "copy" || $menusub1->CurrentMode == "edit") {
		$menusub1_grid->RowIndex = '$rowindex$';
		$menusub1_grid->LoadDefaultValues();

		// Set row properties
		$menusub1->ResetAttrs();
		$menusub1->RowAttrs = array_merge($menusub1->RowAttrs, array('data-rowindex'=>$menusub1_grid->RowIndex, 'id'=>'r0_menusub1', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($menusub1->RowAttrs["class"], "ewTemplate");
		$menusub1->RowType = EW_ROWTYPE_ADD;

		// Render row
		$menusub1_grid->RenderRow();

		// Render list options
		$menusub1_grid->RenderListOptions();
		$menusub1_grid->StartRowCnt = 0;
?>
	<tr<?php echo $menusub1->RowAttributes() ?>>
<?php

// Render list options (body, left)
$menusub1_grid->ListOptions->Render("body", "left", $menusub1_grid->RowIndex);
?>
	<?php if ($menusub1->_Menu->Visible) { // Menu ?>
		<td><span id="el$rowindex$_menusub1__Menu" class="control-group menusub1__Menu">
<?php if ($menusub1->CurrentAction <> "F") { ?>
<input type="text" data-field="x__Menu" name="x<?php echo $menusub1_grid->RowIndex ?>__Menu" id="x<?php echo $menusub1_grid->RowIndex ?>__Menu" size="30" maxlength="100" placeholder="<?php echo $menusub1->_Menu->PlaceHolder ?>" value="<?php echo $menusub1->_Menu->EditValue ?>"<?php echo $menusub1->_Menu->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $menusub1->_Menu->ViewAttributes() ?>>
<?php echo $menusub1->_Menu->ViewValue ?></span>
<input type="hidden" data-field="x__Menu" name="x<?php echo $menusub1_grid->RowIndex ?>__Menu" id="x<?php echo $menusub1_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub1->_Menu->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__Menu" name="o<?php echo $menusub1_grid->RowIndex ?>__Menu" id="o<?php echo $menusub1_grid->RowIndex ?>__Menu" value="<?php echo ew_HtmlEncode($menusub1->_Menu->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($menusub1->Link->Visible) { // Link ?>
		<td><span id="el$rowindex$_menusub1_Link" class="control-group menusub1_Link">
<?php if ($menusub1->CurrentAction <> "F") { ?>
<input type="text" data-field="x_Link" name="x<?php echo $menusub1_grid->RowIndex ?>_Link" id="x<?php echo $menusub1_grid->RowIndex ?>_Link" size="30" maxlength="255" placeholder="<?php echo $menusub1->Link->PlaceHolder ?>" value="<?php echo $menusub1->Link->EditValue ?>"<?php echo $menusub1->Link->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $menusub1->Link->ViewAttributes() ?>>
<?php echo $menusub1->Link->ViewValue ?></span>
<input type="hidden" data-field="x_Link" name="x<?php echo $menusub1_grid->RowIndex ?>_Link" id="x<?php echo $menusub1_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub1->Link->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Link" name="o<?php echo $menusub1_grid->RowIndex ?>_Link" id="o<?php echo $menusub1_grid->RowIndex ?>_Link" value="<?php echo ew_HtmlEncode($menusub1->Link->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($menusub1->Parent->Visible) { // Parent ?>
		<td><span id="el$rowindex$_menusub1_Parent" class="control-group menusub1_Parent">
<?php if ($menusub1->CurrentAction <> "F") { ?>
<?php if ($menusub1->Parent->getSessionValue() <> "") { ?>
<span<?php echo $menusub1->Parent->ViewAttributes() ?>>
<?php echo $menusub1->Parent->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $menusub1_grid->RowIndex ?>_Parent" name="x<?php echo $menusub1_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub1->Parent->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Parent" name="x<?php echo $menusub1_grid->RowIndex ?>_Parent" id="x<?php echo $menusub1_grid->RowIndex ?>_Parent" size="30" maxlength="100" placeholder="<?php echo $menusub1->Parent->PlaceHolder ?>" value="<?php echo $menusub1->Parent->EditValue ?>"<?php echo $menusub1->Parent->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $menusub1->Parent->ViewAttributes() ?>>
<?php echo $menusub1->Parent->ViewValue ?></span>
<input type="hidden" data-field="x_Parent" name="x<?php echo $menusub1_grid->RowIndex ?>_Parent" id="x<?php echo $menusub1_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub1->Parent->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Parent" name="o<?php echo $menusub1_grid->RowIndex ?>_Parent" id="o<?php echo $menusub1_grid->RowIndex ?>_Parent" value="<?php echo ew_HtmlEncode($menusub1->Parent->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($menusub1->No->Visible) { // No ?>
		<td><span id="el$rowindex$_menusub1_No" class="control-group menusub1_No">
<?php if ($menusub1->CurrentAction <> "F") { ?>
<input type="text" data-field="x_No" name="x<?php echo $menusub1_grid->RowIndex ?>_No" id="x<?php echo $menusub1_grid->RowIndex ?>_No" size="30" placeholder="<?php echo $menusub1->No->PlaceHolder ?>" value="<?php echo $menusub1->No->EditValue ?>"<?php echo $menusub1->No->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $menusub1->No->ViewAttributes() ?>>
<?php echo $menusub1->No->ViewValue ?></span>
<input type="hidden" data-field="x_No" name="x<?php echo $menusub1_grid->RowIndex ?>_No" id="x<?php echo $menusub1_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub1->No->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_No" name="o<?php echo $menusub1_grid->RowIndex ?>_No" id="o<?php echo $menusub1_grid->RowIndex ?>_No" value="<?php echo ew_HtmlEncode($menusub1->No->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($menusub1->Akses->Visible) { // Akses ?>
		<td><span id="el$rowindex$_menusub1_Akses" class="control-group menusub1_Akses">
<?php if ($menusub1->CurrentAction <> "F") { ?>
<select data-field="x_Akses" id="x<?php echo $menusub1_grid->RowIndex ?>_Akses[]" name="x<?php echo $menusub1_grid->RowIndex ?>_Akses[]" multiple="multiple"<?php echo $menusub1->Akses->EditAttributes() ?>>
<?php
if (is_array($menusub1->Akses->EditValue)) {
	$arwrk = $menusub1->Akses->EditValue;
	$armultiwrk= explode(",", strval($menusub1->Akses->CurrentValue));
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
if (@$emptywrk) $menusub1->Akses->OldValue = "";
?>
</select>
<?php } else { ?>
<span<?php echo $menusub1->Akses->ViewAttributes() ?>>
<?php echo $menusub1->Akses->ViewValue ?></span>
<input type="hidden" data-field="x_Akses" name="x<?php echo $menusub1_grid->RowIndex ?>_Akses" id="x<?php echo $menusub1_grid->RowIndex ?>_Akses" value="<?php echo ew_HtmlEncode($menusub1->Akses->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Akses" name="o<?php echo $menusub1_grid->RowIndex ?>_Akses[]" id="o<?php echo $menusub1_grid->RowIndex ?>_Akses[]" value="<?php echo ew_HtmlEncode($menusub1->Akses->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$menusub1_grid->ListOptions->Render("body", "right", $menusub1_grid->RowCnt);
?>
<script type="text/javascript">
fmenusub1grid.UpdateOpts(<?php echo $menusub1_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($menusub1->CurrentMode == "add" || $menusub1->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $menusub1_grid->FormKeyCountName ?>" id="<?php echo $menusub1_grid->FormKeyCountName ?>" value="<?php echo $menusub1_grid->KeyCount ?>">
<?php echo $menusub1_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($menusub1->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $menusub1_grid->FormKeyCountName ?>" id="<?php echo $menusub1_grid->FormKeyCountName ?>" value="<?php echo $menusub1_grid->KeyCount ?>">
<?php echo $menusub1_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($menusub1->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmenusub1grid">
</div>
<?php

// Close recordset
if ($menusub1_grid->Recordset)
	$menusub1_grid->Recordset->Close();
?>
<?php if ($menusub1_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($menusub1_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($menusub1->Export == "") { ?>
<script type="text/javascript">
fmenusub1grid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$menusub1_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$menusub1_grid->Page_Terminate();
?>

<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "z2pbackupinfo.php" ?>
<?php include "z2padmininfo.php" ?>
<?php include "userfn7.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$z2pbackup_edit = new cz2pbackup_edit();
$Page =& $z2pbackup_edit;

// Page init
$z2pbackup_edit->Page_Init();

// Page main
$z2pbackup_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var z2pbackup_edit = new ew_Page("z2pbackup_edit");

// page properties
z2pbackup_edit.PageID = "edit"; // page ID
z2pbackup_edit.FormID = "fz2pbackupedit"; // form ID
var EW_PAGE_ID = z2pbackup_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
z2pbackup_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_DBPath"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($z2pbackup->DBPath->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_ToPath"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($z2pbackup->ToPath->FldCaption()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
z2pbackup_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
z2pbackup_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
z2pbackup_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
z2pbackup_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $z2pbackup->TableCaption() ?><br><br>
<a href="<?php echo $z2pbackup->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$z2pbackup_edit->ShowMessage();
?>
<form name="fz2pbackupedit" id="fz2pbackupedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return z2pbackup_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="z2pbackup">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($z2pbackup->ID->Visible) { // ID ?>
	<tr<?php echo $z2pbackup->ID->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2pbackup->ID->FldCaption() ?></td>
		<td<?php echo $z2pbackup->ID->CellAttributes() ?>><span id="el_ID">
<div<?php echo $z2pbackup->ID->ViewAttributes() ?>><?php echo $z2pbackup->ID->EditValue ?></div><input type="hidden" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($z2pbackup->ID->CurrentValue) ?>">
</span><?php echo $z2pbackup->ID->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($z2pbackup->DBPath->Visible) { // DBPath ?>
	<tr<?php echo $z2pbackup->DBPath->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2pbackup->DBPath->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $z2pbackup->DBPath->CellAttributes() ?>><span id="el_DBPath">
<input type="text" name="x_DBPath" id="x_DBPath" title="<?php echo $z2pbackup->DBPath->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $z2pbackup->DBPath->EditValue ?>"<?php echo $z2pbackup->DBPath->EditAttributes() ?>>
</span><?php echo $z2pbackup->DBPath->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($z2pbackup->ToPath->Visible) { // ToPath ?>
	<tr<?php echo $z2pbackup->ToPath->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2pbackup->ToPath->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $z2pbackup->ToPath->CellAttributes() ?>><span id="el_ToPath">
<input type="text" name="x_ToPath" id="x_ToPath" title="<?php echo $z2pbackup->ToPath->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $z2pbackup->ToPath->EditValue ?>"<?php echo $z2pbackup->ToPath->EditAttributes() ?>>
</span><?php echo $z2pbackup->ToPath->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$z2pbackup_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cz2pbackup_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = '2pbackup';

	// Page object name
	var $PageObjName = 'z2pbackup_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $z2pbackup;
		if ($z2pbackup->UseTokenInUrl) $PageUrl .= "t=" . $z2pbackup->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $z2pbackup;
		if ($z2pbackup->UseTokenInUrl) {
			if ($objForm)
				return ($z2pbackup->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($z2pbackup->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cz2pbackup_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (z2pbackup)
		$GLOBALS["z2pbackup"] = new cz2pbackup();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", '2pbackup', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $z2pbackup;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("z2pbackuplist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $sDbMasterFilter;
	var $sDbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $z2pbackup;

		// Load key from QueryString
		if (@$_GET["ID"] <> "")
			$z2pbackup->ID->setQueryStringValue($_GET["ID"]);
		if (@$_POST["a_edit"] <> "") {
			$z2pbackup->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$z2pbackup->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$z2pbackup->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$z2pbackup->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($z2pbackup->ID->CurrentValue == "")
			$this->Page_Terminate("z2pbackuplist.php"); // Invalid key, return to list
		switch ($z2pbackup->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("z2pbackuplist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$z2pbackup->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $z2pbackup->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$z2pbackup->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$z2pbackup->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $z2pbackup;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $z2pbackup;
		$z2pbackup->ID->setFormValue($objForm->GetValue("x_ID"));
		$z2pbackup->DBPath->setFormValue($objForm->GetValue("x_DBPath"));
		$z2pbackup->ToPath->setFormValue($objForm->GetValue("x_ToPath"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $z2pbackup;
		$this->LoadRow();
		$z2pbackup->ID->CurrentValue = $z2pbackup->ID->FormValue;
		$z2pbackup->DBPath->CurrentValue = $z2pbackup->DBPath->FormValue;
		$z2pbackup->ToPath->CurrentValue = $z2pbackup->ToPath->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $z2pbackup;
		$sFilter = $z2pbackup->KeyFilter();

		// Call Row Selecting event
		$z2pbackup->Row_Selecting($sFilter);

		// Load SQL based on filter
		$z2pbackup->CurrentFilter = $sFilter;
		$sSql = $z2pbackup->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$z2pbackup->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $z2pbackup;
		$z2pbackup->ID->setDbValue($rs->fields('ID'));
		$z2pbackup->DBPath->setDbValue($rs->fields('DBPath'));
		$z2pbackup->ToPath->setDbValue($rs->fields('ToPath'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $z2pbackup;

		// Initialize URLs
		// Call Row_Rendering event

		$z2pbackup->Row_Rendering();

		// Common render codes for all row types
		// ID

		$z2pbackup->ID->CellCssStyle = ""; $z2pbackup->ID->CellCssClass = "";
		$z2pbackup->ID->CellAttrs = array(); $z2pbackup->ID->ViewAttrs = array(); $z2pbackup->ID->EditAttrs = array();

		// DBPath
		$z2pbackup->DBPath->CellCssStyle = ""; $z2pbackup->DBPath->CellCssClass = "";
		$z2pbackup->DBPath->CellAttrs = array(); $z2pbackup->DBPath->ViewAttrs = array(); $z2pbackup->DBPath->EditAttrs = array();

		// ToPath
		$z2pbackup->ToPath->CellCssStyle = ""; $z2pbackup->ToPath->CellCssClass = "";
		$z2pbackup->ToPath->CellAttrs = array(); $z2pbackup->ToPath->ViewAttrs = array(); $z2pbackup->ToPath->EditAttrs = array();
		if ($z2pbackup->RowType == EW_ROWTYPE_VIEW) { // View row

			// ID
			$z2pbackup->ID->ViewValue = $z2pbackup->ID->CurrentValue;
			$z2pbackup->ID->CssStyle = "";
			$z2pbackup->ID->CssClass = "";
			$z2pbackup->ID->ViewCustomAttributes = "";

			// DBPath
			$z2pbackup->DBPath->ViewValue = $z2pbackup->DBPath->CurrentValue;
			$z2pbackup->DBPath->CssStyle = "";
			$z2pbackup->DBPath->CssClass = "";
			$z2pbackup->DBPath->ViewCustomAttributes = "";

			// ToPath
			$z2pbackup->ToPath->ViewValue = $z2pbackup->ToPath->CurrentValue;
			$z2pbackup->ToPath->CssStyle = "";
			$z2pbackup->ToPath->CssClass = "";
			$z2pbackup->ToPath->ViewCustomAttributes = "";

			// ID
			$z2pbackup->ID->HrefValue = "";
			$z2pbackup->ID->TooltipValue = "";

			// DBPath
			$z2pbackup->DBPath->HrefValue = "";
			$z2pbackup->DBPath->TooltipValue = "";

			// ToPath
			$z2pbackup->ToPath->HrefValue = "";
			$z2pbackup->ToPath->TooltipValue = "";
		} elseif ($z2pbackup->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// ID
			$z2pbackup->ID->EditCustomAttributes = "";
			$z2pbackup->ID->EditValue = $z2pbackup->ID->CurrentValue;
			$z2pbackup->ID->CssStyle = "";
			$z2pbackup->ID->CssClass = "";
			$z2pbackup->ID->ViewCustomAttributes = "";

			// DBPath
			$z2pbackup->DBPath->EditCustomAttributes = "";
			$z2pbackup->DBPath->EditValue = ew_HtmlEncode($z2pbackup->DBPath->CurrentValue);

			// ToPath
			$z2pbackup->ToPath->EditCustomAttributes = "";
			$z2pbackup->ToPath->EditValue = ew_HtmlEncode($z2pbackup->ToPath->CurrentValue);

			// Edit refer script
			// ID

			$z2pbackup->ID->HrefValue = "";

			// DBPath
			$z2pbackup->DBPath->HrefValue = "";

			// ToPath
			$z2pbackup->ToPath->HrefValue = "";
		}

		// Call Row Rendered event
		if ($z2pbackup->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$z2pbackup->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $z2pbackup;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($z2pbackup->DBPath->FormValue) && $z2pbackup->DBPath->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $z2pbackup->DBPath->FldCaption();
		}
		if (!is_null($z2pbackup->ToPath->FormValue) && $z2pbackup->ToPath->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $z2pbackup->ToPath->FldCaption();
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $z2pbackup;
		$sFilter = $z2pbackup->KeyFilter();
		$z2pbackup->CurrentFilter = $sFilter;
		$sSql = $z2pbackup->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// DBPath
			$z2pbackup->DBPath->SetDbValueDef($rsnew, $z2pbackup->DBPath->CurrentValue, "", FALSE);

			// ToPath
			$z2pbackup->ToPath->SetDbValueDef($rsnew, $z2pbackup->ToPath->CurrentValue, "", FALSE);

			// Call Row Updating event
			$bUpdateRow = $z2pbackup->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($z2pbackup->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($z2pbackup->CancelMessage <> "") {
					$this->setMessage($z2pbackup->CancelMessage);
					$z2pbackup->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$z2pbackup->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>

<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "lapstokinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$lapstok_edit = NULL; // Initialize page object first

class clapstok_edit extends clapstok {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'lapstok';

	// Page object name
	var $PageObjName = 'lapstok_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language, $UserAgent;

		// User agent
		$UserAgent = ew_UserAgent();
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (lapstok)
		if (!isset($GLOBALS["lapstok"])) {
			$GLOBALS["lapstok"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lapstok"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lapstok', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("lapstoklist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

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
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["ID"] <> "") {
			$this->ID->setQueryStringValue($_GET["ID"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->ID->CurrentValue == "")
			$this->Page_Terminate("lapstoklist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("lapstoklist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->GetEditUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->TglDari->FldIsDetailKey) {
			$this->TglDari->setFormValue($objForm->GetValue("x_TglDari"));
			$this->TglDari->CurrentValue = ew_UnFormatDateTime($this->TglDari->CurrentValue, 7);
		}
		if (!$this->TglKe->FldIsDetailKey) {
			$this->TglKe->setFormValue($objForm->GetValue("x_TglKe"));
			$this->TglKe->CurrentValue = ew_UnFormatDateTime($this->TglKe->CurrentValue, 7);
		}
		if (!$this->Laporan->FldIsDetailKey) {
			$this->Laporan->setFormValue($objForm->GetValue("x_Laporan"));
		}
		if (!$this->ID->FldIsDetailKey)
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->ID->CurrentValue = $this->ID->FormValue;
		$this->TglDari->CurrentValue = $this->TglDari->FormValue;
		$this->TglDari->CurrentValue = ew_UnFormatDateTime($this->TglDari->CurrentValue, 7);
		$this->TglKe->CurrentValue = $this->TglKe->FormValue;
		$this->TglKe->CurrentValue = ew_UnFormatDateTime($this->TglKe->CurrentValue, 7);
		$this->Laporan->CurrentValue = $this->Laporan->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->ID->setDbValue($rs->fields('ID'));
		$this->TglDari->setDbValue($rs->fields('TglDari'));
		$this->TglKe->setDbValue($rs->fields('TglKe'));
		$this->Laporan->setDbValue($rs->fields('Laporan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->TglDari->DbValue = $row['TglDari'];
		$this->TglKe->DbValue = $row['TglKe'];
		$this->Laporan->DbValue = $row['Laporan'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// ID
		// TglDari
		// TglKe
		// Laporan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// TglDari
			$this->TglDari->ViewValue = $this->TglDari->CurrentValue;
			$this->TglDari->ViewValue = ew_FormatDateTime($this->TglDari->ViewValue, 7);
			$this->TglDari->ViewCustomAttributes = "";

			// TglKe
			$this->TglKe->ViewValue = $this->TglKe->CurrentValue;
			$this->TglKe->ViewValue = ew_FormatDateTime($this->TglKe->ViewValue, 7);
			$this->TglKe->ViewCustomAttributes = "";

			// Laporan
			$this->Laporan->ViewValue = $this->Laporan->CurrentValue;
			$this->Laporan->CssStyle = "font-weight: bold;";
			$this->Laporan->ViewCustomAttributes = "";

			// TglDari
			$this->TglDari->LinkCustomAttributes = "";
			$this->TglDari->HrefValue = "";
			$this->TglDari->TooltipValue = "";

			// TglKe
			$this->TglKe->LinkCustomAttributes = "";
			$this->TglKe->HrefValue = "";
			$this->TglKe->TooltipValue = "";

			// Laporan
			$this->Laporan->LinkCustomAttributes = "";
			if (!ew_Empty($this->ID->CurrentValue)) {
				$this->Laporan->HrefValue = "AppCetakStokBarangShow.php?id=" . $this->ID->CurrentValue; // Add prefix/suffix
				$this->Laporan->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->Laporan->HrefValue = ew_ConvertFullUrl($this->Laporan->HrefValue);
			} else {
				$this->Laporan->HrefValue = "";
			}
			$this->Laporan->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// TglDari
			$this->TglDari->EditCustomAttributes = "";
			$this->TglDari->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TglDari->CurrentValue, 7));
			$this->TglDari->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->TglDari->FldCaption()));

			// TglKe
			$this->TglKe->EditCustomAttributes = "";
			$this->TglKe->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TglKe->CurrentValue, 7));
			$this->TglKe->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->TglKe->FldCaption()));

			// Laporan
			$this->Laporan->EditCustomAttributes = "";
			$this->Laporan->EditValue = $this->Laporan->CurrentValue;
			$this->Laporan->CssStyle = "font-weight: bold;";
			$this->Laporan->ViewCustomAttributes = "";

			// Edit refer script
			// TglDari

			$this->TglDari->HrefValue = "";

			// TglKe
			$this->TglKe->HrefValue = "";

			// Laporan
			if (!ew_Empty($this->ID->CurrentValue)) {
				$this->Laporan->HrefValue = "AppCetakStokBarangShow.php?id=" . $this->ID->CurrentValue; // Add prefix/suffix
				$this->Laporan->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->Laporan->HrefValue = ew_ConvertFullUrl($this->Laporan->HrefValue);
			} else {
				$this->Laporan->HrefValue = "";
			}
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->TglDari->FldIsDetailKey && !is_null($this->TglDari->FormValue) && $this->TglDari->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->TglDari->FldCaption());
		}
		if (!ew_CheckEuroDate($this->TglDari->FormValue)) {
			ew_AddMessage($gsFormError, $this->TglDari->FldErrMsg());
		}
		if (!$this->TglKe->FldIsDetailKey && !is_null($this->TglKe->FormValue) && $this->TglKe->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->TglKe->FldCaption());
		}
		if (!ew_CheckEuroDate($this->TglKe->FormValue)) {
			ew_AddMessage($gsFormError, $this->TglKe->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// TglDari
			$this->TglDari->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglDari->CurrentValue, 7), ew_CurrentDate(), $this->TglDari->ReadOnly);

			// TglKe
			$this->TglKe->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglKe->CurrentValue, 7), ew_CurrentDate(), $this->TglKe->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "lapstoklist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("edit");
		$Breadcrumb->Add("edit", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($lapstok_edit)) $lapstok_edit = new clapstok_edit();

// Page init
$lapstok_edit->Page_Init();

// Page main
$lapstok_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lapstok_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var lapstok_edit = new ew_Page("lapstok_edit");
lapstok_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = lapstok_edit.PageID; // For backward compatibility

// Form object
var flapstokedit = new ew_Form("flapstokedit");

// Validate form
flapstokedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_TglDari");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lapstok->TglDari->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_TglDari");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($lapstok->TglDari->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TglKe");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lapstok->TglKe->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_TglKe");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($lapstok->TglKe->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
flapstokedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flapstokedit.ValidateRequired = true;
<?php } else { ?>
flapstokedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $lapstok_edit->ShowPageHeader(); ?>
<?php
$lapstok_edit->ShowMessage();
?>
<form name="flapstokedit" id="flapstokedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="lapstok">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_lapstokedit" class="table table-bordered table-striped">
<?php if ($lapstok->TglDari->Visible) { // TglDari ?>
	<tr id="r_TglDari"<?php echo $lapstok->RowAttributes() ?>>
		<td><span id="elh_lapstok_TglDari"><?php echo $lapstok->TglDari->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lapstok->TglDari->CellAttributes() ?>><span id="el_lapstok_TglDari" class="control-group">
<input type="text" data-field="x_TglDari" name="x_TglDari" id="x_TglDari" placeholder="<?php echo $lapstok->TglDari->PlaceHolder ?>" value="<?php echo $lapstok->TglDari->EditValue ?>"<?php echo $lapstok->TglDari->EditAttributes() ?>>
<?php if (!$lapstok->TglDari->ReadOnly && !$lapstok->TglDari->Disabled && @$lapstok->TglDari->EditAttrs["readonly"] == "" && @$lapstok->TglDari->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_TglDari" name="cal_x_TglDari" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_TglDari" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("flapstokedit", "x_TglDari", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $lapstok->TglDari->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lapstok->TglKe->Visible) { // TglKe ?>
	<tr id="r_TglKe"<?php echo $lapstok->RowAttributes() ?>>
		<td><span id="elh_lapstok_TglKe"><?php echo $lapstok->TglKe->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lapstok->TglKe->CellAttributes() ?>><span id="el_lapstok_TglKe" class="control-group">
<input type="text" data-field="x_TglKe" name="x_TglKe" id="x_TglKe" placeholder="<?php echo $lapstok->TglKe->PlaceHolder ?>" value="<?php echo $lapstok->TglKe->EditValue ?>"<?php echo $lapstok->TglKe->EditAttributes() ?>>
<?php if (!$lapstok->TglKe->ReadOnly && !$lapstok->TglKe->Disabled && @$lapstok->TglKe->EditAttrs["readonly"] == "" && @$lapstok->TglKe->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_TglKe" name="cal_x_TglKe" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_TglKe" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("flapstokedit", "x_TglKe", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $lapstok->TglKe->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lapstok->Laporan->Visible) { // Laporan ?>
	<tr id="r_Laporan"<?php echo $lapstok->RowAttributes() ?>>
		<td><span id="elh_lapstok_Laporan"><?php echo $lapstok->Laporan->FldCaption() ?></span></td>
		<td<?php echo $lapstok->Laporan->CellAttributes() ?>><span id="el_lapstok_Laporan" class="control-group">
<span<?php echo $lapstok->Laporan->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($lapstok->Laporan->EditValue) && $lapstok->Laporan->LinkAttributes() <> "") { ?>
<a<?php echo $lapstok->Laporan->LinkAttributes() ?>><?php echo $lapstok->Laporan->EditValue ?></a>
<?php } else { ?>
<?php echo $lapstok->Laporan->EditValue ?>
<?php } ?>
</span>
<input type="hidden" data-field="x_Laporan" name="x_Laporan" id="x_Laporan" value="<?php echo ew_HtmlEncode($lapstok->Laporan->CurrentValue) ?>">
</span><?php echo $lapstok->Laporan->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<input type="hidden" data-field="x_ID" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($lapstok->ID->CurrentValue) ?>">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
flapstokedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$lapstok_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lapstok_edit->Page_Terminate();
?>

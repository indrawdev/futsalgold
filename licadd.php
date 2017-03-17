<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "licinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$lic_add = NULL; // Initialize page object first

class clic_add extends clic {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'lic';

	// Page object name
	var $PageObjName = 'lic_add';

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

		// Table object (lic)
		if (!isset($GLOBALS["lic"])) {
			$GLOBALS["lic"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lic"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lic', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("liclist.php");
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["ID"] != "") {
				$this->ID->setQueryStringValue($_GET["ID"]);
				$this->setKey("ID", $this->ID->CurrentValue); // Set up key
			} else {
				$this->setKey("ID", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("liclist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "licview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Serial->CurrentValue = NULL;
		$this->Serial->OldValue = $this->Serial->CurrentValue;
		$this->Kode->CurrentValue = NULL;
		$this->Kode->OldValue = $this->Kode->CurrentValue;
		$this->Status->CurrentValue = NULL;
		$this->Status->OldValue = $this->Status->CurrentValue;
		$this->Waktu->CurrentValue = NULL;
		$this->Waktu->OldValue = $this->Waktu->CurrentValue;
		$this->Stamp->CurrentValue = NULL;
		$this->Stamp->OldValue = $this->Stamp->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Serial->FldIsDetailKey) {
			$this->Serial->setFormValue($objForm->GetValue("x_Serial"));
		}
		if (!$this->Kode->FldIsDetailKey) {
			$this->Kode->setFormValue($objForm->GetValue("x_Kode"));
		}
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
		if (!$this->Waktu->FldIsDetailKey) {
			$this->Waktu->setFormValue($objForm->GetValue("x_Waktu"));
			$this->Waktu->CurrentValue = ew_UnFormatDateTime($this->Waktu->CurrentValue, 7);
		}
		if (!$this->Stamp->FldIsDetailKey) {
			$this->Stamp->setFormValue($objForm->GetValue("x_Stamp"));
			$this->Stamp->CurrentValue = ew_UnFormatDateTime($this->Stamp->CurrentValue, 7);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Serial->CurrentValue = $this->Serial->FormValue;
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
		$this->Waktu->CurrentValue = $this->Waktu->FormValue;
		$this->Waktu->CurrentValue = ew_UnFormatDateTime($this->Waktu->CurrentValue, 7);
		$this->Stamp->CurrentValue = $this->Stamp->FormValue;
		$this->Stamp->CurrentValue = ew_UnFormatDateTime($this->Stamp->CurrentValue, 7);
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
		$this->Serial->setDbValue($rs->fields('Serial'));
		$this->Kode->setDbValue($rs->fields('Kode'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Serial->DbValue = $row['Serial'];
		$this->Kode->DbValue = $row['Kode'];
		$this->Status->DbValue = $row['Status'];
		$this->Waktu->DbValue = $row['Waktu'];
		$this->Stamp->DbValue = $row['Stamp'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("ID")) <> "")
			$this->ID->CurrentValue = $this->getKey("ID"); // ID
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		// Serial
		// Kode
		// Status
		// Waktu
		// Stamp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// ID
			$this->ID->ViewValue = $this->ID->CurrentValue;
			$this->ID->ViewCustomAttributes = "";

			// Serial
			$this->Serial->ViewValue = $this->Serial->CurrentValue;
			$this->Serial->ViewCustomAttributes = "";

			// Kode
			$this->Kode->ViewValue = $this->Kode->CurrentValue;
			$this->Kode->ViewCustomAttributes = "";

			// Status
			$this->Status->ViewValue = $this->Status->CurrentValue;
			$this->Status->ViewCustomAttributes = "";

			// Waktu
			$this->Waktu->ViewValue = $this->Waktu->CurrentValue;
			$this->Waktu->ViewValue = ew_FormatDateTime($this->Waktu->ViewValue, 7);
			$this->Waktu->ViewCustomAttributes = "";

			// Stamp
			$this->Stamp->ViewValue = $this->Stamp->CurrentValue;
			$this->Stamp->ViewValue = ew_FormatDateTime($this->Stamp->ViewValue, 7);
			$this->Stamp->ViewCustomAttributes = "";

			// Serial
			$this->Serial->LinkCustomAttributes = "";
			$this->Serial->HrefValue = "";
			$this->Serial->TooltipValue = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Waktu
			$this->Waktu->LinkCustomAttributes = "";
			$this->Waktu->HrefValue = "";
			$this->Waktu->TooltipValue = "";

			// Stamp
			$this->Stamp->LinkCustomAttributes = "";
			$this->Stamp->HrefValue = "";
			$this->Stamp->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Serial
			$this->Serial->EditCustomAttributes = "";
			$this->Serial->EditValue = ew_HtmlEncode($this->Serial->CurrentValue);
			$this->Serial->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Serial->FldCaption()));

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->CurrentValue);
			$this->Kode->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kode->FldCaption()));

			// Status
			$this->Status->EditCustomAttributes = "";
			$this->Status->EditValue = ew_HtmlEncode($this->Status->CurrentValue);
			$this->Status->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Status->FldCaption()));

			// Waktu
			$this->Waktu->EditCustomAttributes = "";
			$this->Waktu->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Waktu->CurrentValue, 7));
			$this->Waktu->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Waktu->FldCaption()));

			// Stamp
			$this->Stamp->EditCustomAttributes = "";
			$this->Stamp->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Stamp->CurrentValue, 7));
			$this->Stamp->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Stamp->FldCaption()));

			// Edit refer script
			// Serial

			$this->Serial->HrefValue = "";

			// Kode
			$this->Kode->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";

			// Waktu
			$this->Waktu->HrefValue = "";

			// Stamp
			$this->Stamp->HrefValue = "";
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
		if (!$this->Serial->FldIsDetailKey && !is_null($this->Serial->FormValue) && $this->Serial->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Serial->FldCaption());
		}
		if (!$this->Kode->FldIsDetailKey && !is_null($this->Kode->FormValue) && $this->Kode->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Kode->FldCaption());
		}
		if (!$this->Status->FldIsDetailKey && !is_null($this->Status->FormValue) && $this->Status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Status->FldCaption());
		}
		if (!$this->Waktu->FldIsDetailKey && !is_null($this->Waktu->FormValue) && $this->Waktu->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Waktu->FldCaption());
		}
		if (!ew_CheckEuroDate($this->Waktu->FormValue)) {
			ew_AddMessage($gsFormError, $this->Waktu->FldErrMsg());
		}
		if (!$this->Stamp->FldIsDetailKey && !is_null($this->Stamp->FormValue) && $this->Stamp->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Stamp->FldCaption());
		}
		if (!ew_CheckEuroDate($this->Stamp->FormValue)) {
			ew_AddMessage($gsFormError, $this->Stamp->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Serial
		$this->Serial->SetDbValueDef($rsnew, $this->Serial->CurrentValue, "", FALSE);

		// Kode
		$this->Kode->SetDbValueDef($rsnew, $this->Kode->CurrentValue, "", FALSE);

		// Status
		$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, "", FALSE);

		// Waktu
		$this->Waktu->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Waktu->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// Stamp
		$this->Stamp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Stamp->CurrentValue, 7), NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->ID->setDbValue($conn->Insert_ID());
			$rsnew['ID'] = $this->ID->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "liclist.php", $this->TableVar);
		$PageCaption = ($this->CurrentAction == "C") ? $Language->Phrase("Copy") : $Language->Phrase("Add");
		$Breadcrumb->Add("add", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($lic_add)) $lic_add = new clic_add();

// Page init
$lic_add->Page_Init();

// Page main
$lic_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lic_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var lic_add = new ew_Page("lic_add");
lic_add.PageID = "add"; // Page ID
var EW_PAGE_ID = lic_add.PageID; // For backward compatibility

// Form object
var flicadd = new ew_Form("flicadd");

// Validate form
flicadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Serial");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lic->Serial->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Kode");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lic->Kode->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Status");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lic->Status->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Waktu");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lic->Waktu->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Waktu");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($lic->Waktu->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Stamp");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lic->Stamp->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Stamp");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($lic->Stamp->FldErrMsg()) ?>");

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
flicadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flicadd.ValidateRequired = true;
<?php } else { ?>
flicadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $lic_add->ShowPageHeader(); ?>
<?php
$lic_add->ShowMessage();
?>
<form name="flicadd" id="flicadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="lic">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_licadd" class="table table-bordered table-striped">
<?php if ($lic->Serial->Visible) { // Serial ?>
	<tr id="r_Serial"<?php echo $lic->RowAttributes() ?>>
		<td><span id="elh_lic_Serial"><?php echo $lic->Serial->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lic->Serial->CellAttributes() ?>><span id="el_lic_Serial" class="control-group">
<input type="text" data-field="x_Serial" name="x_Serial" id="x_Serial" size="30" maxlength="100" placeholder="<?php echo $lic->Serial->PlaceHolder ?>" value="<?php echo $lic->Serial->EditValue ?>"<?php echo $lic->Serial->EditAttributes() ?>>
</span><?php echo $lic->Serial->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lic->Kode->Visible) { // Kode ?>
	<tr id="r_Kode"<?php echo $lic->RowAttributes() ?>>
		<td><span id="elh_lic_Kode"><?php echo $lic->Kode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lic->Kode->CellAttributes() ?>><span id="el_lic_Kode" class="control-group">
<input type="text" data-field="x_Kode" name="x_Kode" id="x_Kode" size="30" maxlength="100" placeholder="<?php echo $lic->Kode->PlaceHolder ?>" value="<?php echo $lic->Kode->EditValue ?>"<?php echo $lic->Kode->EditAttributes() ?>>
</span><?php echo $lic->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lic->Status->Visible) { // Status ?>
	<tr id="r_Status"<?php echo $lic->RowAttributes() ?>>
		<td><span id="elh_lic_Status"><?php echo $lic->Status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lic->Status->CellAttributes() ?>><span id="el_lic_Status" class="control-group">
<input type="text" data-field="x_Status" name="x_Status" id="x_Status" size="30" maxlength="50" placeholder="<?php echo $lic->Status->PlaceHolder ?>" value="<?php echo $lic->Status->EditValue ?>"<?php echo $lic->Status->EditAttributes() ?>>
</span><?php echo $lic->Status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lic->Waktu->Visible) { // Waktu ?>
	<tr id="r_Waktu"<?php echo $lic->RowAttributes() ?>>
		<td><span id="elh_lic_Waktu"><?php echo $lic->Waktu->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lic->Waktu->CellAttributes() ?>><span id="el_lic_Waktu" class="control-group">
<input type="text" data-field="x_Waktu" name="x_Waktu" id="x_Waktu" placeholder="<?php echo $lic->Waktu->PlaceHolder ?>" value="<?php echo $lic->Waktu->EditValue ?>"<?php echo $lic->Waktu->EditAttributes() ?>>
</span><?php echo $lic->Waktu->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lic->Stamp->Visible) { // Stamp ?>
	<tr id="r_Stamp"<?php echo $lic->RowAttributes() ?>>
		<td><span id="elh_lic_Stamp"><?php echo $lic->Stamp->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lic->Stamp->CellAttributes() ?>><span id="el_lic_Stamp" class="control-group">
<input type="text" data-field="x_Stamp" name="x_Stamp" id="x_Stamp" placeholder="<?php echo $lic->Stamp->PlaceHolder ?>" value="<?php echo $lic->Stamp->EditValue ?>"<?php echo $lic->Stamp->EditAttributes() ?>>
</span><?php echo $lic->Stamp->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
flicadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$lic_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lic_add->Page_Terminate();
?>

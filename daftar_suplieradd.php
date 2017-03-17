<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "daftar_suplierinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$daftar_suplier_add = NULL; // Initialize page object first

class cdaftar_suplier_add extends cdaftar_suplier {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'daftar suplier';

	// Page object name
	var $PageObjName = 'daftar_suplier_add';

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

		// Table object (daftar_suplier)
		if (!isset($GLOBALS["daftar_suplier"])) {
			$GLOBALS["daftar_suplier"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["daftar_suplier"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar suplier', TRUE);

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
			$this->Page_Terminate("daftar_suplierlist.php");
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
					$this->Page_Terminate("daftar_suplierlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "daftar_suplierview.php")
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
		$this->Kode->CurrentValue = NULL;
		$this->Kode->OldValue = $this->Kode->CurrentValue;
		$this->Nama->CurrentValue = NULL;
		$this->Nama->OldValue = $this->Nama->CurrentValue;
		$this->Alamat->CurrentValue = NULL;
		$this->Alamat->OldValue = $this->Alamat->CurrentValue;
		$this->Kota->CurrentValue = NULL;
		$this->Kota->OldValue = $this->Kota->CurrentValue;
		$this->Telepon->CurrentValue = NULL;
		$this->Telepon->OldValue = $this->Telepon->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Kode->FldIsDetailKey) {
			$this->Kode->setFormValue($objForm->GetValue("x_Kode"));
		}
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		if (!$this->Alamat->FldIsDetailKey) {
			$this->Alamat->setFormValue($objForm->GetValue("x_Alamat"));
		}
		if (!$this->Kota->FldIsDetailKey) {
			$this->Kota->setFormValue($objForm->GetValue("x_Kota"));
		}
		if (!$this->Telepon->FldIsDetailKey) {
			$this->Telepon->setFormValue($objForm->GetValue("x_Telepon"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->Nama->CurrentValue = $this->Nama->FormValue;
		$this->Alamat->CurrentValue = $this->Alamat->FormValue;
		$this->Kota->CurrentValue = $this->Kota->FormValue;
		$this->Telepon->CurrentValue = $this->Telepon->FormValue;
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
		$this->Kode->setDbValue($rs->fields('Kode'));
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Kota->setDbValue($rs->fields('Kota'));
		$this->Telepon->setDbValue($rs->fields('Telepon'));
		$this->Fax->setDbValue($rs->fields('Fax'));
		$this->HP->setDbValue($rs->fields('HP'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Website->setDbValue($rs->fields('Website'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Kode->DbValue = $row['Kode'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->Kota->DbValue = $row['Kota'];
		$this->Telepon->DbValue = $row['Telepon'];
		$this->Fax->DbValue = $row['Fax'];
		$this->HP->DbValue = $row['HP'];
		$this->_Email->DbValue = $row['Email'];
		$this->Website->DbValue = $row['Website'];
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
		// Kode
		// Nama
		// Alamat
		// Kota
		// Telepon
		// Fax
		// HP
		// Email
		// Website
		// Waktu
		// Stamp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			$this->Kode->ViewValue = $this->Kode->CurrentValue;
			$this->Kode->ViewCustomAttributes = "";

			// Nama
			$this->Nama->ViewValue = $this->Nama->CurrentValue;
			$this->Nama->ViewCustomAttributes = "";

			// Alamat
			$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
			$this->Alamat->ViewCustomAttributes = "";

			// Kota
			$this->Kota->ViewValue = $this->Kota->CurrentValue;
			$this->Kota->ViewCustomAttributes = "";

			// Telepon
			$this->Telepon->ViewValue = $this->Telepon->CurrentValue;
			$this->Telepon->ViewCustomAttributes = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";
			$this->Alamat->TooltipValue = "";

			// Kota
			$this->Kota->LinkCustomAttributes = "";
			$this->Kota->HrefValue = "";
			$this->Kota->TooltipValue = "";

			// Telepon
			$this->Telepon->LinkCustomAttributes = "";
			$this->Telepon->HrefValue = "";
			$this->Telepon->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->CurrentValue);
			$this->Kode->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kode->FldCaption()));

			// Nama
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Nama->FldCaption()));

			// Alamat
			$this->Alamat->EditCustomAttributes = "";
			$this->Alamat->EditValue = ew_HtmlEncode($this->Alamat->CurrentValue);
			$this->Alamat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Alamat->FldCaption()));

			// Kota
			$this->Kota->EditCustomAttributes = "";
			$this->Kota->EditValue = ew_HtmlEncode($this->Kota->CurrentValue);
			$this->Kota->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kota->FldCaption()));

			// Telepon
			$this->Telepon->EditCustomAttributes = "";
			$this->Telepon->EditValue = ew_HtmlEncode($this->Telepon->CurrentValue);
			$this->Telepon->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Telepon->FldCaption()));

			// Edit refer script
			// Kode

			$this->Kode->HrefValue = "";

			// Nama
			$this->Nama->HrefValue = "";

			// Alamat
			$this->Alamat->HrefValue = "";

			// Kota
			$this->Kota->HrefValue = "";

			// Telepon
			$this->Telepon->HrefValue = "";
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
		if (!$this->Kode->FldIsDetailKey && !is_null($this->Kode->FormValue) && $this->Kode->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Kode->FldCaption());
		}
		if (!$this->Nama->FldIsDetailKey && !is_null($this->Nama->FormValue) && $this->Nama->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Nama->FldCaption());
		}
		if (!$this->Alamat->FldIsDetailKey && !is_null($this->Alamat->FormValue) && $this->Alamat->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Alamat->FldCaption());
		}
		if (!$this->Kota->FldIsDetailKey && !is_null($this->Kota->FormValue) && $this->Kota->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Kota->FldCaption());
		}
		if (!$this->Telepon->FldIsDetailKey && !is_null($this->Telepon->FormValue) && $this->Telepon->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Telepon->FldCaption());
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

		// Kode
		$this->Kode->SetDbValueDef($rsnew, $this->Kode->CurrentValue, "", FALSE);

		// Nama
		$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", FALSE);

		// Alamat
		$this->Alamat->SetDbValueDef($rsnew, $this->Alamat->CurrentValue, "", FALSE);

		// Kota
		$this->Kota->SetDbValueDef($rsnew, $this->Kota->CurrentValue, "", FALSE);

		// Telepon
		$this->Telepon->SetDbValueDef($rsnew, $this->Telepon->CurrentValue, "", FALSE);

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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "daftar_suplierlist.php", $this->TableVar);
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
if (!isset($daftar_suplier_add)) $daftar_suplier_add = new cdaftar_suplier_add();

// Page init
$daftar_suplier_add->Page_Init();

// Page main
$daftar_suplier_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$daftar_suplier_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var daftar_suplier_add = new ew_Page("daftar_suplier_add");
daftar_suplier_add.PageID = "add"; // Page ID
var EW_PAGE_ID = daftar_suplier_add.PageID; // For backward compatibility

// Form object
var fdaftar_suplieradd = new ew_Form("fdaftar_suplieradd");

// Validate form
fdaftar_suplieradd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Kode");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_suplier->Kode->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_suplier->Nama->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Alamat");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_suplier->Alamat->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Kota");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_suplier->Kota->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Telepon");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_suplier->Telepon->FldCaption()) ?>");

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
fdaftar_suplieradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdaftar_suplieradd.ValidateRequired = true;
<?php } else { ?>
fdaftar_suplieradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $daftar_suplier_add->ShowPageHeader(); ?>
<?php
$daftar_suplier_add->ShowMessage();
?>
<form name="fdaftar_suplieradd" id="fdaftar_suplieradd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="daftar_suplier">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_daftar_suplieradd" class="table table-bordered table-striped">
<?php if ($daftar_suplier->Kode->Visible) { // Kode ?>
	<tr id="r_Kode"<?php echo $daftar_suplier->RowAttributes() ?>>
		<td><span id="elh_daftar_suplier_Kode"><?php echo $daftar_suplier->Kode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_suplier->Kode->CellAttributes() ?>><span id="el_daftar_suplier_Kode" class="control-group">
<input type="text" data-field="x_Kode" name="x_Kode" id="x_Kode" size="30" maxlength="255" placeholder="<?php echo $daftar_suplier->Kode->PlaceHolder ?>" value="<?php echo $daftar_suplier->Kode->EditValue ?>"<?php echo $daftar_suplier->Kode->EditAttributes() ?>>
</span><?php echo $daftar_suplier->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_suplier->Nama->Visible) { // Nama ?>
	<tr id="r_Nama"<?php echo $daftar_suplier->RowAttributes() ?>>
		<td><span id="elh_daftar_suplier_Nama"><?php echo $daftar_suplier->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_suplier->Nama->CellAttributes() ?>><span id="el_daftar_suplier_Nama" class="control-group">
<input type="text" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="255" placeholder="<?php echo $daftar_suplier->Nama->PlaceHolder ?>" value="<?php echo $daftar_suplier->Nama->EditValue ?>"<?php echo $daftar_suplier->Nama->EditAttributes() ?>>
</span><?php echo $daftar_suplier->Nama->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_suplier->Alamat->Visible) { // Alamat ?>
	<tr id="r_Alamat"<?php echo $daftar_suplier->RowAttributes() ?>>
		<td><span id="elh_daftar_suplier_Alamat"><?php echo $daftar_suplier->Alamat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_suplier->Alamat->CellAttributes() ?>><span id="el_daftar_suplier_Alamat" class="control-group">
<input type="text" data-field="x_Alamat" name="x_Alamat" id="x_Alamat" size="30" maxlength="255" placeholder="<?php echo $daftar_suplier->Alamat->PlaceHolder ?>" value="<?php echo $daftar_suplier->Alamat->EditValue ?>"<?php echo $daftar_suplier->Alamat->EditAttributes() ?>>
</span><?php echo $daftar_suplier->Alamat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_suplier->Kota->Visible) { // Kota ?>
	<tr id="r_Kota"<?php echo $daftar_suplier->RowAttributes() ?>>
		<td><span id="elh_daftar_suplier_Kota"><?php echo $daftar_suplier->Kota->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_suplier->Kota->CellAttributes() ?>><span id="el_daftar_suplier_Kota" class="control-group">
<input type="text" data-field="x_Kota" name="x_Kota" id="x_Kota" size="30" maxlength="255" placeholder="<?php echo $daftar_suplier->Kota->PlaceHolder ?>" value="<?php echo $daftar_suplier->Kota->EditValue ?>"<?php echo $daftar_suplier->Kota->EditAttributes() ?>>
</span><?php echo $daftar_suplier->Kota->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_suplier->Telepon->Visible) { // Telepon ?>
	<tr id="r_Telepon"<?php echo $daftar_suplier->RowAttributes() ?>>
		<td><span id="elh_daftar_suplier_Telepon"><?php echo $daftar_suplier->Telepon->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_suplier->Telepon->CellAttributes() ?>><span id="el_daftar_suplier_Telepon" class="control-group">
<input type="text" data-field="x_Telepon" name="x_Telepon" id="x_Telepon" size="30" maxlength="255" placeholder="<?php echo $daftar_suplier->Telepon->PlaceHolder ?>" value="<?php echo $daftar_suplier->Telepon->EditValue ?>"<?php echo $daftar_suplier->Telepon->EditAttributes() ?>>
</span><?php echo $daftar_suplier->Telepon->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fdaftar_suplieradd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$daftar_suplier_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$daftar_suplier_add->Page_Terminate();
?>

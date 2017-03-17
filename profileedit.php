<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "profileinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$profile_edit = NULL; // Initialize page object first

class cprofile_edit extends cprofile {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'profile';

	// Page object name
	var $PageObjName = 'profile_edit';

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

		// Table object (profile)
		if (!isset($GLOBALS["profile"])) {
			$GLOBALS["profile"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["profile"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'profile', TRUE);

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
			$this->Page_Terminate("profilelist.php");
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
			$this->Page_Terminate("profilelist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("profilelist.php"); // No matching record, return to list
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
		if (!$this->NamaToko->FldIsDetailKey) {
			$this->NamaToko->setFormValue($objForm->GetValue("x_NamaToko"));
		}
		if (!$this->Pemilik->FldIsDetailKey) {
			$this->Pemilik->setFormValue($objForm->GetValue("x_Pemilik"));
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
		if (!$this->_Email->FldIsDetailKey) {
			$this->_Email->setFormValue($objForm->GetValue("x__Email"));
		}
		if (!$this->Mobile->FldIsDetailKey) {
			$this->Mobile->setFormValue($objForm->GetValue("x_Mobile"));
		}
		if (!$this->ID->FldIsDetailKey)
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->ID->CurrentValue = $this->ID->FormValue;
		$this->NamaToko->CurrentValue = $this->NamaToko->FormValue;
		$this->Pemilik->CurrentValue = $this->Pemilik->FormValue;
		$this->Alamat->CurrentValue = $this->Alamat->FormValue;
		$this->Kota->CurrentValue = $this->Kota->FormValue;
		$this->Telepon->CurrentValue = $this->Telepon->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
		$this->Mobile->CurrentValue = $this->Mobile->FormValue;
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
		$this->NamaToko->setDbValue($rs->fields('NamaToko'));
		$this->Pemilik->setDbValue($rs->fields('Pemilik'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Kota->setDbValue($rs->fields('Kota'));
		$this->Telepon->setDbValue($rs->fields('Telepon'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Foto->Upload->DbValue = $rs->fields('Foto');
		$this->Serial->setDbValue($rs->fields('Serial'));
		$this->KeyCode->setDbValue($rs->fields('KeyCode'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
		$this->Mobile->setDbValue($rs->fields('Mobile'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Kode->DbValue = $row['Kode'];
		$this->NamaToko->DbValue = $row['NamaToko'];
		$this->Pemilik->DbValue = $row['Pemilik'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->Kota->DbValue = $row['Kota'];
		$this->Telepon->DbValue = $row['Telepon'];
		$this->_Email->DbValue = $row['Email'];
		$this->Foto->Upload->DbValue = $row['Foto'];
		$this->Serial->DbValue = $row['Serial'];
		$this->KeyCode->DbValue = $row['KeyCode'];
		$this->Waktu->DbValue = $row['Waktu'];
		$this->Stamp->DbValue = $row['Stamp'];
		$this->Mobile->DbValue = $row['Mobile'];
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
		// NamaToko
		// Pemilik
		// Alamat
		// Kota
		// Telepon
		// Email
		// Foto
		// Serial
		// KeyCode
		// Waktu
		// Stamp
		// Mobile

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// NamaToko
			$this->NamaToko->ViewValue = $this->NamaToko->CurrentValue;
			$this->NamaToko->ViewCustomAttributes = "";

			// Pemilik
			$this->Pemilik->ViewValue = $this->Pemilik->CurrentValue;
			$this->Pemilik->ViewCustomAttributes = "";

			// Alamat
			$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
			$this->Alamat->ViewCustomAttributes = "";

			// Kota
			$this->Kota->ViewValue = $this->Kota->CurrentValue;
			$this->Kota->ViewCustomAttributes = "";

			// Telepon
			$this->Telepon->ViewValue = $this->Telepon->CurrentValue;
			$this->Telepon->ViewCustomAttributes = "";

			// Email
			$this->_Email->ViewValue = $this->_Email->CurrentValue;
			$this->_Email->ViewCustomAttributes = "";

			// Mobile
			if (strval($this->Mobile->CurrentValue) <> "") {
				switch ($this->Mobile->CurrentValue) {
					case $this->Mobile->FldTagValue(1):
						$this->Mobile->ViewValue = $this->Mobile->FldTagCaption(1) <> "" ? $this->Mobile->FldTagCaption(1) : $this->Mobile->CurrentValue;
						break;
					case $this->Mobile->FldTagValue(2):
						$this->Mobile->ViewValue = $this->Mobile->FldTagCaption(2) <> "" ? $this->Mobile->FldTagCaption(2) : $this->Mobile->CurrentValue;
						break;
					default:
						$this->Mobile->ViewValue = $this->Mobile->CurrentValue;
				}
			} else {
				$this->Mobile->ViewValue = NULL;
			}
			$this->Mobile->ViewCustomAttributes = "";

			// NamaToko
			$this->NamaToko->LinkCustomAttributes = "";
			$this->NamaToko->HrefValue = "";
			$this->NamaToko->TooltipValue = "";

			// Pemilik
			$this->Pemilik->LinkCustomAttributes = "";
			$this->Pemilik->HrefValue = "";
			$this->Pemilik->TooltipValue = "";

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

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";

			// Mobile
			$this->Mobile->LinkCustomAttributes = "";
			$this->Mobile->HrefValue = "";
			$this->Mobile->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// NamaToko
			$this->NamaToko->EditCustomAttributes = "";
			$this->NamaToko->EditValue = ew_HtmlEncode($this->NamaToko->CurrentValue);
			$this->NamaToko->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NamaToko->FldCaption()));

			// Pemilik
			$this->Pemilik->EditCustomAttributes = "";
			$this->Pemilik->EditValue = ew_HtmlEncode($this->Pemilik->CurrentValue);
			$this->Pemilik->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Pemilik->FldCaption()));

			// Alamat
			$this->Alamat->EditCustomAttributes = "";
			$this->Alamat->EditValue = $this->Alamat->CurrentValue;
			$this->Alamat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Alamat->FldCaption()));

			// Kota
			$this->Kota->EditCustomAttributes = "";
			$this->Kota->EditValue = ew_HtmlEncode($this->Kota->CurrentValue);
			$this->Kota->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kota->FldCaption()));

			// Telepon
			$this->Telepon->EditCustomAttributes = "";
			$this->Telepon->EditValue = ew_HtmlEncode($this->Telepon->CurrentValue);
			$this->Telepon->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Telepon->FldCaption()));

			// Email
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue = ew_HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_Email->FldCaption()));

			// Mobile
			$this->Mobile->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Mobile->FldTagValue(1), $this->Mobile->FldTagCaption(1) <> "" ? $this->Mobile->FldTagCaption(1) : $this->Mobile->FldTagValue(1));
			$arwrk[] = array($this->Mobile->FldTagValue(2), $this->Mobile->FldTagCaption(2) <> "" ? $this->Mobile->FldTagCaption(2) : $this->Mobile->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->Mobile->EditValue = $arwrk;

			// Edit refer script
			// NamaToko

			$this->NamaToko->HrefValue = "";

			// Pemilik
			$this->Pemilik->HrefValue = "";

			// Alamat
			$this->Alamat->HrefValue = "";

			// Kota
			$this->Kota->HrefValue = "";

			// Telepon
			$this->Telepon->HrefValue = "";

			// Email
			$this->_Email->HrefValue = "";

			// Mobile
			$this->Mobile->HrefValue = "";
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
		if (!$this->Pemilik->FldIsDetailKey && !is_null($this->Pemilik->FormValue) && $this->Pemilik->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Pemilik->FldCaption());
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
		if (!$this->Mobile->FldIsDetailKey && !is_null($this->Mobile->FormValue) && $this->Mobile->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Mobile->FldCaption());
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

			// NamaToko
			$this->NamaToko->SetDbValueDef($rsnew, $this->NamaToko->CurrentValue, NULL, $this->NamaToko->ReadOnly);

			// Pemilik
			$this->Pemilik->SetDbValueDef($rsnew, $this->Pemilik->CurrentValue, "", $this->Pemilik->ReadOnly);

			// Alamat
			$this->Alamat->SetDbValueDef($rsnew, $this->Alamat->CurrentValue, "", $this->Alamat->ReadOnly);

			// Kota
			$this->Kota->SetDbValueDef($rsnew, $this->Kota->CurrentValue, "", $this->Kota->ReadOnly);

			// Telepon
			$this->Telepon->SetDbValueDef($rsnew, $this->Telepon->CurrentValue, "", $this->Telepon->ReadOnly);

			// Email
			$this->_Email->SetDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, $this->_Email->ReadOnly);

			// Mobile
			$this->Mobile->SetDbValueDef($rsnew, $this->Mobile->CurrentValue, 0, $this->Mobile->ReadOnly);

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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "profilelist.php", $this->TableVar);
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
if (!isset($profile_edit)) $profile_edit = new cprofile_edit();

// Page init
$profile_edit->Page_Init();

// Page main
$profile_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$profile_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var profile_edit = new ew_Page("profile_edit");
profile_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = profile_edit.PageID; // For backward compatibility

// Form object
var fprofileedit = new ew_Form("fprofileedit");

// Validate form
fprofileedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Pemilik");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Pemilik->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Alamat");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Alamat->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Kota");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Kota->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Telepon");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Telepon->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Mobile");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Mobile->FldCaption()) ?>");

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
fprofileedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprofileedit.ValidateRequired = true;
<?php } else { ?>
fprofileedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $profile_edit->ShowPageHeader(); ?>
<?php
$profile_edit->ShowMessage();
?>
<form name="fprofileedit" id="fprofileedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="profile">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_profileedit" class="table table-bordered table-striped">
<?php if ($profile->NamaToko->Visible) { // NamaToko ?>
	<tr id="r_NamaToko"<?php echo $profile->RowAttributes() ?>>
		<td><span id="elh_profile_NamaToko"><?php echo $profile->NamaToko->FldCaption() ?></span></td>
		<td<?php echo $profile->NamaToko->CellAttributes() ?>><span id="el_profile_NamaToko" class="control-group">
<input type="text" data-field="x_NamaToko" name="x_NamaToko" id="x_NamaToko" size="30" maxlength="255" placeholder="<?php echo $profile->NamaToko->PlaceHolder ?>" value="<?php echo $profile->NamaToko->EditValue ?>"<?php echo $profile->NamaToko->EditAttributes() ?>>
</span><?php echo $profile->NamaToko->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->Pemilik->Visible) { // Pemilik ?>
	<tr id="r_Pemilik"<?php echo $profile->RowAttributes() ?>>
		<td><span id="elh_profile_Pemilik"><?php echo $profile->Pemilik->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $profile->Pemilik->CellAttributes() ?>><span id="el_profile_Pemilik" class="control-group">
<input type="text" data-field="x_Pemilik" name="x_Pemilik" id="x_Pemilik" size="30" maxlength="255" placeholder="<?php echo $profile->Pemilik->PlaceHolder ?>" value="<?php echo $profile->Pemilik->EditValue ?>"<?php echo $profile->Pemilik->EditAttributes() ?>>
</span><?php echo $profile->Pemilik->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->Alamat->Visible) { // Alamat ?>
	<tr id="r_Alamat"<?php echo $profile->RowAttributes() ?>>
		<td><span id="elh_profile_Alamat"><?php echo $profile->Alamat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $profile->Alamat->CellAttributes() ?>><span id="el_profile_Alamat" class="control-group">
<textarea data-field="x_Alamat" name="x_Alamat" id="x_Alamat" cols="35" rows="4" placeholder="<?php echo $profile->Alamat->PlaceHolder ?>"<?php echo $profile->Alamat->EditAttributes() ?>><?php echo $profile->Alamat->EditValue ?></textarea>
</span><?php echo $profile->Alamat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->Kota->Visible) { // Kota ?>
	<tr id="r_Kota"<?php echo $profile->RowAttributes() ?>>
		<td><span id="elh_profile_Kota"><?php echo $profile->Kota->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $profile->Kota->CellAttributes() ?>><span id="el_profile_Kota" class="control-group">
<input type="text" data-field="x_Kota" name="x_Kota" id="x_Kota" size="30" maxlength="255" placeholder="<?php echo $profile->Kota->PlaceHolder ?>" value="<?php echo $profile->Kota->EditValue ?>"<?php echo $profile->Kota->EditAttributes() ?>>
</span><?php echo $profile->Kota->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->Telepon->Visible) { // Telepon ?>
	<tr id="r_Telepon"<?php echo $profile->RowAttributes() ?>>
		<td><span id="elh_profile_Telepon"><?php echo $profile->Telepon->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $profile->Telepon->CellAttributes() ?>><span id="el_profile_Telepon" class="control-group">
<input type="text" data-field="x_Telepon" name="x_Telepon" id="x_Telepon" size="30" maxlength="255" placeholder="<?php echo $profile->Telepon->PlaceHolder ?>" value="<?php echo $profile->Telepon->EditValue ?>"<?php echo $profile->Telepon->EditAttributes() ?>>
</span><?php echo $profile->Telepon->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->_Email->Visible) { // Email ?>
	<tr id="r__Email"<?php echo $profile->RowAttributes() ?>>
		<td><span id="elh_profile__Email"><?php echo $profile->_Email->FldCaption() ?></span></td>
		<td<?php echo $profile->_Email->CellAttributes() ?>><span id="el_profile__Email" class="control-group">
<input type="text" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="100" placeholder="<?php echo $profile->_Email->PlaceHolder ?>" value="<?php echo $profile->_Email->EditValue ?>"<?php echo $profile->_Email->EditAttributes() ?>>
</span><?php echo $profile->_Email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->Mobile->Visible) { // Mobile ?>
	<tr id="r_Mobile"<?php echo $profile->RowAttributes() ?>>
		<td><span id="elh_profile_Mobile"><?php echo $profile->Mobile->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $profile->Mobile->CellAttributes() ?>><span id="el_profile_Mobile" class="control-group">
<select data-field="x_Mobile" id="x_Mobile" name="x_Mobile"<?php echo $profile->Mobile->EditAttributes() ?>>
<?php
if (is_array($profile->Mobile->EditValue)) {
	$arwrk = $profile->Mobile->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($profile->Mobile->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $profile->Mobile->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<input type="hidden" data-field="x_ID" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($profile->ID->CurrentValue) ?>">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fprofileedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$profile_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$profile_edit->Page_Terminate();
?>

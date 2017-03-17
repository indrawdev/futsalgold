<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "daftar_lapanganinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$daftar_lapangan_edit = NULL; // Initialize page object first

class cdaftar_lapangan_edit extends cdaftar_lapangan {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'daftar lapangan';

	// Page object name
	var $PageObjName = 'daftar_lapangan_edit';

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

		// Table object (daftar_lapangan)
		if (!isset($GLOBALS["daftar_lapangan"])) {
			$GLOBALS["daftar_lapangan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["daftar_lapangan"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar lapangan', TRUE);

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
			$this->Page_Terminate("daftar_lapanganlist.php");
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
			$this->Page_Terminate("daftar_lapanganlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("daftar_lapanganlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
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
		if (!$this->Kode->FldIsDetailKey) {
			$this->Kode->setFormValue($objForm->GetValue("x_Kode"));
		}
		if (!$this->NamaLapangan->FldIsDetailKey) {
			$this->NamaLapangan->setFormValue($objForm->GetValue("x_NamaLapangan"));
		}
		if (!$this->Ukuran->FldIsDetailKey) {
			$this->Ukuran->setFormValue($objForm->GetValue("x_Ukuran"));
		}
		if (!$this->Kondisi->FldIsDetailKey) {
			$this->Kondisi->setFormValue($objForm->GetValue("x_Kondisi"));
		}
		if (!$this->HargaSewa1->FldIsDetailKey) {
			$this->HargaSewa1->setFormValue($objForm->GetValue("x_HargaSewa1"));
		}
		if (!$this->HargaSewa2->FldIsDetailKey) {
			$this->HargaSewa2->setFormValue($objForm->GetValue("x_HargaSewa2"));
		}
		if (!$this->HargaSewa3->FldIsDetailKey) {
			$this->HargaSewa3->setFormValue($objForm->GetValue("x_HargaSewa3"));
		}
		if (!$this->HargaSewa4->FldIsDetailKey) {
			$this->HargaSewa4->setFormValue($objForm->GetValue("x_HargaSewa4"));
		}
		if (!$this->ID->FldIsDetailKey)
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->ID->CurrentValue = $this->ID->FormValue;
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->NamaLapangan->CurrentValue = $this->NamaLapangan->FormValue;
		$this->Ukuran->CurrentValue = $this->Ukuran->FormValue;
		$this->Kondisi->CurrentValue = $this->Kondisi->FormValue;
		$this->HargaSewa1->CurrentValue = $this->HargaSewa1->FormValue;
		$this->HargaSewa2->CurrentValue = $this->HargaSewa2->FormValue;
		$this->HargaSewa3->CurrentValue = $this->HargaSewa3->FormValue;
		$this->HargaSewa4->CurrentValue = $this->HargaSewa4->FormValue;
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
		$this->NamaLapangan->setDbValue($rs->fields('NamaLapangan'));
		$this->Ukuran->setDbValue($rs->fields('Ukuran'));
		$this->Kondisi->setDbValue($rs->fields('Kondisi'));
		$this->HargaSewa1->setDbValue($rs->fields('HargaSewa1'));
		$this->HargaSewa2->setDbValue($rs->fields('HargaSewa2'));
		$this->HargaSewa3->setDbValue($rs->fields('HargaSewa3'));
		$this->HargaSewa4->setDbValue($rs->fields('HargaSewa4'));
		$this->HargaSewa5->setDbValue($rs->fields('HargaSewa5'));
		$this->Member->setDbValue($rs->fields('Member'));
		$this->NonMember->setDbValue($rs->fields('NonMember'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Kode->DbValue = $row['Kode'];
		$this->NamaLapangan->DbValue = $row['NamaLapangan'];
		$this->Ukuran->DbValue = $row['Ukuran'];
		$this->Kondisi->DbValue = $row['Kondisi'];
		$this->HargaSewa1->DbValue = $row['HargaSewa1'];
		$this->HargaSewa2->DbValue = $row['HargaSewa2'];
		$this->HargaSewa3->DbValue = $row['HargaSewa3'];
		$this->HargaSewa4->DbValue = $row['HargaSewa4'];
		$this->HargaSewa5->DbValue = $row['HargaSewa5'];
		$this->Member->DbValue = $row['Member'];
		$this->NonMember->DbValue = $row['NonMember'];
		$this->Waktu->DbValue = $row['Waktu'];
		$this->Stamp->DbValue = $row['Stamp'];
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
		// NamaLapangan
		// Ukuran
		// Kondisi
		// HargaSewa1
		// HargaSewa2
		// HargaSewa3
		// HargaSewa4
		// HargaSewa5
		// Member
		// NonMember
		// Waktu
		// Stamp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			$this->Kode->ViewValue = $this->Kode->CurrentValue;
			$this->Kode->ViewCustomAttributes = "";

			// NamaLapangan
			$this->NamaLapangan->ViewValue = $this->NamaLapangan->CurrentValue;
			$this->NamaLapangan->ViewCustomAttributes = "";

			// Ukuran
			$this->Ukuran->ViewValue = $this->Ukuran->CurrentValue;
			$this->Ukuran->ViewCustomAttributes = "";

			// Kondisi
			$this->Kondisi->ViewValue = $this->Kondisi->CurrentValue;
			$this->Kondisi->ViewCustomAttributes = "";

			// HargaSewa1
			$this->HargaSewa1->ViewValue = $this->HargaSewa1->CurrentValue;
			$this->HargaSewa1->ViewValue = ew_FormatNumber($this->HargaSewa1->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa1->CellCssStyle .= "text-align: right;";
			$this->HargaSewa1->ViewCustomAttributes = "";

			// HargaSewa2
			$this->HargaSewa2->ViewValue = $this->HargaSewa2->CurrentValue;
			$this->HargaSewa2->ViewValue = ew_FormatNumber($this->HargaSewa2->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa2->CellCssStyle .= "text-align: right;";
			$this->HargaSewa2->ViewCustomAttributes = "";

			// HargaSewa3
			$this->HargaSewa3->ViewValue = $this->HargaSewa3->CurrentValue;
			$this->HargaSewa3->ViewValue = ew_FormatNumber($this->HargaSewa3->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa3->CellCssStyle .= "text-align: right;";
			$this->HargaSewa3->ViewCustomAttributes = "";

			// HargaSewa4
			$this->HargaSewa4->ViewValue = $this->HargaSewa4->CurrentValue;
			$this->HargaSewa4->ViewValue = ew_FormatNumber($this->HargaSewa4->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa4->CellCssStyle .= "text-align: right;";
			$this->HargaSewa4->ViewCustomAttributes = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// NamaLapangan
			$this->NamaLapangan->LinkCustomAttributes = "";
			$this->NamaLapangan->HrefValue = "";
			$this->NamaLapangan->TooltipValue = "";

			// Ukuran
			$this->Ukuran->LinkCustomAttributes = "";
			$this->Ukuran->HrefValue = "";
			$this->Ukuran->TooltipValue = "";

			// Kondisi
			$this->Kondisi->LinkCustomAttributes = "";
			$this->Kondisi->HrefValue = "";
			$this->Kondisi->TooltipValue = "";

			// HargaSewa1
			$this->HargaSewa1->LinkCustomAttributes = "";
			$this->HargaSewa1->HrefValue = "";
			$this->HargaSewa1->TooltipValue = "";

			// HargaSewa2
			$this->HargaSewa2->LinkCustomAttributes = "";
			$this->HargaSewa2->HrefValue = "";
			$this->HargaSewa2->TooltipValue = "";

			// HargaSewa3
			$this->HargaSewa3->LinkCustomAttributes = "";
			$this->HargaSewa3->HrefValue = "";
			$this->HargaSewa3->TooltipValue = "";

			// HargaSewa4
			$this->HargaSewa4->LinkCustomAttributes = "";
			$this->HargaSewa4->HrefValue = "";
			$this->HargaSewa4->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->CurrentValue);
			$this->Kode->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kode->FldCaption()));

			// NamaLapangan
			$this->NamaLapangan->EditCustomAttributes = "";
			$this->NamaLapangan->EditValue = ew_HtmlEncode($this->NamaLapangan->CurrentValue);
			$this->NamaLapangan->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NamaLapangan->FldCaption()));

			// Ukuran
			$this->Ukuran->EditCustomAttributes = "";
			$this->Ukuran->EditValue = ew_HtmlEncode($this->Ukuran->CurrentValue);
			$this->Ukuran->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Ukuran->FldCaption()));

			// Kondisi
			$this->Kondisi->EditCustomAttributes = "";
			$this->Kondisi->EditValue = ew_HtmlEncode($this->Kondisi->CurrentValue);
			$this->Kondisi->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kondisi->FldCaption()));

			// HargaSewa1
			$this->HargaSewa1->EditCustomAttributes = "";
			$this->HargaSewa1->EditValue = ew_HtmlEncode($this->HargaSewa1->CurrentValue);
			$this->HargaSewa1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa1->FldCaption()));

			// HargaSewa2
			$this->HargaSewa2->EditCustomAttributes = "";
			$this->HargaSewa2->EditValue = ew_HtmlEncode($this->HargaSewa2->CurrentValue);
			$this->HargaSewa2->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa2->FldCaption()));

			// HargaSewa3
			$this->HargaSewa3->EditCustomAttributes = "";
			$this->HargaSewa3->EditValue = ew_HtmlEncode($this->HargaSewa3->CurrentValue);
			$this->HargaSewa3->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa3->FldCaption()));

			// HargaSewa4
			$this->HargaSewa4->EditCustomAttributes = "";
			$this->HargaSewa4->EditValue = ew_HtmlEncode($this->HargaSewa4->CurrentValue);
			$this->HargaSewa4->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa4->FldCaption()));

			// Edit refer script
			// Kode

			$this->Kode->HrefValue = "";

			// NamaLapangan
			$this->NamaLapangan->HrefValue = "";

			// Ukuran
			$this->Ukuran->HrefValue = "";

			// Kondisi
			$this->Kondisi->HrefValue = "";

			// HargaSewa1
			$this->HargaSewa1->HrefValue = "";

			// HargaSewa2
			$this->HargaSewa2->HrefValue = "";

			// HargaSewa3
			$this->HargaSewa3->HrefValue = "";

			// HargaSewa4
			$this->HargaSewa4->HrefValue = "";
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
		if (!ew_CheckInteger($this->HargaSewa1->FormValue)) {
			ew_AddMessage($gsFormError, $this->HargaSewa1->FldErrMsg());
		}
		if (!ew_CheckInteger($this->HargaSewa2->FormValue)) {
			ew_AddMessage($gsFormError, $this->HargaSewa2->FldErrMsg());
		}
		if (!ew_CheckInteger($this->HargaSewa3->FormValue)) {
			ew_AddMessage($gsFormError, $this->HargaSewa3->FldErrMsg());
		}
		if (!ew_CheckInteger($this->HargaSewa4->FormValue)) {
			ew_AddMessage($gsFormError, $this->HargaSewa4->FldErrMsg());
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

			// Kode
			$this->Kode->SetDbValueDef($rsnew, $this->Kode->CurrentValue, "", $this->Kode->ReadOnly);

			// NamaLapangan
			$this->NamaLapangan->SetDbValueDef($rsnew, $this->NamaLapangan->CurrentValue, NULL, $this->NamaLapangan->ReadOnly);

			// Ukuran
			$this->Ukuran->SetDbValueDef($rsnew, $this->Ukuran->CurrentValue, NULL, $this->Ukuran->ReadOnly);

			// Kondisi
			$this->Kondisi->SetDbValueDef($rsnew, $this->Kondisi->CurrentValue, NULL, $this->Kondisi->ReadOnly);

			// HargaSewa1
			$this->HargaSewa1->SetDbValueDef($rsnew, $this->HargaSewa1->CurrentValue, NULL, $this->HargaSewa1->ReadOnly);

			// HargaSewa2
			$this->HargaSewa2->SetDbValueDef($rsnew, $this->HargaSewa2->CurrentValue, NULL, $this->HargaSewa2->ReadOnly);

			// HargaSewa3
			$this->HargaSewa3->SetDbValueDef($rsnew, $this->HargaSewa3->CurrentValue, NULL, $this->HargaSewa3->ReadOnly);

			// HargaSewa4
			$this->HargaSewa4->SetDbValueDef($rsnew, $this->HargaSewa4->CurrentValue, NULL, $this->HargaSewa4->ReadOnly);

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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "daftar_lapanganlist.php", $this->TableVar);
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
if (!isset($daftar_lapangan_edit)) $daftar_lapangan_edit = new cdaftar_lapangan_edit();

// Page init
$daftar_lapangan_edit->Page_Init();

// Page main
$daftar_lapangan_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$daftar_lapangan_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var daftar_lapangan_edit = new ew_Page("daftar_lapangan_edit");
daftar_lapangan_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = daftar_lapangan_edit.PageID; // For backward compatibility

// Form object
var fdaftar_lapanganedit = new ew_Form("fdaftar_lapanganedit");

// Validate form
fdaftar_lapanganedit.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_lapangan->Kode->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_HargaSewa1");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_lapangan->HargaSewa1->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_HargaSewa2");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_lapangan->HargaSewa2->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_HargaSewa3");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_lapangan->HargaSewa3->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_HargaSewa4");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_lapangan->HargaSewa4->FldErrMsg()) ?>");

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
fdaftar_lapanganedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdaftar_lapanganedit.ValidateRequired = true;
<?php } else { ?>
fdaftar_lapanganedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $daftar_lapangan_edit->ShowPageHeader(); ?>
<?php
$daftar_lapangan_edit->ShowMessage();
?>
<form name="fdaftar_lapanganedit" id="fdaftar_lapanganedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="daftar_lapangan">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_daftar_lapanganedit" class="table table-bordered table-striped">
<?php if ($daftar_lapangan->Kode->Visible) { // Kode ?>
	<tr id="r_Kode"<?php echo $daftar_lapangan->RowAttributes() ?>>
		<td><span id="elh_daftar_lapangan_Kode"><?php echo $daftar_lapangan->Kode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_lapangan->Kode->CellAttributes() ?>><span id="el_daftar_lapangan_Kode" class="control-group">
<input type="text" data-field="x_Kode" name="x_Kode" id="x_Kode" size="30" maxlength="50" placeholder="<?php echo $daftar_lapangan->Kode->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Kode->EditValue ?>"<?php echo $daftar_lapangan->Kode->EditAttributes() ?>>
</span><?php echo $daftar_lapangan->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->NamaLapangan->Visible) { // NamaLapangan ?>
	<tr id="r_NamaLapangan"<?php echo $daftar_lapangan->RowAttributes() ?>>
		<td><span id="elh_daftar_lapangan_NamaLapangan"><?php echo $daftar_lapangan->NamaLapangan->FldCaption() ?></span></td>
		<td<?php echo $daftar_lapangan->NamaLapangan->CellAttributes() ?>><span id="el_daftar_lapangan_NamaLapangan" class="control-group">
<input type="text" data-field="x_NamaLapangan" name="x_NamaLapangan" id="x_NamaLapangan" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->NamaLapangan->PlaceHolder ?>" value="<?php echo $daftar_lapangan->NamaLapangan->EditValue ?>"<?php echo $daftar_lapangan->NamaLapangan->EditAttributes() ?>>
</span><?php echo $daftar_lapangan->NamaLapangan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->Ukuran->Visible) { // Ukuran ?>
	<tr id="r_Ukuran"<?php echo $daftar_lapangan->RowAttributes() ?>>
		<td><span id="elh_daftar_lapangan_Ukuran"><?php echo $daftar_lapangan->Ukuran->FldCaption() ?></span></td>
		<td<?php echo $daftar_lapangan->Ukuran->CellAttributes() ?>><span id="el_daftar_lapangan_Ukuran" class="control-group">
<input type="text" data-field="x_Ukuran" name="x_Ukuran" id="x_Ukuran" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->Ukuran->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Ukuran->EditValue ?>"<?php echo $daftar_lapangan->Ukuran->EditAttributes() ?>>
</span><?php echo $daftar_lapangan->Ukuran->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->Kondisi->Visible) { // Kondisi ?>
	<tr id="r_Kondisi"<?php echo $daftar_lapangan->RowAttributes() ?>>
		<td><span id="elh_daftar_lapangan_Kondisi"><?php echo $daftar_lapangan->Kondisi->FldCaption() ?></span></td>
		<td<?php echo $daftar_lapangan->Kondisi->CellAttributes() ?>><span id="el_daftar_lapangan_Kondisi" class="control-group">
<input type="text" data-field="x_Kondisi" name="x_Kondisi" id="x_Kondisi" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->Kondisi->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Kondisi->EditValue ?>"<?php echo $daftar_lapangan->Kondisi->EditAttributes() ?>>
</span><?php echo $daftar_lapangan->Kondisi->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->HargaSewa1->Visible) { // HargaSewa1 ?>
	<tr id="r_HargaSewa1"<?php echo $daftar_lapangan->RowAttributes() ?>>
		<td><span id="elh_daftar_lapangan_HargaSewa1"><?php echo $daftar_lapangan->HargaSewa1->FldCaption() ?></span></td>
		<td<?php echo $daftar_lapangan->HargaSewa1->CellAttributes() ?>><span id="el_daftar_lapangan_HargaSewa1" class="control-group">
<input type="text" data-field="x_HargaSewa1" name="x_HargaSewa1" id="x_HargaSewa1" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa1->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa1->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa1->EditAttributes() ?>>
</span><?php echo $daftar_lapangan->HargaSewa1->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->HargaSewa2->Visible) { // HargaSewa2 ?>
	<tr id="r_HargaSewa2"<?php echo $daftar_lapangan->RowAttributes() ?>>
		<td><span id="elh_daftar_lapangan_HargaSewa2"><?php echo $daftar_lapangan->HargaSewa2->FldCaption() ?></span></td>
		<td<?php echo $daftar_lapangan->HargaSewa2->CellAttributes() ?>><span id="el_daftar_lapangan_HargaSewa2" class="control-group">
<input type="text" data-field="x_HargaSewa2" name="x_HargaSewa2" id="x_HargaSewa2" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa2->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa2->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa2->EditAttributes() ?>>
</span><?php echo $daftar_lapangan->HargaSewa2->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->HargaSewa3->Visible) { // HargaSewa3 ?>
	<tr id="r_HargaSewa3"<?php echo $daftar_lapangan->RowAttributes() ?>>
		<td><span id="elh_daftar_lapangan_HargaSewa3"><?php echo $daftar_lapangan->HargaSewa3->FldCaption() ?></span></td>
		<td<?php echo $daftar_lapangan->HargaSewa3->CellAttributes() ?>><span id="el_daftar_lapangan_HargaSewa3" class="control-group">
<input type="text" data-field="x_HargaSewa3" name="x_HargaSewa3" id="x_HargaSewa3" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa3->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa3->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa3->EditAttributes() ?>>
</span><?php echo $daftar_lapangan->HargaSewa3->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->HargaSewa4->Visible) { // HargaSewa4 ?>
	<tr id="r_HargaSewa4"<?php echo $daftar_lapangan->RowAttributes() ?>>
		<td><span id="elh_daftar_lapangan_HargaSewa4"><?php echo $daftar_lapangan->HargaSewa4->FldCaption() ?></span></td>
		<td<?php echo $daftar_lapangan->HargaSewa4->CellAttributes() ?>><span id="el_daftar_lapangan_HargaSewa4" class="control-group">
<input type="text" data-field="x_HargaSewa4" name="x_HargaSewa4" id="x_HargaSewa4" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa4->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa4->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa4->EditAttributes() ?>>
</span><?php echo $daftar_lapangan->HargaSewa4->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<input type="hidden" data-field="x_ID" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($daftar_lapangan->ID->CurrentValue) ?>">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fdaftar_lapanganedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$daftar_lapangan_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$daftar_lapangan_edit->Page_Terminate();
?>

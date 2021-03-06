<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "daftar_pelangganinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$daftar_pelanggan_edit = NULL; // Initialize page object first

class cdaftar_pelanggan_edit extends cdaftar_pelanggan {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'daftar pelanggan';

	// Page object name
	var $PageObjName = 'daftar_pelanggan_edit';

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

		// Table object (daftar_pelanggan)
		if (!isset($GLOBALS["daftar_pelanggan"])) {
			$GLOBALS["daftar_pelanggan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["daftar_pelanggan"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar pelanggan', TRUE);

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
			$this->Page_Terminate("daftar_pelangganlist.php");
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
			$this->Page_Terminate("daftar_pelangganlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("daftar_pelangganlist.php"); // No matching record, return to list
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
		if (!$this->NamaPenyewa->FldIsDetailKey) {
			$this->NamaPenyewa->setFormValue($objForm->GetValue("x_NamaPenyewa"));
		}
		if (!$this->NamaTeam->FldIsDetailKey) {
			$this->NamaTeam->setFormValue($objForm->GetValue("x_NamaTeam"));
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
		if (!$this->ID->FldIsDetailKey)
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->ID->CurrentValue = $this->ID->FormValue;
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->NamaPenyewa->CurrentValue = $this->NamaPenyewa->FormValue;
		$this->NamaTeam->CurrentValue = $this->NamaTeam->FormValue;
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
		$this->NamaPenyewa->setDbValue($rs->fields('NamaPenyewa'));
		$this->NamaTeam->setDbValue($rs->fields('NamaTeam'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Kota->setDbValue($rs->fields('Kota'));
		$this->Telepon->setDbValue($rs->fields('Telepon'));
		$this->Fax->setDbValue($rs->fields('Fax'));
		$this->HP->setDbValue($rs->fields('HP'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Website->setDbValue($rs->fields('Website'));
		$this->Main->setDbValue($rs->fields('Main'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Kode->DbValue = $row['Kode'];
		$this->NamaPenyewa->DbValue = $row['NamaPenyewa'];
		$this->NamaTeam->DbValue = $row['NamaTeam'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->Kota->DbValue = $row['Kota'];
		$this->Telepon->DbValue = $row['Telepon'];
		$this->Fax->DbValue = $row['Fax'];
		$this->HP->DbValue = $row['HP'];
		$this->_Email->DbValue = $row['Email'];
		$this->Website->DbValue = $row['Website'];
		$this->Main->DbValue = $row['Main'];
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
		// NamaPenyewa
		// NamaTeam
		// Alamat
		// Kota
		// Telepon
		// Fax
		// HP
		// Email
		// Website
		// Main
		// Waktu
		// Stamp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			$this->Kode->ViewValue = $this->Kode->CurrentValue;
			$this->Kode->ViewCustomAttributes = "";

			// NamaPenyewa
			$this->NamaPenyewa->ViewValue = $this->NamaPenyewa->CurrentValue;
			$this->NamaPenyewa->ViewCustomAttributes = "";

			// NamaTeam
			$this->NamaTeam->ViewValue = $this->NamaTeam->CurrentValue;
			$this->NamaTeam->ViewCustomAttributes = "";

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

			// NamaPenyewa
			$this->NamaPenyewa->LinkCustomAttributes = "";
			$this->NamaPenyewa->HrefValue = "";
			$this->NamaPenyewa->TooltipValue = "";

			// NamaTeam
			$this->NamaTeam->LinkCustomAttributes = "";
			$this->NamaTeam->HrefValue = "";
			$this->NamaTeam->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->CurrentValue);
			$this->Kode->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kode->FldCaption()));

			// NamaPenyewa
			$this->NamaPenyewa->EditCustomAttributes = "";
			$this->NamaPenyewa->EditValue = ew_HtmlEncode($this->NamaPenyewa->CurrentValue);
			$this->NamaPenyewa->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NamaPenyewa->FldCaption()));

			// NamaTeam
			$this->NamaTeam->EditCustomAttributes = "";
			$this->NamaTeam->EditValue = ew_HtmlEncode($this->NamaTeam->CurrentValue);
			$this->NamaTeam->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NamaTeam->FldCaption()));

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

			// Edit refer script
			// Kode

			$this->Kode->HrefValue = "";

			// NamaPenyewa
			$this->NamaPenyewa->HrefValue = "";

			// NamaTeam
			$this->NamaTeam->HrefValue = "";

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
			$this->Kode->SetDbValueDef($rsnew, $this->Kode->CurrentValue, NULL, $this->Kode->ReadOnly);

			// NamaPenyewa
			$this->NamaPenyewa->SetDbValueDef($rsnew, $this->NamaPenyewa->CurrentValue, NULL, $this->NamaPenyewa->ReadOnly);

			// NamaTeam
			$this->NamaTeam->SetDbValueDef($rsnew, $this->NamaTeam->CurrentValue, NULL, $this->NamaTeam->ReadOnly);

			// Alamat
			$this->Alamat->SetDbValueDef($rsnew, $this->Alamat->CurrentValue, NULL, $this->Alamat->ReadOnly);

			// Kota
			$this->Kota->SetDbValueDef($rsnew, $this->Kota->CurrentValue, NULL, $this->Kota->ReadOnly);

			// Telepon
			$this->Telepon->SetDbValueDef($rsnew, $this->Telepon->CurrentValue, NULL, $this->Telepon->ReadOnly);

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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "daftar_pelangganlist.php", $this->TableVar);
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
if (!isset($daftar_pelanggan_edit)) $daftar_pelanggan_edit = new cdaftar_pelanggan_edit();

// Page init
$daftar_pelanggan_edit->Page_Init();

// Page main
$daftar_pelanggan_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$daftar_pelanggan_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var daftar_pelanggan_edit = new ew_Page("daftar_pelanggan_edit");
daftar_pelanggan_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = daftar_pelanggan_edit.PageID; // For backward compatibility

// Form object
var fdaftar_pelangganedit = new ew_Form("fdaftar_pelangganedit");

// Validate form
fdaftar_pelangganedit.Validate = function() {
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
fdaftar_pelangganedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdaftar_pelangganedit.ValidateRequired = true;
<?php } else { ?>
fdaftar_pelangganedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $daftar_pelanggan_edit->ShowPageHeader(); ?>
<?php
$daftar_pelanggan_edit->ShowMessage();
?>
<form name="fdaftar_pelangganedit" id="fdaftar_pelangganedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="daftar_pelanggan">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_daftar_pelangganedit" class="table table-bordered table-striped">
<?php if ($daftar_pelanggan->Kode->Visible) { // Kode ?>
	<tr id="r_Kode"<?php echo $daftar_pelanggan->RowAttributes() ?>>
		<td><span id="elh_daftar_pelanggan_Kode"><?php echo $daftar_pelanggan->Kode->FldCaption() ?></span></td>
		<td<?php echo $daftar_pelanggan->Kode->CellAttributes() ?>><span id="el_daftar_pelanggan_Kode" class="control-group">
<input type="text" data-field="x_Kode" name="x_Kode" id="x_Kode" size="30" maxlength="255" placeholder="<?php echo $daftar_pelanggan->Kode->PlaceHolder ?>" value="<?php echo $daftar_pelanggan->Kode->EditValue ?>"<?php echo $daftar_pelanggan->Kode->EditAttributes() ?>>
</span><?php echo $daftar_pelanggan->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->NamaPenyewa->Visible) { // NamaPenyewa ?>
	<tr id="r_NamaPenyewa"<?php echo $daftar_pelanggan->RowAttributes() ?>>
		<td><span id="elh_daftar_pelanggan_NamaPenyewa"><?php echo $daftar_pelanggan->NamaPenyewa->FldCaption() ?></span></td>
		<td<?php echo $daftar_pelanggan->NamaPenyewa->CellAttributes() ?>><span id="el_daftar_pelanggan_NamaPenyewa" class="control-group">
<input type="text" data-field="x_NamaPenyewa" name="x_NamaPenyewa" id="x_NamaPenyewa" size="30" maxlength="255" placeholder="<?php echo $daftar_pelanggan->NamaPenyewa->PlaceHolder ?>" value="<?php echo $daftar_pelanggan->NamaPenyewa->EditValue ?>"<?php echo $daftar_pelanggan->NamaPenyewa->EditAttributes() ?>>
</span><?php echo $daftar_pelanggan->NamaPenyewa->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->NamaTeam->Visible) { // NamaTeam ?>
	<tr id="r_NamaTeam"<?php echo $daftar_pelanggan->RowAttributes() ?>>
		<td><span id="elh_daftar_pelanggan_NamaTeam"><?php echo $daftar_pelanggan->NamaTeam->FldCaption() ?></span></td>
		<td<?php echo $daftar_pelanggan->NamaTeam->CellAttributes() ?>><span id="el_daftar_pelanggan_NamaTeam" class="control-group">
<input type="text" data-field="x_NamaTeam" name="x_NamaTeam" id="x_NamaTeam" size="30" maxlength="255" placeholder="<?php echo $daftar_pelanggan->NamaTeam->PlaceHolder ?>" value="<?php echo $daftar_pelanggan->NamaTeam->EditValue ?>"<?php echo $daftar_pelanggan->NamaTeam->EditAttributes() ?>>
</span><?php echo $daftar_pelanggan->NamaTeam->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Alamat->Visible) { // Alamat ?>
	<tr id="r_Alamat"<?php echo $daftar_pelanggan->RowAttributes() ?>>
		<td><span id="elh_daftar_pelanggan_Alamat"><?php echo $daftar_pelanggan->Alamat->FldCaption() ?></span></td>
		<td<?php echo $daftar_pelanggan->Alamat->CellAttributes() ?>><span id="el_daftar_pelanggan_Alamat" class="control-group">
<textarea data-field="x_Alamat" name="x_Alamat" id="x_Alamat" cols="35" rows="4" placeholder="<?php echo $daftar_pelanggan->Alamat->PlaceHolder ?>"<?php echo $daftar_pelanggan->Alamat->EditAttributes() ?>><?php echo $daftar_pelanggan->Alamat->EditValue ?></textarea>
</span><?php echo $daftar_pelanggan->Alamat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Kota->Visible) { // Kota ?>
	<tr id="r_Kota"<?php echo $daftar_pelanggan->RowAttributes() ?>>
		<td><span id="elh_daftar_pelanggan_Kota"><?php echo $daftar_pelanggan->Kota->FldCaption() ?></span></td>
		<td<?php echo $daftar_pelanggan->Kota->CellAttributes() ?>><span id="el_daftar_pelanggan_Kota" class="control-group">
<input type="text" data-field="x_Kota" name="x_Kota" id="x_Kota" size="30" maxlength="255" placeholder="<?php echo $daftar_pelanggan->Kota->PlaceHolder ?>" value="<?php echo $daftar_pelanggan->Kota->EditValue ?>"<?php echo $daftar_pelanggan->Kota->EditAttributes() ?>>
</span><?php echo $daftar_pelanggan->Kota->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Telepon->Visible) { // Telepon ?>
	<tr id="r_Telepon"<?php echo $daftar_pelanggan->RowAttributes() ?>>
		<td><span id="elh_daftar_pelanggan_Telepon"><?php echo $daftar_pelanggan->Telepon->FldCaption() ?></span></td>
		<td<?php echo $daftar_pelanggan->Telepon->CellAttributes() ?>><span id="el_daftar_pelanggan_Telepon" class="control-group">
<input type="text" data-field="x_Telepon" name="x_Telepon" id="x_Telepon" size="30" maxlength="255" placeholder="<?php echo $daftar_pelanggan->Telepon->PlaceHolder ?>" value="<?php echo $daftar_pelanggan->Telepon->EditValue ?>"<?php echo $daftar_pelanggan->Telepon->EditAttributes() ?>>
</span><?php echo $daftar_pelanggan->Telepon->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<input type="hidden" data-field="x_ID" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($daftar_pelanggan->ID->CurrentValue) ?>">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fdaftar_pelangganedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$daftar_pelanggan_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$daftar_pelanggan_edit->Page_Terminate();
?>

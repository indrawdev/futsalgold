<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "persewaan_lapangan_2D_detailinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "persewaan_lapangan_2D_masterinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$persewaan_lapangan_2D_detail_add = NULL; // Initialize page object first

class cpersewaan_lapangan_2D_detail_add extends cpersewaan_lapangan_2D_detail {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'persewaan lapangan - detail';

	// Page object name
	var $PageObjName = 'persewaan_lapangan_2D_detail_add';

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

		// Table object (persewaan_lapangan_2D_detail)
		if (!isset($GLOBALS["persewaan_lapangan_2D_detail"])) {
			$GLOBALS["persewaan_lapangan_2D_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["persewaan_lapangan_2D_detail"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Table object (persewaan_lapangan_2D_master)
		if (!isset($GLOBALS['persewaan_lapangan_2D_master'])) $GLOBALS['persewaan_lapangan_2D_master'] = new cpersewaan_lapangan_2D_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'persewaan lapangan - detail', TRUE);

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
			$this->Page_Terminate("persewaan_lapangan_2D_detaillist.php");
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

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
					$this->Page_Terminate("persewaan_lapangan_2D_detaillist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "persewaan_lapangan_2D_detailview.php")
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
		$this->NamaLapangan->CurrentValue = NULL;
		$this->NamaLapangan->OldValue = $this->NamaLapangan->CurrentValue;
		$this->TglSewa->CurrentValue = ew_CurrentDate();
		$this->JamSewa->CurrentValue = ew_CurrentTime();
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
		if (!$this->TglSewa->FldIsDetailKey) {
			$this->TglSewa->setFormValue($objForm->GetValue("x_TglSewa"));
			$this->TglSewa->CurrentValue = ew_UnFormatDateTime($this->TglSewa->CurrentValue, 7);
		}
		if (!$this->JamSewa->FldIsDetailKey) {
			$this->JamSewa->setFormValue($objForm->GetValue("x_JamSewa"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->NamaLapangan->CurrentValue = $this->NamaLapangan->FormValue;
		$this->TglSewa->CurrentValue = $this->TglSewa->FormValue;
		$this->TglSewa->CurrentValue = ew_UnFormatDateTime($this->TglSewa->CurrentValue, 7);
		$this->JamSewa->CurrentValue = $this->JamSewa->FormValue;
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
		$this->TglSewa->setDbValue($rs->fields('TglSewa'));
		$this->JamSewa->setDbValue($rs->fields('JamSewa'));
		$this->HargaSewa->setDbValue($rs->fields('HargaSewa'));
		$this->Hitung->setDbValue($rs->fields('Hitung'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->IDM->setDbValue($rs->fields('IDM'));
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
		$this->TglSewa->DbValue = $row['TglSewa'];
		$this->JamSewa->DbValue = $row['JamSewa'];
		$this->HargaSewa->DbValue = $row['HargaSewa'];
		$this->Hitung->DbValue = $row['Hitung'];
		$this->Status->DbValue = $row['Status'];
		$this->IDM->DbValue = $row['IDM'];
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
		// NamaLapangan
		// TglSewa
		// JamSewa
		// HargaSewa
		// Hitung
		// Status
		// IDM
		// Waktu
		// Stamp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			if (strval($this->Kode->CurrentValue) <> "") {
				$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaLapangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar lapangan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Kode, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Kode->ViewValue = $rswrk->fields('DispFld');
					$this->Kode->ViewValue .= ew_ValueSeparator(1,$this->Kode) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Kode->ViewValue = $this->Kode->CurrentValue;
				}
			} else {
				$this->Kode->ViewValue = NULL;
			}
			$this->Kode->ViewCustomAttributes = "";

			// NamaLapangan
			$this->NamaLapangan->ViewValue = $this->NamaLapangan->CurrentValue;
			$this->NamaLapangan->ViewCustomAttributes = "";

			// TglSewa
			$this->TglSewa->ViewValue = $this->TglSewa->CurrentValue;
			$this->TglSewa->ViewValue = ew_FormatDateTime($this->TglSewa->ViewValue, 7);
			$this->TglSewa->CellCssStyle .= "text-align: center;";
			$this->TglSewa->ViewCustomAttributes = "";

			// JamSewa
			if (strval($this->JamSewa->CurrentValue) <> "") {
				switch ($this->JamSewa->CurrentValue) {
					case $this->JamSewa->FldTagValue(1):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(1) <> "" ? $this->JamSewa->FldTagCaption(1) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(2):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(2) <> "" ? $this->JamSewa->FldTagCaption(2) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(3):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(3) <> "" ? $this->JamSewa->FldTagCaption(3) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(4):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(4) <> "" ? $this->JamSewa->FldTagCaption(4) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(5):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(5) <> "" ? $this->JamSewa->FldTagCaption(5) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(6):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(6) <> "" ? $this->JamSewa->FldTagCaption(6) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(7):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(7) <> "" ? $this->JamSewa->FldTagCaption(7) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(8):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(8) <> "" ? $this->JamSewa->FldTagCaption(8) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(9):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(9) <> "" ? $this->JamSewa->FldTagCaption(9) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(10):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(10) <> "" ? $this->JamSewa->FldTagCaption(10) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(11):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(11) <> "" ? $this->JamSewa->FldTagCaption(11) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(12):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(12) <> "" ? $this->JamSewa->FldTagCaption(12) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(13):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(13) <> "" ? $this->JamSewa->FldTagCaption(13) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(14):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(14) <> "" ? $this->JamSewa->FldTagCaption(14) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(15):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(15) <> "" ? $this->JamSewa->FldTagCaption(15) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(16):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(16) <> "" ? $this->JamSewa->FldTagCaption(16) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(17):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(17) <> "" ? $this->JamSewa->FldTagCaption(17) : $this->JamSewa->CurrentValue;
						break;
					case $this->JamSewa->FldTagValue(18):
						$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(18) <> "" ? $this->JamSewa->FldTagCaption(18) : $this->JamSewa->CurrentValue;
						break;
					default:
						$this->JamSewa->ViewValue = $this->JamSewa->CurrentValue;
				}
			} else {
				$this->JamSewa->ViewValue = NULL;
			}
			$this->JamSewa->ViewValue = ew_FormatDateTime($this->JamSewa->ViewValue, 4);
			$this->JamSewa->CellCssStyle .= "text-align: center;";
			$this->JamSewa->ViewCustomAttributes = "";

			// HargaSewa
			$this->HargaSewa->ViewValue = $this->HargaSewa->CurrentValue;
			$this->HargaSewa->ViewValue = ew_FormatNumber($this->HargaSewa->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa->CellCssStyle .= "text-align: right;";
			$this->HargaSewa->ViewCustomAttributes = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// NamaLapangan
			$this->NamaLapangan->LinkCustomAttributes = "";
			$this->NamaLapangan->HrefValue = "";
			$this->NamaLapangan->TooltipValue = "";

			// TglSewa
			$this->TglSewa->LinkCustomAttributes = "";
			$this->TglSewa->HrefValue = "";
			$this->TglSewa->TooltipValue = "";

			// JamSewa
			$this->JamSewa->LinkCustomAttributes = "";
			$this->JamSewa->HrefValue = "";
			$this->JamSewa->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaLapangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `daftar lapangan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Kode, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Kode->EditValue = $arwrk;

			// NamaLapangan
			$this->NamaLapangan->EditCustomAttributes = "";
			$this->NamaLapangan->EditValue = ew_HtmlEncode($this->NamaLapangan->CurrentValue);
			$this->NamaLapangan->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NamaLapangan->FldCaption()));

			// TglSewa
			$this->TglSewa->EditCustomAttributes = "";
			$this->TglSewa->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TglSewa->CurrentValue, 7));
			$this->TglSewa->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->TglSewa->FldCaption()));

			// JamSewa
			$this->JamSewa->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->JamSewa->FldTagValue(1), $this->JamSewa->FldTagCaption(1) <> "" ? $this->JamSewa->FldTagCaption(1) : $this->JamSewa->FldTagValue(1));
			$arwrk[] = array($this->JamSewa->FldTagValue(2), $this->JamSewa->FldTagCaption(2) <> "" ? $this->JamSewa->FldTagCaption(2) : $this->JamSewa->FldTagValue(2));
			$arwrk[] = array($this->JamSewa->FldTagValue(3), $this->JamSewa->FldTagCaption(3) <> "" ? $this->JamSewa->FldTagCaption(3) : $this->JamSewa->FldTagValue(3));
			$arwrk[] = array($this->JamSewa->FldTagValue(4), $this->JamSewa->FldTagCaption(4) <> "" ? $this->JamSewa->FldTagCaption(4) : $this->JamSewa->FldTagValue(4));
			$arwrk[] = array($this->JamSewa->FldTagValue(5), $this->JamSewa->FldTagCaption(5) <> "" ? $this->JamSewa->FldTagCaption(5) : $this->JamSewa->FldTagValue(5));
			$arwrk[] = array($this->JamSewa->FldTagValue(6), $this->JamSewa->FldTagCaption(6) <> "" ? $this->JamSewa->FldTagCaption(6) : $this->JamSewa->FldTagValue(6));
			$arwrk[] = array($this->JamSewa->FldTagValue(7), $this->JamSewa->FldTagCaption(7) <> "" ? $this->JamSewa->FldTagCaption(7) : $this->JamSewa->FldTagValue(7));
			$arwrk[] = array($this->JamSewa->FldTagValue(8), $this->JamSewa->FldTagCaption(8) <> "" ? $this->JamSewa->FldTagCaption(8) : $this->JamSewa->FldTagValue(8));
			$arwrk[] = array($this->JamSewa->FldTagValue(9), $this->JamSewa->FldTagCaption(9) <> "" ? $this->JamSewa->FldTagCaption(9) : $this->JamSewa->FldTagValue(9));
			$arwrk[] = array($this->JamSewa->FldTagValue(10), $this->JamSewa->FldTagCaption(10) <> "" ? $this->JamSewa->FldTagCaption(10) : $this->JamSewa->FldTagValue(10));
			$arwrk[] = array($this->JamSewa->FldTagValue(11), $this->JamSewa->FldTagCaption(11) <> "" ? $this->JamSewa->FldTagCaption(11) : $this->JamSewa->FldTagValue(11));
			$arwrk[] = array($this->JamSewa->FldTagValue(12), $this->JamSewa->FldTagCaption(12) <> "" ? $this->JamSewa->FldTagCaption(12) : $this->JamSewa->FldTagValue(12));
			$arwrk[] = array($this->JamSewa->FldTagValue(13), $this->JamSewa->FldTagCaption(13) <> "" ? $this->JamSewa->FldTagCaption(13) : $this->JamSewa->FldTagValue(13));
			$arwrk[] = array($this->JamSewa->FldTagValue(14), $this->JamSewa->FldTagCaption(14) <> "" ? $this->JamSewa->FldTagCaption(14) : $this->JamSewa->FldTagValue(14));
			$arwrk[] = array($this->JamSewa->FldTagValue(15), $this->JamSewa->FldTagCaption(15) <> "" ? $this->JamSewa->FldTagCaption(15) : $this->JamSewa->FldTagValue(15));
			$arwrk[] = array($this->JamSewa->FldTagValue(16), $this->JamSewa->FldTagCaption(16) <> "" ? $this->JamSewa->FldTagCaption(16) : $this->JamSewa->FldTagValue(16));
			$arwrk[] = array($this->JamSewa->FldTagValue(17), $this->JamSewa->FldTagCaption(17) <> "" ? $this->JamSewa->FldTagCaption(17) : $this->JamSewa->FldTagValue(17));
			$arwrk[] = array($this->JamSewa->FldTagValue(18), $this->JamSewa->FldTagCaption(18) <> "" ? $this->JamSewa->FldTagCaption(18) : $this->JamSewa->FldTagValue(18));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->JamSewa->EditValue = $arwrk;

			// Edit refer script
			// Kode

			$this->Kode->HrefValue = "";

			// NamaLapangan
			$this->NamaLapangan->HrefValue = "";

			// TglSewa
			$this->TglSewa->HrefValue = "";

			// JamSewa
			$this->JamSewa->HrefValue = "";
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
		if (!$this->NamaLapangan->FldIsDetailKey && !is_null($this->NamaLapangan->FormValue) && $this->NamaLapangan->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->NamaLapangan->FldCaption());
		}
		if (!$this->TglSewa->FldIsDetailKey && !is_null($this->TglSewa->FormValue) && $this->TglSewa->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->TglSewa->FldCaption());
		}
		if (!ew_CheckEuroDate($this->TglSewa->FormValue)) {
			ew_AddMessage($gsFormError, $this->TglSewa->FldErrMsg());
		}
		if (!$this->JamSewa->FldIsDetailKey && !is_null($this->JamSewa->FormValue) && $this->JamSewa->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->JamSewa->FldCaption());
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

		// NamaLapangan
		$this->NamaLapangan->SetDbValueDef($rsnew, $this->NamaLapangan->CurrentValue, NULL, FALSE);

		// TglSewa
		$this->TglSewa->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglSewa->CurrentValue, 7), NULL, FALSE);

		// JamSewa
		$this->JamSewa->SetDbValueDef($rsnew, $this->JamSewa->CurrentValue, NULL, FALSE);

		// IDM
		if ($this->IDM->getSessionValue() <> "") {
			$rsnew['IDM'] = $this->IDM->getSessionValue();
		}

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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "persewaan_lapangan_2D_master") {
				$bValidMaster = TRUE;
				if (@$_GET["ID"] <> "") {
					$GLOBALS["persewaan_lapangan_2D_master"]->ID->setQueryStringValue($_GET["ID"]);
					$this->IDM->setQueryStringValue($GLOBALS["persewaan_lapangan_2D_master"]->ID->QueryStringValue);
					$this->IDM->setSessionValue($this->IDM->QueryStringValue);
					if (!is_numeric($GLOBALS["persewaan_lapangan_2D_master"]->ID->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "persewaan_lapangan_2D_master") {
				if ($this->IDM->QueryStringValue == "") $this->IDM->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "persewaan_lapangan_2D_detaillist.php", $this->TableVar);
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

	    include('Connections/Konek.php');
	    $E = explode("/",$_POST['x_TglSewa']);
	    $F = $E[2]."-".$E[1]."-".$E[0];    
	    mysql_select_db($database_Konek, $Konek);
	    $query_RD = "SELECT
	        `persewaan lapangan - detail`.`TglSewa` AS `TglSewa`
	        , `persewaan lapangan - detail`.`JamSewa` AS `JamSewa`
	        , `persewaan lapangan - master`.`Status`  
	         , `persewaan lapangan - detail`.`IDM`
	          , `persewaan lapangan - master`.`ID`
	    FROM      
	        `persewaan lapangan - master`
	        INNER JOIN `persewaan lapangan - detail`                   
	            ON (`persewaan lapangan - master`.`ID` = `persewaan lapangan - detail`.`IDM`)
	    WHERE (`persewaan lapangan - detail`.`TglSewa` = '".$F."'
	        AND `persewaan lapangan - detail`.`JamSewa` = '".$_POST['x_JamSewa']."'   
	        AND `persewaan lapangan - master`.`Status` = 'Booking')";
	    $RD = mysql_query($query_RD, $Konek) or die(mysql_error());
	    $row_RD = mysql_fetch_assoc($RD);     
	    $totalRows_RD = mysql_num_rows($RD);
	     if ($totalRows_RD>1){             
	    mysql_select_db($database_Konek, $Konek);
	    $query_RA = "SELECT * FROM `persewaan lapangan - detail` ORDER BY ID DESC";
	    $RA = mysql_query($query_RA, $Konek) or die(mysql_error());
	    $row_RA = mysql_fetch_assoc($RA);   
	    $totalRows_RA = mysql_num_rows($RA); 
	    $query_Hapus = "DELETE FROM `persewaan lapangan - detail` WHERE ID='".$row_RA['ID']."'";
	    mysql_select_db($database_Konek, $Konek);                 
	    mysql_query($query_Hapus, $Konek) or die(mysql_error());
	     echo "Waktu Sewa yang Anda Pilih tidak tersedia, tekan tombol Back browser untuk kembali.";
	     exit;  
	     }  
	   if ($_POST['x_IDM']){
	         echo "<meta http-equiv=refresh content=0;URL=AppHitungLapangan.php?id=".$_POST[x_IDM]."&go=".$url.">";
	         exit;
	        }        
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
if (!isset($persewaan_lapangan_2D_detail_add)) $persewaan_lapangan_2D_detail_add = new cpersewaan_lapangan_2D_detail_add();

// Page init
$persewaan_lapangan_2D_detail_add->Page_Init();

// Page main
$persewaan_lapangan_2D_detail_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persewaan_lapangan_2D_detail_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var persewaan_lapangan_2D_detail_add = new ew_Page("persewaan_lapangan_2D_detail_add");
persewaan_lapangan_2D_detail_add.PageID = "add"; // Page ID
var EW_PAGE_ID = persewaan_lapangan_2D_detail_add.PageID; // For backward compatibility

// Form object
var fpersewaan_lapangan_2D_detailadd = new ew_Form("fpersewaan_lapangan_2D_detailadd");

// Validate form
fpersewaan_lapangan_2D_detailadd.Validate = function() {
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
fpersewaan_lapangan_2D_detailadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersewaan_lapangan_2D_detailadd.ValidateRequired = true;
<?php } else { ?>
fpersewaan_lapangan_2D_detailadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersewaan_lapangan_2D_detailadd.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":true,"DisplayFields":["x_Kode","x_NamaLapangan","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $persewaan_lapangan_2D_detail_add->ShowPageHeader(); ?>
<?php
$persewaan_lapangan_2D_detail_add->ShowMessage();
?>
<form name="fpersewaan_lapangan_2D_detailadd" id="fpersewaan_lapangan_2D_detailadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="persewaan_lapangan_2D_detail">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_persewaan_lapangan_2D_detailadd" class="table table-bordered table-striped">
<?php if ($persewaan_lapangan_2D_detail->Kode->Visible) { // Kode ?>
	<tr id="r_Kode"<?php echo $persewaan_lapangan_2D_detail->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_detail_Kode"><?php echo $persewaan_lapangan_2D_detail->Kode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_detail->Kode->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_detail_Kode" class="control-group">
<?php $persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x_Kode" name="x_Kode"<?php echo $persewaan_lapangan_2D_detail->Kode->EditAttributes() ?>>
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
?>
</select>
<script type="text/javascript">
fpersewaan_lapangan_2D_detailadd.Lists["x_Kode"].Options = <?php echo (is_array($persewaan_lapangan_2D_detail->Kode->EditValue)) ? ew_ArrayToJson($persewaan_lapangan_2D_detail->Kode->EditValue, 1) : "[]" ?>;
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
<input type="hidden" name="sf_x_Kode" id="sf_x_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Kode" id="ln_x_Kode" value="x_NamaLapangan">
</span><?php echo $persewaan_lapangan_2D_detail->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->NamaLapangan->Visible) { // NamaLapangan ?>
	<tr id="r_NamaLapangan"<?php echo $persewaan_lapangan_2D_detail->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_detail_NamaLapangan"><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_detail_NamaLapangan" class="control-group">
<input type="text" data-field="x_NamaLapangan" name="x_NamaLapangan" id="x_NamaLapangan" size="30" maxlength="100" placeholder="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditAttributes() ?>>
</span><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->TglSewa->Visible) { // TglSewa ?>
	<tr id="r_TglSewa"<?php echo $persewaan_lapangan_2D_detail->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_detail_TglSewa"><?php echo $persewaan_lapangan_2D_detail->TglSewa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_detail->TglSewa->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_detail_TglSewa" class="control-group">
<input type="text" data-field="x_TglSewa" name="x_TglSewa" id="x_TglSewa" size="30" maxlength="50" placeholder="<?php echo $persewaan_lapangan_2D_detail->TglSewa->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditAttributes() ?>>
<?php if (!$persewaan_lapangan_2D_detail->TglSewa->ReadOnly && !$persewaan_lapangan_2D_detail->TglSewa->Disabled && @$persewaan_lapangan_2D_detail->TglSewa->EditAttrs["readonly"] == "" && @$persewaan_lapangan_2D_detail->TglSewa->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_TglSewa" name="cal_x_TglSewa" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_TglSewa" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fpersewaan_lapangan_2D_detailadd", "x_TglSewa", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $persewaan_lapangan_2D_detail->TglSewa->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->JamSewa->Visible) { // JamSewa ?>
	<tr id="r_JamSewa"<?php echo $persewaan_lapangan_2D_detail->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_detail_JamSewa"><?php echo $persewaan_lapangan_2D_detail->JamSewa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_detail->JamSewa->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_detail_JamSewa" class="control-group">
<select data-field="x_JamSewa" id="x_JamSewa" name="x_JamSewa"<?php echo $persewaan_lapangan_2D_detail->JamSewa->EditAttributes() ?>>
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
?>
</select>
</span><?php echo $persewaan_lapangan_2D_detail->JamSewa->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php if (strval($persewaan_lapangan_2D_detail->IDM->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_IDM" id="x_IDM" value="<?php echo ew_HtmlEncode(strval($persewaan_lapangan_2D_detail->IDM->getSessionValue())) ?>">
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fpersewaan_lapangan_2D_detailadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$persewaan_lapangan_2D_detail_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$persewaan_lapangan_2D_detail_add->Page_Terminate();
?>

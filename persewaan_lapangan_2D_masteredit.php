<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "persewaan_lapangan_2D_masterinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "persewaan_lapangan_2D_detailgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$persewaan_lapangan_2D_master_edit = NULL; // Initialize page object first

class cpersewaan_lapangan_2D_master_edit extends cpersewaan_lapangan_2D_master {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'persewaan lapangan - master';

	// Page object name
	var $PageObjName = 'persewaan_lapangan_2D_master_edit';

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

		// Table object (persewaan_lapangan_2D_master)
		if (!isset($GLOBALS["persewaan_lapangan_2D_master"])) {
			$GLOBALS["persewaan_lapangan_2D_master"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["persewaan_lapangan_2D_master"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'persewaan lapangan - master', TRUE);

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
			$this->Page_Terminate("persewaan_lapangan_2D_masterlist.php");
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

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->ID->CurrentValue == "")
			$this->Page_Terminate("persewaan_lapangan_2D_masterlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("persewaan_lapangan_2D_masterlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					if ($this->getCurrentDetailTable() <> "") // Master/detail edit
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->No_Faktur->FldIsDetailKey) {
			$this->No_Faktur->setFormValue($objForm->GetValue("x_No_Faktur"));
		}
		if (!$this->Tgl->FldIsDetailKey) {
			$this->Tgl->setFormValue($objForm->GetValue("x_Tgl"));
			$this->Tgl->CurrentValue = ew_UnFormatDateTime($this->Tgl->CurrentValue, 7);
		}
		if (!$this->Kode->FldIsDetailKey) {
			$this->Kode->setFormValue($objForm->GetValue("x_Kode"));
		}
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		if (!$this->Bayar->FldIsDetailKey) {
			$this->Bayar->setFormValue($objForm->GetValue("x_Bayar"));
		}
		if (!$this->Diskon->FldIsDetailKey) {
			$this->Diskon->setFormValue($objForm->GetValue("x_Diskon"));
		}
		if (!$this->Potongan->FldIsDetailKey) {
			$this->Potongan->setFormValue($objForm->GetValue("x_Potongan"));
		}
		if (!$this->Kode_Kasir->FldIsDetailKey) {
			$this->Kode_Kasir->setFormValue($objForm->GetValue("x_Kode_Kasir"));
		}
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
		if (!$this->ID->FldIsDetailKey)
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->ID->CurrentValue = $this->ID->FormValue;
		$this->No_Faktur->CurrentValue = $this->No_Faktur->FormValue;
		$this->Tgl->CurrentValue = $this->Tgl->FormValue;
		$this->Tgl->CurrentValue = ew_UnFormatDateTime($this->Tgl->CurrentValue, 7);
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->Nama->CurrentValue = $this->Nama->FormValue;
		$this->Bayar->CurrentValue = $this->Bayar->FormValue;
		$this->Diskon->CurrentValue = $this->Diskon->FormValue;
		$this->Potongan->CurrentValue = $this->Potongan->FormValue;
		$this->Kode_Kasir->CurrentValue = $this->Kode_Kasir->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
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
		$this->No->setDbValue($rs->fields('No'));
		$this->No_Faktur->setDbValue($rs->fields('No Faktur'));
		$this->Faktur->setDbValue($rs->fields('Faktur'));
		$this->Tgl->setDbValue($rs->fields('Tgl'));
		$this->Kode->setDbValue($rs->fields('Kode'));
		if (array_key_exists('EV__Kode', $rs->fields)) {
			$this->Kode->VirtualValue = $rs->fields('EV__Kode'); // Set up virtual field value
		} else {
			$this->Kode->VirtualValue = ""; // Clear value
		}
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Kota->setDbValue($rs->fields('Kota'));
		$this->Telepon->setDbValue($rs->fields('Telepon'));
		$this->Main->setDbValue($rs->fields('Main'));
		$this->Total->setDbValue($rs->fields('Total'));
		$this->Bayar->setDbValue($rs->fields('Bayar'));
		$this->Sisa->setDbValue($rs->fields('Sisa'));
		$this->Sub_Total->setDbValue($rs->fields('Sub Total'));
		$this->Diskon->setDbValue($rs->fields('Diskon'));
		$this->Potongan->setDbValue($rs->fields('Potongan'));
		$this->Grand_Total->setDbValue($rs->fields('Grand Total'));
		$this->Kode_Kasir->setDbValue($rs->fields('Kode Kasir'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Nama_Kasir->setDbValue($rs->fields('Nama Kasir'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
		$this->Hitung->setDbValue($rs->fields('Hitung'));
		$this->Cetak_Struk->setDbValue($rs->fields('Cetak Struk'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->No->DbValue = $row['No'];
		$this->No_Faktur->DbValue = $row['No Faktur'];
		$this->Faktur->DbValue = $row['Faktur'];
		$this->Tgl->DbValue = $row['Tgl'];
		$this->Kode->DbValue = $row['Kode'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->Kota->DbValue = $row['Kota'];
		$this->Telepon->DbValue = $row['Telepon'];
		$this->Main->DbValue = $row['Main'];
		$this->Total->DbValue = $row['Total'];
		$this->Bayar->DbValue = $row['Bayar'];
		$this->Sisa->DbValue = $row['Sisa'];
		$this->Sub_Total->DbValue = $row['Sub Total'];
		$this->Diskon->DbValue = $row['Diskon'];
		$this->Potongan->DbValue = $row['Potongan'];
		$this->Grand_Total->DbValue = $row['Grand Total'];
		$this->Kode_Kasir->DbValue = $row['Kode Kasir'];
		$this->Status->DbValue = $row['Status'];
		$this->Nama_Kasir->DbValue = $row['Nama Kasir'];
		$this->Waktu->DbValue = $row['Waktu'];
		$this->Stamp->DbValue = $row['Stamp'];
		$this->Hitung->DbValue = $row['Hitung'];
		$this->Cetak_Struk->DbValue = $row['Cetak Struk'];
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
		// No
		// No Faktur
		// Faktur
		// Tgl
		// Kode
		// Nama
		// Alamat
		// Kota
		// Telepon
		// Main
		// Total
		// Bayar
		// Sisa
		// Sub Total
		// Diskon
		// Potongan
		// Grand Total
		// Kode Kasir
		// Status
		// Nama Kasir
		// Waktu
		// Stamp
		// Hitung
		// Cetak Struk

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// No Faktur
			$this->No_Faktur->ViewValue = $this->No_Faktur->CurrentValue;
			$this->No_Faktur->CssStyle = "font-weight: bold;";
			$this->No_Faktur->CellCssStyle .= "text-align: center;";
			$this->No_Faktur->ViewCustomAttributes = "";

			// Tgl
			$this->Tgl->ViewValue = $this->Tgl->CurrentValue;
			$this->Tgl->ViewValue = ew_FormatDateTime($this->Tgl->ViewValue, 7);
			$this->Tgl->ViewCustomAttributes = "";

			// Kode
			if ($this->Kode->VirtualValue <> "") {
				$this->Kode->ViewValue = $this->Kode->VirtualValue;
			} else {
			if (strval($this->Kode->CurrentValue) <> "") {
				$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaPenyewa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar pelanggan`";
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
			}
			$this->Kode->ViewCustomAttributes = "";

			// Nama
			$this->Nama->ViewValue = $this->Nama->CurrentValue;
			$this->Nama->ViewCustomAttributes = "";

			// Bayar
			$this->Bayar->ViewValue = $this->Bayar->CurrentValue;
			$this->Bayar->ViewValue = ew_FormatNumber($this->Bayar->ViewValue, 0, -2, -2, -2);
			$this->Bayar->CellCssStyle .= "text-align: right;";
			$this->Bayar->ViewCustomAttributes = "";

			// Sisa
			$this->Sisa->ViewValue = $this->Sisa->CurrentValue;
			$this->Sisa->ViewValue = ew_FormatNumber($this->Sisa->ViewValue, 0, -2, -2, -2);
			$this->Sisa->CellCssStyle .= "text-align: right;";
			$this->Sisa->ViewCustomAttributes = "";

			// Sub Total
			$this->Sub_Total->ViewValue = $this->Sub_Total->CurrentValue;
			$this->Sub_Total->ViewValue = ew_FormatNumber($this->Sub_Total->ViewValue, 0, -2, -2, -2);
			$this->Sub_Total->CellCssStyle .= "text-align: right;";
			$this->Sub_Total->ViewCustomAttributes = "";

			// Diskon
			$this->Diskon->ViewValue = $this->Diskon->CurrentValue;
			$this->Diskon->CellCssStyle .= "text-align: center;";
			$this->Diskon->ViewCustomAttributes = "";

			// Potongan
			$this->Potongan->ViewValue = $this->Potongan->CurrentValue;
			$this->Potongan->ViewValue = ew_FormatNumber($this->Potongan->ViewValue, 0, -2, -2, -2);
			$this->Potongan->CellCssStyle .= "text-align: right;";
			$this->Potongan->ViewCustomAttributes = "";

			// Grand Total
			$this->Grand_Total->ViewValue = $this->Grand_Total->CurrentValue;
			$this->Grand_Total->ViewValue = ew_FormatNumber($this->Grand_Total->ViewValue, 0, -2, -2, -2);
			$this->Grand_Total->CellCssStyle .= "text-align: right;";
			$this->Grand_Total->ViewCustomAttributes = "";

			// Kode Kasir
			if (strval($this->Kode_Kasir->CurrentValue) <> "") {
				$sFilterWrk = "`Username`" . ew_SearchString("=", $this->Kode_Kasir->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Username`, `Username` AS `DispFld`, `Nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `2padmin`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Kode_Kasir, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Username` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Kode_Kasir->ViewValue = $rswrk->fields('DispFld');
					$this->Kode_Kasir->ViewValue .= ew_ValueSeparator(1,$this->Kode_Kasir) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Kode_Kasir->ViewValue = $this->Kode_Kasir->CurrentValue;
				}
			} else {
				$this->Kode_Kasir->ViewValue = NULL;
			}
			$this->Kode_Kasir->ViewCustomAttributes = "";

			// Status
			if (strval($this->Status->CurrentValue) <> "") {
				switch ($this->Status->CurrentValue) {
					case $this->Status->FldTagValue(1):
						$this->Status->ViewValue = $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(2):
						$this->Status->ViewValue = $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(3):
						$this->Status->ViewValue = $this->Status->FldTagCaption(3) <> "" ? $this->Status->FldTagCaption(3) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(4):
						$this->Status->ViewValue = $this->Status->FldTagCaption(4) <> "" ? $this->Status->FldTagCaption(4) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(5):
						$this->Status->ViewValue = $this->Status->FldTagCaption(5) <> "" ? $this->Status->FldTagCaption(5) : $this->Status->CurrentValue;
						break;
					default:
						$this->Status->ViewValue = $this->Status->CurrentValue;
				}
			} else {
				$this->Status->ViewValue = NULL;
			}
			$this->Status->ViewCustomAttributes = "";

			// No Faktur
			$this->No_Faktur->LinkCustomAttributes = "";
			$this->No_Faktur->HrefValue = "";
			$this->No_Faktur->TooltipValue = "";

			// Tgl
			$this->Tgl->LinkCustomAttributes = "";
			$this->Tgl->HrefValue = "";
			$this->Tgl->TooltipValue = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Bayar
			$this->Bayar->LinkCustomAttributes = "";
			$this->Bayar->HrefValue = "";
			$this->Bayar->TooltipValue = "";

			// Diskon
			$this->Diskon->LinkCustomAttributes = "";
			$this->Diskon->HrefValue = "";
			$this->Diskon->TooltipValue = "";

			// Potongan
			$this->Potongan->LinkCustomAttributes = "";
			$this->Potongan->HrefValue = "";
			$this->Potongan->TooltipValue = "";

			// Kode Kasir
			$this->Kode_Kasir->LinkCustomAttributes = "";
			$this->Kode_Kasir->HrefValue = "";
			$this->Kode_Kasir->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// No Faktur
			$this->No_Faktur->EditCustomAttributes = "";
			$this->No_Faktur->EditValue = ew_HtmlEncode($this->No_Faktur->CurrentValue);
			$this->No_Faktur->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->No_Faktur->FldCaption()));

			// Tgl
			$this->Tgl->EditCustomAttributes = "";
			$this->Tgl->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tgl->CurrentValue, 7));
			$this->Tgl->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Tgl->FldCaption()));

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaPenyewa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `daftar pelanggan`";
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

			// Nama
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Nama->FldCaption()));

			// Bayar
			$this->Bayar->EditCustomAttributes = "";
			$this->Bayar->EditValue = ew_HtmlEncode($this->Bayar->CurrentValue);
			$this->Bayar->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Bayar->FldCaption()));

			// Diskon
			$this->Diskon->EditCustomAttributes = "";
			$this->Diskon->EditValue = ew_HtmlEncode($this->Diskon->CurrentValue);
			$this->Diskon->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Diskon->FldCaption()));

			// Potongan
			$this->Potongan->EditCustomAttributes = "";
			$this->Potongan->EditValue = ew_HtmlEncode($this->Potongan->CurrentValue);
			$this->Potongan->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Potongan->FldCaption()));

			// Kode Kasir
			// Status

			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$arwrk[] = array($this->Status->FldTagValue(3), $this->Status->FldTagCaption(3) <> "" ? $this->Status->FldTagCaption(3) : $this->Status->FldTagValue(3));
			$arwrk[] = array($this->Status->FldTagValue(4), $this->Status->FldTagCaption(4) <> "" ? $this->Status->FldTagCaption(4) : $this->Status->FldTagValue(4));
			$arwrk[] = array($this->Status->FldTagValue(5), $this->Status->FldTagCaption(5) <> "" ? $this->Status->FldTagCaption(5) : $this->Status->FldTagValue(5));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->Status->EditValue = $arwrk;

			// Edit refer script
			// No Faktur

			$this->No_Faktur->HrefValue = "";

			// Tgl
			$this->Tgl->HrefValue = "";

			// Kode
			$this->Kode->HrefValue = "";

			// Nama
			$this->Nama->HrefValue = "";

			// Bayar
			$this->Bayar->HrefValue = "";

			// Diskon
			$this->Diskon->HrefValue = "";

			// Potongan
			$this->Potongan->HrefValue = "";

			// Kode Kasir
			$this->Kode_Kasir->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";
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
		if (!ew_CheckEuroDate($this->Tgl->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tgl->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Bayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->Bayar->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Diskon->FormValue)) {
			ew_AddMessage($gsFormError, $this->Diskon->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Potongan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Potongan->FldErrMsg());
		}
		if (!$this->Status->FldIsDetailKey && !is_null($this->Status->FormValue) && $this->Status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Status->FldCaption());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("persewaan_lapangan_2D_detail", $DetailTblVar) && $GLOBALS["persewaan_lapangan_2D_detail"]->DetailEdit) {
			if (!isset($GLOBALS["persewaan_lapangan_2D_detail_grid"])) $GLOBALS["persewaan_lapangan_2D_detail_grid"] = new cpersewaan_lapangan_2D_detail_grid(); // get detail page object
			$GLOBALS["persewaan_lapangan_2D_detail_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// No Faktur
			$this->No_Faktur->SetDbValueDef($rsnew, $this->No_Faktur->CurrentValue, NULL, $this->No_Faktur->ReadOnly);

			// Tgl
			$this->Tgl->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tgl->CurrentValue, 7), NULL, $this->Tgl->ReadOnly);

			// Kode
			$this->Kode->SetDbValueDef($rsnew, $this->Kode->CurrentValue, NULL, $this->Kode->ReadOnly);

			// Nama
			$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, NULL, $this->Nama->ReadOnly);

			// Bayar
			$this->Bayar->SetDbValueDef($rsnew, $this->Bayar->CurrentValue, NULL, $this->Bayar->ReadOnly);

			// Diskon
			$this->Diskon->SetDbValueDef($rsnew, $this->Diskon->CurrentValue, NULL, $this->Diskon->ReadOnly);

			// Potongan
			$this->Potongan->SetDbValueDef($rsnew, $this->Potongan->CurrentValue, NULL, $this->Potongan->ReadOnly);

			// Kode Kasir
			$this->Kode_Kasir->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Kode Kasir'] = &$this->Kode_Kasir->DbValue;

			// Status
			$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, "", $this->Status->ReadOnly);

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

				// Update detail records
				if ($EditRow) {
					$DetailTblVar = explode(",", $this->getCurrentDetailTable());
					if (in_array("persewaan_lapangan_2D_detail", $DetailTblVar) && $GLOBALS["persewaan_lapangan_2D_detail"]->DetailEdit) {
						if (!isset($GLOBALS["persewaan_lapangan_2D_detail_grid"])) $GLOBALS["persewaan_lapangan_2D_detail_grid"] = new cpersewaan_lapangan_2D_detail_grid(); // Get detail page object
						$EditRow = $GLOBALS["persewaan_lapangan_2D_detail_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("persewaan_lapangan_2D_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["persewaan_lapangan_2D_detail_grid"]))
					$GLOBALS["persewaan_lapangan_2D_detail_grid"] = new cpersewaan_lapangan_2D_detail_grid;
				if ($GLOBALS["persewaan_lapangan_2D_detail_grid"]->DetailEdit) {
					$GLOBALS["persewaan_lapangan_2D_detail_grid"]->CurrentMode = "edit";
					$GLOBALS["persewaan_lapangan_2D_detail_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["persewaan_lapangan_2D_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["persewaan_lapangan_2D_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["persewaan_lapangan_2D_detail_grid"]->IDM->FldIsDetailKey = TRUE;
					$GLOBALS["persewaan_lapangan_2D_detail_grid"]->IDM->CurrentValue = $this->ID->CurrentValue;
					$GLOBALS["persewaan_lapangan_2D_detail_grid"]->IDM->setSessionValue($GLOBALS["persewaan_lapangan_2D_detail_grid"]->IDM->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "persewaan_lapangan_2D_masterlist.php", $this->TableVar);
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

	  if ($_POST['t']){
	   echo "<meta http-equiv='refresh' content='0;URL=AppHitung.php?id=".$_POST['x_ID']."'>";               
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
if (!isset($persewaan_lapangan_2D_master_edit)) $persewaan_lapangan_2D_master_edit = new cpersewaan_lapangan_2D_master_edit();

// Page init
$persewaan_lapangan_2D_master_edit->Page_Init();

// Page main
$persewaan_lapangan_2D_master_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persewaan_lapangan_2D_master_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var persewaan_lapangan_2D_master_edit = new ew_Page("persewaan_lapangan_2D_master_edit");
persewaan_lapangan_2D_master_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = persewaan_lapangan_2D_master_edit.PageID; // For backward compatibility

// Form object
var fpersewaan_lapangan_2D_masteredit = new ew_Form("fpersewaan_lapangan_2D_masteredit");

// Validate form
fpersewaan_lapangan_2D_masteredit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Tgl");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($persewaan_lapangan_2D_master->Tgl->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Bayar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($persewaan_lapangan_2D_master->Bayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Diskon");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($persewaan_lapangan_2D_master->Diskon->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Potongan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($persewaan_lapangan_2D_master->Potongan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Status");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($persewaan_lapangan_2D_master->Status->FldCaption()) ?>");

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
fpersewaan_lapangan_2D_masteredit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersewaan_lapangan_2D_masteredit.ValidateRequired = true;
<?php } else { ?>
fpersewaan_lapangan_2D_masteredit.ValidateRequired = false; 
<?php } ?>

// Multi-Page properties
fpersewaan_lapangan_2D_masteredit.MultiPage = new ew_MultiPage("fpersewaan_lapangan_2D_masteredit",
	[["x_No_Faktur",1],["x_Tgl",1],["x_Kode",2],["x_Nama",2],["x_Bayar",3],["x_Diskon",3],["x_Potongan",3],["x_Status",4]]
);

// Dynamic selection lists
fpersewaan_lapangan_2D_masteredit.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":true,"DisplayFields":["x_Kode","x_NamaPenyewa","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpersewaan_lapangan_2D_masteredit.Lists["x_Kode_Kasir"] = {"LinkField":"x_Username","Ajax":null,"AutoFill":false,"DisplayFields":["x_Username","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $persewaan_lapangan_2D_master_edit->ShowPageHeader(); ?>
<?php
$persewaan_lapangan_2D_master_edit->ShowMessage();
?>
<form name="fpersewaan_lapangan_2D_masteredit" id="fpersewaan_lapangan_2D_masteredit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="persewaan_lapangan_2D_master">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewStdTable"><tbody><tr><td>
<div class="tabbable" id="persewaan_lapangan_2D_master_edit">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_persewaan_lapangan_2D_master1" data-toggle="tab"><?php echo $persewaan_lapangan_2D_master->PageCaption(1) ?></a></li>
		<li><a href="#tab_persewaan_lapangan_2D_master2" data-toggle="tab"><?php echo $persewaan_lapangan_2D_master->PageCaption(2) ?></a></li>
		<li><a href="#tab_persewaan_lapangan_2D_master3" data-toggle="tab"><?php echo $persewaan_lapangan_2D_master->PageCaption(3) ?></a></li>
		<li><a href="#tab_persewaan_lapangan_2D_master4" data-toggle="tab"><?php echo $persewaan_lapangan_2D_master->PageCaption(4) ?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_persewaan_lapangan_2D_master1">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_persewaan_lapangan_2D_masteredit1" class="table table-bordered table-striped">
<?php if ($persewaan_lapangan_2D_master->No_Faktur->Visible) { // No Faktur ?>
	<tr id="r_No_Faktur"<?php echo $persewaan_lapangan_2D_master->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_master_No_Faktur"><?php echo $persewaan_lapangan_2D_master->No_Faktur->FldCaption() ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_master->No_Faktur->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_No_Faktur" class="control-group">
<input type="text" data-field="x_No_Faktur" name="x_No_Faktur" id="x_No_Faktur" size="30" maxlength="100" placeholder="<?php echo $persewaan_lapangan_2D_master->No_Faktur->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_master->No_Faktur->EditValue ?>"<?php echo $persewaan_lapangan_2D_master->No_Faktur->EditAttributes() ?>>
</span><?php echo $persewaan_lapangan_2D_master->No_Faktur->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Tgl->Visible) { // Tgl ?>
	<tr id="r_Tgl"<?php echo $persewaan_lapangan_2D_master->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_master_Tgl"><?php echo $persewaan_lapangan_2D_master->Tgl->FldCaption() ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Tgl->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Tgl" class="control-group">
<input type="text" data-field="x_Tgl" name="x_Tgl" id="x_Tgl" placeholder="<?php echo $persewaan_lapangan_2D_master->Tgl->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_master->Tgl->EditValue ?>"<?php echo $persewaan_lapangan_2D_master->Tgl->EditAttributes() ?>>
<?php if (!$persewaan_lapangan_2D_master->Tgl->ReadOnly && !$persewaan_lapangan_2D_master->Tgl->Disabled && @$persewaan_lapangan_2D_master->Tgl->EditAttrs["readonly"] == "" && @$persewaan_lapangan_2D_master->Tgl->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_Tgl" name="cal_x_Tgl" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_Tgl" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fpersewaan_lapangan_2D_masteredit", "x_Tgl", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $persewaan_lapangan_2D_master->Tgl->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_persewaan_lapangan_2D_master2">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_persewaan_lapangan_2D_masteredit2" class="table table-bordered table-striped">
<?php if ($persewaan_lapangan_2D_master->Kode->Visible) { // Kode ?>
	<tr id="r_Kode"<?php echo $persewaan_lapangan_2D_master->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_master_Kode"><?php echo $persewaan_lapangan_2D_master->Kode->FldCaption() ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Kode->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Kode" class="control-group">
<?php $persewaan_lapangan_2D_master->Kode->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$persewaan_lapangan_2D_master->Kode->EditAttrs["onchange"]; ?>
<select data-field="x_Kode" id="x_Kode" name="x_Kode"<?php echo $persewaan_lapangan_2D_master->Kode->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_master->Kode->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_master->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_master->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$persewaan_lapangan_2D_master->Kode) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
fpersewaan_lapangan_2D_masteredit.Lists["x_Kode"].Options = <?php echo (is_array($persewaan_lapangan_2D_master->Kode->EditValue)) ? ew_ArrayToJson($persewaan_lapangan_2D_master->Kode->EditValue, 1) : "[]" ?>;
</script>
<?php
$sSqlWrk = "SELECT `Kode` AS FIELD0, `NamaPenyewa` AS FIELD1 FROM `daftar pelanggan`";
$sWhereWrk = "(`Kode` = '{query_value}')";

// Call Lookup selecting
$persewaan_lapangan_2D_master->Lookup_Selecting($persewaan_lapangan_2D_master->Kode, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = ew_Encrypt($sSqlWrk);
?>
<input type="hidden" name="sf_x_Kode" id="sf_x_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Kode" id="ln_x_Kode" value="x_Kode,x_Nama">
</span><?php echo $persewaan_lapangan_2D_master->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Nama->Visible) { // Nama ?>
	<tr id="r_Nama"<?php echo $persewaan_lapangan_2D_master->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_master_Nama"><?php echo $persewaan_lapangan_2D_master->Nama->FldCaption() ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Nama->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Nama" class="control-group">
<input type="text" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="100" placeholder="<?php echo $persewaan_lapangan_2D_master->Nama->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_master->Nama->EditValue ?>"<?php echo $persewaan_lapangan_2D_master->Nama->EditAttributes() ?>>
</span><?php echo $persewaan_lapangan_2D_master->Nama->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_persewaan_lapangan_2D_master3">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_persewaan_lapangan_2D_masteredit3" class="table table-bordered table-striped">
<?php if ($persewaan_lapangan_2D_master->Bayar->Visible) { // Bayar ?>
	<tr id="r_Bayar"<?php echo $persewaan_lapangan_2D_master->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_master_Bayar"><?php echo $persewaan_lapangan_2D_master->Bayar->FldCaption() ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Bayar->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Bayar" class="control-group">
<input type="text" data-field="x_Bayar" name="x_Bayar" id="x_Bayar" size="30" placeholder="<?php echo $persewaan_lapangan_2D_master->Bayar->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_master->Bayar->EditValue ?>"<?php echo $persewaan_lapangan_2D_master->Bayar->EditAttributes() ?>>
</span><?php echo $persewaan_lapangan_2D_master->Bayar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Diskon->Visible) { // Diskon ?>
	<tr id="r_Diskon"<?php echo $persewaan_lapangan_2D_master->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_master_Diskon"><?php echo $persewaan_lapangan_2D_master->Diskon->FldCaption() ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Diskon->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Diskon" class="control-group">
<input type="text" data-field="x_Diskon" name="x_Diskon" id="x_Diskon" size="30" placeholder="<?php echo $persewaan_lapangan_2D_master->Diskon->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_master->Diskon->EditValue ?>"<?php echo $persewaan_lapangan_2D_master->Diskon->EditAttributes() ?>>
</span><?php echo $persewaan_lapangan_2D_master->Diskon->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Potongan->Visible) { // Potongan ?>
	<tr id="r_Potongan"<?php echo $persewaan_lapangan_2D_master->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_master_Potongan"><?php echo $persewaan_lapangan_2D_master->Potongan->FldCaption() ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Potongan->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Potongan" class="control-group">
<input type="text" data-field="x_Potongan" name="x_Potongan" id="x_Potongan" size="30" placeholder="<?php echo $persewaan_lapangan_2D_master->Potongan->PlaceHolder ?>" value="<?php echo $persewaan_lapangan_2D_master->Potongan->EditValue ?>"<?php echo $persewaan_lapangan_2D_master->Potongan->EditAttributes() ?>>
</span><?php echo $persewaan_lapangan_2D_master->Potongan->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
		<div class="tab-pane" id="tab_persewaan_lapangan_2D_master4">
<table cellspacing="0" class="ewGrid" style="width: 100%"><tr><td>
<table id="tbl_persewaan_lapangan_2D_masteredit4" class="table table-bordered table-striped">
<?php if ($persewaan_lapangan_2D_master->Status->Visible) { // Status ?>
	<tr id="r_Status"<?php echo $persewaan_lapangan_2D_master->RowAttributes() ?>>
		<td><span id="elh_persewaan_lapangan_2D_master_Status"><?php echo $persewaan_lapangan_2D_master->Status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Status->CellAttributes() ?>><span id="el_persewaan_lapangan_2D_master_Status" class="control-group">
<select data-field="x_Status" id="x_Status" name="x_Status"<?php echo $persewaan_lapangan_2D_master->Status->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_master->Status->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_master->Status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_master->Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $persewaan_lapangan_2D_master->Status->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
		</div>
	</div>
</div>
</td></tr></tbody></table>
<input type="hidden" data-field="x_ID" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_master->ID->CurrentValue) ?>">
<?php
	if (in_array("persewaan_lapangan_2D_detail", explode(",", $persewaan_lapangan_2D_master->getCurrentDetailTable())) && $persewaan_lapangan_2D_detail->DetailEdit) {
?>
<?php include_once "persewaan_lapangan_2D_detailgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fpersewaan_lapangan_2D_masteredit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$persewaan_lapangan_2D_master_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$persewaan_lapangan_2D_master_edit->Page_Terminate();
?>

<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "penjualan_2D_masterinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "penjualan_2D_detailgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$penjualan_2D_master_add = NULL; // Initialize page object first

class cpenjualan_2D_master_add extends cpenjualan_2D_master {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'penjualan - master';

	// Page object name
	var $PageObjName = 'penjualan_2D_master_add';

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

		// Table object (penjualan_2D_master)
		if (!isset($GLOBALS["penjualan_2D_master"])) {
			$GLOBALS["penjualan_2D_master"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["penjualan_2D_master"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'penjualan - master', TRUE);

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
			$this->Page_Terminate("penjualan_2D_masterlist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		if ($Security->IsLoggedIn() && strval($Security->CurrentUserID()) == "") {
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("penjualan_2D_masterlist.php");
		}

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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("penjualan_2D_masterlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "penjualan_2D_masterview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->Tgl->CurrentValue = ew_CurrentDate();
		$this->Diskon->CurrentValue = 0;
		$this->Dibayar->CurrentValue = 0;
		$this->Kode_Pelanggan->CurrentValue = NULL;
		$this->Kode_Pelanggan->OldValue = $this->Kode_Pelanggan->CurrentValue;
		$this->Kode_Kasir->CurrentValue = CurrentUserID();
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Tgl->FldIsDetailKey) {
			$this->Tgl->setFormValue($objForm->GetValue("x_Tgl"));
			$this->Tgl->CurrentValue = ew_UnFormatDateTime($this->Tgl->CurrentValue, 7);
		}
		if (!$this->Diskon->FldIsDetailKey) {
			$this->Diskon->setFormValue($objForm->GetValue("x_Diskon"));
		}
		if (!$this->Dibayar->FldIsDetailKey) {
			$this->Dibayar->setFormValue($objForm->GetValue("x_Dibayar"));
		}
		if (!$this->Kode_Pelanggan->FldIsDetailKey) {
			$this->Kode_Pelanggan->setFormValue($objForm->GetValue("x_Kode_Pelanggan"));
		}
		if (!$this->Kode_Kasir->FldIsDetailKey) {
			$this->Kode_Kasir->setFormValue($objForm->GetValue("x_Kode_Kasir"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Tgl->CurrentValue = $this->Tgl->FormValue;
		$this->Tgl->CurrentValue = ew_UnFormatDateTime($this->Tgl->CurrentValue, 7);
		$this->Diskon->CurrentValue = $this->Diskon->FormValue;
		$this->Dibayar->CurrentValue = $this->Dibayar->FormValue;
		$this->Kode_Pelanggan->CurrentValue = $this->Kode_Pelanggan->FormValue;
		$this->Kode_Kasir->CurrentValue = $this->Kode_Kasir->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('add');
			if (!$res) {
				$sUserIdMsg = $Language->Phrase("NoPermission");
				$this->setFailureMessage($sUserIdMsg);
			}
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
		$this->Tgl->setDbValue($rs->fields('Tgl'));
		$this->Faktur->setDbValue($rs->fields('Faktur'));
		$this->No_Faktur->setDbValue($rs->fields('No Faktur'));
		$this->Ppn->setDbValue($rs->fields('Ppn'));
		$this->Ongkir->setDbValue($rs->fields('Ongkir'));
		$this->Paking->setDbValue($rs->fields('Paking'));
		$this->Lain_2D_lain->setDbValue($rs->fields('Lain - lain'));
		$this->Piutang->setDbValue($rs->fields('Piutang'));
		$this->Total_Berat->setDbValue($rs->fields('Total Berat'));
		$this->Total_HP->setDbValue($rs->fields('Total HP'));
		$this->Total_HJ->setDbValue($rs->fields('Total HJ'));
		$this->Diskon->setDbValue($rs->fields('Diskon'));
		$this->Grand_Total->setDbValue($rs->fields('Grand Total'));
		$this->Laba->setDbValue($rs->fields('Laba'));
		$this->Dibayar->setDbValue($rs->fields('Dibayar'));
		$this->Kembali->setDbValue($rs->fields('Kembali'));
		$this->SisaDibayar->setDbValue($rs->fields('SisaDibayar'));
		$this->Kode_Pelanggan->setDbValue($rs->fields('Kode Pelanggan'));
		$this->Nama_Pelanggan->setDbValue($rs->fields('Nama Pelanggan'));
		$this->Kode_Suplier->setDbValue($rs->fields('Kode Suplier'));
		$this->Kode_Kasir->setDbValue($rs->fields('Kode Kasir'));
		$this->Nama_Kasir->setDbValue($rs->fields('Nama Kasir'));
		$this->Nama_Form->setDbValue($rs->fields('Nama Form'));
		$this->No->setDbValue($rs->fields('No'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
		$this->Hitung->setDbValue($rs->fields('Hitung'));
		$this->CetakStruk->setDbValue($rs->fields('CetakStruk'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Tgl->DbValue = $row['Tgl'];
		$this->Faktur->DbValue = $row['Faktur'];
		$this->No_Faktur->DbValue = $row['No Faktur'];
		$this->Ppn->DbValue = $row['Ppn'];
		$this->Ongkir->DbValue = $row['Ongkir'];
		$this->Paking->DbValue = $row['Paking'];
		$this->Lain_2D_lain->DbValue = $row['Lain - lain'];
		$this->Piutang->DbValue = $row['Piutang'];
		$this->Total_Berat->DbValue = $row['Total Berat'];
		$this->Total_HP->DbValue = $row['Total HP'];
		$this->Total_HJ->DbValue = $row['Total HJ'];
		$this->Diskon->DbValue = $row['Diskon'];
		$this->Grand_Total->DbValue = $row['Grand Total'];
		$this->Laba->DbValue = $row['Laba'];
		$this->Dibayar->DbValue = $row['Dibayar'];
		$this->Kembali->DbValue = $row['Kembali'];
		$this->SisaDibayar->DbValue = $row['SisaDibayar'];
		$this->Kode_Pelanggan->DbValue = $row['Kode Pelanggan'];
		$this->Nama_Pelanggan->DbValue = $row['Nama Pelanggan'];
		$this->Kode_Suplier->DbValue = $row['Kode Suplier'];
		$this->Kode_Kasir->DbValue = $row['Kode Kasir'];
		$this->Nama_Kasir->DbValue = $row['Nama Kasir'];
		$this->Nama_Form->DbValue = $row['Nama Form'];
		$this->No->DbValue = $row['No'];
		$this->Waktu->DbValue = $row['Waktu'];
		$this->Stamp->DbValue = $row['Stamp'];
		$this->Hitung->DbValue = $row['Hitung'];
		$this->CetakStruk->DbValue = $row['CetakStruk'];
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
		// Convert decimal values if posted back

		if ($this->Diskon->FormValue == $this->Diskon->CurrentValue && is_numeric(ew_StrToFloat($this->Diskon->CurrentValue)))
			$this->Diskon->CurrentValue = ew_StrToFloat($this->Diskon->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// ID
		// Tgl
		// Faktur
		// No Faktur
		// Ppn
		// Ongkir
		// Paking
		// Lain - lain
		// Piutang
		// Total Berat
		// Total HP
		// Total HJ
		// Diskon
		// Grand Total
		// Laba
		// Dibayar
		// Kembali
		// SisaDibayar
		// Kode Pelanggan
		// Nama Pelanggan
		// Kode Suplier
		// Kode Kasir
		// Nama Kasir
		// Nama Form
		// No
		// Waktu
		// Stamp
		// Hitung
		// CetakStruk

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Tgl
			$this->Tgl->ViewValue = $this->Tgl->CurrentValue;
			$this->Tgl->ViewValue = ew_FormatDateTime($this->Tgl->ViewValue, 7);
			$this->Tgl->ViewCustomAttributes = "";

			// No Faktur
			$this->No_Faktur->ViewValue = $this->No_Faktur->CurrentValue;
			$this->No_Faktur->CssStyle = "font-weight: bold;";
			$this->No_Faktur->CellCssStyle .= "text-align: center;";
			$this->No_Faktur->ViewCustomAttributes = "";

			// Total HJ
			$this->Total_HJ->ViewValue = $this->Total_HJ->CurrentValue;
			$this->Total_HJ->ViewValue = ew_FormatNumber($this->Total_HJ->ViewValue, 0, -2, -2, -2);
			$this->Total_HJ->CellCssStyle .= "text-align: right;";
			$this->Total_HJ->ViewCustomAttributes = "";

			// Diskon
			$this->Diskon->ViewValue = $this->Diskon->CurrentValue;
			$this->Diskon->CellCssStyle .= "text-align: center;";
			$this->Diskon->ViewCustomAttributes = "";

			// Grand Total
			$this->Grand_Total->ViewValue = $this->Grand_Total->CurrentValue;
			$this->Grand_Total->ViewValue = ew_FormatNumber($this->Grand_Total->ViewValue, 0, -2, -2, -2);
			$this->Grand_Total->CellCssStyle .= "text-align: right;";
			$this->Grand_Total->ViewCustomAttributes = "";

			// Dibayar
			$this->Dibayar->ViewValue = $this->Dibayar->CurrentValue;
			$this->Dibayar->ViewValue = ew_FormatNumber($this->Dibayar->ViewValue, 0, -2, -2, -2);
			$this->Dibayar->CellCssStyle .= "text-align: right;";
			$this->Dibayar->ViewCustomAttributes = "";

			// SisaDibayar
			$this->SisaDibayar->ViewValue = $this->SisaDibayar->CurrentValue;
			$this->SisaDibayar->ViewValue = ew_FormatNumber($this->SisaDibayar->ViewValue, 0, -2, -2, -2);
			$this->SisaDibayar->CellCssStyle .= "text-align: right;";
			$this->SisaDibayar->ViewCustomAttributes = "";

			// Kode Pelanggan
			if (strval($this->Kode_Pelanggan->CurrentValue) <> "") {
				$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode_Pelanggan->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaPenyewa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar pelanggan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Kode_Pelanggan, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Kode_Pelanggan->ViewValue = $rswrk->fields('DispFld');
					$this->Kode_Pelanggan->ViewValue .= ew_ValueSeparator(1,$this->Kode_Pelanggan) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Kode_Pelanggan->ViewValue = $this->Kode_Pelanggan->CurrentValue;
				}
			} else {
				$this->Kode_Pelanggan->ViewValue = NULL;
			}
			$this->Kode_Pelanggan->ViewCustomAttributes = "";

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

			// Tgl
			$this->Tgl->LinkCustomAttributes = "";
			$this->Tgl->HrefValue = "";
			$this->Tgl->TooltipValue = "";

			// Diskon
			$this->Diskon->LinkCustomAttributes = "";
			$this->Diskon->HrefValue = "";
			$this->Diskon->TooltipValue = "";

			// Dibayar
			$this->Dibayar->LinkCustomAttributes = "";
			$this->Dibayar->HrefValue = "";
			$this->Dibayar->TooltipValue = "";

			// Kode Pelanggan
			$this->Kode_Pelanggan->LinkCustomAttributes = "";
			$this->Kode_Pelanggan->HrefValue = "";
			$this->Kode_Pelanggan->TooltipValue = "";

			// Kode Kasir
			$this->Kode_Kasir->LinkCustomAttributes = "";
			$this->Kode_Kasir->HrefValue = "";
			$this->Kode_Kasir->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Tgl
			$this->Tgl->EditCustomAttributes = "";
			$this->Tgl->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tgl->CurrentValue, 7));
			$this->Tgl->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Tgl->FldCaption()));

			// Diskon
			$this->Diskon->EditCustomAttributes = "";
			$this->Diskon->EditValue = ew_HtmlEncode($this->Diskon->CurrentValue);
			$this->Diskon->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Diskon->FldCaption()));
			if (strval($this->Diskon->EditValue) <> "" && is_numeric($this->Diskon->EditValue)) $this->Diskon->EditValue = ew_FormatNumber($this->Diskon->EditValue, -2, -1, -2, 0);

			// Dibayar
			$this->Dibayar->EditCustomAttributes = "";
			$this->Dibayar->EditValue = ew_HtmlEncode($this->Dibayar->CurrentValue);
			$this->Dibayar->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Dibayar->FldCaption()));

			// Kode Pelanggan
			$this->Kode_Pelanggan->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaPenyewa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `daftar pelanggan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Kode_Pelanggan, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Kode_Pelanggan->EditValue = $arwrk;

			// Kode Kasir
			// Edit refer script
			// Tgl

			$this->Tgl->HrefValue = "";

			// Diskon
			$this->Diskon->HrefValue = "";

			// Dibayar
			$this->Dibayar->HrefValue = "";

			// Kode Pelanggan
			$this->Kode_Pelanggan->HrefValue = "";

			// Kode Kasir
			$this->Kode_Kasir->HrefValue = "";
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
		if (!$this->Tgl->FldIsDetailKey && !is_null($this->Tgl->FormValue) && $this->Tgl->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Tgl->FldCaption());
		}
		if (!ew_CheckEuroDate($this->Tgl->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tgl->FldErrMsg());
		}
		if (!$this->Diskon->FldIsDetailKey && !is_null($this->Diskon->FormValue) && $this->Diskon->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Diskon->FldCaption());
		}
		if (!ew_CheckNumber($this->Diskon->FormValue)) {
			ew_AddMessage($gsFormError, $this->Diskon->FldErrMsg());
		}
		if (!$this->Dibayar->FldIsDetailKey && !is_null($this->Dibayar->FormValue) && $this->Dibayar->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Dibayar->FldCaption());
		}
		if (!ew_CheckInteger($this->Dibayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dibayar->FldErrMsg());
		}
		if (!$this->Kode_Pelanggan->FldIsDetailKey && !is_null($this->Kode_Pelanggan->FormValue) && $this->Kode_Pelanggan->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Kode_Pelanggan->FldCaption());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("penjualan_2D_detail", $DetailTblVar) && $GLOBALS["penjualan_2D_detail"]->DetailAdd) {
			if (!isset($GLOBALS["penjualan_2D_detail_grid"])) $GLOBALS["penjualan_2D_detail_grid"] = new cpenjualan_2D_detail_grid(); // get detail page object
			$GLOBALS["penjualan_2D_detail_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Tgl
		$this->Tgl->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tgl->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// Diskon
		$this->Diskon->SetDbValueDef($rsnew, $this->Diskon->CurrentValue, 0, strval($this->Diskon->CurrentValue) == "");

		// Dibayar
		$this->Dibayar->SetDbValueDef($rsnew, $this->Dibayar->CurrentValue, 0, strval($this->Dibayar->CurrentValue) == "");

		// Kode Pelanggan
		$this->Kode_Pelanggan->SetDbValueDef($rsnew, $this->Kode_Pelanggan->CurrentValue, "", FALSE);

		// Kode Kasir
		$this->Kode_Kasir->SetDbValueDef($rsnew, CurrentUserName(), "");
		$rsnew['Kode Kasir'] = &$this->Kode_Kasir->DbValue;

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("penjualan_2D_detail", $DetailTblVar) && $GLOBALS["penjualan_2D_detail"]->DetailAdd) {
				$GLOBALS["penjualan_2D_detail"]->IDM->setSessionValue($this->ID->CurrentValue); // Set master key
				if (!isset($GLOBALS["penjualan_2D_detail_grid"])) $GLOBALS["penjualan_2D_detail_grid"] = new cpenjualan_2D_detail_grid(); // Get detail page object
				$AddRow = $GLOBALS["penjualan_2D_detail_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["penjualan_2D_detail"]->IDM->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->Kode_Kasir->CurrentValue);
		return TRUE;
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
			if (in_array("penjualan_2D_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["penjualan_2D_detail_grid"]))
					$GLOBALS["penjualan_2D_detail_grid"] = new cpenjualan_2D_detail_grid;
				if ($GLOBALS["penjualan_2D_detail_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["penjualan_2D_detail_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["penjualan_2D_detail_grid"]->CurrentMode = "add";
					$GLOBALS["penjualan_2D_detail_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["penjualan_2D_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["penjualan_2D_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["penjualan_2D_detail_grid"]->IDM->FldIsDetailKey = TRUE;
					$GLOBALS["penjualan_2D_detail_grid"]->IDM->CurrentValue = $this->ID->CurrentValue;
					$GLOBALS["penjualan_2D_detail_grid"]->IDM->setSessionValue($GLOBALS["penjualan_2D_detail_grid"]->IDM->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "penjualan_2D_masterlist.php", $this->TableVar);
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

	      if ($_POST['t']){
	            include('Connections/Konek.php');
	            mysql_select_db($database_Konek, $Konek);    
	            $query_N = "SELECT MAX(No) as Nom FROM `penjualan - master`";
	            $N = mysql_query($query_N, $Konek) or die(mysql_error());
	            $row_N = mysql_fetch_assoc($N);         
	            $totalRows_N = mysql_num_rows($N);

	            // NO           
	            $No = $row_N['Nom'] + 1;
	            if ($totalRows_N == 0){
	            $No = $totalRows_N + 1;  
	            }                                 
	            $query_TOP = "SELECT * FROM `penjualan - master` ORDER BY ID DESC";
	            $TOP = mysql_query($query_TOP, $Konek) or die(mysql_error());
	            $row_TOP = mysql_fetch_assoc($TOP);  

	            // No Faktur
	            $NoFaktur = "J-".$No;
	            $updateSQLM = "UPDATE `penjualan - master` SET No=$No,`No Faktur`='$NoFaktur' WHERE ID=".$row_TOP['ID'];                                                                        
	            mysql_query($updateSQLM, $Konek) or die(mysql_error());                                                                            

	                 //echo "<meta http-equiv='refresh' content='0;URLpersewaan_lapangan_2D_masterlist.php?t=persewaan_lapangan_2D_master&z_Status=LIKE&x_Status=Booking&psearch=&Submit=Search+%28*%29&psearchtype='>";               
	                //$url = ;                               
	                //exit;                                         

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
if (!isset($penjualan_2D_master_add)) $penjualan_2D_master_add = new cpenjualan_2D_master_add();

// Page init
$penjualan_2D_master_add->Page_Init();

// Page main
$penjualan_2D_master_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$penjualan_2D_master_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var penjualan_2D_master_add = new ew_Page("penjualan_2D_master_add");
penjualan_2D_master_add.PageID = "add"; // Page ID
var EW_PAGE_ID = penjualan_2D_master_add.PageID; // For backward compatibility

// Form object
var fpenjualan_2D_masteradd = new ew_Form("fpenjualan_2D_masteradd");

// Validate form
fpenjualan_2D_masteradd.Validate = function() {
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
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_master->Tgl->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Tgl");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($penjualan_2D_master->Tgl->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Diskon");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_master->Diskon->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Diskon");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($penjualan_2D_master->Diskon->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Dibayar");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_master->Dibayar->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Dibayar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($penjualan_2D_master->Dibayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Kode_Pelanggan");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_master->Kode_Pelanggan->FldCaption()) ?>");

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
fpenjualan_2D_masteradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpenjualan_2D_masteradd.ValidateRequired = true;
<?php } else { ?>
fpenjualan_2D_masteradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpenjualan_2D_masteradd.Lists["x_Kode_Pelanggan"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_NamaPenyewa","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpenjualan_2D_masteradd.Lists["x_Kode_Kasir"] = {"LinkField":"x_Username","Ajax":null,"AutoFill":false,"DisplayFields":["x_Username","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $penjualan_2D_master_add->ShowPageHeader(); ?>
<?php
$penjualan_2D_master_add->ShowMessage();
?>
<form name="fpenjualan_2D_masteradd" id="fpenjualan_2D_masteradd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="penjualan_2D_master">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_penjualan_2D_masteradd" class="table table-bordered table-striped">
<?php if ($penjualan_2D_master->Tgl->Visible) { // Tgl ?>
	<tr id="r_Tgl"<?php echo $penjualan_2D_master->RowAttributes() ?>>
		<td><span id="elh_penjualan_2D_master_Tgl"><?php echo $penjualan_2D_master->Tgl->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $penjualan_2D_master->Tgl->CellAttributes() ?>><span id="el_penjualan_2D_master_Tgl" class="control-group">
<input type="text" data-field="x_Tgl" name="x_Tgl" id="x_Tgl" placeholder="<?php echo $penjualan_2D_master->Tgl->PlaceHolder ?>" value="<?php echo $penjualan_2D_master->Tgl->EditValue ?>"<?php echo $penjualan_2D_master->Tgl->EditAttributes() ?>>
</span><?php echo $penjualan_2D_master->Tgl->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Diskon->Visible) { // Diskon ?>
	<tr id="r_Diskon"<?php echo $penjualan_2D_master->RowAttributes() ?>>
		<td><span id="elh_penjualan_2D_master_Diskon"><?php echo $penjualan_2D_master->Diskon->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $penjualan_2D_master->Diskon->CellAttributes() ?>><span id="el_penjualan_2D_master_Diskon" class="control-group">
<input type="text" data-field="x_Diskon" name="x_Diskon" id="x_Diskon" size="30" placeholder="<?php echo $penjualan_2D_master->Diskon->PlaceHolder ?>" value="<?php echo $penjualan_2D_master->Diskon->EditValue ?>"<?php echo $penjualan_2D_master->Diskon->EditAttributes() ?>>
</span><?php echo $penjualan_2D_master->Diskon->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Dibayar->Visible) { // Dibayar ?>
	<tr id="r_Dibayar"<?php echo $penjualan_2D_master->RowAttributes() ?>>
		<td><span id="elh_penjualan_2D_master_Dibayar"><?php echo $penjualan_2D_master->Dibayar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $penjualan_2D_master->Dibayar->CellAttributes() ?>><span id="el_penjualan_2D_master_Dibayar" class="control-group">
<input type="text" data-field="x_Dibayar" name="x_Dibayar" id="x_Dibayar" size="30" placeholder="<?php echo $penjualan_2D_master->Dibayar->PlaceHolder ?>" value="<?php echo $penjualan_2D_master->Dibayar->EditValue ?>"<?php echo $penjualan_2D_master->Dibayar->EditAttributes() ?>>
</span><?php echo $penjualan_2D_master->Dibayar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($penjualan_2D_master->Kode_Pelanggan->Visible) { // Kode Pelanggan ?>
	<tr id="r_Kode_Pelanggan"<?php echo $penjualan_2D_master->RowAttributes() ?>>
		<td><span id="elh_penjualan_2D_master_Kode_Pelanggan"><?php echo $penjualan_2D_master->Kode_Pelanggan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $penjualan_2D_master->Kode_Pelanggan->CellAttributes() ?>><span id="el_penjualan_2D_master_Kode_Pelanggan" class="control-group">
<select data-field="x_Kode_Pelanggan" id="x_Kode_Pelanggan" name="x_Kode_Pelanggan"<?php echo $penjualan_2D_master->Kode_Pelanggan->EditAttributes() ?>>
<?php
if (is_array($penjualan_2D_master->Kode_Pelanggan->EditValue)) {
	$arwrk = $penjualan_2D_master->Kode_Pelanggan->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($penjualan_2D_master->Kode_Pelanggan->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$penjualan_2D_master->Kode_Pelanggan) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
fpenjualan_2D_masteradd.Lists["x_Kode_Pelanggan"].Options = <?php echo (is_array($penjualan_2D_master->Kode_Pelanggan->EditValue)) ? ew_ArrayToJson($penjualan_2D_master->Kode_Pelanggan->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $penjualan_2D_master->Kode_Pelanggan->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("penjualan_2D_detail", explode(",", $penjualan_2D_master->getCurrentDetailTable())) && $penjualan_2D_detail->DetailAdd) {
?>
<?php include_once "penjualan_2D_detailgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fpenjualan_2D_masteradd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$penjualan_2D_master_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$penjualan_2D_master_add->Page_Terminate();
?>

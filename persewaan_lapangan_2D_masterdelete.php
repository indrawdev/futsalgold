<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "persewaan_lapangan_2D_masterinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$persewaan_lapangan_2D_master_delete = NULL; // Initialize page object first

class cpersewaan_lapangan_2D_master_delete extends cpersewaan_lapangan_2D_master {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'persewaan lapangan - master';

	// Page object name
	var $PageObjName = 'persewaan_lapangan_2D_master_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("persewaan_lapangan_2D_masterlist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("persewaan_lapangan_2D_masterlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in persewaan_lapangan_2D_master class, persewaan_lapangan_2D_masterinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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

		$this->ID->CellCssStyle = "white-space: nowrap;";

		// No
		$this->No->CellCssStyle = "white-space: nowrap;";

		// No Faktur
		// Faktur

		$this->Faktur->CellCssStyle = "white-space: nowrap;";

		// Tgl
		// Kode
		// Nama
		// Alamat

		$this->Alamat->CellCssStyle = "white-space: nowrap;";

		// Kota
		$this->Kota->CellCssStyle = "white-space: nowrap;";

		// Telepon
		$this->Telepon->CellCssStyle = "white-space: nowrap;";

		// Main
		$this->Main->CellCssStyle = "white-space: nowrap;";

		// Total
		$this->Total->CellCssStyle = "white-space: nowrap;";

		// Bayar
		// Sisa
		// Sub Total
		// Diskon
		// Potongan
		// Grand Total
		// Kode Kasir

		$this->Kode_Kasir->CellCssStyle = "width: 100px;";

		// Status
		// Nama Kasir

		$this->Nama_Kasir->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";

		// Hitung
		$this->Hitung->CellCssStyle = "white-space: nowrap;";

		// Cetak Struk
		$this->Cetak_Struk->CellCssStyle = "white-space: nowrap;";
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

			// Hitung
			$this->Hitung->ViewValue = $this->Hitung->CurrentValue;
			$this->Hitung->ViewCustomAttributes = "";

			// Cetak Struk
			$this->Cetak_Struk->ViewValue = $this->Cetak_Struk->CurrentValue;
			$this->Cetak_Struk->ViewCustomAttributes = "";

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

			// Sisa
			$this->Sisa->LinkCustomAttributes = "";
			$this->Sisa->HrefValue = "";
			$this->Sisa->TooltipValue = "";

			// Sub Total
			$this->Sub_Total->LinkCustomAttributes = "";
			$this->Sub_Total->HrefValue = "";
			$this->Sub_Total->TooltipValue = "";

			// Diskon
			$this->Diskon->LinkCustomAttributes = "";
			$this->Diskon->HrefValue = "";
			$this->Diskon->TooltipValue = "";

			// Potongan
			$this->Potongan->LinkCustomAttributes = "";
			$this->Potongan->HrefValue = "";
			$this->Potongan->TooltipValue = "";

			// Grand Total
			$this->Grand_Total->LinkCustomAttributes = "";
			$this->Grand_Total->HrefValue = "";
			$this->Grand_Total->TooltipValue = "";

			// Kode Kasir
			$this->Kode_Kasir->LinkCustomAttributes = "";
			$this->Kode_Kasir->HrefValue = "";
			$this->Kode_Kasir->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Hitung
			$this->Hitung->LinkCustomAttributes = "";
			if (!ew_Empty($this->ID->CurrentValue)) {
				$this->Hitung->HrefValue = "AppHitung.php?id=" . ((!empty($this->ID->ViewValue)) ? $this->ID->ViewValue : $this->ID->CurrentValue); // Add prefix/suffix
				$this->Hitung->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Hitung->HrefValue = ew_ConvertFullUrl($this->Hitung->HrefValue);
			} else {
				$this->Hitung->HrefValue = "";
			}
			$this->Hitung->TooltipValue = "";

			// Cetak Struk
			$this->Cetak_Struk->LinkCustomAttributes = "";
			if (!ew_Empty($this->ID->CurrentValue)) {
				$this->Cetak_Struk->HrefValue = "AppCetakLapangan.php?id=" . ((!empty($this->ID->ViewValue)) ? $this->ID->ViewValue : $this->ID->CurrentValue); // Add prefix/suffix
				$this->Cetak_Struk->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Cetak_Struk->HrefValue = ew_ConvertFullUrl($this->Cetak_Struk->HrefValue);
			} else {
				$this->Cetak_Struk->HrefValue = "";
			}
			$this->Cetak_Struk->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['ID'];
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "persewaan_lapangan_2D_masterlist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($persewaan_lapangan_2D_master_delete)) $persewaan_lapangan_2D_master_delete = new cpersewaan_lapangan_2D_master_delete();

// Page init
$persewaan_lapangan_2D_master_delete->Page_Init();

// Page main
$persewaan_lapangan_2D_master_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persewaan_lapangan_2D_master_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var persewaan_lapangan_2D_master_delete = new ew_Page("persewaan_lapangan_2D_master_delete");
persewaan_lapangan_2D_master_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = persewaan_lapangan_2D_master_delete.PageID; // For backward compatibility

// Form object
var fpersewaan_lapangan_2D_masterdelete = new ew_Form("fpersewaan_lapangan_2D_masterdelete");

// Form_CustomValidate event
fpersewaan_lapangan_2D_masterdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersewaan_lapangan_2D_masterdelete.ValidateRequired = true;
<?php } else { ?>
fpersewaan_lapangan_2D_masterdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersewaan_lapangan_2D_masterdelete.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_NamaPenyewa","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpersewaan_lapangan_2D_masterdelete.Lists["x_Kode_Kasir"] = {"LinkField":"x_Username","Ajax":null,"AutoFill":false,"DisplayFields":["x_Username","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($persewaan_lapangan_2D_master_delete->Recordset = $persewaan_lapangan_2D_master_delete->LoadRecordset())
	$persewaan_lapangan_2D_master_deleteTotalRecs = $persewaan_lapangan_2D_master_delete->Recordset->RecordCount(); // Get record count
if ($persewaan_lapangan_2D_master_deleteTotalRecs <= 0) { // No record found, exit
	if ($persewaan_lapangan_2D_master_delete->Recordset)
		$persewaan_lapangan_2D_master_delete->Recordset->Close();
	$persewaan_lapangan_2D_master_delete->Page_Terminate("persewaan_lapangan_2D_masterlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $persewaan_lapangan_2D_master_delete->ShowPageHeader(); ?>
<?php
$persewaan_lapangan_2D_master_delete->ShowMessage();
?>
<form name="fpersewaan_lapangan_2D_masterdelete" id="fpersewaan_lapangan_2D_masterdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="persewaan_lapangan_2D_master">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($persewaan_lapangan_2D_master_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_persewaan_lapangan_2D_masterdelete" class="ewTable ewTableSeparate">
<?php echo $persewaan_lapangan_2D_master->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_persewaan_lapangan_2D_master_No_Faktur" class="persewaan_lapangan_2D_master_No_Faktur"><?php echo $persewaan_lapangan_2D_master->No_Faktur->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Tgl" class="persewaan_lapangan_2D_master_Tgl"><?php echo $persewaan_lapangan_2D_master->Tgl->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Kode" class="persewaan_lapangan_2D_master_Kode"><?php echo $persewaan_lapangan_2D_master->Kode->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Nama" class="persewaan_lapangan_2D_master_Nama"><?php echo $persewaan_lapangan_2D_master->Nama->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Bayar" class="persewaan_lapangan_2D_master_Bayar"><?php echo $persewaan_lapangan_2D_master->Bayar->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Sisa" class="persewaan_lapangan_2D_master_Sisa"><?php echo $persewaan_lapangan_2D_master->Sisa->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Sub_Total" class="persewaan_lapangan_2D_master_Sub_Total"><?php echo $persewaan_lapangan_2D_master->Sub_Total->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Diskon" class="persewaan_lapangan_2D_master_Diskon"><?php echo $persewaan_lapangan_2D_master->Diskon->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Potongan" class="persewaan_lapangan_2D_master_Potongan"><?php echo $persewaan_lapangan_2D_master->Potongan->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Grand_Total" class="persewaan_lapangan_2D_master_Grand_Total"><?php echo $persewaan_lapangan_2D_master->Grand_Total->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Kode_Kasir" class="persewaan_lapangan_2D_master_Kode_Kasir"><?php echo $persewaan_lapangan_2D_master->Kode_Kasir->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Status" class="persewaan_lapangan_2D_master_Status"><?php echo $persewaan_lapangan_2D_master->Status->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Hitung" class="persewaan_lapangan_2D_master_Hitung"><?php echo $persewaan_lapangan_2D_master->Hitung->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_master_Cetak_Struk" class="persewaan_lapangan_2D_master_Cetak_Struk"><?php echo $persewaan_lapangan_2D_master->Cetak_Struk->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$persewaan_lapangan_2D_master_delete->RecCnt = 0;
$i = 0;
while (!$persewaan_lapangan_2D_master_delete->Recordset->EOF) {
	$persewaan_lapangan_2D_master_delete->RecCnt++;
	$persewaan_lapangan_2D_master_delete->RowCnt++;

	// Set row properties
	$persewaan_lapangan_2D_master->ResetAttrs();
	$persewaan_lapangan_2D_master->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$persewaan_lapangan_2D_master_delete->LoadRowValues($persewaan_lapangan_2D_master_delete->Recordset);

	// Render row
	$persewaan_lapangan_2D_master_delete->RenderRow();
?>
	<tr<?php echo $persewaan_lapangan_2D_master->RowAttributes() ?>>
		<td<?php echo $persewaan_lapangan_2D_master->No_Faktur->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_No_Faktur" class="control-group persewaan_lapangan_2D_master_No_Faktur">
<span<?php echo $persewaan_lapangan_2D_master->No_Faktur->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->No_Faktur->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Tgl->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Tgl" class="control-group persewaan_lapangan_2D_master_Tgl">
<span<?php echo $persewaan_lapangan_2D_master->Tgl->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Tgl->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Kode->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Kode" class="control-group persewaan_lapangan_2D_master_Kode">
<span<?php echo $persewaan_lapangan_2D_master->Kode->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Kode->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Nama->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Nama" class="control-group persewaan_lapangan_2D_master_Nama">
<span<?php echo $persewaan_lapangan_2D_master->Nama->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Nama->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Bayar->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Bayar" class="control-group persewaan_lapangan_2D_master_Bayar">
<span<?php echo $persewaan_lapangan_2D_master->Bayar->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Bayar->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Sisa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Sisa" class="control-group persewaan_lapangan_2D_master_Sisa">
<span<?php echo $persewaan_lapangan_2D_master->Sisa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Sisa->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Sub_Total->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Sub_Total" class="control-group persewaan_lapangan_2D_master_Sub_Total">
<span<?php echo $persewaan_lapangan_2D_master->Sub_Total->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Sub_Total->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Diskon->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Diskon" class="control-group persewaan_lapangan_2D_master_Diskon">
<span<?php echo $persewaan_lapangan_2D_master->Diskon->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Diskon->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Potongan->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Potongan" class="control-group persewaan_lapangan_2D_master_Potongan">
<span<?php echo $persewaan_lapangan_2D_master->Potongan->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Potongan->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Grand_Total->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Grand_Total" class="control-group persewaan_lapangan_2D_master_Grand_Total">
<span<?php echo $persewaan_lapangan_2D_master->Grand_Total->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Grand_Total->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Kode_Kasir->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Kode_Kasir" class="control-group persewaan_lapangan_2D_master_Kode_Kasir">
<span<?php echo $persewaan_lapangan_2D_master->Kode_Kasir->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Kode_Kasir->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Status->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Status" class="control-group persewaan_lapangan_2D_master_Status">
<span<?php echo $persewaan_lapangan_2D_master->Status->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_master->Status->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Hitung->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Hitung" class="control-group persewaan_lapangan_2D_master_Hitung">
<span<?php echo $persewaan_lapangan_2D_master->Hitung->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($persewaan_lapangan_2D_master->Hitung->ListViewValue()) && $persewaan_lapangan_2D_master->Hitung->LinkAttributes() <> "") { ?>
<a<?php echo $persewaan_lapangan_2D_master->Hitung->LinkAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Hitung->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $persewaan_lapangan_2D_master->Hitung->ListViewValue() ?>
<?php } ?>
</span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_master->Cetak_Struk->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_master_delete->RowCnt ?>_persewaan_lapangan_2D_master_Cetak_Struk" class="control-group persewaan_lapangan_2D_master_Cetak_Struk">
<span<?php echo $persewaan_lapangan_2D_master->Cetak_Struk->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($persewaan_lapangan_2D_master->Cetak_Struk->ListViewValue()) && $persewaan_lapangan_2D_master->Cetak_Struk->LinkAttributes() <> "") { ?>
<a<?php echo $persewaan_lapangan_2D_master->Cetak_Struk->LinkAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Cetak_Struk->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $persewaan_lapangan_2D_master->Cetak_Struk->ListViewValue() ?>
<?php } ?>
</span>
</span></td>
	</tr>
<?php
	$persewaan_lapangan_2D_master_delete->Recordset->MoveNext();
}
$persewaan_lapangan_2D_master_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fpersewaan_lapangan_2D_masterdelete.Init();
</script>
<?php
$persewaan_lapangan_2D_master_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$persewaan_lapangan_2D_master_delete->Page_Terminate();
?>

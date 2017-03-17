<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "pembelian_2D_masterinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$pembelian_2D_master_delete = NULL; // Initialize page object first

class cpembelian_2D_master_delete extends cpembelian_2D_master {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'pembelian - master';

	// Page object name
	var $PageObjName = 'pembelian_2D_master_delete';

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

		// Table object (pembelian_2D_master)
		if (!isset($GLOBALS["pembelian_2D_master"])) {
			$GLOBALS["pembelian_2D_master"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pembelian_2D_master"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pembelian - master', TRUE);

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
			$this->Page_Terminate("pembelian_2D_masterlist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		if ($Security->IsLoggedIn() && strval($Security->CurrentUserID()) == "") {
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("pembelian_2D_masterlist.php");
		}
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
			$this->Page_Terminate("pembelian_2D_masterlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in pembelian_2D_master class, pembelian_2D_masterinfo.php

		$this->CurrentFilter = $sFilter;

		// Check if valid user id
		$sql = $this->GetSQL($this->CurrentFilter, "");
		if ($this->Recordset = ew_LoadRecordset($sql)) {
			$res = TRUE;
			while (!$this->Recordset->EOF) {
				$this->LoadRowValues($this->Recordset);
				if (!$this->ShowOptionLink('delete')) {
					$sUserIdMsg = $Language->Phrase("NoDeletePermission");
					$this->setFailureMessage($sUserIdMsg);
					$res = FALSE;
					break;
				}
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
			if (!$res) $this->Page_Terminate("pembelian_2D_masterlist.php"); // Return to list
		}

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
		$this->Tgl->setDbValue($rs->fields('Tgl'));
		$this->Faktur->setDbValue($rs->fields('Faktur'));
		$this->No_Faktur->setDbValue($rs->fields('No Faktur'));
		$this->Diskon->setDbValue($rs->fields('Diskon'));
		$this->Ppn->setDbValue($rs->fields('Ppn'));
		$this->Ongkir->setDbValue($rs->fields('Ongkir'));
		$this->Paking->setDbValue($rs->fields('Paking'));
		$this->Lain_2D_lain->setDbValue($rs->fields('Lain - lain'));
		$this->Hutang->setDbValue($rs->fields('Hutang'));
		$this->Total_Berat->setDbValue($rs->fields('Total Berat'));
		$this->Total_HP->setDbValue($rs->fields('Total HP'));
		$this->Total_HJ->setDbValue($rs->fields('Total HJ'));
		$this->Grand_Total->setDbValue($rs->fields('Grand Total'));
		$this->Dibayar->setDbValue($rs->fields('Dibayar'));
		$this->Kembali->setDbValue($rs->fields('Kembali'));
		$this->SisaDibayar->setDbValue($rs->fields('SisaDibayar'));
		$this->Kode_Kasir->setDbValue($rs->fields('Kode Kasir'));
		$this->Nama_Kasir->setDbValue($rs->fields('Nama Kasir'));
		$this->Kode_Supplier->setDbValue($rs->fields('Kode Supplier'));
		$this->Nama_Supplier->setDbValue($rs->fields('Nama Supplier'));
		$this->Nama_Form->setDbValue($rs->fields('Nama Form'));
		$this->No->setDbValue($rs->fields('No'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
		$this->Hitung->setDbValue($rs->fields('Hitung'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Tgl->DbValue = $row['Tgl'];
		$this->Faktur->DbValue = $row['Faktur'];
		$this->No_Faktur->DbValue = $row['No Faktur'];
		$this->Diskon->DbValue = $row['Diskon'];
		$this->Ppn->DbValue = $row['Ppn'];
		$this->Ongkir->DbValue = $row['Ongkir'];
		$this->Paking->DbValue = $row['Paking'];
		$this->Lain_2D_lain->DbValue = $row['Lain - lain'];
		$this->Hutang->DbValue = $row['Hutang'];
		$this->Total_Berat->DbValue = $row['Total Berat'];
		$this->Total_HP->DbValue = $row['Total HP'];
		$this->Total_HJ->DbValue = $row['Total HJ'];
		$this->Grand_Total->DbValue = $row['Grand Total'];
		$this->Dibayar->DbValue = $row['Dibayar'];
		$this->Kembali->DbValue = $row['Kembali'];
		$this->SisaDibayar->DbValue = $row['SisaDibayar'];
		$this->Kode_Kasir->DbValue = $row['Kode Kasir'];
		$this->Nama_Kasir->DbValue = $row['Nama Kasir'];
		$this->Kode_Supplier->DbValue = $row['Kode Supplier'];
		$this->Nama_Supplier->DbValue = $row['Nama Supplier'];
		$this->Nama_Form->DbValue = $row['Nama Form'];
		$this->No->DbValue = $row['No'];
		$this->Waktu->DbValue = $row['Waktu'];
		$this->Stamp->DbValue = $row['Stamp'];
		$this->Hitung->DbValue = $row['Hitung'];
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

		// Tgl
		// Faktur

		$this->Faktur->CellCssStyle = "white-space: nowrap;";

		// No Faktur
		// Diskon

		$this->Diskon->CellCssStyle = "white-space: nowrap;";

		// Ppn
		$this->Ppn->CellCssStyle = "white-space: nowrap;";

		// Ongkir
		$this->Ongkir->CellCssStyle = "white-space: nowrap;";

		// Paking
		$this->Paking->CellCssStyle = "white-space: nowrap;";

		// Lain - lain
		$this->Lain_2D_lain->CellCssStyle = "white-space: nowrap;";

		// Hutang
		$this->Hutang->CellCssStyle = "white-space: nowrap;";

		// Total Berat
		$this->Total_Berat->CellCssStyle = "white-space: nowrap;";

		// Total HP
		$this->Total_HP->CellCssStyle = "white-space: nowrap;";

		// Total HJ
		$this->Total_HJ->CellCssStyle = "white-space: nowrap;";

		// Grand Total
		// Dibayar
		// Kembali

		$this->Kembali->CellCssStyle = "white-space: nowrap;";

		// SisaDibayar
		// Kode Kasir
		// Nama Kasir

		$this->Nama_Kasir->CellCssStyle = "white-space: nowrap;";

		// Kode Supplier
		// Nama Supplier

		$this->Nama_Supplier->CellCssStyle = "white-space: nowrap;";

		// Nama Form
		$this->Nama_Form->CellCssStyle = "white-space: nowrap;";

		// No
		$this->No->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";

		// Hitung
		$this->Hitung->CellCssStyle = "white-space: nowrap;";
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

			// Kode Supplier
			if (strval($this->Kode_Supplier->CurrentValue) <> "") {
				$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode_Supplier->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `Nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar suplier`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Kode_Supplier, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Kode_Supplier->ViewValue = $rswrk->fields('DispFld');
					$this->Kode_Supplier->ViewValue .= ew_ValueSeparator(1,$this->Kode_Supplier) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Kode_Supplier->ViewValue = $this->Kode_Supplier->CurrentValue;
				}
			} else {
				$this->Kode_Supplier->ViewValue = NULL;
			}
			$this->Kode_Supplier->ViewCustomAttributes = "";

			// Hitung
			$this->Hitung->ViewValue = $this->Hitung->CurrentValue;
			$this->Hitung->ViewCustomAttributes = "";

			// Tgl
			$this->Tgl->LinkCustomAttributes = "";
			$this->Tgl->HrefValue = "";
			$this->Tgl->TooltipValue = "";

			// No Faktur
			$this->No_Faktur->LinkCustomAttributes = "";
			$this->No_Faktur->HrefValue = "";
			$this->No_Faktur->TooltipValue = "";

			// Grand Total
			$this->Grand_Total->LinkCustomAttributes = "";
			$this->Grand_Total->HrefValue = "";
			$this->Grand_Total->TooltipValue = "";

			// Dibayar
			$this->Dibayar->LinkCustomAttributes = "";
			$this->Dibayar->HrefValue = "";
			$this->Dibayar->TooltipValue = "";

			// SisaDibayar
			$this->SisaDibayar->LinkCustomAttributes = "";
			$this->SisaDibayar->HrefValue = "";
			$this->SisaDibayar->TooltipValue = "";

			// Kode Kasir
			$this->Kode_Kasir->LinkCustomAttributes = "";
			$this->Kode_Kasir->HrefValue = "";
			$this->Kode_Kasir->TooltipValue = "";

			// Kode Supplier
			$this->Kode_Supplier->LinkCustomAttributes = "";
			$this->Kode_Supplier->HrefValue = "";
			$this->Kode_Supplier->TooltipValue = "";

			// Hitung
			$this->Hitung->LinkCustomAttributes = "";
			if (!ew_Empty($this->ID->CurrentValue)) {
				$this->Hitung->HrefValue = "AppHitungPembelian.php?id=" . ((!empty($this->ID->ViewValue)) ? $this->ID->ViewValue : $this->ID->CurrentValue); // Add prefix/suffix
				$this->Hitung->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Hitung->HrefValue = ew_ConvertFullUrl($this->Hitung->HrefValue);
			} else {
				$this->Hitung->HrefValue = "";
			}
			$this->Hitung->TooltipValue = "";
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

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->Kode_Kasir->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "pembelian_2D_masterlist.php", $this->TableVar);
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
if (!isset($pembelian_2D_master_delete)) $pembelian_2D_master_delete = new cpembelian_2D_master_delete();

// Page init
$pembelian_2D_master_delete->Page_Init();

// Page main
$pembelian_2D_master_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pembelian_2D_master_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var pembelian_2D_master_delete = new ew_Page("pembelian_2D_master_delete");
pembelian_2D_master_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = pembelian_2D_master_delete.PageID; // For backward compatibility

// Form object
var fpembelian_2D_masterdelete = new ew_Form("fpembelian_2D_masterdelete");

// Form_CustomValidate event
fpembelian_2D_masterdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpembelian_2D_masterdelete.ValidateRequired = true;
<?php } else { ?>
fpembelian_2D_masterdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpembelian_2D_masterdelete.Lists["x_Kode_Kasir"] = {"LinkField":"x_Username","Ajax":null,"AutoFill":false,"DisplayFields":["x_Username","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpembelian_2D_masterdelete.Lists["x_Kode_Supplier"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($pembelian_2D_master_delete->Recordset = $pembelian_2D_master_delete->LoadRecordset())
	$pembelian_2D_master_deleteTotalRecs = $pembelian_2D_master_delete->Recordset->RecordCount(); // Get record count
if ($pembelian_2D_master_deleteTotalRecs <= 0) { // No record found, exit
	if ($pembelian_2D_master_delete->Recordset)
		$pembelian_2D_master_delete->Recordset->Close();
	$pembelian_2D_master_delete->Page_Terminate("pembelian_2D_masterlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $pembelian_2D_master_delete->ShowPageHeader(); ?>
<?php
$pembelian_2D_master_delete->ShowMessage();
?>
<form name="fpembelian_2D_masterdelete" id="fpembelian_2D_masterdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="pembelian_2D_master">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($pembelian_2D_master_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_pembelian_2D_masterdelete" class="ewTable ewTableSeparate">
<?php echo $pembelian_2D_master->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_pembelian_2D_master_Tgl" class="pembelian_2D_master_Tgl"><?php echo $pembelian_2D_master->Tgl->FldCaption() ?></span></td>
		<td><span id="elh_pembelian_2D_master_No_Faktur" class="pembelian_2D_master_No_Faktur"><?php echo $pembelian_2D_master->No_Faktur->FldCaption() ?></span></td>
		<td><span id="elh_pembelian_2D_master_Grand_Total" class="pembelian_2D_master_Grand_Total"><?php echo $pembelian_2D_master->Grand_Total->FldCaption() ?></span></td>
		<td><span id="elh_pembelian_2D_master_Dibayar" class="pembelian_2D_master_Dibayar"><?php echo $pembelian_2D_master->Dibayar->FldCaption() ?></span></td>
		<td><span id="elh_pembelian_2D_master_SisaDibayar" class="pembelian_2D_master_SisaDibayar"><?php echo $pembelian_2D_master->SisaDibayar->FldCaption() ?></span></td>
		<td><span id="elh_pembelian_2D_master_Kode_Kasir" class="pembelian_2D_master_Kode_Kasir"><?php echo $pembelian_2D_master->Kode_Kasir->FldCaption() ?></span></td>
		<td><span id="elh_pembelian_2D_master_Kode_Supplier" class="pembelian_2D_master_Kode_Supplier"><?php echo $pembelian_2D_master->Kode_Supplier->FldCaption() ?></span></td>
		<td><span id="elh_pembelian_2D_master_Hitung" class="pembelian_2D_master_Hitung"><?php echo $pembelian_2D_master->Hitung->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$pembelian_2D_master_delete->RecCnt = 0;
$i = 0;
while (!$pembelian_2D_master_delete->Recordset->EOF) {
	$pembelian_2D_master_delete->RecCnt++;
	$pembelian_2D_master_delete->RowCnt++;

	// Set row properties
	$pembelian_2D_master->ResetAttrs();
	$pembelian_2D_master->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$pembelian_2D_master_delete->LoadRowValues($pembelian_2D_master_delete->Recordset);

	// Render row
	$pembelian_2D_master_delete->RenderRow();
?>
	<tr<?php echo $pembelian_2D_master->RowAttributes() ?>>
		<td<?php echo $pembelian_2D_master->Tgl->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_master_delete->RowCnt ?>_pembelian_2D_master_Tgl" class="control-group pembelian_2D_master_Tgl">
<span<?php echo $pembelian_2D_master->Tgl->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Tgl->ListViewValue() ?></span>
</span></td>
		<td<?php echo $pembelian_2D_master->No_Faktur->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_master_delete->RowCnt ?>_pembelian_2D_master_No_Faktur" class="control-group pembelian_2D_master_No_Faktur">
<span<?php echo $pembelian_2D_master->No_Faktur->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->No_Faktur->ListViewValue() ?></span>
</span></td>
		<td<?php echo $pembelian_2D_master->Grand_Total->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_master_delete->RowCnt ?>_pembelian_2D_master_Grand_Total" class="control-group pembelian_2D_master_Grand_Total">
<span<?php echo $pembelian_2D_master->Grand_Total->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Grand_Total->ListViewValue() ?></span>
</span></td>
		<td<?php echo $pembelian_2D_master->Dibayar->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_master_delete->RowCnt ?>_pembelian_2D_master_Dibayar" class="control-group pembelian_2D_master_Dibayar">
<span<?php echo $pembelian_2D_master->Dibayar->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Dibayar->ListViewValue() ?></span>
</span></td>
		<td<?php echo $pembelian_2D_master->SisaDibayar->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_master_delete->RowCnt ?>_pembelian_2D_master_SisaDibayar" class="control-group pembelian_2D_master_SisaDibayar">
<span<?php echo $pembelian_2D_master->SisaDibayar->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->SisaDibayar->ListViewValue() ?></span>
</span></td>
		<td<?php echo $pembelian_2D_master->Kode_Kasir->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_master_delete->RowCnt ?>_pembelian_2D_master_Kode_Kasir" class="control-group pembelian_2D_master_Kode_Kasir">
<span<?php echo $pembelian_2D_master->Kode_Kasir->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Kode_Kasir->ListViewValue() ?></span>
</span></td>
		<td<?php echo $pembelian_2D_master->Kode_Supplier->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_master_delete->RowCnt ?>_pembelian_2D_master_Kode_Supplier" class="control-group pembelian_2D_master_Kode_Supplier">
<span<?php echo $pembelian_2D_master->Kode_Supplier->ViewAttributes() ?>>
<?php echo $pembelian_2D_master->Kode_Supplier->ListViewValue() ?></span>
</span></td>
		<td<?php echo $pembelian_2D_master->Hitung->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_master_delete->RowCnt ?>_pembelian_2D_master_Hitung" class="control-group pembelian_2D_master_Hitung">
<span<?php echo $pembelian_2D_master->Hitung->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($pembelian_2D_master->Hitung->ListViewValue()) && $pembelian_2D_master->Hitung->LinkAttributes() <> "") { ?>
<a<?php echo $pembelian_2D_master->Hitung->LinkAttributes() ?>><?php echo $pembelian_2D_master->Hitung->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $pembelian_2D_master->Hitung->ListViewValue() ?>
<?php } ?>
</span>
</span></td>
	</tr>
<?php
	$pembelian_2D_master_delete->Recordset->MoveNext();
}
$pembelian_2D_master_delete->Recordset->Close();
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
fpembelian_2D_masterdelete.Init();
</script>
<?php
$pembelian_2D_master_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pembelian_2D_master_delete->Page_Terminate();
?>

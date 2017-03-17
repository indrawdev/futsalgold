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

$persewaan_lapangan_2D_detail_delete = NULL; // Initialize page object first

class cpersewaan_lapangan_2D_detail_delete extends cpersewaan_lapangan_2D_detail {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'persewaan lapangan - detail';

	// Page object name
	var $PageObjName = 'persewaan_lapangan_2D_detail_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("persewaan_lapangan_2D_detaillist.php");
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
			$this->Page_Terminate("persewaan_lapangan_2D_detaillist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in persewaan_lapangan_2D_detail class, persewaan_lapangan_2D_detailinfo.php

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

		// Kode
		// NamaLapangan
		// TglSewa
		// JamSewa
		// HargaSewa
		// Hitung

		$this->Hitung->CellCssStyle = "white-space: nowrap;";

		// Status
		$this->Status->CellCssStyle = "white-space: nowrap;";

		// IDM
		$this->IDM->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";
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

			// Hitung
			$this->Hitung->ViewValue = $this->Hitung->CurrentValue;
			$this->Hitung->ViewCustomAttributes = "";

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

			// HargaSewa
			$this->HargaSewa->LinkCustomAttributes = "";
			$this->HargaSewa->HrefValue = "";
			$this->HargaSewa->TooltipValue = "";

			// Hitung
			$this->Hitung->LinkCustomAttributes = "";
			if (!ew_Empty($this->IDM->CurrentValue)) {
				$this->Hitung->HrefValue = "AppHitung.php?id=" . ((!empty($this->IDM->ViewValue)) ? $this->IDM->ViewValue : $this->IDM->CurrentValue); // Add prefix/suffix
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "persewaan_lapangan_2D_detaillist.php", $this->TableVar);
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
if (!isset($persewaan_lapangan_2D_detail_delete)) $persewaan_lapangan_2D_detail_delete = new cpersewaan_lapangan_2D_detail_delete();

// Page init
$persewaan_lapangan_2D_detail_delete->Page_Init();

// Page main
$persewaan_lapangan_2D_detail_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persewaan_lapangan_2D_detail_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var persewaan_lapangan_2D_detail_delete = new ew_Page("persewaan_lapangan_2D_detail_delete");
persewaan_lapangan_2D_detail_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = persewaan_lapangan_2D_detail_delete.PageID; // For backward compatibility

// Form object
var fpersewaan_lapangan_2D_detaildelete = new ew_Form("fpersewaan_lapangan_2D_detaildelete");

// Form_CustomValidate event
fpersewaan_lapangan_2D_detaildelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersewaan_lapangan_2D_detaildelete.ValidateRequired = true;
<?php } else { ?>
fpersewaan_lapangan_2D_detaildelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersewaan_lapangan_2D_detaildelete.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_NamaLapangan","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($persewaan_lapangan_2D_detail_delete->Recordset = $persewaan_lapangan_2D_detail_delete->LoadRecordset())
	$persewaan_lapangan_2D_detail_deleteTotalRecs = $persewaan_lapangan_2D_detail_delete->Recordset->RecordCount(); // Get record count
if ($persewaan_lapangan_2D_detail_deleteTotalRecs <= 0) { // No record found, exit
	if ($persewaan_lapangan_2D_detail_delete->Recordset)
		$persewaan_lapangan_2D_detail_delete->Recordset->Close();
	$persewaan_lapangan_2D_detail_delete->Page_Terminate("persewaan_lapangan_2D_detaillist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $persewaan_lapangan_2D_detail_delete->ShowPageHeader(); ?>
<?php
$persewaan_lapangan_2D_detail_delete->ShowMessage();
?>
<form name="fpersewaan_lapangan_2D_detaildelete" id="fpersewaan_lapangan_2D_detaildelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="persewaan_lapangan_2D_detail">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($persewaan_lapangan_2D_detail_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_persewaan_lapangan_2D_detaildelete" class="ewTable ewTableSeparate">
<?php echo $persewaan_lapangan_2D_detail->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_persewaan_lapangan_2D_detail_Kode" class="persewaan_lapangan_2D_detail_Kode"><?php echo $persewaan_lapangan_2D_detail->Kode->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_detail_NamaLapangan" class="persewaan_lapangan_2D_detail_NamaLapangan"><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_detail_TglSewa" class="persewaan_lapangan_2D_detail_TglSewa"><?php echo $persewaan_lapangan_2D_detail->TglSewa->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_detail_JamSewa" class="persewaan_lapangan_2D_detail_JamSewa"><?php echo $persewaan_lapangan_2D_detail->JamSewa->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_detail_HargaSewa" class="persewaan_lapangan_2D_detail_HargaSewa"><?php echo $persewaan_lapangan_2D_detail->HargaSewa->FldCaption() ?></span></td>
		<td><span id="elh_persewaan_lapangan_2D_detail_Hitung" class="persewaan_lapangan_2D_detail_Hitung"><?php echo $persewaan_lapangan_2D_detail->Hitung->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$persewaan_lapangan_2D_detail_delete->RecCnt = 0;
$i = 0;
while (!$persewaan_lapangan_2D_detail_delete->Recordset->EOF) {
	$persewaan_lapangan_2D_detail_delete->RecCnt++;
	$persewaan_lapangan_2D_detail_delete->RowCnt++;

	// Set row properties
	$persewaan_lapangan_2D_detail->ResetAttrs();
	$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$persewaan_lapangan_2D_detail_delete->LoadRowValues($persewaan_lapangan_2D_detail_delete->Recordset);

	// Render row
	$persewaan_lapangan_2D_detail_delete->RenderRow();
?>
	<tr<?php echo $persewaan_lapangan_2D_detail->RowAttributes() ?>>
		<td<?php echo $persewaan_lapangan_2D_detail->Kode->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_delete->RowCnt ?>_persewaan_lapangan_2D_detail_Kode" class="control-group persewaan_lapangan_2D_detail_Kode">
<span<?php echo $persewaan_lapangan_2D_detail->Kode->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->Kode->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_delete->RowCnt ?>_persewaan_lapangan_2D_detail_NamaLapangan" class="control-group persewaan_lapangan_2D_detail_NamaLapangan">
<span<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_detail->TglSewa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_delete->RowCnt ?>_persewaan_lapangan_2D_detail_TglSewa" class="control-group persewaan_lapangan_2D_detail_TglSewa">
<span<?php echo $persewaan_lapangan_2D_detail->TglSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->TglSewa->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_detail->JamSewa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_delete->RowCnt ?>_persewaan_lapangan_2D_detail_JamSewa" class="control-group persewaan_lapangan_2D_detail_JamSewa">
<span<?php echo $persewaan_lapangan_2D_detail->JamSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->JamSewa->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_detail->HargaSewa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_delete->RowCnt ?>_persewaan_lapangan_2D_detail_HargaSewa" class="control-group persewaan_lapangan_2D_detail_HargaSewa">
<span<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ListViewValue() ?></span>
</span></td>
		<td<?php echo $persewaan_lapangan_2D_detail->Hitung->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_delete->RowCnt ?>_persewaan_lapangan_2D_detail_Hitung" class="control-group persewaan_lapangan_2D_detail_Hitung">
<span<?php echo $persewaan_lapangan_2D_detail->Hitung->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($persewaan_lapangan_2D_detail->Hitung->ListViewValue()) && $persewaan_lapangan_2D_detail->Hitung->LinkAttributes() <> "") { ?>
<a<?php echo $persewaan_lapangan_2D_detail->Hitung->LinkAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->Hitung->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $persewaan_lapangan_2D_detail->Hitung->ListViewValue() ?>
<?php } ?>
</span>
</span></td>
	</tr>
<?php
	$persewaan_lapangan_2D_detail_delete->Recordset->MoveNext();
}
$persewaan_lapangan_2D_detail_delete->Recordset->Close();
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
fpersewaan_lapangan_2D_detaildelete.Init();
</script>
<?php
$persewaan_lapangan_2D_detail_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$persewaan_lapangan_2D_detail_delete->Page_Terminate();
?>

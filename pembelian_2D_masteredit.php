<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "pembelian_2D_masterinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "pembelian_2D_detailgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$pembelian_2D_master_edit = NULL; // Initialize page object first

class cpembelian_2D_master_edit extends cpembelian_2D_master {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'pembelian - master';

	// Page object name
	var $PageObjName = 'pembelian_2D_master_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
			$this->Page_Terminate("pembelian_2D_masterlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("pembelian_2D_masterlist.php"); // No matching record, return to list
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
		if (!$this->Tgl->FldIsDetailKey) {
			$this->Tgl->setFormValue($objForm->GetValue("x_Tgl"));
			$this->Tgl->CurrentValue = ew_UnFormatDateTime($this->Tgl->CurrentValue, 7);
		}
		if (!$this->No_Faktur->FldIsDetailKey) {
			$this->No_Faktur->setFormValue($objForm->GetValue("x_No_Faktur"));
		}
		if (!$this->Dibayar->FldIsDetailKey) {
			$this->Dibayar->setFormValue($objForm->GetValue("x_Dibayar"));
		}
		if (!$this->Kode_Kasir->FldIsDetailKey) {
			$this->Kode_Kasir->setFormValue($objForm->GetValue("x_Kode_Kasir"));
		}
		if (!$this->Kode_Supplier->FldIsDetailKey) {
			$this->Kode_Supplier->setFormValue($objForm->GetValue("x_Kode_Supplier"));
		}
		if (!$this->ID->FldIsDetailKey)
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->ID->CurrentValue = $this->ID->FormValue;
		$this->Tgl->CurrentValue = $this->Tgl->FormValue;
		$this->Tgl->CurrentValue = ew_UnFormatDateTime($this->Tgl->CurrentValue, 7);
		$this->No_Faktur->CurrentValue = $this->No_Faktur->FormValue;
		$this->Dibayar->CurrentValue = $this->Dibayar->FormValue;
		$this->Kode_Kasir->CurrentValue = $this->Kode_Kasir->FormValue;
		$this->Kode_Supplier->CurrentValue = $this->Kode_Supplier->FormValue;
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
			$res = $this->ShowOptionLink('edit');
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
		// Tgl
		// Faktur
		// No Faktur
		// Diskon
		// Ppn
		// Ongkir
		// Paking
		// Lain - lain
		// Hutang
		// Total Berat
		// Total HP
		// Total HJ
		// Grand Total
		// Dibayar
		// Kembali
		// SisaDibayar
		// Kode Kasir
		// Nama Kasir
		// Kode Supplier
		// Nama Supplier
		// Nama Form
		// No
		// Waktu
		// Stamp
		// Hitung

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

			// Tgl
			$this->Tgl->LinkCustomAttributes = "";
			$this->Tgl->HrefValue = "";
			$this->Tgl->TooltipValue = "";

			// No Faktur
			$this->No_Faktur->LinkCustomAttributes = "";
			$this->No_Faktur->HrefValue = "";
			$this->No_Faktur->TooltipValue = "";

			// Dibayar
			$this->Dibayar->LinkCustomAttributes = "";
			$this->Dibayar->HrefValue = "";
			$this->Dibayar->TooltipValue = "";

			// Kode Kasir
			$this->Kode_Kasir->LinkCustomAttributes = "";
			$this->Kode_Kasir->HrefValue = "";
			$this->Kode_Kasir->TooltipValue = "";

			// Kode Supplier
			$this->Kode_Supplier->LinkCustomAttributes = "";
			$this->Kode_Supplier->HrefValue = "";
			$this->Kode_Supplier->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Tgl
			$this->Tgl->EditCustomAttributes = "";
			$this->Tgl->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tgl->CurrentValue, 7));
			$this->Tgl->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Tgl->FldCaption()));

			// No Faktur
			$this->No_Faktur->EditCustomAttributes = "";
			$this->No_Faktur->EditValue = ew_HtmlEncode($this->No_Faktur->CurrentValue);
			$this->No_Faktur->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->No_Faktur->FldCaption()));

			// Dibayar
			$this->Dibayar->EditCustomAttributes = "";
			$this->Dibayar->EditValue = ew_HtmlEncode($this->Dibayar->CurrentValue);
			$this->Dibayar->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Dibayar->FldCaption()));

			// Kode Kasir
			// Kode Supplier

			$this->Kode_Supplier->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `Nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `daftar suplier`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Kode_Supplier, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Kode_Supplier->EditValue = $arwrk;

			// Edit refer script
			// Tgl

			$this->Tgl->HrefValue = "";

			// No Faktur
			$this->No_Faktur->HrefValue = "";

			// Dibayar
			$this->Dibayar->HrefValue = "";

			// Kode Kasir
			$this->Kode_Kasir->HrefValue = "";

			// Kode Supplier
			$this->Kode_Supplier->HrefValue = "";
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
		if (!$this->No_Faktur->FldIsDetailKey && !is_null($this->No_Faktur->FormValue) && $this->No_Faktur->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->No_Faktur->FldCaption());
		}
		if (!$this->Dibayar->FldIsDetailKey && !is_null($this->Dibayar->FormValue) && $this->Dibayar->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Dibayar->FldCaption());
		}
		if (!ew_CheckInteger($this->Dibayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->Dibayar->FldErrMsg());
		}
		if (!$this->Kode_Supplier->FldIsDetailKey && !is_null($this->Kode_Supplier->FormValue) && $this->Kode_Supplier->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Kode_Supplier->FldCaption());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("pembelian_2D_detail", $DetailTblVar) && $GLOBALS["pembelian_2D_detail"]->DetailEdit) {
			if (!isset($GLOBALS["pembelian_2D_detail_grid"])) $GLOBALS["pembelian_2D_detail_grid"] = new cpembelian_2D_detail_grid(); // get detail page object
			$GLOBALS["pembelian_2D_detail_grid"]->ValidateGridForm();
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

			// Tgl
			$this->Tgl->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tgl->CurrentValue, 7), ew_CurrentDate(), $this->Tgl->ReadOnly);

			// No Faktur
			$this->No_Faktur->SetDbValueDef($rsnew, $this->No_Faktur->CurrentValue, "", $this->No_Faktur->ReadOnly);

			// Dibayar
			$this->Dibayar->SetDbValueDef($rsnew, $this->Dibayar->CurrentValue, 0, $this->Dibayar->ReadOnly);

			// Kode Kasir
			$this->Kode_Kasir->SetDbValueDef($rsnew, CurrentUserName(), "");
			$rsnew['Kode Kasir'] = &$this->Kode_Kasir->DbValue;

			// Kode Supplier
			$this->Kode_Supplier->SetDbValueDef($rsnew, $this->Kode_Supplier->CurrentValue, "", $this->Kode_Supplier->ReadOnly);

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
					if (in_array("pembelian_2D_detail", $DetailTblVar) && $GLOBALS["pembelian_2D_detail"]->DetailEdit) {
						if (!isset($GLOBALS["pembelian_2D_detail_grid"])) $GLOBALS["pembelian_2D_detail_grid"] = new cpembelian_2D_detail_grid(); // Get detail page object
						$EditRow = $GLOBALS["pembelian_2D_detail_grid"]->GridUpdate();
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
			if (in_array("pembelian_2D_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["pembelian_2D_detail_grid"]))
					$GLOBALS["pembelian_2D_detail_grid"] = new cpembelian_2D_detail_grid;
				if ($GLOBALS["pembelian_2D_detail_grid"]->DetailEdit) {
					$GLOBALS["pembelian_2D_detail_grid"]->CurrentMode = "edit";
					$GLOBALS["pembelian_2D_detail_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["pembelian_2D_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["pembelian_2D_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["pembelian_2D_detail_grid"]->IDM->FldIsDetailKey = TRUE;
					$GLOBALS["pembelian_2D_detail_grid"]->IDM->CurrentValue = $this->ID->CurrentValue;
					$GLOBALS["pembelian_2D_detail_grid"]->IDM->setSessionValue($GLOBALS["pembelian_2D_detail_grid"]->IDM->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "pembelian_2D_masterlist.php", $this->TableVar);
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
	   echo "<meta http-equiv='refresh' content='0;URL=AppHitungPembelian.php?id=".$_POST['x_ID']."'>";               
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
if (!isset($pembelian_2D_master_edit)) $pembelian_2D_master_edit = new cpembelian_2D_master_edit();

// Page init
$pembelian_2D_master_edit->Page_Init();

// Page main
$pembelian_2D_master_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pembelian_2D_master_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var pembelian_2D_master_edit = new ew_Page("pembelian_2D_master_edit");
pembelian_2D_master_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = pembelian_2D_master_edit.PageID; // For backward compatibility

// Form object
var fpembelian_2D_masteredit = new ew_Form("fpembelian_2D_masteredit");

// Validate form
fpembelian_2D_masteredit.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_master->Tgl->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Tgl");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pembelian_2D_master->Tgl->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_No_Faktur");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_master->No_Faktur->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Dibayar");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_master->Dibayar->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Dibayar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pembelian_2D_master->Dibayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Kode_Supplier");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_master->Kode_Supplier->FldCaption()) ?>");

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
fpembelian_2D_masteredit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpembelian_2D_masteredit.ValidateRequired = true;
<?php } else { ?>
fpembelian_2D_masteredit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpembelian_2D_masteredit.Lists["x_Kode_Kasir"] = {"LinkField":"x_Username","Ajax":null,"AutoFill":false,"DisplayFields":["x_Username","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpembelian_2D_masteredit.Lists["x_Kode_Supplier"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $pembelian_2D_master_edit->ShowPageHeader(); ?>
<?php
$pembelian_2D_master_edit->ShowMessage();
?>
<form name="fpembelian_2D_masteredit" id="fpembelian_2D_masteredit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="pembelian_2D_master">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_pembelian_2D_masteredit" class="table table-bordered table-striped">
<?php if ($pembelian_2D_master->Tgl->Visible) { // Tgl ?>
	<tr id="r_Tgl"<?php echo $pembelian_2D_master->RowAttributes() ?>>
		<td><span id="elh_pembelian_2D_master_Tgl"><?php echo $pembelian_2D_master->Tgl->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $pembelian_2D_master->Tgl->CellAttributes() ?>><span id="el_pembelian_2D_master_Tgl" class="control-group">
<input type="text" data-field="x_Tgl" name="x_Tgl" id="x_Tgl" placeholder="<?php echo $pembelian_2D_master->Tgl->PlaceHolder ?>" value="<?php echo $pembelian_2D_master->Tgl->EditValue ?>"<?php echo $pembelian_2D_master->Tgl->EditAttributes() ?>>
<?php if (!$pembelian_2D_master->Tgl->ReadOnly && !$pembelian_2D_master->Tgl->Disabled && @$pembelian_2D_master->Tgl->EditAttrs["readonly"] == "" && @$pembelian_2D_master->Tgl->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_Tgl" name="cal_x_Tgl" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_Tgl" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fpembelian_2D_masteredit", "x_Tgl", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $pembelian_2D_master->Tgl->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($pembelian_2D_master->No_Faktur->Visible) { // No Faktur ?>
	<tr id="r_No_Faktur"<?php echo $pembelian_2D_master->RowAttributes() ?>>
		<td><span id="elh_pembelian_2D_master_No_Faktur"><?php echo $pembelian_2D_master->No_Faktur->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $pembelian_2D_master->No_Faktur->CellAttributes() ?>><span id="el_pembelian_2D_master_No_Faktur" class="control-group">
<input type="text" data-field="x_No_Faktur" name="x_No_Faktur" id="x_No_Faktur" size="30" maxlength="255" placeholder="<?php echo $pembelian_2D_master->No_Faktur->PlaceHolder ?>" value="<?php echo $pembelian_2D_master->No_Faktur->EditValue ?>"<?php echo $pembelian_2D_master->No_Faktur->EditAttributes() ?>>
</span><?php echo $pembelian_2D_master->No_Faktur->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($pembelian_2D_master->Dibayar->Visible) { // Dibayar ?>
	<tr id="r_Dibayar"<?php echo $pembelian_2D_master->RowAttributes() ?>>
		<td><span id="elh_pembelian_2D_master_Dibayar"><?php echo $pembelian_2D_master->Dibayar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $pembelian_2D_master->Dibayar->CellAttributes() ?>><span id="el_pembelian_2D_master_Dibayar" class="control-group">
<input type="text" data-field="x_Dibayar" name="x_Dibayar" id="x_Dibayar" size="30" placeholder="<?php echo $pembelian_2D_master->Dibayar->PlaceHolder ?>" value="<?php echo $pembelian_2D_master->Dibayar->EditValue ?>"<?php echo $pembelian_2D_master->Dibayar->EditAttributes() ?>>
</span><?php echo $pembelian_2D_master->Dibayar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($pembelian_2D_master->Kode_Supplier->Visible) { // Kode Supplier ?>
	<tr id="r_Kode_Supplier"<?php echo $pembelian_2D_master->RowAttributes() ?>>
		<td><span id="elh_pembelian_2D_master_Kode_Supplier"><?php echo $pembelian_2D_master->Kode_Supplier->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $pembelian_2D_master->Kode_Supplier->CellAttributes() ?>><span id="el_pembelian_2D_master_Kode_Supplier" class="control-group">
<select data-field="x_Kode_Supplier" id="x_Kode_Supplier" name="x_Kode_Supplier"<?php echo $pembelian_2D_master->Kode_Supplier->EditAttributes() ?>>
<?php
if (is_array($pembelian_2D_master->Kode_Supplier->EditValue)) {
	$arwrk = $pembelian_2D_master->Kode_Supplier->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pembelian_2D_master->Kode_Supplier->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pembelian_2D_master->Kode_Supplier) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
fpembelian_2D_masteredit.Lists["x_Kode_Supplier"].Options = <?php echo (is_array($pembelian_2D_master->Kode_Supplier->EditValue)) ? ew_ArrayToJson($pembelian_2D_master->Kode_Supplier->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $pembelian_2D_master->Kode_Supplier->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<input type="hidden" data-field="x_ID" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($pembelian_2D_master->ID->CurrentValue) ?>">
<?php
	if (in_array("pembelian_2D_detail", explode(",", $pembelian_2D_master->getCurrentDetailTable())) && $pembelian_2D_detail->DetailEdit) {
?>
<?php include_once "pembelian_2D_detailgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fpembelian_2D_masteredit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$pembelian_2D_master_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pembelian_2D_master_edit->Page_Terminate();
?>

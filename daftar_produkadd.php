<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "daftar_produkinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$daftar_produk_add = NULL; // Initialize page object first

class cdaftar_produk_add extends cdaftar_produk {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'daftar produk';

	// Page object name
	var $PageObjName = 'daftar_produk_add';

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

		// Table object (daftar_produk)
		if (!isset($GLOBALS["daftar_produk"])) {
			$GLOBALS["daftar_produk"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["daftar_produk"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar produk', TRUE);

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
			$this->Page_Terminate("daftar_produklist.php");
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
					$this->Page_Terminate("daftar_produklist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "daftar_produkview.php")
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
		$this->Nama_Barang->CurrentValue = NULL;
		$this->Nama_Barang->OldValue = $this->Nama_Barang->CurrentValue;
		$this->Satuan->CurrentValue = NULL;
		$this->Satuan->OldValue = $this->Satuan->CurrentValue;
		$this->Harga_Pokok->CurrentValue = NULL;
		$this->Harga_Pokok->OldValue = $this->Harga_Pokok->CurrentValue;
		$this->Harga_Jual->CurrentValue = NULL;
		$this->Harga_Jual->OldValue = $this->Harga_Jual->CurrentValue;
		$this->Jumlah->CurrentValue = NULL;
		$this->Jumlah->OldValue = $this->Jumlah->CurrentValue;
		$this->Supplier->CurrentValue = NULL;
		$this->Supplier->OldValue = $this->Supplier->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Kode->FldIsDetailKey) {
			$this->Kode->setFormValue($objForm->GetValue("x_Kode"));
		}
		if (!$this->Nama_Barang->FldIsDetailKey) {
			$this->Nama_Barang->setFormValue($objForm->GetValue("x_Nama_Barang"));
		}
		if (!$this->Satuan->FldIsDetailKey) {
			$this->Satuan->setFormValue($objForm->GetValue("x_Satuan"));
		}
		if (!$this->Harga_Pokok->FldIsDetailKey) {
			$this->Harga_Pokok->setFormValue($objForm->GetValue("x_Harga_Pokok"));
		}
		if (!$this->Harga_Jual->FldIsDetailKey) {
			$this->Harga_Jual->setFormValue($objForm->GetValue("x_Harga_Jual"));
		}
		if (!$this->Jumlah->FldIsDetailKey) {
			$this->Jumlah->setFormValue($objForm->GetValue("x_Jumlah"));
		}
		if (!$this->Supplier->FldIsDetailKey) {
			$this->Supplier->setFormValue($objForm->GetValue("x_Supplier"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->Nama_Barang->CurrentValue = $this->Nama_Barang->FormValue;
		$this->Satuan->CurrentValue = $this->Satuan->FormValue;
		$this->Harga_Pokok->CurrentValue = $this->Harga_Pokok->FormValue;
		$this->Harga_Jual->CurrentValue = $this->Harga_Jual->FormValue;
		$this->Jumlah->CurrentValue = $this->Jumlah->FormValue;
		$this->Supplier->CurrentValue = $this->Supplier->FormValue;
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
		$this->TglStok->setDbValue($rs->fields('TglStok'));
		$this->Kode->setDbValue($rs->fields('Kode'));
		$this->Nama_Barang->setDbValue($rs->fields('Nama Barang'));
		$this->Isi->setDbValue($rs->fields('Isi'));
		$this->Satuan->setDbValue($rs->fields('Satuan'));
		$this->Berat->setDbValue($rs->fields('Berat'));
		$this->Harga_Pokok->setDbValue($rs->fields('Harga Pokok'));
		$this->Harga_Jual->setDbValue($rs->fields('Harga Jual'));
		$this->Jumlah->setDbValue($rs->fields('Jumlah'));
		$this->Jumlah_Total->setDbValue($rs->fields('Jumlah Total'));
		$this->Supplier->setDbValue($rs->fields('Supplier'));
		$this->Departemen->setDbValue($rs->fields('Departemen'));
		$this->Foto->Upload->DbValue = $rs->fields('Foto');
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->TglStok->DbValue = $row['TglStok'];
		$this->Kode->DbValue = $row['Kode'];
		$this->Nama_Barang->DbValue = $row['Nama Barang'];
		$this->Isi->DbValue = $row['Isi'];
		$this->Satuan->DbValue = $row['Satuan'];
		$this->Berat->DbValue = $row['Berat'];
		$this->Harga_Pokok->DbValue = $row['Harga Pokok'];
		$this->Harga_Jual->DbValue = $row['Harga Jual'];
		$this->Jumlah->DbValue = $row['Jumlah'];
		$this->Jumlah_Total->DbValue = $row['Jumlah Total'];
		$this->Supplier->DbValue = $row['Supplier'];
		$this->Departemen->DbValue = $row['Departemen'];
		$this->Foto->Upload->DbValue = $row['Foto'];
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
		// TglStok
		// Kode
		// Nama Barang
		// Isi
		// Satuan
		// Berat
		// Harga Pokok
		// Harga Jual
		// Jumlah
		// Jumlah Total
		// Supplier
		// Departemen
		// Foto
		// Waktu
		// Stamp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			$this->Kode->ViewValue = $this->Kode->CurrentValue;
			$this->Kode->ViewCustomAttributes = "";

			// Nama Barang
			$this->Nama_Barang->ViewValue = $this->Nama_Barang->CurrentValue;
			$this->Nama_Barang->ViewCustomAttributes = "";

			// Satuan
			if (strval($this->Satuan->CurrentValue) <> "") {
				$sFilterWrk = "`Satuan`" . ew_SearchString("=", $this->Satuan->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Satuan`, `Satuan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar satuan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Satuan, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Satuan` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Satuan->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Satuan->ViewValue = $this->Satuan->CurrentValue;
				}
			} else {
				$this->Satuan->ViewValue = NULL;
			}
			$this->Satuan->ViewCustomAttributes = "";

			// Harga Pokok
			$this->Harga_Pokok->ViewValue = $this->Harga_Pokok->CurrentValue;
			$this->Harga_Pokok->ViewValue = ew_FormatNumber($this->Harga_Pokok->ViewValue, 0, -2, -2, -2);
			$this->Harga_Pokok->CellCssStyle .= "text-align: right;";
			$this->Harga_Pokok->ViewCustomAttributes = "";

			// Harga Jual
			$this->Harga_Jual->ViewValue = $this->Harga_Jual->CurrentValue;
			$this->Harga_Jual->ViewValue = ew_FormatNumber($this->Harga_Jual->ViewValue, 0, -2, -2, -2);
			$this->Harga_Jual->CellCssStyle .= "text-align: right;";
			$this->Harga_Jual->ViewCustomAttributes = "";

			// Jumlah
			$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
			$this->Jumlah->CellCssStyle .= "text-align: center;";
			$this->Jumlah->ViewCustomAttributes = "";

			// Supplier
			if (strval($this->Supplier->CurrentValue) <> "") {
				$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Supplier->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `Nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar suplier`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Supplier, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Supplier->ViewValue = $rswrk->fields('DispFld');
					$this->Supplier->ViewValue .= ew_ValueSeparator(1,$this->Supplier) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Supplier->ViewValue = $this->Supplier->CurrentValue;
				}
			} else {
				$this->Supplier->ViewValue = NULL;
			}
			$this->Supplier->ViewCustomAttributes = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// Nama Barang
			$this->Nama_Barang->LinkCustomAttributes = "";
			$this->Nama_Barang->HrefValue = "";
			$this->Nama_Barang->TooltipValue = "";

			// Satuan
			$this->Satuan->LinkCustomAttributes = "";
			$this->Satuan->HrefValue = "";
			$this->Satuan->TooltipValue = "";

			// Harga Pokok
			$this->Harga_Pokok->LinkCustomAttributes = "";
			$this->Harga_Pokok->HrefValue = "";
			$this->Harga_Pokok->TooltipValue = "";

			// Harga Jual
			$this->Harga_Jual->LinkCustomAttributes = "";
			$this->Harga_Jual->HrefValue = "";
			$this->Harga_Jual->TooltipValue = "";

			// Jumlah
			$this->Jumlah->LinkCustomAttributes = "";
			$this->Jumlah->HrefValue = "";
			$this->Jumlah->TooltipValue = "";

			// Supplier
			$this->Supplier->LinkCustomAttributes = "";
			$this->Supplier->HrefValue = "";
			$this->Supplier->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->CurrentValue);
			$this->Kode->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kode->FldCaption()));

			// Nama Barang
			$this->Nama_Barang->EditCustomAttributes = "";
			$this->Nama_Barang->EditValue = ew_HtmlEncode($this->Nama_Barang->CurrentValue);
			$this->Nama_Barang->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Nama_Barang->FldCaption()));

			// Satuan
			$this->Satuan->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Satuan`, `Satuan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `daftar satuan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Satuan, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Satuan` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Satuan->EditValue = $arwrk;

			// Harga Pokok
			$this->Harga_Pokok->EditCustomAttributes = "";
			$this->Harga_Pokok->EditValue = ew_HtmlEncode($this->Harga_Pokok->CurrentValue);
			$this->Harga_Pokok->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Harga_Pokok->FldCaption()));

			// Harga Jual
			$this->Harga_Jual->EditCustomAttributes = "";
			$this->Harga_Jual->EditValue = ew_HtmlEncode($this->Harga_Jual->CurrentValue);
			$this->Harga_Jual->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Harga_Jual->FldCaption()));

			// Jumlah
			$this->Jumlah->EditCustomAttributes = "";
			$this->Jumlah->EditValue = ew_HtmlEncode($this->Jumlah->CurrentValue);
			$this->Jumlah->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Jumlah->FldCaption()));

			// Supplier
			$this->Supplier->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `Nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `daftar suplier`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Supplier, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Supplier->EditValue = $arwrk;

			// Edit refer script
			// Kode

			$this->Kode->HrefValue = "";

			// Nama Barang
			$this->Nama_Barang->HrefValue = "";

			// Satuan
			$this->Satuan->HrefValue = "";

			// Harga Pokok
			$this->Harga_Pokok->HrefValue = "";

			// Harga Jual
			$this->Harga_Jual->HrefValue = "";

			// Jumlah
			$this->Jumlah->HrefValue = "";

			// Supplier
			$this->Supplier->HrefValue = "";
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
		if (!$this->Nama_Barang->FldIsDetailKey && !is_null($this->Nama_Barang->FormValue) && $this->Nama_Barang->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Nama_Barang->FldCaption());
		}
		if (!$this->Satuan->FldIsDetailKey && !is_null($this->Satuan->FormValue) && $this->Satuan->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Satuan->FldCaption());
		}
		if (!$this->Harga_Pokok->FldIsDetailKey && !is_null($this->Harga_Pokok->FormValue) && $this->Harga_Pokok->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Harga_Pokok->FldCaption());
		}
		if (!ew_CheckInteger($this->Harga_Pokok->FormValue)) {
			ew_AddMessage($gsFormError, $this->Harga_Pokok->FldErrMsg());
		}
		if (!$this->Harga_Jual->FldIsDetailKey && !is_null($this->Harga_Jual->FormValue) && $this->Harga_Jual->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Harga_Jual->FldCaption());
		}
		if (!ew_CheckInteger($this->Harga_Jual->FormValue)) {
			ew_AddMessage($gsFormError, $this->Harga_Jual->FldErrMsg());
		}
		if (!$this->Jumlah->FldIsDetailKey && !is_null($this->Jumlah->FormValue) && $this->Jumlah->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Jumlah->FldCaption());
		}
		if (!ew_CheckInteger($this->Jumlah->FormValue)) {
			ew_AddMessage($gsFormError, $this->Jumlah->FldErrMsg());
		}
		if (!$this->Supplier->FldIsDetailKey && !is_null($this->Supplier->FormValue) && $this->Supplier->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Supplier->FldCaption());
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

		// Nama Barang
		$this->Nama_Barang->SetDbValueDef($rsnew, $this->Nama_Barang->CurrentValue, "", FALSE);

		// Satuan
		$this->Satuan->SetDbValueDef($rsnew, $this->Satuan->CurrentValue, "", FALSE);

		// Harga Pokok
		$this->Harga_Pokok->SetDbValueDef($rsnew, $this->Harga_Pokok->CurrentValue, 0, FALSE);

		// Harga Jual
		$this->Harga_Jual->SetDbValueDef($rsnew, $this->Harga_Jual->CurrentValue, 0, FALSE);

		// Jumlah
		$this->Jumlah->SetDbValueDef($rsnew, $this->Jumlah->CurrentValue, 0, FALSE);

		// Supplier
		$this->Supplier->SetDbValueDef($rsnew, $this->Supplier->CurrentValue, "", FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "daftar_produklist.php", $this->TableVar);
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
if (!isset($daftar_produk_add)) $daftar_produk_add = new cdaftar_produk_add();

// Page init
$daftar_produk_add->Page_Init();

// Page main
$daftar_produk_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$daftar_produk_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var daftar_produk_add = new ew_Page("daftar_produk_add");
daftar_produk_add.PageID = "add"; // Page ID
var EW_PAGE_ID = daftar_produk_add.PageID; // For backward compatibility

// Form object
var fdaftar_produkadd = new ew_Form("fdaftar_produkadd");

// Validate form
fdaftar_produkadd.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_produk->Kode->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Nama_Barang");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_produk->Nama_Barang->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Satuan");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_produk->Satuan->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Harga_Pokok");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_produk->Harga_Pokok->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Harga_Pokok");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_produk->Harga_Pokok->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Harga_Jual");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_produk->Harga_Jual->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Harga_Jual");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_produk->Harga_Jual->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_produk->Jumlah->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_produk->Jumlah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Supplier");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_produk->Supplier->FldCaption()) ?>");

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
fdaftar_produkadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdaftar_produkadd.ValidateRequired = true;
<?php } else { ?>
fdaftar_produkadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdaftar_produkadd.Lists["x_Satuan"] = {"LinkField":"x_Satuan","Ajax":null,"AutoFill":false,"DisplayFields":["x_Satuan","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdaftar_produkadd.Lists["x_Supplier"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $daftar_produk_add->ShowPageHeader(); ?>
<?php
$daftar_produk_add->ShowMessage();
?>
<form name="fdaftar_produkadd" id="fdaftar_produkadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="daftar_produk">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_daftar_produkadd" class="table table-bordered table-striped">
<?php if ($daftar_produk->Kode->Visible) { // Kode ?>
	<tr id="r_Kode"<?php echo $daftar_produk->RowAttributes() ?>>
		<td><span id="elh_daftar_produk_Kode"><?php echo $daftar_produk->Kode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_produk->Kode->CellAttributes() ?>><span id="el_daftar_produk_Kode" class="control-group">
<input type="text" data-field="x_Kode" name="x_Kode" id="x_Kode" size="30" maxlength="255" placeholder="<?php echo $daftar_produk->Kode->PlaceHolder ?>" value="<?php echo $daftar_produk->Kode->EditValue ?>"<?php echo $daftar_produk->Kode->EditAttributes() ?>>
</span><?php echo $daftar_produk->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_produk->Nama_Barang->Visible) { // Nama Barang ?>
	<tr id="r_Nama_Barang"<?php echo $daftar_produk->RowAttributes() ?>>
		<td><span id="elh_daftar_produk_Nama_Barang"><?php echo $daftar_produk->Nama_Barang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_produk->Nama_Barang->CellAttributes() ?>><span id="el_daftar_produk_Nama_Barang" class="control-group">
<input type="text" data-field="x_Nama_Barang" name="x_Nama_Barang" id="x_Nama_Barang" size="30" maxlength="255" placeholder="<?php echo $daftar_produk->Nama_Barang->PlaceHolder ?>" value="<?php echo $daftar_produk->Nama_Barang->EditValue ?>"<?php echo $daftar_produk->Nama_Barang->EditAttributes() ?>>
</span><?php echo $daftar_produk->Nama_Barang->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_produk->Satuan->Visible) { // Satuan ?>
	<tr id="r_Satuan"<?php echo $daftar_produk->RowAttributes() ?>>
		<td><span id="elh_daftar_produk_Satuan"><?php echo $daftar_produk->Satuan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_produk->Satuan->CellAttributes() ?>><span id="el_daftar_produk_Satuan" class="control-group">
<select data-field="x_Satuan" id="x_Satuan" name="x_Satuan"<?php echo $daftar_produk->Satuan->EditAttributes() ?>>
<?php
if (is_array($daftar_produk->Satuan->EditValue)) {
	$arwrk = $daftar_produk->Satuan->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($daftar_produk->Satuan->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<script type="text/javascript">
fdaftar_produkadd.Lists["x_Satuan"].Options = <?php echo (is_array($daftar_produk->Satuan->EditValue)) ? ew_ArrayToJson($daftar_produk->Satuan->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $daftar_produk->Satuan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_produk->Harga_Pokok->Visible) { // Harga Pokok ?>
	<tr id="r_Harga_Pokok"<?php echo $daftar_produk->RowAttributes() ?>>
		<td><span id="elh_daftar_produk_Harga_Pokok"><?php echo $daftar_produk->Harga_Pokok->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_produk->Harga_Pokok->CellAttributes() ?>><span id="el_daftar_produk_Harga_Pokok" class="control-group">
<input type="text" data-field="x_Harga_Pokok" name="x_Harga_Pokok" id="x_Harga_Pokok" size="30" placeholder="<?php echo $daftar_produk->Harga_Pokok->PlaceHolder ?>" value="<?php echo $daftar_produk->Harga_Pokok->EditValue ?>"<?php echo $daftar_produk->Harga_Pokok->EditAttributes() ?>>
</span><?php echo $daftar_produk->Harga_Pokok->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_produk->Harga_Jual->Visible) { // Harga Jual ?>
	<tr id="r_Harga_Jual"<?php echo $daftar_produk->RowAttributes() ?>>
		<td><span id="elh_daftar_produk_Harga_Jual"><?php echo $daftar_produk->Harga_Jual->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_produk->Harga_Jual->CellAttributes() ?>><span id="el_daftar_produk_Harga_Jual" class="control-group">
<input type="text" data-field="x_Harga_Jual" name="x_Harga_Jual" id="x_Harga_Jual" size="30" placeholder="<?php echo $daftar_produk->Harga_Jual->PlaceHolder ?>" value="<?php echo $daftar_produk->Harga_Jual->EditValue ?>"<?php echo $daftar_produk->Harga_Jual->EditAttributes() ?>>
</span><?php echo $daftar_produk->Harga_Jual->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_produk->Jumlah->Visible) { // Jumlah ?>
	<tr id="r_Jumlah"<?php echo $daftar_produk->RowAttributes() ?>>
		<td><span id="elh_daftar_produk_Jumlah"><?php echo $daftar_produk->Jumlah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_produk->Jumlah->CellAttributes() ?>><span id="el_daftar_produk_Jumlah" class="control-group">
<input type="text" data-field="x_Jumlah" name="x_Jumlah" id="x_Jumlah" size="30" placeholder="<?php echo $daftar_produk->Jumlah->PlaceHolder ?>" value="<?php echo $daftar_produk->Jumlah->EditValue ?>"<?php echo $daftar_produk->Jumlah->EditAttributes() ?>>
</span><?php echo $daftar_produk->Jumlah->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($daftar_produk->Supplier->Visible) { // Supplier ?>
	<tr id="r_Supplier"<?php echo $daftar_produk->RowAttributes() ?>>
		<td><span id="elh_daftar_produk_Supplier"><?php echo $daftar_produk->Supplier->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $daftar_produk->Supplier->CellAttributes() ?>><span id="el_daftar_produk_Supplier" class="control-group">
<select data-field="x_Supplier" id="x_Supplier" name="x_Supplier"<?php echo $daftar_produk->Supplier->EditAttributes() ?>>
<?php
if (is_array($daftar_produk->Supplier->EditValue)) {
	$arwrk = $daftar_produk->Supplier->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($daftar_produk->Supplier->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$daftar_produk->Supplier) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
fdaftar_produkadd.Lists["x_Supplier"].Options = <?php echo (is_array($daftar_produk->Supplier->EditValue)) ? ew_ArrayToJson($daftar_produk->Supplier->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $daftar_produk->Supplier->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fdaftar_produkadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$daftar_produk_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$daftar_produk_add->Page_Terminate();
?>

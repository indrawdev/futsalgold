<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "Sisa_Bayarinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$Sisa_Bayar_list = NULL; // Initialize page object first

class cSisa_Bayar_list extends cSisa_Bayar {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'Sisa Bayar';

	// Page object name
	var $PageObjName = 'Sisa_Bayar_list';

	// Grid form hidden field names
	var $FormName = 'fSisa_Bayarlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (Sisa_Bayar)
		if (!isset($GLOBALS["Sisa_Bayar"])) {
			$GLOBALS["Sisa_Bayar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["Sisa_Bayar"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "Sisa_Bayaradd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "Sisa_Bayardelete.php";
		$this->MultiUpdateUrl = "Sisa_Bayarupdate.php";

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'Sisa Bayar', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "span";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "span";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "span";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("login.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->Kode_Kasir->Visible = !$this->IsAddOrEdit();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Setup other options
		$this->SetupOtherOptions();

		// Update url if printer friendly for Pdf
		if ($this->PrinterFriendlyForPdf)
			$this->ExportOptions->Items["pdf"]->Body = str_replace($this->ExportPdfUrl, $this->ExportPrintUrl . "&pdf=1", $this->ExportOptions->Items["pdf"]->Body);
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();
		if ($this->Export == "print" && @$_GET["pdf"] == "1") { // Printer friendly version and with pdf=1 in URL parameters
			$pdf = new cExportPdf($GLOBALS["Table"]);
			$pdf->Text = ob_get_contents(); // Set the content as the HTML of current page (printer friendly version)
			ob_end_clean();
			$pdf->Export();
		}

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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process custom action first
			$this->ProcessCustomAction();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide export options
			if ($this->Export <> "" || $this->CurrentAction <> "")
				$this->ExportOptions->HideAllOptions();

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset
			if ($this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 0) {
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->No_Faktur, FALSE); // No Faktur
		$this->BuildSearchSql($sWhere, $this->Tgl, FALSE); // Tgl
		$this->BuildSearchSql($sWhere, $this->Bayar, FALSE); // Bayar
		$this->BuildSearchSql($sWhere, $this->Sisa, FALSE); // Sisa
		$this->BuildSearchSql($sWhere, $this->Sub_Total, FALSE); // Sub Total
		$this->BuildSearchSql($sWhere, $this->Diskon, FALSE); // Diskon
		$this->BuildSearchSql($sWhere, $this->Potongan, FALSE); // Potongan
		$this->BuildSearchSql($sWhere, $this->Grand_Total, FALSE); // Grand Total
		$this->BuildSearchSql($sWhere, $this->Kode_Kasir, FALSE); // Kode Kasir
		$this->BuildSearchSql($sWhere, $this->Kode, FALSE); // Kode

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->No_Faktur->AdvancedSearch->Save(); // No Faktur
			$this->Tgl->AdvancedSearch->Save(); // Tgl
			$this->Bayar->AdvancedSearch->Save(); // Bayar
			$this->Sisa->AdvancedSearch->Save(); // Sisa
			$this->Sub_Total->AdvancedSearch->Save(); // Sub Total
			$this->Diskon->AdvancedSearch->Save(); // Diskon
			$this->Potongan->AdvancedSearch->Save(); // Potongan
			$this->Grand_Total->AdvancedSearch->Save(); // Grand Total
			$this->Kode_Kasir->AdvancedSearch->Save(); // Kode Kasir
			$this->Kode->AdvancedSearch->Save(); // Kode
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->No_Faktur, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Kode_Kasir, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Kode, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		if ($Keyword == EW_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NULL";
		} elseif ($Keyword == EW_NOT_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NOT NULL";
		} else {
			$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = $this->BasicSearch->Keyword;
		$sSearchType = $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->No_Faktur->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tgl->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Bayar->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sisa->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Sub_Total->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Diskon->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Potongan->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Grand_Total->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Kode_Kasir->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Kode->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->No_Faktur->AdvancedSearch->UnsetSession();
		$this->Tgl->AdvancedSearch->UnsetSession();
		$this->Bayar->AdvancedSearch->UnsetSession();
		$this->Sisa->AdvancedSearch->UnsetSession();
		$this->Sub_Total->AdvancedSearch->UnsetSession();
		$this->Diskon->AdvancedSearch->UnsetSession();
		$this->Potongan->AdvancedSearch->UnsetSession();
		$this->Grand_Total->AdvancedSearch->UnsetSession();
		$this->Kode_Kasir->AdvancedSearch->UnsetSession();
		$this->Kode->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->No_Faktur->AdvancedSearch->Load();
		$this->Tgl->AdvancedSearch->Load();
		$this->Bayar->AdvancedSearch->Load();
		$this->Sisa->AdvancedSearch->Load();
		$this->Sub_Total->AdvancedSearch->Load();
		$this->Diskon->AdvancedSearch->Load();
		$this->Potongan->AdvancedSearch->Load();
		$this->Grand_Total->AdvancedSearch->Load();
		$this->Kode_Kasir->AdvancedSearch->Load();
		$this->Kode->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->No_Faktur); // No Faktur
			$this->UpdateSort($this->Tgl); // Tgl
			$this->UpdateSort($this->Bayar); // Bayar
			$this->UpdateSort($this->Sisa); // Sisa
			$this->UpdateSort($this->Sub_Total); // Sub Total
			$this->UpdateSort($this->Diskon); // Diskon
			$this->UpdateSort($this->Potongan); // Potongan
			$this->UpdateSort($this->Grand_Total); // Grand Total
			$this->UpdateSort($this->Kode_Kasir); // Kode Kasir
			$this->UpdateSort($this->Kode); // Kode
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->SqlOrderBy() <> "") {
				$sOrderBy = $this->SqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->setSessionOrderByList($sOrderBy);
				$this->No_Faktur->setSort("");
				$this->Tgl->setSort("");
				$this->Bayar->setSort("");
				$this->Sisa->setSort("");
				$this->Sub_Total->setSort("");
				$this->Diskon->setSort("");
				$this->Potongan->setSort("");
				$this->Grand_Total->setSort("");
				$this->Kode_Kasir->setSort("");
				$this->Kode->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"></label>";
		if (count($this->CustomActions) > 0) $item->Visible = TRUE;
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		$this->ListOptions->ButtonClass = "btn-small"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-small"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fSisa_Bayarlist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
			}

			// Hide grid edit, multi-delete and multi-update
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$item = &$option->GetItem("multidelete");
				if ($item) $item->Visible = FALSE;
				$item = &$option->GetItem("multiupdate");
				if ($item) $item->Visible = FALSE;
			}
	}

	// Process custom action
	function ProcessCustomAction() {
		global $conn, $Language, $Security;
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$rsuser = ($rs) ? $rs->GetRows() : array();
			if ($rs)
				$rs->Close();

			// Call row custom action event
			if (count($rsuser) > 0) {
				$conn->BeginTrans();
				foreach ($rsuser as $row) {
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCancelled")));
					}
				}
			}
		}
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// No Faktur

		$this->No_Faktur->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_No_Faktur"]);
		if ($this->No_Faktur->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->No_Faktur->AdvancedSearch->SearchOperator = @$_GET["z_No_Faktur"];

		// Tgl
		$this->Tgl->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tgl"]);
		if ($this->Tgl->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tgl->AdvancedSearch->SearchOperator = @$_GET["z_Tgl"];
		$this->Tgl->AdvancedSearch->SearchCondition = @$_GET["v_Tgl"];
		$this->Tgl->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_Tgl"]);
		if ($this->Tgl->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->Tgl->AdvancedSearch->SearchOperator2 = @$_GET["w_Tgl"];

		// Bayar
		$this->Bayar->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Bayar"]);
		if ($this->Bayar->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Bayar->AdvancedSearch->SearchOperator = @$_GET["z_Bayar"];

		// Sisa
		$this->Sisa->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sisa"]);
		if ($this->Sisa->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sisa->AdvancedSearch->SearchOperator = @$_GET["z_Sisa"];

		// Sub Total
		$this->Sub_Total->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Sub_Total"]);
		if ($this->Sub_Total->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Sub_Total->AdvancedSearch->SearchOperator = @$_GET["z_Sub_Total"];

		// Diskon
		$this->Diskon->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Diskon"]);
		if ($this->Diskon->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Diskon->AdvancedSearch->SearchOperator = @$_GET["z_Diskon"];

		// Potongan
		$this->Potongan->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Potongan"]);
		if ($this->Potongan->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Potongan->AdvancedSearch->SearchOperator = @$_GET["z_Potongan"];

		// Grand Total
		$this->Grand_Total->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Grand_Total"]);
		if ($this->Grand_Total->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Grand_Total->AdvancedSearch->SearchOperator = @$_GET["z_Grand_Total"];

		// Kode Kasir
		$this->Kode_Kasir->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Kode_Kasir"]);
		if ($this->Kode_Kasir->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Kode_Kasir->AdvancedSearch->SearchOperator = @$_GET["z_Kode_Kasir"];

		// Kode
		$this->Kode->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Kode"]);
		if ($this->Kode->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Kode->AdvancedSearch->SearchOperator = @$_GET["z_Kode"];
	}

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
		$this->No_Faktur->setDbValue($rs->fields('No Faktur'));
		$this->Tgl->setDbValue($rs->fields('Tgl'));
		$this->Bayar->setDbValue($rs->fields('Bayar'));
		$this->Sisa->setDbValue($rs->fields('Sisa'));
		$this->Sub_Total->setDbValue($rs->fields('Sub Total'));
		$this->Diskon->setDbValue($rs->fields('Diskon'));
		$this->Potongan->setDbValue($rs->fields('Potongan'));
		$this->Grand_Total->setDbValue($rs->fields('Grand Total'));
		$this->Kode_Kasir->setDbValue($rs->fields('Kode Kasir'));
		$this->Kode->setDbValue($rs->fields('Kode'));
		if (array_key_exists('EV__Kode', $rs->fields)) {
			$this->Kode->VirtualValue = $rs->fields('EV__Kode'); // Set up virtual field value
		} else {
			$this->Kode->VirtualValue = ""; // Clear value
		}
		$this->ID->setDbValue($rs->fields('ID'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->No_Faktur->DbValue = $row['No Faktur'];
		$this->Tgl->DbValue = $row['Tgl'];
		$this->Bayar->DbValue = $row['Bayar'];
		$this->Sisa->DbValue = $row['Sisa'];
		$this->Sub_Total->DbValue = $row['Sub Total'];
		$this->Diskon->DbValue = $row['Diskon'];
		$this->Potongan->DbValue = $row['Potongan'];
		$this->Grand_Total->DbValue = $row['Grand Total'];
		$this->Kode_Kasir->DbValue = $row['Kode Kasir'];
		$this->Kode->DbValue = $row['Kode'];
		$this->ID->DbValue = $row['ID'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;

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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// No Faktur
		// Tgl
		// Bayar
		// Sisa
		// Sub Total
		// Diskon
		// Potongan
		// Grand Total
		// Kode Kasir
		// Kode
		// ID

		$this->ID->CellCssStyle = "white-space: nowrap;";

		// Accumulate aggregate value
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT && $this->RowType <> EW_ROWTYPE_AGGREGATE) {
			if (is_numeric($this->Bayar->CurrentValue))
				$this->Bayar->Total += $this->Bayar->CurrentValue; // Accumulate total
			if (is_numeric($this->Sisa->CurrentValue))
				$this->Sisa->Total += $this->Sisa->CurrentValue; // Accumulate total
			if (is_numeric($this->Sub_Total->CurrentValue))
				$this->Sub_Total->Total += $this->Sub_Total->CurrentValue; // Accumulate total
			if (is_numeric($this->Grand_Total->CurrentValue))
				$this->Grand_Total->Total += $this->Grand_Total->CurrentValue; // Accumulate total
		}
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

			// No Faktur
			$this->No_Faktur->LinkCustomAttributes = "";
			if (!ew_Empty($this->ID->CurrentValue)) {
				$this->No_Faktur->HrefValue = "persewaan_lapangan_2D_detaillist.php?showmaster=persewaan_lapangan_2D_master&ID=" . ((!empty($this->ID->ViewValue)) ? $this->ID->ViewValue : $this->ID->CurrentValue); // Add prefix/suffix
				$this->No_Faktur->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->No_Faktur->HrefValue = ew_ConvertFullUrl($this->No_Faktur->HrefValue);
			} else {
				$this->No_Faktur->HrefValue = "";
			}
			$this->No_Faktur->TooltipValue = "";

			// Tgl
			$this->Tgl->LinkCustomAttributes = "";
			$this->Tgl->HrefValue = "";
			$this->Tgl->TooltipValue = "";

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

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// No Faktur
			$this->No_Faktur->EditCustomAttributes = "";
			$this->No_Faktur->EditValue = ew_HtmlEncode($this->No_Faktur->AdvancedSearch->SearchValue);
			$this->No_Faktur->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->No_Faktur->FldCaption()));

			// Tgl
			$this->Tgl->EditCustomAttributes = "";
			$this->Tgl->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Tgl->AdvancedSearch->SearchValue, 7), 7));
			$this->Tgl->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Tgl->FldCaption()));
			$this->Tgl->EditCustomAttributes = "";
			$this->Tgl->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Tgl->AdvancedSearch->SearchValue2, 7), 7));
			$this->Tgl->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Tgl->FldCaption()));

			// Bayar
			$this->Bayar->EditCustomAttributes = "";
			$this->Bayar->EditValue = ew_HtmlEncode($this->Bayar->AdvancedSearch->SearchValue);
			$this->Bayar->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Bayar->FldCaption()));

			// Sisa
			$this->Sisa->EditCustomAttributes = "";
			$this->Sisa->EditValue = ew_HtmlEncode($this->Sisa->AdvancedSearch->SearchValue);
			$this->Sisa->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Sisa->FldCaption()));

			// Sub Total
			$this->Sub_Total->EditCustomAttributes = "";
			$this->Sub_Total->EditValue = ew_HtmlEncode($this->Sub_Total->AdvancedSearch->SearchValue);
			$this->Sub_Total->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Sub_Total->FldCaption()));

			// Diskon
			$this->Diskon->EditCustomAttributes = "";
			$this->Diskon->EditValue = ew_HtmlEncode($this->Diskon->AdvancedSearch->SearchValue);
			$this->Diskon->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Diskon->FldCaption()));

			// Potongan
			$this->Potongan->EditCustomAttributes = "";
			$this->Potongan->EditValue = ew_HtmlEncode($this->Potongan->AdvancedSearch->SearchValue);
			$this->Potongan->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Potongan->FldCaption()));

			// Grand Total
			$this->Grand_Total->EditCustomAttributes = "";
			$this->Grand_Total->EditValue = ew_HtmlEncode($this->Grand_Total->AdvancedSearch->SearchValue);
			$this->Grand_Total->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Grand_Total->FldCaption()));

			// Kode Kasir
			$this->Kode_Kasir->EditCustomAttributes = "";

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->AdvancedSearch->SearchValue);
			$this->Kode->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kode->FldCaption()));
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
			$this->Bayar->Total = 0; // Initialize total
			$this->Sisa->Total = 0; // Initialize total
			$this->Sub_Total->Total = 0; // Initialize total
			$this->Grand_Total->Total = 0; // Initialize total
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATE) { // Aggregate row
			$this->Bayar->CurrentValue = $this->Bayar->Total;
			$this->Bayar->ViewValue = $this->Bayar->CurrentValue;
			$this->Bayar->ViewValue = ew_FormatNumber($this->Bayar->ViewValue, 0, -2, -2, -2);
			$this->Bayar->CellCssStyle .= "text-align: right;";
			$this->Bayar->ViewCustomAttributes = "";
			$this->Bayar->HrefValue = ""; // Clear href value
			$this->Sisa->CurrentValue = $this->Sisa->Total;
			$this->Sisa->ViewValue = $this->Sisa->CurrentValue;
			$this->Sisa->ViewValue = ew_FormatNumber($this->Sisa->ViewValue, 0, -2, -2, -2);
			$this->Sisa->CellCssStyle .= "text-align: right;";
			$this->Sisa->ViewCustomAttributes = "";
			$this->Sisa->HrefValue = ""; // Clear href value
			$this->Sub_Total->CurrentValue = $this->Sub_Total->Total;
			$this->Sub_Total->ViewValue = $this->Sub_Total->CurrentValue;
			$this->Sub_Total->ViewValue = ew_FormatNumber($this->Sub_Total->ViewValue, 0, -2, -2, -2);
			$this->Sub_Total->CellCssStyle .= "text-align: right;";
			$this->Sub_Total->ViewCustomAttributes = "";
			$this->Sub_Total->HrefValue = ""; // Clear href value
			$this->Grand_Total->CurrentValue = $this->Grand_Total->Total;
			$this->Grand_Total->ViewValue = $this->Grand_Total->CurrentValue;
			$this->Grand_Total->ViewValue = ew_FormatNumber($this->Grand_Total->ViewValue, 0, -2, -2, -2);
			$this->Grand_Total->CellCssStyle .= "text-align: right;";
			$this->Grand_Total->ViewCustomAttributes = "";
			$this->Grand_Total->HrefValue = ""; // Clear href value
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckEuroDate($this->Tgl->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Tgl->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Tgl->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->Tgl->FldErrMsg());
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->No_Faktur->AdvancedSearch->Load();
		$this->Tgl->AdvancedSearch->Load();
		$this->Bayar->AdvancedSearch->Load();
		$this->Sisa->AdvancedSearch->Load();
		$this->Sub_Total->AdvancedSearch->Load();
		$this->Diskon->AdvancedSearch->Load();
		$this->Potongan->AdvancedSearch->Load();
		$this->Grand_Total->AdvancedSearch->Load();
		$this->Kode_Kasir->AdvancedSearch->Load();
		$this->Kode->AdvancedSearch->Load();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$item->Body = "<a id=\"emf_Sisa_Bayar\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_Sisa_Bayar',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fSisa_Bayarlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "h");
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$ExportDoc->Text .= $sHeader;
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$ExportDoc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Export header and footer
		$ExportDoc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($ExportDoc->Text);
		} else {
			$ExportDoc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_GET["sender"];
		$sRecipient = @$_GET["recipient"];
		$sCc = @$_GET["cc"];
		$sBcc = @$_GET["bcc"];
		$sContentType = @$_GET["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_GET["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_GET["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-error\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		$Email->Charset = EW_EMAIL_CHARSET;
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= $EmailContent; // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-error\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Build QueryString for search
		if ($this->BasicSearch->getKeyword() <> "") {
			$sQry .= "&" . EW_TABLE_BASIC_SEARCH . "=" . urlencode($this->BasicSearch->getKeyword()) . "&" . EW_TABLE_BASIC_SEARCH_TYPE . "=" . urlencode($this->BasicSearch->getType());
		}
		$this->AddSearchQueryString($sQry, $this->No_Faktur); // No Faktur
		$this->AddSearchQueryString($sQry, $this->Tgl); // Tgl
		$this->AddSearchQueryString($sQry, $this->Bayar); // Bayar
		$this->AddSearchQueryString($sQry, $this->Sisa); // Sisa
		$this->AddSearchQueryString($sQry, $this->Sub_Total); // Sub Total
		$this->AddSearchQueryString($sQry, $this->Diskon); // Diskon
		$this->AddSearchQueryString($sQry, $this->Potongan); // Potongan
		$this->AddSearchQueryString($sQry, $this->Grand_Total); // Grand Total
		$this->AddSearchQueryString($sQry, $this->Kode_Kasir); // Kode Kasir
		$this->AddSearchQueryString($sQry, $this->Kode); // Kode

		// Build QueryString for pager
		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . urlencode($this->getRecordsPerPage()) . "&" . EW_TABLE_START_REC . "=" . urlencode($this->getStartRecordNumber());
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", $url, $this->TableVar);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($Sisa_Bayar_list)) $Sisa_Bayar_list = new cSisa_Bayar_list();

// Page init
$Sisa_Bayar_list->Page_Init();

// Page main
$Sisa_Bayar_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$Sisa_Bayar_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($Sisa_Bayar->Export == "") { ?>
<script type="text/javascript">

// Page object
var Sisa_Bayar_list = new ew_Page("Sisa_Bayar_list");
Sisa_Bayar_list.PageID = "list"; // Page ID
var EW_PAGE_ID = Sisa_Bayar_list.PageID; // For backward compatibility

// Form object
var fSisa_Bayarlist = new ew_Form("fSisa_Bayarlist");
fSisa_Bayarlist.FormKeyCountName = '<?php echo $Sisa_Bayar_list->FormKeyCountName ?>';

// Form_CustomValidate event
fSisa_Bayarlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fSisa_Bayarlist.ValidateRequired = true;
<?php } else { ?>
fSisa_Bayarlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fSisa_Bayarlist.Lists["x_Kode_Kasir"] = {"LinkField":"x_Username","Ajax":null,"AutoFill":false,"DisplayFields":["x_Username","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fSisa_Bayarlist.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_NamaPenyewa","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fSisa_Bayarlistsrch = new ew_Form("fSisa_Bayarlistsrch");

// Validate function for search
fSisa_Bayarlistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";
	elm = this.GetElements("x" + infix + "_Tgl");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($Sisa_Bayar->Tgl->FldErrMsg()) ?>");

	// Set up row object
	ew_ElementsToRow(fobj);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fSisa_Bayarlistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fSisa_Bayarlistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fSisa_Bayarlistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($Sisa_Bayar->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($Sisa_Bayar_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $Sisa_Bayar_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$Sisa_Bayar_list->TotalRecs = $Sisa_Bayar->SelectRecordCount();
	} else {
		if ($Sisa_Bayar_list->Recordset = $Sisa_Bayar_list->LoadRecordset())
			$Sisa_Bayar_list->TotalRecs = $Sisa_Bayar_list->Recordset->RecordCount();
	}
	$Sisa_Bayar_list->StartRec = 1;
	if ($Sisa_Bayar_list->DisplayRecs <= 0 || ($Sisa_Bayar->Export <> "" && $Sisa_Bayar->ExportAll)) // Display all records
		$Sisa_Bayar_list->DisplayRecs = $Sisa_Bayar_list->TotalRecs;
	if (!($Sisa_Bayar->Export <> "" && $Sisa_Bayar->ExportAll))
		$Sisa_Bayar_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$Sisa_Bayar_list->Recordset = $Sisa_Bayar_list->LoadRecordset($Sisa_Bayar_list->StartRec-1, $Sisa_Bayar_list->DisplayRecs);
$Sisa_Bayar_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($Sisa_Bayar->Export == "" && $Sisa_Bayar->CurrentAction == "") { ?>
<form name="fSisa_Bayarlistsrch" id="fSisa_Bayarlistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="fSisa_Bayarlistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#fSisa_Bayarlistsrch_SearchGroup" href="#fSisa_Bayarlistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="fSisa_Bayarlistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="fSisa_Bayarlistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="Sisa_Bayar">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$Sisa_Bayar_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$Sisa_Bayar->RowType = EW_ROWTYPE_SEARCH;

// Render row
$Sisa_Bayar->ResetAttrs();
$Sisa_Bayar_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($Sisa_Bayar->Tgl->Visible) { // Tgl ?>
	<span id="xsc_Tgl" class="ewCell">
		<span class="ewSearchCaption"><?php echo $Sisa_Bayar->Tgl->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("BETWEEN") ?><input type="hidden" name="z_Tgl" id="z_Tgl" value="BETWEEN"></span>
		<span class="control-group ewSearchField">
<input type="text" data-field="x_Tgl" name="x_Tgl" id="x_Tgl" placeholder="<?php echo $Sisa_Bayar->Tgl->PlaceHolder ?>" value="<?php echo $Sisa_Bayar->Tgl->EditValue ?>"<?php echo $Sisa_Bayar->Tgl->EditAttributes() ?>>
<?php if (!$Sisa_Bayar->Tgl->ReadOnly && !$Sisa_Bayar->Tgl->Disabled && @$Sisa_Bayar->Tgl->EditAttrs["readonly"] == "" && @$Sisa_Bayar->Tgl->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_Tgl" name="cal_x_Tgl" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_Tgl" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fSisa_Bayarlistsrch", "x_Tgl", "%d/%m/%Y");
</script>
<?php } ?>
</span>
		<span class="ewSearchCond btw1_Tgl">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
		<span class="control-group ewSearchField btw1_Tgl">
<input type="text" data-field="x_Tgl" name="y_Tgl" id="y_Tgl" placeholder="<?php echo $Sisa_Bayar->Tgl->PlaceHolder ?>" value="<?php echo $Sisa_Bayar->Tgl->EditValue2 ?>"<?php echo $Sisa_Bayar->Tgl->EditAttributes() ?>>
<?php if (!$Sisa_Bayar->Tgl->ReadOnly && !$Sisa_Bayar->Tgl->Disabled && @$Sisa_Bayar->Tgl->EditAttrs["readonly"] == "" && @$Sisa_Bayar->Tgl->EditAttrs["disabled"] == "") { ?>
<button id="cal_y_Tgl" name="cal_y_Tgl" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_y_Tgl" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fSisa_Bayarlistsrch", "y_Tgl", "%d/%m/%Y");
</script>
<?php } ?>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($Sisa_Bayar_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $Sisa_Bayar_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_3" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($Sisa_Bayar_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($Sisa_Bayar_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($Sisa_Bayar_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
			</div>
		</div>
	</div>
</div>
</td></tr></table>
</form>
<?php } ?>
<?php } ?>
<?php $Sisa_Bayar_list->ShowPageHeader(); ?>
<?php
$Sisa_Bayar_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fSisa_Bayarlist" id="fSisa_Bayarlist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="Sisa_Bayar">
<div id="gmp_Sisa_Bayar" class="ewGridMiddlePanel">
<?php if ($Sisa_Bayar_list->TotalRecs > 0) { ?>
<table id="tbl_Sisa_Bayarlist" class="ewTable ewTableSeparate">
<?php echo $Sisa_Bayar->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$Sisa_Bayar_list->RenderListOptions();

// Render list options (header, left)
$Sisa_Bayar_list->ListOptions->Render("header", "left");
?>
<?php if ($Sisa_Bayar->No_Faktur->Visible) { // No Faktur ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->No_Faktur) == "") { ?>
		<td><div id="elh_Sisa_Bayar_No_Faktur" class="Sisa_Bayar_No_Faktur"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->No_Faktur->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->No_Faktur) ?>',1);"><div id="elh_Sisa_Bayar_No_Faktur" class="Sisa_Bayar_No_Faktur">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->No_Faktur->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->No_Faktur->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->No_Faktur->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($Sisa_Bayar->Tgl->Visible) { // Tgl ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->Tgl) == "") { ?>
		<td><div id="elh_Sisa_Bayar_Tgl" class="Sisa_Bayar_Tgl"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Tgl->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->Tgl) ?>',1);"><div id="elh_Sisa_Bayar_Tgl" class="Sisa_Bayar_Tgl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Tgl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->Tgl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->Tgl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($Sisa_Bayar->Bayar->Visible) { // Bayar ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->Bayar) == "") { ?>
		<td><div id="elh_Sisa_Bayar_Bayar" class="Sisa_Bayar_Bayar"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Bayar->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->Bayar) ?>',1);"><div id="elh_Sisa_Bayar_Bayar" class="Sisa_Bayar_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($Sisa_Bayar->Sisa->Visible) { // Sisa ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->Sisa) == "") { ?>
		<td><div id="elh_Sisa_Bayar_Sisa" class="Sisa_Bayar_Sisa"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Sisa->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->Sisa) ?>',1);"><div id="elh_Sisa_Bayar_Sisa" class="Sisa_Bayar_Sisa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Sisa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->Sisa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->Sisa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($Sisa_Bayar->Sub_Total->Visible) { // Sub Total ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->Sub_Total) == "") { ?>
		<td><div id="elh_Sisa_Bayar_Sub_Total" class="Sisa_Bayar_Sub_Total"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Sub_Total->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->Sub_Total) ?>',1);"><div id="elh_Sisa_Bayar_Sub_Total" class="Sisa_Bayar_Sub_Total">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Sub_Total->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->Sub_Total->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->Sub_Total->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($Sisa_Bayar->Diskon->Visible) { // Diskon ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->Diskon) == "") { ?>
		<td><div id="elh_Sisa_Bayar_Diskon" class="Sisa_Bayar_Diskon"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Diskon->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->Diskon) ?>',1);"><div id="elh_Sisa_Bayar_Diskon" class="Sisa_Bayar_Diskon">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Diskon->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->Diskon->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->Diskon->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($Sisa_Bayar->Potongan->Visible) { // Potongan ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->Potongan) == "") { ?>
		<td><div id="elh_Sisa_Bayar_Potongan" class="Sisa_Bayar_Potongan"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Potongan->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->Potongan) ?>',1);"><div id="elh_Sisa_Bayar_Potongan" class="Sisa_Bayar_Potongan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Potongan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->Potongan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->Potongan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($Sisa_Bayar->Grand_Total->Visible) { // Grand Total ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->Grand_Total) == "") { ?>
		<td><div id="elh_Sisa_Bayar_Grand_Total" class="Sisa_Bayar_Grand_Total"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Grand_Total->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->Grand_Total) ?>',1);"><div id="elh_Sisa_Bayar_Grand_Total" class="Sisa_Bayar_Grand_Total">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Grand_Total->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->Grand_Total->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->Grand_Total->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($Sisa_Bayar->Kode_Kasir->Visible) { // Kode Kasir ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->Kode_Kasir) == "") { ?>
		<td><div id="elh_Sisa_Bayar_Kode_Kasir" class="Sisa_Bayar_Kode_Kasir"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Kode_Kasir->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->Kode_Kasir) ?>',1);"><div id="elh_Sisa_Bayar_Kode_Kasir" class="Sisa_Bayar_Kode_Kasir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Kode_Kasir->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->Kode_Kasir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->Kode_Kasir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($Sisa_Bayar->Kode->Visible) { // Kode ?>
	<?php if ($Sisa_Bayar->SortUrl($Sisa_Bayar->Kode) == "") { ?>
		<td><div id="elh_Sisa_Bayar_Kode" class="Sisa_Bayar_Kode"><div class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Kode->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $Sisa_Bayar->SortUrl($Sisa_Bayar->Kode) ?>',1);"><div id="elh_Sisa_Bayar_Kode" class="Sisa_Bayar_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $Sisa_Bayar->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($Sisa_Bayar->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Sisa_Bayar->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$Sisa_Bayar_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($Sisa_Bayar->ExportAll && $Sisa_Bayar->Export <> "") {
	$Sisa_Bayar_list->StopRec = $Sisa_Bayar_list->TotalRecs;
} else {

	// Set the last record to display
	if ($Sisa_Bayar_list->TotalRecs > $Sisa_Bayar_list->StartRec + $Sisa_Bayar_list->DisplayRecs - 1)
		$Sisa_Bayar_list->StopRec = $Sisa_Bayar_list->StartRec + $Sisa_Bayar_list->DisplayRecs - 1;
	else
		$Sisa_Bayar_list->StopRec = $Sisa_Bayar_list->TotalRecs;
}
$Sisa_Bayar_list->RecCnt = $Sisa_Bayar_list->StartRec - 1;
if ($Sisa_Bayar_list->Recordset && !$Sisa_Bayar_list->Recordset->EOF) {
	$Sisa_Bayar_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $Sisa_Bayar_list->StartRec > 1)
		$Sisa_Bayar_list->Recordset->Move($Sisa_Bayar_list->StartRec - 1);
} elseif (!$Sisa_Bayar->AllowAddDeleteRow && $Sisa_Bayar_list->StopRec == 0) {
	$Sisa_Bayar_list->StopRec = $Sisa_Bayar->GridAddRowCount;
}

// Initialize aggregate
$Sisa_Bayar->RowType = EW_ROWTYPE_AGGREGATEINIT;
$Sisa_Bayar->ResetAttrs();
$Sisa_Bayar_list->RenderRow();
while ($Sisa_Bayar_list->RecCnt < $Sisa_Bayar_list->StopRec) {
	$Sisa_Bayar_list->RecCnt++;
	if (intval($Sisa_Bayar_list->RecCnt) >= intval($Sisa_Bayar_list->StartRec)) {
		$Sisa_Bayar_list->RowCnt++;

		// Set up key count
		$Sisa_Bayar_list->KeyCount = $Sisa_Bayar_list->RowIndex;

		// Init row class and style
		$Sisa_Bayar->ResetAttrs();
		$Sisa_Bayar->CssClass = "";
		if ($Sisa_Bayar->CurrentAction == "gridadd") {
		} else {
			$Sisa_Bayar_list->LoadRowValues($Sisa_Bayar_list->Recordset); // Load row values
		}
		$Sisa_Bayar->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$Sisa_Bayar->RowAttrs = array_merge($Sisa_Bayar->RowAttrs, array('data-rowindex'=>$Sisa_Bayar_list->RowCnt, 'id'=>'r' . $Sisa_Bayar_list->RowCnt . '_Sisa_Bayar', 'data-rowtype'=>$Sisa_Bayar->RowType));

		// Render row
		$Sisa_Bayar_list->RenderRow();

		// Render list options
		$Sisa_Bayar_list->RenderListOptions();
?>
	<tr<?php echo $Sisa_Bayar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$Sisa_Bayar_list->ListOptions->Render("body", "left", $Sisa_Bayar_list->RowCnt);
?>
	<?php if ($Sisa_Bayar->No_Faktur->Visible) { // No Faktur ?>
		<td<?php echo $Sisa_Bayar->No_Faktur->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_No_Faktur" class="control-group Sisa_Bayar_No_Faktur">
<span<?php echo $Sisa_Bayar->No_Faktur->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($Sisa_Bayar->No_Faktur->ListViewValue()) && $Sisa_Bayar->No_Faktur->LinkAttributes() <> "") { ?>
<a<?php echo $Sisa_Bayar->No_Faktur->LinkAttributes() ?>><?php echo $Sisa_Bayar->No_Faktur->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $Sisa_Bayar->No_Faktur->ListViewValue() ?>
<?php } ?>
</span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Tgl->Visible) { // Tgl ?>
		<td<?php echo $Sisa_Bayar->Tgl->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_Tgl" class="control-group Sisa_Bayar_Tgl">
<span<?php echo $Sisa_Bayar->Tgl->ViewAttributes() ?>>
<?php echo $Sisa_Bayar->Tgl->ListViewValue() ?></span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Bayar->Visible) { // Bayar ?>
		<td<?php echo $Sisa_Bayar->Bayar->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_Bayar" class="control-group Sisa_Bayar_Bayar">
<span<?php echo $Sisa_Bayar->Bayar->ViewAttributes() ?>>
<?php echo $Sisa_Bayar->Bayar->ListViewValue() ?></span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Sisa->Visible) { // Sisa ?>
		<td<?php echo $Sisa_Bayar->Sisa->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_Sisa" class="control-group Sisa_Bayar_Sisa">
<span<?php echo $Sisa_Bayar->Sisa->ViewAttributes() ?>>
<?php echo $Sisa_Bayar->Sisa->ListViewValue() ?></span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Sub_Total->Visible) { // Sub Total ?>
		<td<?php echo $Sisa_Bayar->Sub_Total->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_Sub_Total" class="control-group Sisa_Bayar_Sub_Total">
<span<?php echo $Sisa_Bayar->Sub_Total->ViewAttributes() ?>>
<?php echo $Sisa_Bayar->Sub_Total->ListViewValue() ?></span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Diskon->Visible) { // Diskon ?>
		<td<?php echo $Sisa_Bayar->Diskon->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_Diskon" class="control-group Sisa_Bayar_Diskon">
<span<?php echo $Sisa_Bayar->Diskon->ViewAttributes() ?>>
<?php echo $Sisa_Bayar->Diskon->ListViewValue() ?></span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Potongan->Visible) { // Potongan ?>
		<td<?php echo $Sisa_Bayar->Potongan->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_Potongan" class="control-group Sisa_Bayar_Potongan">
<span<?php echo $Sisa_Bayar->Potongan->ViewAttributes() ?>>
<?php echo $Sisa_Bayar->Potongan->ListViewValue() ?></span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Grand_Total->Visible) { // Grand Total ?>
		<td<?php echo $Sisa_Bayar->Grand_Total->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_Grand_Total" class="control-group Sisa_Bayar_Grand_Total">
<span<?php echo $Sisa_Bayar->Grand_Total->ViewAttributes() ?>>
<?php echo $Sisa_Bayar->Grand_Total->ListViewValue() ?></span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Kode_Kasir->Visible) { // Kode Kasir ?>
		<td<?php echo $Sisa_Bayar->Kode_Kasir->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_Kode_Kasir" class="control-group Sisa_Bayar_Kode_Kasir">
<span<?php echo $Sisa_Bayar->Kode_Kasir->ViewAttributes() ?>>
<?php echo $Sisa_Bayar->Kode_Kasir->ListViewValue() ?></span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Kode->Visible) { // Kode ?>
		<td<?php echo $Sisa_Bayar->Kode->CellAttributes() ?>><span id="el<?php echo $Sisa_Bayar_list->RowCnt ?>_Sisa_Bayar_Kode" class="control-group Sisa_Bayar_Kode">
<span<?php echo $Sisa_Bayar->Kode->ViewAttributes() ?>>
<?php echo $Sisa_Bayar->Kode->ListViewValue() ?></span>
</span><a id="<?php echo $Sisa_Bayar_list->PageObjName . "_row_" . $Sisa_Bayar_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$Sisa_Bayar_list->ListOptions->Render("body", "right", $Sisa_Bayar_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($Sisa_Bayar->CurrentAction <> "gridadd")
		$Sisa_Bayar_list->Recordset->MoveNext();
}
?>
</tbody>
<?php

// Render aggregate row
$Sisa_Bayar->RowType = EW_ROWTYPE_AGGREGATE;
$Sisa_Bayar->ResetAttrs();
$Sisa_Bayar_list->RenderRow();
?>
<?php if ($Sisa_Bayar_list->TotalRecs > 0 && ($Sisa_Bayar->CurrentAction <> "gridadd" && $Sisa_Bayar->CurrentAction <> "gridedit")) { ?>
<tfoot><!-- Table footer -->
	<tr class="ewTableFooter">
<?php

// Render list options
$Sisa_Bayar_list->RenderListOptions();

// Render list options (footer, left)
$Sisa_Bayar_list->ListOptions->Render("footer", "left");
?>
	<?php if ($Sisa_Bayar->No_Faktur->Visible) { // No Faktur ?>
		<td><span id="elf_Sisa_Bayar_No_Faktur" class="Sisa_Bayar_No_Faktur">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Tgl->Visible) { // Tgl ?>
		<td><span id="elf_Sisa_Bayar_Tgl" class="Sisa_Bayar_Tgl">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Bayar->Visible) { // Bayar ?>
		<td><span id="elf_Sisa_Bayar_Bayar" class="Sisa_Bayar_Bayar">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?>: </span>
<?php echo $Sisa_Bayar->Bayar->ViewValue ?>
		</span></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Sisa->Visible) { // Sisa ?>
		<td><span id="elf_Sisa_Bayar_Sisa" class="Sisa_Bayar_Sisa">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?>: </span>
<?php echo $Sisa_Bayar->Sisa->ViewValue ?>
		</span></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Sub_Total->Visible) { // Sub Total ?>
		<td><span id="elf_Sisa_Bayar_Sub_Total" class="Sisa_Bayar_Sub_Total">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?>: </span>
<?php echo $Sisa_Bayar->Sub_Total->ViewValue ?>
		</span></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Diskon->Visible) { // Diskon ?>
		<td><span id="elf_Sisa_Bayar_Diskon" class="Sisa_Bayar_Diskon">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Potongan->Visible) { // Potongan ?>
		<td><span id="elf_Sisa_Bayar_Potongan" class="Sisa_Bayar_Potongan">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Grand_Total->Visible) { // Grand Total ?>
		<td><span id="elf_Sisa_Bayar_Grand_Total" class="Sisa_Bayar_Grand_Total">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?>: </span>
<?php echo $Sisa_Bayar->Grand_Total->ViewValue ?>
		</span></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Kode_Kasir->Visible) { // Kode Kasir ?>
		<td><span id="elf_Sisa_Bayar_Kode_Kasir" class="Sisa_Bayar_Kode_Kasir">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($Sisa_Bayar->Kode->Visible) { // Kode ?>
		<td><span id="elf_Sisa_Bayar_Kode" class="Sisa_Bayar_Kode">
		&nbsp;
		</span></td>
	<?php } ?>
<?php

// Render list options (footer, right)
$Sisa_Bayar_list->ListOptions->Render("footer", "right");
?>
	</tr>
</tfoot>	
<?php } ?>
</table>
<?php } ?>
<?php if ($Sisa_Bayar->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($Sisa_Bayar_list->Recordset)
	$Sisa_Bayar_list->Recordset->Close();
?>
<?php if ($Sisa_Bayar->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($Sisa_Bayar->CurrentAction <> "gridadd" && $Sisa_Bayar->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($Sisa_Bayar_list->Pager)) $Sisa_Bayar_list->Pager = new cNumericPager($Sisa_Bayar_list->StartRec, $Sisa_Bayar_list->DisplayRecs, $Sisa_Bayar_list->TotalRecs, $Sisa_Bayar_list->RecRange) ?>
<?php if ($Sisa_Bayar_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($Sisa_Bayar_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $Sisa_Bayar_list->PageUrl() ?>start=<?php echo $Sisa_Bayar_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($Sisa_Bayar_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $Sisa_Bayar_list->PageUrl() ?>start=<?php echo $Sisa_Bayar_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($Sisa_Bayar_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $Sisa_Bayar_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($Sisa_Bayar_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $Sisa_Bayar_list->PageUrl() ?>start=<?php echo $Sisa_Bayar_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($Sisa_Bayar_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $Sisa_Bayar_list->PageUrl() ?>start=<?php echo $Sisa_Bayar_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($Sisa_Bayar_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $Sisa_Bayar_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $Sisa_Bayar_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $Sisa_Bayar_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($Sisa_Bayar_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoPermission") ?></p>
	<?php } ?>
<?php } ?>
</td>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($Sisa_Bayar_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($Sisa_Bayar->Export == "") { ?>
<script type="text/javascript">
fSisa_Bayarlistsrch.Init();
fSisa_Bayarlist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$Sisa_Bayar_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($Sisa_Bayar->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$Sisa_Bayar_list->Page_Terminate();
?>

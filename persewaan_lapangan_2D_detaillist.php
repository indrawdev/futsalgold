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

$persewaan_lapangan_2D_detail_list = NULL; // Initialize page object first

class cpersewaan_lapangan_2D_detail_list extends cpersewaan_lapangan_2D_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'persewaan lapangan - detail';

	// Page object name
	var $PageObjName = 'persewaan_lapangan_2D_detail_list';

	// Grid form hidden field names
	var $FormName = 'fpersewaan_lapangan_2D_detaillist';
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

		// Table object (persewaan_lapangan_2D_detail)
		if (!isset($GLOBALS["persewaan_lapangan_2D_detail"])) {
			$GLOBALS["persewaan_lapangan_2D_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["persewaan_lapangan_2D_detail"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "persewaan_lapangan_2D_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "persewaan_lapangan_2D_detaildelete.php";
		$this->MultiUpdateUrl = "persewaan_lapangan_2D_detailupdate.php";

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Table object (persewaan_lapangan_2D_master)
		if (!isset($GLOBALS['persewaan_lapangan_2D_master'])) $GLOBALS['persewaan_lapangan_2D_master'] = new cpersewaan_lapangan_2D_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'persewaan lapangan - detail', TRUE);

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

			// Set up master detail parameters
			$this->SetUpMasterParms();

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

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "persewaan_lapangan_2D_master") {
			global $persewaan_lapangan_2D_master;
			$rsmaster = $persewaan_lapangan_2D_master->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("persewaan_lapangan_2D_masterlist.php"); // Return to master page
			} else {
				$persewaan_lapangan_2D_master->LoadListRowValues($rsmaster);
				$persewaan_lapangan_2D_master->RowType = EW_ROWTYPE_MASTER; // Master row
				$persewaan_lapangan_2D_master->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";
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
		if (count($arrKeyFlds) >= 1) {
			$this->ID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->ID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Kode); // Kode
			$this->UpdateSort($this->NamaLapangan); // NamaLapangan
			$this->UpdateSort($this->TglSewa); // TglSewa
			$this->UpdateSort($this->JamSewa); // JamSewa
			$this->UpdateSort($this->HargaSewa); // HargaSewa
			$this->UpdateSort($this->Hitung); // Hitung
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->IDM->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Kode->setSort("");
				$this->NamaLapangan->setSort("");
				$this->TglSewa->setSort("");
				$this->JamSewa->setSort("");
				$this->HargaSewa->setSort("");
				$this->Hitung->setSort("");
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
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;
		$item->Header = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"></label>";
		if (count($this->CustomActions) > 0) $item->Visible = TRUE;
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = TRUE;
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

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->ID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'></label>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.fpersewaan_lapangan_2D_detaillist, '" . $this->MultiDeleteUrl . "');return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = TRUE;
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fpersewaan_lapangan_2D_detaillist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

		// Accumulate aggregate value
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT && $this->RowType <> EW_ROWTYPE_AGGREGATE) {
			if (is_numeric($this->HargaSewa->CurrentValue))
				$this->HargaSewa->Total += $this->HargaSewa->CurrentValue; // Accumulate total
		}
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
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
			$this->HargaSewa->Total = 0; // Initialize total
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATE) { // Aggregate row
			$this->HargaSewa->CurrentValue = $this->HargaSewa->Total;
			$this->HargaSewa->ViewValue = $this->HargaSewa->CurrentValue;
			$this->HargaSewa->ViewValue = ew_FormatNumber($this->HargaSewa->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa->CellCssStyle .= "text-align: right;";
			$this->HargaSewa->ViewCustomAttributes = "";
			$this->HargaSewa->HrefValue = ""; // Clear href value
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

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
		$item->Body = "<a id=\"emf_persewaan_lapangan_2D_detail\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_persewaan_lapangan_2D_detail',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fpersewaan_lapangan_2D_detaillist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
if (!isset($persewaan_lapangan_2D_detail_list)) $persewaan_lapangan_2D_detail_list = new cpersewaan_lapangan_2D_detail_list();

// Page init
$persewaan_lapangan_2D_detail_list->Page_Init();

// Page main
$persewaan_lapangan_2D_detail_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persewaan_lapangan_2D_detail_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var persewaan_lapangan_2D_detail_list = new ew_Page("persewaan_lapangan_2D_detail_list");
persewaan_lapangan_2D_detail_list.PageID = "list"; // Page ID
var EW_PAGE_ID = persewaan_lapangan_2D_detail_list.PageID; // For backward compatibility

// Form object
var fpersewaan_lapangan_2D_detaillist = new ew_Form("fpersewaan_lapangan_2D_detaillist");
fpersewaan_lapangan_2D_detaillist.FormKeyCountName = '<?php echo $persewaan_lapangan_2D_detail_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpersewaan_lapangan_2D_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersewaan_lapangan_2D_detaillist.ValidateRequired = true;
<?php } else { ?>
fpersewaan_lapangan_2D_detaillist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersewaan_lapangan_2D_detaillist.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_NamaLapangan","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->getCurrentMasterTable() == "" && $persewaan_lapangan_2D_detail_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $persewaan_lapangan_2D_detail_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php if (($persewaan_lapangan_2D_detail->Export == "") || (EW_EXPORT_MASTER_RECORD && $persewaan_lapangan_2D_detail->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "persewaan_lapangan_2D_masterlist.php";
if ($persewaan_lapangan_2D_detail_list->DbMasterFilter <> "" && $persewaan_lapangan_2D_detail->getCurrentMasterTable() == "persewaan_lapangan_2D_master") {
	if ($persewaan_lapangan_2D_detail_list->MasterRecordExists) {
		if ($persewaan_lapangan_2D_detail->getCurrentMasterTable() == $persewaan_lapangan_2D_detail->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($persewaan_lapangan_2D_detail_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $persewaan_lapangan_2D_detail_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once "persewaan_lapangan_2D_mastermaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$persewaan_lapangan_2D_detail_list->TotalRecs = $persewaan_lapangan_2D_detail->SelectRecordCount();
	} else {
		if ($persewaan_lapangan_2D_detail_list->Recordset = $persewaan_lapangan_2D_detail_list->LoadRecordset())
			$persewaan_lapangan_2D_detail_list->TotalRecs = $persewaan_lapangan_2D_detail_list->Recordset->RecordCount();
	}
	$persewaan_lapangan_2D_detail_list->StartRec = 1;
	if ($persewaan_lapangan_2D_detail_list->DisplayRecs <= 0 || ($persewaan_lapangan_2D_detail->Export <> "" && $persewaan_lapangan_2D_detail->ExportAll)) // Display all records
		$persewaan_lapangan_2D_detail_list->DisplayRecs = $persewaan_lapangan_2D_detail_list->TotalRecs;
	if (!($persewaan_lapangan_2D_detail->Export <> "" && $persewaan_lapangan_2D_detail->ExportAll))
		$persewaan_lapangan_2D_detail_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$persewaan_lapangan_2D_detail_list->Recordset = $persewaan_lapangan_2D_detail_list->LoadRecordset($persewaan_lapangan_2D_detail_list->StartRec-1, $persewaan_lapangan_2D_detail_list->DisplayRecs);
$persewaan_lapangan_2D_detail_list->RenderOtherOptions();
?>
<?php $persewaan_lapangan_2D_detail_list->ShowPageHeader(); ?>
<?php
$persewaan_lapangan_2D_detail_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fpersewaan_lapangan_2D_detaillist" id="fpersewaan_lapangan_2D_detaillist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="persewaan_lapangan_2D_detail">
<div id="gmp_persewaan_lapangan_2D_detail" class="ewGridMiddlePanel">
<?php if ($persewaan_lapangan_2D_detail_list->TotalRecs > 0) { ?>
<table id="tbl_persewaan_lapangan_2D_detaillist" class="ewTable ewTableSeparate">
<?php echo $persewaan_lapangan_2D_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$persewaan_lapangan_2D_detail_list->RenderListOptions();

// Render list options (header, left)
$persewaan_lapangan_2D_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($persewaan_lapangan_2D_detail->Kode->Visible) { // Kode ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->Kode) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_Kode" class="persewaan_lapangan_2D_detail_Kode"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->Kode->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->Kode) ?>',1);"><div id="elh_persewaan_lapangan_2D_detail_Kode" class="persewaan_lapangan_2D_detail_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->NamaLapangan->Visible) { // NamaLapangan ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->NamaLapangan) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_NamaLapangan" class="persewaan_lapangan_2D_detail_NamaLapangan"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->NamaLapangan) ?>',1);"><div id="elh_persewaan_lapangan_2D_detail_NamaLapangan" class="persewaan_lapangan_2D_detail_NamaLapangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->NamaLapangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->NamaLapangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->TglSewa->Visible) { // TglSewa ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->TglSewa) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_TglSewa" class="persewaan_lapangan_2D_detail_TglSewa"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->TglSewa->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->TglSewa) ?>',1);"><div id="elh_persewaan_lapangan_2D_detail_TglSewa" class="persewaan_lapangan_2D_detail_TglSewa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->TglSewa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->TglSewa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->TglSewa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->JamSewa->Visible) { // JamSewa ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->JamSewa) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_JamSewa" class="persewaan_lapangan_2D_detail_JamSewa"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->JamSewa->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->JamSewa) ?>',1);"><div id="elh_persewaan_lapangan_2D_detail_JamSewa" class="persewaan_lapangan_2D_detail_JamSewa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->JamSewa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->JamSewa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->JamSewa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->HargaSewa->Visible) { // HargaSewa ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->HargaSewa) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_HargaSewa" class="persewaan_lapangan_2D_detail_HargaSewa"><div class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->HargaSewa->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->HargaSewa) ?>',1);"><div id="elh_persewaan_lapangan_2D_detail_HargaSewa" class="persewaan_lapangan_2D_detail_HargaSewa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->HargaSewa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->HargaSewa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->HargaSewa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($persewaan_lapangan_2D_detail->Hitung->Visible) { // Hitung ?>
	<?php if ($persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->Hitung) == "") { ?>
		<td><div id="elh_persewaan_lapangan_2D_detail_Hitung" class="persewaan_lapangan_2D_detail_Hitung"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $persewaan_lapangan_2D_detail->Hitung->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $persewaan_lapangan_2D_detail->SortUrl($persewaan_lapangan_2D_detail->Hitung) ?>',1);"><div id="elh_persewaan_lapangan_2D_detail_Hitung" class="persewaan_lapangan_2D_detail_Hitung">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $persewaan_lapangan_2D_detail->Hitung->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persewaan_lapangan_2D_detail->Hitung->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persewaan_lapangan_2D_detail->Hitung->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$persewaan_lapangan_2D_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($persewaan_lapangan_2D_detail->ExportAll && $persewaan_lapangan_2D_detail->Export <> "") {
	$persewaan_lapangan_2D_detail_list->StopRec = $persewaan_lapangan_2D_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($persewaan_lapangan_2D_detail_list->TotalRecs > $persewaan_lapangan_2D_detail_list->StartRec + $persewaan_lapangan_2D_detail_list->DisplayRecs - 1)
		$persewaan_lapangan_2D_detail_list->StopRec = $persewaan_lapangan_2D_detail_list->StartRec + $persewaan_lapangan_2D_detail_list->DisplayRecs - 1;
	else
		$persewaan_lapangan_2D_detail_list->StopRec = $persewaan_lapangan_2D_detail_list->TotalRecs;
}
$persewaan_lapangan_2D_detail_list->RecCnt = $persewaan_lapangan_2D_detail_list->StartRec - 1;
if ($persewaan_lapangan_2D_detail_list->Recordset && !$persewaan_lapangan_2D_detail_list->Recordset->EOF) {
	$persewaan_lapangan_2D_detail_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $persewaan_lapangan_2D_detail_list->StartRec > 1)
		$persewaan_lapangan_2D_detail_list->Recordset->Move($persewaan_lapangan_2D_detail_list->StartRec - 1);
} elseif (!$persewaan_lapangan_2D_detail->AllowAddDeleteRow && $persewaan_lapangan_2D_detail_list->StopRec == 0) {
	$persewaan_lapangan_2D_detail_list->StopRec = $persewaan_lapangan_2D_detail->GridAddRowCount;
}

// Initialize aggregate
$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$persewaan_lapangan_2D_detail->ResetAttrs();
$persewaan_lapangan_2D_detail_list->RenderRow();
while ($persewaan_lapangan_2D_detail_list->RecCnt < $persewaan_lapangan_2D_detail_list->StopRec) {
	$persewaan_lapangan_2D_detail_list->RecCnt++;
	if (intval($persewaan_lapangan_2D_detail_list->RecCnt) >= intval($persewaan_lapangan_2D_detail_list->StartRec)) {
		$persewaan_lapangan_2D_detail_list->RowCnt++;

		// Set up key count
		$persewaan_lapangan_2D_detail_list->KeyCount = $persewaan_lapangan_2D_detail_list->RowIndex;

		// Init row class and style
		$persewaan_lapangan_2D_detail->ResetAttrs();
		$persewaan_lapangan_2D_detail->CssClass = "";
		if ($persewaan_lapangan_2D_detail->CurrentAction == "gridadd") {
		} else {
			$persewaan_lapangan_2D_detail_list->LoadRowValues($persewaan_lapangan_2D_detail_list->Recordset); // Load row values
		}
		$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$persewaan_lapangan_2D_detail->RowAttrs = array_merge($persewaan_lapangan_2D_detail->RowAttrs, array('data-rowindex'=>$persewaan_lapangan_2D_detail_list->RowCnt, 'id'=>'r' . $persewaan_lapangan_2D_detail_list->RowCnt . '_persewaan_lapangan_2D_detail', 'data-rowtype'=>$persewaan_lapangan_2D_detail->RowType));

		// Render row
		$persewaan_lapangan_2D_detail_list->RenderRow();

		// Render list options
		$persewaan_lapangan_2D_detail_list->RenderListOptions();
?>
	<tr<?php echo $persewaan_lapangan_2D_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$persewaan_lapangan_2D_detail_list->ListOptions->Render("body", "left", $persewaan_lapangan_2D_detail_list->RowCnt);
?>
	<?php if ($persewaan_lapangan_2D_detail->Kode->Visible) { // Kode ?>
		<td<?php echo $persewaan_lapangan_2D_detail->Kode->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_list->RowCnt ?>_persewaan_lapangan_2D_detail_Kode" class="control-group persewaan_lapangan_2D_detail_Kode">
<span<?php echo $persewaan_lapangan_2D_detail->Kode->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->Kode->ListViewValue() ?></span>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_list->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->NamaLapangan->Visible) { // NamaLapangan ?>
		<td<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_list->RowCnt ?>_persewaan_lapangan_2D_detail_NamaLapangan" class="control-group persewaan_lapangan_2D_detail_NamaLapangan">
<span<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ListViewValue() ?></span>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_list->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->TglSewa->Visible) { // TglSewa ?>
		<td<?php echo $persewaan_lapangan_2D_detail->TglSewa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_list->RowCnt ?>_persewaan_lapangan_2D_detail_TglSewa" class="control-group persewaan_lapangan_2D_detail_TglSewa">
<span<?php echo $persewaan_lapangan_2D_detail->TglSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->TglSewa->ListViewValue() ?></span>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_list->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->JamSewa->Visible) { // JamSewa ?>
		<td<?php echo $persewaan_lapangan_2D_detail->JamSewa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_list->RowCnt ?>_persewaan_lapangan_2D_detail_JamSewa" class="control-group persewaan_lapangan_2D_detail_JamSewa">
<span<?php echo $persewaan_lapangan_2D_detail->JamSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->JamSewa->ListViewValue() ?></span>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_list->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->HargaSewa->Visible) { // HargaSewa ?>
		<td<?php echo $persewaan_lapangan_2D_detail->HargaSewa->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_list->RowCnt ?>_persewaan_lapangan_2D_detail_HargaSewa" class="control-group persewaan_lapangan_2D_detail_HargaSewa">
<span<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ViewAttributes() ?>>
<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ListViewValue() ?></span>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_list->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->Hitung->Visible) { // Hitung ?>
		<td<?php echo $persewaan_lapangan_2D_detail->Hitung->CellAttributes() ?>><span id="el<?php echo $persewaan_lapangan_2D_detail_list->RowCnt ?>_persewaan_lapangan_2D_detail_Hitung" class="control-group persewaan_lapangan_2D_detail_Hitung">
<span<?php echo $persewaan_lapangan_2D_detail->Hitung->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($persewaan_lapangan_2D_detail->Hitung->ListViewValue()) && $persewaan_lapangan_2D_detail->Hitung->LinkAttributes() <> "") { ?>
<a<?php echo $persewaan_lapangan_2D_detail->Hitung->LinkAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->Hitung->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $persewaan_lapangan_2D_detail->Hitung->ListViewValue() ?>
<?php } ?>
</span>
</span><a id="<?php echo $persewaan_lapangan_2D_detail_list->PageObjName . "_row_" . $persewaan_lapangan_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$persewaan_lapangan_2D_detail_list->ListOptions->Render("body", "right", $persewaan_lapangan_2D_detail_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($persewaan_lapangan_2D_detail->CurrentAction <> "gridadd")
		$persewaan_lapangan_2D_detail_list->Recordset->MoveNext();
}
?>
</tbody>
<?php

// Render aggregate row
$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_AGGREGATE;
$persewaan_lapangan_2D_detail->ResetAttrs();
$persewaan_lapangan_2D_detail_list->RenderRow();
?>
<?php if ($persewaan_lapangan_2D_detail_list->TotalRecs > 0 && ($persewaan_lapangan_2D_detail->CurrentAction <> "gridadd" && $persewaan_lapangan_2D_detail->CurrentAction <> "gridedit")) { ?>
<tfoot><!-- Table footer -->
	<tr class="ewTableFooter">
<?php

// Render list options
$persewaan_lapangan_2D_detail_list->RenderListOptions();

// Render list options (footer, left)
$persewaan_lapangan_2D_detail_list->ListOptions->Render("footer", "left");
?>
	<?php if ($persewaan_lapangan_2D_detail->Kode->Visible) { // Kode ?>
		<td><span id="elf_persewaan_lapangan_2D_detail_Kode" class="persewaan_lapangan_2D_detail_Kode">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->NamaLapangan->Visible) { // NamaLapangan ?>
		<td><span id="elf_persewaan_lapangan_2D_detail_NamaLapangan" class="persewaan_lapangan_2D_detail_NamaLapangan">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->TglSewa->Visible) { // TglSewa ?>
		<td><span id="elf_persewaan_lapangan_2D_detail_TglSewa" class="persewaan_lapangan_2D_detail_TglSewa">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->JamSewa->Visible) { // JamSewa ?>
		<td><span id="elf_persewaan_lapangan_2D_detail_JamSewa" class="persewaan_lapangan_2D_detail_JamSewa">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->HargaSewa->Visible) { // HargaSewa ?>
		<td><span id="elf_persewaan_lapangan_2D_detail_HargaSewa" class="persewaan_lapangan_2D_detail_HargaSewa">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?>: </span>
<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ViewValue ?>
		</span></td>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail->Hitung->Visible) { // Hitung ?>
		<td><span id="elf_persewaan_lapangan_2D_detail_Hitung" class="persewaan_lapangan_2D_detail_Hitung">
		&nbsp;
		</span></td>
	<?php } ?>
<?php

// Render list options (footer, right)
$persewaan_lapangan_2D_detail_list->ListOptions->Render("footer", "right");
?>
	</tr>
</tfoot>	
<?php } ?>
</table>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($persewaan_lapangan_2D_detail_list->Recordset)
	$persewaan_lapangan_2D_detail_list->Recordset->Close();
?>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($persewaan_lapangan_2D_detail->CurrentAction <> "gridadd" && $persewaan_lapangan_2D_detail->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($persewaan_lapangan_2D_detail_list->Pager)) $persewaan_lapangan_2D_detail_list->Pager = new cNumericPager($persewaan_lapangan_2D_detail_list->StartRec, $persewaan_lapangan_2D_detail_list->DisplayRecs, $persewaan_lapangan_2D_detail_list->TotalRecs, $persewaan_lapangan_2D_detail_list->RecRange) ?>
<?php if ($persewaan_lapangan_2D_detail_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($persewaan_lapangan_2D_detail_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $persewaan_lapangan_2D_detail_list->PageUrl() ?>start=<?php echo $persewaan_lapangan_2D_detail_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $persewaan_lapangan_2D_detail_list->PageUrl() ?>start=<?php echo $persewaan_lapangan_2D_detail_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($persewaan_lapangan_2D_detail_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $persewaan_lapangan_2D_detail_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $persewaan_lapangan_2D_detail_list->PageUrl() ?>start=<?php echo $persewaan_lapangan_2D_detail_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($persewaan_lapangan_2D_detail_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $persewaan_lapangan_2D_detail_list->PageUrl() ?>start=<?php echo $persewaan_lapangan_2D_detail_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($persewaan_lapangan_2D_detail_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $persewaan_lapangan_2D_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $persewaan_lapangan_2D_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $persewaan_lapangan_2D_detail_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($persewaan_lapangan_2D_detail_list->SearchWhere == "0=101") { ?>
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
	foreach ($persewaan_lapangan_2D_detail_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<script type="text/javascript">
fpersewaan_lapangan_2D_detaillist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$persewaan_lapangan_2D_detail_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$persewaan_lapangan_2D_detail_list->Page_Terminate();
?>

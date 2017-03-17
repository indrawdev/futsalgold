<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "pembelian_2D_detailinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "pembelian_2D_masterinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$pembelian_2D_detail_list = NULL; // Initialize page object first

class cpembelian_2D_detail_list extends cpembelian_2D_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'pembelian - detail';

	// Page object name
	var $PageObjName = 'pembelian_2D_detail_list';

	// Grid form hidden field names
	var $FormName = 'fpembelian_2D_detaillist';
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

		// Table object (pembelian_2D_detail)
		if (!isset($GLOBALS["pembelian_2D_detail"])) {
			$GLOBALS["pembelian_2D_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pembelian_2D_detail"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "pembelian_2D_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "pembelian_2D_detaildelete.php";
		$this->MultiUpdateUrl = "pembelian_2D_detailupdate.php";

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Table object (pembelian_2D_master)
		if (!isset($GLOBALS['pembelian_2D_master'])) $GLOBALS['pembelian_2D_master'] = new cpembelian_2D_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pembelian - detail', TRUE);

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

		// Add master User ID filter
		if ($Security->CurrentUserID() <> "" && !$Security->IsAdmin()) { // Non system admin
			if ($this->getCurrentMasterTable() == "pembelian_2D_master")
				$this->DbMasterFilter = $this->AddMasterUserIDFilter($this->DbMasterFilter, "pembelian_2D_master"); // Add master User ID filter
		}
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "pembelian_2D_master") {
			global $pembelian_2D_master;
			$rsmaster = $pembelian_2D_master->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("pembelian_2D_masterlist.php"); // Return to master page
			} else {
				$pembelian_2D_master->LoadListRowValues($rsmaster);
				$pembelian_2D_master->RowType = EW_ROWTYPE_MASTER; // Master row
				$pembelian_2D_master->RenderListRow();
				$rsmaster->Close();
			}
		}

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
			$this->UpdateSort($this->Nama_Barang); // Nama Barang
			$this->UpdateSort($this->Satuan); // Satuan
			$this->UpdateSort($this->Harga_Beli); // Harga Beli
			$this->UpdateSort($this->Jumlah); // Jumlah
			$this->UpdateSort($this->Total_HP); // Total HP
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
				$this->setSessionOrderByList($sOrderBy);
				$this->Kode->setSort("");
				$this->Nama_Barang->setSort("");
				$this->Satuan->setSort("");
				$this->Harga_Beli->setSort("");
				$this->Jumlah->setSort("");
				$this->Total_HP->setSort("");
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.fpembelian_2D_detaillist, '" . $this->MultiDeleteUrl . "');return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fpembelian_2D_detaillist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		if (array_key_exists('EV__Kode', $rs->fields)) {
			$this->Kode->VirtualValue = $rs->fields('EV__Kode'); // Set up virtual field value
		} else {
			$this->Kode->VirtualValue = ""; // Clear value
		}
		$this->Nama_Barang->setDbValue($rs->fields('Nama Barang'));
		$this->Isi->setDbValue($rs->fields('Isi'));
		$this->Satuan->setDbValue($rs->fields('Satuan'));
		$this->Harga_Beli->setDbValue($rs->fields('Harga Beli'));
		$this->Jumlah->setDbValue($rs->fields('Jumlah'));
		$this->Total_Jumlah->setDbValue($rs->fields('Total Jumlah'));
		$this->Berat->setDbValue($rs->fields('Berat'));
		$this->Diskon->setDbValue($rs->fields('Diskon'));
		$this->Total_HP->setDbValue($rs->fields('Total HP'));
		$this->Retur->setDbValue($rs->fields('Retur'));
		$this->User->setDbValue($rs->fields('User'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
		$this->IDM->setDbValue($rs->fields('IDM'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Kode->DbValue = $row['Kode'];
		$this->Nama_Barang->DbValue = $row['Nama Barang'];
		$this->Isi->DbValue = $row['Isi'];
		$this->Satuan->DbValue = $row['Satuan'];
		$this->Harga_Beli->DbValue = $row['Harga Beli'];
		$this->Jumlah->DbValue = $row['Jumlah'];
		$this->Total_Jumlah->DbValue = $row['Total Jumlah'];
		$this->Berat->DbValue = $row['Berat'];
		$this->Diskon->DbValue = $row['Diskon'];
		$this->Total_HP->DbValue = $row['Total HP'];
		$this->Retur->DbValue = $row['Retur'];
		$this->User->DbValue = $row['User'];
		$this->Waktu->DbValue = $row['Waktu'];
		$this->Stamp->DbValue = $row['Stamp'];
		$this->IDM->DbValue = $row['IDM'];
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

		// Convert decimal values if posted back
		if ($this->Jumlah->FormValue == $this->Jumlah->CurrentValue && is_numeric(ew_StrToFloat($this->Jumlah->CurrentValue)))
			$this->Jumlah->CurrentValue = ew_StrToFloat($this->Jumlah->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// ID

		$this->ID->CellCssStyle = "white-space: nowrap;";

		// Kode
		// Nama Barang
		// Isi

		$this->Isi->CellCssStyle = "white-space: nowrap;";

		// Satuan
		// Harga Beli
		// Jumlah
		// Total Jumlah

		$this->Total_Jumlah->CellCssStyle = "white-space: nowrap;";

		// Berat
		$this->Berat->CellCssStyle = "white-space: nowrap;";

		// Diskon
		$this->Diskon->CellCssStyle = "white-space: nowrap;";

		// Total HP
		// Retur

		$this->Retur->CellCssStyle = "white-space: nowrap;";

		// User
		$this->User->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";

		// IDM
		$this->IDM->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			if ($this->Kode->VirtualValue <> "") {
				$this->Kode->ViewValue = $this->Kode->VirtualValue;
			} else {
			if (strval($this->Kode->CurrentValue) <> "") {
				$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `Nama Barang` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar produk`";
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
			$this->Kode->CssStyle = "font-weight: bold;";
			$this->Kode->CellCssStyle .= "text-align: center;";
			$this->Kode->ViewCustomAttributes = "";

			// Nama Barang
			$this->Nama_Barang->ViewValue = $this->Nama_Barang->CurrentValue;
			$this->Nama_Barang->ViewCustomAttributes = "";

			// Satuan
			$this->Satuan->ViewValue = $this->Satuan->CurrentValue;
			$this->Satuan->ViewCustomAttributes = "";

			// Harga Beli
			$this->Harga_Beli->ViewValue = $this->Harga_Beli->CurrentValue;
			$this->Harga_Beli->ViewValue = ew_FormatNumber($this->Harga_Beli->ViewValue, 0, -2, -2, -2);
			$this->Harga_Beli->CellCssStyle .= "text-align: right;";
			$this->Harga_Beli->ViewCustomAttributes = "";

			// Jumlah
			$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
			$this->Jumlah->CellCssStyle .= "text-align: center;";
			$this->Jumlah->ViewCustomAttributes = "";

			// Total HP
			$this->Total_HP->ViewValue = $this->Total_HP->CurrentValue;
			$this->Total_HP->ViewValue = ew_FormatNumber($this->Total_HP->ViewValue, 0, -2, -2, -2);
			$this->Total_HP->CellCssStyle .= "text-align: right;";
			$this->Total_HP->ViewCustomAttributes = "";

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

			// Harga Beli
			$this->Harga_Beli->LinkCustomAttributes = "";
			$this->Harga_Beli->HrefValue = "";
			$this->Harga_Beli->TooltipValue = "";

			// Jumlah
			$this->Jumlah->LinkCustomAttributes = "";
			$this->Jumlah->HrefValue = "";
			$this->Jumlah->TooltipValue = "";

			// Total HP
			$this->Total_HP->LinkCustomAttributes = "";
			$this->Total_HP->HrefValue = "";
			$this->Total_HP->TooltipValue = "";
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
		$item->Body = "<a id=\"emf_pembelian_2D_detail\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pembelian_2D_detail',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fpembelian_2D_detaillist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "pembelian_2D_master") {
			global $pembelian_2D_master;
			$rsmaster = $pembelian_2D_master->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $ExportDoc->Style;
				$ExportDoc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$pembelian_2D_master->ExportDocument($ExportDoc, $rsmaster, 1, 1);
					$ExportDoc->ExportEmptyRow();
				}
				$ExportDoc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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
			if ($sMasterTblVar == "pembelian_2D_master") {
				$bValidMaster = TRUE;
				if (@$_GET["ID"] <> "") {
					$GLOBALS["pembelian_2D_master"]->ID->setQueryStringValue($_GET["ID"]);
					$this->IDM->setQueryStringValue($GLOBALS["pembelian_2D_master"]->ID->QueryStringValue);
					$this->IDM->setSessionValue($this->IDM->QueryStringValue);
					if (!is_numeric($GLOBALS["pembelian_2D_master"]->ID->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "pembelian_2D_master") {
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
if (!isset($pembelian_2D_detail_list)) $pembelian_2D_detail_list = new cpembelian_2D_detail_list();

// Page init
$pembelian_2D_detail_list->Page_Init();

// Page main
$pembelian_2D_detail_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pembelian_2D_detail_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($pembelian_2D_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var pembelian_2D_detail_list = new ew_Page("pembelian_2D_detail_list");
pembelian_2D_detail_list.PageID = "list"; // Page ID
var EW_PAGE_ID = pembelian_2D_detail_list.PageID; // For backward compatibility

// Form object
var fpembelian_2D_detaillist = new ew_Form("fpembelian_2D_detaillist");
fpembelian_2D_detaillist.FormKeyCountName = '<?php echo $pembelian_2D_detail_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpembelian_2D_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpembelian_2D_detaillist.ValidateRequired = true;
<?php } else { ?>
fpembelian_2D_detaillist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpembelian_2D_detaillist.Lists["x_Kode"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_Nama_Barang","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($pembelian_2D_detail->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($pembelian_2D_detail->getCurrentMasterTable() == "" && $pembelian_2D_detail_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $pembelian_2D_detail_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php if (($pembelian_2D_detail->Export == "") || (EW_EXPORT_MASTER_RECORD && $pembelian_2D_detail->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "pembelian_2D_masterlist.php";
if ($pembelian_2D_detail_list->DbMasterFilter <> "" && $pembelian_2D_detail->getCurrentMasterTable() == "pembelian_2D_master") {
	if ($pembelian_2D_detail_list->MasterRecordExists) {
		if ($pembelian_2D_detail->getCurrentMasterTable() == $pembelian_2D_detail->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($pembelian_2D_detail_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $pembelian_2D_detail_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once "pembelian_2D_mastermaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$pembelian_2D_detail_list->TotalRecs = $pembelian_2D_detail->SelectRecordCount();
	} else {
		if ($pembelian_2D_detail_list->Recordset = $pembelian_2D_detail_list->LoadRecordset())
			$pembelian_2D_detail_list->TotalRecs = $pembelian_2D_detail_list->Recordset->RecordCount();
	}
	$pembelian_2D_detail_list->StartRec = 1;
	if ($pembelian_2D_detail_list->DisplayRecs <= 0 || ($pembelian_2D_detail->Export <> "" && $pembelian_2D_detail->ExportAll)) // Display all records
		$pembelian_2D_detail_list->DisplayRecs = $pembelian_2D_detail_list->TotalRecs;
	if (!($pembelian_2D_detail->Export <> "" && $pembelian_2D_detail->ExportAll))
		$pembelian_2D_detail_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$pembelian_2D_detail_list->Recordset = $pembelian_2D_detail_list->LoadRecordset($pembelian_2D_detail_list->StartRec-1, $pembelian_2D_detail_list->DisplayRecs);
$pembelian_2D_detail_list->RenderOtherOptions();
?>
<?php $pembelian_2D_detail_list->ShowPageHeader(); ?>
<?php
$pembelian_2D_detail_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fpembelian_2D_detaillist" id="fpembelian_2D_detaillist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="pembelian_2D_detail">
<div id="gmp_pembelian_2D_detail" class="ewGridMiddlePanel">
<?php if ($pembelian_2D_detail_list->TotalRecs > 0) { ?>
<table id="tbl_pembelian_2D_detaillist" class="ewTable ewTableSeparate">
<?php echo $pembelian_2D_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$pembelian_2D_detail_list->RenderListOptions();

// Render list options (header, left)
$pembelian_2D_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($pembelian_2D_detail->Kode->Visible) { // Kode ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Kode) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Kode" class="pembelian_2D_detail_Kode"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Kode->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pembelian_2D_detail->SortUrl($pembelian_2D_detail->Kode) ?>',1);"><div id="elh_pembelian_2D_detail_Kode" class="pembelian_2D_detail_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Nama_Barang->Visible) { // Nama Barang ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Nama_Barang) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Nama_Barang" class="pembelian_2D_detail_Nama_Barang"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Nama_Barang->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pembelian_2D_detail->SortUrl($pembelian_2D_detail->Nama_Barang) ?>',1);"><div id="elh_pembelian_2D_detail_Nama_Barang" class="pembelian_2D_detail_Nama_Barang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Nama_Barang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Nama_Barang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Nama_Barang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Satuan->Visible) { // Satuan ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Satuan) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Satuan" class="pembelian_2D_detail_Satuan"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Satuan->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pembelian_2D_detail->SortUrl($pembelian_2D_detail->Satuan) ?>',1);"><div id="elh_pembelian_2D_detail_Satuan" class="pembelian_2D_detail_Satuan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Satuan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Satuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Satuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Harga_Beli->Visible) { // Harga Beli ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Harga_Beli) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Harga_Beli" class="pembelian_2D_detail_Harga_Beli"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Harga_Beli->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pembelian_2D_detail->SortUrl($pembelian_2D_detail->Harga_Beli) ?>',1);"><div id="elh_pembelian_2D_detail_Harga_Beli" class="pembelian_2D_detail_Harga_Beli">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Harga_Beli->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Harga_Beli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Harga_Beli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Jumlah->Visible) { // Jumlah ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Jumlah) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Jumlah" class="pembelian_2D_detail_Jumlah"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Jumlah->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pembelian_2D_detail->SortUrl($pembelian_2D_detail->Jumlah) ?>',1);"><div id="elh_pembelian_2D_detail_Jumlah" class="pembelian_2D_detail_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($pembelian_2D_detail->Total_HP->Visible) { // Total HP ?>
	<?php if ($pembelian_2D_detail->SortUrl($pembelian_2D_detail->Total_HP) == "") { ?>
		<td><div id="elh_pembelian_2D_detail_Total_HP" class="pembelian_2D_detail_Total_HP"><div class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Total_HP->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pembelian_2D_detail->SortUrl($pembelian_2D_detail->Total_HP) ?>',1);"><div id="elh_pembelian_2D_detail_Total_HP" class="pembelian_2D_detail_Total_HP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pembelian_2D_detail->Total_HP->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pembelian_2D_detail->Total_HP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pembelian_2D_detail->Total_HP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pembelian_2D_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pembelian_2D_detail->ExportAll && $pembelian_2D_detail->Export <> "") {
	$pembelian_2D_detail_list->StopRec = $pembelian_2D_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pembelian_2D_detail_list->TotalRecs > $pembelian_2D_detail_list->StartRec + $pembelian_2D_detail_list->DisplayRecs - 1)
		$pembelian_2D_detail_list->StopRec = $pembelian_2D_detail_list->StartRec + $pembelian_2D_detail_list->DisplayRecs - 1;
	else
		$pembelian_2D_detail_list->StopRec = $pembelian_2D_detail_list->TotalRecs;
}
$pembelian_2D_detail_list->RecCnt = $pembelian_2D_detail_list->StartRec - 1;
if ($pembelian_2D_detail_list->Recordset && !$pembelian_2D_detail_list->Recordset->EOF) {
	$pembelian_2D_detail_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $pembelian_2D_detail_list->StartRec > 1)
		$pembelian_2D_detail_list->Recordset->Move($pembelian_2D_detail_list->StartRec - 1);
} elseif (!$pembelian_2D_detail->AllowAddDeleteRow && $pembelian_2D_detail_list->StopRec == 0) {
	$pembelian_2D_detail_list->StopRec = $pembelian_2D_detail->GridAddRowCount;
}

// Initialize aggregate
$pembelian_2D_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pembelian_2D_detail->ResetAttrs();
$pembelian_2D_detail_list->RenderRow();
while ($pembelian_2D_detail_list->RecCnt < $pembelian_2D_detail_list->StopRec) {
	$pembelian_2D_detail_list->RecCnt++;
	if (intval($pembelian_2D_detail_list->RecCnt) >= intval($pembelian_2D_detail_list->StartRec)) {
		$pembelian_2D_detail_list->RowCnt++;

		// Set up key count
		$pembelian_2D_detail_list->KeyCount = $pembelian_2D_detail_list->RowIndex;

		// Init row class and style
		$pembelian_2D_detail->ResetAttrs();
		$pembelian_2D_detail->CssClass = "";
		if ($pembelian_2D_detail->CurrentAction == "gridadd") {
		} else {
			$pembelian_2D_detail_list->LoadRowValues($pembelian_2D_detail_list->Recordset); // Load row values
		}
		$pembelian_2D_detail->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$pembelian_2D_detail->RowAttrs = array_merge($pembelian_2D_detail->RowAttrs, array('data-rowindex'=>$pembelian_2D_detail_list->RowCnt, 'id'=>'r' . $pembelian_2D_detail_list->RowCnt . '_pembelian_2D_detail', 'data-rowtype'=>$pembelian_2D_detail->RowType));

		// Render row
		$pembelian_2D_detail_list->RenderRow();

		// Render list options
		$pembelian_2D_detail_list->RenderListOptions();
?>
	<tr<?php echo $pembelian_2D_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pembelian_2D_detail_list->ListOptions->Render("body", "left", $pembelian_2D_detail_list->RowCnt);
?>
	<?php if ($pembelian_2D_detail->Kode->Visible) { // Kode ?>
		<td<?php echo $pembelian_2D_detail->Kode->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_list->RowCnt ?>_pembelian_2D_detail_Kode" class="control-group pembelian_2D_detail_Kode">
<span<?php echo $pembelian_2D_detail->Kode->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Kode->ListViewValue() ?></span>
</span><a id="<?php echo $pembelian_2D_detail_list->PageObjName . "_row_" . $pembelian_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Nama_Barang->Visible) { // Nama Barang ?>
		<td<?php echo $pembelian_2D_detail->Nama_Barang->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_list->RowCnt ?>_pembelian_2D_detail_Nama_Barang" class="control-group pembelian_2D_detail_Nama_Barang">
<span<?php echo $pembelian_2D_detail->Nama_Barang->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Nama_Barang->ListViewValue() ?></span>
</span><a id="<?php echo $pembelian_2D_detail_list->PageObjName . "_row_" . $pembelian_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Satuan->Visible) { // Satuan ?>
		<td<?php echo $pembelian_2D_detail->Satuan->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_list->RowCnt ?>_pembelian_2D_detail_Satuan" class="control-group pembelian_2D_detail_Satuan">
<span<?php echo $pembelian_2D_detail->Satuan->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Satuan->ListViewValue() ?></span>
</span><a id="<?php echo $pembelian_2D_detail_list->PageObjName . "_row_" . $pembelian_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Harga_Beli->Visible) { // Harga Beli ?>
		<td<?php echo $pembelian_2D_detail->Harga_Beli->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_list->RowCnt ?>_pembelian_2D_detail_Harga_Beli" class="control-group pembelian_2D_detail_Harga_Beli">
<span<?php echo $pembelian_2D_detail->Harga_Beli->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Harga_Beli->ListViewValue() ?></span>
</span><a id="<?php echo $pembelian_2D_detail_list->PageObjName . "_row_" . $pembelian_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Jumlah->Visible) { // Jumlah ?>
		<td<?php echo $pembelian_2D_detail->Jumlah->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_list->RowCnt ?>_pembelian_2D_detail_Jumlah" class="control-group pembelian_2D_detail_Jumlah">
<span<?php echo $pembelian_2D_detail->Jumlah->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Jumlah->ListViewValue() ?></span>
</span><a id="<?php echo $pembelian_2D_detail_list->PageObjName . "_row_" . $pembelian_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pembelian_2D_detail->Total_HP->Visible) { // Total HP ?>
		<td<?php echo $pembelian_2D_detail->Total_HP->CellAttributes() ?>><span id="el<?php echo $pembelian_2D_detail_list->RowCnt ?>_pembelian_2D_detail_Total_HP" class="control-group pembelian_2D_detail_Total_HP">
<span<?php echo $pembelian_2D_detail->Total_HP->ViewAttributes() ?>>
<?php echo $pembelian_2D_detail->Total_HP->ListViewValue() ?></span>
</span><a id="<?php echo $pembelian_2D_detail_list->PageObjName . "_row_" . $pembelian_2D_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$pembelian_2D_detail_list->ListOptions->Render("body", "right", $pembelian_2D_detail_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($pembelian_2D_detail->CurrentAction <> "gridadd")
		$pembelian_2D_detail_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($pembelian_2D_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($pembelian_2D_detail_list->Recordset)
	$pembelian_2D_detail_list->Recordset->Close();
?>
<?php if ($pembelian_2D_detail->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($pembelian_2D_detail->CurrentAction <> "gridadd" && $pembelian_2D_detail->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($pembelian_2D_detail_list->Pager)) $pembelian_2D_detail_list->Pager = new cNumericPager($pembelian_2D_detail_list->StartRec, $pembelian_2D_detail_list->DisplayRecs, $pembelian_2D_detail_list->TotalRecs, $pembelian_2D_detail_list->RecRange) ?>
<?php if ($pembelian_2D_detail_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($pembelian_2D_detail_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $pembelian_2D_detail_list->PageUrl() ?>start=<?php echo $pembelian_2D_detail_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($pembelian_2D_detail_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $pembelian_2D_detail_list->PageUrl() ?>start=<?php echo $pembelian_2D_detail_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($pembelian_2D_detail_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $pembelian_2D_detail_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($pembelian_2D_detail_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $pembelian_2D_detail_list->PageUrl() ?>start=<?php echo $pembelian_2D_detail_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($pembelian_2D_detail_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $pembelian_2D_detail_list->PageUrl() ?>start=<?php echo $pembelian_2D_detail_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($pembelian_2D_detail_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pembelian_2D_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pembelian_2D_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pembelian_2D_detail_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($pembelian_2D_detail_list->SearchWhere == "0=101") { ?>
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
	foreach ($pembelian_2D_detail_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($pembelian_2D_detail->Export == "") { ?>
<script type="text/javascript">
fpembelian_2D_detaillist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$pembelian_2D_detail_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($pembelian_2D_detail->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pembelian_2D_detail_list->Page_Terminate();
?>

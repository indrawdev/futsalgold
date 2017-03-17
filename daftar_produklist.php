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

$daftar_produk_list = NULL; // Initialize page object first

class cdaftar_produk_list extends cdaftar_produk {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'daftar produk';

	// Page object name
	var $PageObjName = 'daftar_produk_list';

	// Grid form hidden field names
	var $FormName = 'fdaftar_produklist';
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

		// Table object (daftar_produk)
		if (!isset($GLOBALS["daftar_produk"])) {
			$GLOBALS["daftar_produk"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["daftar_produk"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "daftar_produkadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "daftar_produkdelete.php";
		$this->MultiUpdateUrl = "daftar_produkupdate.php";

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar produk', TRUE);

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

		// Create form object
		$objForm = new cFormObj();

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

			// Set up Breadcrumb
			$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$this->GridUpdate();
						} else {
							$this->setFailureMessage($gsFormError);
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$this->GridInsert();
						} else {
							$this->setFailureMessage($gsFormError);
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Begin transaction
		$conn->BeginTrans();

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $this->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
		return $bGridUpdate;
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

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->ID->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_Kode") && $objForm->HasValue("o_Kode") && $this->Kode->CurrentValue <> $this->Kode->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nama_Barang") && $objForm->HasValue("o_Nama_Barang") && $this->Nama_Barang->CurrentValue <> $this->Nama_Barang->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Satuan") && $objForm->HasValue("o_Satuan") && $this->Satuan->CurrentValue <> $this->Satuan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Harga_Pokok") && $objForm->HasValue("o_Harga_Pokok") && $this->Harga_Pokok->CurrentValue <> $this->Harga_Pokok->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Harga_Jual") && $objForm->HasValue("o_Harga_Jual") && $this->Harga_Jual->CurrentValue <> $this->Harga_Jual->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Jumlah") && $objForm->HasValue("o_Jumlah") && $this->Jumlah->CurrentValue <> $this->Jumlah->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Supplier") && $objForm->HasValue("o_Supplier") && $this->Supplier->CurrentValue <> $this->Supplier->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Kode, FALSE); // Kode
		$this->BuildSearchSql($sWhere, $this->Nama_Barang, FALSE); // Nama Barang
		$this->BuildSearchSql($sWhere, $this->Satuan, FALSE); // Satuan
		$this->BuildSearchSql($sWhere, $this->Harga_Pokok, FALSE); // Harga Pokok
		$this->BuildSearchSql($sWhere, $this->Harga_Jual, FALSE); // Harga Jual
		$this->BuildSearchSql($sWhere, $this->Jumlah, FALSE); // Jumlah
		$this->BuildSearchSql($sWhere, $this->Supplier, FALSE); // Supplier

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Kode->AdvancedSearch->Save(); // Kode
			$this->Nama_Barang->AdvancedSearch->Save(); // Nama Barang
			$this->Satuan->AdvancedSearch->Save(); // Satuan
			$this->Harga_Pokok->AdvancedSearch->Save(); // Harga Pokok
			$this->Harga_Jual->AdvancedSearch->Save(); // Harga Jual
			$this->Jumlah->AdvancedSearch->Save(); // Jumlah
			$this->Supplier->AdvancedSearch->Save(); // Supplier
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
		$this->BuildBasicSearchSQL($sWhere, $this->Kode, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Nama_Barang, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Satuan, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Supplier, $Keyword);
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
		if ($this->Kode->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nama_Barang->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Satuan->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Harga_Pokok->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Harga_Jual->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Jumlah->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Supplier->AdvancedSearch->IssetSession())
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
		$this->Kode->AdvancedSearch->UnsetSession();
		$this->Nama_Barang->AdvancedSearch->UnsetSession();
		$this->Satuan->AdvancedSearch->UnsetSession();
		$this->Harga_Pokok->AdvancedSearch->UnsetSession();
		$this->Harga_Jual->AdvancedSearch->UnsetSession();
		$this->Jumlah->AdvancedSearch->UnsetSession();
		$this->Supplier->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Kode->AdvancedSearch->Load();
		$this->Nama_Barang->AdvancedSearch->Load();
		$this->Satuan->AdvancedSearch->Load();
		$this->Harga_Pokok->AdvancedSearch->Load();
		$this->Harga_Jual->AdvancedSearch->Load();
		$this->Jumlah->AdvancedSearch->Load();
		$this->Supplier->AdvancedSearch->Load();
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
			$this->UpdateSort($this->Harga_Pokok); // Harga Pokok
			$this->UpdateSort($this->Harga_Jual); // Harga Jual
			$this->UpdateSort($this->Jumlah); // Jumlah
			$this->UpdateSort($this->Supplier); // Supplier
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
				$this->Kode->setSort("");
				$this->Nama_Barang->setSort("");
				$this->Satuan->setSort("");
				$this->Harga_Pokok->setSort("");
				$this->Harga_Jual->setSort("");
				$this->Jumlah->setSort("");
				$this->Supplier->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->ID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'></label>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->ID->CurrentValue . "\">";
		}
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
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.fdaftar_produklist, '" . $this->MultiDeleteUrl . "');return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fdaftar_produklist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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
		// Kode

		$this->Kode->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Kode"]);
		if ($this->Kode->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Kode->AdvancedSearch->SearchOperator = @$_GET["z_Kode"];

		// Nama Barang
		$this->Nama_Barang->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nama_Barang"]);
		if ($this->Nama_Barang->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nama_Barang->AdvancedSearch->SearchOperator = @$_GET["z_Nama_Barang"];

		// Satuan
		$this->Satuan->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Satuan"]);
		if ($this->Satuan->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Satuan->AdvancedSearch->SearchOperator = @$_GET["z_Satuan"];

		// Harga Pokok
		$this->Harga_Pokok->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Harga_Pokok"]);
		if ($this->Harga_Pokok->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Harga_Pokok->AdvancedSearch->SearchOperator = @$_GET["z_Harga_Pokok"];

		// Harga Jual
		$this->Harga_Jual->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Harga_Jual"]);
		if ($this->Harga_Jual->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Harga_Jual->AdvancedSearch->SearchOperator = @$_GET["z_Harga_Jual"];

		// Jumlah
		$this->Jumlah->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Jumlah"]);
		if ($this->Jumlah->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Jumlah->AdvancedSearch->SearchOperator = @$_GET["z_Jumlah"];

		// Supplier
		$this->Supplier->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Supplier"]);
		if ($this->Supplier->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Supplier->AdvancedSearch->SearchOperator = @$_GET["z_Supplier"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Kode->FldIsDetailKey) {
			$this->Kode->setFormValue($objForm->GetValue("x_Kode"));
		}
		$this->Kode->setOldValue($objForm->GetValue("o_Kode"));
		if (!$this->Nama_Barang->FldIsDetailKey) {
			$this->Nama_Barang->setFormValue($objForm->GetValue("x_Nama_Barang"));
		}
		$this->Nama_Barang->setOldValue($objForm->GetValue("o_Nama_Barang"));
		if (!$this->Satuan->FldIsDetailKey) {
			$this->Satuan->setFormValue($objForm->GetValue("x_Satuan"));
		}
		$this->Satuan->setOldValue($objForm->GetValue("o_Satuan"));
		if (!$this->Harga_Pokok->FldIsDetailKey) {
			$this->Harga_Pokok->setFormValue($objForm->GetValue("x_Harga_Pokok"));
		}
		$this->Harga_Pokok->setOldValue($objForm->GetValue("o_Harga_Pokok"));
		if (!$this->Harga_Jual->FldIsDetailKey) {
			$this->Harga_Jual->setFormValue($objForm->GetValue("x_Harga_Jual"));
		}
		$this->Harga_Jual->setOldValue($objForm->GetValue("o_Harga_Jual"));
		if (!$this->Jumlah->FldIsDetailKey) {
			$this->Jumlah->setFormValue($objForm->GetValue("x_Jumlah"));
		}
		$this->Jumlah->setOldValue($objForm->GetValue("o_Jumlah"));
		if (!$this->Supplier->FldIsDetailKey) {
			$this->Supplier->setFormValue($objForm->GetValue("x_Supplier"));
		}
		$this->Supplier->setOldValue($objForm->GetValue("o_Supplier"));
		if (!$this->ID->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->ID->CurrentValue = $this->ID->FormValue;
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->Nama_Barang->CurrentValue = $this->Nama_Barang->FormValue;
		$this->Satuan->CurrentValue = $this->Satuan->FormValue;
		$this->Harga_Pokok->CurrentValue = $this->Harga_Pokok->FormValue;
		$this->Harga_Jual->CurrentValue = $this->Harga_Jual->FormValue;
		$this->Jumlah->CurrentValue = $this->Jumlah->FormValue;
		$this->Supplier->CurrentValue = $this->Supplier->FormValue;
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

		// TglStok
		$this->TglStok->CellCssStyle = "white-space: nowrap;";

		// Kode
		// Nama Barang
		// Isi

		$this->Isi->CellCssStyle = "white-space: nowrap;";

		// Satuan
		// Berat

		$this->Berat->CellCssStyle = "white-space: nowrap;";

		// Harga Pokok
		// Harga Jual
		// Jumlah
		// Jumlah Total

		$this->Jumlah_Total->CellCssStyle = "white-space: nowrap;";

		// Supplier
		// Departemen

		$this->Departemen->CellCssStyle = "white-space: nowrap;";

		// Foto
		$this->Foto->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->AdvancedSearch->SearchValue);
			$this->Kode->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kode->FldCaption()));

			// Nama Barang
			$this->Nama_Barang->EditCustomAttributes = "";
			$this->Nama_Barang->EditValue = ew_HtmlEncode($this->Nama_Barang->AdvancedSearch->SearchValue);
			$this->Nama_Barang->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Nama_Barang->FldCaption()));

			// Satuan
			$this->Satuan->EditCustomAttributes = "";

			// Harga Pokok
			$this->Harga_Pokok->EditCustomAttributes = "";
			$this->Harga_Pokok->EditValue = ew_HtmlEncode($this->Harga_Pokok->AdvancedSearch->SearchValue);
			$this->Harga_Pokok->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Harga_Pokok->FldCaption()));

			// Harga Jual
			$this->Harga_Jual->EditCustomAttributes = "";
			$this->Harga_Jual->EditValue = ew_HtmlEncode($this->Harga_Jual->AdvancedSearch->SearchValue);
			$this->Harga_Jual->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Harga_Jual->FldCaption()));

			// Jumlah
			$this->Jumlah->EditCustomAttributes = "";
			$this->Jumlah->EditValue = ew_HtmlEncode($this->Jumlah->AdvancedSearch->SearchValue);
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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Kode
			$this->Kode->SetDbValueDef($rsnew, $this->Kode->CurrentValue, "", $this->Kode->ReadOnly);

			// Nama Barang
			$this->Nama_Barang->SetDbValueDef($rsnew, $this->Nama_Barang->CurrentValue, "", $this->Nama_Barang->ReadOnly);

			// Satuan
			$this->Satuan->SetDbValueDef($rsnew, $this->Satuan->CurrentValue, "", $this->Satuan->ReadOnly);

			// Harga Pokok
			$this->Harga_Pokok->SetDbValueDef($rsnew, $this->Harga_Pokok->CurrentValue, 0, $this->Harga_Pokok->ReadOnly);

			// Harga Jual
			$this->Harga_Jual->SetDbValueDef($rsnew, $this->Harga_Jual->CurrentValue, 0, $this->Harga_Jual->ReadOnly);

			// Jumlah
			$this->Jumlah->SetDbValueDef($rsnew, $this->Jumlah->CurrentValue, 0, $this->Jumlah->ReadOnly);

			// Supplier
			$this->Supplier->SetDbValueDef($rsnew, $this->Supplier->CurrentValue, "", $this->Supplier->ReadOnly);

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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Kode->AdvancedSearch->Load();
		$this->Nama_Barang->AdvancedSearch->Load();
		$this->Satuan->AdvancedSearch->Load();
		$this->Harga_Pokok->AdvancedSearch->Load();
		$this->Harga_Jual->AdvancedSearch->Load();
		$this->Jumlah->AdvancedSearch->Load();
		$this->Supplier->AdvancedSearch->Load();
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
		$item->Body = "<a id=\"emf_daftar_produk\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_daftar_produk',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fdaftar_produklist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
		$this->AddSearchQueryString($sQry, $this->Kode); // Kode
		$this->AddSearchQueryString($sQry, $this->Nama_Barang); // Nama Barang
		$this->AddSearchQueryString($sQry, $this->Satuan); // Satuan
		$this->AddSearchQueryString($sQry, $this->Harga_Pokok); // Harga Pokok
		$this->AddSearchQueryString($sQry, $this->Harga_Jual); // Harga Jual
		$this->AddSearchQueryString($sQry, $this->Jumlah); // Jumlah
		$this->AddSearchQueryString($sQry, $this->Supplier); // Supplier

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
if (!isset($daftar_produk_list)) $daftar_produk_list = new cdaftar_produk_list();

// Page init
$daftar_produk_list->Page_Init();

// Page main
$daftar_produk_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$daftar_produk_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($daftar_produk->Export == "") { ?>
<script type="text/javascript">

// Page object
var daftar_produk_list = new ew_Page("daftar_produk_list");
daftar_produk_list.PageID = "list"; // Page ID
var EW_PAGE_ID = daftar_produk_list.PageID; // For backward compatibility

// Form object
var fdaftar_produklist = new ew_Form("fdaftar_produklist");
fdaftar_produklist.FormKeyCountName = '<?php echo $daftar_produk_list->FormKeyCountName ?>';

// Validate form
fdaftar_produklist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
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
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fdaftar_produklist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Kode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nama_Barang", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Satuan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Harga_Pokok", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Harga_Jual", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Jumlah", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Supplier", false)) return false;
	return true;
}

// Form_CustomValidate event
fdaftar_produklist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdaftar_produklist.ValidateRequired = true;
<?php } else { ?>
fdaftar_produklist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdaftar_produklist.Lists["x_Satuan"] = {"LinkField":"x_Satuan","Ajax":null,"AutoFill":false,"DisplayFields":["x_Satuan","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdaftar_produklist.Lists["x_Supplier"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fdaftar_produklistsrch = new ew_Form("fdaftar_produklistsrch");

// Validate function for search
fdaftar_produklistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";

	// Set up row object
	ew_ElementsToRow(fobj);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fdaftar_produklistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdaftar_produklistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fdaftar_produklistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
fdaftar_produklistsrch.Lists["x_Supplier"] = {"LinkField":"x_Kode","Ajax":null,"AutoFill":false,"DisplayFields":["x_Kode","x_Nama","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($daftar_produk->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($daftar_produk_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $daftar_produk_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($daftar_produk->CurrentAction == "gridadd") {
	$daftar_produk->CurrentFilter = "0=1";
	$daftar_produk_list->StartRec = 1;
	$daftar_produk_list->DisplayRecs = $daftar_produk->GridAddRowCount;
	$daftar_produk_list->TotalRecs = $daftar_produk_list->DisplayRecs;
	$daftar_produk_list->StopRec = $daftar_produk_list->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$daftar_produk_list->TotalRecs = $daftar_produk->SelectRecordCount();
	} else {
		if ($daftar_produk_list->Recordset = $daftar_produk_list->LoadRecordset())
			$daftar_produk_list->TotalRecs = $daftar_produk_list->Recordset->RecordCount();
	}
	$daftar_produk_list->StartRec = 1;
	if ($daftar_produk_list->DisplayRecs <= 0 || ($daftar_produk->Export <> "" && $daftar_produk->ExportAll)) // Display all records
		$daftar_produk_list->DisplayRecs = $daftar_produk_list->TotalRecs;
	if (!($daftar_produk->Export <> "" && $daftar_produk->ExportAll))
		$daftar_produk_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$daftar_produk_list->Recordset = $daftar_produk_list->LoadRecordset($daftar_produk_list->StartRec-1, $daftar_produk_list->DisplayRecs);
}
$daftar_produk_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($daftar_produk->Export == "" && $daftar_produk->CurrentAction == "") { ?>
<form name="fdaftar_produklistsrch" id="fdaftar_produklistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="fdaftar_produklistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#fdaftar_produklistsrch_SearchGroup" href="#fdaftar_produklistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="fdaftar_produklistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="fdaftar_produklistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="daftar_produk">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$daftar_produk_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$daftar_produk->RowType = EW_ROWTYPE_SEARCH;

// Render row
$daftar_produk->ResetAttrs();
$daftar_produk_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($daftar_produk->Supplier->Visible) { // Supplier ?>
	<span id="xsc_Supplier" class="ewCell">
		<span class="ewSearchCaption"><?php echo $daftar_produk->Supplier->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Supplier" id="z_Supplier" value="LIKE"></span>
		<span class="control-group ewSearchField">
<select data-field="x_Supplier" id="x_Supplier" name="x_Supplier"<?php echo $daftar_produk->Supplier->EditAttributes() ?>>
<?php
if (is_array($daftar_produk->Supplier->EditValue)) {
	$arwrk = $daftar_produk->Supplier->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($daftar_produk->Supplier->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
if (@$emptywrk) $daftar_produk->Supplier->OldValue = "";
?>
</select>
<script type="text/javascript">
fdaftar_produklistsrch.Lists["x_Supplier"].Options = <?php echo (is_array($daftar_produk->Supplier->EditValue)) ? ew_ArrayToJson($daftar_produk->Supplier->EditValue, 1) : "[]" ?>;
</script>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($daftar_produk_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $daftar_produk_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_3" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($daftar_produk_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($daftar_produk_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($daftar_produk_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php $daftar_produk_list->ShowPageHeader(); ?>
<?php
$daftar_produk_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fdaftar_produklist" id="fdaftar_produklist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="daftar_produk">
<div id="gmp_daftar_produk" class="ewGridMiddlePanel">
<?php if ($daftar_produk_list->TotalRecs > 0) { ?>
<table id="tbl_daftar_produklist" class="ewTable ewTableSeparate">
<?php echo $daftar_produk->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$daftar_produk_list->RenderListOptions();

// Render list options (header, left)
$daftar_produk_list->ListOptions->Render("header", "left");
?>
<?php if ($daftar_produk->Kode->Visible) { // Kode ?>
	<?php if ($daftar_produk->SortUrl($daftar_produk->Kode) == "") { ?>
		<td><div id="elh_daftar_produk_Kode" class="daftar_produk_Kode"><div class="ewTableHeaderCaption"><?php echo $daftar_produk->Kode->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_produk->SortUrl($daftar_produk->Kode) ?>',1);"><div id="elh_daftar_produk_Kode" class="daftar_produk_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_produk->Kode->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($daftar_produk->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_produk->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_produk->Nama_Barang->Visible) { // Nama Barang ?>
	<?php if ($daftar_produk->SortUrl($daftar_produk->Nama_Barang) == "") { ?>
		<td><div id="elh_daftar_produk_Nama_Barang" class="daftar_produk_Nama_Barang"><div class="ewTableHeaderCaption"><?php echo $daftar_produk->Nama_Barang->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_produk->SortUrl($daftar_produk->Nama_Barang) ?>',1);"><div id="elh_daftar_produk_Nama_Barang" class="daftar_produk_Nama_Barang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_produk->Nama_Barang->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($daftar_produk->Nama_Barang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_produk->Nama_Barang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_produk->Satuan->Visible) { // Satuan ?>
	<?php if ($daftar_produk->SortUrl($daftar_produk->Satuan) == "") { ?>
		<td><div id="elh_daftar_produk_Satuan" class="daftar_produk_Satuan"><div class="ewTableHeaderCaption"><?php echo $daftar_produk->Satuan->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_produk->SortUrl($daftar_produk->Satuan) ?>',1);"><div id="elh_daftar_produk_Satuan" class="daftar_produk_Satuan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_produk->Satuan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_produk->Satuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_produk->Satuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_produk->Harga_Pokok->Visible) { // Harga Pokok ?>
	<?php if ($daftar_produk->SortUrl($daftar_produk->Harga_Pokok) == "") { ?>
		<td><div id="elh_daftar_produk_Harga_Pokok" class="daftar_produk_Harga_Pokok"><div class="ewTableHeaderCaption"><?php echo $daftar_produk->Harga_Pokok->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_produk->SortUrl($daftar_produk->Harga_Pokok) ?>',1);"><div id="elh_daftar_produk_Harga_Pokok" class="daftar_produk_Harga_Pokok">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_produk->Harga_Pokok->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_produk->Harga_Pokok->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_produk->Harga_Pokok->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_produk->Harga_Jual->Visible) { // Harga Jual ?>
	<?php if ($daftar_produk->SortUrl($daftar_produk->Harga_Jual) == "") { ?>
		<td><div id="elh_daftar_produk_Harga_Jual" class="daftar_produk_Harga_Jual"><div class="ewTableHeaderCaption"><?php echo $daftar_produk->Harga_Jual->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_produk->SortUrl($daftar_produk->Harga_Jual) ?>',1);"><div id="elh_daftar_produk_Harga_Jual" class="daftar_produk_Harga_Jual">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_produk->Harga_Jual->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_produk->Harga_Jual->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_produk->Harga_Jual->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_produk->Jumlah->Visible) { // Jumlah ?>
	<?php if ($daftar_produk->SortUrl($daftar_produk->Jumlah) == "") { ?>
		<td><div id="elh_daftar_produk_Jumlah" class="daftar_produk_Jumlah"><div class="ewTableHeaderCaption"><?php echo $daftar_produk->Jumlah->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_produk->SortUrl($daftar_produk->Jumlah) ?>',1);"><div id="elh_daftar_produk_Jumlah" class="daftar_produk_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_produk->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_produk->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_produk->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_produk->Supplier->Visible) { // Supplier ?>
	<?php if ($daftar_produk->SortUrl($daftar_produk->Supplier) == "") { ?>
		<td><div id="elh_daftar_produk_Supplier" class="daftar_produk_Supplier"><div class="ewTableHeaderCaption"><?php echo $daftar_produk->Supplier->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_produk->SortUrl($daftar_produk->Supplier) ?>',1);"><div id="elh_daftar_produk_Supplier" class="daftar_produk_Supplier">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_produk->Supplier->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_produk->Supplier->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_produk->Supplier->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$daftar_produk_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($daftar_produk->ExportAll && $daftar_produk->Export <> "") {
	$daftar_produk_list->StopRec = $daftar_produk_list->TotalRecs;
} else {

	// Set the last record to display
	if ($daftar_produk_list->TotalRecs > $daftar_produk_list->StartRec + $daftar_produk_list->DisplayRecs - 1)
		$daftar_produk_list->StopRec = $daftar_produk_list->StartRec + $daftar_produk_list->DisplayRecs - 1;
	else
		$daftar_produk_list->StopRec = $daftar_produk_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($daftar_produk_list->FormKeyCountName) && ($daftar_produk->CurrentAction == "gridadd" || $daftar_produk->CurrentAction == "gridedit" || $daftar_produk->CurrentAction == "F")) {
		$daftar_produk_list->KeyCount = $objForm->GetValue($daftar_produk_list->FormKeyCountName);
		$daftar_produk_list->StopRec = $daftar_produk_list->StartRec + $daftar_produk_list->KeyCount - 1;
	}
}
$daftar_produk_list->RecCnt = $daftar_produk_list->StartRec - 1;
if ($daftar_produk_list->Recordset && !$daftar_produk_list->Recordset->EOF) {
	$daftar_produk_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $daftar_produk_list->StartRec > 1)
		$daftar_produk_list->Recordset->Move($daftar_produk_list->StartRec - 1);
} elseif (!$daftar_produk->AllowAddDeleteRow && $daftar_produk_list->StopRec == 0) {
	$daftar_produk_list->StopRec = $daftar_produk->GridAddRowCount;
}

// Initialize aggregate
$daftar_produk->RowType = EW_ROWTYPE_AGGREGATEINIT;
$daftar_produk->ResetAttrs();
$daftar_produk_list->RenderRow();
if ($daftar_produk->CurrentAction == "gridadd")
	$daftar_produk_list->RowIndex = 0;
if ($daftar_produk->CurrentAction == "gridedit")
	$daftar_produk_list->RowIndex = 0;
while ($daftar_produk_list->RecCnt < $daftar_produk_list->StopRec) {
	$daftar_produk_list->RecCnt++;
	if (intval($daftar_produk_list->RecCnt) >= intval($daftar_produk_list->StartRec)) {
		$daftar_produk_list->RowCnt++;
		if ($daftar_produk->CurrentAction == "gridadd" || $daftar_produk->CurrentAction == "gridedit" || $daftar_produk->CurrentAction == "F") {
			$daftar_produk_list->RowIndex++;
			$objForm->Index = $daftar_produk_list->RowIndex;
			if ($objForm->HasValue($daftar_produk_list->FormActionName))
				$daftar_produk_list->RowAction = strval($objForm->GetValue($daftar_produk_list->FormActionName));
			elseif ($daftar_produk->CurrentAction == "gridadd")
				$daftar_produk_list->RowAction = "insert";
			else
				$daftar_produk_list->RowAction = "";
		}

		// Set up key count
		$daftar_produk_list->KeyCount = $daftar_produk_list->RowIndex;

		// Init row class and style
		$daftar_produk->ResetAttrs();
		$daftar_produk->CssClass = "";
		if ($daftar_produk->CurrentAction == "gridadd") {
			$daftar_produk_list->LoadDefaultValues(); // Load default values
		} else {
			$daftar_produk_list->LoadRowValues($daftar_produk_list->Recordset); // Load row values
		}
		$daftar_produk->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($daftar_produk->CurrentAction == "gridadd") // Grid add
			$daftar_produk->RowType = EW_ROWTYPE_ADD; // Render add
		if ($daftar_produk->CurrentAction == "gridadd" && $daftar_produk->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$daftar_produk_list->RestoreCurrentRowFormValues($daftar_produk_list->RowIndex); // Restore form values
		if ($daftar_produk->CurrentAction == "gridedit") { // Grid edit
			if ($daftar_produk->EventCancelled) {
				$daftar_produk_list->RestoreCurrentRowFormValues($daftar_produk_list->RowIndex); // Restore form values
			}
			if ($daftar_produk_list->RowAction == "insert")
				$daftar_produk->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$daftar_produk->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($daftar_produk->CurrentAction == "gridedit" && ($daftar_produk->RowType == EW_ROWTYPE_EDIT || $daftar_produk->RowType == EW_ROWTYPE_ADD) && $daftar_produk->EventCancelled) // Update failed
			$daftar_produk_list->RestoreCurrentRowFormValues($daftar_produk_list->RowIndex); // Restore form values
		if ($daftar_produk->RowType == EW_ROWTYPE_EDIT) // Edit row
			$daftar_produk_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$daftar_produk->RowAttrs = array_merge($daftar_produk->RowAttrs, array('data-rowindex'=>$daftar_produk_list->RowCnt, 'id'=>'r' . $daftar_produk_list->RowCnt . '_daftar_produk', 'data-rowtype'=>$daftar_produk->RowType));

		// Render row
		$daftar_produk_list->RenderRow();

		// Render list options
		$daftar_produk_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($daftar_produk_list->RowAction <> "delete" && $daftar_produk_list->RowAction <> "insertdelete" && !($daftar_produk_list->RowAction == "insert" && $daftar_produk->CurrentAction == "F" && $daftar_produk_list->EmptyRow())) {
?>
	<tr<?php echo $daftar_produk->RowAttributes() ?>>
<?php

// Render list options (body, left)
$daftar_produk_list->ListOptions->Render("body", "left", $daftar_produk_list->RowCnt);
?>
	<?php if ($daftar_produk->Kode->Visible) { // Kode ?>
		<td<?php echo $daftar_produk->Kode->CellAttributes() ?>><span id="el<?php echo $daftar_produk_list->RowCnt ?>_daftar_produk_Kode" class="control-group daftar_produk_Kode">
<?php if ($daftar_produk->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Kode" name="x<?php echo $daftar_produk_list->RowIndex ?>_Kode" id="x<?php echo $daftar_produk_list->RowIndex ?>_Kode" size="30" maxlength="255" placeholder="<?php echo $daftar_produk->Kode->PlaceHolder ?>" value="<?php echo $daftar_produk->Kode->EditValue ?>"<?php echo $daftar_produk->Kode->EditAttributes() ?>>
<input type="hidden" data-field="x_Kode" name="o<?php echo $daftar_produk_list->RowIndex ?>_Kode" id="o<?php echo $daftar_produk_list->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($daftar_produk->Kode->OldValue) ?>">
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Kode" name="x<?php echo $daftar_produk_list->RowIndex ?>_Kode" id="x<?php echo $daftar_produk_list->RowIndex ?>_Kode" size="30" maxlength="255" placeholder="<?php echo $daftar_produk->Kode->PlaceHolder ?>" value="<?php echo $daftar_produk->Kode->EditValue ?>"<?php echo $daftar_produk->Kode->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_produk->Kode->ViewAttributes() ?>>
<?php echo $daftar_produk->Kode->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_produk_list->PageObjName . "_row_" . $daftar_produk_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $daftar_produk_list->RowIndex ?>_ID" id="x<?php echo $daftar_produk_list->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($daftar_produk->ID->CurrentValue) ?>">
<input type="hidden" data-field="x_ID" name="o<?php echo $daftar_produk_list->RowIndex ?>_ID" id="o<?php echo $daftar_produk_list->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($daftar_produk->ID->OldValue) ?>">
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_EDIT || $daftar_produk->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $daftar_produk_list->RowIndex ?>_ID" id="x<?php echo $daftar_produk_list->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($daftar_produk->ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($daftar_produk->Nama_Barang->Visible) { // Nama Barang ?>
		<td<?php echo $daftar_produk->Nama_Barang->CellAttributes() ?>><span id="el<?php echo $daftar_produk_list->RowCnt ?>_daftar_produk_Nama_Barang" class="control-group daftar_produk_Nama_Barang">
<?php if ($daftar_produk->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Nama_Barang" name="x<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" id="x<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" size="30" maxlength="255" placeholder="<?php echo $daftar_produk->Nama_Barang->PlaceHolder ?>" value="<?php echo $daftar_produk->Nama_Barang->EditValue ?>"<?php echo $daftar_produk->Nama_Barang->EditAttributes() ?>>
<input type="hidden" data-field="x_Nama_Barang" name="o<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" id="o<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" value="<?php echo ew_HtmlEncode($daftar_produk->Nama_Barang->OldValue) ?>">
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Nama_Barang" name="x<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" id="x<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" size="30" maxlength="255" placeholder="<?php echo $daftar_produk->Nama_Barang->PlaceHolder ?>" value="<?php echo $daftar_produk->Nama_Barang->EditValue ?>"<?php echo $daftar_produk->Nama_Barang->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_produk->Nama_Barang->ViewAttributes() ?>>
<?php echo $daftar_produk->Nama_Barang->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_produk_list->PageObjName . "_row_" . $daftar_produk_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_produk->Satuan->Visible) { // Satuan ?>
		<td<?php echo $daftar_produk->Satuan->CellAttributes() ?>><span id="el<?php echo $daftar_produk_list->RowCnt ?>_daftar_produk_Satuan" class="control-group daftar_produk_Satuan">
<?php if ($daftar_produk->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select data-field="x_Satuan" id="x<?php echo $daftar_produk_list->RowIndex ?>_Satuan" name="x<?php echo $daftar_produk_list->RowIndex ?>_Satuan"<?php echo $daftar_produk->Satuan->EditAttributes() ?>>
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
if (@$emptywrk) $daftar_produk->Satuan->OldValue = "";
?>
</select>
<script type="text/javascript">
fdaftar_produklist.Lists["x_Satuan"].Options = <?php echo (is_array($daftar_produk->Satuan->EditValue)) ? ew_ArrayToJson($daftar_produk->Satuan->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" data-field="x_Satuan" name="o<?php echo $daftar_produk_list->RowIndex ?>_Satuan" id="o<?php echo $daftar_produk_list->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($daftar_produk->Satuan->OldValue) ?>">
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select data-field="x_Satuan" id="x<?php echo $daftar_produk_list->RowIndex ?>_Satuan" name="x<?php echo $daftar_produk_list->RowIndex ?>_Satuan"<?php echo $daftar_produk->Satuan->EditAttributes() ?>>
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
if (@$emptywrk) $daftar_produk->Satuan->OldValue = "";
?>
</select>
<script type="text/javascript">
fdaftar_produklist.Lists["x_Satuan"].Options = <?php echo (is_array($daftar_produk->Satuan->EditValue)) ? ew_ArrayToJson($daftar_produk->Satuan->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_produk->Satuan->ViewAttributes() ?>>
<?php echo $daftar_produk->Satuan->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_produk_list->PageObjName . "_row_" . $daftar_produk_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_produk->Harga_Pokok->Visible) { // Harga Pokok ?>
		<td<?php echo $daftar_produk->Harga_Pokok->CellAttributes() ?>><span id="el<?php echo $daftar_produk_list->RowCnt ?>_daftar_produk_Harga_Pokok" class="control-group daftar_produk_Harga_Pokok">
<?php if ($daftar_produk->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Harga_Pokok" name="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" id="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" size="30" placeholder="<?php echo $daftar_produk->Harga_Pokok->PlaceHolder ?>" value="<?php echo $daftar_produk->Harga_Pokok->EditValue ?>"<?php echo $daftar_produk->Harga_Pokok->EditAttributes() ?>>
<input type="hidden" data-field="x_Harga_Pokok" name="o<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" id="o<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" value="<?php echo ew_HtmlEncode($daftar_produk->Harga_Pokok->OldValue) ?>">
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Harga_Pokok" name="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" id="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" size="30" placeholder="<?php echo $daftar_produk->Harga_Pokok->PlaceHolder ?>" value="<?php echo $daftar_produk->Harga_Pokok->EditValue ?>"<?php echo $daftar_produk->Harga_Pokok->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_produk->Harga_Pokok->ViewAttributes() ?>>
<?php echo $daftar_produk->Harga_Pokok->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_produk_list->PageObjName . "_row_" . $daftar_produk_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_produk->Harga_Jual->Visible) { // Harga Jual ?>
		<td<?php echo $daftar_produk->Harga_Jual->CellAttributes() ?>><span id="el<?php echo $daftar_produk_list->RowCnt ?>_daftar_produk_Harga_Jual" class="control-group daftar_produk_Harga_Jual">
<?php if ($daftar_produk->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Harga_Jual" name="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" id="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" size="30" placeholder="<?php echo $daftar_produk->Harga_Jual->PlaceHolder ?>" value="<?php echo $daftar_produk->Harga_Jual->EditValue ?>"<?php echo $daftar_produk->Harga_Jual->EditAttributes() ?>>
<input type="hidden" data-field="x_Harga_Jual" name="o<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" id="o<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" value="<?php echo ew_HtmlEncode($daftar_produk->Harga_Jual->OldValue) ?>">
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Harga_Jual" name="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" id="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" size="30" placeholder="<?php echo $daftar_produk->Harga_Jual->PlaceHolder ?>" value="<?php echo $daftar_produk->Harga_Jual->EditValue ?>"<?php echo $daftar_produk->Harga_Jual->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_produk->Harga_Jual->ViewAttributes() ?>>
<?php echo $daftar_produk->Harga_Jual->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_produk_list->PageObjName . "_row_" . $daftar_produk_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_produk->Jumlah->Visible) { // Jumlah ?>
		<td<?php echo $daftar_produk->Jumlah->CellAttributes() ?>><span id="el<?php echo $daftar_produk_list->RowCnt ?>_daftar_produk_Jumlah" class="control-group daftar_produk_Jumlah">
<?php if ($daftar_produk->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Jumlah" name="x<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" id="x<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo $daftar_produk->Jumlah->PlaceHolder ?>" value="<?php echo $daftar_produk->Jumlah->EditValue ?>"<?php echo $daftar_produk->Jumlah->EditAttributes() ?>>
<input type="hidden" data-field="x_Jumlah" name="o<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" id="o<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($daftar_produk->Jumlah->OldValue) ?>">
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Jumlah" name="x<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" id="x<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo $daftar_produk->Jumlah->PlaceHolder ?>" value="<?php echo $daftar_produk->Jumlah->EditValue ?>"<?php echo $daftar_produk->Jumlah->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_produk->Jumlah->ViewAttributes() ?>>
<?php echo $daftar_produk->Jumlah->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_produk_list->PageObjName . "_row_" . $daftar_produk_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_produk->Supplier->Visible) { // Supplier ?>
		<td<?php echo $daftar_produk->Supplier->CellAttributes() ?>><span id="el<?php echo $daftar_produk_list->RowCnt ?>_daftar_produk_Supplier" class="control-group daftar_produk_Supplier">
<?php if ($daftar_produk->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select data-field="x_Supplier" id="x<?php echo $daftar_produk_list->RowIndex ?>_Supplier" name="x<?php echo $daftar_produk_list->RowIndex ?>_Supplier"<?php echo $daftar_produk->Supplier->EditAttributes() ?>>
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
if (@$emptywrk) $daftar_produk->Supplier->OldValue = "";
?>
</select>
<script type="text/javascript">
fdaftar_produklist.Lists["x_Supplier"].Options = <?php echo (is_array($daftar_produk->Supplier->EditValue)) ? ew_ArrayToJson($daftar_produk->Supplier->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" data-field="x_Supplier" name="o<?php echo $daftar_produk_list->RowIndex ?>_Supplier" id="o<?php echo $daftar_produk_list->RowIndex ?>_Supplier" value="<?php echo ew_HtmlEncode($daftar_produk->Supplier->OldValue) ?>">
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select data-field="x_Supplier" id="x<?php echo $daftar_produk_list->RowIndex ?>_Supplier" name="x<?php echo $daftar_produk_list->RowIndex ?>_Supplier"<?php echo $daftar_produk->Supplier->EditAttributes() ?>>
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
if (@$emptywrk) $daftar_produk->Supplier->OldValue = "";
?>
</select>
<script type="text/javascript">
fdaftar_produklist.Lists["x_Supplier"].Options = <?php echo (is_array($daftar_produk->Supplier->EditValue)) ? ew_ArrayToJson($daftar_produk->Supplier->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_produk->Supplier->ViewAttributes() ?>>
<?php echo $daftar_produk->Supplier->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_produk_list->PageObjName . "_row_" . $daftar_produk_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$daftar_produk_list->ListOptions->Render("body", "right", $daftar_produk_list->RowCnt);
?>
	</tr>
<?php if ($daftar_produk->RowType == EW_ROWTYPE_ADD || $daftar_produk->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdaftar_produklist.UpdateOpts(<?php echo $daftar_produk_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($daftar_produk->CurrentAction <> "gridadd")
		if (!$daftar_produk_list->Recordset->EOF) $daftar_produk_list->Recordset->MoveNext();
}
?>
<?php
	if ($daftar_produk->CurrentAction == "gridadd" || $daftar_produk->CurrentAction == "gridedit") {
		$daftar_produk_list->RowIndex = '$rowindex$';
		$daftar_produk_list->LoadDefaultValues();

		// Set row properties
		$daftar_produk->ResetAttrs();
		$daftar_produk->RowAttrs = array_merge($daftar_produk->RowAttrs, array('data-rowindex'=>$daftar_produk_list->RowIndex, 'id'=>'r0_daftar_produk', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($daftar_produk->RowAttrs["class"], "ewTemplate");
		$daftar_produk->RowType = EW_ROWTYPE_ADD;

		// Render row
		$daftar_produk_list->RenderRow();

		// Render list options
		$daftar_produk_list->RenderListOptions();
		$daftar_produk_list->StartRowCnt = 0;
?>
	<tr<?php echo $daftar_produk->RowAttributes() ?>>
<?php

// Render list options (body, left)
$daftar_produk_list->ListOptions->Render("body", "left", $daftar_produk_list->RowIndex);
?>
	<?php if ($daftar_produk->Kode->Visible) { // Kode ?>
		<td><span id="el$rowindex$_daftar_produk_Kode" class="control-group daftar_produk_Kode">
<input type="text" data-field="x_Kode" name="x<?php echo $daftar_produk_list->RowIndex ?>_Kode" id="x<?php echo $daftar_produk_list->RowIndex ?>_Kode" size="30" maxlength="255" placeholder="<?php echo $daftar_produk->Kode->PlaceHolder ?>" value="<?php echo $daftar_produk->Kode->EditValue ?>"<?php echo $daftar_produk->Kode->EditAttributes() ?>>
<input type="hidden" data-field="x_Kode" name="o<?php echo $daftar_produk_list->RowIndex ?>_Kode" id="o<?php echo $daftar_produk_list->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($daftar_produk->Kode->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_produk->Nama_Barang->Visible) { // Nama Barang ?>
		<td><span id="el$rowindex$_daftar_produk_Nama_Barang" class="control-group daftar_produk_Nama_Barang">
<input type="text" data-field="x_Nama_Barang" name="x<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" id="x<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" size="30" maxlength="255" placeholder="<?php echo $daftar_produk->Nama_Barang->PlaceHolder ?>" value="<?php echo $daftar_produk->Nama_Barang->EditValue ?>"<?php echo $daftar_produk->Nama_Barang->EditAttributes() ?>>
<input type="hidden" data-field="x_Nama_Barang" name="o<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" id="o<?php echo $daftar_produk_list->RowIndex ?>_Nama_Barang" value="<?php echo ew_HtmlEncode($daftar_produk->Nama_Barang->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_produk->Satuan->Visible) { // Satuan ?>
		<td><span id="el$rowindex$_daftar_produk_Satuan" class="control-group daftar_produk_Satuan">
<select data-field="x_Satuan" id="x<?php echo $daftar_produk_list->RowIndex ?>_Satuan" name="x<?php echo $daftar_produk_list->RowIndex ?>_Satuan"<?php echo $daftar_produk->Satuan->EditAttributes() ?>>
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
if (@$emptywrk) $daftar_produk->Satuan->OldValue = "";
?>
</select>
<script type="text/javascript">
fdaftar_produklist.Lists["x_Satuan"].Options = <?php echo (is_array($daftar_produk->Satuan->EditValue)) ? ew_ArrayToJson($daftar_produk->Satuan->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" data-field="x_Satuan" name="o<?php echo $daftar_produk_list->RowIndex ?>_Satuan" id="o<?php echo $daftar_produk_list->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($daftar_produk->Satuan->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_produk->Harga_Pokok->Visible) { // Harga Pokok ?>
		<td><span id="el$rowindex$_daftar_produk_Harga_Pokok" class="control-group daftar_produk_Harga_Pokok">
<input type="text" data-field="x_Harga_Pokok" name="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" id="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" size="30" placeholder="<?php echo $daftar_produk->Harga_Pokok->PlaceHolder ?>" value="<?php echo $daftar_produk->Harga_Pokok->EditValue ?>"<?php echo $daftar_produk->Harga_Pokok->EditAttributes() ?>>
<input type="hidden" data-field="x_Harga_Pokok" name="o<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" id="o<?php echo $daftar_produk_list->RowIndex ?>_Harga_Pokok" value="<?php echo ew_HtmlEncode($daftar_produk->Harga_Pokok->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_produk->Harga_Jual->Visible) { // Harga Jual ?>
		<td><span id="el$rowindex$_daftar_produk_Harga_Jual" class="control-group daftar_produk_Harga_Jual">
<input type="text" data-field="x_Harga_Jual" name="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" id="x<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" size="30" placeholder="<?php echo $daftar_produk->Harga_Jual->PlaceHolder ?>" value="<?php echo $daftar_produk->Harga_Jual->EditValue ?>"<?php echo $daftar_produk->Harga_Jual->EditAttributes() ?>>
<input type="hidden" data-field="x_Harga_Jual" name="o<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" id="o<?php echo $daftar_produk_list->RowIndex ?>_Harga_Jual" value="<?php echo ew_HtmlEncode($daftar_produk->Harga_Jual->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_produk->Jumlah->Visible) { // Jumlah ?>
		<td><span id="el$rowindex$_daftar_produk_Jumlah" class="control-group daftar_produk_Jumlah">
<input type="text" data-field="x_Jumlah" name="x<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" id="x<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo $daftar_produk->Jumlah->PlaceHolder ?>" value="<?php echo $daftar_produk->Jumlah->EditValue ?>"<?php echo $daftar_produk->Jumlah->EditAttributes() ?>>
<input type="hidden" data-field="x_Jumlah" name="o<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" id="o<?php echo $daftar_produk_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($daftar_produk->Jumlah->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_produk->Supplier->Visible) { // Supplier ?>
		<td><span id="el$rowindex$_daftar_produk_Supplier" class="control-group daftar_produk_Supplier">
<select data-field="x_Supplier" id="x<?php echo $daftar_produk_list->RowIndex ?>_Supplier" name="x<?php echo $daftar_produk_list->RowIndex ?>_Supplier"<?php echo $daftar_produk->Supplier->EditAttributes() ?>>
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
if (@$emptywrk) $daftar_produk->Supplier->OldValue = "";
?>
</select>
<script type="text/javascript">
fdaftar_produklist.Lists["x_Supplier"].Options = <?php echo (is_array($daftar_produk->Supplier->EditValue)) ? ew_ArrayToJson($daftar_produk->Supplier->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" data-field="x_Supplier" name="o<?php echo $daftar_produk_list->RowIndex ?>_Supplier" id="o<?php echo $daftar_produk_list->RowIndex ?>_Supplier" value="<?php echo ew_HtmlEncode($daftar_produk->Supplier->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$daftar_produk_list->ListOptions->Render("body", "right", $daftar_produk_list->RowCnt);
?>
<script type="text/javascript">
fdaftar_produklist.UpdateOpts(<?php echo $daftar_produk_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($daftar_produk->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $daftar_produk_list->FormKeyCountName ?>" id="<?php echo $daftar_produk_list->FormKeyCountName ?>" value="<?php echo $daftar_produk_list->KeyCount ?>">
<?php echo $daftar_produk_list->MultiSelectKey ?>
<?php } ?>
<?php if ($daftar_produk->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $daftar_produk_list->FormKeyCountName ?>" id="<?php echo $daftar_produk_list->FormKeyCountName ?>" value="<?php echo $daftar_produk_list->KeyCount ?>">
<?php echo $daftar_produk_list->MultiSelectKey ?>
<?php } ?>
<?php if ($daftar_produk->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($daftar_produk_list->Recordset)
	$daftar_produk_list->Recordset->Close();
?>
<?php if ($daftar_produk->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($daftar_produk->CurrentAction <> "gridadd" && $daftar_produk->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($daftar_produk_list->Pager)) $daftar_produk_list->Pager = new cNumericPager($daftar_produk_list->StartRec, $daftar_produk_list->DisplayRecs, $daftar_produk_list->TotalRecs, $daftar_produk_list->RecRange) ?>
<?php if ($daftar_produk_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($daftar_produk_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $daftar_produk_list->PageUrl() ?>start=<?php echo $daftar_produk_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($daftar_produk_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $daftar_produk_list->PageUrl() ?>start=<?php echo $daftar_produk_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($daftar_produk_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $daftar_produk_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($daftar_produk_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $daftar_produk_list->PageUrl() ?>start=<?php echo $daftar_produk_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($daftar_produk_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $daftar_produk_list->PageUrl() ?>start=<?php echo $daftar_produk_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($daftar_produk_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $daftar_produk_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $daftar_produk_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $daftar_produk_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($daftar_produk_list->SearchWhere == "0=101") { ?>
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
	foreach ($daftar_produk_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($daftar_produk->Export == "") { ?>
<script type="text/javascript">
fdaftar_produklistsrch.Init();
fdaftar_produklist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$daftar_produk_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($daftar_produk->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$daftar_produk_list->Page_Terminate();
?>

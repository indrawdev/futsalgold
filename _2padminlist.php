<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$p_2padmin_list = NULL; // Initialize page object first

class cp_2padmin_list extends c_2padmin {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = '2padmin';

	// Page object name
	var $PageObjName = 'p_2padmin_list';

	// Grid form hidden field names
	var $FormName = 'f_2padminlist';
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

		// Table object (_2padmin)
		if (!isset($GLOBALS["_2padmin"])) {
			$GLOBALS["_2padmin"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["_2padmin"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "_2padminadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "_2padmindelete.php";
		$this->MultiUpdateUrl = "_2padminupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", '2padmin', TRUE);

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
		if ($Security->IsLoggedIn() && strval($Security->CurrentUserID()) == "") {
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate();
		}

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
		if ($objForm->HasValue("x_Nama") && $objForm->HasValue("o_Nama") && $this->Nama->CurrentValue <> $this->Nama->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Username") && $objForm->HasValue("o_Username") && $this->Username->CurrentValue <> $this->Username->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Password") && $objForm->HasValue("o_Password") && $this->Password->CurrentValue <> $this->Password->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Level") && $objForm->HasValue("o_Level") && $this->Level->CurrentValue <> $this->Level->OldValue)
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

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Nama); // Nama
			$this->UpdateSort($this->Username); // Username
			$this->UpdateSort($this->Password); // Password
			$this->UpdateSort($this->Level); // Level
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Nama->setSort("");
				$this->Username->setSort("");
				$this->Password->setSort("");
				$this->Level->setSort("");
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
		if ($Security->CanEdit() && $this->ShowOptionLink('edit')) {
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.f_2padminlist, '" . $this->MultiDeleteUrl . "');return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.f_2padminlist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		$this->Nama->CurrentValue = NULL;
		$this->Nama->OldValue = $this->Nama->CurrentValue;
		$this->Username->CurrentValue = NULL;
		$this->Username->OldValue = $this->Username->CurrentValue;
		$this->Password->CurrentValue = NULL;
		$this->Password->OldValue = $this->Password->CurrentValue;
		$this->Level->CurrentValue = NULL;
		$this->Level->OldValue = $this->Level->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		$this->Nama->setOldValue($objForm->GetValue("o_Nama"));
		if (!$this->Username->FldIsDetailKey) {
			$this->Username->setFormValue($objForm->GetValue("x_Username"));
		}
		$this->Username->setOldValue($objForm->GetValue("o_Username"));
		if (!$this->Password->FldIsDetailKey) {
			$this->Password->setFormValue($objForm->GetValue("x_Password"));
		}
		$this->Password->setOldValue($objForm->GetValue("o_Password"));
		if (!$this->Level->FldIsDetailKey) {
			$this->Level->setFormValue($objForm->GetValue("x_Level"));
		}
		$this->Level->setOldValue($objForm->GetValue("o_Level"));
		if (!$this->ID->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->ID->CurrentValue = $this->ID->FormValue;
		$this->Nama->CurrentValue = $this->Nama->FormValue;
		$this->Username->CurrentValue = $this->Username->FormValue;
		$this->Password->CurrentValue = $this->Password->FormValue;
		$this->Level->CurrentValue = $this->Level->FormValue;
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
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Username->setDbValue($rs->fields('Username'));
		$this->Password->setDbValue($rs->fields('Password'));
		$this->Level->setDbValue($rs->fields('Level'));
		$this->Jabatan->setDbValue($rs->fields('Jabatan'));
		$this->Foto->Upload->DbValue = $rs->fields('Foto');
		$this->Temp->setDbValue($rs->fields('Temp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Username->DbValue = $row['Username'];
		$this->Password->DbValue = $row['Password'];
		$this->Level->DbValue = $row['Level'];
		$this->Jabatan->DbValue = $row['Jabatan'];
		$this->Foto->Upload->DbValue = $row['Foto'];
		$this->Temp->DbValue = $row['Temp'];
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

		// Nama
		// Username
		// Password
		// Level
		// Jabatan

		$this->Jabatan->CellCssStyle = "white-space: nowrap;";

		// Foto
		$this->Foto->CellCssStyle = "white-space: nowrap;";

		// Temp
		$this->Temp->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Nama
			$this->Nama->ViewValue = $this->Nama->CurrentValue;
			$this->Nama->ViewCustomAttributes = "";

			// Username
			$this->Username->ViewValue = $this->Username->CurrentValue;
			$this->Username->ViewCustomAttributes = "";

			// Password
			$this->Password->ViewValue = $this->Password->CurrentValue;
			$this->Password->ViewCustomAttributes = "";

			// Level
			if ($Security->CanAdmin()) { // System admin
			if (strval($this->Level->CurrentValue) <> "") {
				switch ($this->Level->CurrentValue) {
					case $this->Level->FldTagValue(1):
						$this->Level->ViewValue = $this->Level->FldTagCaption(1) <> "" ? $this->Level->FldTagCaption(1) : $this->Level->CurrentValue;
						break;
					case $this->Level->FldTagValue(2):
						$this->Level->ViewValue = $this->Level->FldTagCaption(2) <> "" ? $this->Level->FldTagCaption(2) : $this->Level->CurrentValue;
						break;
					case $this->Level->FldTagValue(3):
						$this->Level->ViewValue = $this->Level->FldTagCaption(3) <> "" ? $this->Level->FldTagCaption(3) : $this->Level->CurrentValue;
						break;
					default:
						$this->Level->ViewValue = $this->Level->CurrentValue;
				}
			} else {
				$this->Level->ViewValue = NULL;
			}
			} else {
				$this->Level->ViewValue = "********";
			}
			$this->Level->ViewCustomAttributes = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Username
			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";
			$this->Username->TooltipValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";
			$this->Password->TooltipValue = "";

			// Level
			$this->Level->LinkCustomAttributes = "";
			$this->Level->HrefValue = "";
			$this->Level->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Nama
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Nama->FldCaption()));

			// Username
			$this->Username->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow($this->CurrentAction)) { // Non system admin
				$this->Username->CurrentValue = CurrentUserID();
			$this->Username->EditValue = $this->Username->CurrentValue;
			$this->Username->ViewCustomAttributes = "";
			} else {
			$this->Username->EditValue = ew_HtmlEncode($this->Username->CurrentValue);
			$this->Username->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Username->FldCaption()));
			}

			// Password
			$this->Password->EditCustomAttributes = "";
			$this->Password->EditValue = ew_HtmlEncode($this->Password->CurrentValue);
			$this->Password->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Password->FldCaption()));

			// Level
			$this->Level->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->Level->EditValue = "********";
			} else {
			$arwrk = array();
			$arwrk[] = array($this->Level->FldTagValue(1), $this->Level->FldTagCaption(1) <> "" ? $this->Level->FldTagCaption(1) : $this->Level->FldTagValue(1));
			$arwrk[] = array($this->Level->FldTagValue(2), $this->Level->FldTagCaption(2) <> "" ? $this->Level->FldTagCaption(2) : $this->Level->FldTagValue(2));
			$arwrk[] = array($this->Level->FldTagValue(3), $this->Level->FldTagCaption(3) <> "" ? $this->Level->FldTagCaption(3) : $this->Level->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->Level->EditValue = $arwrk;
			}

			// Edit refer script
			// Nama

			$this->Nama->HrefValue = "";

			// Username
			$this->Username->HrefValue = "";

			// Password
			$this->Password->HrefValue = "";

			// Level
			$this->Level->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Nama
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Nama->FldCaption()));

			// Username
			$this->Username->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow($this->CurrentAction)) { // Non system admin
				$this->Username->CurrentValue = CurrentUserID();
			$this->Username->EditValue = $this->Username->CurrentValue;
			$this->Username->ViewCustomAttributes = "";
			} else {
			$this->Username->EditValue = ew_HtmlEncode($this->Username->CurrentValue);
			$this->Username->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Username->FldCaption()));
			}

			// Password
			$this->Password->EditCustomAttributes = "";
			$this->Password->EditValue = ew_HtmlEncode($this->Password->CurrentValue);
			$this->Password->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Password->FldCaption()));

			// Level
			$this->Level->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->Level->EditValue = "********";
			} else {
			$arwrk = array();
			$arwrk[] = array($this->Level->FldTagValue(1), $this->Level->FldTagCaption(1) <> "" ? $this->Level->FldTagCaption(1) : $this->Level->FldTagValue(1));
			$arwrk[] = array($this->Level->FldTagValue(2), $this->Level->FldTagCaption(2) <> "" ? $this->Level->FldTagCaption(2) : $this->Level->FldTagValue(2));
			$arwrk[] = array($this->Level->FldTagValue(3), $this->Level->FldTagCaption(3) <> "" ? $this->Level->FldTagCaption(3) : $this->Level->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->Level->EditValue = $arwrk;
			}

			// Edit refer script
			// Nama

			$this->Nama->HrefValue = "";

			// Username
			$this->Username->HrefValue = "";

			// Password
			$this->Password->HrefValue = "";

			// Level
			$this->Level->HrefValue = "";
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
		if (!$this->Nama->FldIsDetailKey && !is_null($this->Nama->FormValue) && $this->Nama->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Nama->FldCaption());
		}
		if (!$this->Username->FldIsDetailKey && !is_null($this->Username->FormValue) && $this->Username->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Username->FldCaption());
		}
		if (!$this->Password->FldIsDetailKey && !is_null($this->Password->FormValue) && $this->Password->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Password->FldCaption());
		}
		if (!$this->Level->FldIsDetailKey && !is_null($this->Level->FormValue) && $this->Level->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Level->FldCaption());
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

			// Nama
			$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", $this->Nama->ReadOnly);

			// Username
			$this->Username->SetDbValueDef($rsnew, $this->Username->CurrentValue, "", $this->Username->ReadOnly);

			// Password
			$this->Password->SetDbValueDef($rsnew, $this->Password->CurrentValue, "", $this->Password->ReadOnly || (EW_ENCRYPTED_PASSWORD && $rs->fields('Password') == $this->Password->CurrentValue));

			// Level
			if ($Security->CanAdmin()) { // System admin
			$this->Level->SetDbValueDef($rsnew, $this->Level->CurrentValue, 0, $this->Level->ReadOnly);
			}

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

		// Check if valid User ID
		$bValidUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !$Security->IsAdmin()) { // Non system admin
			$bValidUser = $Security->IsValidUserID($this->Username->CurrentValue);
			if (!$bValidUser) {
				$sUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedUserID"));
				$sUserIdMsg = str_replace("%u", $this->Username->CurrentValue, $sUserIdMsg);
				$this->setFailureMessage($sUserIdMsg);
				return FALSE;
			}
		}

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Nama
		$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", FALSE);

		// Username
		$this->Username->SetDbValueDef($rsnew, $this->Username->CurrentValue, "", FALSE);

		// Password
		$this->Password->SetDbValueDef($rsnew, $this->Password->CurrentValue, "", FALSE);

		// Level
		if ($Security->CanAdmin()) { // System admin
		$this->Level->SetDbValueDef($rsnew, $this->Level->CurrentValue, 0, FALSE);
		}

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
		$item->Body = "<a id=\"emf__2padmin\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf__2padmin',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.f_2padminlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->Username->CurrentValue);
		return TRUE;
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
if (!isset($p_2padmin_list)) $p_2padmin_list = new cp_2padmin_list();

// Page init
$p_2padmin_list->Page_Init();

// Page main
$p_2padmin_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$p_2padmin_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($_2padmin->Export == "") { ?>
<script type="text/javascript">

// Page object
var p_2padmin_list = new ew_Page("p_2padmin_list");
p_2padmin_list.PageID = "list"; // Page ID
var EW_PAGE_ID = p_2padmin_list.PageID; // For backward compatibility

// Form object
var f_2padminlist = new ew_Form("f_2padminlist");
f_2padminlist.FormKeyCountName = '<?php echo $p_2padmin_list->FormKeyCountName ?>';

// Validate form
f_2padminlist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($_2padmin->Nama->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Username");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($_2padmin->Username->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Password");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($_2padmin->Password->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Level");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($_2padmin->Level->FldCaption()) ?>");

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
f_2padminlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Nama", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Username", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Password", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Level", false)) return false;
	return true;
}

// Form_CustomValidate event
f_2padminlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
f_2padminlist.ValidateRequired = true;
<?php } else { ?>
f_2padminlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($_2padmin->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($p_2padmin_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $p_2padmin_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($_2padmin->CurrentAction == "gridadd") {
	$_2padmin->CurrentFilter = "0=1";
	$p_2padmin_list->StartRec = 1;
	$p_2padmin_list->DisplayRecs = $_2padmin->GridAddRowCount;
	$p_2padmin_list->TotalRecs = $p_2padmin_list->DisplayRecs;
	$p_2padmin_list->StopRec = $p_2padmin_list->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$p_2padmin_list->TotalRecs = $_2padmin->SelectRecordCount();
	} else {
		if ($p_2padmin_list->Recordset = $p_2padmin_list->LoadRecordset())
			$p_2padmin_list->TotalRecs = $p_2padmin_list->Recordset->RecordCount();
	}
	$p_2padmin_list->StartRec = 1;
	if ($p_2padmin_list->DisplayRecs <= 0 || ($_2padmin->Export <> "" && $_2padmin->ExportAll)) // Display all records
		$p_2padmin_list->DisplayRecs = $p_2padmin_list->TotalRecs;
	if (!($_2padmin->Export <> "" && $_2padmin->ExportAll))
		$p_2padmin_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$p_2padmin_list->Recordset = $p_2padmin_list->LoadRecordset($p_2padmin_list->StartRec-1, $p_2padmin_list->DisplayRecs);
}
$p_2padmin_list->RenderOtherOptions();
?>
<?php $p_2padmin_list->ShowPageHeader(); ?>
<?php
$p_2padmin_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="f_2padminlist" id="f_2padminlist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="_2padmin">
<div id="gmp__2padmin" class="ewGridMiddlePanel">
<?php if ($p_2padmin_list->TotalRecs > 0) { ?>
<table id="tbl__2padminlist" class="ewTable ewTableSeparate">
<?php echo $_2padmin->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$p_2padmin_list->RenderListOptions();

// Render list options (header, left)
$p_2padmin_list->ListOptions->Render("header", "left");
?>
<?php if ($_2padmin->Nama->Visible) { // Nama ?>
	<?php if ($_2padmin->SortUrl($_2padmin->Nama) == "") { ?>
		<td><div id="elh__2padmin_Nama" class="_2padmin_Nama"><div class="ewTableHeaderCaption"><?php echo $_2padmin->Nama->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $_2padmin->SortUrl($_2padmin->Nama) ?>',1);"><div id="elh__2padmin_Nama" class="_2padmin_Nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $_2padmin->Nama->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($_2padmin->Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($_2padmin->Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($_2padmin->Username->Visible) { // Username ?>
	<?php if ($_2padmin->SortUrl($_2padmin->Username) == "") { ?>
		<td><div id="elh__2padmin_Username" class="_2padmin_Username"><div class="ewTableHeaderCaption"><?php echo $_2padmin->Username->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $_2padmin->SortUrl($_2padmin->Username) ?>',1);"><div id="elh__2padmin_Username" class="_2padmin_Username">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $_2padmin->Username->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($_2padmin->Username->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($_2padmin->Username->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($_2padmin->Password->Visible) { // Password ?>
	<?php if ($_2padmin->SortUrl($_2padmin->Password) == "") { ?>
		<td><div id="elh__2padmin_Password" class="_2padmin_Password"><div class="ewTableHeaderCaption"><?php echo $_2padmin->Password->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $_2padmin->SortUrl($_2padmin->Password) ?>',1);"><div id="elh__2padmin_Password" class="_2padmin_Password">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $_2padmin->Password->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($_2padmin->Password->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($_2padmin->Password->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($_2padmin->Level->Visible) { // Level ?>
	<?php if ($_2padmin->SortUrl($_2padmin->Level) == "") { ?>
		<td><div id="elh__2padmin_Level" class="_2padmin_Level"><div class="ewTableHeaderCaption"><?php echo $_2padmin->Level->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $_2padmin->SortUrl($_2padmin->Level) ?>',1);"><div id="elh__2padmin_Level" class="_2padmin_Level">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $_2padmin->Level->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($_2padmin->Level->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($_2padmin->Level->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$p_2padmin_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($_2padmin->ExportAll && $_2padmin->Export <> "") {
	$p_2padmin_list->StopRec = $p_2padmin_list->TotalRecs;
} else {

	// Set the last record to display
	if ($p_2padmin_list->TotalRecs > $p_2padmin_list->StartRec + $p_2padmin_list->DisplayRecs - 1)
		$p_2padmin_list->StopRec = $p_2padmin_list->StartRec + $p_2padmin_list->DisplayRecs - 1;
	else
		$p_2padmin_list->StopRec = $p_2padmin_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($p_2padmin_list->FormKeyCountName) && ($_2padmin->CurrentAction == "gridadd" || $_2padmin->CurrentAction == "gridedit" || $_2padmin->CurrentAction == "F")) {
		$p_2padmin_list->KeyCount = $objForm->GetValue($p_2padmin_list->FormKeyCountName);
		$p_2padmin_list->StopRec = $p_2padmin_list->StartRec + $p_2padmin_list->KeyCount - 1;
	}
}
$p_2padmin_list->RecCnt = $p_2padmin_list->StartRec - 1;
if ($p_2padmin_list->Recordset && !$p_2padmin_list->Recordset->EOF) {
	$p_2padmin_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $p_2padmin_list->StartRec > 1)
		$p_2padmin_list->Recordset->Move($p_2padmin_list->StartRec - 1);
} elseif (!$_2padmin->AllowAddDeleteRow && $p_2padmin_list->StopRec == 0) {
	$p_2padmin_list->StopRec = $_2padmin->GridAddRowCount;
}

// Initialize aggregate
$_2padmin->RowType = EW_ROWTYPE_AGGREGATEINIT;
$_2padmin->ResetAttrs();
$p_2padmin_list->RenderRow();
if ($_2padmin->CurrentAction == "gridadd")
	$p_2padmin_list->RowIndex = 0;
if ($_2padmin->CurrentAction == "gridedit")
	$p_2padmin_list->RowIndex = 0;
while ($p_2padmin_list->RecCnt < $p_2padmin_list->StopRec) {
	$p_2padmin_list->RecCnt++;
	if (intval($p_2padmin_list->RecCnt) >= intval($p_2padmin_list->StartRec)) {
		$p_2padmin_list->RowCnt++;
		if ($_2padmin->CurrentAction == "gridadd" || $_2padmin->CurrentAction == "gridedit" || $_2padmin->CurrentAction == "F") {
			$p_2padmin_list->RowIndex++;
			$objForm->Index = $p_2padmin_list->RowIndex;
			if ($objForm->HasValue($p_2padmin_list->FormActionName))
				$p_2padmin_list->RowAction = strval($objForm->GetValue($p_2padmin_list->FormActionName));
			elseif ($_2padmin->CurrentAction == "gridadd")
				$p_2padmin_list->RowAction = "insert";
			else
				$p_2padmin_list->RowAction = "";
		}

		// Set up key count
		$p_2padmin_list->KeyCount = $p_2padmin_list->RowIndex;

		// Init row class and style
		$_2padmin->ResetAttrs();
		$_2padmin->CssClass = "";
		if ($_2padmin->CurrentAction == "gridadd") {
			$p_2padmin_list->LoadDefaultValues(); // Load default values
		} else {
			$p_2padmin_list->LoadRowValues($p_2padmin_list->Recordset); // Load row values
		}
		$_2padmin->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($_2padmin->CurrentAction == "gridadd") // Grid add
			$_2padmin->RowType = EW_ROWTYPE_ADD; // Render add
		if ($_2padmin->CurrentAction == "gridadd" && $_2padmin->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$p_2padmin_list->RestoreCurrentRowFormValues($p_2padmin_list->RowIndex); // Restore form values
		if ($_2padmin->CurrentAction == "gridedit") { // Grid edit
			if ($_2padmin->EventCancelled) {
				$p_2padmin_list->RestoreCurrentRowFormValues($p_2padmin_list->RowIndex); // Restore form values
			}
			if ($p_2padmin_list->RowAction == "insert")
				$_2padmin->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$_2padmin->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($_2padmin->CurrentAction == "gridedit" && ($_2padmin->RowType == EW_ROWTYPE_EDIT || $_2padmin->RowType == EW_ROWTYPE_ADD) && $_2padmin->EventCancelled) // Update failed
			$p_2padmin_list->RestoreCurrentRowFormValues($p_2padmin_list->RowIndex); // Restore form values
		if ($_2padmin->RowType == EW_ROWTYPE_EDIT) // Edit row
			$p_2padmin_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$_2padmin->RowAttrs = array_merge($_2padmin->RowAttrs, array('data-rowindex'=>$p_2padmin_list->RowCnt, 'id'=>'r' . $p_2padmin_list->RowCnt . '__2padmin', 'data-rowtype'=>$_2padmin->RowType));

		// Render row
		$p_2padmin_list->RenderRow();

		// Render list options
		$p_2padmin_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($p_2padmin_list->RowAction <> "delete" && $p_2padmin_list->RowAction <> "insertdelete" && !($p_2padmin_list->RowAction == "insert" && $_2padmin->CurrentAction == "F" && $p_2padmin_list->EmptyRow())) {
?>
	<tr<?php echo $_2padmin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$p_2padmin_list->ListOptions->Render("body", "left", $p_2padmin_list->RowCnt);
?>
	<?php if ($_2padmin->Nama->Visible) { // Nama ?>
		<td<?php echo $_2padmin->Nama->CellAttributes() ?>><span id="el<?php echo $p_2padmin_list->RowCnt ?>__2padmin_Nama" class="control-group _2padmin_Nama">
<?php if ($_2padmin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Nama" name="x<?php echo $p_2padmin_list->RowIndex ?>_Nama" id="x<?php echo $p_2padmin_list->RowIndex ?>_Nama" size="30" maxlength="255" placeholder="<?php echo $_2padmin->Nama->PlaceHolder ?>" value="<?php echo $_2padmin->Nama->EditValue ?>"<?php echo $_2padmin->Nama->EditAttributes() ?>>
<input type="hidden" data-field="x_Nama" name="o<?php echo $p_2padmin_list->RowIndex ?>_Nama" id="o<?php echo $p_2padmin_list->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($_2padmin->Nama->OldValue) ?>">
<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Nama" name="x<?php echo $p_2padmin_list->RowIndex ?>_Nama" id="x<?php echo $p_2padmin_list->RowIndex ?>_Nama" size="30" maxlength="255" placeholder="<?php echo $_2padmin->Nama->PlaceHolder ?>" value="<?php echo $_2padmin->Nama->EditValue ?>"<?php echo $_2padmin->Nama->EditAttributes() ?>>
<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $_2padmin->Nama->ViewAttributes() ?>>
<?php echo $_2padmin->Nama->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $p_2padmin_list->PageObjName . "_row_" . $p_2padmin_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $p_2padmin_list->RowIndex ?>_ID" id="x<?php echo $p_2padmin_list->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($_2padmin->ID->CurrentValue) ?>">
<input type="hidden" data-field="x_ID" name="o<?php echo $p_2padmin_list->RowIndex ?>_ID" id="o<?php echo $p_2padmin_list->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($_2padmin->ID->OldValue) ?>">
<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_EDIT || $_2padmin->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $p_2padmin_list->RowIndex ?>_ID" id="x<?php echo $p_2padmin_list->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($_2padmin->ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($_2padmin->Username->Visible) { // Username ?>
		<td<?php echo $_2padmin->Username->CellAttributes() ?>><span id="el<?php echo $p_2padmin_list->RowCnt ?>__2padmin_Username" class="control-group _2padmin_Username">
<?php if ($_2padmin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$_2padmin->UserIDAllow($_2padmin->CurrentAction)) { // Non system admin ?>
<span<?php echo $_2padmin->Username->ViewAttributes() ?>>
<?php echo $_2padmin->Username->EditValue ?></span>
<input type="hidden" data-field="x_Username" name="x<?php echo $p_2padmin_list->RowIndex ?>_Username" id="x<?php echo $p_2padmin_list->RowIndex ?>_Username" value="<?php echo ew_HtmlEncode($_2padmin->Username->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Username" name="x<?php echo $p_2padmin_list->RowIndex ?>_Username" id="x<?php echo $p_2padmin_list->RowIndex ?>_Username" size="30" maxlength="255" placeholder="<?php echo $_2padmin->Username->PlaceHolder ?>" value="<?php echo $_2padmin->Username->EditValue ?>"<?php echo $_2padmin->Username->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_Username" name="o<?php echo $p_2padmin_list->RowIndex ?>_Username" id="o<?php echo $p_2padmin_list->RowIndex ?>_Username" value="<?php echo ew_HtmlEncode($_2padmin->Username->OldValue) ?>">
<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$_2padmin->UserIDAllow($_2padmin->CurrentAction)) { // Non system admin ?>
<span<?php echo $_2padmin->Username->ViewAttributes() ?>>
<?php echo $_2padmin->Username->EditValue ?></span>
<input type="hidden" data-field="x_Username" name="x<?php echo $p_2padmin_list->RowIndex ?>_Username" id="x<?php echo $p_2padmin_list->RowIndex ?>_Username" value="<?php echo ew_HtmlEncode($_2padmin->Username->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Username" name="x<?php echo $p_2padmin_list->RowIndex ?>_Username" id="x<?php echo $p_2padmin_list->RowIndex ?>_Username" size="30" maxlength="255" placeholder="<?php echo $_2padmin->Username->PlaceHolder ?>" value="<?php echo $_2padmin->Username->EditValue ?>"<?php echo $_2padmin->Username->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $_2padmin->Username->ViewAttributes() ?>>
<?php echo $_2padmin->Username->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $p_2padmin_list->PageObjName . "_row_" . $p_2padmin_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($_2padmin->Password->Visible) { // Password ?>
		<td<?php echo $_2padmin->Password->CellAttributes() ?>><span id="el<?php echo $p_2padmin_list->RowCnt ?>__2padmin_Password" class="control-group _2padmin_Password">
<?php if ($_2padmin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Password" name="x<?php echo $p_2padmin_list->RowIndex ?>_Password" id="x<?php echo $p_2padmin_list->RowIndex ?>_Password" size="30" maxlength="255" placeholder="<?php echo $_2padmin->Password->PlaceHolder ?>" value="<?php echo $_2padmin->Password->EditValue ?>"<?php echo $_2padmin->Password->EditAttributes() ?>>
<input type="hidden" data-field="x_Password" name="o<?php echo $p_2padmin_list->RowIndex ?>_Password" id="o<?php echo $p_2padmin_list->RowIndex ?>_Password" value="<?php echo ew_HtmlEncode($_2padmin->Password->OldValue) ?>">
<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Password" name="x<?php echo $p_2padmin_list->RowIndex ?>_Password" id="x<?php echo $p_2padmin_list->RowIndex ?>_Password" size="30" maxlength="255" placeholder="<?php echo $_2padmin->Password->PlaceHolder ?>" value="<?php echo $_2padmin->Password->EditValue ?>"<?php echo $_2padmin->Password->EditAttributes() ?>>
<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $_2padmin->Password->ViewAttributes() ?>>
<?php echo $_2padmin->Password->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $p_2padmin_list->PageObjName . "_row_" . $p_2padmin_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($_2padmin->Level->Visible) { // Level ?>
		<td<?php echo $_2padmin->Level->CellAttributes() ?>><span id="el<?php echo $p_2padmin_list->RowCnt ?>__2padmin_Level" class="control-group _2padmin_Level">
<?php if ($_2padmin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<?php echo $_2padmin->Level->EditValue ?>
<?php } else { ?>
<select data-field="x_Level" id="x<?php echo $p_2padmin_list->RowIndex ?>_Level" name="x<?php echo $p_2padmin_list->RowIndex ?>_Level"<?php echo $_2padmin->Level->EditAttributes() ?>>
<?php
if (is_array($_2padmin->Level->EditValue)) {
	$arwrk = $_2padmin->Level->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($_2padmin->Level->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $_2padmin->Level->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" data-field="x_Level" name="o<?php echo $p_2padmin_list->RowIndex ?>_Level" id="o<?php echo $p_2padmin_list->RowIndex ?>_Level" value="<?php echo ew_HtmlEncode($_2padmin->Level->OldValue) ?>">
<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<?php echo $_2padmin->Level->EditValue ?>
<?php } else { ?>
<select data-field="x_Level" id="x<?php echo $p_2padmin_list->RowIndex ?>_Level" name="x<?php echo $p_2padmin_list->RowIndex ?>_Level"<?php echo $_2padmin->Level->EditAttributes() ?>>
<?php
if (is_array($_2padmin->Level->EditValue)) {
	$arwrk = $_2padmin->Level->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($_2padmin->Level->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $_2padmin->Level->OldValue = "";
?>
</select>
<?php } ?>
<?php } ?>
<?php if ($_2padmin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $_2padmin->Level->ViewAttributes() ?>>
<?php echo $_2padmin->Level->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $p_2padmin_list->PageObjName . "_row_" . $p_2padmin_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$p_2padmin_list->ListOptions->Render("body", "right", $p_2padmin_list->RowCnt);
?>
	</tr>
<?php if ($_2padmin->RowType == EW_ROWTYPE_ADD || $_2padmin->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
f_2padminlist.UpdateOpts(<?php echo $p_2padmin_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($_2padmin->CurrentAction <> "gridadd")
		if (!$p_2padmin_list->Recordset->EOF) $p_2padmin_list->Recordset->MoveNext();
}
?>
<?php
	if ($_2padmin->CurrentAction == "gridadd" || $_2padmin->CurrentAction == "gridedit") {
		$p_2padmin_list->RowIndex = '$rowindex$';
		$p_2padmin_list->LoadDefaultValues();

		// Set row properties
		$_2padmin->ResetAttrs();
		$_2padmin->RowAttrs = array_merge($_2padmin->RowAttrs, array('data-rowindex'=>$p_2padmin_list->RowIndex, 'id'=>'r0__2padmin', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($_2padmin->RowAttrs["class"], "ewTemplate");
		$_2padmin->RowType = EW_ROWTYPE_ADD;

		// Render row
		$p_2padmin_list->RenderRow();

		// Render list options
		$p_2padmin_list->RenderListOptions();
		$p_2padmin_list->StartRowCnt = 0;
?>
	<tr<?php echo $_2padmin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$p_2padmin_list->ListOptions->Render("body", "left", $p_2padmin_list->RowIndex);
?>
	<?php if ($_2padmin->Nama->Visible) { // Nama ?>
		<td><span id="el$rowindex$__2padmin_Nama" class="control-group _2padmin_Nama">
<input type="text" data-field="x_Nama" name="x<?php echo $p_2padmin_list->RowIndex ?>_Nama" id="x<?php echo $p_2padmin_list->RowIndex ?>_Nama" size="30" maxlength="255" placeholder="<?php echo $_2padmin->Nama->PlaceHolder ?>" value="<?php echo $_2padmin->Nama->EditValue ?>"<?php echo $_2padmin->Nama->EditAttributes() ?>>
<input type="hidden" data-field="x_Nama" name="o<?php echo $p_2padmin_list->RowIndex ?>_Nama" id="o<?php echo $p_2padmin_list->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($_2padmin->Nama->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($_2padmin->Username->Visible) { // Username ?>
		<td><span id="el$rowindex$__2padmin_Username" class="control-group _2padmin_Username">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$_2padmin->UserIDAllow($_2padmin->CurrentAction)) { // Non system admin ?>
<span<?php echo $_2padmin->Username->ViewAttributes() ?>>
<?php echo $_2padmin->Username->EditValue ?></span>
<input type="hidden" data-field="x_Username" name="x<?php echo $p_2padmin_list->RowIndex ?>_Username" id="x<?php echo $p_2padmin_list->RowIndex ?>_Username" value="<?php echo ew_HtmlEncode($_2padmin->Username->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Username" name="x<?php echo $p_2padmin_list->RowIndex ?>_Username" id="x<?php echo $p_2padmin_list->RowIndex ?>_Username" size="30" maxlength="255" placeholder="<?php echo $_2padmin->Username->PlaceHolder ?>" value="<?php echo $_2padmin->Username->EditValue ?>"<?php echo $_2padmin->Username->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_Username" name="o<?php echo $p_2padmin_list->RowIndex ?>_Username" id="o<?php echo $p_2padmin_list->RowIndex ?>_Username" value="<?php echo ew_HtmlEncode($_2padmin->Username->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($_2padmin->Password->Visible) { // Password ?>
		<td><span id="el$rowindex$__2padmin_Password" class="control-group _2padmin_Password">
<input type="text" data-field="x_Password" name="x<?php echo $p_2padmin_list->RowIndex ?>_Password" id="x<?php echo $p_2padmin_list->RowIndex ?>_Password" size="30" maxlength="255" placeholder="<?php echo $_2padmin->Password->PlaceHolder ?>" value="<?php echo $_2padmin->Password->EditValue ?>"<?php echo $_2padmin->Password->EditAttributes() ?>>
<input type="hidden" data-field="x_Password" name="o<?php echo $p_2padmin_list->RowIndex ?>_Password" id="o<?php echo $p_2padmin_list->RowIndex ?>_Password" value="<?php echo ew_HtmlEncode($_2padmin->Password->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($_2padmin->Level->Visible) { // Level ?>
		<td><span id="el$rowindex$__2padmin_Level" class="control-group _2padmin_Level">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<?php echo $_2padmin->Level->EditValue ?>
<?php } else { ?>
<select data-field="x_Level" id="x<?php echo $p_2padmin_list->RowIndex ?>_Level" name="x<?php echo $p_2padmin_list->RowIndex ?>_Level"<?php echo $_2padmin->Level->EditAttributes() ?>>
<?php
if (is_array($_2padmin->Level->EditValue)) {
	$arwrk = $_2padmin->Level->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($_2padmin->Level->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $_2padmin->Level->OldValue = "";
?>
</select>
<?php } ?>
<input type="hidden" data-field="x_Level" name="o<?php echo $p_2padmin_list->RowIndex ?>_Level" id="o<?php echo $p_2padmin_list->RowIndex ?>_Level" value="<?php echo ew_HtmlEncode($_2padmin->Level->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$p_2padmin_list->ListOptions->Render("body", "right", $p_2padmin_list->RowCnt);
?>
<script type="text/javascript">
f_2padminlist.UpdateOpts(<?php echo $p_2padmin_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($_2padmin->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $p_2padmin_list->FormKeyCountName ?>" id="<?php echo $p_2padmin_list->FormKeyCountName ?>" value="<?php echo $p_2padmin_list->KeyCount ?>">
<?php echo $p_2padmin_list->MultiSelectKey ?>
<?php } ?>
<?php if ($_2padmin->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $p_2padmin_list->FormKeyCountName ?>" id="<?php echo $p_2padmin_list->FormKeyCountName ?>" value="<?php echo $p_2padmin_list->KeyCount ?>">
<?php echo $p_2padmin_list->MultiSelectKey ?>
<?php } ?>
<?php if ($_2padmin->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($p_2padmin_list->Recordset)
	$p_2padmin_list->Recordset->Close();
?>
<?php if ($_2padmin->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($_2padmin->CurrentAction <> "gridadd" && $_2padmin->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($p_2padmin_list->Pager)) $p_2padmin_list->Pager = new cNumericPager($p_2padmin_list->StartRec, $p_2padmin_list->DisplayRecs, $p_2padmin_list->TotalRecs, $p_2padmin_list->RecRange) ?>
<?php if ($p_2padmin_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($p_2padmin_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $p_2padmin_list->PageUrl() ?>start=<?php echo $p_2padmin_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($p_2padmin_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $p_2padmin_list->PageUrl() ?>start=<?php echo $p_2padmin_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($p_2padmin_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $p_2padmin_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($p_2padmin_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $p_2padmin_list->PageUrl() ?>start=<?php echo $p_2padmin_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($p_2padmin_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $p_2padmin_list->PageUrl() ?>start=<?php echo $p_2padmin_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($p_2padmin_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $p_2padmin_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $p_2padmin_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $p_2padmin_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($p_2padmin_list->SearchWhere == "0=101") { ?>
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
	foreach ($p_2padmin_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($_2padmin->Export == "") { ?>
<script type="text/javascript">
f_2padminlist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$p_2padmin_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($_2padmin->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$p_2padmin_list->Page_Terminate();
?>

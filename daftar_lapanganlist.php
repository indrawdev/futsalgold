<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "daftar_lapanganinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$daftar_lapangan_list = NULL; // Initialize page object first

class cdaftar_lapangan_list extends cdaftar_lapangan {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'daftar lapangan';

	// Page object name
	var $PageObjName = 'daftar_lapangan_list';

	// Grid form hidden field names
	var $FormName = 'fdaftar_lapanganlist';
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

		// Table object (daftar_lapangan)
		if (!isset($GLOBALS["daftar_lapangan"])) {
			$GLOBALS["daftar_lapangan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["daftar_lapangan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "daftar_lapanganadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "daftar_lapangandelete.php";
		$this->MultiUpdateUrl = "daftar_lapanganupdate.php";

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar lapangan', TRUE);

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
		if ($objForm->HasValue("x_Kode") && $objForm->HasValue("o_Kode") && $this->Kode->CurrentValue <> $this->Kode->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NamaLapangan") && $objForm->HasValue("o_NamaLapangan") && $this->NamaLapangan->CurrentValue <> $this->NamaLapangan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Ukuran") && $objForm->HasValue("o_Ukuran") && $this->Ukuran->CurrentValue <> $this->Ukuran->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Kondisi") && $objForm->HasValue("o_Kondisi") && $this->Kondisi->CurrentValue <> $this->Kondisi->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_HargaSewa1") && $objForm->HasValue("o_HargaSewa1") && $this->HargaSewa1->CurrentValue <> $this->HargaSewa1->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_HargaSewa2") && $objForm->HasValue("o_HargaSewa2") && $this->HargaSewa2->CurrentValue <> $this->HargaSewa2->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_HargaSewa3") && $objForm->HasValue("o_HargaSewa3") && $this->HargaSewa3->CurrentValue <> $this->HargaSewa3->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_HargaSewa4") && $objForm->HasValue("o_HargaSewa4") && $this->HargaSewa4->CurrentValue <> $this->HargaSewa4->OldValue)
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
			$this->UpdateSort($this->Kode); // Kode
			$this->UpdateSort($this->NamaLapangan); // NamaLapangan
			$this->UpdateSort($this->Ukuran); // Ukuran
			$this->UpdateSort($this->Kondisi); // Kondisi
			$this->UpdateSort($this->HargaSewa1); // HargaSewa1
			$this->UpdateSort($this->HargaSewa2); // HargaSewa2
			$this->UpdateSort($this->HargaSewa3); // HargaSewa3
			$this->UpdateSort($this->HargaSewa4); // HargaSewa4
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
				$this->Kode->setSort("");
				$this->NamaLapangan->setSort("");
				$this->Ukuran->setSort("");
				$this->Kondisi->setSort("");
				$this->HargaSewa1->setSort("");
				$this->HargaSewa2->setSort("");
				$this->HargaSewa3->setSort("");
				$this->HargaSewa4->setSort("");
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.fdaftar_lapanganlist, '" . $this->MultiDeleteUrl . "');return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fdaftar_lapanganlist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		$this->NamaLapangan->CurrentValue = "-";
		$this->NamaLapangan->OldValue = $this->NamaLapangan->CurrentValue;
		$this->Ukuran->CurrentValue = "-";
		$this->Ukuran->OldValue = $this->Ukuran->CurrentValue;
		$this->Kondisi->CurrentValue = "-";
		$this->Kondisi->OldValue = $this->Kondisi->CurrentValue;
		$this->HargaSewa1->CurrentValue = 0;
		$this->HargaSewa1->OldValue = $this->HargaSewa1->CurrentValue;
		$this->HargaSewa2->CurrentValue = 0;
		$this->HargaSewa2->OldValue = $this->HargaSewa2->CurrentValue;
		$this->HargaSewa3->CurrentValue = 0;
		$this->HargaSewa3->OldValue = $this->HargaSewa3->CurrentValue;
		$this->HargaSewa4->CurrentValue = 0;
		$this->HargaSewa4->OldValue = $this->HargaSewa4->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Kode->FldIsDetailKey) {
			$this->Kode->setFormValue($objForm->GetValue("x_Kode"));
		}
		$this->Kode->setOldValue($objForm->GetValue("o_Kode"));
		if (!$this->NamaLapangan->FldIsDetailKey) {
			$this->NamaLapangan->setFormValue($objForm->GetValue("x_NamaLapangan"));
		}
		$this->NamaLapangan->setOldValue($objForm->GetValue("o_NamaLapangan"));
		if (!$this->Ukuran->FldIsDetailKey) {
			$this->Ukuran->setFormValue($objForm->GetValue("x_Ukuran"));
		}
		$this->Ukuran->setOldValue($objForm->GetValue("o_Ukuran"));
		if (!$this->Kondisi->FldIsDetailKey) {
			$this->Kondisi->setFormValue($objForm->GetValue("x_Kondisi"));
		}
		$this->Kondisi->setOldValue($objForm->GetValue("o_Kondisi"));
		if (!$this->HargaSewa1->FldIsDetailKey) {
			$this->HargaSewa1->setFormValue($objForm->GetValue("x_HargaSewa1"));
		}
		$this->HargaSewa1->setOldValue($objForm->GetValue("o_HargaSewa1"));
		if (!$this->HargaSewa2->FldIsDetailKey) {
			$this->HargaSewa2->setFormValue($objForm->GetValue("x_HargaSewa2"));
		}
		$this->HargaSewa2->setOldValue($objForm->GetValue("o_HargaSewa2"));
		if (!$this->HargaSewa3->FldIsDetailKey) {
			$this->HargaSewa3->setFormValue($objForm->GetValue("x_HargaSewa3"));
		}
		$this->HargaSewa3->setOldValue($objForm->GetValue("o_HargaSewa3"));
		if (!$this->HargaSewa4->FldIsDetailKey) {
			$this->HargaSewa4->setFormValue($objForm->GetValue("x_HargaSewa4"));
		}
		$this->HargaSewa4->setOldValue($objForm->GetValue("o_HargaSewa4"));
		if (!$this->ID->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->ID->CurrentValue = $this->ID->FormValue;
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->NamaLapangan->CurrentValue = $this->NamaLapangan->FormValue;
		$this->Ukuran->CurrentValue = $this->Ukuran->FormValue;
		$this->Kondisi->CurrentValue = $this->Kondisi->FormValue;
		$this->HargaSewa1->CurrentValue = $this->HargaSewa1->FormValue;
		$this->HargaSewa2->CurrentValue = $this->HargaSewa2->FormValue;
		$this->HargaSewa3->CurrentValue = $this->HargaSewa3->FormValue;
		$this->HargaSewa4->CurrentValue = $this->HargaSewa4->FormValue;
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
		$this->Ukuran->setDbValue($rs->fields('Ukuran'));
		$this->Kondisi->setDbValue($rs->fields('Kondisi'));
		$this->HargaSewa1->setDbValue($rs->fields('HargaSewa1'));
		$this->HargaSewa2->setDbValue($rs->fields('HargaSewa2'));
		$this->HargaSewa3->setDbValue($rs->fields('HargaSewa3'));
		$this->HargaSewa4->setDbValue($rs->fields('HargaSewa4'));
		$this->HargaSewa5->setDbValue($rs->fields('HargaSewa5'));
		$this->Member->setDbValue($rs->fields('Member'));
		$this->NonMember->setDbValue($rs->fields('NonMember'));
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
		$this->Ukuran->DbValue = $row['Ukuran'];
		$this->Kondisi->DbValue = $row['Kondisi'];
		$this->HargaSewa1->DbValue = $row['HargaSewa1'];
		$this->HargaSewa2->DbValue = $row['HargaSewa2'];
		$this->HargaSewa3->DbValue = $row['HargaSewa3'];
		$this->HargaSewa4->DbValue = $row['HargaSewa4'];
		$this->HargaSewa5->DbValue = $row['HargaSewa5'];
		$this->Member->DbValue = $row['Member'];
		$this->NonMember->DbValue = $row['NonMember'];
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
		// Ukuran
		// Kondisi
		// HargaSewa1
		// HargaSewa2
		// HargaSewa3
		// HargaSewa4
		// HargaSewa5

		$this->HargaSewa5->CellCssStyle = "white-space: nowrap;";

		// Member
		$this->Member->CellCssStyle = "white-space: nowrap;";

		// NonMember
		$this->NonMember->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			$this->Kode->ViewValue = $this->Kode->CurrentValue;
			$this->Kode->ViewCustomAttributes = "";

			// NamaLapangan
			$this->NamaLapangan->ViewValue = $this->NamaLapangan->CurrentValue;
			$this->NamaLapangan->ViewCustomAttributes = "";

			// Ukuran
			$this->Ukuran->ViewValue = $this->Ukuran->CurrentValue;
			$this->Ukuran->ViewCustomAttributes = "";

			// Kondisi
			$this->Kondisi->ViewValue = $this->Kondisi->CurrentValue;
			$this->Kondisi->ViewCustomAttributes = "";

			// HargaSewa1
			$this->HargaSewa1->ViewValue = $this->HargaSewa1->CurrentValue;
			$this->HargaSewa1->ViewValue = ew_FormatNumber($this->HargaSewa1->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa1->CellCssStyle .= "text-align: right;";
			$this->HargaSewa1->ViewCustomAttributes = "";

			// HargaSewa2
			$this->HargaSewa2->ViewValue = $this->HargaSewa2->CurrentValue;
			$this->HargaSewa2->ViewValue = ew_FormatNumber($this->HargaSewa2->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa2->CellCssStyle .= "text-align: right;";
			$this->HargaSewa2->ViewCustomAttributes = "";

			// HargaSewa3
			$this->HargaSewa3->ViewValue = $this->HargaSewa3->CurrentValue;
			$this->HargaSewa3->ViewValue = ew_FormatNumber($this->HargaSewa3->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa3->CellCssStyle .= "text-align: right;";
			$this->HargaSewa3->ViewCustomAttributes = "";

			// HargaSewa4
			$this->HargaSewa4->ViewValue = $this->HargaSewa4->CurrentValue;
			$this->HargaSewa4->ViewValue = ew_FormatNumber($this->HargaSewa4->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa4->CellCssStyle .= "text-align: right;";
			$this->HargaSewa4->ViewCustomAttributes = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// NamaLapangan
			$this->NamaLapangan->LinkCustomAttributes = "";
			$this->NamaLapangan->HrefValue = "";
			$this->NamaLapangan->TooltipValue = "";

			// Ukuran
			$this->Ukuran->LinkCustomAttributes = "";
			$this->Ukuran->HrefValue = "";
			$this->Ukuran->TooltipValue = "";

			// Kondisi
			$this->Kondisi->LinkCustomAttributes = "";
			$this->Kondisi->HrefValue = "";
			$this->Kondisi->TooltipValue = "";

			// HargaSewa1
			$this->HargaSewa1->LinkCustomAttributes = "";
			$this->HargaSewa1->HrefValue = "";
			$this->HargaSewa1->TooltipValue = "";

			// HargaSewa2
			$this->HargaSewa2->LinkCustomAttributes = "";
			$this->HargaSewa2->HrefValue = "";
			$this->HargaSewa2->TooltipValue = "";

			// HargaSewa3
			$this->HargaSewa3->LinkCustomAttributes = "";
			$this->HargaSewa3->HrefValue = "";
			$this->HargaSewa3->TooltipValue = "";

			// HargaSewa4
			$this->HargaSewa4->LinkCustomAttributes = "";
			$this->HargaSewa4->HrefValue = "";
			$this->HargaSewa4->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->CurrentValue);
			$this->Kode->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kode->FldCaption()));

			// NamaLapangan
			$this->NamaLapangan->EditCustomAttributes = "";
			$this->NamaLapangan->EditValue = ew_HtmlEncode($this->NamaLapangan->CurrentValue);
			$this->NamaLapangan->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NamaLapangan->FldCaption()));

			// Ukuran
			$this->Ukuran->EditCustomAttributes = "";
			$this->Ukuran->EditValue = ew_HtmlEncode($this->Ukuran->CurrentValue);
			$this->Ukuran->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Ukuran->FldCaption()));

			// Kondisi
			$this->Kondisi->EditCustomAttributes = "";
			$this->Kondisi->EditValue = ew_HtmlEncode($this->Kondisi->CurrentValue);
			$this->Kondisi->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kondisi->FldCaption()));

			// HargaSewa1
			$this->HargaSewa1->EditCustomAttributes = "";
			$this->HargaSewa1->EditValue = ew_HtmlEncode($this->HargaSewa1->CurrentValue);
			$this->HargaSewa1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa1->FldCaption()));

			// HargaSewa2
			$this->HargaSewa2->EditCustomAttributes = "";
			$this->HargaSewa2->EditValue = ew_HtmlEncode($this->HargaSewa2->CurrentValue);
			$this->HargaSewa2->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa2->FldCaption()));

			// HargaSewa3
			$this->HargaSewa3->EditCustomAttributes = "";
			$this->HargaSewa3->EditValue = ew_HtmlEncode($this->HargaSewa3->CurrentValue);
			$this->HargaSewa3->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa3->FldCaption()));

			// HargaSewa4
			$this->HargaSewa4->EditCustomAttributes = "";
			$this->HargaSewa4->EditValue = ew_HtmlEncode($this->HargaSewa4->CurrentValue);
			$this->HargaSewa4->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa4->FldCaption()));

			// Edit refer script
			// Kode

			$this->Kode->HrefValue = "";

			// NamaLapangan
			$this->NamaLapangan->HrefValue = "";

			// Ukuran
			$this->Ukuran->HrefValue = "";

			// Kondisi
			$this->Kondisi->HrefValue = "";

			// HargaSewa1
			$this->HargaSewa1->HrefValue = "";

			// HargaSewa2
			$this->HargaSewa2->HrefValue = "";

			// HargaSewa3
			$this->HargaSewa3->HrefValue = "";

			// HargaSewa4
			$this->HargaSewa4->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->CurrentValue);
			$this->Kode->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kode->FldCaption()));

			// NamaLapangan
			$this->NamaLapangan->EditCustomAttributes = "";
			$this->NamaLapangan->EditValue = ew_HtmlEncode($this->NamaLapangan->CurrentValue);
			$this->NamaLapangan->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NamaLapangan->FldCaption()));

			// Ukuran
			$this->Ukuran->EditCustomAttributes = "";
			$this->Ukuran->EditValue = ew_HtmlEncode($this->Ukuran->CurrentValue);
			$this->Ukuran->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Ukuran->FldCaption()));

			// Kondisi
			$this->Kondisi->EditCustomAttributes = "";
			$this->Kondisi->EditValue = ew_HtmlEncode($this->Kondisi->CurrentValue);
			$this->Kondisi->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Kondisi->FldCaption()));

			// HargaSewa1
			$this->HargaSewa1->EditCustomAttributes = "";
			$this->HargaSewa1->EditValue = ew_HtmlEncode($this->HargaSewa1->CurrentValue);
			$this->HargaSewa1->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa1->FldCaption()));

			// HargaSewa2
			$this->HargaSewa2->EditCustomAttributes = "";
			$this->HargaSewa2->EditValue = ew_HtmlEncode($this->HargaSewa2->CurrentValue);
			$this->HargaSewa2->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa2->FldCaption()));

			// HargaSewa3
			$this->HargaSewa3->EditCustomAttributes = "";
			$this->HargaSewa3->EditValue = ew_HtmlEncode($this->HargaSewa3->CurrentValue);
			$this->HargaSewa3->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa3->FldCaption()));

			// HargaSewa4
			$this->HargaSewa4->EditCustomAttributes = "";
			$this->HargaSewa4->EditValue = ew_HtmlEncode($this->HargaSewa4->CurrentValue);
			$this->HargaSewa4->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa4->FldCaption()));

			// Edit refer script
			// Kode

			$this->Kode->HrefValue = "";

			// NamaLapangan
			$this->NamaLapangan->HrefValue = "";

			// Ukuran
			$this->Ukuran->HrefValue = "";

			// Kondisi
			$this->Kondisi->HrefValue = "";

			// HargaSewa1
			$this->HargaSewa1->HrefValue = "";

			// HargaSewa2
			$this->HargaSewa2->HrefValue = "";

			// HargaSewa3
			$this->HargaSewa3->HrefValue = "";

			// HargaSewa4
			$this->HargaSewa4->HrefValue = "";
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
		if (!ew_CheckInteger($this->HargaSewa1->FormValue)) {
			ew_AddMessage($gsFormError, $this->HargaSewa1->FldErrMsg());
		}
		if (!ew_CheckInteger($this->HargaSewa2->FormValue)) {
			ew_AddMessage($gsFormError, $this->HargaSewa2->FldErrMsg());
		}
		if (!ew_CheckInteger($this->HargaSewa3->FormValue)) {
			ew_AddMessage($gsFormError, $this->HargaSewa3->FldErrMsg());
		}
		if (!ew_CheckInteger($this->HargaSewa4->FormValue)) {
			ew_AddMessage($gsFormError, $this->HargaSewa4->FldErrMsg());
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

			// NamaLapangan
			$this->NamaLapangan->SetDbValueDef($rsnew, $this->NamaLapangan->CurrentValue, NULL, $this->NamaLapangan->ReadOnly);

			// Ukuran
			$this->Ukuran->SetDbValueDef($rsnew, $this->Ukuran->CurrentValue, NULL, $this->Ukuran->ReadOnly);

			// Kondisi
			$this->Kondisi->SetDbValueDef($rsnew, $this->Kondisi->CurrentValue, NULL, $this->Kondisi->ReadOnly);

			// HargaSewa1
			$this->HargaSewa1->SetDbValueDef($rsnew, $this->HargaSewa1->CurrentValue, NULL, $this->HargaSewa1->ReadOnly);

			// HargaSewa2
			$this->HargaSewa2->SetDbValueDef($rsnew, $this->HargaSewa2->CurrentValue, NULL, $this->HargaSewa2->ReadOnly);

			// HargaSewa3
			$this->HargaSewa3->SetDbValueDef($rsnew, $this->HargaSewa3->CurrentValue, NULL, $this->HargaSewa3->ReadOnly);

			// HargaSewa4
			$this->HargaSewa4->SetDbValueDef($rsnew, $this->HargaSewa4->CurrentValue, NULL, $this->HargaSewa4->ReadOnly);

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

		// NamaLapangan
		$this->NamaLapangan->SetDbValueDef($rsnew, $this->NamaLapangan->CurrentValue, NULL, strval($this->NamaLapangan->CurrentValue) == "");

		// Ukuran
		$this->Ukuran->SetDbValueDef($rsnew, $this->Ukuran->CurrentValue, NULL, strval($this->Ukuran->CurrentValue) == "");

		// Kondisi
		$this->Kondisi->SetDbValueDef($rsnew, $this->Kondisi->CurrentValue, NULL, strval($this->Kondisi->CurrentValue) == "");

		// HargaSewa1
		$this->HargaSewa1->SetDbValueDef($rsnew, $this->HargaSewa1->CurrentValue, NULL, strval($this->HargaSewa1->CurrentValue) == "");

		// HargaSewa2
		$this->HargaSewa2->SetDbValueDef($rsnew, $this->HargaSewa2->CurrentValue, NULL, strval($this->HargaSewa2->CurrentValue) == "");

		// HargaSewa3
		$this->HargaSewa3->SetDbValueDef($rsnew, $this->HargaSewa3->CurrentValue, NULL, strval($this->HargaSewa3->CurrentValue) == "");

		// HargaSewa4
		$this->HargaSewa4->SetDbValueDef($rsnew, $this->HargaSewa4->CurrentValue, NULL, strval($this->HargaSewa4->CurrentValue) == "");

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
		$item->Body = "<a id=\"emf_daftar_lapangan\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_daftar_lapangan',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fdaftar_lapanganlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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
if (!isset($daftar_lapangan_list)) $daftar_lapangan_list = new cdaftar_lapangan_list();

// Page init
$daftar_lapangan_list->Page_Init();

// Page main
$daftar_lapangan_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$daftar_lapangan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($daftar_lapangan->Export == "") { ?>
<script type="text/javascript">

// Page object
var daftar_lapangan_list = new ew_Page("daftar_lapangan_list");
daftar_lapangan_list.PageID = "list"; // Page ID
var EW_PAGE_ID = daftar_lapangan_list.PageID; // For backward compatibility

// Form object
var fdaftar_lapanganlist = new ew_Form("fdaftar_lapanganlist");
fdaftar_lapanganlist.FormKeyCountName = '<?php echo $daftar_lapangan_list->FormKeyCountName ?>';

// Validate form
fdaftar_lapanganlist.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($daftar_lapangan->Kode->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_HargaSewa1");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_lapangan->HargaSewa1->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_HargaSewa2");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_lapangan->HargaSewa2->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_HargaSewa3");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_lapangan->HargaSewa3->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_HargaSewa4");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($daftar_lapangan->HargaSewa4->FldErrMsg()) ?>");

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
fdaftar_lapanganlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Kode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NamaLapangan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Ukuran", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Kondisi", false)) return false;
	if (ew_ValueChanged(fobj, infix, "HargaSewa1", false)) return false;
	if (ew_ValueChanged(fobj, infix, "HargaSewa2", false)) return false;
	if (ew_ValueChanged(fobj, infix, "HargaSewa3", false)) return false;
	if (ew_ValueChanged(fobj, infix, "HargaSewa4", false)) return false;
	return true;
}

// Form_CustomValidate event
fdaftar_lapanganlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdaftar_lapanganlist.ValidateRequired = true;
<?php } else { ?>
fdaftar_lapanganlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($daftar_lapangan->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($daftar_lapangan_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $daftar_lapangan_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($daftar_lapangan->CurrentAction == "gridadd") {
	$daftar_lapangan->CurrentFilter = "0=1";
	$daftar_lapangan_list->StartRec = 1;
	$daftar_lapangan_list->DisplayRecs = $daftar_lapangan->GridAddRowCount;
	$daftar_lapangan_list->TotalRecs = $daftar_lapangan_list->DisplayRecs;
	$daftar_lapangan_list->StopRec = $daftar_lapangan_list->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$daftar_lapangan_list->TotalRecs = $daftar_lapangan->SelectRecordCount();
	} else {
		if ($daftar_lapangan_list->Recordset = $daftar_lapangan_list->LoadRecordset())
			$daftar_lapangan_list->TotalRecs = $daftar_lapangan_list->Recordset->RecordCount();
	}
	$daftar_lapangan_list->StartRec = 1;
	if ($daftar_lapangan_list->DisplayRecs <= 0 || ($daftar_lapangan->Export <> "" && $daftar_lapangan->ExportAll)) // Display all records
		$daftar_lapangan_list->DisplayRecs = $daftar_lapangan_list->TotalRecs;
	if (!($daftar_lapangan->Export <> "" && $daftar_lapangan->ExportAll))
		$daftar_lapangan_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$daftar_lapangan_list->Recordset = $daftar_lapangan_list->LoadRecordset($daftar_lapangan_list->StartRec-1, $daftar_lapangan_list->DisplayRecs);
}
$daftar_lapangan_list->RenderOtherOptions();
?>
<?php $daftar_lapangan_list->ShowPageHeader(); ?>
<?php
$daftar_lapangan_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fdaftar_lapanganlist" id="fdaftar_lapanganlist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="daftar_lapangan">
<div id="gmp_daftar_lapangan" class="ewGridMiddlePanel">
<?php if ($daftar_lapangan_list->TotalRecs > 0) { ?>
<table id="tbl_daftar_lapanganlist" class="ewTable ewTableSeparate">
<?php echo $daftar_lapangan->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$daftar_lapangan_list->RenderListOptions();

// Render list options (header, left)
$daftar_lapangan_list->ListOptions->Render("header", "left");
?>
<?php if ($daftar_lapangan->Kode->Visible) { // Kode ?>
	<?php if ($daftar_lapangan->SortUrl($daftar_lapangan->Kode) == "") { ?>
		<td><div id="elh_daftar_lapangan_Kode" class="daftar_lapangan_Kode"><div class="ewTableHeaderCaption"><?php echo $daftar_lapangan->Kode->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_lapangan->SortUrl($daftar_lapangan->Kode) ?>',1);"><div id="elh_daftar_lapangan_Kode" class="daftar_lapangan_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_lapangan->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_lapangan->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_lapangan->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_lapangan->NamaLapangan->Visible) { // NamaLapangan ?>
	<?php if ($daftar_lapangan->SortUrl($daftar_lapangan->NamaLapangan) == "") { ?>
		<td><div id="elh_daftar_lapangan_NamaLapangan" class="daftar_lapangan_NamaLapangan"><div class="ewTableHeaderCaption"><?php echo $daftar_lapangan->NamaLapangan->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_lapangan->SortUrl($daftar_lapangan->NamaLapangan) ?>',1);"><div id="elh_daftar_lapangan_NamaLapangan" class="daftar_lapangan_NamaLapangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_lapangan->NamaLapangan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_lapangan->NamaLapangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_lapangan->NamaLapangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_lapangan->Ukuran->Visible) { // Ukuran ?>
	<?php if ($daftar_lapangan->SortUrl($daftar_lapangan->Ukuran) == "") { ?>
		<td><div id="elh_daftar_lapangan_Ukuran" class="daftar_lapangan_Ukuran"><div class="ewTableHeaderCaption"><?php echo $daftar_lapangan->Ukuran->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_lapangan->SortUrl($daftar_lapangan->Ukuran) ?>',1);"><div id="elh_daftar_lapangan_Ukuran" class="daftar_lapangan_Ukuran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_lapangan->Ukuran->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_lapangan->Ukuran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_lapangan->Ukuran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_lapangan->Kondisi->Visible) { // Kondisi ?>
	<?php if ($daftar_lapangan->SortUrl($daftar_lapangan->Kondisi) == "") { ?>
		<td><div id="elh_daftar_lapangan_Kondisi" class="daftar_lapangan_Kondisi"><div class="ewTableHeaderCaption"><?php echo $daftar_lapangan->Kondisi->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_lapangan->SortUrl($daftar_lapangan->Kondisi) ?>',1);"><div id="elh_daftar_lapangan_Kondisi" class="daftar_lapangan_Kondisi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_lapangan->Kondisi->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_lapangan->Kondisi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_lapangan->Kondisi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_lapangan->HargaSewa1->Visible) { // HargaSewa1 ?>
	<?php if ($daftar_lapangan->SortUrl($daftar_lapangan->HargaSewa1) == "") { ?>
		<td><div id="elh_daftar_lapangan_HargaSewa1" class="daftar_lapangan_HargaSewa1"><div class="ewTableHeaderCaption"><?php echo $daftar_lapangan->HargaSewa1->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_lapangan->SortUrl($daftar_lapangan->HargaSewa1) ?>',1);"><div id="elh_daftar_lapangan_HargaSewa1" class="daftar_lapangan_HargaSewa1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_lapangan->HargaSewa1->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_lapangan->HargaSewa1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_lapangan->HargaSewa1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_lapangan->HargaSewa2->Visible) { // HargaSewa2 ?>
	<?php if ($daftar_lapangan->SortUrl($daftar_lapangan->HargaSewa2) == "") { ?>
		<td><div id="elh_daftar_lapangan_HargaSewa2" class="daftar_lapangan_HargaSewa2"><div class="ewTableHeaderCaption"><?php echo $daftar_lapangan->HargaSewa2->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_lapangan->SortUrl($daftar_lapangan->HargaSewa2) ?>',1);"><div id="elh_daftar_lapangan_HargaSewa2" class="daftar_lapangan_HargaSewa2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_lapangan->HargaSewa2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_lapangan->HargaSewa2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_lapangan->HargaSewa2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_lapangan->HargaSewa3->Visible) { // HargaSewa3 ?>
	<?php if ($daftar_lapangan->SortUrl($daftar_lapangan->HargaSewa3) == "") { ?>
		<td><div id="elh_daftar_lapangan_HargaSewa3" class="daftar_lapangan_HargaSewa3"><div class="ewTableHeaderCaption"><?php echo $daftar_lapangan->HargaSewa3->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_lapangan->SortUrl($daftar_lapangan->HargaSewa3) ?>',1);"><div id="elh_daftar_lapangan_HargaSewa3" class="daftar_lapangan_HargaSewa3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_lapangan->HargaSewa3->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_lapangan->HargaSewa3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_lapangan->HargaSewa3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($daftar_lapangan->HargaSewa4->Visible) { // HargaSewa4 ?>
	<?php if ($daftar_lapangan->SortUrl($daftar_lapangan->HargaSewa4) == "") { ?>
		<td><div id="elh_daftar_lapangan_HargaSewa4" class="daftar_lapangan_HargaSewa4"><div class="ewTableHeaderCaption"><?php echo $daftar_lapangan->HargaSewa4->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $daftar_lapangan->SortUrl($daftar_lapangan->HargaSewa4) ?>',1);"><div id="elh_daftar_lapangan_HargaSewa4" class="daftar_lapangan_HargaSewa4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $daftar_lapangan->HargaSewa4->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($daftar_lapangan->HargaSewa4->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($daftar_lapangan->HargaSewa4->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$daftar_lapangan_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($daftar_lapangan->ExportAll && $daftar_lapangan->Export <> "") {
	$daftar_lapangan_list->StopRec = $daftar_lapangan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($daftar_lapangan_list->TotalRecs > $daftar_lapangan_list->StartRec + $daftar_lapangan_list->DisplayRecs - 1)
		$daftar_lapangan_list->StopRec = $daftar_lapangan_list->StartRec + $daftar_lapangan_list->DisplayRecs - 1;
	else
		$daftar_lapangan_list->StopRec = $daftar_lapangan_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($daftar_lapangan_list->FormKeyCountName) && ($daftar_lapangan->CurrentAction == "gridadd" || $daftar_lapangan->CurrentAction == "gridedit" || $daftar_lapangan->CurrentAction == "F")) {
		$daftar_lapangan_list->KeyCount = $objForm->GetValue($daftar_lapangan_list->FormKeyCountName);
		$daftar_lapangan_list->StopRec = $daftar_lapangan_list->StartRec + $daftar_lapangan_list->KeyCount - 1;
	}
}
$daftar_lapangan_list->RecCnt = $daftar_lapangan_list->StartRec - 1;
if ($daftar_lapangan_list->Recordset && !$daftar_lapangan_list->Recordset->EOF) {
	$daftar_lapangan_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $daftar_lapangan_list->StartRec > 1)
		$daftar_lapangan_list->Recordset->Move($daftar_lapangan_list->StartRec - 1);
} elseif (!$daftar_lapangan->AllowAddDeleteRow && $daftar_lapangan_list->StopRec == 0) {
	$daftar_lapangan_list->StopRec = $daftar_lapangan->GridAddRowCount;
}

// Initialize aggregate
$daftar_lapangan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$daftar_lapangan->ResetAttrs();
$daftar_lapangan_list->RenderRow();
if ($daftar_lapangan->CurrentAction == "gridadd")
	$daftar_lapangan_list->RowIndex = 0;
if ($daftar_lapangan->CurrentAction == "gridedit")
	$daftar_lapangan_list->RowIndex = 0;
while ($daftar_lapangan_list->RecCnt < $daftar_lapangan_list->StopRec) {
	$daftar_lapangan_list->RecCnt++;
	if (intval($daftar_lapangan_list->RecCnt) >= intval($daftar_lapangan_list->StartRec)) {
		$daftar_lapangan_list->RowCnt++;
		if ($daftar_lapangan->CurrentAction == "gridadd" || $daftar_lapangan->CurrentAction == "gridedit" || $daftar_lapangan->CurrentAction == "F") {
			$daftar_lapangan_list->RowIndex++;
			$objForm->Index = $daftar_lapangan_list->RowIndex;
			if ($objForm->HasValue($daftar_lapangan_list->FormActionName))
				$daftar_lapangan_list->RowAction = strval($objForm->GetValue($daftar_lapangan_list->FormActionName));
			elseif ($daftar_lapangan->CurrentAction == "gridadd")
				$daftar_lapangan_list->RowAction = "insert";
			else
				$daftar_lapangan_list->RowAction = "";
		}

		// Set up key count
		$daftar_lapangan_list->KeyCount = $daftar_lapangan_list->RowIndex;

		// Init row class and style
		$daftar_lapangan->ResetAttrs();
		$daftar_lapangan->CssClass = "";
		if ($daftar_lapangan->CurrentAction == "gridadd") {
			$daftar_lapangan_list->LoadDefaultValues(); // Load default values
		} else {
			$daftar_lapangan_list->LoadRowValues($daftar_lapangan_list->Recordset); // Load row values
		}
		$daftar_lapangan->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($daftar_lapangan->CurrentAction == "gridadd") // Grid add
			$daftar_lapangan->RowType = EW_ROWTYPE_ADD; // Render add
		if ($daftar_lapangan->CurrentAction == "gridadd" && $daftar_lapangan->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$daftar_lapangan_list->RestoreCurrentRowFormValues($daftar_lapangan_list->RowIndex); // Restore form values
		if ($daftar_lapangan->CurrentAction == "gridedit") { // Grid edit
			if ($daftar_lapangan->EventCancelled) {
				$daftar_lapangan_list->RestoreCurrentRowFormValues($daftar_lapangan_list->RowIndex); // Restore form values
			}
			if ($daftar_lapangan_list->RowAction == "insert")
				$daftar_lapangan->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$daftar_lapangan->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($daftar_lapangan->CurrentAction == "gridedit" && ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT || $daftar_lapangan->RowType == EW_ROWTYPE_ADD) && $daftar_lapangan->EventCancelled) // Update failed
			$daftar_lapangan_list->RestoreCurrentRowFormValues($daftar_lapangan_list->RowIndex); // Restore form values
		if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT) // Edit row
			$daftar_lapangan_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$daftar_lapangan->RowAttrs = array_merge($daftar_lapangan->RowAttrs, array('data-rowindex'=>$daftar_lapangan_list->RowCnt, 'id'=>'r' . $daftar_lapangan_list->RowCnt . '_daftar_lapangan', 'data-rowtype'=>$daftar_lapangan->RowType));

		// Render row
		$daftar_lapangan_list->RenderRow();

		// Render list options
		$daftar_lapangan_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($daftar_lapangan_list->RowAction <> "delete" && $daftar_lapangan_list->RowAction <> "insertdelete" && !($daftar_lapangan_list->RowAction == "insert" && $daftar_lapangan->CurrentAction == "F" && $daftar_lapangan_list->EmptyRow())) {
?>
	<tr<?php echo $daftar_lapangan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$daftar_lapangan_list->ListOptions->Render("body", "left", $daftar_lapangan_list->RowCnt);
?>
	<?php if ($daftar_lapangan->Kode->Visible) { // Kode ?>
		<td<?php echo $daftar_lapangan->Kode->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_list->RowCnt ?>_daftar_lapangan_Kode" class="control-group daftar_lapangan_Kode">
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Kode" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" size="30" maxlength="50" placeholder="<?php echo $daftar_lapangan->Kode->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Kode->EditValue ?>"<?php echo $daftar_lapangan->Kode->EditAttributes() ?>>
<input type="hidden" data-field="x_Kode" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($daftar_lapangan->Kode->OldValue) ?>">
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Kode" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" size="30" maxlength="50" placeholder="<?php echo $daftar_lapangan->Kode->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Kode->EditValue ?>"<?php echo $daftar_lapangan->Kode->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_lapangan->Kode->ViewAttributes() ?>>
<?php echo $daftar_lapangan->Kode->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_lapangan_list->PageObjName . "_row_" . $daftar_lapangan_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_ID" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($daftar_lapangan->ID->CurrentValue) ?>">
<input type="hidden" data-field="x_ID" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_ID" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($daftar_lapangan->ID->OldValue) ?>">
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT || $daftar_lapangan->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_ID" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_ID" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_ID" value="<?php echo ew_HtmlEncode($daftar_lapangan->ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($daftar_lapangan->NamaLapangan->Visible) { // NamaLapangan ?>
		<td<?php echo $daftar_lapangan->NamaLapangan->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_list->RowCnt ?>_daftar_lapangan_NamaLapangan" class="control-group daftar_lapangan_NamaLapangan">
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_NamaLapangan" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->NamaLapangan->PlaceHolder ?>" value="<?php echo $daftar_lapangan->NamaLapangan->EditValue ?>"<?php echo $daftar_lapangan->NamaLapangan->EditAttributes() ?>>
<input type="hidden" data-field="x_NamaLapangan" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" value="<?php echo ew_HtmlEncode($daftar_lapangan->NamaLapangan->OldValue) ?>">
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_NamaLapangan" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->NamaLapangan->PlaceHolder ?>" value="<?php echo $daftar_lapangan->NamaLapangan->EditValue ?>"<?php echo $daftar_lapangan->NamaLapangan->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_lapangan->NamaLapangan->ViewAttributes() ?>>
<?php echo $daftar_lapangan->NamaLapangan->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_lapangan_list->PageObjName . "_row_" . $daftar_lapangan_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_lapangan->Ukuran->Visible) { // Ukuran ?>
		<td<?php echo $daftar_lapangan->Ukuran->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_list->RowCnt ?>_daftar_lapangan_Ukuran" class="control-group daftar_lapangan_Ukuran">
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Ukuran" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->Ukuran->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Ukuran->EditValue ?>"<?php echo $daftar_lapangan->Ukuran->EditAttributes() ?>>
<input type="hidden" data-field="x_Ukuran" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" value="<?php echo ew_HtmlEncode($daftar_lapangan->Ukuran->OldValue) ?>">
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Ukuran" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->Ukuran->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Ukuran->EditValue ?>"<?php echo $daftar_lapangan->Ukuran->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_lapangan->Ukuran->ViewAttributes() ?>>
<?php echo $daftar_lapangan->Ukuran->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_lapangan_list->PageObjName . "_row_" . $daftar_lapangan_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_lapangan->Kondisi->Visible) { // Kondisi ?>
		<td<?php echo $daftar_lapangan->Kondisi->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_list->RowCnt ?>_daftar_lapangan_Kondisi" class="control-group daftar_lapangan_Kondisi">
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_Kondisi" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->Kondisi->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Kondisi->EditValue ?>"<?php echo $daftar_lapangan->Kondisi->EditAttributes() ?>>
<input type="hidden" data-field="x_Kondisi" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" value="<?php echo ew_HtmlEncode($daftar_lapangan->Kondisi->OldValue) ?>">
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_Kondisi" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->Kondisi->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Kondisi->EditValue ?>"<?php echo $daftar_lapangan->Kondisi->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_lapangan->Kondisi->ViewAttributes() ?>>
<?php echo $daftar_lapangan->Kondisi->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_lapangan_list->PageObjName . "_row_" . $daftar_lapangan_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_lapangan->HargaSewa1->Visible) { // HargaSewa1 ?>
		<td<?php echo $daftar_lapangan->HargaSewa1->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_list->RowCnt ?>_daftar_lapangan_HargaSewa1" class="control-group daftar_lapangan_HargaSewa1">
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_HargaSewa1" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa1->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa1->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa1->EditAttributes() ?>>
<input type="hidden" data-field="x_HargaSewa1" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" value="<?php echo ew_HtmlEncode($daftar_lapangan->HargaSewa1->OldValue) ?>">
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_HargaSewa1" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa1->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa1->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa1->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_lapangan->HargaSewa1->ViewAttributes() ?>>
<?php echo $daftar_lapangan->HargaSewa1->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_lapangan_list->PageObjName . "_row_" . $daftar_lapangan_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_lapangan->HargaSewa2->Visible) { // HargaSewa2 ?>
		<td<?php echo $daftar_lapangan->HargaSewa2->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_list->RowCnt ?>_daftar_lapangan_HargaSewa2" class="control-group daftar_lapangan_HargaSewa2">
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_HargaSewa2" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa2->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa2->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa2->EditAttributes() ?>>
<input type="hidden" data-field="x_HargaSewa2" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" value="<?php echo ew_HtmlEncode($daftar_lapangan->HargaSewa2->OldValue) ?>">
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_HargaSewa2" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa2->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa2->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa2->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_lapangan->HargaSewa2->ViewAttributes() ?>>
<?php echo $daftar_lapangan->HargaSewa2->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_lapangan_list->PageObjName . "_row_" . $daftar_lapangan_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_lapangan->HargaSewa3->Visible) { // HargaSewa3 ?>
		<td<?php echo $daftar_lapangan->HargaSewa3->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_list->RowCnt ?>_daftar_lapangan_HargaSewa3" class="control-group daftar_lapangan_HargaSewa3">
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_HargaSewa3" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa3->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa3->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa3->EditAttributes() ?>>
<input type="hidden" data-field="x_HargaSewa3" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" value="<?php echo ew_HtmlEncode($daftar_lapangan->HargaSewa3->OldValue) ?>">
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_HargaSewa3" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa3->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa3->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa3->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_lapangan->HargaSewa3->ViewAttributes() ?>>
<?php echo $daftar_lapangan->HargaSewa3->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_lapangan_list->PageObjName . "_row_" . $daftar_lapangan_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($daftar_lapangan->HargaSewa4->Visible) { // HargaSewa4 ?>
		<td<?php echo $daftar_lapangan->HargaSewa4->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_list->RowCnt ?>_daftar_lapangan_HargaSewa4" class="control-group daftar_lapangan_HargaSewa4">
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" data-field="x_HargaSewa4" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa4->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa4->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa4->EditAttributes() ?>>
<input type="hidden" data-field="x_HargaSewa4" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" value="<?php echo ew_HtmlEncode($daftar_lapangan->HargaSewa4->OldValue) ?>">
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-field="x_HargaSewa4" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa4->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa4->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa4->EditAttributes() ?>>
<?php } ?>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $daftar_lapangan->HargaSewa4->ViewAttributes() ?>>
<?php echo $daftar_lapangan->HargaSewa4->ListViewValue() ?></span>
<?php } ?>
</span><a id="<?php echo $daftar_lapangan_list->PageObjName . "_row_" . $daftar_lapangan_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$daftar_lapangan_list->ListOptions->Render("body", "right", $daftar_lapangan_list->RowCnt);
?>
	</tr>
<?php if ($daftar_lapangan->RowType == EW_ROWTYPE_ADD || $daftar_lapangan->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdaftar_lapanganlist.UpdateOpts(<?php echo $daftar_lapangan_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($daftar_lapangan->CurrentAction <> "gridadd")
		if (!$daftar_lapangan_list->Recordset->EOF) $daftar_lapangan_list->Recordset->MoveNext();
}
?>
<?php
	if ($daftar_lapangan->CurrentAction == "gridadd" || $daftar_lapangan->CurrentAction == "gridedit") {
		$daftar_lapangan_list->RowIndex = '$rowindex$';
		$daftar_lapangan_list->LoadDefaultValues();

		// Set row properties
		$daftar_lapangan->ResetAttrs();
		$daftar_lapangan->RowAttrs = array_merge($daftar_lapangan->RowAttrs, array('data-rowindex'=>$daftar_lapangan_list->RowIndex, 'id'=>'r0_daftar_lapangan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($daftar_lapangan->RowAttrs["class"], "ewTemplate");
		$daftar_lapangan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$daftar_lapangan_list->RenderRow();

		// Render list options
		$daftar_lapangan_list->RenderListOptions();
		$daftar_lapangan_list->StartRowCnt = 0;
?>
	<tr<?php echo $daftar_lapangan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$daftar_lapangan_list->ListOptions->Render("body", "left", $daftar_lapangan_list->RowIndex);
?>
	<?php if ($daftar_lapangan->Kode->Visible) { // Kode ?>
		<td><span id="el$rowindex$_daftar_lapangan_Kode" class="control-group daftar_lapangan_Kode">
<input type="text" data-field="x_Kode" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" size="30" maxlength="50" placeholder="<?php echo $daftar_lapangan->Kode->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Kode->EditValue ?>"<?php echo $daftar_lapangan->Kode->EditAttributes() ?>>
<input type="hidden" data-field="x_Kode" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($daftar_lapangan->Kode->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_lapangan->NamaLapangan->Visible) { // NamaLapangan ?>
		<td><span id="el$rowindex$_daftar_lapangan_NamaLapangan" class="control-group daftar_lapangan_NamaLapangan">
<input type="text" data-field="x_NamaLapangan" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->NamaLapangan->PlaceHolder ?>" value="<?php echo $daftar_lapangan->NamaLapangan->EditValue ?>"<?php echo $daftar_lapangan->NamaLapangan->EditAttributes() ?>>
<input type="hidden" data-field="x_NamaLapangan" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_NamaLapangan" value="<?php echo ew_HtmlEncode($daftar_lapangan->NamaLapangan->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_lapangan->Ukuran->Visible) { // Ukuran ?>
		<td><span id="el$rowindex$_daftar_lapangan_Ukuran" class="control-group daftar_lapangan_Ukuran">
<input type="text" data-field="x_Ukuran" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->Ukuran->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Ukuran->EditValue ?>"<?php echo $daftar_lapangan->Ukuran->EditAttributes() ?>>
<input type="hidden" data-field="x_Ukuran" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_Ukuran" value="<?php echo ew_HtmlEncode($daftar_lapangan->Ukuran->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_lapangan->Kondisi->Visible) { // Kondisi ?>
		<td><span id="el$rowindex$_daftar_lapangan_Kondisi" class="control-group daftar_lapangan_Kondisi">
<input type="text" data-field="x_Kondisi" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" size="30" maxlength="100" placeholder="<?php echo $daftar_lapangan->Kondisi->PlaceHolder ?>" value="<?php echo $daftar_lapangan->Kondisi->EditValue ?>"<?php echo $daftar_lapangan->Kondisi->EditAttributes() ?>>
<input type="hidden" data-field="x_Kondisi" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_Kondisi" value="<?php echo ew_HtmlEncode($daftar_lapangan->Kondisi->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_lapangan->HargaSewa1->Visible) { // HargaSewa1 ?>
		<td><span id="el$rowindex$_daftar_lapangan_HargaSewa1" class="control-group daftar_lapangan_HargaSewa1">
<input type="text" data-field="x_HargaSewa1" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa1->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa1->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa1->EditAttributes() ?>>
<input type="hidden" data-field="x_HargaSewa1" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa1" value="<?php echo ew_HtmlEncode($daftar_lapangan->HargaSewa1->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_lapangan->HargaSewa2->Visible) { // HargaSewa2 ?>
		<td><span id="el$rowindex$_daftar_lapangan_HargaSewa2" class="control-group daftar_lapangan_HargaSewa2">
<input type="text" data-field="x_HargaSewa2" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa2->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa2->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa2->EditAttributes() ?>>
<input type="hidden" data-field="x_HargaSewa2" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa2" value="<?php echo ew_HtmlEncode($daftar_lapangan->HargaSewa2->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_lapangan->HargaSewa3->Visible) { // HargaSewa3 ?>
		<td><span id="el$rowindex$_daftar_lapangan_HargaSewa3" class="control-group daftar_lapangan_HargaSewa3">
<input type="text" data-field="x_HargaSewa3" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa3->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa3->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa3->EditAttributes() ?>>
<input type="hidden" data-field="x_HargaSewa3" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa3" value="<?php echo ew_HtmlEncode($daftar_lapangan->HargaSewa3->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($daftar_lapangan->HargaSewa4->Visible) { // HargaSewa4 ?>
		<td><span id="el$rowindex$_daftar_lapangan_HargaSewa4" class="control-group daftar_lapangan_HargaSewa4">
<input type="text" data-field="x_HargaSewa4" name="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" id="x<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" size="30" placeholder="<?php echo $daftar_lapangan->HargaSewa4->PlaceHolder ?>" value="<?php echo $daftar_lapangan->HargaSewa4->EditValue ?>"<?php echo $daftar_lapangan->HargaSewa4->EditAttributes() ?>>
<input type="hidden" data-field="x_HargaSewa4" name="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" id="o<?php echo $daftar_lapangan_list->RowIndex ?>_HargaSewa4" value="<?php echo ew_HtmlEncode($daftar_lapangan->HargaSewa4->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$daftar_lapangan_list->ListOptions->Render("body", "right", $daftar_lapangan_list->RowCnt);
?>
<script type="text/javascript">
fdaftar_lapanganlist.UpdateOpts(<?php echo $daftar_lapangan_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($daftar_lapangan->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $daftar_lapangan_list->FormKeyCountName ?>" id="<?php echo $daftar_lapangan_list->FormKeyCountName ?>" value="<?php echo $daftar_lapangan_list->KeyCount ?>">
<?php echo $daftar_lapangan_list->MultiSelectKey ?>
<?php } ?>
<?php if ($daftar_lapangan->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $daftar_lapangan_list->FormKeyCountName ?>" id="<?php echo $daftar_lapangan_list->FormKeyCountName ?>" value="<?php echo $daftar_lapangan_list->KeyCount ?>">
<?php echo $daftar_lapangan_list->MultiSelectKey ?>
<?php } ?>
<?php if ($daftar_lapangan->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($daftar_lapangan_list->Recordset)
	$daftar_lapangan_list->Recordset->Close();
?>
<?php if ($daftar_lapangan->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($daftar_lapangan->CurrentAction <> "gridadd" && $daftar_lapangan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($daftar_lapangan_list->Pager)) $daftar_lapangan_list->Pager = new cNumericPager($daftar_lapangan_list->StartRec, $daftar_lapangan_list->DisplayRecs, $daftar_lapangan_list->TotalRecs, $daftar_lapangan_list->RecRange) ?>
<?php if ($daftar_lapangan_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($daftar_lapangan_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $daftar_lapangan_list->PageUrl() ?>start=<?php echo $daftar_lapangan_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($daftar_lapangan_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $daftar_lapangan_list->PageUrl() ?>start=<?php echo $daftar_lapangan_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($daftar_lapangan_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $daftar_lapangan_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($daftar_lapangan_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $daftar_lapangan_list->PageUrl() ?>start=<?php echo $daftar_lapangan_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($daftar_lapangan_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $daftar_lapangan_list->PageUrl() ?>start=<?php echo $daftar_lapangan_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($daftar_lapangan_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $daftar_lapangan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $daftar_lapangan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $daftar_lapangan_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($daftar_lapangan_list->SearchWhere == "0=101") { ?>
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
	foreach ($daftar_lapangan_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
</td></tr></table>
<?php if ($daftar_lapangan->Export == "") { ?>
<script type="text/javascript">
fdaftar_lapanganlist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$daftar_lapangan_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($daftar_lapangan->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$daftar_lapangan_list->Page_Terminate();
?>

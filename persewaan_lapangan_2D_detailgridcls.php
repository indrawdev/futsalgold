<?php include_once "persewaan_lapangan_2D_detailinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php

//
// Page class
//

$persewaan_lapangan_2D_detail_grid = NULL; // Initialize page object first

class cpersewaan_lapangan_2D_detail_grid extends cpersewaan_lapangan_2D_detail {

	// Page ID
	var $PageID = 'grid';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'persewaan lapangan - detail';

	// Page object name
	var $PageObjName = 'persewaan_lapangan_2D_detail_grid';

	// Grid form hidden field names
	var $FormName = 'fpersewaan_lapangan_2D_detailgrid';
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
		$this->FormActionName .= '_' . $this->FormName;
		$this->FormKeyName .= '_' . $this->FormName;
		$this->FormOldKeyName .= '_' . $this->FormName;
		$this->FormBlankRowName .= '_' . $this->FormName;
		$this->FormKeyCountName .= '_' . $this->FormName;
		$GLOBALS["Grid"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (persewaan_lapangan_2D_detail)
		if (!isset($GLOBALS["persewaan_lapangan_2D_detail"])) {
			$GLOBALS["persewaan_lapangan_2D_detail"] = &$this;

//			$GLOBALS["MasterTable"] = &$GLOBALS["Table"];
//			if (!isset($GLOBALS["Table"])) $GLOBALS["Table"] = &$GLOBALS["persewaan_lapangan_2D_detail"];

		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

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

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "span";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Setup other options
		$this->SetupOtherOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url == "")
			return;

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

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
	var $ShowOtherOptions = FALSE;
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

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterParms();

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

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
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
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
				$this->LoadOldRecord(); // Load old recordset
			}
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
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
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
		if ($objForm->HasValue("x_TglSewa") && $objForm->HasValue("o_TglSewa") && $this->TglSewa->CurrentValue <> $this->TglSewa->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_JamSewa") && $objForm->HasValue("o_JamSewa") && $this->JamSewa->CurrentValue <> $this->JamSewa->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_HargaSewa") && $objForm->HasValue("o_HargaSewa") && $this->HargaSewa->CurrentValue <> $this->HargaSewa->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Hitung") && $objForm->HasValue("o_Hitung") && $this->Hitung->CurrentValue <> $this->Hitung->OldValue)
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

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		$this->ListOptions->ButtonClass = "btn-small"; // Class for button group
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
			if ($objForm->HasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $OldKeyName . "\" id=\"" . $OldKeyName . "\" value=\"" . ew_HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
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
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->ID->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs->fields('ID');
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$option = &$this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;
		$option->ButtonClass = "btn-small"; // Class for button group
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && $this->CurrentAction != "F") { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = &$options["addedit"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
				$item = &$option->Add("addblankrow");
				$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
				$item->Visible = $Security->CanAdd();
				$this->ShowOtherOptions = $item->Visible;
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Kode->CurrentValue = NULL;
		$this->Kode->OldValue = $this->Kode->CurrentValue;
		$this->NamaLapangan->CurrentValue = NULL;
		$this->NamaLapangan->OldValue = $this->NamaLapangan->CurrentValue;
		$this->TglSewa->CurrentValue = ew_CurrentDate();
		$this->TglSewa->OldValue = $this->TglSewa->CurrentValue;
		$this->JamSewa->CurrentValue = ew_CurrentTime();
		$this->JamSewa->OldValue = $this->JamSewa->CurrentValue;
		$this->HargaSewa->CurrentValue = NULL;
		$this->HargaSewa->OldValue = $this->HargaSewa->CurrentValue;
		$this->Hitung->CurrentValue = "Hitung";
		$this->Hitung->OldValue = $this->Hitung->CurrentValue;
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
		if (!$this->TglSewa->FldIsDetailKey) {
			$this->TglSewa->setFormValue($objForm->GetValue("x_TglSewa"));
			$this->TglSewa->CurrentValue = ew_UnFormatDateTime($this->TglSewa->CurrentValue, 7);
		}
		$this->TglSewa->setOldValue($objForm->GetValue("o_TglSewa"));
		if (!$this->JamSewa->FldIsDetailKey) {
			$this->JamSewa->setFormValue($objForm->GetValue("x_JamSewa"));
		}
		$this->JamSewa->setOldValue($objForm->GetValue("o_JamSewa"));
		if (!$this->HargaSewa->FldIsDetailKey) {
			$this->HargaSewa->setFormValue($objForm->GetValue("x_HargaSewa"));
		}
		$this->HargaSewa->setOldValue($objForm->GetValue("o_HargaSewa"));
		if (!$this->Hitung->FldIsDetailKey) {
			$this->Hitung->setFormValue($objForm->GetValue("x_Hitung"));
		}
		$this->Hitung->setOldValue($objForm->GetValue("o_Hitung"));
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
		$this->TglSewa->CurrentValue = $this->TglSewa->FormValue;
		$this->TglSewa->CurrentValue = ew_UnFormatDateTime($this->TglSewa->CurrentValue, 7);
		$this->JamSewa->CurrentValue = $this->JamSewa->FormValue;
		$this->HargaSewa->CurrentValue = $this->HargaSewa->FormValue;
		$this->Hitung->CurrentValue = $this->Hitung->FormValue;
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
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$this->ID->CurrentValue = strval($arKeys[0]); // ID
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaLapangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `daftar lapangan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Kode, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Kode->EditValue = $arwrk;

			// NamaLapangan
			$this->NamaLapangan->EditCustomAttributes = "";
			$this->NamaLapangan->EditValue = ew_HtmlEncode($this->NamaLapangan->CurrentValue);
			$this->NamaLapangan->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NamaLapangan->FldCaption()));

			// TglSewa
			$this->TglSewa->EditCustomAttributes = "";
			$this->TglSewa->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TglSewa->CurrentValue, 7));
			$this->TglSewa->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->TglSewa->FldCaption()));

			// JamSewa
			$this->JamSewa->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->JamSewa->FldTagValue(1), $this->JamSewa->FldTagCaption(1) <> "" ? $this->JamSewa->FldTagCaption(1) : $this->JamSewa->FldTagValue(1));
			$arwrk[] = array($this->JamSewa->FldTagValue(2), $this->JamSewa->FldTagCaption(2) <> "" ? $this->JamSewa->FldTagCaption(2) : $this->JamSewa->FldTagValue(2));
			$arwrk[] = array($this->JamSewa->FldTagValue(3), $this->JamSewa->FldTagCaption(3) <> "" ? $this->JamSewa->FldTagCaption(3) : $this->JamSewa->FldTagValue(3));
			$arwrk[] = array($this->JamSewa->FldTagValue(4), $this->JamSewa->FldTagCaption(4) <> "" ? $this->JamSewa->FldTagCaption(4) : $this->JamSewa->FldTagValue(4));
			$arwrk[] = array($this->JamSewa->FldTagValue(5), $this->JamSewa->FldTagCaption(5) <> "" ? $this->JamSewa->FldTagCaption(5) : $this->JamSewa->FldTagValue(5));
			$arwrk[] = array($this->JamSewa->FldTagValue(6), $this->JamSewa->FldTagCaption(6) <> "" ? $this->JamSewa->FldTagCaption(6) : $this->JamSewa->FldTagValue(6));
			$arwrk[] = array($this->JamSewa->FldTagValue(7), $this->JamSewa->FldTagCaption(7) <> "" ? $this->JamSewa->FldTagCaption(7) : $this->JamSewa->FldTagValue(7));
			$arwrk[] = array($this->JamSewa->FldTagValue(8), $this->JamSewa->FldTagCaption(8) <> "" ? $this->JamSewa->FldTagCaption(8) : $this->JamSewa->FldTagValue(8));
			$arwrk[] = array($this->JamSewa->FldTagValue(9), $this->JamSewa->FldTagCaption(9) <> "" ? $this->JamSewa->FldTagCaption(9) : $this->JamSewa->FldTagValue(9));
			$arwrk[] = array($this->JamSewa->FldTagValue(10), $this->JamSewa->FldTagCaption(10) <> "" ? $this->JamSewa->FldTagCaption(10) : $this->JamSewa->FldTagValue(10));
			$arwrk[] = array($this->JamSewa->FldTagValue(11), $this->JamSewa->FldTagCaption(11) <> "" ? $this->JamSewa->FldTagCaption(11) : $this->JamSewa->FldTagValue(11));
			$arwrk[] = array($this->JamSewa->FldTagValue(12), $this->JamSewa->FldTagCaption(12) <> "" ? $this->JamSewa->FldTagCaption(12) : $this->JamSewa->FldTagValue(12));
			$arwrk[] = array($this->JamSewa->FldTagValue(13), $this->JamSewa->FldTagCaption(13) <> "" ? $this->JamSewa->FldTagCaption(13) : $this->JamSewa->FldTagValue(13));
			$arwrk[] = array($this->JamSewa->FldTagValue(14), $this->JamSewa->FldTagCaption(14) <> "" ? $this->JamSewa->FldTagCaption(14) : $this->JamSewa->FldTagValue(14));
			$arwrk[] = array($this->JamSewa->FldTagValue(15), $this->JamSewa->FldTagCaption(15) <> "" ? $this->JamSewa->FldTagCaption(15) : $this->JamSewa->FldTagValue(15));
			$arwrk[] = array($this->JamSewa->FldTagValue(16), $this->JamSewa->FldTagCaption(16) <> "" ? $this->JamSewa->FldTagCaption(16) : $this->JamSewa->FldTagValue(16));
			$arwrk[] = array($this->JamSewa->FldTagValue(17), $this->JamSewa->FldTagCaption(17) <> "" ? $this->JamSewa->FldTagCaption(17) : $this->JamSewa->FldTagValue(17));
			$arwrk[] = array($this->JamSewa->FldTagValue(18), $this->JamSewa->FldTagCaption(18) <> "" ? $this->JamSewa->FldTagCaption(18) : $this->JamSewa->FldTagValue(18));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->JamSewa->EditValue = $arwrk;

			// HargaSewa
			$this->HargaSewa->EditCustomAttributes = "";
			$this->HargaSewa->EditValue = ew_HtmlEncode($this->HargaSewa->CurrentValue);
			$this->HargaSewa->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa->FldCaption()));

			// Hitung
			$this->Hitung->EditCustomAttributes = "";
			$this->Hitung->EditValue = ew_HtmlEncode($this->Hitung->CurrentValue);
			$this->Hitung->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Hitung->FldCaption()));

			// Edit refer script
			// Kode

			$this->Kode->HrefValue = "";

			// NamaLapangan
			$this->NamaLapangan->HrefValue = "";

			// TglSewa
			$this->TglSewa->HrefValue = "";

			// JamSewa
			$this->JamSewa->HrefValue = "";

			// HargaSewa
			$this->HargaSewa->HrefValue = "";

			// Hitung
			if (!ew_Empty($this->IDM->CurrentValue)) {
				$this->Hitung->HrefValue = "AppHitung.php?id=" . ((!empty($this->IDM->EditValue)) ? $this->IDM->EditValue : $this->IDM->CurrentValue); // Add prefix/suffix
				$this->Hitung->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Hitung->HrefValue = ew_ConvertFullUrl($this->Hitung->HrefValue);
			} else {
				$this->Hitung->HrefValue = "";
			}
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Kode
			$this->Kode->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaLapangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `daftar lapangan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Kode, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Kode->EditValue = $arwrk;

			// NamaLapangan
			$this->NamaLapangan->EditCustomAttributes = "";
			$this->NamaLapangan->EditValue = ew_HtmlEncode($this->NamaLapangan->CurrentValue);
			$this->NamaLapangan->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NamaLapangan->FldCaption()));

			// TglSewa
			$this->TglSewa->EditCustomAttributes = "";
			$this->TglSewa->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TglSewa->CurrentValue, 7));
			$this->TglSewa->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->TglSewa->FldCaption()));

			// JamSewa
			$this->JamSewa->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->JamSewa->FldTagValue(1), $this->JamSewa->FldTagCaption(1) <> "" ? $this->JamSewa->FldTagCaption(1) : $this->JamSewa->FldTagValue(1));
			$arwrk[] = array($this->JamSewa->FldTagValue(2), $this->JamSewa->FldTagCaption(2) <> "" ? $this->JamSewa->FldTagCaption(2) : $this->JamSewa->FldTagValue(2));
			$arwrk[] = array($this->JamSewa->FldTagValue(3), $this->JamSewa->FldTagCaption(3) <> "" ? $this->JamSewa->FldTagCaption(3) : $this->JamSewa->FldTagValue(3));
			$arwrk[] = array($this->JamSewa->FldTagValue(4), $this->JamSewa->FldTagCaption(4) <> "" ? $this->JamSewa->FldTagCaption(4) : $this->JamSewa->FldTagValue(4));
			$arwrk[] = array($this->JamSewa->FldTagValue(5), $this->JamSewa->FldTagCaption(5) <> "" ? $this->JamSewa->FldTagCaption(5) : $this->JamSewa->FldTagValue(5));
			$arwrk[] = array($this->JamSewa->FldTagValue(6), $this->JamSewa->FldTagCaption(6) <> "" ? $this->JamSewa->FldTagCaption(6) : $this->JamSewa->FldTagValue(6));
			$arwrk[] = array($this->JamSewa->FldTagValue(7), $this->JamSewa->FldTagCaption(7) <> "" ? $this->JamSewa->FldTagCaption(7) : $this->JamSewa->FldTagValue(7));
			$arwrk[] = array($this->JamSewa->FldTagValue(8), $this->JamSewa->FldTagCaption(8) <> "" ? $this->JamSewa->FldTagCaption(8) : $this->JamSewa->FldTagValue(8));
			$arwrk[] = array($this->JamSewa->FldTagValue(9), $this->JamSewa->FldTagCaption(9) <> "" ? $this->JamSewa->FldTagCaption(9) : $this->JamSewa->FldTagValue(9));
			$arwrk[] = array($this->JamSewa->FldTagValue(10), $this->JamSewa->FldTagCaption(10) <> "" ? $this->JamSewa->FldTagCaption(10) : $this->JamSewa->FldTagValue(10));
			$arwrk[] = array($this->JamSewa->FldTagValue(11), $this->JamSewa->FldTagCaption(11) <> "" ? $this->JamSewa->FldTagCaption(11) : $this->JamSewa->FldTagValue(11));
			$arwrk[] = array($this->JamSewa->FldTagValue(12), $this->JamSewa->FldTagCaption(12) <> "" ? $this->JamSewa->FldTagCaption(12) : $this->JamSewa->FldTagValue(12));
			$arwrk[] = array($this->JamSewa->FldTagValue(13), $this->JamSewa->FldTagCaption(13) <> "" ? $this->JamSewa->FldTagCaption(13) : $this->JamSewa->FldTagValue(13));
			$arwrk[] = array($this->JamSewa->FldTagValue(14), $this->JamSewa->FldTagCaption(14) <> "" ? $this->JamSewa->FldTagCaption(14) : $this->JamSewa->FldTagValue(14));
			$arwrk[] = array($this->JamSewa->FldTagValue(15), $this->JamSewa->FldTagCaption(15) <> "" ? $this->JamSewa->FldTagCaption(15) : $this->JamSewa->FldTagValue(15));
			$arwrk[] = array($this->JamSewa->FldTagValue(16), $this->JamSewa->FldTagCaption(16) <> "" ? $this->JamSewa->FldTagCaption(16) : $this->JamSewa->FldTagValue(16));
			$arwrk[] = array($this->JamSewa->FldTagValue(17), $this->JamSewa->FldTagCaption(17) <> "" ? $this->JamSewa->FldTagCaption(17) : $this->JamSewa->FldTagValue(17));
			$arwrk[] = array($this->JamSewa->FldTagValue(18), $this->JamSewa->FldTagCaption(18) <> "" ? $this->JamSewa->FldTagCaption(18) : $this->JamSewa->FldTagValue(18));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->JamSewa->EditValue = $arwrk;

			// HargaSewa
			$this->HargaSewa->EditCustomAttributes = "";
			$this->HargaSewa->EditValue = ew_HtmlEncode($this->HargaSewa->CurrentValue);
			$this->HargaSewa->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->HargaSewa->FldCaption()));

			// Hitung
			$this->Hitung->EditCustomAttributes = "";
			$this->Hitung->EditValue = ew_HtmlEncode($this->Hitung->CurrentValue);
			$this->Hitung->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Hitung->FldCaption()));

			// Edit refer script
			// Kode

			$this->Kode->HrefValue = "";

			// NamaLapangan
			$this->NamaLapangan->HrefValue = "";

			// TglSewa
			$this->TglSewa->HrefValue = "";

			// JamSewa
			$this->JamSewa->HrefValue = "";

			// HargaSewa
			$this->HargaSewa->HrefValue = "";

			// Hitung
			if (!ew_Empty($this->IDM->CurrentValue)) {
				$this->Hitung->HrefValue = "AppHitung.php?id=" . ((!empty($this->IDM->EditValue)) ? $this->IDM->EditValue : $this->IDM->CurrentValue); // Add prefix/suffix
				$this->Hitung->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Hitung->HrefValue = ew_ConvertFullUrl($this->Hitung->HrefValue);
			} else {
				$this->Hitung->HrefValue = "";
			}
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

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->Kode->FldIsDetailKey && !is_null($this->Kode->FormValue) && $this->Kode->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Kode->FldCaption());
		}
		if (!$this->NamaLapangan->FldIsDetailKey && !is_null($this->NamaLapangan->FormValue) && $this->NamaLapangan->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->NamaLapangan->FldCaption());
		}
		if (!$this->TglSewa->FldIsDetailKey && !is_null($this->TglSewa->FormValue) && $this->TglSewa->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->TglSewa->FldCaption());
		}
		if (!ew_CheckEuroDate($this->TglSewa->FormValue)) {
			ew_AddMessage($gsFormError, $this->TglSewa->FldErrMsg());
		}
		if (!$this->JamSewa->FldIsDetailKey && !is_null($this->JamSewa->FormValue) && $this->JamSewa->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->JamSewa->FldCaption());
		}
		if (!ew_CheckInteger($this->HargaSewa->FormValue)) {
			ew_AddMessage($gsFormError, $this->HargaSewa->FldErrMsg());
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

			// TglSewa
			$this->TglSewa->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglSewa->CurrentValue, 7), NULL, $this->TglSewa->ReadOnly);

			// JamSewa
			$this->JamSewa->SetDbValueDef($rsnew, $this->JamSewa->CurrentValue, NULL, $this->JamSewa->ReadOnly);

			// HargaSewa
			$this->HargaSewa->SetDbValueDef($rsnew, $this->HargaSewa->CurrentValue, NULL, $this->HargaSewa->ReadOnly);

			// Hitung
			$this->Hitung->SetDbValueDef($rsnew, $this->Hitung->CurrentValue, NULL, $this->Hitung->ReadOnly);

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

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "persewaan_lapangan_2D_master") {
				$this->IDM->CurrentValue = $this->IDM->getSessionValue();
			}

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Kode
		$this->Kode->SetDbValueDef($rsnew, $this->Kode->CurrentValue, "", FALSE);

		// NamaLapangan
		$this->NamaLapangan->SetDbValueDef($rsnew, $this->NamaLapangan->CurrentValue, NULL, FALSE);

		// TglSewa
		$this->TglSewa->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TglSewa->CurrentValue, 7), NULL, FALSE);

		// JamSewa
		$this->JamSewa->SetDbValueDef($rsnew, $this->JamSewa->CurrentValue, NULL, FALSE);

		// HargaSewa
		$this->HargaSewa->SetDbValueDef($rsnew, $this->HargaSewa->CurrentValue, NULL, strval($this->HargaSewa->CurrentValue) == "");

		// Hitung
		$this->Hitung->SetDbValueDef($rsnew, $this->Hitung->CurrentValue, NULL, strval($this->Hitung->CurrentValue) == "");

		// IDM
		if ($this->IDM->getSessionValue() <> "") {
			$rsnew['IDM'] = $this->IDM->getSessionValue();
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {

		// Hide foreign keys
		$sMasterTblVar = $this->getCurrentMasterTable();
		if ($sMasterTblVar == "persewaan_lapangan_2D_master") {
			$this->IDM->Visible = FALSE;
			if ($GLOBALS["persewaan_lapangan_2D_master"]->EventCancelled) $this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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

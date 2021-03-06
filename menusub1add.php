<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "menusub1info.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "_menuinfo.php" ?>
<?php include_once "menusub2gridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$menusub1_add = NULL; // Initialize page object first

class cmenusub1_add extends cmenusub1 {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'menusub1';

	// Page object name
	var $PageObjName = 'menusub1_add';

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

		// Table object (menusub1)
		if (!isset($GLOBALS["menusub1"])) {
			$GLOBALS["menusub1"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["menusub1"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Table object (_menu)
		if (!isset($GLOBALS['_menu'])) $GLOBALS['_menu'] = new c_menu();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'menusub1', TRUE);

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
			$this->Page_Terminate("menusub1list.php");
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("menusub1list.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "menusub1view.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->_Menu->CurrentValue = NULL;
		$this->_Menu->OldValue = $this->_Menu->CurrentValue;
		$this->Link->CurrentValue = NULL;
		$this->Link->OldValue = $this->Link->CurrentValue;
		$this->Parent->CurrentValue = NULL;
		$this->Parent->OldValue = $this->Parent->CurrentValue;
		$this->No->CurrentValue = 0;
		$this->Akses->CurrentValue = NULL;
		$this->Akses->OldValue = $this->Akses->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->_Menu->FldIsDetailKey) {
			$this->_Menu->setFormValue($objForm->GetValue("x__Menu"));
		}
		if (!$this->Link->FldIsDetailKey) {
			$this->Link->setFormValue($objForm->GetValue("x_Link"));
		}
		if (!$this->Parent->FldIsDetailKey) {
			$this->Parent->setFormValue($objForm->GetValue("x_Parent"));
		}
		if (!$this->No->FldIsDetailKey) {
			$this->No->setFormValue($objForm->GetValue("x_No"));
		}
		if (!$this->Akses->FldIsDetailKey) {
			$this->Akses->setFormValue($objForm->GetValue("x_Akses"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->_Menu->CurrentValue = $this->_Menu->FormValue;
		$this->Link->CurrentValue = $this->Link->FormValue;
		$this->Parent->CurrentValue = $this->Parent->FormValue;
		$this->No->CurrentValue = $this->No->FormValue;
		$this->Akses->CurrentValue = $this->Akses->FormValue;
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
		$this->_Menu->setDbValue($rs->fields('Menu'));
		$this->Link->setDbValue($rs->fields('Link'));
		$this->Parent->setDbValue($rs->fields('Parent'));
		$this->No->setDbValue($rs->fields('No'));
		$this->Akses->setDbValue($rs->fields('Akses'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->_Menu->DbValue = $row['Menu'];
		$this->Link->DbValue = $row['Link'];
		$this->Parent->DbValue = $row['Parent'];
		$this->No->DbValue = $row['No'];
		$this->Akses->DbValue = $row['Akses'];
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
		// Menu
		// Link
		// Parent
		// No
		// Akses

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Menu
			$this->_Menu->ViewValue = $this->_Menu->CurrentValue;
			$this->_Menu->ViewCustomAttributes = "";

			// Link
			$this->Link->ViewValue = $this->Link->CurrentValue;
			$this->Link->ViewCustomAttributes = "";

			// Parent
			$this->Parent->ViewValue = $this->Parent->CurrentValue;
			$this->Parent->ViewCustomAttributes = "";

			// No
			$this->No->ViewValue = $this->No->CurrentValue;
			$this->No->CellCssStyle .= "text-align: center;";
			$this->No->ViewCustomAttributes = "";

			// Akses
			if (strval($this->Akses->CurrentValue) <> "") {
				$this->Akses->ViewValue = "";
				$arwrk = explode(",", strval($this->Akses->CurrentValue));
				$cnt = count($arwrk);
				for ($ari = 0; $ari < $cnt; $ari++) {
					switch (trim($arwrk[$ari])) {
						case $this->Akses->FldTagValue(1):
							$this->Akses->ViewValue .= $this->Akses->FldTagCaption(1) <> "" ? $this->Akses->FldTagCaption(1) : trim($arwrk[$ari]);
							break;
						case $this->Akses->FldTagValue(2):
							$this->Akses->ViewValue .= $this->Akses->FldTagCaption(2) <> "" ? $this->Akses->FldTagCaption(2) : trim($arwrk[$ari]);
							break;
						case $this->Akses->FldTagValue(3):
							$this->Akses->ViewValue .= $this->Akses->FldTagCaption(3) <> "" ? $this->Akses->FldTagCaption(3) : trim($arwrk[$ari]);
							break;
						default:
							$this->Akses->ViewValue .= trim($arwrk[$ari]);
					}
					if ($ari < $cnt-1) $this->Akses->ViewValue .= ew_ViewOptionSeparator($ari);
				}
			} else {
				$this->Akses->ViewValue = NULL;
			}
			$this->Akses->ViewCustomAttributes = "";

			// Menu
			$this->_Menu->LinkCustomAttributes = "";
			$this->_Menu->HrefValue = "";
			$this->_Menu->TooltipValue = "";

			// Link
			$this->Link->LinkCustomAttributes = "";
			$this->Link->HrefValue = "";
			$this->Link->TooltipValue = "";

			// Parent
			$this->Parent->LinkCustomAttributes = "";
			$this->Parent->HrefValue = "";
			$this->Parent->TooltipValue = "";

			// No
			$this->No->LinkCustomAttributes = "";
			$this->No->HrefValue = "";
			$this->No->TooltipValue = "";

			// Akses
			$this->Akses->LinkCustomAttributes = "";
			$this->Akses->HrefValue = "";
			$this->Akses->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Menu
			$this->_Menu->EditCustomAttributes = "";
			$this->_Menu->EditValue = ew_HtmlEncode($this->_Menu->CurrentValue);
			$this->_Menu->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_Menu->FldCaption()));

			// Link
			$this->Link->EditCustomAttributes = "";
			$this->Link->EditValue = ew_HtmlEncode($this->Link->CurrentValue);
			$this->Link->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Link->FldCaption()));

			// Parent
			$this->Parent->EditCustomAttributes = "";
			if ($this->Parent->getSessionValue() <> "") {
				$this->Parent->CurrentValue = $this->Parent->getSessionValue();
			$this->Parent->ViewValue = $this->Parent->CurrentValue;
			$this->Parent->ViewCustomAttributes = "";
			} else {
			$this->Parent->EditValue = ew_HtmlEncode($this->Parent->CurrentValue);
			$this->Parent->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Parent->FldCaption()));
			}

			// No
			$this->No->EditCustomAttributes = "";
			$this->No->EditValue = ew_HtmlEncode($this->No->CurrentValue);
			$this->No->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->No->FldCaption()));

			// Akses
			$this->Akses->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Akses->FldTagValue(1), $this->Akses->FldTagCaption(1) <> "" ? $this->Akses->FldTagCaption(1) : $this->Akses->FldTagValue(1));
			$arwrk[] = array($this->Akses->FldTagValue(2), $this->Akses->FldTagCaption(2) <> "" ? $this->Akses->FldTagCaption(2) : $this->Akses->FldTagValue(2));
			$arwrk[] = array($this->Akses->FldTagValue(3), $this->Akses->FldTagCaption(3) <> "" ? $this->Akses->FldTagCaption(3) : $this->Akses->FldTagValue(3));
			$this->Akses->EditValue = $arwrk;

			// Edit refer script
			// Menu

			$this->_Menu->HrefValue = "";

			// Link
			$this->Link->HrefValue = "";

			// Parent
			$this->Parent->HrefValue = "";

			// No
			$this->No->HrefValue = "";

			// Akses
			$this->Akses->HrefValue = "";
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
		if (!$this->_Menu->FldIsDetailKey && !is_null($this->_Menu->FormValue) && $this->_Menu->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->_Menu->FldCaption());
		}
		if (!$this->Link->FldIsDetailKey && !is_null($this->Link->FormValue) && $this->Link->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Link->FldCaption());
		}
		if (!$this->Parent->FldIsDetailKey && !is_null($this->Parent->FormValue) && $this->Parent->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Parent->FldCaption());
		}
		if (!$this->No->FldIsDetailKey && !is_null($this->No->FormValue) && $this->No->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->No->FldCaption());
		}
		if (!ew_CheckInteger($this->No->FormValue)) {
			ew_AddMessage($gsFormError, $this->No->FldErrMsg());
		}
		if ($this->Akses->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Akses->FldCaption());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("menusub2", $DetailTblVar) && $GLOBALS["menusub2"]->DetailAdd) {
			if (!isset($GLOBALS["menusub2_grid"])) $GLOBALS["menusub2_grid"] = new cmenusub2_grid(); // get detail page object
			$GLOBALS["menusub2_grid"]->ValidateGridForm();
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

		// Check referential integrity for master table 'menu'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter__menu();
		if (strval($this->Parent->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@MainMenu@", ew_AdjustSql($this->Parent->CurrentValue), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["_menu"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "menu", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Menu
		$this->_Menu->SetDbValueDef($rsnew, $this->_Menu->CurrentValue, "", FALSE);

		// Link
		$this->Link->SetDbValueDef($rsnew, $this->Link->CurrentValue, "", FALSE);

		// Parent
		$this->Parent->SetDbValueDef($rsnew, $this->Parent->CurrentValue, "", FALSE);

		// No
		$this->No->SetDbValueDef($rsnew, $this->No->CurrentValue, 0, strval($this->No->CurrentValue) == "");

		// Akses
		$this->Akses->SetDbValueDef($rsnew, $this->Akses->CurrentValue, "", FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("menusub2", $DetailTblVar) && $GLOBALS["menusub2"]->DetailAdd) {
				$GLOBALS["menusub2"]->Parent->setSessionValue($this->_Menu->CurrentValue); // Set master key
				if (!isset($GLOBALS["menusub2_grid"])) $GLOBALS["menusub2_grid"] = new cmenusub2_grid(); // Get detail page object
				$AddRow = $GLOBALS["menusub2_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["menusub2"]->Parent->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
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
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "_menu") {
				$bValidMaster = TRUE;
				if (@$_GET["MainMenu"] <> "") {
					$GLOBALS["_menu"]->MainMenu->setQueryStringValue($_GET["MainMenu"]);
					$this->Parent->setQueryStringValue($GLOBALS["_menu"]->MainMenu->QueryStringValue);
					$this->Parent->setSessionValue($this->Parent->QueryStringValue);
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
			if ($sMasterTblVar <> "_menu") {
				if ($this->Parent->QueryStringValue == "") $this->Parent->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
			if (in_array("menusub2", $DetailTblVar)) {
				if (!isset($GLOBALS["menusub2_grid"]))
					$GLOBALS["menusub2_grid"] = new cmenusub2_grid;
				if ($GLOBALS["menusub2_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["menusub2_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["menusub2_grid"]->CurrentMode = "add";
					$GLOBALS["menusub2_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["menusub2_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["menusub2_grid"]->setStartRecordNumber(1);
					$GLOBALS["menusub2_grid"]->Parent->FldIsDetailKey = TRUE;
					$GLOBALS["menusub2_grid"]->Parent->CurrentValue = $this->_Menu->CurrentValue;
					$GLOBALS["menusub2_grid"]->Parent->setSessionValue($GLOBALS["menusub2_grid"]->Parent->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "menusub1list.php", $this->TableVar);
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
if (!isset($menusub1_add)) $menusub1_add = new cmenusub1_add();

// Page init
$menusub1_add->Page_Init();

// Page main
$menusub1_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$menusub1_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var menusub1_add = new ew_Page("menusub1_add");
menusub1_add.PageID = "add"; // Page ID
var EW_PAGE_ID = menusub1_add.PageID; // For backward compatibility

// Form object
var fmenusub1add = new ew_Form("fmenusub1add");

// Validate form
fmenusub1add.Validate = function() {
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
			elm = this.GetElements("x" + infix + "__Menu");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->_Menu->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Link");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->Link->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Parent");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->Parent->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_No");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->No->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_No");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($menusub1->No->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Akses[]");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($menusub1->Akses->FldCaption()) ?>");

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
fmenusub1add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmenusub1add.ValidateRequired = true;
<?php } else { ?>
fmenusub1add.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $menusub1_add->ShowPageHeader(); ?>
<?php
$menusub1_add->ShowMessage();
?>
<form name="fmenusub1add" id="fmenusub1add" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="menusub1">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_menusub1add" class="table table-bordered table-striped">
<?php if ($menusub1->_Menu->Visible) { // Menu ?>
	<tr id="r__Menu"<?php echo $menusub1->RowAttributes() ?>>
		<td><span id="elh_menusub1__Menu"><?php echo $menusub1->_Menu->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $menusub1->_Menu->CellAttributes() ?>><span id="el_menusub1__Menu" class="control-group">
<input type="text" data-field="x__Menu" name="x__Menu" id="x__Menu" size="30" maxlength="100" placeholder="<?php echo $menusub1->_Menu->PlaceHolder ?>" value="<?php echo $menusub1->_Menu->EditValue ?>"<?php echo $menusub1->_Menu->EditAttributes() ?>>
</span><?php echo $menusub1->_Menu->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($menusub1->Link->Visible) { // Link ?>
	<tr id="r_Link"<?php echo $menusub1->RowAttributes() ?>>
		<td><span id="elh_menusub1_Link"><?php echo $menusub1->Link->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $menusub1->Link->CellAttributes() ?>><span id="el_menusub1_Link" class="control-group">
<input type="text" data-field="x_Link" name="x_Link" id="x_Link" size="30" maxlength="255" placeholder="<?php echo $menusub1->Link->PlaceHolder ?>" value="<?php echo $menusub1->Link->EditValue ?>"<?php echo $menusub1->Link->EditAttributes() ?>>
</span><?php echo $menusub1->Link->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($menusub1->Parent->Visible) { // Parent ?>
	<tr id="r_Parent"<?php echo $menusub1->RowAttributes() ?>>
		<td><span id="elh_menusub1_Parent"><?php echo $menusub1->Parent->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $menusub1->Parent->CellAttributes() ?>><span id="el_menusub1_Parent" class="control-group">
<?php if ($menusub1->Parent->getSessionValue() <> "") { ?>
<span<?php echo $menusub1->Parent->ViewAttributes() ?>>
<?php echo $menusub1->Parent->ViewValue ?></span>
<input type="hidden" id="x_Parent" name="x_Parent" value="<?php echo ew_HtmlEncode($menusub1->Parent->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_Parent" name="x_Parent" id="x_Parent" size="30" maxlength="100" placeholder="<?php echo $menusub1->Parent->PlaceHolder ?>" value="<?php echo $menusub1->Parent->EditValue ?>"<?php echo $menusub1->Parent->EditAttributes() ?>>
<?php } ?>
</span><?php echo $menusub1->Parent->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($menusub1->No->Visible) { // No ?>
	<tr id="r_No"<?php echo $menusub1->RowAttributes() ?>>
		<td><span id="elh_menusub1_No"><?php echo $menusub1->No->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $menusub1->No->CellAttributes() ?>><span id="el_menusub1_No" class="control-group">
<input type="text" data-field="x_No" name="x_No" id="x_No" size="30" placeholder="<?php echo $menusub1->No->PlaceHolder ?>" value="<?php echo $menusub1->No->EditValue ?>"<?php echo $menusub1->No->EditAttributes() ?>>
</span><?php echo $menusub1->No->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($menusub1->Akses->Visible) { // Akses ?>
	<tr id="r_Akses"<?php echo $menusub1->RowAttributes() ?>>
		<td><span id="elh_menusub1_Akses"><?php echo $menusub1->Akses->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $menusub1->Akses->CellAttributes() ?>><span id="el_menusub1_Akses" class="control-group">
<select data-field="x_Akses" id="x_Akses[]" name="x_Akses[]" multiple="multiple"<?php echo $menusub1->Akses->EditAttributes() ?>>
<?php
if (is_array($menusub1->Akses->EditValue)) {
	$arwrk = $menusub1->Akses->EditValue;
	$armultiwrk= explode(",", strval($menusub1->Akses->CurrentValue));
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = "";
		$cnt = count($armultiwrk);
		for ($ari = 0; $ari < $cnt; $ari++) {
			if (strval($arwrk[$rowcntwrk][0]) == trim(strval($armultiwrk[$ari]))) {
				$selwrk = " selected=\"selected\"";
				if ($selwrk <> "") $emptywrk = FALSE;
				break;
			}
		}	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $menusub1->Akses->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("menusub2", explode(",", $menusub1->getCurrentDetailTable())) && $menusub2->DetailAdd) {
?>
<?php include_once "menusub2grid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fmenusub1add.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$menusub1_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$menusub1_add->Page_Terminate();
?>

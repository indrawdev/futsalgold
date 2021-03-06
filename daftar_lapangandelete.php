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

$daftar_lapangan_delete = NULL; // Initialize page object first

class cdaftar_lapangan_delete extends cdaftar_lapangan {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'daftar lapangan';

	// Page object name
	var $PageObjName = 'daftar_lapangan_delete';

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

		// Table object (daftar_lapangan)
		if (!isset($GLOBALS["daftar_lapangan"])) {
			$GLOBALS["daftar_lapangan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["daftar_lapangan"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar lapangan', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("daftar_lapanganlist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("daftar_lapanganlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in daftar_lapangan class, daftar_lapanganinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		$conn->BeginTrans();

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
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "daftar_lapanganlist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($daftar_lapangan_delete)) $daftar_lapangan_delete = new cdaftar_lapangan_delete();

// Page init
$daftar_lapangan_delete->Page_Init();

// Page main
$daftar_lapangan_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$daftar_lapangan_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var daftar_lapangan_delete = new ew_Page("daftar_lapangan_delete");
daftar_lapangan_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = daftar_lapangan_delete.PageID; // For backward compatibility

// Form object
var fdaftar_lapangandelete = new ew_Form("fdaftar_lapangandelete");

// Form_CustomValidate event
fdaftar_lapangandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdaftar_lapangandelete.ValidateRequired = true;
<?php } else { ?>
fdaftar_lapangandelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($daftar_lapangan_delete->Recordset = $daftar_lapangan_delete->LoadRecordset())
	$daftar_lapangan_deleteTotalRecs = $daftar_lapangan_delete->Recordset->RecordCount(); // Get record count
if ($daftar_lapangan_deleteTotalRecs <= 0) { // No record found, exit
	if ($daftar_lapangan_delete->Recordset)
		$daftar_lapangan_delete->Recordset->Close();
	$daftar_lapangan_delete->Page_Terminate("daftar_lapanganlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $daftar_lapangan_delete->ShowPageHeader(); ?>
<?php
$daftar_lapangan_delete->ShowMessage();
?>
<form name="fdaftar_lapangandelete" id="fdaftar_lapangandelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="daftar_lapangan">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($daftar_lapangan_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_daftar_lapangandelete" class="ewTable ewTableSeparate">
<?php echo $daftar_lapangan->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_daftar_lapangan_Kode" class="daftar_lapangan_Kode"><?php echo $daftar_lapangan->Kode->FldCaption() ?></span></td>
		<td><span id="elh_daftar_lapangan_NamaLapangan" class="daftar_lapangan_NamaLapangan"><?php echo $daftar_lapangan->NamaLapangan->FldCaption() ?></span></td>
		<td><span id="elh_daftar_lapangan_Ukuran" class="daftar_lapangan_Ukuran"><?php echo $daftar_lapangan->Ukuran->FldCaption() ?></span></td>
		<td><span id="elh_daftar_lapangan_Kondisi" class="daftar_lapangan_Kondisi"><?php echo $daftar_lapangan->Kondisi->FldCaption() ?></span></td>
		<td><span id="elh_daftar_lapangan_HargaSewa1" class="daftar_lapangan_HargaSewa1"><?php echo $daftar_lapangan->HargaSewa1->FldCaption() ?></span></td>
		<td><span id="elh_daftar_lapangan_HargaSewa2" class="daftar_lapangan_HargaSewa2"><?php echo $daftar_lapangan->HargaSewa2->FldCaption() ?></span></td>
		<td><span id="elh_daftar_lapangan_HargaSewa3" class="daftar_lapangan_HargaSewa3"><?php echo $daftar_lapangan->HargaSewa3->FldCaption() ?></span></td>
		<td><span id="elh_daftar_lapangan_HargaSewa4" class="daftar_lapangan_HargaSewa4"><?php echo $daftar_lapangan->HargaSewa4->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$daftar_lapangan_delete->RecCnt = 0;
$i = 0;
while (!$daftar_lapangan_delete->Recordset->EOF) {
	$daftar_lapangan_delete->RecCnt++;
	$daftar_lapangan_delete->RowCnt++;

	// Set row properties
	$daftar_lapangan->ResetAttrs();
	$daftar_lapangan->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$daftar_lapangan_delete->LoadRowValues($daftar_lapangan_delete->Recordset);

	// Render row
	$daftar_lapangan_delete->RenderRow();
?>
	<tr<?php echo $daftar_lapangan->RowAttributes() ?>>
		<td<?php echo $daftar_lapangan->Kode->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_delete->RowCnt ?>_daftar_lapangan_Kode" class="control-group daftar_lapangan_Kode">
<span<?php echo $daftar_lapangan->Kode->ViewAttributes() ?>>
<?php echo $daftar_lapangan->Kode->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_lapangan->NamaLapangan->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_delete->RowCnt ?>_daftar_lapangan_NamaLapangan" class="control-group daftar_lapangan_NamaLapangan">
<span<?php echo $daftar_lapangan->NamaLapangan->ViewAttributes() ?>>
<?php echo $daftar_lapangan->NamaLapangan->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_lapangan->Ukuran->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_delete->RowCnt ?>_daftar_lapangan_Ukuran" class="control-group daftar_lapangan_Ukuran">
<span<?php echo $daftar_lapangan->Ukuran->ViewAttributes() ?>>
<?php echo $daftar_lapangan->Ukuran->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_lapangan->Kondisi->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_delete->RowCnt ?>_daftar_lapangan_Kondisi" class="control-group daftar_lapangan_Kondisi">
<span<?php echo $daftar_lapangan->Kondisi->ViewAttributes() ?>>
<?php echo $daftar_lapangan->Kondisi->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_lapangan->HargaSewa1->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_delete->RowCnt ?>_daftar_lapangan_HargaSewa1" class="control-group daftar_lapangan_HargaSewa1">
<span<?php echo $daftar_lapangan->HargaSewa1->ViewAttributes() ?>>
<?php echo $daftar_lapangan->HargaSewa1->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_lapangan->HargaSewa2->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_delete->RowCnt ?>_daftar_lapangan_HargaSewa2" class="control-group daftar_lapangan_HargaSewa2">
<span<?php echo $daftar_lapangan->HargaSewa2->ViewAttributes() ?>>
<?php echo $daftar_lapangan->HargaSewa2->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_lapangan->HargaSewa3->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_delete->RowCnt ?>_daftar_lapangan_HargaSewa3" class="control-group daftar_lapangan_HargaSewa3">
<span<?php echo $daftar_lapangan->HargaSewa3->ViewAttributes() ?>>
<?php echo $daftar_lapangan->HargaSewa3->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_lapangan->HargaSewa4->CellAttributes() ?>><span id="el<?php echo $daftar_lapangan_delete->RowCnt ?>_daftar_lapangan_HargaSewa4" class="control-group daftar_lapangan_HargaSewa4">
<span<?php echo $daftar_lapangan->HargaSewa4->ViewAttributes() ?>>
<?php echo $daftar_lapangan->HargaSewa4->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$daftar_lapangan_delete->Recordset->MoveNext();
}
$daftar_lapangan_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fdaftar_lapangandelete.Init();
</script>
<?php
$daftar_lapangan_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$daftar_lapangan_delete->Page_Terminate();
?>

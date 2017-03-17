<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "daftar_pelangganinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$daftar_pelanggan_delete = NULL; // Initialize page object first

class cdaftar_pelanggan_delete extends cdaftar_pelanggan {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'daftar pelanggan';

	// Page object name
	var $PageObjName = 'daftar_pelanggan_delete';

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

		// Table object (daftar_pelanggan)
		if (!isset($GLOBALS["daftar_pelanggan"])) {
			$GLOBALS["daftar_pelanggan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["daftar_pelanggan"];
		}

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar pelanggan', TRUE);

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
			$this->Page_Terminate("daftar_pelangganlist.php");
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
			$this->Page_Terminate("daftar_pelangganlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in daftar_pelanggan class, daftar_pelangganinfo.php

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
		$this->NamaPenyewa->setDbValue($rs->fields('NamaPenyewa'));
		$this->NamaTeam->setDbValue($rs->fields('NamaTeam'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Kota->setDbValue($rs->fields('Kota'));
		$this->Telepon->setDbValue($rs->fields('Telepon'));
		$this->Fax->setDbValue($rs->fields('Fax'));
		$this->HP->setDbValue($rs->fields('HP'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Website->setDbValue($rs->fields('Website'));
		$this->Main->setDbValue($rs->fields('Main'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ID->DbValue = $row['ID'];
		$this->Kode->DbValue = $row['Kode'];
		$this->NamaPenyewa->DbValue = $row['NamaPenyewa'];
		$this->NamaTeam->DbValue = $row['NamaTeam'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->Kota->DbValue = $row['Kota'];
		$this->Telepon->DbValue = $row['Telepon'];
		$this->Fax->DbValue = $row['Fax'];
		$this->HP->DbValue = $row['HP'];
		$this->_Email->DbValue = $row['Email'];
		$this->Website->DbValue = $row['Website'];
		$this->Main->DbValue = $row['Main'];
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
		// NamaPenyewa
		// NamaTeam
		// Alamat
		// Kota
		// Telepon
		// Fax

		$this->Fax->CellCssStyle = "white-space: nowrap;";

		// HP
		$this->HP->CellCssStyle = "white-space: nowrap;";

		// Email
		$this->_Email->CellCssStyle = "white-space: nowrap;";

		// Website
		$this->Website->CellCssStyle = "white-space: nowrap;";

		// Main
		$this->Main->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			$this->Kode->ViewValue = $this->Kode->CurrentValue;
			$this->Kode->ViewCustomAttributes = "";

			// NamaPenyewa
			$this->NamaPenyewa->ViewValue = $this->NamaPenyewa->CurrentValue;
			$this->NamaPenyewa->ViewCustomAttributes = "";

			// NamaTeam
			$this->NamaTeam->ViewValue = $this->NamaTeam->CurrentValue;
			$this->NamaTeam->ViewCustomAttributes = "";

			// Kota
			$this->Kota->ViewValue = $this->Kota->CurrentValue;
			$this->Kota->ViewCustomAttributes = "";

			// Telepon
			$this->Telepon->ViewValue = $this->Telepon->CurrentValue;
			$this->Telepon->ViewCustomAttributes = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// NamaPenyewa
			$this->NamaPenyewa->LinkCustomAttributes = "";
			$this->NamaPenyewa->HrefValue = "";
			$this->NamaPenyewa->TooltipValue = "";

			// NamaTeam
			$this->NamaTeam->LinkCustomAttributes = "";
			$this->NamaTeam->HrefValue = "";
			$this->NamaTeam->TooltipValue = "";

			// Kota
			$this->Kota->LinkCustomAttributes = "";
			$this->Kota->HrefValue = "";
			$this->Kota->TooltipValue = "";

			// Telepon
			$this->Telepon->LinkCustomAttributes = "";
			$this->Telepon->HrefValue = "";
			$this->Telepon->TooltipValue = "";
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "daftar_pelangganlist.php", $this->TableVar);
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
if (!isset($daftar_pelanggan_delete)) $daftar_pelanggan_delete = new cdaftar_pelanggan_delete();

// Page init
$daftar_pelanggan_delete->Page_Init();

// Page main
$daftar_pelanggan_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$daftar_pelanggan_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var daftar_pelanggan_delete = new ew_Page("daftar_pelanggan_delete");
daftar_pelanggan_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = daftar_pelanggan_delete.PageID; // For backward compatibility

// Form object
var fdaftar_pelanggandelete = new ew_Form("fdaftar_pelanggandelete");

// Form_CustomValidate event
fdaftar_pelanggandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdaftar_pelanggandelete.ValidateRequired = true;
<?php } else { ?>
fdaftar_pelanggandelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($daftar_pelanggan_delete->Recordset = $daftar_pelanggan_delete->LoadRecordset())
	$daftar_pelanggan_deleteTotalRecs = $daftar_pelanggan_delete->Recordset->RecordCount(); // Get record count
if ($daftar_pelanggan_deleteTotalRecs <= 0) { // No record found, exit
	if ($daftar_pelanggan_delete->Recordset)
		$daftar_pelanggan_delete->Recordset->Close();
	$daftar_pelanggan_delete->Page_Terminate("daftar_pelangganlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $daftar_pelanggan_delete->ShowPageHeader(); ?>
<?php
$daftar_pelanggan_delete->ShowMessage();
?>
<form name="fdaftar_pelanggandelete" id="fdaftar_pelanggandelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="daftar_pelanggan">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($daftar_pelanggan_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_daftar_pelanggandelete" class="ewTable ewTableSeparate">
<?php echo $daftar_pelanggan->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_daftar_pelanggan_Kode" class="daftar_pelanggan_Kode"><?php echo $daftar_pelanggan->Kode->FldCaption() ?></span></td>
		<td><span id="elh_daftar_pelanggan_NamaPenyewa" class="daftar_pelanggan_NamaPenyewa"><?php echo $daftar_pelanggan->NamaPenyewa->FldCaption() ?></span></td>
		<td><span id="elh_daftar_pelanggan_NamaTeam" class="daftar_pelanggan_NamaTeam"><?php echo $daftar_pelanggan->NamaTeam->FldCaption() ?></span></td>
		<td><span id="elh_daftar_pelanggan_Kota" class="daftar_pelanggan_Kota"><?php echo $daftar_pelanggan->Kota->FldCaption() ?></span></td>
		<td><span id="elh_daftar_pelanggan_Telepon" class="daftar_pelanggan_Telepon"><?php echo $daftar_pelanggan->Telepon->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$daftar_pelanggan_delete->RecCnt = 0;
$i = 0;
while (!$daftar_pelanggan_delete->Recordset->EOF) {
	$daftar_pelanggan_delete->RecCnt++;
	$daftar_pelanggan_delete->RowCnt++;

	// Set row properties
	$daftar_pelanggan->ResetAttrs();
	$daftar_pelanggan->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$daftar_pelanggan_delete->LoadRowValues($daftar_pelanggan_delete->Recordset);

	// Render row
	$daftar_pelanggan_delete->RenderRow();
?>
	<tr<?php echo $daftar_pelanggan->RowAttributes() ?>>
		<td<?php echo $daftar_pelanggan->Kode->CellAttributes() ?>><span id="el<?php echo $daftar_pelanggan_delete->RowCnt ?>_daftar_pelanggan_Kode" class="control-group daftar_pelanggan_Kode">
<span<?php echo $daftar_pelanggan->Kode->ViewAttributes() ?>>
<?php echo $daftar_pelanggan->Kode->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_pelanggan->NamaPenyewa->CellAttributes() ?>><span id="el<?php echo $daftar_pelanggan_delete->RowCnt ?>_daftar_pelanggan_NamaPenyewa" class="control-group daftar_pelanggan_NamaPenyewa">
<span<?php echo $daftar_pelanggan->NamaPenyewa->ViewAttributes() ?>>
<?php echo $daftar_pelanggan->NamaPenyewa->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_pelanggan->NamaTeam->CellAttributes() ?>><span id="el<?php echo $daftar_pelanggan_delete->RowCnt ?>_daftar_pelanggan_NamaTeam" class="control-group daftar_pelanggan_NamaTeam">
<span<?php echo $daftar_pelanggan->NamaTeam->ViewAttributes() ?>>
<?php echo $daftar_pelanggan->NamaTeam->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_pelanggan->Kota->CellAttributes() ?>><span id="el<?php echo $daftar_pelanggan_delete->RowCnt ?>_daftar_pelanggan_Kota" class="control-group daftar_pelanggan_Kota">
<span<?php echo $daftar_pelanggan->Kota->ViewAttributes() ?>>
<?php echo $daftar_pelanggan->Kota->ListViewValue() ?></span>
</span></td>
		<td<?php echo $daftar_pelanggan->Telepon->CellAttributes() ?>><span id="el<?php echo $daftar_pelanggan_delete->RowCnt ?>_daftar_pelanggan_Telepon" class="control-group daftar_pelanggan_Telepon">
<span<?php echo $daftar_pelanggan->Telepon->ViewAttributes() ?>>
<?php echo $daftar_pelanggan->Telepon->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$daftar_pelanggan_delete->Recordset->MoveNext();
}
$daftar_pelanggan_delete->Recordset->Close();
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
fdaftar_pelanggandelete.Init();
</script>
<?php
$daftar_pelanggan_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$daftar_pelanggan_delete->Page_Terminate();
?>

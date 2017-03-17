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
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$menusub1_delete = NULL; // Initialize page object first

class cmenusub1_delete extends cmenusub1 {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'menusub1';

	// Page object name
	var $PageObjName = 'menusub1_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("menusub1list.php");
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
			$this->Page_Terminate("menusub1list.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in menusub1 class, menusub1info.php

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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "menusub1list.php", $this->TableVar);
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
if (!isset($menusub1_delete)) $menusub1_delete = new cmenusub1_delete();

// Page init
$menusub1_delete->Page_Init();

// Page main
$menusub1_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$menusub1_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var menusub1_delete = new ew_Page("menusub1_delete");
menusub1_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = menusub1_delete.PageID; // For backward compatibility

// Form object
var fmenusub1delete = new ew_Form("fmenusub1delete");

// Form_CustomValidate event
fmenusub1delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmenusub1delete.ValidateRequired = true;
<?php } else { ?>
fmenusub1delete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($menusub1_delete->Recordset = $menusub1_delete->LoadRecordset())
	$menusub1_deleteTotalRecs = $menusub1_delete->Recordset->RecordCount(); // Get record count
if ($menusub1_deleteTotalRecs <= 0) { // No record found, exit
	if ($menusub1_delete->Recordset)
		$menusub1_delete->Recordset->Close();
	$menusub1_delete->Page_Terminate("menusub1list.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $menusub1_delete->ShowPageHeader(); ?>
<?php
$menusub1_delete->ShowMessage();
?>
<form name="fmenusub1delete" id="fmenusub1delete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="menusub1">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($menusub1_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_menusub1delete" class="ewTable ewTableSeparate">
<?php echo $menusub1->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_menusub1__Menu" class="menusub1__Menu"><?php echo $menusub1->_Menu->FldCaption() ?></span></td>
		<td><span id="elh_menusub1_Link" class="menusub1_Link"><?php echo $menusub1->Link->FldCaption() ?></span></td>
		<td><span id="elh_menusub1_Parent" class="menusub1_Parent"><?php echo $menusub1->Parent->FldCaption() ?></span></td>
		<td><span id="elh_menusub1_No" class="menusub1_No"><?php echo $menusub1->No->FldCaption() ?></span></td>
		<td><span id="elh_menusub1_Akses" class="menusub1_Akses"><?php echo $menusub1->Akses->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$menusub1_delete->RecCnt = 0;
$i = 0;
while (!$menusub1_delete->Recordset->EOF) {
	$menusub1_delete->RecCnt++;
	$menusub1_delete->RowCnt++;

	// Set row properties
	$menusub1->ResetAttrs();
	$menusub1->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$menusub1_delete->LoadRowValues($menusub1_delete->Recordset);

	// Render row
	$menusub1_delete->RenderRow();
?>
	<tr<?php echo $menusub1->RowAttributes() ?>>
		<td<?php echo $menusub1->_Menu->CellAttributes() ?>><span id="el<?php echo $menusub1_delete->RowCnt ?>_menusub1__Menu" class="control-group menusub1__Menu">
<span<?php echo $menusub1->_Menu->ViewAttributes() ?>>
<?php echo $menusub1->_Menu->ListViewValue() ?></span>
</span></td>
		<td<?php echo $menusub1->Link->CellAttributes() ?>><span id="el<?php echo $menusub1_delete->RowCnt ?>_menusub1_Link" class="control-group menusub1_Link">
<span<?php echo $menusub1->Link->ViewAttributes() ?>>
<?php echo $menusub1->Link->ListViewValue() ?></span>
</span></td>
		<td<?php echo $menusub1->Parent->CellAttributes() ?>><span id="el<?php echo $menusub1_delete->RowCnt ?>_menusub1_Parent" class="control-group menusub1_Parent">
<span<?php echo $menusub1->Parent->ViewAttributes() ?>>
<?php echo $menusub1->Parent->ListViewValue() ?></span>
</span></td>
		<td<?php echo $menusub1->No->CellAttributes() ?>><span id="el<?php echo $menusub1_delete->RowCnt ?>_menusub1_No" class="control-group menusub1_No">
<span<?php echo $menusub1->No->ViewAttributes() ?>>
<?php echo $menusub1->No->ListViewValue() ?></span>
</span></td>
		<td<?php echo $menusub1->Akses->CellAttributes() ?>><span id="el<?php echo $menusub1_delete->RowCnt ?>_menusub1_Akses" class="control-group menusub1_Akses">
<span<?php echo $menusub1->Akses->ViewAttributes() ?>>
<?php echo $menusub1->Akses->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$menusub1_delete->Recordset->MoveNext();
}
$menusub1_delete->Recordset->Close();
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
fmenusub1delete.Init();
</script>
<?php
$menusub1_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$menusub1_delete->Page_Terminate();
?>

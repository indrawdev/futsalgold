<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "z2pbackupinfo.php" ?>
<?php include "z2padmininfo.php" ?>
<?php include "userfn7.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$z2pbackup_view = new cz2pbackup_view();
$Page =& $z2pbackup_view;

// Page init
$z2pbackup_view->Page_Init();

// Page main
$z2pbackup_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($z2pbackup->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var z2pbackup_view = new ew_Page("z2pbackup_view");

// page properties
z2pbackup_view.PageID = "view"; // page ID
z2pbackup_view.FormID = "fz2pbackupview"; // form ID
var EW_PAGE_ID = z2pbackup_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
z2pbackup_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
z2pbackup_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
z2pbackup_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $z2pbackup->TableCaption() ?>
<br><br>
<?php if ($z2pbackup->Export == "") { ?>
<a href="<?php echo $z2pbackup_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $z2pbackup_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $z2pbackup_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $z2pbackup_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$z2pbackup_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($z2pbackup->ID->Visible) { // ID ?>
	<tr<?php echo $z2pbackup->ID->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2pbackup->ID->FldCaption() ?></td>
		<td<?php echo $z2pbackup->ID->CellAttributes() ?>>
<div<?php echo $z2pbackup->ID->ViewAttributes() ?>><?php echo $z2pbackup->ID->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($z2pbackup->DBPath->Visible) { // DBPath ?>
	<tr<?php echo $z2pbackup->DBPath->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2pbackup->DBPath->FldCaption() ?></td>
		<td<?php echo $z2pbackup->DBPath->CellAttributes() ?>>
<div<?php echo $z2pbackup->DBPath->ViewAttributes() ?>><?php echo $z2pbackup->DBPath->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($z2pbackup->ToPath->Visible) { // ToPath ?>
	<tr<?php echo $z2pbackup->ToPath->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2pbackup->ToPath->FldCaption() ?></td>
		<td<?php echo $z2pbackup->ToPath->CellAttributes() ?>>
<div<?php echo $z2pbackup->ToPath->ViewAttributes() ?>><?php echo $z2pbackup->ToPath->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($z2pbackup->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$z2pbackup_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cz2pbackup_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = '2pbackup';

	// Page object name
	var $PageObjName = 'z2pbackup_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $z2pbackup;
		if ($z2pbackup->UseTokenInUrl) $PageUrl .= "t=" . $z2pbackup->TableVar . "&"; // Add page token
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
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $z2pbackup;
		if ($z2pbackup->UseTokenInUrl) {
			if ($objForm)
				return ($z2pbackup->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($z2pbackup->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cz2pbackup_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (z2pbackup)
		$GLOBALS["z2pbackup"] = new cz2pbackup();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", '2pbackup', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $z2pbackup;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

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

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $lDisplayRecs = 1;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $lRecCnt;
	var $arRecKey = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $z2pbackup;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ID"] <> "") {
				$z2pbackup->ID->setQueryStringValue($_GET["ID"]);
				$this->arRecKey["ID"] = $z2pbackup->ID->QueryStringValue;
			} else {
				$sReturnUrl = "z2pbackuplist.php"; // Return to list
			}

			// Get action
			$z2pbackup->CurrentAction = "I"; // Display form
			switch ($z2pbackup->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "z2pbackuplist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "z2pbackuplist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$z2pbackup->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $z2pbackup;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$z2pbackup->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$z2pbackup->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $z2pbackup->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$z2pbackup->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$z2pbackup->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$z2pbackup->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $z2pbackup;
		$sFilter = $z2pbackup->KeyFilter();

		// Call Row Selecting event
		$z2pbackup->Row_Selecting($sFilter);

		// Load SQL based on filter
		$z2pbackup->CurrentFilter = $sFilter;
		$sSql = $z2pbackup->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$z2pbackup->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $z2pbackup;
		$z2pbackup->ID->setDbValue($rs->fields('ID'));
		$z2pbackup->DBPath->setDbValue($rs->fields('DBPath'));
		$z2pbackup->ToPath->setDbValue($rs->fields('ToPath'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $z2pbackup;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "ID=" . urlencode($z2pbackup->ID->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "ID=" . urlencode($z2pbackup->ID->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "ID=" . urlencode($z2pbackup->ID->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "ID=" . urlencode($z2pbackup->ID->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "ID=" . urlencode($z2pbackup->ID->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "ID=" . urlencode($z2pbackup->ID->CurrentValue);
		$this->AddUrl = $z2pbackup->AddUrl();
		$this->EditUrl = $z2pbackup->EditUrl();
		$this->CopyUrl = $z2pbackup->CopyUrl();
		$this->DeleteUrl = $z2pbackup->DeleteUrl();
		$this->ListUrl = $z2pbackup->ListUrl();

		// Call Row_Rendering event
		$z2pbackup->Row_Rendering();

		// Common render codes for all row types
		// ID

		$z2pbackup->ID->CellCssStyle = ""; $z2pbackup->ID->CellCssClass = "";
		$z2pbackup->ID->CellAttrs = array(); $z2pbackup->ID->ViewAttrs = array(); $z2pbackup->ID->EditAttrs = array();

		// DBPath
		$z2pbackup->DBPath->CellCssStyle = ""; $z2pbackup->DBPath->CellCssClass = "";
		$z2pbackup->DBPath->CellAttrs = array(); $z2pbackup->DBPath->ViewAttrs = array(); $z2pbackup->DBPath->EditAttrs = array();

		// ToPath
		$z2pbackup->ToPath->CellCssStyle = ""; $z2pbackup->ToPath->CellCssClass = "";
		$z2pbackup->ToPath->CellAttrs = array(); $z2pbackup->ToPath->ViewAttrs = array(); $z2pbackup->ToPath->EditAttrs = array();
		if ($z2pbackup->RowType == EW_ROWTYPE_VIEW) { // View row

			// ID
			$z2pbackup->ID->ViewValue = $z2pbackup->ID->CurrentValue;
			$z2pbackup->ID->CssStyle = "";
			$z2pbackup->ID->CssClass = "";
			$z2pbackup->ID->ViewCustomAttributes = "";

			// DBPath
			$z2pbackup->DBPath->ViewValue = $z2pbackup->DBPath->CurrentValue;
			$z2pbackup->DBPath->CssStyle = "";
			$z2pbackup->DBPath->CssClass = "";
			$z2pbackup->DBPath->ViewCustomAttributes = "";

			// ToPath
			$z2pbackup->ToPath->ViewValue = $z2pbackup->ToPath->CurrentValue;
			$z2pbackup->ToPath->CssStyle = "";
			$z2pbackup->ToPath->CssClass = "";
			$z2pbackup->ToPath->ViewCustomAttributes = "";

			// ID
			$z2pbackup->ID->HrefValue = "";
			$z2pbackup->ID->TooltipValue = "";

			// DBPath
			$z2pbackup->DBPath->HrefValue = "";
			$z2pbackup->DBPath->TooltipValue = "";

			// ToPath
			$z2pbackup->ToPath->HrefValue = "";
			$z2pbackup->ToPath->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($z2pbackup->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$z2pbackup->Row_Rendered();
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
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}
}
?>

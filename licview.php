<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "licinfo.php" ?>
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
$lic_view = new clic_view();
$Page =& $lic_view;

// Page init
$lic_view->Page_Init();

// Page main
$lic_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($lic->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var lic_view = new ew_Page("lic_view");

// page properties
lic_view.PageID = "view"; // page ID
lic_view.FormID = "flicview"; // form ID
var EW_PAGE_ID = lic_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
lic_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
lic_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
lic_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $lic->TableCaption() ?>
<br><br>
<?php if ($lic->Export == "") { ?>
<a href="<?php echo $lic_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lic_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lic_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $lic_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$lic_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($lic->ID->Visible) { // ID ?>
	<tr<?php echo $lic->ID->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $lic->ID->FldCaption() ?></td>
		<td<?php echo $lic->ID->CellAttributes() ?>>
<div<?php echo $lic->ID->ViewAttributes() ?>><?php echo $lic->ID->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lic->Serial->Visible) { // Serial ?>
	<tr<?php echo $lic->Serial->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $lic->Serial->FldCaption() ?></td>
		<td<?php echo $lic->Serial->CellAttributes() ?>>
<div<?php echo $lic->Serial->ViewAttributes() ?>><?php echo $lic->Serial->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lic->Kode->Visible) { // Kode ?>
	<tr<?php echo $lic->Kode->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $lic->Kode->FldCaption() ?></td>
		<td<?php echo $lic->Kode->CellAttributes() ?>>
<div<?php echo $lic->Kode->ViewAttributes() ?>><?php echo $lic->Kode->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lic->Status->Visible) { // Status ?>
	<tr<?php echo $lic->Status->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $lic->Status->FldCaption() ?></td>
		<td<?php echo $lic->Status->CellAttributes() ?>>
<div<?php echo $lic->Status->ViewAttributes() ?>><?php echo $lic->Status->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lic->Waktu->Visible) { // Waktu ?>
	<tr<?php echo $lic->Waktu->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $lic->Waktu->FldCaption() ?></td>
		<td<?php echo $lic->Waktu->CellAttributes() ?>>
<div<?php echo $lic->Waktu->ViewAttributes() ?>><?php echo $lic->Waktu->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($lic->Stamp->Visible) { // Stamp ?>
	<tr<?php echo $lic->Stamp->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $lic->Stamp->FldCaption() ?></td>
		<td<?php echo $lic->Stamp->CellAttributes() ?>>
<div<?php echo $lic->Stamp->ViewAttributes() ?>><?php echo $lic->Stamp->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($lic->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$lic_view->Page_Terminate();
?>
<?php

//
// Page class
//
class clic_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'lic';

	// Page object name
	var $PageObjName = 'lic_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $lic;
		if ($lic->UseTokenInUrl) $PageUrl .= "t=" . $lic->TableVar . "&"; // Add page token
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
		global $objForm, $lic;
		if ($lic->UseTokenInUrl) {
			if ($objForm)
				return ($lic->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($lic->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function clic_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (lic)
		$GLOBALS["lic"] = new clic();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lic', TRUE);

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
		global $lic;

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
		global $Language, $lic;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ID"] <> "") {
				$lic->ID->setQueryStringValue($_GET["ID"]);
				$this->arRecKey["ID"] = $lic->ID->QueryStringValue;
			} else {
				$sReturnUrl = "liclist.php"; // Return to list
			}

			// Get action
			$lic->CurrentAction = "I"; // Display form
			switch ($lic->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "liclist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "liclist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$lic->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $lic;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$lic->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$lic->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $lic->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$lic->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$lic->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$lic->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $lic;
		$sFilter = $lic->KeyFilter();

		// Call Row Selecting event
		$lic->Row_Selecting($sFilter);

		// Load SQL based on filter
		$lic->CurrentFilter = $sFilter;
		$sSql = $lic->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$lic->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $lic;
		$lic->ID->setDbValue($rs->fields('ID'));
		$lic->Serial->setDbValue($rs->fields('Serial'));
		$lic->Kode->setDbValue($rs->fields('Kode'));
		$lic->Status->setDbValue($rs->fields('Status'));
		$lic->Waktu->setDbValue($rs->fields('Waktu'));
		$lic->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $lic;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "ID=" . urlencode($lic->ID->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "ID=" . urlencode($lic->ID->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "ID=" . urlencode($lic->ID->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "ID=" . urlencode($lic->ID->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "ID=" . urlencode($lic->ID->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "ID=" . urlencode($lic->ID->CurrentValue);
		$this->AddUrl = $lic->AddUrl();
		$this->EditUrl = $lic->EditUrl();
		$this->CopyUrl = $lic->CopyUrl();
		$this->DeleteUrl = $lic->DeleteUrl();
		$this->ListUrl = $lic->ListUrl();

		// Call Row_Rendering event
		$lic->Row_Rendering();

		// Common render codes for all row types
		// ID

		$lic->ID->CellCssStyle = ""; $lic->ID->CellCssClass = "";
		$lic->ID->CellAttrs = array(); $lic->ID->ViewAttrs = array(); $lic->ID->EditAttrs = array();

		// Serial
		$lic->Serial->CellCssStyle = ""; $lic->Serial->CellCssClass = "";
		$lic->Serial->CellAttrs = array(); $lic->Serial->ViewAttrs = array(); $lic->Serial->EditAttrs = array();

		// Kode
		$lic->Kode->CellCssStyle = ""; $lic->Kode->CellCssClass = "";
		$lic->Kode->CellAttrs = array(); $lic->Kode->ViewAttrs = array(); $lic->Kode->EditAttrs = array();

		// Status
		$lic->Status->CellCssStyle = ""; $lic->Status->CellCssClass = "";
		$lic->Status->CellAttrs = array(); $lic->Status->ViewAttrs = array(); $lic->Status->EditAttrs = array();

		// Waktu
		$lic->Waktu->CellCssStyle = ""; $lic->Waktu->CellCssClass = "";
		$lic->Waktu->CellAttrs = array(); $lic->Waktu->ViewAttrs = array(); $lic->Waktu->EditAttrs = array();

		// Stamp
		$lic->Stamp->CellCssStyle = ""; $lic->Stamp->CellCssClass = "";
		$lic->Stamp->CellAttrs = array(); $lic->Stamp->ViewAttrs = array(); $lic->Stamp->EditAttrs = array();
		if ($lic->RowType == EW_ROWTYPE_VIEW) { // View row

			// ID
			$lic->ID->ViewValue = $lic->ID->CurrentValue;
			$lic->ID->CssStyle = "";
			$lic->ID->CssClass = "";
			$lic->ID->ViewCustomAttributes = "";

			// Serial
			$lic->Serial->ViewValue = $lic->Serial->CurrentValue;
			$lic->Serial->CssStyle = "";
			$lic->Serial->CssClass = "";
			$lic->Serial->ViewCustomAttributes = "";

			// Kode
			$lic->Kode->ViewValue = $lic->Kode->CurrentValue;
			$lic->Kode->CssStyle = "";
			$lic->Kode->CssClass = "";
			$lic->Kode->ViewCustomAttributes = "";

			// Status
			$lic->Status->ViewValue = $lic->Status->CurrentValue;
			$lic->Status->CssStyle = "";
			$lic->Status->CssClass = "";
			$lic->Status->ViewCustomAttributes = "";

			// Waktu
			$lic->Waktu->ViewValue = $lic->Waktu->CurrentValue;
			$lic->Waktu->ViewValue = ew_FormatDateTime($lic->Waktu->ViewValue, 5);
			$lic->Waktu->CssStyle = "";
			$lic->Waktu->CssClass = "";
			$lic->Waktu->ViewCustomAttributes = "";

			// Stamp
			$lic->Stamp->ViewValue = $lic->Stamp->CurrentValue;
			$lic->Stamp->ViewValue = ew_FormatDateTime($lic->Stamp->ViewValue, 5);
			$lic->Stamp->CssStyle = "";
			$lic->Stamp->CssClass = "";
			$lic->Stamp->ViewCustomAttributes = "";

			// ID
			$lic->ID->HrefValue = "";
			$lic->ID->TooltipValue = "";

			// Serial
			$lic->Serial->HrefValue = "";
			$lic->Serial->TooltipValue = "";

			// Kode
			$lic->Kode->HrefValue = "";
			$lic->Kode->TooltipValue = "";

			// Status
			$lic->Status->HrefValue = "";
			$lic->Status->TooltipValue = "";

			// Waktu
			$lic->Waktu->HrefValue = "";
			$lic->Waktu->TooltipValue = "";

			// Stamp
			$lic->Stamp->HrefValue = "";
			$lic->Stamp->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($lic->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$lic->Row_Rendered();
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

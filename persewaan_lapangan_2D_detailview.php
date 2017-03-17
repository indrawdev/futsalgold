<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "persewaan_lapangan_2D_detailinfo.php" ?>
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
$persewaan_lapangan_2D_detail_view = new cpersewaan_lapangan_2D_detail_view();
$Page =& $persewaan_lapangan_2D_detail_view;

// Page init
$persewaan_lapangan_2D_detail_view->Page_Init();

// Page main
$persewaan_lapangan_2D_detail_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var persewaan_lapangan_2D_detail_view = new ew_Page("persewaan_lapangan_2D_detail_view");

// page properties
persewaan_lapangan_2D_detail_view.PageID = "view"; // page ID
persewaan_lapangan_2D_detail_view.FormID = "fpersewaan_lapangan_2D_detailview"; // form ID
var EW_PAGE_ID = persewaan_lapangan_2D_detail_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
persewaan_lapangan_2D_detail_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
persewaan_lapangan_2D_detail_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
persewaan_lapangan_2D_detail_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $persewaan_lapangan_2D_detail->TableCaption() ?>
<br><br>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<a href="<?php echo $persewaan_lapangan_2D_detail_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $persewaan_lapangan_2D_detail_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $persewaan_lapangan_2D_detail_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $persewaan_lapangan_2D_detail_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$persewaan_lapangan_2D_detail_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($persewaan_lapangan_2D_detail->ID->Visible) { // ID ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->ID->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->ID->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->ID->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_detail->ID->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->ID->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->NamaLapangan->Visible) { // NamaLapangan ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->TglSewa->Visible) { // TglSewa ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->TglSewa->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->TglSewa->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->TglSewa->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_detail->TglSewa->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->TglSewa->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->JamSewa->Visible) { // JamSewa ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->JamSewa->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->JamSewa->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->JamSewa->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_detail->JamSewa->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->JamSewa->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->HargaSewa->Visible) { // HargaSewa ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->HargaSewa->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->HargaSewa->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->HargaSewa->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_detail->HargaSewa->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->HargaSewa->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->Status->Visible) { // Status ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->Status->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->Status->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->Status->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_detail->Status->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->Status->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->IDM->Visible) { // IDM ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->IDM->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->IDM->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->IDM->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_detail->IDM->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->IDM->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->Waktu->Visible) { // Waktu ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->Waktu->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->Waktu->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->Waktu->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_detail->Waktu->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->Waktu->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->Stamp->Visible) { // Stamp ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->Stamp->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->Stamp->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->Stamp->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_detail->Stamp->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_detail->Stamp->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($persewaan_lapangan_2D_detail->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$persewaan_lapangan_2D_detail_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cpersewaan_lapangan_2D_detail_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'persewaan lapangan - detail';

	// Page object name
	var $PageObjName = 'persewaan_lapangan_2D_detail_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $persewaan_lapangan_2D_detail;
		if ($persewaan_lapangan_2D_detail->UseTokenInUrl) $PageUrl .= "t=" . $persewaan_lapangan_2D_detail->TableVar . "&"; // Add page token
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
		global $objForm, $persewaan_lapangan_2D_detail;
		if ($persewaan_lapangan_2D_detail->UseTokenInUrl) {
			if ($objForm)
				return ($persewaan_lapangan_2D_detail->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($persewaan_lapangan_2D_detail->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cpersewaan_lapangan_2D_detail_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (persewaan_lapangan_2D_detail)
		$GLOBALS["persewaan_lapangan_2D_detail"] = new cpersewaan_lapangan_2D_detail();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'persewaan lapangan - detail', TRUE);

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
		global $persewaan_lapangan_2D_detail;

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
		global $Language, $persewaan_lapangan_2D_detail;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ID"] <> "") {
				$persewaan_lapangan_2D_detail->ID->setQueryStringValue($_GET["ID"]);
				$this->arRecKey["ID"] = $persewaan_lapangan_2D_detail->ID->QueryStringValue;
			} else {
				$sReturnUrl = "persewaan_lapangan_2D_detaillist.php"; // Return to list
			}

			// Get action
			$persewaan_lapangan_2D_detail->CurrentAction = "I"; // Display form
			switch ($persewaan_lapangan_2D_detail->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "persewaan_lapangan_2D_detaillist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "persewaan_lapangan_2D_detaillist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $persewaan_lapangan_2D_detail;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$persewaan_lapangan_2D_detail->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$persewaan_lapangan_2D_detail->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $persewaan_lapangan_2D_detail->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$persewaan_lapangan_2D_detail->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$persewaan_lapangan_2D_detail->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$persewaan_lapangan_2D_detail->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $persewaan_lapangan_2D_detail;
		$sFilter = $persewaan_lapangan_2D_detail->KeyFilter();

		// Call Row Selecting event
		$persewaan_lapangan_2D_detail->Row_Selecting($sFilter);

		// Load SQL based on filter
		$persewaan_lapangan_2D_detail->CurrentFilter = $sFilter;
		$sSql = $persewaan_lapangan_2D_detail->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$persewaan_lapangan_2D_detail->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $persewaan_lapangan_2D_detail;
		$persewaan_lapangan_2D_detail->ID->setDbValue($rs->fields('ID'));
		$persewaan_lapangan_2D_detail->NamaLapangan->setDbValue($rs->fields('NamaLapangan'));
		$persewaan_lapangan_2D_detail->TglSewa->setDbValue($rs->fields('TglSewa'));
		$persewaan_lapangan_2D_detail->JamSewa->setDbValue($rs->fields('JamSewa'));
		$persewaan_lapangan_2D_detail->HargaSewa->setDbValue($rs->fields('HargaSewa'));
		$persewaan_lapangan_2D_detail->Status->setDbValue($rs->fields('Status'));
		$persewaan_lapangan_2D_detail->IDM->setDbValue($rs->fields('IDM'));
		$persewaan_lapangan_2D_detail->Waktu->setDbValue($rs->fields('Waktu'));
		$persewaan_lapangan_2D_detail->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $persewaan_lapangan_2D_detail;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "ID=" . urlencode($persewaan_lapangan_2D_detail->ID->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "ID=" . urlencode($persewaan_lapangan_2D_detail->ID->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "ID=" . urlencode($persewaan_lapangan_2D_detail->ID->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "ID=" . urlencode($persewaan_lapangan_2D_detail->ID->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "ID=" . urlencode($persewaan_lapangan_2D_detail->ID->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "ID=" . urlencode($persewaan_lapangan_2D_detail->ID->CurrentValue);
		$this->AddUrl = $persewaan_lapangan_2D_detail->AddUrl();
		$this->EditUrl = $persewaan_lapangan_2D_detail->EditUrl();
		$this->CopyUrl = $persewaan_lapangan_2D_detail->CopyUrl();
		$this->DeleteUrl = $persewaan_lapangan_2D_detail->DeleteUrl();
		$this->ListUrl = $persewaan_lapangan_2D_detail->ListUrl();

		// Call Row_Rendering event
		$persewaan_lapangan_2D_detail->Row_Rendering();

		// Common render codes for all row types
		// ID

		$persewaan_lapangan_2D_detail->ID->CellCssStyle = ""; $persewaan_lapangan_2D_detail->ID->CellCssClass = "";
		$persewaan_lapangan_2D_detail->ID->CellAttrs = array(); $persewaan_lapangan_2D_detail->ID->ViewAttrs = array(); $persewaan_lapangan_2D_detail->ID->EditAttrs = array();

		// NamaLapangan
		$persewaan_lapangan_2D_detail->NamaLapangan->CellCssStyle = ""; $persewaan_lapangan_2D_detail->NamaLapangan->CellCssClass = "";
		$persewaan_lapangan_2D_detail->NamaLapangan->CellAttrs = array(); $persewaan_lapangan_2D_detail->NamaLapangan->ViewAttrs = array(); $persewaan_lapangan_2D_detail->NamaLapangan->EditAttrs = array();

		// TglSewa
		$persewaan_lapangan_2D_detail->TglSewa->CellCssStyle = ""; $persewaan_lapangan_2D_detail->TglSewa->CellCssClass = "";
		$persewaan_lapangan_2D_detail->TglSewa->CellAttrs = array(); $persewaan_lapangan_2D_detail->TglSewa->ViewAttrs = array(); $persewaan_lapangan_2D_detail->TglSewa->EditAttrs = array();

		// JamSewa
		$persewaan_lapangan_2D_detail->JamSewa->CellCssStyle = ""; $persewaan_lapangan_2D_detail->JamSewa->CellCssClass = "";
		$persewaan_lapangan_2D_detail->JamSewa->CellAttrs = array(); $persewaan_lapangan_2D_detail->JamSewa->ViewAttrs = array(); $persewaan_lapangan_2D_detail->JamSewa->EditAttrs = array();

		// HargaSewa
		$persewaan_lapangan_2D_detail->HargaSewa->CellCssStyle = ""; $persewaan_lapangan_2D_detail->HargaSewa->CellCssClass = "";
		$persewaan_lapangan_2D_detail->HargaSewa->CellAttrs = array(); $persewaan_lapangan_2D_detail->HargaSewa->ViewAttrs = array(); $persewaan_lapangan_2D_detail->HargaSewa->EditAttrs = array();

		// Status
		$persewaan_lapangan_2D_detail->Status->CellCssStyle = ""; $persewaan_lapangan_2D_detail->Status->CellCssClass = "";
		$persewaan_lapangan_2D_detail->Status->CellAttrs = array(); $persewaan_lapangan_2D_detail->Status->ViewAttrs = array(); $persewaan_lapangan_2D_detail->Status->EditAttrs = array();

		// IDM
		$persewaan_lapangan_2D_detail->IDM->CellCssStyle = ""; $persewaan_lapangan_2D_detail->IDM->CellCssClass = "";
		$persewaan_lapangan_2D_detail->IDM->CellAttrs = array(); $persewaan_lapangan_2D_detail->IDM->ViewAttrs = array(); $persewaan_lapangan_2D_detail->IDM->EditAttrs = array();

		// Waktu
		$persewaan_lapangan_2D_detail->Waktu->CellCssStyle = ""; $persewaan_lapangan_2D_detail->Waktu->CellCssClass = "";
		$persewaan_lapangan_2D_detail->Waktu->CellAttrs = array(); $persewaan_lapangan_2D_detail->Waktu->ViewAttrs = array(); $persewaan_lapangan_2D_detail->Waktu->EditAttrs = array();

		// Stamp
		$persewaan_lapangan_2D_detail->Stamp->CellCssStyle = ""; $persewaan_lapangan_2D_detail->Stamp->CellCssClass = "";
		$persewaan_lapangan_2D_detail->Stamp->CellAttrs = array(); $persewaan_lapangan_2D_detail->Stamp->ViewAttrs = array(); $persewaan_lapangan_2D_detail->Stamp->EditAttrs = array();
		if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View row

			// ID
			$persewaan_lapangan_2D_detail->ID->ViewValue = $persewaan_lapangan_2D_detail->ID->CurrentValue;
			$persewaan_lapangan_2D_detail->ID->CssStyle = "";
			$persewaan_lapangan_2D_detail->ID->CssClass = "";
			$persewaan_lapangan_2D_detail->ID->ViewCustomAttributes = "";

			// NamaLapangan
			$persewaan_lapangan_2D_detail->NamaLapangan->ViewValue = $persewaan_lapangan_2D_detail->NamaLapangan->CurrentValue;
			$persewaan_lapangan_2D_detail->NamaLapangan->CssStyle = "";
			$persewaan_lapangan_2D_detail->NamaLapangan->CssClass = "";
			$persewaan_lapangan_2D_detail->NamaLapangan->ViewCustomAttributes = "";

			// TglSewa
			$persewaan_lapangan_2D_detail->TglSewa->ViewValue = $persewaan_lapangan_2D_detail->TglSewa->CurrentValue;
			$persewaan_lapangan_2D_detail->TglSewa->CssStyle = "";
			$persewaan_lapangan_2D_detail->TglSewa->CssClass = "";
			$persewaan_lapangan_2D_detail->TglSewa->ViewCustomAttributes = "";

			// JamSewa
			$persewaan_lapangan_2D_detail->JamSewa->ViewValue = $persewaan_lapangan_2D_detail->JamSewa->CurrentValue;
			$persewaan_lapangan_2D_detail->JamSewa->CssStyle = "";
			$persewaan_lapangan_2D_detail->JamSewa->CssClass = "";
			$persewaan_lapangan_2D_detail->JamSewa->ViewCustomAttributes = "";

			// HargaSewa
			$persewaan_lapangan_2D_detail->HargaSewa->ViewValue = $persewaan_lapangan_2D_detail->HargaSewa->CurrentValue;
			$persewaan_lapangan_2D_detail->HargaSewa->CssStyle = "";
			$persewaan_lapangan_2D_detail->HargaSewa->CssClass = "";
			$persewaan_lapangan_2D_detail->HargaSewa->ViewCustomAttributes = "";

			// Status
			$persewaan_lapangan_2D_detail->Status->ViewValue = $persewaan_lapangan_2D_detail->Status->CurrentValue;
			$persewaan_lapangan_2D_detail->Status->CssStyle = "";
			$persewaan_lapangan_2D_detail->Status->CssClass = "";
			$persewaan_lapangan_2D_detail->Status->ViewCustomAttributes = "";

			// IDM
			$persewaan_lapangan_2D_detail->IDM->ViewValue = $persewaan_lapangan_2D_detail->IDM->CurrentValue;
			$persewaan_lapangan_2D_detail->IDM->CssStyle = "";
			$persewaan_lapangan_2D_detail->IDM->CssClass = "";
			$persewaan_lapangan_2D_detail->IDM->ViewCustomAttributes = "";

			// Waktu
			$persewaan_lapangan_2D_detail->Waktu->ViewValue = $persewaan_lapangan_2D_detail->Waktu->CurrentValue;
			$persewaan_lapangan_2D_detail->Waktu->ViewValue = ew_FormatDateTime($persewaan_lapangan_2D_detail->Waktu->ViewValue, 5);
			$persewaan_lapangan_2D_detail->Waktu->CssStyle = "";
			$persewaan_lapangan_2D_detail->Waktu->CssClass = "";
			$persewaan_lapangan_2D_detail->Waktu->ViewCustomAttributes = "";

			// Stamp
			$persewaan_lapangan_2D_detail->Stamp->ViewValue = $persewaan_lapangan_2D_detail->Stamp->CurrentValue;
			$persewaan_lapangan_2D_detail->Stamp->ViewValue = ew_FormatDateTime($persewaan_lapangan_2D_detail->Stamp->ViewValue, 5);
			$persewaan_lapangan_2D_detail->Stamp->CssStyle = "";
			$persewaan_lapangan_2D_detail->Stamp->CssClass = "";
			$persewaan_lapangan_2D_detail->Stamp->ViewCustomAttributes = "";

			// ID
			$persewaan_lapangan_2D_detail->ID->HrefValue = "";
			$persewaan_lapangan_2D_detail->ID->TooltipValue = "";

			// NamaLapangan
			$persewaan_lapangan_2D_detail->NamaLapangan->HrefValue = "";
			$persewaan_lapangan_2D_detail->NamaLapangan->TooltipValue = "";

			// TglSewa
			$persewaan_lapangan_2D_detail->TglSewa->HrefValue = "";
			$persewaan_lapangan_2D_detail->TglSewa->TooltipValue = "";

			// JamSewa
			$persewaan_lapangan_2D_detail->JamSewa->HrefValue = "";
			$persewaan_lapangan_2D_detail->JamSewa->TooltipValue = "";

			// HargaSewa
			$persewaan_lapangan_2D_detail->HargaSewa->HrefValue = "";
			$persewaan_lapangan_2D_detail->HargaSewa->TooltipValue = "";

			// Status
			$persewaan_lapangan_2D_detail->Status->HrefValue = "";
			$persewaan_lapangan_2D_detail->Status->TooltipValue = "";

			// IDM
			$persewaan_lapangan_2D_detail->IDM->HrefValue = "";
			$persewaan_lapangan_2D_detail->IDM->TooltipValue = "";

			// Waktu
			$persewaan_lapangan_2D_detail->Waktu->HrefValue = "";
			$persewaan_lapangan_2D_detail->Waktu->TooltipValue = "";

			// Stamp
			$persewaan_lapangan_2D_detail->Stamp->HrefValue = "";
			$persewaan_lapangan_2D_detail->Stamp->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($persewaan_lapangan_2D_detail->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$persewaan_lapangan_2D_detail->Row_Rendered();
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

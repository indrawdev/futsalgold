<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "daftar_lapanganinfo.php" ?>
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
$daftar_lapangan_view = new cdaftar_lapangan_view();
$Page =& $daftar_lapangan_view;

// Page init
$daftar_lapangan_view->Page_Init();

// Page main
$daftar_lapangan_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($daftar_lapangan->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var daftar_lapangan_view = new ew_Page("daftar_lapangan_view");

// page properties
daftar_lapangan_view.PageID = "view"; // page ID
daftar_lapangan_view.FormID = "fdaftar_lapanganview"; // form ID
var EW_PAGE_ID = daftar_lapangan_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
daftar_lapangan_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
daftar_lapangan_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
daftar_lapangan_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $daftar_lapangan->TableCaption() ?>
<br><br>
<?php if ($daftar_lapangan->Export == "") { ?>
<a href="<?php echo $daftar_lapangan_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $daftar_lapangan_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $daftar_lapangan_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $daftar_lapangan_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$daftar_lapangan_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($daftar_lapangan->NamaLapangan->Visible) { // NamaLapangan ?>
	<tr<?php echo $daftar_lapangan->NamaLapangan->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_lapangan->NamaLapangan->FldCaption() ?></td>
		<td<?php echo $daftar_lapangan->NamaLapangan->CellAttributes() ?>>
<div<?php echo $daftar_lapangan->NamaLapangan->ViewAttributes() ?>><?php echo $daftar_lapangan->NamaLapangan->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->Ukuran->Visible) { // Ukuran ?>
	<tr<?php echo $daftar_lapangan->Ukuran->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_lapangan->Ukuran->FldCaption() ?></td>
		<td<?php echo $daftar_lapangan->Ukuran->CellAttributes() ?>>
<div<?php echo $daftar_lapangan->Ukuran->ViewAttributes() ?>><?php echo $daftar_lapangan->Ukuran->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->Kondisi->Visible) { // Kondisi ?>
	<tr<?php echo $daftar_lapangan->Kondisi->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_lapangan->Kondisi->FldCaption() ?></td>
		<td<?php echo $daftar_lapangan->Kondisi->CellAttributes() ?>>
<div<?php echo $daftar_lapangan->Kondisi->ViewAttributes() ?>><?php echo $daftar_lapangan->Kondisi->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->HargaSewa1->Visible) { // HargaSewa1 ?>
	<tr<?php echo $daftar_lapangan->HargaSewa1->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_lapangan->HargaSewa1->FldCaption() ?></td>
		<td<?php echo $daftar_lapangan->HargaSewa1->CellAttributes() ?>>
<div<?php echo $daftar_lapangan->HargaSewa1->ViewAttributes() ?>><?php echo $daftar_lapangan->HargaSewa1->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->HargaSewa2->Visible) { // HargaSewa2 ?>
	<tr<?php echo $daftar_lapangan->HargaSewa2->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_lapangan->HargaSewa2->FldCaption() ?></td>
		<td<?php echo $daftar_lapangan->HargaSewa2->CellAttributes() ?>>
<div<?php echo $daftar_lapangan->HargaSewa2->ViewAttributes() ?>><?php echo $daftar_lapangan->HargaSewa2->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->HargaSewa3->Visible) { // HargaSewa3 ?>
	<tr<?php echo $daftar_lapangan->HargaSewa3->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_lapangan->HargaSewa3->FldCaption() ?></td>
		<td<?php echo $daftar_lapangan->HargaSewa3->CellAttributes() ?>>
<div<?php echo $daftar_lapangan->HargaSewa3->ViewAttributes() ?>><?php echo $daftar_lapangan->HargaSewa3->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_lapangan->HargaSewa4->Visible) { // HargaSewa4 ?>
	<tr<?php echo $daftar_lapangan->HargaSewa4->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_lapangan->HargaSewa4->FldCaption() ?></td>
		<td<?php echo $daftar_lapangan->HargaSewa4->CellAttributes() ?>>
<div<?php echo $daftar_lapangan->HargaSewa4->ViewAttributes() ?>><?php echo $daftar_lapangan->HargaSewa4->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($daftar_lapangan->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$daftar_lapangan_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cdaftar_lapangan_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'daftar lapangan';

	// Page object name
	var $PageObjName = 'daftar_lapangan_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $daftar_lapangan;
		if ($daftar_lapangan->UseTokenInUrl) $PageUrl .= "t=" . $daftar_lapangan->TableVar . "&"; // Add page token
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
		global $objForm, $daftar_lapangan;
		if ($daftar_lapangan->UseTokenInUrl) {
			if ($objForm)
				return ($daftar_lapangan->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($daftar_lapangan->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cdaftar_lapangan_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (daftar_lapangan)
		$GLOBALS["daftar_lapangan"] = new cdaftar_lapangan();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar lapangan', TRUE);

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
		global $daftar_lapangan;

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
		global $Language, $daftar_lapangan;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ID"] <> "") {
				$daftar_lapangan->ID->setQueryStringValue($_GET["ID"]);
				$this->arRecKey["ID"] = $daftar_lapangan->ID->QueryStringValue;
			} else {
				$sReturnUrl = "daftar_lapanganlist.php"; // Return to list
			}

			// Get action
			$daftar_lapangan->CurrentAction = "I"; // Display form
			switch ($daftar_lapangan->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "daftar_lapanganlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "daftar_lapanganlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$daftar_lapangan->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $daftar_lapangan;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$daftar_lapangan->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$daftar_lapangan->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $daftar_lapangan->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$daftar_lapangan->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$daftar_lapangan->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$daftar_lapangan->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $daftar_lapangan;
		$sFilter = $daftar_lapangan->KeyFilter();

		// Call Row Selecting event
		$daftar_lapangan->Row_Selecting($sFilter);

		// Load SQL based on filter
		$daftar_lapangan->CurrentFilter = $sFilter;
		$sSql = $daftar_lapangan->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$daftar_lapangan->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $daftar_lapangan;
		$daftar_lapangan->ID->setDbValue($rs->fields('ID'));
		$daftar_lapangan->NamaLapangan->setDbValue($rs->fields('NamaLapangan'));
		$daftar_lapangan->Ukuran->setDbValue($rs->fields('Ukuran'));
		$daftar_lapangan->Kondisi->setDbValue($rs->fields('Kondisi'));
		$daftar_lapangan->HargaSewa1->setDbValue($rs->fields('HargaSewa1'));
		$daftar_lapangan->HargaSewa2->setDbValue($rs->fields('HargaSewa2'));
		$daftar_lapangan->HargaSewa3->setDbValue($rs->fields('HargaSewa3'));
		$daftar_lapangan->HargaSewa4->setDbValue($rs->fields('HargaSewa4'));
		$daftar_lapangan->HargaSewa5->setDbValue($rs->fields('HargaSewa5'));
		$daftar_lapangan->Member->setDbValue($rs->fields('Member'));
		$daftar_lapangan->NonMember->setDbValue($rs->fields('NonMember'));
		$daftar_lapangan->Waktu->setDbValue($rs->fields('Waktu'));
		$daftar_lapangan->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $daftar_lapangan;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "ID=" . urlencode($daftar_lapangan->ID->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "ID=" . urlencode($daftar_lapangan->ID->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "ID=" . urlencode($daftar_lapangan->ID->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "ID=" . urlencode($daftar_lapangan->ID->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "ID=" . urlencode($daftar_lapangan->ID->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "ID=" . urlencode($daftar_lapangan->ID->CurrentValue);
		$this->AddUrl = $daftar_lapangan->AddUrl();
		$this->EditUrl = $daftar_lapangan->EditUrl();
		$this->CopyUrl = $daftar_lapangan->CopyUrl();
		$this->DeleteUrl = $daftar_lapangan->DeleteUrl();
		$this->ListUrl = $daftar_lapangan->ListUrl();

		// Call Row_Rendering event
		$daftar_lapangan->Row_Rendering();

		// Common render codes for all row types
		// NamaLapangan

		$daftar_lapangan->NamaLapangan->CellCssStyle = ""; $daftar_lapangan->NamaLapangan->CellCssClass = "";
		$daftar_lapangan->NamaLapangan->CellAttrs = array(); $daftar_lapangan->NamaLapangan->ViewAttrs = array(); $daftar_lapangan->NamaLapangan->EditAttrs = array();

		// Ukuran
		$daftar_lapangan->Ukuran->CellCssStyle = ""; $daftar_lapangan->Ukuran->CellCssClass = "";
		$daftar_lapangan->Ukuran->CellAttrs = array(); $daftar_lapangan->Ukuran->ViewAttrs = array(); $daftar_lapangan->Ukuran->EditAttrs = array();

		// Kondisi
		$daftar_lapangan->Kondisi->CellCssStyle = ""; $daftar_lapangan->Kondisi->CellCssClass = "";
		$daftar_lapangan->Kondisi->CellAttrs = array(); $daftar_lapangan->Kondisi->ViewAttrs = array(); $daftar_lapangan->Kondisi->EditAttrs = array();

		// HargaSewa1
		$daftar_lapangan->HargaSewa1->CellCssStyle = ""; $daftar_lapangan->HargaSewa1->CellCssClass = "";
		$daftar_lapangan->HargaSewa1->CellAttrs = array(); $daftar_lapangan->HargaSewa1->ViewAttrs = array(); $daftar_lapangan->HargaSewa1->EditAttrs = array();

		// HargaSewa2
		$daftar_lapangan->HargaSewa2->CellCssStyle = ""; $daftar_lapangan->HargaSewa2->CellCssClass = "";
		$daftar_lapangan->HargaSewa2->CellAttrs = array(); $daftar_lapangan->HargaSewa2->ViewAttrs = array(); $daftar_lapangan->HargaSewa2->EditAttrs = array();

		// HargaSewa3
		$daftar_lapangan->HargaSewa3->CellCssStyle = ""; $daftar_lapangan->HargaSewa3->CellCssClass = "";
		$daftar_lapangan->HargaSewa3->CellAttrs = array(); $daftar_lapangan->HargaSewa3->ViewAttrs = array(); $daftar_lapangan->HargaSewa3->EditAttrs = array();

		// HargaSewa4
		$daftar_lapangan->HargaSewa4->CellCssStyle = ""; $daftar_lapangan->HargaSewa4->CellCssClass = "";
		$daftar_lapangan->HargaSewa4->CellAttrs = array(); $daftar_lapangan->HargaSewa4->ViewAttrs = array(); $daftar_lapangan->HargaSewa4->EditAttrs = array();
		if ($daftar_lapangan->RowType == EW_ROWTYPE_VIEW) { // View row

			// NamaLapangan
			$daftar_lapangan->NamaLapangan->ViewValue = $daftar_lapangan->NamaLapangan->CurrentValue;
			$daftar_lapangan->NamaLapangan->CssStyle = "";
			$daftar_lapangan->NamaLapangan->CssClass = "";
			$daftar_lapangan->NamaLapangan->ViewCustomAttributes = "";

			// Ukuran
			$daftar_lapangan->Ukuran->ViewValue = $daftar_lapangan->Ukuran->CurrentValue;
			$daftar_lapangan->Ukuran->CssStyle = "";
			$daftar_lapangan->Ukuran->CssClass = "";
			$daftar_lapangan->Ukuran->ViewCustomAttributes = "";

			// Kondisi
			$daftar_lapangan->Kondisi->ViewValue = $daftar_lapangan->Kondisi->CurrentValue;
			$daftar_lapangan->Kondisi->CssStyle = "";
			$daftar_lapangan->Kondisi->CssClass = "";
			$daftar_lapangan->Kondisi->ViewCustomAttributes = "";

			// HargaSewa1
			$daftar_lapangan->HargaSewa1->ViewValue = $daftar_lapangan->HargaSewa1->CurrentValue;
			$daftar_lapangan->HargaSewa1->ViewValue = ew_FormatNumber($daftar_lapangan->HargaSewa1->ViewValue, 0, -2, -2, -2);
			$daftar_lapangan->HargaSewa1->CssStyle = "";
			$daftar_lapangan->HargaSewa1->CssClass = "";
			$daftar_lapangan->HargaSewa1->ViewCustomAttributes = "";

			// HargaSewa2
			$daftar_lapangan->HargaSewa2->ViewValue = $daftar_lapangan->HargaSewa2->CurrentValue;
			$daftar_lapangan->HargaSewa2->ViewValue = ew_FormatNumber($daftar_lapangan->HargaSewa2->ViewValue, 0, -2, -2, -2);
			$daftar_lapangan->HargaSewa2->CssStyle = "";
			$daftar_lapangan->HargaSewa2->CssClass = "";
			$daftar_lapangan->HargaSewa2->ViewCustomAttributes = "";

			// HargaSewa3
			$daftar_lapangan->HargaSewa3->ViewValue = $daftar_lapangan->HargaSewa3->CurrentValue;
			$daftar_lapangan->HargaSewa3->ViewValue = ew_FormatNumber($daftar_lapangan->HargaSewa3->ViewValue, 0, -2, -2, -2);
			$daftar_lapangan->HargaSewa3->CssStyle = "";
			$daftar_lapangan->HargaSewa3->CssClass = "";
			$daftar_lapangan->HargaSewa3->ViewCustomAttributes = "";

			// HargaSewa4
			$daftar_lapangan->HargaSewa4->ViewValue = $daftar_lapangan->HargaSewa4->CurrentValue;
			$daftar_lapangan->HargaSewa4->ViewValue = ew_FormatNumber($daftar_lapangan->HargaSewa4->ViewValue, 0, -2, -2, -2);
			$daftar_lapangan->HargaSewa4->CssStyle = "";
			$daftar_lapangan->HargaSewa4->CssClass = "";
			$daftar_lapangan->HargaSewa4->ViewCustomAttributes = "";

			// NamaLapangan
			$daftar_lapangan->NamaLapangan->HrefValue = "";
			$daftar_lapangan->NamaLapangan->TooltipValue = "";

			// Ukuran
			$daftar_lapangan->Ukuran->HrefValue = "";
			$daftar_lapangan->Ukuran->TooltipValue = "";

			// Kondisi
			$daftar_lapangan->Kondisi->HrefValue = "";
			$daftar_lapangan->Kondisi->TooltipValue = "";

			// HargaSewa1
			$daftar_lapangan->HargaSewa1->HrefValue = "";
			$daftar_lapangan->HargaSewa1->TooltipValue = "";

			// HargaSewa2
			$daftar_lapangan->HargaSewa2->HrefValue = "";
			$daftar_lapangan->HargaSewa2->TooltipValue = "";

			// HargaSewa3
			$daftar_lapangan->HargaSewa3->HrefValue = "";
			$daftar_lapangan->HargaSewa3->TooltipValue = "";

			// HargaSewa4
			$daftar_lapangan->HargaSewa4->HrefValue = "";
			$daftar_lapangan->HargaSewa4->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($daftar_lapangan->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$daftar_lapangan->Row_Rendered();
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

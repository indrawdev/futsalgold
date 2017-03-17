<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
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
$z2padmin_view = new cz2padmin_view();
$Page =& $z2padmin_view;

// Page init
$z2padmin_view->Page_Init();

// Page main
$z2padmin_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($z2padmin->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var z2padmin_view = new ew_Page("z2padmin_view");

// page properties
z2padmin_view.PageID = "view"; // page ID
z2padmin_view.FormID = "fz2padminview"; // form ID
var EW_PAGE_ID = z2padmin_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
z2padmin_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
z2padmin_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
z2padmin_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $z2padmin->TableCaption() ?>
<br><br>
<?php if ($z2padmin->Export == "") { ?>
<a href="<?php echo $z2padmin_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($z2padmin_view->ShowOptionLink()) { ?>
<a href="<?php echo $z2padmin_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($z2padmin_view->ShowOptionLink()) { ?>
<a href="<?php echo $z2padmin_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($z2padmin_view->ShowOptionLink()) { ?>
<a href="<?php echo $z2padmin_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$z2padmin_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($z2padmin->Nama->Visible) { // Nama ?>
	<tr<?php echo $z2padmin->Nama->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Nama->FldCaption() ?></td>
		<td<?php echo $z2padmin->Nama->CellAttributes() ?>>
<div<?php echo $z2padmin->Nama->ViewAttributes() ?>><?php echo $z2padmin->Nama->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($z2padmin->Username->Visible) { // Username ?>
	<tr<?php echo $z2padmin->Username->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Username->FldCaption() ?></td>
		<td<?php echo $z2padmin->Username->CellAttributes() ?>>
<div<?php echo $z2padmin->Username->ViewAttributes() ?>><?php echo $z2padmin->Username->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($z2padmin->Password->Visible) { // Password ?>
	<tr<?php echo $z2padmin->Password->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Password->FldCaption() ?></td>
		<td<?php echo $z2padmin->Password->CellAttributes() ?>>
<div<?php echo $z2padmin->Password->ViewAttributes() ?>><?php echo $z2padmin->Password->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($z2padmin->Jabatan->Visible) { // Jabatan ?>
	<tr<?php echo $z2padmin->Jabatan->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Jabatan->FldCaption() ?></td>
		<td<?php echo $z2padmin->Jabatan->CellAttributes() ?>>
<div<?php echo $z2padmin->Jabatan->ViewAttributes() ?>><?php echo $z2padmin->Jabatan->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($z2padmin->Foto->Visible) { // Foto ?>
	<tr<?php echo $z2padmin->Foto->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Foto->FldCaption() ?></td>
		<td<?php echo $z2padmin->Foto->CellAttributes() ?>>
<?php if ($z2padmin->Foto->HrefValue <> "" || $z2padmin->Foto->TooltipValue <> "") { ?>
<?php if (!empty($z2padmin->Foto->Upload->DbValue)) { ?>
<a href="<?php echo $z2padmin->Foto->HrefValue ?>" target="_blank"><?php echo $z2padmin->Foto->ViewValue ?></a>
<?php } elseif (!in_array($z2padmin->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($z2padmin->Foto->Upload->DbValue)) { ?>
<?php echo $z2padmin->Foto->ViewValue ?>
<?php } elseif (!in_array($z2padmin->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	</tr>
<?php } ?>
<?php if ($z2padmin->Temp->Visible) { // Temp ?>
	<tr<?php echo $z2padmin->Temp->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Temp->FldCaption() ?></td>
		<td<?php echo $z2padmin->Temp->CellAttributes() ?>>
<div<?php echo $z2padmin->Temp->ViewAttributes() ?>><?php echo $z2padmin->Temp->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($z2padmin->Level->Visible) { // Level ?>
	<tr<?php echo $z2padmin->Level->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Level->FldCaption() ?></td>
		<td<?php echo $z2padmin->Level->CellAttributes() ?>>
<div<?php echo $z2padmin->Level->ViewAttributes() ?>><?php echo $z2padmin->Level->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($z2padmin->ID->Visible) { // ID ?>
	<tr<?php echo $z2padmin->ID->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->ID->FldCaption() ?></td>
		<td<?php echo $z2padmin->ID->CellAttributes() ?>>
<div<?php echo $z2padmin->ID->ViewAttributes() ?>><?php echo $z2padmin->ID->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($z2padmin->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$z2padmin_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cz2padmin_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = '2padmin';

	// Page object name
	var $PageObjName = 'z2padmin_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $z2padmin;
		if ($z2padmin->UseTokenInUrl) $PageUrl .= "t=" . $z2padmin->TableVar . "&"; // Add page token
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
		global $objForm, $z2padmin;
		if ($z2padmin->UseTokenInUrl) {
			if ($objForm)
				return ($z2padmin->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($z2padmin->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cz2padmin_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (z2padmin)
		$GLOBALS["z2padmin"] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", '2padmin', TRUE);

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
		global $z2padmin;

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
		if ($Security->IsLoggedIn() && $Security->CurrentUserID() == "") {
			$_SESSION[EW_SESSION_MESSAGE] = $Language->Phrase("NoPermission");
			$this->Page_Terminate("z2padminlist.php");
		}

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
		global $Language, $z2padmin;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ID"] <> "") {
				$z2padmin->ID->setQueryStringValue($_GET["ID"]);
				$this->arRecKey["ID"] = $z2padmin->ID->QueryStringValue;
			} else {
				$sReturnUrl = "z2padminlist.php"; // Return to list
			}

			// Get action
			$z2padmin->CurrentAction = "I"; // Display form
			switch ($z2padmin->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "z2padminlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "z2padminlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$z2padmin->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $z2padmin;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$z2padmin->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$z2padmin->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $z2padmin->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$z2padmin->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$z2padmin->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$z2padmin->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $z2padmin;
		$sFilter = $z2padmin->KeyFilter();

		// Call Row Selecting event
		$z2padmin->Row_Selecting($sFilter);

		// Load SQL based on filter
		$z2padmin->CurrentFilter = $sFilter;
		$sSql = $z2padmin->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$z2padmin->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $z2padmin;
		$z2padmin->Nama->setDbValue($rs->fields('Nama'));
		$z2padmin->Username->setDbValue($rs->fields('Username'));
		$z2padmin->Password->setDbValue($rs->fields('Password'));
		$z2padmin->Jabatan->setDbValue($rs->fields('Jabatan'));
		$z2padmin->Foto->Upload->DbValue = $rs->fields('Foto');
		$z2padmin->Temp->setDbValue($rs->fields('Temp'));
		$z2padmin->Level->setDbValue($rs->fields('Level'));
		$z2padmin->ID->setDbValue($rs->fields('ID'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $z2padmin;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "ID=" . urlencode($z2padmin->ID->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "ID=" . urlencode($z2padmin->ID->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "ID=" . urlencode($z2padmin->ID->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "ID=" . urlencode($z2padmin->ID->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "ID=" . urlencode($z2padmin->ID->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "ID=" . urlencode($z2padmin->ID->CurrentValue);
		$this->AddUrl = $z2padmin->AddUrl();
		$this->EditUrl = $z2padmin->EditUrl();
		$this->CopyUrl = $z2padmin->CopyUrl();
		$this->DeleteUrl = $z2padmin->DeleteUrl();
		$this->ListUrl = $z2padmin->ListUrl();

		// Call Row_Rendering event
		$z2padmin->Row_Rendering();

		// Common render codes for all row types
		// Nama

		$z2padmin->Nama->CellCssStyle = ""; $z2padmin->Nama->CellCssClass = "";
		$z2padmin->Nama->CellAttrs = array(); $z2padmin->Nama->ViewAttrs = array(); $z2padmin->Nama->EditAttrs = array();

		// Username
		$z2padmin->Username->CellCssStyle = ""; $z2padmin->Username->CellCssClass = "";
		$z2padmin->Username->CellAttrs = array(); $z2padmin->Username->ViewAttrs = array(); $z2padmin->Username->EditAttrs = array();

		// Password
		$z2padmin->Password->CellCssStyle = ""; $z2padmin->Password->CellCssClass = "";
		$z2padmin->Password->CellAttrs = array(); $z2padmin->Password->ViewAttrs = array(); $z2padmin->Password->EditAttrs = array();

		// Jabatan
		$z2padmin->Jabatan->CellCssStyle = ""; $z2padmin->Jabatan->CellCssClass = "";
		$z2padmin->Jabatan->CellAttrs = array(); $z2padmin->Jabatan->ViewAttrs = array(); $z2padmin->Jabatan->EditAttrs = array();

		// Foto
		$z2padmin->Foto->CellCssStyle = ""; $z2padmin->Foto->CellCssClass = "";
		$z2padmin->Foto->CellAttrs = array(); $z2padmin->Foto->ViewAttrs = array(); $z2padmin->Foto->EditAttrs = array();

		// Temp
		$z2padmin->Temp->CellCssStyle = ""; $z2padmin->Temp->CellCssClass = "";
		$z2padmin->Temp->CellAttrs = array(); $z2padmin->Temp->ViewAttrs = array(); $z2padmin->Temp->EditAttrs = array();

		// Level
		$z2padmin->Level->CellCssStyle = ""; $z2padmin->Level->CellCssClass = "";
		$z2padmin->Level->CellAttrs = array(); $z2padmin->Level->ViewAttrs = array(); $z2padmin->Level->EditAttrs = array();

		// ID
		$z2padmin->ID->CellCssStyle = ""; $z2padmin->ID->CellCssClass = "";
		$z2padmin->ID->CellAttrs = array(); $z2padmin->ID->ViewAttrs = array(); $z2padmin->ID->EditAttrs = array();
		if ($z2padmin->RowType == EW_ROWTYPE_VIEW) { // View row

			// Nama
			$z2padmin->Nama->ViewValue = $z2padmin->Nama->CurrentValue;
			$z2padmin->Nama->CssStyle = "";
			$z2padmin->Nama->CssClass = "";
			$z2padmin->Nama->ViewCustomAttributes = "";

			// Username
			$z2padmin->Username->ViewValue = $z2padmin->Username->CurrentValue;
			$z2padmin->Username->CssStyle = "";
			$z2padmin->Username->CssClass = "";
			$z2padmin->Username->ViewCustomAttributes = "";

			// Password
			$z2padmin->Password->ViewValue = $z2padmin->Password->CurrentValue;
			$z2padmin->Password->CssStyle = "";
			$z2padmin->Password->CssClass = "";
			$z2padmin->Password->ViewCustomAttributes = "";

			// Jabatan
			$z2padmin->Jabatan->ViewValue = $z2padmin->Jabatan->CurrentValue;
			$z2padmin->Jabatan->CssStyle = "";
			$z2padmin->Jabatan->CssClass = "";
			$z2padmin->Jabatan->ViewCustomAttributes = "";

			// Foto
			if (!ew_Empty($z2padmin->Foto->Upload->DbValue)) {
				$z2padmin->Foto->ViewValue = $z2padmin->Foto->FldCaption();
			} else {
				$z2padmin->Foto->ViewValue = "";
			}
			$z2padmin->Foto->CssStyle = "";
			$z2padmin->Foto->CssClass = "";
			$z2padmin->Foto->ViewCustomAttributes = "";

			// Temp
			$z2padmin->Temp->ViewValue = $z2padmin->Temp->CurrentValue;
			$z2padmin->Temp->ViewValue = ew_FormatDateTime($z2padmin->Temp->ViewValue, 5);
			$z2padmin->Temp->CssStyle = "";
			$z2padmin->Temp->CssClass = "";
			$z2padmin->Temp->ViewCustomAttributes = "";

			// Level
			$z2padmin->Level->ViewValue = $z2padmin->Level->CurrentValue;
			$z2padmin->Level->CssStyle = "";
			$z2padmin->Level->CssClass = "";
			$z2padmin->Level->ViewCustomAttributes = "";

			// ID
			$z2padmin->ID->ViewValue = $z2padmin->ID->CurrentValue;
			$z2padmin->ID->CssStyle = "";
			$z2padmin->ID->CssClass = "";
			$z2padmin->ID->ViewCustomAttributes = "";

			// Nama
			$z2padmin->Nama->HrefValue = "";
			$z2padmin->Nama->TooltipValue = "";

			// Username
			$z2padmin->Username->HrefValue = "";
			$z2padmin->Username->TooltipValue = "";

			// Password
			$z2padmin->Password->HrefValue = "";
			$z2padmin->Password->TooltipValue = "";

			// Jabatan
			$z2padmin->Jabatan->HrefValue = "";
			$z2padmin->Jabatan->TooltipValue = "";

			// Foto
			if (!empty($z2padmin->Foto->Upload->DbValue)) {
				$z2padmin->Foto->HrefValue = "z2padmin_Foto_bv.php?ID=" . $z2padmin->ID->CurrentValue;
				if ($z2padmin->Export <> "") $z2padmin->Foto->HrefValue = ew_ConvertFullUrl($z2padmin->Foto->HrefValue);
			} else {
				$z2padmin->Foto->HrefValue = "";
			}
			$z2padmin->Foto->TooltipValue = "";

			// Temp
			$z2padmin->Temp->HrefValue = "";
			$z2padmin->Temp->TooltipValue = "";

			// Level
			$z2padmin->Level->HrefValue = "";
			$z2padmin->Level->TooltipValue = "";

			// ID
			$z2padmin->ID->HrefValue = "";
			$z2padmin->ID->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($z2padmin->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$z2padmin->Row_Rendered();
	}

	// Show link optionally based on User ID
	function ShowOptionLink() {
		global $Security, $z2padmin;
		if ($Security->IsLoggedIn()) {
			if (!$Security->IsAdmin()) {
				return $Security->IsValidUserID($z2padmin->Level->CurrentValue);
			}
		}
		return TRUE;
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

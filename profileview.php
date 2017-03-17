<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "profileinfo.php" ?>
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
$profile_view = new cprofile_view();
$Page =& $profile_view;

// Page init
$profile_view->Page_Init();

// Page main
$profile_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($profile->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var profile_view = new ew_Page("profile_view");

// page properties
profile_view.PageID = "view"; // page ID
profile_view.FormID = "fprofileview"; // form ID
var EW_PAGE_ID = profile_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
profile_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
profile_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
profile_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $profile->TableCaption() ?>
<br><br>
<?php if ($profile->Export == "") { ?>
<a href="<?php echo $profile_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $profile_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $profile_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $profile_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$profile_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($profile->ID->Visible) { // ID ?>
	<tr<?php echo $profile->ID->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->ID->FldCaption() ?></td>
		<td<?php echo $profile->ID->CellAttributes() ?>>
<div<?php echo $profile->ID->ViewAttributes() ?>><?php echo $profile->ID->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->Kode->Visible) { // Kode ?>
	<tr<?php echo $profile->Kode->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Kode->FldCaption() ?></td>
		<td<?php echo $profile->Kode->CellAttributes() ?>>
<div<?php echo $profile->Kode->ViewAttributes() ?>><?php echo $profile->Kode->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->NamaToko->Visible) { // NamaToko ?>
	<tr<?php echo $profile->NamaToko->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->NamaToko->FldCaption() ?></td>
		<td<?php echo $profile->NamaToko->CellAttributes() ?>>
<div<?php echo $profile->NamaToko->ViewAttributes() ?>><?php echo $profile->NamaToko->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->Pemilik->Visible) { // Pemilik ?>
	<tr<?php echo $profile->Pemilik->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Pemilik->FldCaption() ?></td>
		<td<?php echo $profile->Pemilik->CellAttributes() ?>>
<div<?php echo $profile->Pemilik->ViewAttributes() ?>><?php echo $profile->Pemilik->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->Alamat->Visible) { // Alamat ?>
	<tr<?php echo $profile->Alamat->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Alamat->FldCaption() ?></td>
		<td<?php echo $profile->Alamat->CellAttributes() ?>>
<div<?php echo $profile->Alamat->ViewAttributes() ?>><?php echo $profile->Alamat->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->Kota->Visible) { // Kota ?>
	<tr<?php echo $profile->Kota->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Kota->FldCaption() ?></td>
		<td<?php echo $profile->Kota->CellAttributes() ?>>
<div<?php echo $profile->Kota->ViewAttributes() ?>><?php echo $profile->Kota->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->Telepon->Visible) { // Telepon ?>
	<tr<?php echo $profile->Telepon->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Telepon->FldCaption() ?></td>
		<td<?php echo $profile->Telepon->CellAttributes() ?>>
<div<?php echo $profile->Telepon->ViewAttributes() ?>><?php echo $profile->Telepon->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->zEmail->Visible) { // Email ?>
	<tr<?php echo $profile->zEmail->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->zEmail->FldCaption() ?></td>
		<td<?php echo $profile->zEmail->CellAttributes() ?>>
<div<?php echo $profile->zEmail->ViewAttributes() ?>><?php echo $profile->zEmail->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->Foto->Visible) { // Foto ?>
	<tr<?php echo $profile->Foto->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Foto->FldCaption() ?></td>
		<td<?php echo $profile->Foto->CellAttributes() ?>>
<?php if ($profile->Foto->HrefValue <> "" || $profile->Foto->TooltipValue <> "") { ?>
<?php if (!empty($profile->Foto->Upload->DbValue)) { ?>
<a href="<?php echo $profile->Foto->HrefValue ?>" target="_blank"><?php echo $profile->Foto->ViewValue ?></a>
<?php } elseif (!in_array($profile->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($profile->Foto->Upload->DbValue)) { ?>
<?php echo $profile->Foto->ViewValue ?>
<?php } elseif (!in_array($profile->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</td>
	</tr>
<?php } ?>
<?php if ($profile->Serial->Visible) { // Serial ?>
	<tr<?php echo $profile->Serial->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Serial->FldCaption() ?></td>
		<td<?php echo $profile->Serial->CellAttributes() ?>>
<div<?php echo $profile->Serial->ViewAttributes() ?>><?php echo $profile->Serial->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->KeyCode->Visible) { // KeyCode ?>
	<tr<?php echo $profile->KeyCode->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->KeyCode->FldCaption() ?></td>
		<td<?php echo $profile->KeyCode->CellAttributes() ?>>
<div<?php echo $profile->KeyCode->ViewAttributes() ?>><?php echo $profile->KeyCode->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->Waktu->Visible) { // Waktu ?>
	<tr<?php echo $profile->Waktu->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Waktu->FldCaption() ?></td>
		<td<?php echo $profile->Waktu->CellAttributes() ?>>
<div<?php echo $profile->Waktu->ViewAttributes() ?>><?php echo $profile->Waktu->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($profile->Stamp->Visible) { // Stamp ?>
	<tr<?php echo $profile->Stamp->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Stamp->FldCaption() ?></td>
		<td<?php echo $profile->Stamp->CellAttributes() ?>>
<div<?php echo $profile->Stamp->ViewAttributes() ?>><?php echo $profile->Stamp->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($profile->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$profile_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cprofile_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'profile';

	// Page object name
	var $PageObjName = 'profile_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $profile;
		if ($profile->UseTokenInUrl) $PageUrl .= "t=" . $profile->TableVar . "&"; // Add page token
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
		global $objForm, $profile;
		if ($profile->UseTokenInUrl) {
			if ($objForm)
				return ($profile->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($profile->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cprofile_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (profile)
		$GLOBALS["profile"] = new cprofile();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'profile', TRUE);

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
		global $profile;

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
		global $Language, $profile;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ID"] <> "") {
				$profile->ID->setQueryStringValue($_GET["ID"]);
				$this->arRecKey["ID"] = $profile->ID->QueryStringValue;
			} else {
				$sReturnUrl = "profilelist.php"; // Return to list
			}

			// Get action
			$profile->CurrentAction = "I"; // Display form
			switch ($profile->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "profilelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "profilelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$profile->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $profile;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$profile->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$profile->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $profile->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$profile->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$profile->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$profile->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $profile;
		$sFilter = $profile->KeyFilter();

		// Call Row Selecting event
		$profile->Row_Selecting($sFilter);

		// Load SQL based on filter
		$profile->CurrentFilter = $sFilter;
		$sSql = $profile->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$profile->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $profile;
		$profile->ID->setDbValue($rs->fields('ID'));
		$profile->Kode->setDbValue($rs->fields('Kode'));
		$profile->NamaToko->setDbValue($rs->fields('NamaToko'));
		$profile->Pemilik->setDbValue($rs->fields('Pemilik'));
		$profile->Alamat->setDbValue($rs->fields('Alamat'));
		$profile->Kota->setDbValue($rs->fields('Kota'));
		$profile->Telepon->setDbValue($rs->fields('Telepon'));
		$profile->zEmail->setDbValue($rs->fields('Email'));
		$profile->Foto->Upload->DbValue = $rs->fields('Foto');
		$profile->Serial->setDbValue($rs->fields('Serial'));
		$profile->KeyCode->setDbValue($rs->fields('KeyCode'));
		$profile->Waktu->setDbValue($rs->fields('Waktu'));
		$profile->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $profile;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "ID=" . urlencode($profile->ID->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "ID=" . urlencode($profile->ID->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "ID=" . urlencode($profile->ID->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "ID=" . urlencode($profile->ID->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "ID=" . urlencode($profile->ID->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "ID=" . urlencode($profile->ID->CurrentValue);
		$this->AddUrl = $profile->AddUrl();
		$this->EditUrl = $profile->EditUrl();
		$this->CopyUrl = $profile->CopyUrl();
		$this->DeleteUrl = $profile->DeleteUrl();
		$this->ListUrl = $profile->ListUrl();

		// Call Row_Rendering event
		$profile->Row_Rendering();

		// Common render codes for all row types
		// ID

		$profile->ID->CellCssStyle = ""; $profile->ID->CellCssClass = "";
		$profile->ID->CellAttrs = array(); $profile->ID->ViewAttrs = array(); $profile->ID->EditAttrs = array();

		// Kode
		$profile->Kode->CellCssStyle = ""; $profile->Kode->CellCssClass = "";
		$profile->Kode->CellAttrs = array(); $profile->Kode->ViewAttrs = array(); $profile->Kode->EditAttrs = array();

		// NamaToko
		$profile->NamaToko->CellCssStyle = ""; $profile->NamaToko->CellCssClass = "";
		$profile->NamaToko->CellAttrs = array(); $profile->NamaToko->ViewAttrs = array(); $profile->NamaToko->EditAttrs = array();

		// Pemilik
		$profile->Pemilik->CellCssStyle = ""; $profile->Pemilik->CellCssClass = "";
		$profile->Pemilik->CellAttrs = array(); $profile->Pemilik->ViewAttrs = array(); $profile->Pemilik->EditAttrs = array();

		// Alamat
		$profile->Alamat->CellCssStyle = ""; $profile->Alamat->CellCssClass = "";
		$profile->Alamat->CellAttrs = array(); $profile->Alamat->ViewAttrs = array(); $profile->Alamat->EditAttrs = array();

		// Kota
		$profile->Kota->CellCssStyle = ""; $profile->Kota->CellCssClass = "";
		$profile->Kota->CellAttrs = array(); $profile->Kota->ViewAttrs = array(); $profile->Kota->EditAttrs = array();

		// Telepon
		$profile->Telepon->CellCssStyle = ""; $profile->Telepon->CellCssClass = "";
		$profile->Telepon->CellAttrs = array(); $profile->Telepon->ViewAttrs = array(); $profile->Telepon->EditAttrs = array();

		// Email
		$profile->zEmail->CellCssStyle = ""; $profile->zEmail->CellCssClass = "";
		$profile->zEmail->CellAttrs = array(); $profile->zEmail->ViewAttrs = array(); $profile->zEmail->EditAttrs = array();

		// Foto
		$profile->Foto->CellCssStyle = ""; $profile->Foto->CellCssClass = "";
		$profile->Foto->CellAttrs = array(); $profile->Foto->ViewAttrs = array(); $profile->Foto->EditAttrs = array();

		// Serial
		$profile->Serial->CellCssStyle = ""; $profile->Serial->CellCssClass = "";
		$profile->Serial->CellAttrs = array(); $profile->Serial->ViewAttrs = array(); $profile->Serial->EditAttrs = array();

		// KeyCode
		$profile->KeyCode->CellCssStyle = ""; $profile->KeyCode->CellCssClass = "";
		$profile->KeyCode->CellAttrs = array(); $profile->KeyCode->ViewAttrs = array(); $profile->KeyCode->EditAttrs = array();

		// Waktu
		$profile->Waktu->CellCssStyle = ""; $profile->Waktu->CellCssClass = "";
		$profile->Waktu->CellAttrs = array(); $profile->Waktu->ViewAttrs = array(); $profile->Waktu->EditAttrs = array();

		// Stamp
		$profile->Stamp->CellCssStyle = ""; $profile->Stamp->CellCssClass = "";
		$profile->Stamp->CellAttrs = array(); $profile->Stamp->ViewAttrs = array(); $profile->Stamp->EditAttrs = array();
		if ($profile->RowType == EW_ROWTYPE_VIEW) { // View row

			// ID
			$profile->ID->ViewValue = $profile->ID->CurrentValue;
			$profile->ID->CssStyle = "";
			$profile->ID->CssClass = "";
			$profile->ID->ViewCustomAttributes = "";

			// Kode
			$profile->Kode->ViewValue = $profile->Kode->CurrentValue;
			$profile->Kode->CssStyle = "";
			$profile->Kode->CssClass = "";
			$profile->Kode->ViewCustomAttributes = "";

			// NamaToko
			$profile->NamaToko->ViewValue = $profile->NamaToko->CurrentValue;
			$profile->NamaToko->CssStyle = "";
			$profile->NamaToko->CssClass = "";
			$profile->NamaToko->ViewCustomAttributes = "";

			// Pemilik
			$profile->Pemilik->ViewValue = $profile->Pemilik->CurrentValue;
			$profile->Pemilik->CssStyle = "";
			$profile->Pemilik->CssClass = "";
			$profile->Pemilik->ViewCustomAttributes = "";

			// Alamat
			$profile->Alamat->ViewValue = $profile->Alamat->CurrentValue;
			$profile->Alamat->CssStyle = "";
			$profile->Alamat->CssClass = "";
			$profile->Alamat->ViewCustomAttributes = "";

			// Kota
			$profile->Kota->ViewValue = $profile->Kota->CurrentValue;
			$profile->Kota->CssStyle = "";
			$profile->Kota->CssClass = "";
			$profile->Kota->ViewCustomAttributes = "";

			// Telepon
			$profile->Telepon->ViewValue = $profile->Telepon->CurrentValue;
			$profile->Telepon->CssStyle = "";
			$profile->Telepon->CssClass = "";
			$profile->Telepon->ViewCustomAttributes = "";

			// Email
			$profile->zEmail->ViewValue = $profile->zEmail->CurrentValue;
			$profile->zEmail->CssStyle = "";
			$profile->zEmail->CssClass = "";
			$profile->zEmail->ViewCustomAttributes = "";

			// Foto
			if (!ew_Empty($profile->Foto->Upload->DbValue)) {
				$profile->Foto->ViewValue = $profile->Foto->FldCaption();
			} else {
				$profile->Foto->ViewValue = "";
			}
			$profile->Foto->CssStyle = "";
			$profile->Foto->CssClass = "";
			$profile->Foto->ViewCustomAttributes = "";

			// Serial
			$profile->Serial->ViewValue = $profile->Serial->CurrentValue;
			$profile->Serial->CssStyle = "";
			$profile->Serial->CssClass = "";
			$profile->Serial->ViewCustomAttributes = "";

			// KeyCode
			$profile->KeyCode->ViewValue = $profile->KeyCode->CurrentValue;
			$profile->KeyCode->CssStyle = "";
			$profile->KeyCode->CssClass = "";
			$profile->KeyCode->ViewCustomAttributes = "";

			// Waktu
			$profile->Waktu->ViewValue = $profile->Waktu->CurrentValue;
			$profile->Waktu->ViewValue = ew_FormatDateTime($profile->Waktu->ViewValue, 5);
			$profile->Waktu->CssStyle = "";
			$profile->Waktu->CssClass = "";
			$profile->Waktu->ViewCustomAttributes = "";

			// Stamp
			$profile->Stamp->ViewValue = $profile->Stamp->CurrentValue;
			$profile->Stamp->ViewValue = ew_FormatDateTime($profile->Stamp->ViewValue, 5);
			$profile->Stamp->CssStyle = "";
			$profile->Stamp->CssClass = "";
			$profile->Stamp->ViewCustomAttributes = "";

			// ID
			$profile->ID->HrefValue = "";
			$profile->ID->TooltipValue = "";

			// Kode
			$profile->Kode->HrefValue = "";
			$profile->Kode->TooltipValue = "";

			// NamaToko
			$profile->NamaToko->HrefValue = "";
			$profile->NamaToko->TooltipValue = "";

			// Pemilik
			$profile->Pemilik->HrefValue = "";
			$profile->Pemilik->TooltipValue = "";

			// Alamat
			$profile->Alamat->HrefValue = "";
			$profile->Alamat->TooltipValue = "";

			// Kota
			$profile->Kota->HrefValue = "";
			$profile->Kota->TooltipValue = "";

			// Telepon
			$profile->Telepon->HrefValue = "";
			$profile->Telepon->TooltipValue = "";

			// Email
			$profile->zEmail->HrefValue = "";
			$profile->zEmail->TooltipValue = "";

			// Foto
			if (!empty($profile->Foto->Upload->DbValue)) {
				$profile->Foto->HrefValue = "profile_Foto_bv.php?ID=" . $profile->ID->CurrentValue;
				if ($profile->Export <> "") $profile->Foto->HrefValue = ew_ConvertFullUrl($profile->Foto->HrefValue);
			} else {
				$profile->Foto->HrefValue = "";
			}
			$profile->Foto->TooltipValue = "";

			// Serial
			$profile->Serial->HrefValue = "";
			$profile->Serial->TooltipValue = "";

			// KeyCode
			$profile->KeyCode->HrefValue = "";
			$profile->KeyCode->TooltipValue = "";

			// Waktu
			$profile->Waktu->HrefValue = "";
			$profile->Waktu->TooltipValue = "";

			// Stamp
			$profile->Stamp->HrefValue = "";
			$profile->Stamp->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($profile->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$profile->Row_Rendered();
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

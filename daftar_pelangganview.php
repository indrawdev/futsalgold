<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "daftar_pelangganinfo.php" ?>
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
$daftar_pelanggan_view = new cdaftar_pelanggan_view();
$Page =& $daftar_pelanggan_view;

// Page init
$daftar_pelanggan_view->Page_Init();

// Page main
$daftar_pelanggan_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($daftar_pelanggan->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var daftar_pelanggan_view = new ew_Page("daftar_pelanggan_view");

// page properties
daftar_pelanggan_view.PageID = "view"; // page ID
daftar_pelanggan_view.FormID = "fdaftar_pelangganview"; // form ID
var EW_PAGE_ID = daftar_pelanggan_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
daftar_pelanggan_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
daftar_pelanggan_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
daftar_pelanggan_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $daftar_pelanggan->TableCaption() ?>
<br><br>
<?php if ($daftar_pelanggan->Export == "") { ?>
<a href="<?php echo $daftar_pelanggan_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $daftar_pelanggan_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $daftar_pelanggan_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $daftar_pelanggan_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$daftar_pelanggan_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($daftar_pelanggan->ID->Visible) { // ID ?>
	<tr<?php echo $daftar_pelanggan->ID->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->ID->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->ID->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->ID->ViewAttributes() ?>><?php echo $daftar_pelanggan->ID->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Kode->Visible) { // Kode ?>
	<tr<?php echo $daftar_pelanggan->Kode->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->Kode->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->Kode->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->Kode->ViewAttributes() ?>><?php echo $daftar_pelanggan->Kode->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->NamaPenyewa->Visible) { // NamaPenyewa ?>
	<tr<?php echo $daftar_pelanggan->NamaPenyewa->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->NamaPenyewa->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->NamaPenyewa->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->NamaPenyewa->ViewAttributes() ?>><?php echo $daftar_pelanggan->NamaPenyewa->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->NamaTeam->Visible) { // NamaTeam ?>
	<tr<?php echo $daftar_pelanggan->NamaTeam->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->NamaTeam->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->NamaTeam->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->NamaTeam->ViewAttributes() ?>><?php echo $daftar_pelanggan->NamaTeam->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Alamat->Visible) { // Alamat ?>
	<tr<?php echo $daftar_pelanggan->Alamat->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->Alamat->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->Alamat->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->Alamat->ViewAttributes() ?>><?php echo $daftar_pelanggan->Alamat->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Kota->Visible) { // Kota ?>
	<tr<?php echo $daftar_pelanggan->Kota->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->Kota->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->Kota->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->Kota->ViewAttributes() ?>><?php echo $daftar_pelanggan->Kota->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Telepon->Visible) { // Telepon ?>
	<tr<?php echo $daftar_pelanggan->Telepon->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->Telepon->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->Telepon->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->Telepon->ViewAttributes() ?>><?php echo $daftar_pelanggan->Telepon->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Fax->Visible) { // Fax ?>
	<tr<?php echo $daftar_pelanggan->Fax->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->Fax->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->Fax->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->Fax->ViewAttributes() ?>><?php echo $daftar_pelanggan->Fax->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->HP->Visible) { // HP ?>
	<tr<?php echo $daftar_pelanggan->HP->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->HP->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->HP->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->HP->ViewAttributes() ?>><?php echo $daftar_pelanggan->HP->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->zEmail->Visible) { // Email ?>
	<tr<?php echo $daftar_pelanggan->zEmail->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->zEmail->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->zEmail->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->zEmail->ViewAttributes() ?>><?php echo $daftar_pelanggan->zEmail->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Website->Visible) { // Website ?>
	<tr<?php echo $daftar_pelanggan->Website->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->Website->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->Website->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->Website->ViewAttributes() ?>><?php echo $daftar_pelanggan->Website->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Main->Visible) { // Main ?>
	<tr<?php echo $daftar_pelanggan->Main->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->Main->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->Main->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->Main->ViewAttributes() ?>><?php echo $daftar_pelanggan->Main->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Waktu->Visible) { // Waktu ?>
	<tr<?php echo $daftar_pelanggan->Waktu->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->Waktu->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->Waktu->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->Waktu->ViewAttributes() ?>><?php echo $daftar_pelanggan->Waktu->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($daftar_pelanggan->Stamp->Visible) { // Stamp ?>
	<tr<?php echo $daftar_pelanggan->Stamp->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $daftar_pelanggan->Stamp->FldCaption() ?></td>
		<td<?php echo $daftar_pelanggan->Stamp->CellAttributes() ?>>
<div<?php echo $daftar_pelanggan->Stamp->ViewAttributes() ?>><?php echo $daftar_pelanggan->Stamp->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($daftar_pelanggan->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$daftar_pelanggan_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cdaftar_pelanggan_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'daftar pelanggan';

	// Page object name
	var $PageObjName = 'daftar_pelanggan_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $daftar_pelanggan;
		if ($daftar_pelanggan->UseTokenInUrl) $PageUrl .= "t=" . $daftar_pelanggan->TableVar . "&"; // Add page token
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
		global $objForm, $daftar_pelanggan;
		if ($daftar_pelanggan->UseTokenInUrl) {
			if ($objForm)
				return ($daftar_pelanggan->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($daftar_pelanggan->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cdaftar_pelanggan_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (daftar_pelanggan)
		$GLOBALS["daftar_pelanggan"] = new cdaftar_pelanggan();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'daftar pelanggan', TRUE);

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
		global $daftar_pelanggan;

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
		global $Language, $daftar_pelanggan;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ID"] <> "") {
				$daftar_pelanggan->ID->setQueryStringValue($_GET["ID"]);
				$this->arRecKey["ID"] = $daftar_pelanggan->ID->QueryStringValue;
			} else {
				$sReturnUrl = "daftar_pelangganlist.php"; // Return to list
			}

			// Get action
			$daftar_pelanggan->CurrentAction = "I"; // Display form
			switch ($daftar_pelanggan->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "daftar_pelangganlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "daftar_pelangganlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$daftar_pelanggan->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $daftar_pelanggan;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$daftar_pelanggan->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$daftar_pelanggan->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $daftar_pelanggan->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$daftar_pelanggan->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$daftar_pelanggan->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$daftar_pelanggan->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $daftar_pelanggan;
		$sFilter = $daftar_pelanggan->KeyFilter();

		// Call Row Selecting event
		$daftar_pelanggan->Row_Selecting($sFilter);

		// Load SQL based on filter
		$daftar_pelanggan->CurrentFilter = $sFilter;
		$sSql = $daftar_pelanggan->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$daftar_pelanggan->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $daftar_pelanggan;
		$daftar_pelanggan->ID->setDbValue($rs->fields('ID'));
		$daftar_pelanggan->Kode->setDbValue($rs->fields('Kode'));
		$daftar_pelanggan->NamaPenyewa->setDbValue($rs->fields('NamaPenyewa'));
		$daftar_pelanggan->NamaTeam->setDbValue($rs->fields('NamaTeam'));
		$daftar_pelanggan->Alamat->setDbValue($rs->fields('Alamat'));
		$daftar_pelanggan->Kota->setDbValue($rs->fields('Kota'));
		$daftar_pelanggan->Telepon->setDbValue($rs->fields('Telepon'));
		$daftar_pelanggan->Fax->setDbValue($rs->fields('Fax'));
		$daftar_pelanggan->HP->setDbValue($rs->fields('HP'));
		$daftar_pelanggan->zEmail->setDbValue($rs->fields('Email'));
		$daftar_pelanggan->Website->setDbValue($rs->fields('Website'));
		$daftar_pelanggan->Main->setDbValue($rs->fields('Main'));
		$daftar_pelanggan->Waktu->setDbValue($rs->fields('Waktu'));
		$daftar_pelanggan->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $daftar_pelanggan;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "ID=" . urlencode($daftar_pelanggan->ID->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "ID=" . urlencode($daftar_pelanggan->ID->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "ID=" . urlencode($daftar_pelanggan->ID->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "ID=" . urlencode($daftar_pelanggan->ID->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "ID=" . urlencode($daftar_pelanggan->ID->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "ID=" . urlencode($daftar_pelanggan->ID->CurrentValue);
		$this->AddUrl = $daftar_pelanggan->AddUrl();
		$this->EditUrl = $daftar_pelanggan->EditUrl();
		$this->CopyUrl = $daftar_pelanggan->CopyUrl();
		$this->DeleteUrl = $daftar_pelanggan->DeleteUrl();
		$this->ListUrl = $daftar_pelanggan->ListUrl();

		// Call Row_Rendering event
		$daftar_pelanggan->Row_Rendering();

		// Common render codes for all row types
		// ID

		$daftar_pelanggan->ID->CellCssStyle = ""; $daftar_pelanggan->ID->CellCssClass = "";
		$daftar_pelanggan->ID->CellAttrs = array(); $daftar_pelanggan->ID->ViewAttrs = array(); $daftar_pelanggan->ID->EditAttrs = array();

		// Kode
		$daftar_pelanggan->Kode->CellCssStyle = ""; $daftar_pelanggan->Kode->CellCssClass = "";
		$daftar_pelanggan->Kode->CellAttrs = array(); $daftar_pelanggan->Kode->ViewAttrs = array(); $daftar_pelanggan->Kode->EditAttrs = array();

		// NamaPenyewa
		$daftar_pelanggan->NamaPenyewa->CellCssStyle = ""; $daftar_pelanggan->NamaPenyewa->CellCssClass = "";
		$daftar_pelanggan->NamaPenyewa->CellAttrs = array(); $daftar_pelanggan->NamaPenyewa->ViewAttrs = array(); $daftar_pelanggan->NamaPenyewa->EditAttrs = array();

		// NamaTeam
		$daftar_pelanggan->NamaTeam->CellCssStyle = ""; $daftar_pelanggan->NamaTeam->CellCssClass = "";
		$daftar_pelanggan->NamaTeam->CellAttrs = array(); $daftar_pelanggan->NamaTeam->ViewAttrs = array(); $daftar_pelanggan->NamaTeam->EditAttrs = array();

		// Alamat
		$daftar_pelanggan->Alamat->CellCssStyle = ""; $daftar_pelanggan->Alamat->CellCssClass = "";
		$daftar_pelanggan->Alamat->CellAttrs = array(); $daftar_pelanggan->Alamat->ViewAttrs = array(); $daftar_pelanggan->Alamat->EditAttrs = array();

		// Kota
		$daftar_pelanggan->Kota->CellCssStyle = ""; $daftar_pelanggan->Kota->CellCssClass = "";
		$daftar_pelanggan->Kota->CellAttrs = array(); $daftar_pelanggan->Kota->ViewAttrs = array(); $daftar_pelanggan->Kota->EditAttrs = array();

		// Telepon
		$daftar_pelanggan->Telepon->CellCssStyle = ""; $daftar_pelanggan->Telepon->CellCssClass = "";
		$daftar_pelanggan->Telepon->CellAttrs = array(); $daftar_pelanggan->Telepon->ViewAttrs = array(); $daftar_pelanggan->Telepon->EditAttrs = array();

		// Fax
		$daftar_pelanggan->Fax->CellCssStyle = ""; $daftar_pelanggan->Fax->CellCssClass = "";
		$daftar_pelanggan->Fax->CellAttrs = array(); $daftar_pelanggan->Fax->ViewAttrs = array(); $daftar_pelanggan->Fax->EditAttrs = array();

		// HP
		$daftar_pelanggan->HP->CellCssStyle = ""; $daftar_pelanggan->HP->CellCssClass = "";
		$daftar_pelanggan->HP->CellAttrs = array(); $daftar_pelanggan->HP->ViewAttrs = array(); $daftar_pelanggan->HP->EditAttrs = array();

		// Email
		$daftar_pelanggan->zEmail->CellCssStyle = ""; $daftar_pelanggan->zEmail->CellCssClass = "";
		$daftar_pelanggan->zEmail->CellAttrs = array(); $daftar_pelanggan->zEmail->ViewAttrs = array(); $daftar_pelanggan->zEmail->EditAttrs = array();

		// Website
		$daftar_pelanggan->Website->CellCssStyle = ""; $daftar_pelanggan->Website->CellCssClass = "";
		$daftar_pelanggan->Website->CellAttrs = array(); $daftar_pelanggan->Website->ViewAttrs = array(); $daftar_pelanggan->Website->EditAttrs = array();

		// Main
		$daftar_pelanggan->Main->CellCssStyle = ""; $daftar_pelanggan->Main->CellCssClass = "";
		$daftar_pelanggan->Main->CellAttrs = array(); $daftar_pelanggan->Main->ViewAttrs = array(); $daftar_pelanggan->Main->EditAttrs = array();

		// Waktu
		$daftar_pelanggan->Waktu->CellCssStyle = ""; $daftar_pelanggan->Waktu->CellCssClass = "";
		$daftar_pelanggan->Waktu->CellAttrs = array(); $daftar_pelanggan->Waktu->ViewAttrs = array(); $daftar_pelanggan->Waktu->EditAttrs = array();

		// Stamp
		$daftar_pelanggan->Stamp->CellCssStyle = ""; $daftar_pelanggan->Stamp->CellCssClass = "";
		$daftar_pelanggan->Stamp->CellAttrs = array(); $daftar_pelanggan->Stamp->ViewAttrs = array(); $daftar_pelanggan->Stamp->EditAttrs = array();
		if ($daftar_pelanggan->RowType == EW_ROWTYPE_VIEW) { // View row

			// ID
			$daftar_pelanggan->ID->ViewValue = $daftar_pelanggan->ID->CurrentValue;
			$daftar_pelanggan->ID->CssStyle = "";
			$daftar_pelanggan->ID->CssClass = "";
			$daftar_pelanggan->ID->ViewCustomAttributes = "";

			// Kode
			$daftar_pelanggan->Kode->ViewValue = $daftar_pelanggan->Kode->CurrentValue;
			$daftar_pelanggan->Kode->CssStyle = "";
			$daftar_pelanggan->Kode->CssClass = "";
			$daftar_pelanggan->Kode->ViewCustomAttributes = "";

			// NamaPenyewa
			$daftar_pelanggan->NamaPenyewa->ViewValue = $daftar_pelanggan->NamaPenyewa->CurrentValue;
			$daftar_pelanggan->NamaPenyewa->CssStyle = "";
			$daftar_pelanggan->NamaPenyewa->CssClass = "";
			$daftar_pelanggan->NamaPenyewa->ViewCustomAttributes = "";

			// NamaTeam
			$daftar_pelanggan->NamaTeam->ViewValue = $daftar_pelanggan->NamaTeam->CurrentValue;
			$daftar_pelanggan->NamaTeam->CssStyle = "";
			$daftar_pelanggan->NamaTeam->CssClass = "";
			$daftar_pelanggan->NamaTeam->ViewCustomAttributes = "";

			// Alamat
			$daftar_pelanggan->Alamat->ViewValue = $daftar_pelanggan->Alamat->CurrentValue;
			$daftar_pelanggan->Alamat->CssStyle = "";
			$daftar_pelanggan->Alamat->CssClass = "";
			$daftar_pelanggan->Alamat->ViewCustomAttributes = "";

			// Kota
			$daftar_pelanggan->Kota->ViewValue = $daftar_pelanggan->Kota->CurrentValue;
			$daftar_pelanggan->Kota->CssStyle = "";
			$daftar_pelanggan->Kota->CssClass = "";
			$daftar_pelanggan->Kota->ViewCustomAttributes = "";

			// Telepon
			$daftar_pelanggan->Telepon->ViewValue = $daftar_pelanggan->Telepon->CurrentValue;
			$daftar_pelanggan->Telepon->CssStyle = "";
			$daftar_pelanggan->Telepon->CssClass = "";
			$daftar_pelanggan->Telepon->ViewCustomAttributes = "";

			// Fax
			$daftar_pelanggan->Fax->ViewValue = $daftar_pelanggan->Fax->CurrentValue;
			$daftar_pelanggan->Fax->CssStyle = "";
			$daftar_pelanggan->Fax->CssClass = "";
			$daftar_pelanggan->Fax->ViewCustomAttributes = "";

			// HP
			$daftar_pelanggan->HP->ViewValue = $daftar_pelanggan->HP->CurrentValue;
			$daftar_pelanggan->HP->CssStyle = "";
			$daftar_pelanggan->HP->CssClass = "";
			$daftar_pelanggan->HP->ViewCustomAttributes = "";

			// Email
			$daftar_pelanggan->zEmail->ViewValue = $daftar_pelanggan->zEmail->CurrentValue;
			$daftar_pelanggan->zEmail->CssStyle = "";
			$daftar_pelanggan->zEmail->CssClass = "";
			$daftar_pelanggan->zEmail->ViewCustomAttributes = "";

			// Website
			$daftar_pelanggan->Website->ViewValue = $daftar_pelanggan->Website->CurrentValue;
			$daftar_pelanggan->Website->CssStyle = "";
			$daftar_pelanggan->Website->CssClass = "";
			$daftar_pelanggan->Website->ViewCustomAttributes = "";

			// Main
			$daftar_pelanggan->Main->ViewValue = $daftar_pelanggan->Main->CurrentValue;
			$daftar_pelanggan->Main->CssStyle = "";
			$daftar_pelanggan->Main->CssClass = "";
			$daftar_pelanggan->Main->ViewCustomAttributes = "";

			// Waktu
			$daftar_pelanggan->Waktu->ViewValue = $daftar_pelanggan->Waktu->CurrentValue;
			$daftar_pelanggan->Waktu->ViewValue = ew_FormatDateTime($daftar_pelanggan->Waktu->ViewValue, 5);
			$daftar_pelanggan->Waktu->CssStyle = "";
			$daftar_pelanggan->Waktu->CssClass = "";
			$daftar_pelanggan->Waktu->ViewCustomAttributes = "";

			// Stamp
			$daftar_pelanggan->Stamp->ViewValue = $daftar_pelanggan->Stamp->CurrentValue;
			$daftar_pelanggan->Stamp->ViewValue = ew_FormatDateTime($daftar_pelanggan->Stamp->ViewValue, 5);
			$daftar_pelanggan->Stamp->CssStyle = "";
			$daftar_pelanggan->Stamp->CssClass = "";
			$daftar_pelanggan->Stamp->ViewCustomAttributes = "";

			// ID
			$daftar_pelanggan->ID->HrefValue = "";
			$daftar_pelanggan->ID->TooltipValue = "";

			// Kode
			$daftar_pelanggan->Kode->HrefValue = "";
			$daftar_pelanggan->Kode->TooltipValue = "";

			// NamaPenyewa
			$daftar_pelanggan->NamaPenyewa->HrefValue = "";
			$daftar_pelanggan->NamaPenyewa->TooltipValue = "";

			// NamaTeam
			$daftar_pelanggan->NamaTeam->HrefValue = "";
			$daftar_pelanggan->NamaTeam->TooltipValue = "";

			// Alamat
			$daftar_pelanggan->Alamat->HrefValue = "";
			$daftar_pelanggan->Alamat->TooltipValue = "";

			// Kota
			$daftar_pelanggan->Kota->HrefValue = "";
			$daftar_pelanggan->Kota->TooltipValue = "";

			// Telepon
			$daftar_pelanggan->Telepon->HrefValue = "";
			$daftar_pelanggan->Telepon->TooltipValue = "";

			// Fax
			$daftar_pelanggan->Fax->HrefValue = "";
			$daftar_pelanggan->Fax->TooltipValue = "";

			// HP
			$daftar_pelanggan->HP->HrefValue = "";
			$daftar_pelanggan->HP->TooltipValue = "";

			// Email
			$daftar_pelanggan->zEmail->HrefValue = "";
			$daftar_pelanggan->zEmail->TooltipValue = "";

			// Website
			$daftar_pelanggan->Website->HrefValue = "";
			$daftar_pelanggan->Website->TooltipValue = "";

			// Main
			$daftar_pelanggan->Main->HrefValue = "";
			$daftar_pelanggan->Main->TooltipValue = "";

			// Waktu
			$daftar_pelanggan->Waktu->HrefValue = "";
			$daftar_pelanggan->Waktu->TooltipValue = "";

			// Stamp
			$daftar_pelanggan->Stamp->HrefValue = "";
			$daftar_pelanggan->Stamp->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($daftar_pelanggan->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$daftar_pelanggan->Row_Rendered();
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

<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "persewaan_lapangan_2D_masterinfo.php" ?>
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
$persewaan_lapangan_2D_master_view = new cpersewaan_lapangan_2D_master_view();
$Page =& $persewaan_lapangan_2D_master_view;

// Page init
$persewaan_lapangan_2D_master_view->Page_Init();

// Page main
$persewaan_lapangan_2D_master_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($persewaan_lapangan_2D_master->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var persewaan_lapangan_2D_master_view = new ew_Page("persewaan_lapangan_2D_master_view");

// page properties
persewaan_lapangan_2D_master_view.PageID = "view"; // page ID
persewaan_lapangan_2D_master_view.FormID = "fpersewaan_lapangan_2D_masterview"; // form ID
var EW_PAGE_ID = persewaan_lapangan_2D_master_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
persewaan_lapangan_2D_master_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
persewaan_lapangan_2D_master_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
persewaan_lapangan_2D_master_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $persewaan_lapangan_2D_master->TableCaption() ?>
<br><br>
<?php if ($persewaan_lapangan_2D_master->Export == "") { ?>
<a href="<?php echo $persewaan_lapangan_2D_master_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $persewaan_lapangan_2D_master_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $persewaan_lapangan_2D_master_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $persewaan_lapangan_2D_master_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$persewaan_lapangan_2D_master_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($persewaan_lapangan_2D_master->ID->Visible) { // ID ?>
	<tr<?php echo $persewaan_lapangan_2D_master->ID->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->ID->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->ID->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->ID->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->ID->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->No->Visible) { // No ?>
	<tr<?php echo $persewaan_lapangan_2D_master->No->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->No->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->No->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->No->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->No->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->No_Faktur->Visible) { // No Faktur ?>
	<tr<?php echo $persewaan_lapangan_2D_master->No_Faktur->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->No_Faktur->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->No_Faktur->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->No_Faktur->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->No_Faktur->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Faktur->Visible) { // Faktur ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Faktur->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Faktur->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Faktur->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Faktur->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Faktur->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Tgl->Visible) { // Tgl ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Tgl->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Tgl->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Tgl->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Tgl->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Tgl->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Kode->Visible) { // Kode ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Kode->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Kode->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Kode->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Kode->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Kode->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Nama->Visible) { // Nama ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Nama->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Nama->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Nama->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Nama->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Nama->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Alamat->Visible) { // Alamat ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Alamat->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Alamat->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Alamat->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Alamat->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Alamat->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Kota->Visible) { // Kota ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Kota->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Kota->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Kota->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Kota->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Kota->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Telepon->Visible) { // Telepon ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Telepon->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Telepon->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Telepon->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Telepon->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Telepon->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Main->Visible) { // Main ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Main->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Main->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Main->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Main->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Main->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Total->Visible) { // Total ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Total->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Total->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Total->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Total->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Total->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Bayar->Visible) { // Bayar ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Bayar->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Bayar->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Bayar->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Bayar->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Bayar->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Sisa->Visible) { // Sisa ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Sisa->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Sisa->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Sisa->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Sisa->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Sisa->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Sub_Total->Visible) { // Sub Total ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Sub_Total->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Sub_Total->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Sub_Total->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Sub_Total->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Sub_Total->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Diskon->Visible) { // Diskon ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Diskon->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Diskon->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Diskon->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Diskon->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Diskon->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Potongan->Visible) { // Potongan ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Potongan->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Potongan->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Potongan->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Potongan->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Potongan->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Grand_Total->Visible) { // Grand Total ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Grand_Total->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Grand_Total->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Grand_Total->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Grand_Total->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Grand_Total->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Kode_Kasir->Visible) { // Kode Kasir ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Kode_Kasir->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Kode_Kasir->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Kode_Kasir->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Kode_Kasir->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Kode_Kasir->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Nama_Kasir->Visible) { // Nama Kasir ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Nama_Kasir->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Nama_Kasir->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Nama_Kasir->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Nama_Kasir->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Nama_Kasir->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Waktu->Visible) { // Waktu ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Waktu->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Waktu->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Waktu->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Waktu->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Waktu->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_master->Stamp->Visible) { // Stamp ?>
	<tr<?php echo $persewaan_lapangan_2D_master->Stamp->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_master->Stamp->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_master->Stamp->CellAttributes() ?>>
<div<?php echo $persewaan_lapangan_2D_master->Stamp->ViewAttributes() ?>><?php echo $persewaan_lapangan_2D_master->Stamp->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($persewaan_lapangan_2D_master->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$persewaan_lapangan_2D_master_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cpersewaan_lapangan_2D_master_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'persewaan lapangan - master';

	// Page object name
	var $PageObjName = 'persewaan_lapangan_2D_master_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $persewaan_lapangan_2D_master;
		if ($persewaan_lapangan_2D_master->UseTokenInUrl) $PageUrl .= "t=" . $persewaan_lapangan_2D_master->TableVar . "&"; // Add page token
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
		global $objForm, $persewaan_lapangan_2D_master;
		if ($persewaan_lapangan_2D_master->UseTokenInUrl) {
			if ($objForm)
				return ($persewaan_lapangan_2D_master->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($persewaan_lapangan_2D_master->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cpersewaan_lapangan_2D_master_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (persewaan_lapangan_2D_master)
		$GLOBALS["persewaan_lapangan_2D_master"] = new cpersewaan_lapangan_2D_master();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'persewaan lapangan - master', TRUE);

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
		global $persewaan_lapangan_2D_master;

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
		global $Language, $persewaan_lapangan_2D_master;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ID"] <> "") {
				$persewaan_lapangan_2D_master->ID->setQueryStringValue($_GET["ID"]);
				$this->arRecKey["ID"] = $persewaan_lapangan_2D_master->ID->QueryStringValue;
			} else {
				$sReturnUrl = "persewaan_lapangan_2D_masterlist.php"; // Return to list
			}

			// Get action
			$persewaan_lapangan_2D_master->CurrentAction = "I"; // Display form
			switch ($persewaan_lapangan_2D_master->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "persewaan_lapangan_2D_masterlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "persewaan_lapangan_2D_masterlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$persewaan_lapangan_2D_master->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $persewaan_lapangan_2D_master;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$persewaan_lapangan_2D_master->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$persewaan_lapangan_2D_master->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $persewaan_lapangan_2D_master->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$persewaan_lapangan_2D_master->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$persewaan_lapangan_2D_master->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$persewaan_lapangan_2D_master->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $persewaan_lapangan_2D_master;
		$sFilter = $persewaan_lapangan_2D_master->KeyFilter();

		// Call Row Selecting event
		$persewaan_lapangan_2D_master->Row_Selecting($sFilter);

		// Load SQL based on filter
		$persewaan_lapangan_2D_master->CurrentFilter = $sFilter;
		$sSql = $persewaan_lapangan_2D_master->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$persewaan_lapangan_2D_master->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $persewaan_lapangan_2D_master;
		$persewaan_lapangan_2D_master->ID->setDbValue($rs->fields('ID'));
		$persewaan_lapangan_2D_master->No->setDbValue($rs->fields('No'));
		$persewaan_lapangan_2D_master->No_Faktur->setDbValue($rs->fields('No Faktur'));
		$persewaan_lapangan_2D_master->Faktur->setDbValue($rs->fields('Faktur'));
		$persewaan_lapangan_2D_master->Tgl->setDbValue($rs->fields('Tgl'));
		$persewaan_lapangan_2D_master->Kode->setDbValue($rs->fields('Kode'));
		$persewaan_lapangan_2D_master->Nama->setDbValue($rs->fields('Nama'));
		$persewaan_lapangan_2D_master->Alamat->setDbValue($rs->fields('Alamat'));
		$persewaan_lapangan_2D_master->Kota->setDbValue($rs->fields('Kota'));
		$persewaan_lapangan_2D_master->Telepon->setDbValue($rs->fields('Telepon'));
		$persewaan_lapangan_2D_master->Main->setDbValue($rs->fields('Main'));
		$persewaan_lapangan_2D_master->Total->setDbValue($rs->fields('Total'));
		$persewaan_lapangan_2D_master->Bayar->setDbValue($rs->fields('Bayar'));
		$persewaan_lapangan_2D_master->Sisa->setDbValue($rs->fields('Sisa'));
		$persewaan_lapangan_2D_master->Sub_Total->setDbValue($rs->fields('Sub Total'));
		$persewaan_lapangan_2D_master->Diskon->setDbValue($rs->fields('Diskon'));
		$persewaan_lapangan_2D_master->Potongan->setDbValue($rs->fields('Potongan'));
		$persewaan_lapangan_2D_master->Grand_Total->setDbValue($rs->fields('Grand Total'));
		$persewaan_lapangan_2D_master->Kode_Kasir->setDbValue($rs->fields('Kode Kasir'));
		$persewaan_lapangan_2D_master->Nama_Kasir->setDbValue($rs->fields('Nama Kasir'));
		$persewaan_lapangan_2D_master->Waktu->setDbValue($rs->fields('Waktu'));
		$persewaan_lapangan_2D_master->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $persewaan_lapangan_2D_master;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "ID=" . urlencode($persewaan_lapangan_2D_master->ID->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "ID=" . urlencode($persewaan_lapangan_2D_master->ID->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "ID=" . urlencode($persewaan_lapangan_2D_master->ID->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "ID=" . urlencode($persewaan_lapangan_2D_master->ID->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "ID=" . urlencode($persewaan_lapangan_2D_master->ID->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "ID=" . urlencode($persewaan_lapangan_2D_master->ID->CurrentValue);
		$this->AddUrl = $persewaan_lapangan_2D_master->AddUrl();
		$this->EditUrl = $persewaan_lapangan_2D_master->EditUrl();
		$this->CopyUrl = $persewaan_lapangan_2D_master->CopyUrl();
		$this->DeleteUrl = $persewaan_lapangan_2D_master->DeleteUrl();
		$this->ListUrl = $persewaan_lapangan_2D_master->ListUrl();

		// Call Row_Rendering event
		$persewaan_lapangan_2D_master->Row_Rendering();

		// Common render codes for all row types
		// ID

		$persewaan_lapangan_2D_master->ID->CellCssStyle = ""; $persewaan_lapangan_2D_master->ID->CellCssClass = "";
		$persewaan_lapangan_2D_master->ID->CellAttrs = array(); $persewaan_lapangan_2D_master->ID->ViewAttrs = array(); $persewaan_lapangan_2D_master->ID->EditAttrs = array();

		// No
		$persewaan_lapangan_2D_master->No->CellCssStyle = ""; $persewaan_lapangan_2D_master->No->CellCssClass = "";
		$persewaan_lapangan_2D_master->No->CellAttrs = array(); $persewaan_lapangan_2D_master->No->ViewAttrs = array(); $persewaan_lapangan_2D_master->No->EditAttrs = array();

		// No Faktur
		$persewaan_lapangan_2D_master->No_Faktur->CellCssStyle = ""; $persewaan_lapangan_2D_master->No_Faktur->CellCssClass = "";
		$persewaan_lapangan_2D_master->No_Faktur->CellAttrs = array(); $persewaan_lapangan_2D_master->No_Faktur->ViewAttrs = array(); $persewaan_lapangan_2D_master->No_Faktur->EditAttrs = array();

		// Faktur
		$persewaan_lapangan_2D_master->Faktur->CellCssStyle = ""; $persewaan_lapangan_2D_master->Faktur->CellCssClass = "";
		$persewaan_lapangan_2D_master->Faktur->CellAttrs = array(); $persewaan_lapangan_2D_master->Faktur->ViewAttrs = array(); $persewaan_lapangan_2D_master->Faktur->EditAttrs = array();

		// Tgl
		$persewaan_lapangan_2D_master->Tgl->CellCssStyle = ""; $persewaan_lapangan_2D_master->Tgl->CellCssClass = "";
		$persewaan_lapangan_2D_master->Tgl->CellAttrs = array(); $persewaan_lapangan_2D_master->Tgl->ViewAttrs = array(); $persewaan_lapangan_2D_master->Tgl->EditAttrs = array();

		// Kode
		$persewaan_lapangan_2D_master->Kode->CellCssStyle = ""; $persewaan_lapangan_2D_master->Kode->CellCssClass = "";
		$persewaan_lapangan_2D_master->Kode->CellAttrs = array(); $persewaan_lapangan_2D_master->Kode->ViewAttrs = array(); $persewaan_lapangan_2D_master->Kode->EditAttrs = array();

		// Nama
		$persewaan_lapangan_2D_master->Nama->CellCssStyle = ""; $persewaan_lapangan_2D_master->Nama->CellCssClass = "";
		$persewaan_lapangan_2D_master->Nama->CellAttrs = array(); $persewaan_lapangan_2D_master->Nama->ViewAttrs = array(); $persewaan_lapangan_2D_master->Nama->EditAttrs = array();

		// Alamat
		$persewaan_lapangan_2D_master->Alamat->CellCssStyle = ""; $persewaan_lapangan_2D_master->Alamat->CellCssClass = "";
		$persewaan_lapangan_2D_master->Alamat->CellAttrs = array(); $persewaan_lapangan_2D_master->Alamat->ViewAttrs = array(); $persewaan_lapangan_2D_master->Alamat->EditAttrs = array();

		// Kota
		$persewaan_lapangan_2D_master->Kota->CellCssStyle = ""; $persewaan_lapangan_2D_master->Kota->CellCssClass = "";
		$persewaan_lapangan_2D_master->Kota->CellAttrs = array(); $persewaan_lapangan_2D_master->Kota->ViewAttrs = array(); $persewaan_lapangan_2D_master->Kota->EditAttrs = array();

		// Telepon
		$persewaan_lapangan_2D_master->Telepon->CellCssStyle = ""; $persewaan_lapangan_2D_master->Telepon->CellCssClass = "";
		$persewaan_lapangan_2D_master->Telepon->CellAttrs = array(); $persewaan_lapangan_2D_master->Telepon->ViewAttrs = array(); $persewaan_lapangan_2D_master->Telepon->EditAttrs = array();

		// Main
		$persewaan_lapangan_2D_master->Main->CellCssStyle = ""; $persewaan_lapangan_2D_master->Main->CellCssClass = "";
		$persewaan_lapangan_2D_master->Main->CellAttrs = array(); $persewaan_lapangan_2D_master->Main->ViewAttrs = array(); $persewaan_lapangan_2D_master->Main->EditAttrs = array();

		// Total
		$persewaan_lapangan_2D_master->Total->CellCssStyle = ""; $persewaan_lapangan_2D_master->Total->CellCssClass = "";
		$persewaan_lapangan_2D_master->Total->CellAttrs = array(); $persewaan_lapangan_2D_master->Total->ViewAttrs = array(); $persewaan_lapangan_2D_master->Total->EditAttrs = array();

		// Bayar
		$persewaan_lapangan_2D_master->Bayar->CellCssStyle = ""; $persewaan_lapangan_2D_master->Bayar->CellCssClass = "";
		$persewaan_lapangan_2D_master->Bayar->CellAttrs = array(); $persewaan_lapangan_2D_master->Bayar->ViewAttrs = array(); $persewaan_lapangan_2D_master->Bayar->EditAttrs = array();

		// Sisa
		$persewaan_lapangan_2D_master->Sisa->CellCssStyle = ""; $persewaan_lapangan_2D_master->Sisa->CellCssClass = "";
		$persewaan_lapangan_2D_master->Sisa->CellAttrs = array(); $persewaan_lapangan_2D_master->Sisa->ViewAttrs = array(); $persewaan_lapangan_2D_master->Sisa->EditAttrs = array();

		// Sub Total
		$persewaan_lapangan_2D_master->Sub_Total->CellCssStyle = ""; $persewaan_lapangan_2D_master->Sub_Total->CellCssClass = "";
		$persewaan_lapangan_2D_master->Sub_Total->CellAttrs = array(); $persewaan_lapangan_2D_master->Sub_Total->ViewAttrs = array(); $persewaan_lapangan_2D_master->Sub_Total->EditAttrs = array();

		// Diskon
		$persewaan_lapangan_2D_master->Diskon->CellCssStyle = ""; $persewaan_lapangan_2D_master->Diskon->CellCssClass = "";
		$persewaan_lapangan_2D_master->Diskon->CellAttrs = array(); $persewaan_lapangan_2D_master->Diskon->ViewAttrs = array(); $persewaan_lapangan_2D_master->Diskon->EditAttrs = array();

		// Potongan
		$persewaan_lapangan_2D_master->Potongan->CellCssStyle = ""; $persewaan_lapangan_2D_master->Potongan->CellCssClass = "";
		$persewaan_lapangan_2D_master->Potongan->CellAttrs = array(); $persewaan_lapangan_2D_master->Potongan->ViewAttrs = array(); $persewaan_lapangan_2D_master->Potongan->EditAttrs = array();

		// Grand Total
		$persewaan_lapangan_2D_master->Grand_Total->CellCssStyle = ""; $persewaan_lapangan_2D_master->Grand_Total->CellCssClass = "";
		$persewaan_lapangan_2D_master->Grand_Total->CellAttrs = array(); $persewaan_lapangan_2D_master->Grand_Total->ViewAttrs = array(); $persewaan_lapangan_2D_master->Grand_Total->EditAttrs = array();

		// Kode Kasir
		$persewaan_lapangan_2D_master->Kode_Kasir->CellCssStyle = ""; $persewaan_lapangan_2D_master->Kode_Kasir->CellCssClass = "";
		$persewaan_lapangan_2D_master->Kode_Kasir->CellAttrs = array(); $persewaan_lapangan_2D_master->Kode_Kasir->ViewAttrs = array(); $persewaan_lapangan_2D_master->Kode_Kasir->EditAttrs = array();

		// Nama Kasir
		$persewaan_lapangan_2D_master->Nama_Kasir->CellCssStyle = ""; $persewaan_lapangan_2D_master->Nama_Kasir->CellCssClass = "";
		$persewaan_lapangan_2D_master->Nama_Kasir->CellAttrs = array(); $persewaan_lapangan_2D_master->Nama_Kasir->ViewAttrs = array(); $persewaan_lapangan_2D_master->Nama_Kasir->EditAttrs = array();

		// Waktu
		$persewaan_lapangan_2D_master->Waktu->CellCssStyle = ""; $persewaan_lapangan_2D_master->Waktu->CellCssClass = "";
		$persewaan_lapangan_2D_master->Waktu->CellAttrs = array(); $persewaan_lapangan_2D_master->Waktu->ViewAttrs = array(); $persewaan_lapangan_2D_master->Waktu->EditAttrs = array();

		// Stamp
		$persewaan_lapangan_2D_master->Stamp->CellCssStyle = ""; $persewaan_lapangan_2D_master->Stamp->CellCssClass = "";
		$persewaan_lapangan_2D_master->Stamp->CellAttrs = array(); $persewaan_lapangan_2D_master->Stamp->ViewAttrs = array(); $persewaan_lapangan_2D_master->Stamp->EditAttrs = array();
		if ($persewaan_lapangan_2D_master->RowType == EW_ROWTYPE_VIEW) { // View row

			// ID
			$persewaan_lapangan_2D_master->ID->ViewValue = $persewaan_lapangan_2D_master->ID->CurrentValue;
			$persewaan_lapangan_2D_master->ID->CssStyle = "";
			$persewaan_lapangan_2D_master->ID->CssClass = "";
			$persewaan_lapangan_2D_master->ID->ViewCustomAttributes = "";

			// No
			$persewaan_lapangan_2D_master->No->ViewValue = $persewaan_lapangan_2D_master->No->CurrentValue;
			$persewaan_lapangan_2D_master->No->CssStyle = "";
			$persewaan_lapangan_2D_master->No->CssClass = "";
			$persewaan_lapangan_2D_master->No->ViewCustomAttributes = "";

			// No Faktur
			$persewaan_lapangan_2D_master->No_Faktur->ViewValue = $persewaan_lapangan_2D_master->No_Faktur->CurrentValue;
			$persewaan_lapangan_2D_master->No_Faktur->CssStyle = "";
			$persewaan_lapangan_2D_master->No_Faktur->CssClass = "";
			$persewaan_lapangan_2D_master->No_Faktur->ViewCustomAttributes = "";

			// Faktur
			$persewaan_lapangan_2D_master->Faktur->ViewValue = $persewaan_lapangan_2D_master->Faktur->CurrentValue;
			$persewaan_lapangan_2D_master->Faktur->CssStyle = "";
			$persewaan_lapangan_2D_master->Faktur->CssClass = "";
			$persewaan_lapangan_2D_master->Faktur->ViewCustomAttributes = "";

			// Tgl
			$persewaan_lapangan_2D_master->Tgl->ViewValue = $persewaan_lapangan_2D_master->Tgl->CurrentValue;
			$persewaan_lapangan_2D_master->Tgl->ViewValue = ew_FormatDateTime($persewaan_lapangan_2D_master->Tgl->ViewValue, 5);
			$persewaan_lapangan_2D_master->Tgl->CssStyle = "";
			$persewaan_lapangan_2D_master->Tgl->CssClass = "";
			$persewaan_lapangan_2D_master->Tgl->ViewCustomAttributes = "";

			// Kode
			$persewaan_lapangan_2D_master->Kode->ViewValue = $persewaan_lapangan_2D_master->Kode->CurrentValue;
			$persewaan_lapangan_2D_master->Kode->CssStyle = "";
			$persewaan_lapangan_2D_master->Kode->CssClass = "";
			$persewaan_lapangan_2D_master->Kode->ViewCustomAttributes = "";

			// Nama
			$persewaan_lapangan_2D_master->Nama->ViewValue = $persewaan_lapangan_2D_master->Nama->CurrentValue;
			$persewaan_lapangan_2D_master->Nama->CssStyle = "";
			$persewaan_lapangan_2D_master->Nama->CssClass = "";
			$persewaan_lapangan_2D_master->Nama->ViewCustomAttributes = "";

			// Alamat
			$persewaan_lapangan_2D_master->Alamat->ViewValue = $persewaan_lapangan_2D_master->Alamat->CurrentValue;
			$persewaan_lapangan_2D_master->Alamat->CssStyle = "";
			$persewaan_lapangan_2D_master->Alamat->CssClass = "";
			$persewaan_lapangan_2D_master->Alamat->ViewCustomAttributes = "";

			// Kota
			$persewaan_lapangan_2D_master->Kota->ViewValue = $persewaan_lapangan_2D_master->Kota->CurrentValue;
			$persewaan_lapangan_2D_master->Kota->CssStyle = "";
			$persewaan_lapangan_2D_master->Kota->CssClass = "";
			$persewaan_lapangan_2D_master->Kota->ViewCustomAttributes = "";

			// Telepon
			$persewaan_lapangan_2D_master->Telepon->ViewValue = $persewaan_lapangan_2D_master->Telepon->CurrentValue;
			$persewaan_lapangan_2D_master->Telepon->CssStyle = "";
			$persewaan_lapangan_2D_master->Telepon->CssClass = "";
			$persewaan_lapangan_2D_master->Telepon->ViewCustomAttributes = "";

			// Main
			$persewaan_lapangan_2D_master->Main->ViewValue = $persewaan_lapangan_2D_master->Main->CurrentValue;
			$persewaan_lapangan_2D_master->Main->CssStyle = "";
			$persewaan_lapangan_2D_master->Main->CssClass = "";
			$persewaan_lapangan_2D_master->Main->ViewCustomAttributes = "";

			// Total
			$persewaan_lapangan_2D_master->Total->ViewValue = $persewaan_lapangan_2D_master->Total->CurrentValue;
			$persewaan_lapangan_2D_master->Total->CssStyle = "";
			$persewaan_lapangan_2D_master->Total->CssClass = "";
			$persewaan_lapangan_2D_master->Total->ViewCustomAttributes = "";

			// Bayar
			$persewaan_lapangan_2D_master->Bayar->ViewValue = $persewaan_lapangan_2D_master->Bayar->CurrentValue;
			$persewaan_lapangan_2D_master->Bayar->CssStyle = "";
			$persewaan_lapangan_2D_master->Bayar->CssClass = "";
			$persewaan_lapangan_2D_master->Bayar->ViewCustomAttributes = "";

			// Sisa
			$persewaan_lapangan_2D_master->Sisa->ViewValue = $persewaan_lapangan_2D_master->Sisa->CurrentValue;
			$persewaan_lapangan_2D_master->Sisa->CssStyle = "";
			$persewaan_lapangan_2D_master->Sisa->CssClass = "";
			$persewaan_lapangan_2D_master->Sisa->ViewCustomAttributes = "";

			// Sub Total
			$persewaan_lapangan_2D_master->Sub_Total->ViewValue = $persewaan_lapangan_2D_master->Sub_Total->CurrentValue;
			$persewaan_lapangan_2D_master->Sub_Total->CssStyle = "";
			$persewaan_lapangan_2D_master->Sub_Total->CssClass = "";
			$persewaan_lapangan_2D_master->Sub_Total->ViewCustomAttributes = "";

			// Diskon
			$persewaan_lapangan_2D_master->Diskon->ViewValue = $persewaan_lapangan_2D_master->Diskon->CurrentValue;
			$persewaan_lapangan_2D_master->Diskon->CssStyle = "";
			$persewaan_lapangan_2D_master->Diskon->CssClass = "";
			$persewaan_lapangan_2D_master->Diskon->ViewCustomAttributes = "";

			// Potongan
			$persewaan_lapangan_2D_master->Potongan->ViewValue = $persewaan_lapangan_2D_master->Potongan->CurrentValue;
			$persewaan_lapangan_2D_master->Potongan->CssStyle = "";
			$persewaan_lapangan_2D_master->Potongan->CssClass = "";
			$persewaan_lapangan_2D_master->Potongan->ViewCustomAttributes = "";

			// Grand Total
			$persewaan_lapangan_2D_master->Grand_Total->ViewValue = $persewaan_lapangan_2D_master->Grand_Total->CurrentValue;
			$persewaan_lapangan_2D_master->Grand_Total->CssStyle = "";
			$persewaan_lapangan_2D_master->Grand_Total->CssClass = "";
			$persewaan_lapangan_2D_master->Grand_Total->ViewCustomAttributes = "";

			// Kode Kasir
			$persewaan_lapangan_2D_master->Kode_Kasir->ViewValue = $persewaan_lapangan_2D_master->Kode_Kasir->CurrentValue;
			$persewaan_lapangan_2D_master->Kode_Kasir->CssStyle = "";
			$persewaan_lapangan_2D_master->Kode_Kasir->CssClass = "";
			$persewaan_lapangan_2D_master->Kode_Kasir->ViewCustomAttributes = "";

			// Nama Kasir
			$persewaan_lapangan_2D_master->Nama_Kasir->ViewValue = $persewaan_lapangan_2D_master->Nama_Kasir->CurrentValue;
			$persewaan_lapangan_2D_master->Nama_Kasir->CssStyle = "";
			$persewaan_lapangan_2D_master->Nama_Kasir->CssClass = "";
			$persewaan_lapangan_2D_master->Nama_Kasir->ViewCustomAttributes = "";

			// Waktu
			$persewaan_lapangan_2D_master->Waktu->ViewValue = $persewaan_lapangan_2D_master->Waktu->CurrentValue;
			$persewaan_lapangan_2D_master->Waktu->ViewValue = ew_FormatDateTime($persewaan_lapangan_2D_master->Waktu->ViewValue, 5);
			$persewaan_lapangan_2D_master->Waktu->CssStyle = "";
			$persewaan_lapangan_2D_master->Waktu->CssClass = "";
			$persewaan_lapangan_2D_master->Waktu->ViewCustomAttributes = "";

			// Stamp
			$persewaan_lapangan_2D_master->Stamp->ViewValue = $persewaan_lapangan_2D_master->Stamp->CurrentValue;
			$persewaan_lapangan_2D_master->Stamp->ViewValue = ew_FormatDateTime($persewaan_lapangan_2D_master->Stamp->ViewValue, 5);
			$persewaan_lapangan_2D_master->Stamp->CssStyle = "";
			$persewaan_lapangan_2D_master->Stamp->CssClass = "";
			$persewaan_lapangan_2D_master->Stamp->ViewCustomAttributes = "";

			// ID
			$persewaan_lapangan_2D_master->ID->HrefValue = "";
			$persewaan_lapangan_2D_master->ID->TooltipValue = "";

			// No
			$persewaan_lapangan_2D_master->No->HrefValue = "";
			$persewaan_lapangan_2D_master->No->TooltipValue = "";

			// No Faktur
			$persewaan_lapangan_2D_master->No_Faktur->HrefValue = "";
			$persewaan_lapangan_2D_master->No_Faktur->TooltipValue = "";

			// Faktur
			$persewaan_lapangan_2D_master->Faktur->HrefValue = "";
			$persewaan_lapangan_2D_master->Faktur->TooltipValue = "";

			// Tgl
			$persewaan_lapangan_2D_master->Tgl->HrefValue = "";
			$persewaan_lapangan_2D_master->Tgl->TooltipValue = "";

			// Kode
			$persewaan_lapangan_2D_master->Kode->HrefValue = "";
			$persewaan_lapangan_2D_master->Kode->TooltipValue = "";

			// Nama
			$persewaan_lapangan_2D_master->Nama->HrefValue = "";
			$persewaan_lapangan_2D_master->Nama->TooltipValue = "";

			// Alamat
			$persewaan_lapangan_2D_master->Alamat->HrefValue = "";
			$persewaan_lapangan_2D_master->Alamat->TooltipValue = "";

			// Kota
			$persewaan_lapangan_2D_master->Kota->HrefValue = "";
			$persewaan_lapangan_2D_master->Kota->TooltipValue = "";

			// Telepon
			$persewaan_lapangan_2D_master->Telepon->HrefValue = "";
			$persewaan_lapangan_2D_master->Telepon->TooltipValue = "";

			// Main
			$persewaan_lapangan_2D_master->Main->HrefValue = "";
			$persewaan_lapangan_2D_master->Main->TooltipValue = "";

			// Total
			$persewaan_lapangan_2D_master->Total->HrefValue = "";
			$persewaan_lapangan_2D_master->Total->TooltipValue = "";

			// Bayar
			$persewaan_lapangan_2D_master->Bayar->HrefValue = "";
			$persewaan_lapangan_2D_master->Bayar->TooltipValue = "";

			// Sisa
			$persewaan_lapangan_2D_master->Sisa->HrefValue = "";
			$persewaan_lapangan_2D_master->Sisa->TooltipValue = "";

			// Sub Total
			$persewaan_lapangan_2D_master->Sub_Total->HrefValue = "";
			$persewaan_lapangan_2D_master->Sub_Total->TooltipValue = "";

			// Diskon
			$persewaan_lapangan_2D_master->Diskon->HrefValue = "";
			$persewaan_lapangan_2D_master->Diskon->TooltipValue = "";

			// Potongan
			$persewaan_lapangan_2D_master->Potongan->HrefValue = "";
			$persewaan_lapangan_2D_master->Potongan->TooltipValue = "";

			// Grand Total
			$persewaan_lapangan_2D_master->Grand_Total->HrefValue = "";
			$persewaan_lapangan_2D_master->Grand_Total->TooltipValue = "";

			// Kode Kasir
			$persewaan_lapangan_2D_master->Kode_Kasir->HrefValue = "";
			$persewaan_lapangan_2D_master->Kode_Kasir->TooltipValue = "";

			// Nama Kasir
			$persewaan_lapangan_2D_master->Nama_Kasir->HrefValue = "";
			$persewaan_lapangan_2D_master->Nama_Kasir->TooltipValue = "";

			// Waktu
			$persewaan_lapangan_2D_master->Waktu->HrefValue = "";
			$persewaan_lapangan_2D_master->Waktu->TooltipValue = "";

			// Stamp
			$persewaan_lapangan_2D_master->Stamp->HrefValue = "";
			$persewaan_lapangan_2D_master->Stamp->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($persewaan_lapangan_2D_master->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$persewaan_lapangan_2D_master->Row_Rendered();
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

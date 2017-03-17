<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$default = NULL; // Initialize page object first

class cdefault {

	// Page ID
	var $PageID = 'default';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Page object name
	var $PageObjName = 'default';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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

		// User table object (_2padmin)
		if (!isset($GLOBALS["_2padmin"])) $GLOBALS["_2padmin"] = new c_2padmin;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'default', TRUE);

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

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadUserLevel(); // Load User Level
		if ($Security->AllowList(CurrentProjectID() . 'persewaan lapangan - master'))
		$this->Page_Terminate("persewaan_lapangan_2D_masterlist.php"); // Exit and go to default page
		if ($Security->AllowList(CurrentProjectID() . '2padmin'))
			$this->Page_Terminate("_2padminlist.php");
		if ($Security->AllowList(CurrentProjectID() . '2pbackup'))
			$this->Page_Terminate("_2pbackuplist.php");
		if ($Security->AllowList(CurrentProjectID() . 'daftar lapangan'))
			$this->Page_Terminate("daftar_lapanganlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'daftar pelanggan'))
			$this->Page_Terminate("daftar_pelangganlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'lic'))
			$this->Page_Terminate("liclist.php");
		if ($Security->AllowList(CurrentProjectID() . 'persewaan lapangan - detail'))
			$this->Page_Terminate("persewaan_lapangan_2D_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'profile'))
			$this->Page_Terminate("profilelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'daftar produk'))
			$this->Page_Terminate("daftar_produklist.php");
		if ($Security->AllowList(CurrentProjectID() . 'daftar satuan'))
			$this->Page_Terminate("daftar_satuanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'daftar suplier'))
			$this->Page_Terminate("daftar_suplierlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pembelian - detail'))
			$this->Page_Terminate("pembelian_2D_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pembelian - master'))
			$this->Page_Terminate("pembelian_2D_masterlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'penjualan - detail'))
			$this->Page_Terminate("penjualan_2D_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'penjualan - master'))
			$this->Page_Terminate("penjualan_2D_masterlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Booking'))
			$this->Page_Terminate("Bookinglist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Rekapitulasi Persewaan'))
			$this->Page_Terminate("Rekapitulasi_Persewaanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Sisa Stok'))
			$this->Page_Terminate("Sisa_Stoklist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Sisa Bayar'))
			$this->Page_Terminate("Sisa_Bayarlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Rekapitulasi Penjualan'))
			$this->Page_Terminate("Rekapitulasi_Penjualanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Rekapitulasi Pembelian'))
			$this->Page_Terminate("Rekapitulasi_Pembelianlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Penjualan Belum Lunas'))
			$this->Page_Terminate("Penjualan_Belum_Lunaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Pembelian Belum Lunas'))
			$this->Page_Terminate("Pembelian_Belum_Lunaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'Laporan Daftar Pelanggan'))
			$this->Page_Terminate("Laporan_Daftar_Pelangganreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'Laporan Daftar Lapangan'))
			$this->Page_Terminate("Laporan_Daftar_Lapanganreport.php");
		if ($Security->AllowList(CurrentProjectID() . 'lapstok'))
			$this->Page_Terminate("lapstoklist.php");
		if ($Security->AllowList(CurrentProjectID() . 'menu'))
			$this->Page_Terminate("_menulist.php");
		if ($Security->AllowList(CurrentProjectID() . 'menusub1'))
			$this->Page_Terminate("menusub1list.php");
		if ($Security->AllowList(CurrentProjectID() . 'menusub2'))
			$this->Page_Terminate("menusub2list.php");
		if ($Security->IsLoggedIn()) {
			$this->setFailureMessage($Language->Phrase("NoPermission") . "<br><br><a href=\"logout.php\">" . $Language->Phrase("BackToLogin") . "</a>");
		} else {
			$this->Page_Terminate("login.php"); // Exit and go to login page
		}
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
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($default)) $default = new cdefault();

// Page init
$default->Page_Init();

// Page main
$default->Page_Main();
?>
<?php include_once "header.php" ?>
<?php
$default->ShowMessage();
?>
<?php include_once "footer.php" ?>
<?php
$default->Page_Terminate();
?>

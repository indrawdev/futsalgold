<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php

// Global variable for table object
$Laporan_Daftar_Lapangan = NULL;

//
// Table class for Laporan Daftar Lapangan
//
class cLaporan_Daftar_Lapangan extends cTableBase {
	var $ID;
	var $Kode;
	var $NamaLapangan;
	var $Ukuran;
	var $Kondisi;
	var $HargaSewa1;
	var $HargaSewa2;
	var $HargaSewa3;
	var $HargaSewa4;
	var $HargaSewa5;
	var $Member;
	var $NonMember;
	var $Waktu;
	var $Stamp;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'Laporan_Daftar_Lapangan';
		$this->TableName = 'Laporan Daftar Lapangan';
		$this->TableType = 'REPORT';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->PrinterFriendlyForPdf = TRUE;
		$this->UserIDAllowSecurity = 0; // User ID Allow

		// ID
		$this->ID = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_ID', 'ID', '`ID`', '`ID`', 3, -1, FALSE, '`ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ID'] = &$this->ID;

		// Kode
		$this->Kode = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_Kode', 'Kode', '`Kode`', '`Kode`', 200, -1, FALSE, '`Kode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode'] = &$this->Kode;

		// NamaLapangan
		$this->NamaLapangan = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_NamaLapangan', 'NamaLapangan', '`NamaLapangan`', '`NamaLapangan`', 200, -1, FALSE, '`NamaLapangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['NamaLapangan'] = &$this->NamaLapangan;

		// Ukuran
		$this->Ukuran = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_Ukuran', 'Ukuran', '`Ukuran`', '`Ukuran`', 200, -1, FALSE, '`Ukuran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Ukuran'] = &$this->Ukuran;

		// Kondisi
		$this->Kondisi = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_Kondisi', 'Kondisi', '`Kondisi`', '`Kondisi`', 200, -1, FALSE, '`Kondisi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kondisi'] = &$this->Kondisi;

		// HargaSewa1
		$this->HargaSewa1 = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_HargaSewa1', 'HargaSewa1', '`HargaSewa1`', '`HargaSewa1`', 3, -1, FALSE, '`HargaSewa1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->HargaSewa1->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['HargaSewa1'] = &$this->HargaSewa1;

		// HargaSewa2
		$this->HargaSewa2 = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_HargaSewa2', 'HargaSewa2', '`HargaSewa2`', '`HargaSewa2`', 3, -1, FALSE, '`HargaSewa2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->HargaSewa2->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['HargaSewa2'] = &$this->HargaSewa2;

		// HargaSewa3
		$this->HargaSewa3 = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_HargaSewa3', 'HargaSewa3', '`HargaSewa3`', '`HargaSewa3`', 3, -1, FALSE, '`HargaSewa3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->HargaSewa3->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['HargaSewa3'] = &$this->HargaSewa3;

		// HargaSewa4
		$this->HargaSewa4 = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_HargaSewa4', 'HargaSewa4', '`HargaSewa4`', '`HargaSewa4`', 3, -1, FALSE, '`HargaSewa4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->HargaSewa4->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['HargaSewa4'] = &$this->HargaSewa4;

		// HargaSewa5
		$this->HargaSewa5 = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_HargaSewa5', 'HargaSewa5', '`HargaSewa5`', '`HargaSewa5`', 3, -1, FALSE, '`HargaSewa5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->HargaSewa5->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['HargaSewa5'] = &$this->HargaSewa5;

		// Member
		$this->Member = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_Member', 'Member', '`Member`', '`Member`', 3, -1, FALSE, '`Member`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Member->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Member'] = &$this->Member;

		// NonMember
		$this->NonMember = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_NonMember', 'NonMember', '`NonMember`', '`NonMember`', 3, -1, FALSE, '`NonMember`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->NonMember->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['NonMember'] = &$this->NonMember;

		// Waktu
		$this->Waktu = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_Waktu', 'Waktu', '`Waktu`', 'DATE_FORMAT(`Waktu`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Waktu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Waktu->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Waktu'] = &$this->Waktu;

		// Stamp
		$this->Stamp = new cField('Laporan_Daftar_Lapangan', 'Laporan Daftar Lapangan', 'x_Stamp', 'Stamp', '`Stamp`', 'DATE_FORMAT(`Stamp`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Stamp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Stamp->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Stamp'] = &$this->Stamp;
	}

	// Report detail level SQL
	function SqlDetailSelect() { // Select
		return "SELECT * FROM `daftar lapangan`";
	}

	function SqlDetailWhere() { // Where
		return "";
	}

	function SqlDetailGroupBy() { // Group By
		return "";
	}

	function SqlDetailHaving() { // Having
		return "";
	}

	function SqlDetailOrderBy() { // Order By
		return "`Kode` ASC";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 8) == 8);
			case "search":
				return (($allow & 8) == 8);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Report detail SQL
	function DetailSQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = "";
		return ew_BuildSelectSql($this->SqlDetailSelect(), $this->SqlDetailWhere(),
			$this->SqlDetailGroupBy(), $this->SqlDetailHaving(),
			$this->SqlDetailOrderBy(), $sFilter, $sSort);
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "Laporan_Daftar_Lapanganreport.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "Laporan_Daftar_Lapanganreport.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("", $this->UrlParm($parm));
		else
			return $this->KeyUrl("", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->ID->CurrentValue)) {
			$sUrl .= "ID=" . urlencode($this->ID->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["ID"]; // ID

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->ID->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

		$this->HargaSewa1->ViewValue = number_format($this->HargaSewa1->ViewValue); 
		$this->HargaSewa2->ViewValue = number_format($this->HargaSewa2->ViewValue); 
		$this->HargaSewa3->ViewValue = number_format($this->HargaSewa3->ViewValue); 
		$this->HargaSewa4->ViewValue = number_format($this->HargaSewa4->ViewValue);
		$this->HargaSewa5->ViewValue = number_format($this->HargaSewa5->ViewValue); 
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$Laporan_Daftar_Lapangan_report = NULL; // Initialize page object first

class cLaporan_Daftar_Lapangan_report extends cLaporan_Daftar_Lapangan {

	// Page ID
	var $PageID = 'report';

	// Project ID
	var $ProjectID = "{FB59CACA-F11C-4CE1-B69A-4810252F4810}";

	// Table name
	var $TableName = 'Laporan Daftar Lapangan';

	// Page object name
	var $PageObjName = 'Laporan_Daftar_Lapangan_report';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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
	var $ExportPdfUrl;

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
		return TRUE;
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

		// Table object (Laporan_Daftar_Lapangan)
		if (!isset($GLOBALS["Laporan_Daftar_Lapangan"])) {
			$GLOBALS["Laporan_Daftar_Lapangan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["Laporan_Daftar_Lapangan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Table object (_2padmin)
		if (!isset($GLOBALS['_2padmin'])) $GLOBALS['_2padmin'] = new c_2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'report', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'Laporan Daftar Lapangan', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";
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
		if (!$Security->CanReport()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("login.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		}
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Setup export options
		$this->SetupExportOptions();

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
		global $EW_EXPORT_REPORT;

		// Page Unload event
		$this->Page_Unload();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EW_EXPORT_REPORT)) {
			$sContent = ob_get_contents();
			$fn = $EW_EXPORT_REPORT[$this->Export];
			$this->$fn($sContent);
			if ($this->Export == "email") { // Email
				ob_end_clean();
				$conn->Close(); // Close connection
				header("Location: " . ew_CurrentPage());
				exit();
			}
		}

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
	var $ExportOptions; // Export options
	var $RecCnt = 0;
	var $ReportSql = "";
	var $ReportFilter = "";
	var $DefaultFilter = "";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $MasterRecordExists;
	var $Command;
	var $DtlRecordCount;
	var $ReportGroups;
	var $ReportCounts;
	var $LevelBreak;
	var $ReportTotals;
	var $ReportMaxs;
	var $ReportMins;
	var $Recordset;
	var $DetailRecordset;
	var $RecordExists;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		$this->ReportGroups = &ew_InitArray(1, NULL);
		$this->ReportCounts = &ew_InitArray(1, 0);
		$this->LevelBreak = &ew_InitArray(1, FALSE);
		$this->ReportTotals = &ew_Init2DArray(1, 9, 0);
		$this->ReportMaxs = &ew_Init2DArray(1, 9, 0);
		$this->ReportMins = &ew_Init2DArray(1, 9, 0);

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
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
		// Kode
		// NamaLapangan
		// Ukuran
		// Kondisi
		// HargaSewa1
		// HargaSewa2
		// HargaSewa3
		// HargaSewa4
		// HargaSewa5
		// Member
		// NonMember
		// Waktu
		// Stamp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			$this->Kode->ViewValue = $this->Kode->CurrentValue;
			$this->Kode->ViewCustomAttributes = "";

			// NamaLapangan
			$this->NamaLapangan->ViewValue = $this->NamaLapangan->CurrentValue;
			$this->NamaLapangan->ViewCustomAttributes = "";

			// Ukuran
			$this->Ukuran->ViewValue = $this->Ukuran->CurrentValue;
			$this->Ukuran->ViewCustomAttributes = "";

			// Kondisi
			$this->Kondisi->ViewValue = $this->Kondisi->CurrentValue;
			$this->Kondisi->ViewCustomAttributes = "";

			// HargaSewa1
			$this->HargaSewa1->ViewValue = $this->HargaSewa1->CurrentValue;
			$this->HargaSewa1->ViewValue = ew_FormatNumber($this->HargaSewa1->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa1->CellCssStyle .= "text-align: right;";
			$this->HargaSewa1->ViewCustomAttributes = "";

			// HargaSewa2
			$this->HargaSewa2->ViewValue = $this->HargaSewa2->CurrentValue;
			$this->HargaSewa2->ViewValue = ew_FormatNumber($this->HargaSewa2->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa2->CellCssStyle .= "text-align: right;";
			$this->HargaSewa2->ViewCustomAttributes = "";

			// HargaSewa3
			$this->HargaSewa3->ViewValue = $this->HargaSewa3->CurrentValue;
			$this->HargaSewa3->ViewValue = ew_FormatNumber($this->HargaSewa3->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa3->CellCssStyle .= "text-align: right;";
			$this->HargaSewa3->ViewCustomAttributes = "";

			// HargaSewa4
			$this->HargaSewa4->ViewValue = $this->HargaSewa4->CurrentValue;
			$this->HargaSewa4->ViewValue = ew_FormatNumber($this->HargaSewa4->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa4->CellCssStyle .= "text-align: right;";
			$this->HargaSewa4->ViewCustomAttributes = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// NamaLapangan
			$this->NamaLapangan->LinkCustomAttributes = "";
			$this->NamaLapangan->HrefValue = "";
			$this->NamaLapangan->TooltipValue = "";

			// Ukuran
			$this->Ukuran->LinkCustomAttributes = "";
			$this->Ukuran->HrefValue = "";
			$this->Ukuran->TooltipValue = "";

			// Kondisi
			$this->Kondisi->LinkCustomAttributes = "";
			$this->Kondisi->HrefValue = "";
			$this->Kondisi->TooltipValue = "";

			// HargaSewa1
			$this->HargaSewa1->LinkCustomAttributes = "";
			$this->HargaSewa1->HrefValue = "";
			$this->HargaSewa1->TooltipValue = "";

			// HargaSewa2
			$this->HargaSewa2->LinkCustomAttributes = "";
			$this->HargaSewa2->HrefValue = "";
			$this->HargaSewa2->TooltipValue = "";

			// HargaSewa3
			$this->HargaSewa3->LinkCustomAttributes = "";
			$this->HargaSewa3->HrefValue = "";
			$this->HargaSewa3->TooltipValue = "";

			// HargaSewa4
			$this->HargaSewa4->LinkCustomAttributes = "";
			$this->HargaSewa4->HrefValue = "";
			$this->HargaSewa4->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("report", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", $url, $this->TableVar);
	}

	// Export report to HTML
	function ExportReportHtml($html) {

		//global $gsExportFile;
		//header('Content-Type: text/html' . (EW_CHARSET <> '' ? ';charset=' . EW_CHARSET : ''));
		//header('Content-Disposition: attachment; filename=' . $gsExportFile . '.html');
		//echo $html;

	}

	// Export report to EXCEL
	function ExportReportExcel($html) {
		global $gsExportFile;
		header('Content-Type: application/vnd.ms-excel' . (EW_CHARSET <> '' ? ';charset=' . EW_CHARSET : ''));
		header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
		echo $html;
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
if (!isset($Laporan_Daftar_Lapangan_report)) $Laporan_Daftar_Lapangan_report = new cLaporan_Daftar_Lapangan_report();

// Page init
$Laporan_Daftar_Lapangan_report->Page_Init();

// Page main
$Laporan_Daftar_Lapangan_report->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$Laporan_Daftar_Lapangan_report->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($Laporan_Daftar_Lapangan->Export == "") { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($Laporan_Daftar_Lapangan->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php
$Laporan_Daftar_Lapangan_report->RecCnt = 1; // No grouping
if ($Laporan_Daftar_Lapangan_report->DbDetailFilter <> "") {
	if ($Laporan_Daftar_Lapangan_report->ReportFilter <> "") $Laporan_Daftar_Lapangan_report->ReportFilter .= " AND ";
	$Laporan_Daftar_Lapangan_report->ReportFilter .= "(" . $Laporan_Daftar_Lapangan_report->DbDetailFilter . ")";
}

// Set up detail SQL
$Laporan_Daftar_Lapangan->CurrentFilter = $Laporan_Daftar_Lapangan_report->ReportFilter;
$Laporan_Daftar_Lapangan_report->ReportSql = $Laporan_Daftar_Lapangan->DetailSQL();

// Load recordset
$Laporan_Daftar_Lapangan_report->Recordset = $conn->Execute($Laporan_Daftar_Lapangan_report->ReportSql);
$Laporan_Daftar_Lapangan_report->RecordExists = !$Laporan_Daftar_Lapangan_report->Recordset->EOF;
?>
<?php if ($Laporan_Daftar_Lapangan->Export == "") { ?>
<?php if ($Laporan_Daftar_Lapangan_report->RecordExists) { ?>
<div class="ewViewExportOptions"><?php $Laporan_Daftar_Lapangan_report->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php } ?>
<?php $Laporan_Daftar_Lapangan_report->ShowPageHeader(); ?>
<form method="post">
<table class="ewReportTable">
<?php

	// Get detail records
	$Laporan_Daftar_Lapangan_report->ReportFilter = $Laporan_Daftar_Lapangan_report->DefaultFilter;
	if ($Laporan_Daftar_Lapangan_report->DbDetailFilter <> "") {
		if ($Laporan_Daftar_Lapangan_report->ReportFilter <> "")
			$Laporan_Daftar_Lapangan_report->ReportFilter .= " AND ";
		$Laporan_Daftar_Lapangan_report->ReportFilter .= "(" . $Laporan_Daftar_Lapangan_report->DbDetailFilter . ")";
	}
	if (!$Security->CanReport()) {
		if ($sFilter <> "") $sFilter .= " AND ";
		$sFilter .= "(0=1)";
	}

	// Set up detail SQL
	$Laporan_Daftar_Lapangan->CurrentFilter = $Laporan_Daftar_Lapangan_report->ReportFilter;
	$Laporan_Daftar_Lapangan_report->ReportSql = $Laporan_Daftar_Lapangan->DetailSQL();

	// Load detail records
	$Laporan_Daftar_Lapangan_report->DetailRecordset = $conn->Execute($Laporan_Daftar_Lapangan_report->ReportSql);
	$Laporan_Daftar_Lapangan_report->DtlRecordCount = $Laporan_Daftar_Lapangan_report->DetailRecordset->RecordCount();

	// Initialize aggregates
	if (!$Laporan_Daftar_Lapangan_report->DetailRecordset->EOF) {
		$Laporan_Daftar_Lapangan_report->RecCnt++;
	}
	if ($Laporan_Daftar_Lapangan_report->RecCnt == 1) {
		$Laporan_Daftar_Lapangan_report->ReportCounts[0] = 0;
	}
	$Laporan_Daftar_Lapangan_report->ReportCounts[0] += $Laporan_Daftar_Lapangan_report->DtlRecordCount;
	if ($Laporan_Daftar_Lapangan_report->RecordExists) {
?>
	<tr>
		<td class="ewGroupHeader"><?php echo $Laporan_Daftar_Lapangan->Kode->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Laporan_Daftar_Lapangan->NamaLapangan->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Laporan_Daftar_Lapangan->Ukuran->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Laporan_Daftar_Lapangan->Kondisi->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Laporan_Daftar_Lapangan->HargaSewa1->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Laporan_Daftar_Lapangan->HargaSewa2->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Laporan_Daftar_Lapangan->HargaSewa3->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Laporan_Daftar_Lapangan->HargaSewa4->FldCaption() ?></td>
	</tr>
<?php
	}
	while (!$Laporan_Daftar_Lapangan_report->DetailRecordset->EOF) {
		$Laporan_Daftar_Lapangan->Kode->setDbValue($Laporan_Daftar_Lapangan_report->DetailRecordset->fields('Kode'));
		$Laporan_Daftar_Lapangan->NamaLapangan->setDbValue($Laporan_Daftar_Lapangan_report->DetailRecordset->fields('NamaLapangan'));
		$Laporan_Daftar_Lapangan->Ukuran->setDbValue($Laporan_Daftar_Lapangan_report->DetailRecordset->fields('Ukuran'));
		$Laporan_Daftar_Lapangan->Kondisi->setDbValue($Laporan_Daftar_Lapangan_report->DetailRecordset->fields('Kondisi'));
		$Laporan_Daftar_Lapangan->HargaSewa1->setDbValue($Laporan_Daftar_Lapangan_report->DetailRecordset->fields('HargaSewa1'));
		$Laporan_Daftar_Lapangan->HargaSewa2->setDbValue($Laporan_Daftar_Lapangan_report->DetailRecordset->fields('HargaSewa2'));
		$Laporan_Daftar_Lapangan->HargaSewa3->setDbValue($Laporan_Daftar_Lapangan_report->DetailRecordset->fields('HargaSewa3'));
		$Laporan_Daftar_Lapangan->HargaSewa4->setDbValue($Laporan_Daftar_Lapangan_report->DetailRecordset->fields('HargaSewa4'));

		// Render for view
		$Laporan_Daftar_Lapangan->RowType = EW_ROWTYPE_VIEW;
		$Laporan_Daftar_Lapangan->ResetAttrs();
		$Laporan_Daftar_Lapangan_report->RenderRow();
?>
	<tr>
		<td<?php echo $Laporan_Daftar_Lapangan->Kode->CellAttributes() ?>>
<span<?php echo $Laporan_Daftar_Lapangan->Kode->ViewAttributes() ?>>
<?php echo $Laporan_Daftar_Lapangan->Kode->ViewValue ?></span>
</td>
		<td<?php echo $Laporan_Daftar_Lapangan->NamaLapangan->CellAttributes() ?>>
<span<?php echo $Laporan_Daftar_Lapangan->NamaLapangan->ViewAttributes() ?>>
<?php echo $Laporan_Daftar_Lapangan->NamaLapangan->ViewValue ?></span>
</td>
		<td<?php echo $Laporan_Daftar_Lapangan->Ukuran->CellAttributes() ?>>
<span<?php echo $Laporan_Daftar_Lapangan->Ukuran->ViewAttributes() ?>>
<?php echo $Laporan_Daftar_Lapangan->Ukuran->ViewValue ?></span>
</td>
		<td<?php echo $Laporan_Daftar_Lapangan->Kondisi->CellAttributes() ?>>
<span<?php echo $Laporan_Daftar_Lapangan->Kondisi->ViewAttributes() ?>>
<?php echo $Laporan_Daftar_Lapangan->Kondisi->ViewValue ?></span>
</td>
		<td<?php echo $Laporan_Daftar_Lapangan->HargaSewa1->CellAttributes() ?>>
<span<?php echo $Laporan_Daftar_Lapangan->HargaSewa1->ViewAttributes() ?>>
<?php echo $Laporan_Daftar_Lapangan->HargaSewa1->ViewValue ?></span>
</td>
		<td<?php echo $Laporan_Daftar_Lapangan->HargaSewa2->CellAttributes() ?>>
<span<?php echo $Laporan_Daftar_Lapangan->HargaSewa2->ViewAttributes() ?>>
<?php echo $Laporan_Daftar_Lapangan->HargaSewa2->ViewValue ?></span>
</td>
		<td<?php echo $Laporan_Daftar_Lapangan->HargaSewa3->CellAttributes() ?>>
<span<?php echo $Laporan_Daftar_Lapangan->HargaSewa3->ViewAttributes() ?>>
<?php echo $Laporan_Daftar_Lapangan->HargaSewa3->ViewValue ?></span>
</td>
		<td<?php echo $Laporan_Daftar_Lapangan->HargaSewa4->CellAttributes() ?>>
<span<?php echo $Laporan_Daftar_Lapangan->HargaSewa4->ViewAttributes() ?>>
<?php echo $Laporan_Daftar_Lapangan->HargaSewa4->ViewValue ?></span>
</td>
	</tr>
<?php
		$Laporan_Daftar_Lapangan_report->DetailRecordset->MoveNext();
	}
	$Laporan_Daftar_Lapangan_report->DetailRecordset->Close();
?>
<?php if ($Laporan_Daftar_Lapangan_report->RecordExists) { ?>
	<tr><td colspan=8>&nbsp;<br></td></tr>
	<tr><td colspan=8 class="ewGrandSummary"><?php echo $Language->Phrase("RptGrandTotal") ?>&nbsp;(<?php echo ew_FormatNumber($Laporan_Daftar_Lapangan_report->ReportCounts[0], 0) ?>&nbsp;<?php echo $Language->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
<?php if ($Laporan_Daftar_Lapangan_report->RecordExists) { ?>
	<tr><td colspan=8>&nbsp;<br></td></tr>
<?php } else { ?>
	<tr><td><?php echo $Language->Phrase("NoRecord") ?></td></tr>
<?php } ?>
</table>
</form>
<?php
$Laporan_Daftar_Lapangan_report->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($Laporan_Daftar_Lapangan->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$Laporan_Daftar_Lapangan_report->Page_Terminate();
?>

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
$z2padmin_list = new cz2padmin_list();
$Page =& $z2padmin_list;

// Page init
$z2padmin_list->Page_Init();

// Page main
$z2padmin_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($z2padmin->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var z2padmin_list = new ew_Page("z2padmin_list");

// page properties
z2padmin_list.PageID = "list"; // page ID
z2padmin_list.FormID = "fz2padminlist"; // form ID
var EW_PAGE_ID = z2padmin_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
z2padmin_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
z2padmin_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
z2padmin_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
z2padmin_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($z2padmin->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$z2padmin_list->lTotalRecs = $z2padmin->SelectRecordCount();
	} else {
		if ($rs = $z2padmin_list->LoadRecordset())
			$z2padmin_list->lTotalRecs = $rs->RecordCount();
	}
	$z2padmin_list->lStartRec = 1;
	if ($z2padmin_list->lDisplayRecs <= 0 || ($z2padmin->Export <> "" && $z2padmin->ExportAll)) // Display all records
		$z2padmin_list->lDisplayRecs = $z2padmin_list->lTotalRecs;
	if (!($z2padmin->Export <> "" && $z2padmin->ExportAll))
		$z2padmin_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $z2padmin_list->LoadRecordset($z2padmin_list->lStartRec-1, $z2padmin_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php //echo $Language->Phrase("TblTypeTABLE") ?><?php echo $z2padmin->TableCaption() ?>
<?php if ($z2padmin->Export == "" && $z2padmin->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $z2padmin_list->ExportExcelUrl ?>"><?php echo $Language->Phrase("ExportToExcel") ?></a>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$z2padmin_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fz2padminlist" id="fz2padminlist" class="ewForm" action="" method="post">
<div id="gmp_z2padmin" class="ewGridMiddlePanel">
<?php if ($z2padmin_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $z2padmin->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$z2padmin_list->RenderListOptions();

// Render list options (header, left)
$z2padmin_list->ListOptions->Render("header", "left");
?>
<?php if ($z2padmin->Nama->Visible) { // Nama ?>
	<?php if ($z2padmin->SortUrl($z2padmin->Nama) == "") { ?>
		<td><?php echo $z2padmin->Nama->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $z2padmin->SortUrl($z2padmin->Nama) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $z2padmin->Nama->FldCaption() ?></td><td style="width: 10px;"><?php if ($z2padmin->Nama->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($z2padmin->Nama->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($z2padmin->Username->Visible) { // Username ?>
	<?php if ($z2padmin->SortUrl($z2padmin->Username) == "") { ?>
		<td><?php echo $z2padmin->Username->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $z2padmin->SortUrl($z2padmin->Username) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $z2padmin->Username->FldCaption() ?></td><td style="width: 10px;"><?php if ($z2padmin->Username->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($z2padmin->Username->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($z2padmin->Password->Visible) { // Password ?>
	<?php if ($z2padmin->SortUrl($z2padmin->Password) == "") { ?>
		<td><?php echo $z2padmin->Password->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $z2padmin->SortUrl($z2padmin->Password) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $z2padmin->Password->FldCaption() ?></td><td style="width: 10px;"><?php if ($z2padmin->Password->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($z2padmin->Password->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($z2padmin->Level->Visible) { // Level ?>
	<?php if ($z2padmin->SortUrl($z2padmin->Level) == "") { ?>
		<td><?php echo $z2padmin->Level->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $z2padmin->SortUrl($z2padmin->Level) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $z2padmin->Level->FldCaption() ?></td><td style="width: 10px;"><?php if ($z2padmin->Level->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($z2padmin->Level->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$z2padmin_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($z2padmin->ExportAll && $z2padmin->Export <> "") {
	$z2padmin_list->lStopRec = $z2padmin_list->lTotalRecs;
} else {
	$z2padmin_list->lStopRec = $z2padmin_list->lStartRec + $z2padmin_list->lDisplayRecs - 1; // Set the last record to display
}
$z2padmin_list->lRecCount = $z2padmin_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $z2padmin_list->lStartRec > 1)
		$rs->Move($z2padmin_list->lStartRec - 1);
}

// Initialize aggregate
$z2padmin->RowType = EW_ROWTYPE_AGGREGATEINIT;
$z2padmin_list->RenderRow();
$z2padmin_list->lRowCnt = 0;
while (($z2padmin->CurrentAction == "gridadd" || !$rs->EOF) &&
	$z2padmin_list->lRecCount < $z2padmin_list->lStopRec) {
	$z2padmin_list->lRecCount++;
	if (intval($z2padmin_list->lRecCount) >= intval($z2padmin_list->lStartRec)) {
		$z2padmin_list->lRowCnt++;

	// Init row class and style
	$z2padmin->CssClass = "";
	$z2padmin->CssStyle = "";
	$z2padmin->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($z2padmin->CurrentAction == "gridadd") {
		$z2padmin_list->LoadDefaultValues(); // Load default values
	} else {
		$z2padmin_list->LoadRowValues($rs); // Load row values
	}
	$z2padmin->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$z2padmin_list->RenderRow();

	// Render list options
	$z2padmin_list->RenderListOptions();
?>
	<tr<?php echo $z2padmin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$z2padmin_list->ListOptions->Render("body", "left");
?>
	<?php if ($z2padmin->Nama->Visible) { // Nama ?>
		<td<?php echo $z2padmin->Nama->CellAttributes() ?>>
<div<?php echo $z2padmin->Nama->ViewAttributes() ?>><?php echo $z2padmin->Nama->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($z2padmin->Username->Visible) { // Username ?>
		<td<?php echo $z2padmin->Username->CellAttributes() ?>>
<div<?php echo $z2padmin->Username->ViewAttributes() ?>><?php echo $z2padmin->Username->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($z2padmin->Password->Visible) { // Password ?>
		<td<?php echo $z2padmin->Password->CellAttributes() ?>>
<div<?php echo $z2padmin->Password->ViewAttributes() ?>><?php echo $z2padmin->Password->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($z2padmin->Level->Visible) { // Level ?>
		<td<?php echo $z2padmin->Level->CellAttributes() ?>>
<div<?php echo $z2padmin->Level->ViewAttributes() ?>><?php echo $z2padmin->Level->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$z2padmin_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($z2padmin->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($z2padmin->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($z2padmin->CurrentAction <> "gridadd" && $z2padmin->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($z2padmin_list->Pager)) $z2padmin_list->Pager = new cPrevNextPager($z2padmin_list->lStartRec, $z2padmin_list->lDisplayRecs, $z2padmin_list->lTotalRecs) ?>
<?php if ($z2padmin_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($z2padmin_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $z2padmin_list->PageUrl() ?>start=<?php echo $z2padmin_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($z2padmin_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $z2padmin_list->PageUrl() ?>start=<?php echo $z2padmin_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $z2padmin_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($z2padmin_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $z2padmin_list->PageUrl() ?>start=<?php echo $z2padmin_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($z2padmin_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $z2padmin_list->PageUrl() ?>start=<?php echo $z2padmin_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $z2padmin_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $z2padmin_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $z2padmin_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $z2padmin_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($z2padmin_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($z2padmin_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $z2padmin_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($z2padmin_list->lTotalRecs > 0) { ?>
<?php if ($Security->CanDelete()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fz2padminlist, '<?php echo $z2padmin_list->MultiDeleteUrl ?>');return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($z2padmin->Export == "" && $z2padmin->CurrentAction == "") { ?>
<?php } ?>
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
$z2padmin_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cz2padmin_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = '2padmin';

	// Page object name
	var $PageObjName = 'z2padmin_list';

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
	function cz2padmin_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (z2padmin)
		$GLOBALS["z2padmin"] = new cz2padmin();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["z2padmin"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "z2padmindelete.php";
		$this->MultiUpdateUrl = "z2padminupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", '2padmin', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
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
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		if ($Security->IsLoggedIn() && $Security->CurrentUserID() == "") {
			$_SESSION[EW_SESSION_MESSAGE] = $Language->Phrase("NoPermission");
			$this->Page_Terminate();
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$z2padmin->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$z2padmin->Export = $_POST["exporttype"];
		} else {
			$z2padmin->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $z2padmin->Export; // Get export parameter, used in header
		$gsExportFile = $z2padmin->TableVar; // Get export file, used in header
		if ($z2padmin->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
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

	// Class variables
	var $ListOptions; // List options
	var $lDisplayRecs = 20;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $sSrchWhere = ""; // Search WHERE clause
	var $lRecCnt = 0; // Record count
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex; // Row index
	var $lRecPerRow = 0;
	var $lColCnt = 0;
	var $sDbMasterFilter = ""; // Master filter
	var $sDbDetailFilter = ""; // Detail filter
	var $bMasterRecordExists;	
	var $sMultiSelectKey;
	var $RestoreSearch;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError, $Security, $z2padmin;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up list options
			$this->SetupListOptions();

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($z2padmin->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $z2padmin->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$z2padmin->setSessionWhere($sFilter);
		$z2padmin->CurrentFilter = "";

		// Export data only
		if (in_array($z2padmin->Export, array("html","word","excel","xml","csv","email"))) {
			$this->ExportData();
			if ($z2padmin->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $z2padmin;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$z2padmin->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$z2padmin->CurrentOrderType = @$_GET["ordertype"];
			$z2padmin->UpdateSort($z2padmin->Nama); // Nama
			$z2padmin->UpdateSort($z2padmin->Username); // Username
			$z2padmin->UpdateSort($z2padmin->Password); // Password
			$z2padmin->UpdateSort($z2padmin->Level); // Level
			$z2padmin->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $z2padmin;
		$sOrderBy = $z2padmin->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($z2padmin->SqlOrderBy() <> "") {
				$sOrderBy = $z2padmin->SqlOrderBy();
				$z2padmin->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $z2padmin;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$z2padmin->setSessionOrderBy($sOrderBy);
				$z2padmin->Nama->setSort("");
				$z2padmin->Username->setSort("");
				$z2padmin->Password->setSort("");
				$z2padmin->Level->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$z2padmin->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $z2padmin;

		// "edit"
		$this->ListOptions->Add("edit");
		$item =& $this->ListOptions->Items["edit"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "checkbox"
		$this->ListOptions->Add("checkbox");
		$item =& $this->ListOptions->Items["checkbox"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"z2padmin_list.SelectAllKey(this);\">";

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($z2padmin->Export <> "" ||
			$z2padmin->CurrentAction == "gridadd" ||
			$z2padmin->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $z2padmin;
		$this->ListOptions->LoadDefault();

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($Security->CanEdit() && $this->ShowOptionLink() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
		}

		// "checkbox"
		$oListOpt =& $this->ListOptions->Items["checkbox"];
		if ($Security->CanDelete() && $this->ShowOptionLink() && $oListOpt->Visible)
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($z2padmin->ID->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $z2padmin;
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $z2padmin;

		// Call Recordset Selecting event
		$z2padmin->Recordset_Selecting($z2padmin->CurrentFilter);

		// Load List page SQL
		$sSql = $z2padmin->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$z2padmin->Recordset_Selected($rs);
		return $rs;
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
		$z2padmin->ID->setDbValue($rs->fields('ID'));
		$z2padmin->Nama->setDbValue($rs->fields('Nama'));
		$z2padmin->Username->setDbValue($rs->fields('Username'));
		$z2padmin->Password->setDbValue($rs->fields('Password'));
		$z2padmin->Level->setDbValue($rs->fields('Level'));
		$z2padmin->Jabatan->setDbValue($rs->fields('Jabatan'));
		$z2padmin->Foto->Upload->DbValue = $rs->fields('Foto');
		$z2padmin->Temp->setDbValue($rs->fields('Temp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $z2padmin;

		// Initialize URLs
		$this->ViewUrl = $z2padmin->ViewUrl();
		$this->EditUrl = $z2padmin->EditUrl();
		$this->InlineEditUrl = $z2padmin->InlineEditUrl();
		$this->CopyUrl = $z2padmin->CopyUrl();
		$this->InlineCopyUrl = $z2padmin->InlineCopyUrl();
		$this->DeleteUrl = $z2padmin->DeleteUrl();

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

		// Level
		$z2padmin->Level->CellCssStyle = ""; $z2padmin->Level->CellCssClass = "";
		$z2padmin->Level->CellAttrs = array(); $z2padmin->Level->ViewAttrs = array(); $z2padmin->Level->EditAttrs = array();
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

			// Level
			if ($Security->CanAdmin()) { // System admin
			if (strval($z2padmin->Level->CurrentValue) <> "") {
				switch ($z2padmin->Level->CurrentValue) {
					case "-1":
						$z2padmin->Level->ViewValue = "Administrator";
						break;
					case "0":
						$z2padmin->Level->ViewValue = "Default";
						break;
					case "1":
						$z2padmin->Level->ViewValue = "Operator";
						break;
					default:
						$z2padmin->Level->ViewValue = $z2padmin->Level->CurrentValue;
				}
			} else {
				$z2padmin->Level->ViewValue = NULL;
			}
			} else {
				$z2padmin->Level->ViewValue = "********";
			}
			$z2padmin->Level->CssStyle = "";
			$z2padmin->Level->CssClass = "";
			$z2padmin->Level->ViewCustomAttributes = "";

			// Nama
			$z2padmin->Nama->HrefValue = "";
			$z2padmin->Nama->TooltipValue = "";

			// Username
			$z2padmin->Username->HrefValue = "";
			$z2padmin->Username->TooltipValue = "";

			// Password
			$z2padmin->Password->HrefValue = "";
			$z2padmin->Password->TooltipValue = "";

			// Level
			$z2padmin->Level->HrefValue = "";
			$z2padmin->Level->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($z2padmin->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$z2padmin->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email format
	function ExportData() {
		global $z2padmin;
		$utf8 = FALSE;
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->lTotalRecs = $z2padmin->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->lTotalRecs = $rs->RecordCount();
		}
		$this->lStartRec = 1;

		// Export all
		if ($z2padmin->ExportAll) {
			$this->lDisplayRecs = $this->lTotalRecs;
			$this->lStopRec = $this->lTotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->lDisplayRecs < 0) {
				$this->lStopRec = $this->lTotalRecs;
			} else {
				$this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->lStartRec-1, $this->lDisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		if ($z2padmin->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
			$XmlDoc->AddRoot();
		} else {
			$ExportDoc = new cExportDocument($z2padmin, "h");
			$ExportDoc->ExportHeader();
			if ($ExportDoc->Horizontal) { // Horizontal format, write header
				$ExportDoc->BeginExportRow();
				$ExportDoc->ExportCaption($z2padmin->Nama);
				$ExportDoc->ExportCaption($z2padmin->Username);
				$ExportDoc->ExportCaption($z2padmin->Password);
				$ExportDoc->ExportCaption($z2padmin->Level);
				$ExportDoc->EndExportRow();
			}
		}

		// Move to first record
		$this->lRecCnt = $this->lStartRec - 1;
		if (!$rs->EOF) {
			$rs->MoveFirst();
			if (!$bSelectLimit && $this->lStartRec > 1)
				$rs->Move($this->lStartRec - 1);
		}
		while (!$rs->EOF && $this->lRecCnt < $this->lStopRec) {
			$this->lRecCnt++;
			if (intval($this->lRecCnt) >= intval($this->lStartRec)) {
				$this->LoadRowValues($rs);

				// Render row
				$z2padmin->CssClass = "";
				$z2padmin->CssStyle = "";
				$z2padmin->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($z2padmin->Export == "xml") {
					$XmlDoc->AddRow();
					$XmlDoc->AddField('Nama', $z2padmin->Nama->ExportValue($z2padmin->Export, $z2padmin->ExportOriginalValue));
					$XmlDoc->AddField('Username', $z2padmin->Username->ExportValue($z2padmin->Export, $z2padmin->ExportOriginalValue));
					$XmlDoc->AddField('Password', $z2padmin->Password->ExportValue($z2padmin->Export, $z2padmin->ExportOriginalValue));
					$XmlDoc->AddField('Level', $z2padmin->Level->ExportValue($z2padmin->Export, $z2padmin->ExportOriginalValue));
				} else {
					$ExportDoc->BeginExportRow(TRUE); // Allow CSS styles if enabled
					$ExportDoc->ExportField($z2padmin->Nama);
					$ExportDoc->ExportField($z2padmin->Username);
					$ExportDoc->ExportField($z2padmin->Password);
					$ExportDoc->ExportField($z2padmin->Level);
					$ExportDoc->EndExportRow();
				}
			}
			$rs->MoveNext();
		}
		if ($z2padmin->Export <> "xml")
			$ExportDoc->ExportFooter();

		// Close recordset
		$rs->Close();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($z2padmin->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($z2padmin->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($z2padmin->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($z2padmin->ExportReturnUrl());
		} else {
			echo $ExportDoc->Text;
		}
	}

	// Show link optionally based on User ID
	function ShowOptionLink() {
		global $Security, $z2padmin;
		if ($Security->IsLoggedIn()) {
			if (!$Security->IsAdmin()) {
				return $Security->IsValidUserID($z2padmin->Username->CurrentValue);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example: 
		//$this->ListOptions->Add("new");
		//$this->ListOptions->Items["new"]->OnLeft = TRUE; // Link on left
		//$this->ListOptions->MoveItem("new", 0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>

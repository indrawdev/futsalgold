<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "z2pbackupinfo.php" ?>
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
$z2pbackup_list = new cz2pbackup_list();
$Page =& $z2pbackup_list;

// Page init
$z2pbackup_list->Page_Init();

// Page main
$z2pbackup_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($z2pbackup->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var z2pbackup_list = new ew_Page("z2pbackup_list");

// page properties
z2pbackup_list.PageID = "list"; // page ID
z2pbackup_list.FormID = "fz2pbackuplist"; // form ID
var EW_PAGE_ID = z2pbackup_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
z2pbackup_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
z2pbackup_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
z2pbackup_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
z2pbackup_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($z2pbackup->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$z2pbackup_list->lTotalRecs = $z2pbackup->SelectRecordCount();
	} else {
		if ($rs = $z2pbackup_list->LoadRecordset())
			$z2pbackup_list->lTotalRecs = $rs->RecordCount();
	}
	$z2pbackup_list->lStartRec = 1;
	if ($z2pbackup_list->lDisplayRecs <= 0 || ($z2pbackup->Export <> "" && $z2pbackup->ExportAll)) // Display all records
		$z2pbackup_list->lDisplayRecs = $z2pbackup_list->lTotalRecs;
	if (!($z2pbackup->Export <> "" && $z2pbackup->ExportAll))
		$z2pbackup_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $z2pbackup_list->LoadRecordset($z2pbackup_list->lStartRec-1, $z2pbackup_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php //echo $Language->Phrase("TblTypeTABLE") ?><?php echo $z2pbackup->TableCaption() ?>
<?php if ($z2pbackup->Export == "" && $z2pbackup->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $z2pbackup_list->ExportExcelUrl ?>"><?php echo $Language->Phrase("ExportToExcel") ?></a>
<?php } ?>
</span></p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($z2pbackup->Export == "" && $z2pbackup->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(z2pbackup_list);" style="text-decoration: none;"><img id="z2pbackup_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="z2pbackup_list_SearchPanel">
<form name="fz2pbackuplistsrch" id="fz2pbackuplistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="z2pbackup">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($z2pbackup->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $z2pbackup_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($z2pbackup->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($z2pbackup->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($z2pbackup->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$z2pbackup_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fz2pbackuplist" id="fz2pbackuplist" class="ewForm" action="" method="post">
<div id="gmp_z2pbackup" class="ewGridMiddlePanel">
<?php if ($z2pbackup_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $z2pbackup->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$z2pbackup_list->RenderListOptions();

// Render list options (header, left)
$z2pbackup_list->ListOptions->Render("header", "left");
?>
<?php if ($z2pbackup->ID->Visible) { // ID ?>
	<?php if ($z2pbackup->SortUrl($z2pbackup->ID) == "") { ?>
		<td><?php echo $z2pbackup->ID->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $z2pbackup->SortUrl($z2pbackup->ID) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $z2pbackup->ID->FldCaption() ?></td><td style="width: 10px;"><?php if ($z2pbackup->ID->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($z2pbackup->ID->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($z2pbackup->DBPath->Visible) { // DBPath ?>
	<?php if ($z2pbackup->SortUrl($z2pbackup->DBPath) == "") { ?>
		<td><?php echo $z2pbackup->DBPath->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $z2pbackup->SortUrl($z2pbackup->DBPath) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $z2pbackup->DBPath->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($z2pbackup->DBPath->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($z2pbackup->DBPath->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($z2pbackup->ToPath->Visible) { // ToPath ?>
	<?php if ($z2pbackup->SortUrl($z2pbackup->ToPath) == "") { ?>
		<td><?php echo $z2pbackup->ToPath->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $z2pbackup->SortUrl($z2pbackup->ToPath) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $z2pbackup->ToPath->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($z2pbackup->ToPath->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($z2pbackup->ToPath->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$z2pbackup_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($z2pbackup->ExportAll && $z2pbackup->Export <> "") {
	$z2pbackup_list->lStopRec = $z2pbackup_list->lTotalRecs;
} else {
	$z2pbackup_list->lStopRec = $z2pbackup_list->lStartRec + $z2pbackup_list->lDisplayRecs - 1; // Set the last record to display
}
$z2pbackup_list->lRecCount = $z2pbackup_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $z2pbackup_list->lStartRec > 1)
		$rs->Move($z2pbackup_list->lStartRec - 1);
}

// Initialize aggregate
$z2pbackup->RowType = EW_ROWTYPE_AGGREGATEINIT;
$z2pbackup_list->RenderRow();
$z2pbackup_list->lRowCnt = 0;
while (($z2pbackup->CurrentAction == "gridadd" || !$rs->EOF) &&
	$z2pbackup_list->lRecCount < $z2pbackup_list->lStopRec) {
	$z2pbackup_list->lRecCount++;
	if (intval($z2pbackup_list->lRecCount) >= intval($z2pbackup_list->lStartRec)) {
		$z2pbackup_list->lRowCnt++;

	// Init row class and style
	$z2pbackup->CssClass = "";
	$z2pbackup->CssStyle = "";
	$z2pbackup->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($z2pbackup->CurrentAction == "gridadd") {
		$z2pbackup_list->LoadDefaultValues(); // Load default values
	} else {
		$z2pbackup_list->LoadRowValues($rs); // Load row values
	}
	$z2pbackup->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$z2pbackup_list->RenderRow();

	// Render list options
	$z2pbackup_list->RenderListOptions();
?>
	<tr<?php echo $z2pbackup->RowAttributes() ?>>
<?php

// Render list options (body, left)
$z2pbackup_list->ListOptions->Render("body", "left");
?>
	<?php if ($z2pbackup->ID->Visible) { // ID ?>
		<td<?php echo $z2pbackup->ID->CellAttributes() ?>>
<div<?php echo $z2pbackup->ID->ViewAttributes() ?>><?php echo $z2pbackup->ID->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($z2pbackup->DBPath->Visible) { // DBPath ?>
		<td<?php echo $z2pbackup->DBPath->CellAttributes() ?>>
<div<?php echo $z2pbackup->DBPath->ViewAttributes() ?>><?php echo $z2pbackup->DBPath->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($z2pbackup->ToPath->Visible) { // ToPath ?>
		<td<?php echo $z2pbackup->ToPath->CellAttributes() ?>>
<div<?php echo $z2pbackup->ToPath->ViewAttributes() ?>><?php echo $z2pbackup->ToPath->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$z2pbackup_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($z2pbackup->CurrentAction <> "gridadd")
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
<?php if ($z2pbackup->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($z2pbackup->CurrentAction <> "gridadd" && $z2pbackup->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($z2pbackup_list->Pager)) $z2pbackup_list->Pager = new cPrevNextPager($z2pbackup_list->lStartRec, $z2pbackup_list->lDisplayRecs, $z2pbackup_list->lTotalRecs) ?>
<?php if ($z2pbackup_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($z2pbackup_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $z2pbackup_list->PageUrl() ?>start=<?php echo $z2pbackup_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($z2pbackup_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $z2pbackup_list->PageUrl() ?>start=<?php echo $z2pbackup_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $z2pbackup_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($z2pbackup_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $z2pbackup_list->PageUrl() ?>start=<?php echo $z2pbackup_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($z2pbackup_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $z2pbackup_list->PageUrl() ?>start=<?php echo $z2pbackup_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $z2pbackup_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $z2pbackup_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $z2pbackup_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $z2pbackup_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($z2pbackup_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($z2pbackup_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $z2pbackup_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($z2pbackup_list->lTotalRecs > 0) { ?>
<?php if ($Security->CanDelete()) { ?>
<a href="" onclick="ew_SubmitSelected(document.fz2pbackuplist, '<?php echo $z2pbackup_list->MultiDeleteUrl ?>');return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($z2pbackup->Export == "" && $z2pbackup->CurrentAction == "") { ?>
<?php } ?>
<?php if ($z2pbackup->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$z2pbackup_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cz2pbackup_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = '2pbackup';

	// Page object name
	var $PageObjName = 'z2pbackup_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $z2pbackup;
		if ($z2pbackup->UseTokenInUrl) $PageUrl .= "t=" . $z2pbackup->TableVar . "&"; // Add page token
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
		global $objForm, $z2pbackup;
		if ($z2pbackup->UseTokenInUrl) {
			if ($objForm)
				return ($z2pbackup->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($z2pbackup->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cz2pbackup_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (z2pbackup)
		$GLOBALS["z2pbackup"] = new cz2pbackup();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["z2pbackup"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "z2pbackupdelete.php";
		$this->MultiUpdateUrl = "z2pbackupupdate.php";

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", '2pbackup', TRUE);

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
		global $z2pbackup;

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

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$z2pbackup->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$z2pbackup->Export = $_POST["exporttype"];
		} else {
			$z2pbackup->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $z2pbackup->Export; // Get export parameter, used in header
		$gsExportFile = $z2pbackup->TableVar; // Get export file, used in header
		if ($z2pbackup->Export == "excel") {
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
		global $objForm, $Language, $gsSearchError, $Security, $z2pbackup;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up list options
			$this->SetupListOptions();

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$z2pbackup->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($z2pbackup->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $z2pbackup->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		if ($sSrchAdvanced <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchAdvanced . ")" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchBasic. ")" : $sSrchBasic;

		// Call Recordset_Searching event
		$z2pbackup->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$z2pbackup->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$z2pbackup->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $z2pbackup->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$z2pbackup->setSessionWhere($sFilter);
		$z2pbackup->CurrentFilter = "";

		// Export data only
		if (in_array($z2pbackup->Export, array("html","word","excel","xml","csv","email"))) {
			$this->ExportData();
			if ($z2pbackup->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $z2pbackup;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $z2pbackup->DBPath, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $z2pbackup->ToPath, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		$sFldExpression = ($Fld->FldVirtualExpression <> "") ? $Fld->FldVirtualExpression : $Fld->FldExpression;
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($lFldDataType == EW_DATATYPE_NUMBER) {
			$sWrk = $sFldExpression . " = " . ew_QuotedValue($Keyword, $lFldDataType);
		} else {
			$sWrk = $sFldExpression . " LIKE " . ew_QuotedValue("%" . $Keyword . "%", $lFldDataType);
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $z2pbackup;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = $z2pbackup->BasicSearchKeyword;
		$sSearchType = $z2pbackup->BasicSearchType;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$z2pbackup->setSessionBasicSearchKeyword($sSearchKeyword);
			$z2pbackup->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $z2pbackup;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$z2pbackup->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $z2pbackup;
		$z2pbackup->setSessionBasicSearchKeyword("");
		$z2pbackup->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $z2pbackup;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$z2pbackup->BasicSearchKeyword = $z2pbackup->getSessionBasicSearchKeyword();
			$z2pbackup->BasicSearchType = $z2pbackup->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $z2pbackup;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$z2pbackup->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$z2pbackup->CurrentOrderType = @$_GET["ordertype"];
			$z2pbackup->UpdateSort($z2pbackup->ID); // ID
			$z2pbackup->UpdateSort($z2pbackup->DBPath); // DBPath
			$z2pbackup->UpdateSort($z2pbackup->ToPath); // ToPath
			$z2pbackup->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $z2pbackup;
		$sOrderBy = $z2pbackup->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($z2pbackup->SqlOrderBy() <> "") {
				$sOrderBy = $z2pbackup->SqlOrderBy();
				$z2pbackup->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $z2pbackup;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$z2pbackup->setSessionOrderBy($sOrderBy);
				$z2pbackup->ID->setSort("");
				$z2pbackup->DBPath->setSort("");
				$z2pbackup->ToPath->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$z2pbackup->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $z2pbackup;

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
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"z2pbackup_list.SelectAllKey(this);\">";

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($z2pbackup->Export <> "" ||
			$z2pbackup->CurrentAction == "gridadd" ||
			$z2pbackup->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $z2pbackup;
		$this->ListOptions->LoadDefault();

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($Security->CanEdit() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
		}

		// "checkbox"
		$oListOpt =& $this->ListOptions->Items["checkbox"];
		if ($Security->CanDelete() && $oListOpt->Visible)
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($z2pbackup->ID->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $z2pbackup;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $z2pbackup;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$z2pbackup->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$z2pbackup->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $z2pbackup->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$z2pbackup->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$z2pbackup->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$z2pbackup->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $z2pbackup;
		$z2pbackup->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$z2pbackup->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $z2pbackup;

		// Call Recordset Selecting event
		$z2pbackup->Recordset_Selecting($z2pbackup->CurrentFilter);

		// Load List page SQL
		$sSql = $z2pbackup->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$z2pbackup->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $z2pbackup;
		$sFilter = $z2pbackup->KeyFilter();

		// Call Row Selecting event
		$z2pbackup->Row_Selecting($sFilter);

		// Load SQL based on filter
		$z2pbackup->CurrentFilter = $sFilter;
		$sSql = $z2pbackup->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$z2pbackup->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $z2pbackup;
		$z2pbackup->ID->setDbValue($rs->fields('ID'));
		$z2pbackup->DBPath->setDbValue($rs->fields('DBPath'));
		$z2pbackup->ToPath->setDbValue($rs->fields('ToPath'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $z2pbackup;

		// Initialize URLs
		$this->ViewUrl = $z2pbackup->ViewUrl();
		$this->EditUrl = $z2pbackup->EditUrl();
		$this->InlineEditUrl = $z2pbackup->InlineEditUrl();
		$this->CopyUrl = $z2pbackup->CopyUrl();
		$this->InlineCopyUrl = $z2pbackup->InlineCopyUrl();
		$this->DeleteUrl = $z2pbackup->DeleteUrl();

		// Call Row_Rendering event
		$z2pbackup->Row_Rendering();

		// Common render codes for all row types
		// ID

		$z2pbackup->ID->CellCssStyle = ""; $z2pbackup->ID->CellCssClass = "";
		$z2pbackup->ID->CellAttrs = array(); $z2pbackup->ID->ViewAttrs = array(); $z2pbackup->ID->EditAttrs = array();

		// DBPath
		$z2pbackup->DBPath->CellCssStyle = ""; $z2pbackup->DBPath->CellCssClass = "";
		$z2pbackup->DBPath->CellAttrs = array(); $z2pbackup->DBPath->ViewAttrs = array(); $z2pbackup->DBPath->EditAttrs = array();

		// ToPath
		$z2pbackup->ToPath->CellCssStyle = ""; $z2pbackup->ToPath->CellCssClass = "";
		$z2pbackup->ToPath->CellAttrs = array(); $z2pbackup->ToPath->ViewAttrs = array(); $z2pbackup->ToPath->EditAttrs = array();
		if ($z2pbackup->RowType == EW_ROWTYPE_VIEW) { // View row

			// ID
			$z2pbackup->ID->ViewValue = $z2pbackup->ID->CurrentValue;
			$z2pbackup->ID->CssStyle = "";
			$z2pbackup->ID->CssClass = "";
			$z2pbackup->ID->ViewCustomAttributes = "";

			// DBPath
			$z2pbackup->DBPath->ViewValue = $z2pbackup->DBPath->CurrentValue;
			$z2pbackup->DBPath->CssStyle = "";
			$z2pbackup->DBPath->CssClass = "";
			$z2pbackup->DBPath->ViewCustomAttributes = "";

			// ToPath
			$z2pbackup->ToPath->ViewValue = $z2pbackup->ToPath->CurrentValue;
			$z2pbackup->ToPath->CssStyle = "";
			$z2pbackup->ToPath->CssClass = "";
			$z2pbackup->ToPath->ViewCustomAttributes = "";

			// ID
			$z2pbackup->ID->HrefValue = "";
			$z2pbackup->ID->TooltipValue = "";

			// DBPath
			$z2pbackup->DBPath->HrefValue = "";
			$z2pbackup->DBPath->TooltipValue = "";

			// ToPath
			$z2pbackup->ToPath->HrefValue = "";
			$z2pbackup->ToPath->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($z2pbackup->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$z2pbackup->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email format
	function ExportData() {
		global $z2pbackup;
		$utf8 = FALSE;
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->lTotalRecs = $z2pbackup->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->lTotalRecs = $rs->RecordCount();
		}
		$this->lStartRec = 1;

		// Export all
		if ($z2pbackup->ExportAll) {
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
		if ($z2pbackup->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
			$XmlDoc->AddRoot();
		} else {
			$ExportDoc = new cExportDocument($z2pbackup, "h");
			$ExportDoc->ExportHeader();
			if ($ExportDoc->Horizontal) { // Horizontal format, write header
				$ExportDoc->BeginExportRow();
				$ExportDoc->ExportCaption($z2pbackup->ID);
				$ExportDoc->ExportCaption($z2pbackup->DBPath);
				$ExportDoc->ExportCaption($z2pbackup->ToPath);
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
				$z2pbackup->CssClass = "";
				$z2pbackup->CssStyle = "";
				$z2pbackup->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($z2pbackup->Export == "xml") {
					$XmlDoc->AddRow();
					$XmlDoc->AddField('ID', $z2pbackup->ID->ExportValue($z2pbackup->Export, $z2pbackup->ExportOriginalValue));
					$XmlDoc->AddField('DBPath', $z2pbackup->DBPath->ExportValue($z2pbackup->Export, $z2pbackup->ExportOriginalValue));
					$XmlDoc->AddField('ToPath', $z2pbackup->ToPath->ExportValue($z2pbackup->Export, $z2pbackup->ExportOriginalValue));
				} else {
					$ExportDoc->BeginExportRow(TRUE); // Allow CSS styles if enabled
					$ExportDoc->ExportField($z2pbackup->ID);
					$ExportDoc->ExportField($z2pbackup->DBPath);
					$ExportDoc->ExportField($z2pbackup->ToPath);
					$ExportDoc->EndExportRow();
				}
			}
			$rs->MoveNext();
		}
		if ($z2pbackup->Export <> "xml")
			$ExportDoc->ExportFooter();

		// Close recordset
		$rs->Close();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($z2pbackup->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($z2pbackup->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($z2pbackup->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($z2pbackup->ExportReturnUrl());
		} else {
			echo $ExportDoc->Text;
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

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
$z2pbackup_delete = new cz2pbackup_delete();
$Page =& $z2pbackup_delete;

// Page init
$z2pbackup_delete->Page_Init();

// Page main
$z2pbackup_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var z2pbackup_delete = new ew_Page("z2pbackup_delete");

// page properties
z2pbackup_delete.PageID = "delete"; // page ID
z2pbackup_delete.FormID = "fz2pbackupdelete"; // form ID
var EW_PAGE_ID = z2pbackup_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
z2pbackup_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
z2pbackup_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
z2pbackup_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
z2pbackup_delete.ValidateRequired = false; // no JavaScript validation
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
<?php

// Load records for display
if ($rs = $z2pbackup_delete->LoadRecordset())
	$z2pbackup_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($z2pbackup_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$z2pbackup_delete->Page_Terminate("z2pbackuplist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $z2pbackup->TableCaption() ?><br><br>
<a href="<?php echo $z2pbackup->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$z2pbackup_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="z2pbackup">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($z2pbackup_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $z2pbackup->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $z2pbackup->ID->FldCaption() ?></td>
		<td valign="top"><?php echo $z2pbackup->DBPath->FldCaption() ?></td>
		<td valign="top"><?php echo $z2pbackup->ToPath->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$z2pbackup_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$z2pbackup_delete->lRecCnt++;

	// Set row properties
	$z2pbackup->CssClass = "";
	$z2pbackup->CssStyle = "";
	$z2pbackup->RowAttrs = array();
	$z2pbackup->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$z2pbackup_delete->LoadRowValues($rs);

	// Render row
	$z2pbackup_delete->RenderRow();
?>
	<tr<?php echo $z2pbackup->RowAttributes() ?>>
		<td<?php echo $z2pbackup->ID->CellAttributes() ?>>
<div<?php echo $z2pbackup->ID->ViewAttributes() ?>><?php echo $z2pbackup->ID->ListViewValue() ?></div></td>
		<td<?php echo $z2pbackup->DBPath->CellAttributes() ?>>
<div<?php echo $z2pbackup->DBPath->ViewAttributes() ?>><?php echo $z2pbackup->DBPath->ListViewValue() ?></div></td>
		<td<?php echo $z2pbackup->ToPath->CellAttributes() ?>>
<div<?php echo $z2pbackup->ToPath->ViewAttributes() ?>><?php echo $z2pbackup->ToPath->ListViewValue() ?></div></td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$z2pbackup_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cz2pbackup_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = '2pbackup';

	// Page object name
	var $PageObjName = 'z2pbackup_delete';

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
	function cz2pbackup_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (z2pbackup)
		$GLOBALS["z2pbackup"] = new cz2pbackup();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", '2pbackup', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("z2pbackuplist.php");
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
	var $lTotalRecs = 0;
	var $lRecCnt;
	var $arRecKeys = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $z2pbackup;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["ID"] <> "") {
			$z2pbackup->ID->setQueryStringValue($_GET["ID"]);
			if (!is_numeric($z2pbackup->ID->QueryStringValue))
				$this->Page_Terminate("z2pbackuplist.php"); // Prevent SQL injection, exit
			$sKey .= $z2pbackup->ID->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if ($bSingleDelete) {
			$nKeySelected = 1; // Set up key selected count
			$this->arRecKeys[0] = $sKey;
		} else {
			if (isset($_POST["key_m"])) { // Key in form
				$nKeySelected = count($_POST["key_m"]); // Set up key selected count
				$this->arRecKeys = ew_StripSlashes($_POST["key_m"]);
			}
		}
		if ($nKeySelected <= 0)
			$this->Page_Terminate("z2pbackuplist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("z2pbackuplist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`ID`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in z2pbackup class, z2pbackupinfo.php

		$z2pbackup->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$z2pbackup->CurrentAction = $_POST["a_delete"];
		} else {
			$z2pbackup->CurrentAction = "I"; // Display record
		}
		switch ($z2pbackup->CurrentAction) {
			case "D": // Delete
				$z2pbackup->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($z2pbackup->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $z2pbackup;
		$DeleteRows = TRUE;
		$sWrkFilter = $z2pbackup->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in z2pbackup class, z2pbackupinfo.php

		$z2pbackup->CurrentFilter = $sWrkFilter;
		$sSql = $z2pbackup->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $z2pbackup->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['ID'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($z2pbackup->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($z2pbackup->CancelMessage <> "") {
				$this->setMessage($z2pbackup->CancelMessage);
				$z2pbackup->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$z2pbackup->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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

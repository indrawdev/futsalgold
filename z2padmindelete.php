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
$z2padmin_delete = new cz2padmin_delete();
$Page =& $z2padmin_delete;

// Page init
$z2padmin_delete->Page_Init();

// Page main
$z2padmin_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var z2padmin_delete = new ew_Page("z2padmin_delete");

// page properties
z2padmin_delete.PageID = "delete"; // page ID
z2padmin_delete.FormID = "fz2padmindelete"; // form ID
var EW_PAGE_ID = z2padmin_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
z2padmin_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
z2padmin_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
z2padmin_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
z2padmin_delete.ValidateRequired = false; // no JavaScript validation
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
if ($rs = $z2padmin_delete->LoadRecordset())
	$z2padmin_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($z2padmin_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$z2padmin_delete->Page_Terminate("z2padminlist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $z2padmin->TableCaption() ?><br><br>
<a href="<?php echo $z2padmin->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$z2padmin_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="z2padmin">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($z2padmin_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $z2padmin->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $z2padmin->Nama->FldCaption() ?></td>
		<td valign="top"><?php echo $z2padmin->Username->FldCaption() ?></td>
		<td valign="top"><?php echo $z2padmin->Password->FldCaption() ?></td>
		<td valign="top"><?php echo $z2padmin->Level->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$z2padmin_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$z2padmin_delete->lRecCnt++;

	// Set row properties
	$z2padmin->CssClass = "";
	$z2padmin->CssStyle = "";
	$z2padmin->RowAttrs = array();
	$z2padmin->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$z2padmin_delete->LoadRowValues($rs);

	// Render row
	$z2padmin_delete->RenderRow();
?>
	<tr<?php echo $z2padmin->RowAttributes() ?>>
		<td<?php echo $z2padmin->Nama->CellAttributes() ?>>
<div<?php echo $z2padmin->Nama->ViewAttributes() ?>><?php echo $z2padmin->Nama->ListViewValue() ?></div></td>
		<td<?php echo $z2padmin->Username->CellAttributes() ?>>
<div<?php echo $z2padmin->Username->ViewAttributes() ?>><?php echo $z2padmin->Username->ListViewValue() ?></div></td>
		<td<?php echo $z2padmin->Password->CellAttributes() ?>>
<div<?php echo $z2padmin->Password->ViewAttributes() ?>><?php echo $z2padmin->Password->ListViewValue() ?></div></td>
		<td<?php echo $z2padmin->Level->CellAttributes() ?>>
<div<?php echo $z2padmin->Level->ViewAttributes() ?>><?php echo $z2padmin->Level->ListViewValue() ?></div></td>
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
$z2padmin_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cz2padmin_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = '2padmin';

	// Page object name
	var $PageObjName = 'z2padmin_delete';

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
	function cz2padmin_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (z2padmin)
		$GLOBALS["z2padmin"] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("z2padminlist.php");
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
	var $lTotalRecs = 0;
	var $lRecCnt;
	var $arRecKeys = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $z2padmin;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["ID"] <> "") {
			$z2padmin->ID->setQueryStringValue($_GET["ID"]);
			if (!is_numeric($z2padmin->ID->QueryStringValue))
				$this->Page_Terminate("z2padminlist.php"); // Prevent SQL injection, exit
			$sKey .= $z2padmin->ID->QueryStringValue;
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
			$this->Page_Terminate("z2padminlist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("z2padminlist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`ID`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in z2padmin class, z2padmininfo.php

		$z2padmin->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$z2padmin->CurrentAction = $_POST["a_delete"];
		} else {
			$z2padmin->CurrentAction = "I"; // Display record
		}
		switch ($z2padmin->CurrentAction) {
			case "D": // Delete
				$z2padmin->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($z2padmin->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $z2padmin;
		$DeleteRows = TRUE;
		$sWrkFilter = $z2padmin->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in z2padmin class, z2padmininfo.php

		$z2padmin->CurrentFilter = $sWrkFilter;
		$sSql = $z2padmin->SQL();
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
				$DeleteRows = $z2padmin->Row_Deleting($row);
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
				$DeleteRows = $conn->Execute($z2padmin->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($z2padmin->CancelMessage <> "") {
				$this->setMessage($z2padmin->CancelMessage);
				$z2padmin->CancelMessage = "";
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
				$z2padmin->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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

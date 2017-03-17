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
$profile_delete = new cprofile_delete();
$Page =& $profile_delete;

// Page init
$profile_delete->Page_Init();

// Page main
$profile_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var profile_delete = new ew_Page("profile_delete");

// page properties
profile_delete.PageID = "delete"; // page ID
profile_delete.FormID = "fprofiledelete"; // form ID
var EW_PAGE_ID = profile_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
profile_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
profile_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
profile_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
profile_delete.ValidateRequired = false; // no JavaScript validation
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
if ($rs = $profile_delete->LoadRecordset())
	$profile_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($profile_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$profile_delete->Page_Terminate("profilelist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $profile->TableCaption() ?><br><br>
<a href="<?php echo $profile->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$profile_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="profile">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($profile_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $profile->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $profile->Kode->FldCaption() ?></td>
		<td valign="top"><?php echo $profile->NamaToko->FldCaption() ?></td>
		<td valign="top"><?php echo $profile->Pemilik->FldCaption() ?></td>
		<td valign="top"><?php echo $profile->Kota->FldCaption() ?></td>
		<td valign="top"><?php echo $profile->Telepon->FldCaption() ?></td>
		<td valign="top"><?php echo $profile->zEmail->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$profile_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$profile_delete->lRecCnt++;

	// Set row properties
	$profile->CssClass = "";
	$profile->CssStyle = "";
	$profile->RowAttrs = array();
	$profile->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$profile_delete->LoadRowValues($rs);

	// Render row
	$profile_delete->RenderRow();
?>
	<tr<?php echo $profile->RowAttributes() ?>>
		<td<?php echo $profile->Kode->CellAttributes() ?>>
<div<?php echo $profile->Kode->ViewAttributes() ?>><?php echo $profile->Kode->ListViewValue() ?></div></td>
		<td<?php echo $profile->NamaToko->CellAttributes() ?>>
<div<?php echo $profile->NamaToko->ViewAttributes() ?>><?php echo $profile->NamaToko->ListViewValue() ?></div></td>
		<td<?php echo $profile->Pemilik->CellAttributes() ?>>
<div<?php echo $profile->Pemilik->ViewAttributes() ?>><?php echo $profile->Pemilik->ListViewValue() ?></div></td>
		<td<?php echo $profile->Kota->CellAttributes() ?>>
<div<?php echo $profile->Kota->ViewAttributes() ?>><?php echo $profile->Kota->ListViewValue() ?></div></td>
		<td<?php echo $profile->Telepon->CellAttributes() ?>>
<div<?php echo $profile->Telepon->ViewAttributes() ?>><?php echo $profile->Telepon->ListViewValue() ?></div></td>
		<td<?php echo $profile->zEmail->CellAttributes() ?>>
<div<?php echo $profile->zEmail->ViewAttributes() ?>><?php echo $profile->zEmail->ListViewValue() ?></div></td>
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
$profile_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cprofile_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'profile';

	// Page object name
	var $PageObjName = 'profile_delete';

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
	function cprofile_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (profile)
		$GLOBALS["profile"] = new cprofile();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("profilelist.php");
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
		global $Language, $profile;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["ID"] <> "") {
			$profile->ID->setQueryStringValue($_GET["ID"]);
			if (!is_numeric($profile->ID->QueryStringValue))
				$this->Page_Terminate("profilelist.php"); // Prevent SQL injection, exit
			$sKey .= $profile->ID->QueryStringValue;
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
			$this->Page_Terminate("profilelist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("profilelist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`ID`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in profile class, profileinfo.php

		$profile->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$profile->CurrentAction = $_POST["a_delete"];
		} else {
			$profile->CurrentAction = "I"; // Display record
		}
		switch ($profile->CurrentAction) {
			case "D": // Delete
				$profile->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($profile->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $profile;
		$DeleteRows = TRUE;
		$sWrkFilter = $profile->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in profile class, profileinfo.php

		$profile->CurrentFilter = $sWrkFilter;
		$sSql = $profile->SQL();
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
				$DeleteRows = $profile->Row_Deleting($row);
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
				$DeleteRows = $conn->Execute($profile->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($profile->CancelMessage <> "") {
				$this->setMessage($profile->CancelMessage);
				$profile->CancelMessage = "";
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
				$profile->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $profile;

		// Call Recordset Selecting event
		$profile->Recordset_Selecting($profile->CurrentFilter);

		// Load List page SQL
		$sSql = $profile->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$profile->Recordset_Selected($rs);
		return $rs;
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
		// Call Row_Rendering event

		$profile->Row_Rendering();

		// Common render codes for all row types
		// Kode

		$profile->Kode->CellCssStyle = ""; $profile->Kode->CellCssClass = "";
		$profile->Kode->CellAttrs = array(); $profile->Kode->ViewAttrs = array(); $profile->Kode->EditAttrs = array();

		// NamaToko
		$profile->NamaToko->CellCssStyle = ""; $profile->NamaToko->CellCssClass = "";
		$profile->NamaToko->CellAttrs = array(); $profile->NamaToko->ViewAttrs = array(); $profile->NamaToko->EditAttrs = array();

		// Pemilik
		$profile->Pemilik->CellCssStyle = ""; $profile->Pemilik->CellCssClass = "";
		$profile->Pemilik->CellAttrs = array(); $profile->Pemilik->ViewAttrs = array(); $profile->Pemilik->EditAttrs = array();

		// Kota
		$profile->Kota->CellCssStyle = ""; $profile->Kota->CellCssClass = "";
		$profile->Kota->CellAttrs = array(); $profile->Kota->ViewAttrs = array(); $profile->Kota->EditAttrs = array();

		// Telepon
		$profile->Telepon->CellCssStyle = ""; $profile->Telepon->CellCssClass = "";
		$profile->Telepon->CellAttrs = array(); $profile->Telepon->ViewAttrs = array(); $profile->Telepon->EditAttrs = array();

		// Email
		$profile->zEmail->CellCssStyle = ""; $profile->zEmail->CellCssClass = "";
		$profile->zEmail->CellAttrs = array(); $profile->zEmail->ViewAttrs = array(); $profile->zEmail->EditAttrs = array();
		if ($profile->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// Kode
			$profile->Kode->HrefValue = "";
			$profile->Kode->TooltipValue = "";

			// NamaToko
			$profile->NamaToko->HrefValue = "";
			$profile->NamaToko->TooltipValue = "";

			// Pemilik
			$profile->Pemilik->HrefValue = "";
			$profile->Pemilik->TooltipValue = "";

			// Kota
			$profile->Kota->HrefValue = "";
			$profile->Kota->TooltipValue = "";

			// Telepon
			$profile->Telepon->HrefValue = "";
			$profile->Telepon->TooltipValue = "";

			// Email
			$profile->zEmail->HrefValue = "";
			$profile->zEmail->TooltipValue = "";
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

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
$profile_add = new cprofile_add();
$Page =& $profile_add;

// Page init
$profile_add->Page_Init();

// Page main
$profile_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var profile_add = new ew_Page("profile_add");

// page properties
profile_add.PageID = "add"; // page ID
profile_add.FormID = "fprofileadd"; // form ID
var EW_PAGE_ID = profile_add.PageID; // for backward compatibility

// extend page with ValidateForm function
profile_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_Kode"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Kode->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Pemilik"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Pemilik->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Alamat"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Alamat->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Kota"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Kota->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Telepon"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($profile->Telepon->FldCaption()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
profile_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
profile_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
profile_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
profile_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $profile->TableCaption() ?><br><br>
<a href="<?php echo $profile->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$profile_add->ShowMessage();
?>
<form name="fprofileadd" id="fprofileadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return profile_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="profile">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($profile->Kode->Visible) { // Kode ?>
	<tr<?php echo $profile->Kode->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Kode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $profile->Kode->CellAttributes() ?>><span id="el_Kode">
<input type="text" name="x_Kode" id="x_Kode" title="<?php echo $profile->Kode->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $profile->Kode->EditValue ?>"<?php echo $profile->Kode->EditAttributes() ?>>
</span><?php echo $profile->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->NamaToko->Visible) { // NamaToko ?>
	<tr<?php echo $profile->NamaToko->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->NamaToko->FldCaption() ?></td>
		<td<?php echo $profile->NamaToko->CellAttributes() ?>><span id="el_NamaToko">
<input type="text" name="x_NamaToko" id="x_NamaToko" title="<?php echo $profile->NamaToko->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $profile->NamaToko->EditValue ?>"<?php echo $profile->NamaToko->EditAttributes() ?>>
</span><?php echo $profile->NamaToko->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->Pemilik->Visible) { // Pemilik ?>
	<tr<?php echo $profile->Pemilik->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Pemilik->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $profile->Pemilik->CellAttributes() ?>><span id="el_Pemilik">
<input type="text" name="x_Pemilik" id="x_Pemilik" title="<?php echo $profile->Pemilik->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $profile->Pemilik->EditValue ?>"<?php echo $profile->Pemilik->EditAttributes() ?>>
</span><?php echo $profile->Pemilik->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->Alamat->Visible) { // Alamat ?>
	<tr<?php echo $profile->Alamat->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Alamat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $profile->Alamat->CellAttributes() ?>><span id="el_Alamat">
<textarea name="x_Alamat" id="x_Alamat" title="<?php echo $profile->Alamat->FldTitle() ?>" cols="35" rows="4"<?php echo $profile->Alamat->EditAttributes() ?>><?php echo $profile->Alamat->EditValue ?></textarea>
</span><?php echo $profile->Alamat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->Kota->Visible) { // Kota ?>
	<tr<?php echo $profile->Kota->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Kota->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $profile->Kota->CellAttributes() ?>><span id="el_Kota">
<input type="text" name="x_Kota" id="x_Kota" title="<?php echo $profile->Kota->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $profile->Kota->EditValue ?>"<?php echo $profile->Kota->EditAttributes() ?>>
</span><?php echo $profile->Kota->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->Telepon->Visible) { // Telepon ?>
	<tr<?php echo $profile->Telepon->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->Telepon->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $profile->Telepon->CellAttributes() ?>><span id="el_Telepon">
<input type="text" name="x_Telepon" id="x_Telepon" title="<?php echo $profile->Telepon->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $profile->Telepon->EditValue ?>"<?php echo $profile->Telepon->EditAttributes() ?>>
</span><?php echo $profile->Telepon->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($profile->zEmail->Visible) { // Email ?>
	<tr<?php echo $profile->zEmail->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $profile->zEmail->FldCaption() ?></td>
		<td<?php echo $profile->zEmail->CellAttributes() ?>><span id="el_zEmail">
<input type="text" name="x_zEmail" id="x_zEmail" title="<?php echo $profile->zEmail->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $profile->zEmail->EditValue ?>"<?php echo $profile->zEmail->EditAttributes() ?>>
</span><?php echo $profile->zEmail->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$profile_add->Page_Terminate();
?>
<?php

//
// Page class
//
class cprofile_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'profile';

	// Page object name
	var $PageObjName = 'profile_add';

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
	function cprofile_add() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (profile)
		$GLOBALS["profile"] = new cprofile();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("profilelist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();

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
	var $sDbMasterFilter = "";
	var $sDbDetailFilter = "";
	var $lPriv = 0;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $profile;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["ID"] != "") {
		  $profile->ID->setQueryStringValue($_GET["ID"]);
		} else {
		  $bCopy = FALSE;
		}

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $profile->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$profile->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $profile->CurrentAction = "C"; // Copy record
		  } else {
		    $profile->CurrentAction = "I"; // Display blank record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($profile->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage($Language->Phrase("NoRecord")); // No record found
		      $this->Page_Terminate("profilelist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$profile->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $profile->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$profile->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $profile;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $profile;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $profile;
		$profile->Kode->setFormValue($objForm->GetValue("x_Kode"));
		$profile->NamaToko->setFormValue($objForm->GetValue("x_NamaToko"));
		$profile->Pemilik->setFormValue($objForm->GetValue("x_Pemilik"));
		$profile->Alamat->setFormValue($objForm->GetValue("x_Alamat"));
		$profile->Kota->setFormValue($objForm->GetValue("x_Kota"));
		$profile->Telepon->setFormValue($objForm->GetValue("x_Telepon"));
		$profile->zEmail->setFormValue($objForm->GetValue("x_zEmail"));
		$profile->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $profile;
		$profile->ID->CurrentValue = $profile->ID->FormValue;
		$profile->Kode->CurrentValue = $profile->Kode->FormValue;
		$profile->NamaToko->CurrentValue = $profile->NamaToko->FormValue;
		$profile->Pemilik->CurrentValue = $profile->Pemilik->FormValue;
		$profile->Alamat->CurrentValue = $profile->Alamat->FormValue;
		$profile->Kota->CurrentValue = $profile->Kota->FormValue;
		$profile->Telepon->CurrentValue = $profile->Telepon->FormValue;
		$profile->zEmail->CurrentValue = $profile->zEmail->FormValue;
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
		} elseif ($profile->RowType == EW_ROWTYPE_ADD) { // Add row

			// Kode
			$profile->Kode->EditCustomAttributes = "";
			$profile->Kode->EditValue = ew_HtmlEncode($profile->Kode->CurrentValue);

			// NamaToko
			$profile->NamaToko->EditCustomAttributes = "";
			$profile->NamaToko->EditValue = ew_HtmlEncode($profile->NamaToko->CurrentValue);

			// Pemilik
			$profile->Pemilik->EditCustomAttributes = "";
			$profile->Pemilik->EditValue = ew_HtmlEncode($profile->Pemilik->CurrentValue);

			// Alamat
			$profile->Alamat->EditCustomAttributes = "";
			$profile->Alamat->EditValue = ew_HtmlEncode($profile->Alamat->CurrentValue);

			// Kota
			$profile->Kota->EditCustomAttributes = "";
			$profile->Kota->EditValue = ew_HtmlEncode($profile->Kota->CurrentValue);

			// Telepon
			$profile->Telepon->EditCustomAttributes = "";
			$profile->Telepon->EditValue = ew_HtmlEncode($profile->Telepon->CurrentValue);

			// Email
			$profile->zEmail->EditCustomAttributes = "";
			$profile->zEmail->EditValue = ew_HtmlEncode($profile->zEmail->CurrentValue);
		}

		// Call Row Rendered event
		if ($profile->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$profile->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $profile;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($profile->Kode->FormValue) && $profile->Kode->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $profile->Kode->FldCaption();
		}
		if (!is_null($profile->Pemilik->FormValue) && $profile->Pemilik->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $profile->Pemilik->FldCaption();
		}
		if (!is_null($profile->Alamat->FormValue) && $profile->Alamat->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $profile->Alamat->FldCaption();
		}
		if (!is_null($profile->Kota->FormValue) && $profile->Kota->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $profile->Kota->FldCaption();
		}
		if (!is_null($profile->Telepon->FormValue) && $profile->Telepon->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $profile->Telepon->FldCaption();
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow() {
		global $conn, $Language, $Security, $profile;
		$rsnew = array();

		// Kode
		$profile->Kode->SetDbValueDef($rsnew, $profile->Kode->CurrentValue, "", FALSE);

		// NamaToko
		$profile->NamaToko->SetDbValueDef($rsnew, $profile->NamaToko->CurrentValue, NULL, FALSE);

		// Pemilik
		$profile->Pemilik->SetDbValueDef($rsnew, $profile->Pemilik->CurrentValue, "", FALSE);

		// Alamat
		$profile->Alamat->SetDbValueDef($rsnew, $profile->Alamat->CurrentValue, "", FALSE);

		// Kota
		$profile->Kota->SetDbValueDef($rsnew, $profile->Kota->CurrentValue, "", FALSE);

		// Telepon
		$profile->Telepon->SetDbValueDef($rsnew, $profile->Telepon->CurrentValue, "", FALSE);

		// Email
		$profile->zEmail->SetDbValueDef($rsnew, $profile->zEmail->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$bInsertRow = $profile->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($profile->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($profile->CancelMessage <> "") {
				$this->setMessage($profile->CancelMessage);
				$profile->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$profile->ID->setDbValue($conn->Insert_ID());
			$rsnew['ID'] = $profile->ID->DbValue;

			// Call Row Inserted event
			$profile->Row_Inserted($rsnew);
		}
		return $AddRow;
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
}
?>

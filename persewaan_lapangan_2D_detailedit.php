<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "persewaan_lapangan_2D_detailinfo.php" ?>
<?php include "z2padmininfo.php" ?>
<?php include "persewaan_lapangan_2D_masterinfo.php" ?>
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
$persewaan_lapangan_2D_detail_edit = new cpersewaan_lapangan_2D_detail_edit();
$Page =& $persewaan_lapangan_2D_detail_edit;

// Page init
$persewaan_lapangan_2D_detail_edit->Page_Init();

// Page main
$persewaan_lapangan_2D_detail_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var persewaan_lapangan_2D_detail_edit = new ew_Page("persewaan_lapangan_2D_detail_edit");

// page properties
persewaan_lapangan_2D_detail_edit.PageID = "edit"; // page ID
persewaan_lapangan_2D_detail_edit.FormID = "fpersewaan_lapangan_2D_detailedit"; // form ID
var EW_PAGE_ID = persewaan_lapangan_2D_detail_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
persewaan_lapangan_2D_detail_edit.ValidateForm = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->Kode->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_NamaLapangan"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->NamaLapangan->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_TglSewa"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->TglSewa->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_TglSewa"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->TglSewa->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_JamSewa"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->JamSewa->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_HargaSewa"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($persewaan_lapangan_2D_detail->HargaSewa->FldErrMsg()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
persewaan_lapangan_2D_detail_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
persewaan_lapangan_2D_detail_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
persewaan_lapangan_2D_detail_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
persewaan_lapangan_2D_detail_edit.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-cold-1.css" title="win2k-1">
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $persewaan_lapangan_2D_detail->TableCaption() ?><br><br>
<a href="<?php echo $persewaan_lapangan_2D_detail->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$persewaan_lapangan_2D_detail_edit->ShowMessage();
?>
<form name="fpersewaan_lapangan_2D_detailedit" id="fpersewaan_lapangan_2D_detailedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return persewaan_lapangan_2D_detail_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="persewaan_lapangan_2D_detail">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($persewaan_lapangan_2D_detail->Kode->Visible) { // Kode ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->Kode->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->Kode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->Kode->CellAttributes() ?>><span id="el_Kode">
<?php $persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"] = "ew_AjaxAutoFill(this); " . @$persewaan_lapangan_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select id="x_Kode" name="x_Kode" title="<?php echo $persewaan_lapangan_2D_detail->Kode->FldTitle() ?>"<?php echo $persewaan_lapangan_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_detail->Kode->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `NamaLapangan` AS FIELD0 FROM `daftar lapangan`";
$sWhereWrk = "(`Kode` = '{query_value}')";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x_Kode" id="sf_x_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Kode" id="ln_x_Kode" value="x_NamaLapangan">
</span><?php echo $persewaan_lapangan_2D_detail->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->NamaLapangan->Visible) { // NamaLapangan ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->CellAttributes() ?>><span id="el_NamaLapangan">
<input type="text" name="x_NamaLapangan" id="x_NamaLapangan" title="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->FldTitle() ?>" size="30" maxlength="100" value="<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->NamaLapangan->EditAttributes() ?>>
</span><?php echo $persewaan_lapangan_2D_detail->NamaLapangan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->TglSewa->Visible) { // TglSewa ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->TglSewa->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->TglSewa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->TglSewa->CellAttributes() ?>><span id="el_TglSewa">
<input type="text" name="x_TglSewa" id="x_TglSewa" title="<?php echo $persewaan_lapangan_2D_detail->TglSewa->FldTitle() ?>" size="30" maxlength="50" value="<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->TglSewa->EditAttributes() ?>>
&nbsp;<img src="images/calendar.png" id="cal_x_TglSewa" name="cal_x_TglSewa" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField: "x_TglSewa", // input field id
	ifFormat: "%d/%m/%Y", // date format
	button: "cal_x_TglSewa" // button id
});
</script>
</span><?php echo $persewaan_lapangan_2D_detail->TglSewa->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->JamSewa->Visible) { // JamSewa ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->JamSewa->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->JamSewa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->JamSewa->CellAttributes() ?>><span id="el_JamSewa">
<select id="x_JamSewa" name="x_JamSewa" title="<?php echo $persewaan_lapangan_2D_detail->JamSewa->FldTitle() ?>"<?php echo $persewaan_lapangan_2D_detail->JamSewa->EditAttributes() ?>>
<?php
if (is_array($persewaan_lapangan_2D_detail->JamSewa->EditValue)) {
	$arwrk = $persewaan_lapangan_2D_detail->JamSewa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persewaan_lapangan_2D_detail->JamSewa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $persewaan_lapangan_2D_detail->JamSewa->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($persewaan_lapangan_2D_detail->HargaSewa->Visible) { // HargaSewa ?>
	<tr<?php echo $persewaan_lapangan_2D_detail->HargaSewa->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $persewaan_lapangan_2D_detail->HargaSewa->FldCaption() ?></td>
		<td<?php echo $persewaan_lapangan_2D_detail->HargaSewa->CellAttributes() ?>><span id="el_HargaSewa">
<input type="text" name="x_HargaSewa" id="x_HargaSewa" title="<?php echo $persewaan_lapangan_2D_detail->HargaSewa->FldTitle() ?>" size="30" value="<?php echo $persewaan_lapangan_2D_detail->HargaSewa->EditValue ?>"<?php echo $persewaan_lapangan_2D_detail->HargaSewa->EditAttributes() ?>>
</span><?php echo $persewaan_lapangan_2D_detail->HargaSewa->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<input type="hidden" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($persewaan_lapangan_2D_detail->ID->CurrentValue) ?>">
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$persewaan_lapangan_2D_detail_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cpersewaan_lapangan_2D_detail_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'persewaan lapangan - detail';

	// Page object name
	var $PageObjName = 'persewaan_lapangan_2D_detail_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $persewaan_lapangan_2D_detail;
		if ($persewaan_lapangan_2D_detail->UseTokenInUrl) $PageUrl .= "t=" . $persewaan_lapangan_2D_detail->TableVar . "&"; // Add page token
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
		global $objForm, $persewaan_lapangan_2D_detail;
		if ($persewaan_lapangan_2D_detail->UseTokenInUrl) {
			if ($objForm)
				return ($persewaan_lapangan_2D_detail->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($persewaan_lapangan_2D_detail->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cpersewaan_lapangan_2D_detail_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (persewaan_lapangan_2D_detail)
		$GLOBALS["persewaan_lapangan_2D_detail"] = new cpersewaan_lapangan_2D_detail();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Table object (persewaan_lapangan_2D_master)
		$GLOBALS['persewaan_lapangan_2D_master'] = new cpersewaan_lapangan_2D_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'persewaan lapangan - detail', TRUE);

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
		global $persewaan_lapangan_2D_detail;

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("persewaan_lapangan_2D_detaillist.php");
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
	var $sDbMasterFilter;
	var $sDbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $persewaan_lapangan_2D_detail;

		// Load key from QueryString
		if (@$_GET["ID"] <> "")
			$persewaan_lapangan_2D_detail->ID->setQueryStringValue($_GET["ID"]);

		// Set up master detail parameters
		$this->SetUpMasterDetail();
		if (@$_POST["a_edit"] <> "") {
			$persewaan_lapangan_2D_detail->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$persewaan_lapangan_2D_detail->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$persewaan_lapangan_2D_detail->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$persewaan_lapangan_2D_detail->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($persewaan_lapangan_2D_detail->ID->CurrentValue == "")
			$this->Page_Terminate("persewaan_lapangan_2D_detaillist.php"); // Invalid key, return to list
		switch ($persewaan_lapangan_2D_detail->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("persewaan_lapangan_2D_detaillist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$persewaan_lapangan_2D_detail->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $persewaan_lapangan_2D_detail->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$persewaan_lapangan_2D_detail->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$persewaan_lapangan_2D_detail->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $persewaan_lapangan_2D_detail;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $persewaan_lapangan_2D_detail;
		$persewaan_lapangan_2D_detail->Kode->setFormValue($objForm->GetValue("x_Kode"));
		$persewaan_lapangan_2D_detail->NamaLapangan->setFormValue($objForm->GetValue("x_NamaLapangan"));
		$persewaan_lapangan_2D_detail->TglSewa->setFormValue($objForm->GetValue("x_TglSewa"));
		$persewaan_lapangan_2D_detail->TglSewa->CurrentValue = ew_UnFormatDateTime($persewaan_lapangan_2D_detail->TglSewa->CurrentValue, 7);
		$persewaan_lapangan_2D_detail->JamSewa->setFormValue($objForm->GetValue("x_JamSewa"));
		$persewaan_lapangan_2D_detail->HargaSewa->setFormValue($objForm->GetValue("x_HargaSewa"));
		$persewaan_lapangan_2D_detail->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $persewaan_lapangan_2D_detail;
		$persewaan_lapangan_2D_detail->ID->CurrentValue = $persewaan_lapangan_2D_detail->ID->FormValue;
		$this->LoadRow();
		$persewaan_lapangan_2D_detail->Kode->CurrentValue = $persewaan_lapangan_2D_detail->Kode->FormValue;
		$persewaan_lapangan_2D_detail->NamaLapangan->CurrentValue = $persewaan_lapangan_2D_detail->NamaLapangan->FormValue;
		$persewaan_lapangan_2D_detail->TglSewa->CurrentValue = $persewaan_lapangan_2D_detail->TglSewa->FormValue;
		$persewaan_lapangan_2D_detail->TglSewa->CurrentValue = ew_UnFormatDateTime($persewaan_lapangan_2D_detail->TglSewa->CurrentValue, 7);
		$persewaan_lapangan_2D_detail->JamSewa->CurrentValue = $persewaan_lapangan_2D_detail->JamSewa->FormValue;
		$persewaan_lapangan_2D_detail->HargaSewa->CurrentValue = $persewaan_lapangan_2D_detail->HargaSewa->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $persewaan_lapangan_2D_detail;
		$sFilter = $persewaan_lapangan_2D_detail->KeyFilter();

		// Call Row Selecting event
		$persewaan_lapangan_2D_detail->Row_Selecting($sFilter);

		// Load SQL based on filter
		$persewaan_lapangan_2D_detail->CurrentFilter = $sFilter;
		$sSql = $persewaan_lapangan_2D_detail->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$persewaan_lapangan_2D_detail->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $persewaan_lapangan_2D_detail;
		$persewaan_lapangan_2D_detail->ID->setDbValue($rs->fields('ID'));
		$persewaan_lapangan_2D_detail->Kode->setDbValue($rs->fields('Kode'));
		$persewaan_lapangan_2D_detail->NamaLapangan->setDbValue($rs->fields('NamaLapangan'));
		$persewaan_lapangan_2D_detail->TglSewa->setDbValue($rs->fields('TglSewa'));
		$persewaan_lapangan_2D_detail->JamSewa->setDbValue($rs->fields('JamSewa'));
		$persewaan_lapangan_2D_detail->HargaSewa->setDbValue($rs->fields('HargaSewa'));
		$persewaan_lapangan_2D_detail->Status->setDbValue($rs->fields('Status'));
		$persewaan_lapangan_2D_detail->IDM->setDbValue($rs->fields('IDM'));
		$persewaan_lapangan_2D_detail->Waktu->setDbValue($rs->fields('Waktu'));
		$persewaan_lapangan_2D_detail->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $persewaan_lapangan_2D_detail;

		// Initialize URLs
		// Call Row_Rendering event

		$persewaan_lapangan_2D_detail->Row_Rendering();

		// Common render codes for all row types
		// Kode

		$persewaan_lapangan_2D_detail->Kode->CellCssStyle = ""; $persewaan_lapangan_2D_detail->Kode->CellCssClass = "";
		$persewaan_lapangan_2D_detail->Kode->CellAttrs = array(); $persewaan_lapangan_2D_detail->Kode->ViewAttrs = array(); $persewaan_lapangan_2D_detail->Kode->EditAttrs = array();

		// NamaLapangan
		$persewaan_lapangan_2D_detail->NamaLapangan->CellCssStyle = ""; $persewaan_lapangan_2D_detail->NamaLapangan->CellCssClass = "";
		$persewaan_lapangan_2D_detail->NamaLapangan->CellAttrs = array(); $persewaan_lapangan_2D_detail->NamaLapangan->ViewAttrs = array(); $persewaan_lapangan_2D_detail->NamaLapangan->EditAttrs = array();

		// TglSewa
		$persewaan_lapangan_2D_detail->TglSewa->CellCssStyle = ""; $persewaan_lapangan_2D_detail->TglSewa->CellCssClass = "";
		$persewaan_lapangan_2D_detail->TglSewa->CellAttrs = array(); $persewaan_lapangan_2D_detail->TglSewa->ViewAttrs = array(); $persewaan_lapangan_2D_detail->TglSewa->EditAttrs = array();

		// JamSewa
		$persewaan_lapangan_2D_detail->JamSewa->CellCssStyle = ""; $persewaan_lapangan_2D_detail->JamSewa->CellCssClass = "";
		$persewaan_lapangan_2D_detail->JamSewa->CellAttrs = array(); $persewaan_lapangan_2D_detail->JamSewa->ViewAttrs = array(); $persewaan_lapangan_2D_detail->JamSewa->EditAttrs = array();

		// HargaSewa
		$persewaan_lapangan_2D_detail->HargaSewa->CellCssStyle = ""; $persewaan_lapangan_2D_detail->HargaSewa->CellCssClass = "";
		$persewaan_lapangan_2D_detail->HargaSewa->CellAttrs = array(); $persewaan_lapangan_2D_detail->HargaSewa->ViewAttrs = array(); $persewaan_lapangan_2D_detail->HargaSewa->EditAttrs = array();
		if ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			if (strval($persewaan_lapangan_2D_detail->Kode->CurrentValue) <> "") {
				$sFilterWrk = "`Kode` = '" . ew_AdjustSql($persewaan_lapangan_2D_detail->Kode->CurrentValue) . "'";
			$sSqlWrk = "SELECT `Kode`, `NamaLapangan` FROM `daftar lapangan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$persewaan_lapangan_2D_detail->Kode->ViewValue = $rswrk->fields('Kode');
					$persewaan_lapangan_2D_detail->Kode->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('NamaLapangan');
					$rswrk->Close();
				} else {
					$persewaan_lapangan_2D_detail->Kode->ViewValue = $persewaan_lapangan_2D_detail->Kode->CurrentValue;
				}
			} else {
				$persewaan_lapangan_2D_detail->Kode->ViewValue = NULL;
			}
			$persewaan_lapangan_2D_detail->Kode->CssStyle = "";
			$persewaan_lapangan_2D_detail->Kode->CssClass = "";
			$persewaan_lapangan_2D_detail->Kode->ViewCustomAttributes = "";

			// NamaLapangan
			$persewaan_lapangan_2D_detail->NamaLapangan->ViewValue = $persewaan_lapangan_2D_detail->NamaLapangan->CurrentValue;
			$persewaan_lapangan_2D_detail->NamaLapangan->CssStyle = "";
			$persewaan_lapangan_2D_detail->NamaLapangan->CssClass = "";
			$persewaan_lapangan_2D_detail->NamaLapangan->ViewCustomAttributes = "";

			// TglSewa
			$persewaan_lapangan_2D_detail->TglSewa->ViewValue = $persewaan_lapangan_2D_detail->TglSewa->CurrentValue;
			$persewaan_lapangan_2D_detail->TglSewa->ViewValue = ew_FormatDateTime($persewaan_lapangan_2D_detail->TglSewa->ViewValue, 7);
			$persewaan_lapangan_2D_detail->TglSewa->CssStyle = "";
			$persewaan_lapangan_2D_detail->TglSewa->CssClass = "";
			$persewaan_lapangan_2D_detail->TglSewa->ViewCustomAttributes = "";

			// JamSewa
			if (strval($persewaan_lapangan_2D_detail->JamSewa->CurrentValue) <> "") {
				switch ($persewaan_lapangan_2D_detail->JamSewa->CurrentValue) {
					case "07:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "07:00:00";
						break;
					case "08:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "08:00:00";
						break;
					case "09:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "09:00:00";
						break;
					case "10:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "10:00:00";
						break;
					case "11:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "11:00:00";
						break;
					case "12:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "12:00:00";
						break;
					case "13:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "13:00:00";
						break;
					case "14:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "14:00:00";
						break;
					case "15:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "15:00:00";
						break;
					case "16:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "16:00:00";
						break;
					case "17:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "17:00:00";
						break;
					case "18:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "18:00:00";
						break;
					case "19:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "19:00:00";
						break;
					case "20:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "20:00:00";
						break;
					case "21:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "21:00:00";
						break;
					case "22:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "22:00:00";
						break;
					case "23:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "23:00:00";
						break;
					case "24:00:00":
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = "24:00:00";
						break;
					default:
						$persewaan_lapangan_2D_detail->JamSewa->ViewValue = $persewaan_lapangan_2D_detail->JamSewa->CurrentValue;
				}
			} else {
				$persewaan_lapangan_2D_detail->JamSewa->ViewValue = NULL;
			}
			$persewaan_lapangan_2D_detail->JamSewa->ViewValue = ew_FormatDateTime($persewaan_lapangan_2D_detail->JamSewa->ViewValue, 4);
			$persewaan_lapangan_2D_detail->JamSewa->CssStyle = "";
			$persewaan_lapangan_2D_detail->JamSewa->CssClass = "";
			$persewaan_lapangan_2D_detail->JamSewa->ViewCustomAttributes = "";

			// HargaSewa
			$persewaan_lapangan_2D_detail->HargaSewa->ViewValue = $persewaan_lapangan_2D_detail->HargaSewa->CurrentValue;
			$persewaan_lapangan_2D_detail->HargaSewa->ViewValue = ew_FormatNumber($persewaan_lapangan_2D_detail->HargaSewa->ViewValue, 0, -2, -2, -2);
			$persewaan_lapangan_2D_detail->HargaSewa->CssStyle = "text-align:right;";
			$persewaan_lapangan_2D_detail->HargaSewa->CssClass = "";
			$persewaan_lapangan_2D_detail->HargaSewa->ViewCustomAttributes = "";

			// Kode
			$persewaan_lapangan_2D_detail->Kode->HrefValue = "";
			$persewaan_lapangan_2D_detail->Kode->TooltipValue = "";

			// NamaLapangan
			$persewaan_lapangan_2D_detail->NamaLapangan->HrefValue = "";
			$persewaan_lapangan_2D_detail->NamaLapangan->TooltipValue = "";

			// TglSewa
			if (!ew_Empty($persewaan_lapangan_2D_detail->TglSewa->CurrentValue)) {
				$persewaan_lapangan_2D_detail->TglSewa->HrefValue = ((!empty($persewaan_lapangan_2D_detail->TglSewa->ViewValue)) ? $persewaan_lapangan_2D_detail->TglSewa->ViewValue : $persewaan_lapangan_2D_detail->TglSewa->CurrentValue);
				if ($persewaan_lapangan_2D_detail->Export <> "") $persewaan_lapangan_2D_detail->TglSewa->HrefValue = ew_ConvertFullUrl($persewaan_lapangan_2D_detail->TglSewa->HrefValue);
			} else {
				$persewaan_lapangan_2D_detail->TglSewa->HrefValue = "";
			}
			$persewaan_lapangan_2D_detail->TglSewa->TooltipValue = "";

			// JamSewa
			if (!ew_Empty($persewaan_lapangan_2D_detail->TglSewa->CurrentValue)) {
				$persewaan_lapangan_2D_detail->JamSewa->HrefValue = ((!empty($persewaan_lapangan_2D_detail->TglSewa->ViewValue)) ? $persewaan_lapangan_2D_detail->TglSewa->ViewValue : $persewaan_lapangan_2D_detail->TglSewa->CurrentValue);
				if ($persewaan_lapangan_2D_detail->Export <> "") $persewaan_lapangan_2D_detail->JamSewa->HrefValue = ew_ConvertFullUrl($persewaan_lapangan_2D_detail->JamSewa->HrefValue);
			} else {
				$persewaan_lapangan_2D_detail->JamSewa->HrefValue = "";
			}
			$persewaan_lapangan_2D_detail->JamSewa->TooltipValue = "";

			// HargaSewa
			$persewaan_lapangan_2D_detail->HargaSewa->HrefValue = "";
			$persewaan_lapangan_2D_detail->HargaSewa->TooltipValue = "";
		} elseif ($persewaan_lapangan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Kode
			$persewaan_lapangan_2D_detail->Kode->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `Kode`, `Kode`, `NamaLapangan`, '' AS SelectFilterFld FROM `daftar lapangan`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), ""));
			$persewaan_lapangan_2D_detail->Kode->EditValue = $arwrk;

			// NamaLapangan
			$persewaan_lapangan_2D_detail->NamaLapangan->EditCustomAttributes = "";
			$persewaan_lapangan_2D_detail->NamaLapangan->EditValue = ew_HtmlEncode($persewaan_lapangan_2D_detail->NamaLapangan->CurrentValue);

			// TglSewa
			$persewaan_lapangan_2D_detail->TglSewa->EditCustomAttributes = "";
			$persewaan_lapangan_2D_detail->TglSewa->EditValue = ew_HtmlEncode(ew_FormatDateTime($persewaan_lapangan_2D_detail->TglSewa->CurrentValue, 7));

			// JamSewa
			$persewaan_lapangan_2D_detail->JamSewa->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("07:00:00", "07:00:00");
			$arwrk[] = array("08:00:00", "08:00:00");
			$arwrk[] = array("09:00:00", "09:00:00");
			$arwrk[] = array("10:00:00", "10:00:00");
			$arwrk[] = array("11:00:00", "11:00:00");
			$arwrk[] = array("12:00:00", "12:00:00");
			$arwrk[] = array("13:00:00", "13:00:00");
			$arwrk[] = array("14:00:00", "14:00:00");
			$arwrk[] = array("15:00:00", "15:00:00");
			$arwrk[] = array("16:00:00", "16:00:00");
			$arwrk[] = array("17:00:00", "17:00:00");
			$arwrk[] = array("18:00:00", "18:00:00");
			$arwrk[] = array("19:00:00", "19:00:00");
			$arwrk[] = array("20:00:00", "20:00:00");
			$arwrk[] = array("21:00:00", "21:00:00");
			$arwrk[] = array("22:00:00", "22:00:00");
			$arwrk[] = array("23:00:00", "23:00:00");
			$arwrk[] = array("24:00:00", "24:00:00");
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$persewaan_lapangan_2D_detail->JamSewa->EditValue = $arwrk;

			// HargaSewa
			$persewaan_lapangan_2D_detail->HargaSewa->EditCustomAttributes = "";
			$persewaan_lapangan_2D_detail->HargaSewa->EditValue = ew_HtmlEncode($persewaan_lapangan_2D_detail->HargaSewa->CurrentValue);

			// Edit refer script
			// Kode

			$persewaan_lapangan_2D_detail->Kode->HrefValue = "";

			// NamaLapangan
			$persewaan_lapangan_2D_detail->NamaLapangan->HrefValue = "";

			// TglSewa
			if (!ew_Empty($persewaan_lapangan_2D_detail->TglSewa->CurrentValue)) {
				$persewaan_lapangan_2D_detail->TglSewa->HrefValue = ((!empty($persewaan_lapangan_2D_detail->TglSewa->EditValue)) ? $persewaan_lapangan_2D_detail->TglSewa->EditValue : $persewaan_lapangan_2D_detail->TglSewa->CurrentValue);
				if ($persewaan_lapangan_2D_detail->Export <> "") $persewaan_lapangan_2D_detail->TglSewa->HrefValue = ew_ConvertFullUrl($persewaan_lapangan_2D_detail->TglSewa->HrefValue);
			} else {
				$persewaan_lapangan_2D_detail->TglSewa->HrefValue = "";
			}

			// JamSewa
			if (!ew_Empty($persewaan_lapangan_2D_detail->TglSewa->CurrentValue)) {
				$persewaan_lapangan_2D_detail->JamSewa->HrefValue = ((!empty($persewaan_lapangan_2D_detail->TglSewa->EditValue)) ? $persewaan_lapangan_2D_detail->TglSewa->EditValue : $persewaan_lapangan_2D_detail->TglSewa->CurrentValue);
				if ($persewaan_lapangan_2D_detail->Export <> "") $persewaan_lapangan_2D_detail->JamSewa->HrefValue = ew_ConvertFullUrl($persewaan_lapangan_2D_detail->JamSewa->HrefValue);
			} else {
				$persewaan_lapangan_2D_detail->JamSewa->HrefValue = "";
			}

			// HargaSewa
			$persewaan_lapangan_2D_detail->HargaSewa->HrefValue = "";
		}

		// Call Row Rendered event
		if ($persewaan_lapangan_2D_detail->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$persewaan_lapangan_2D_detail->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $persewaan_lapangan_2D_detail;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($persewaan_lapangan_2D_detail->Kode->FormValue) && $persewaan_lapangan_2D_detail->Kode->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $persewaan_lapangan_2D_detail->Kode->FldCaption();
		}
		if (!is_null($persewaan_lapangan_2D_detail->NamaLapangan->FormValue) && $persewaan_lapangan_2D_detail->NamaLapangan->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $persewaan_lapangan_2D_detail->NamaLapangan->FldCaption();
		}
		if (!is_null($persewaan_lapangan_2D_detail->TglSewa->FormValue) && $persewaan_lapangan_2D_detail->TglSewa->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $persewaan_lapangan_2D_detail->TglSewa->FldCaption();
		}
		if (!ew_CheckEuroDate($persewaan_lapangan_2D_detail->TglSewa->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $persewaan_lapangan_2D_detail->TglSewa->FldErrMsg();
		}
		if (!is_null($persewaan_lapangan_2D_detail->JamSewa->FormValue) && $persewaan_lapangan_2D_detail->JamSewa->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $persewaan_lapangan_2D_detail->JamSewa->FldCaption();
		}
		if (!ew_CheckInteger($persewaan_lapangan_2D_detail->HargaSewa->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $persewaan_lapangan_2D_detail->HargaSewa->FldErrMsg();
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $persewaan_lapangan_2D_detail;
		$sFilter = $persewaan_lapangan_2D_detail->KeyFilter();
		$persewaan_lapangan_2D_detail->CurrentFilter = $sFilter;
		$sSql = $persewaan_lapangan_2D_detail->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// Kode
			$persewaan_lapangan_2D_detail->Kode->SetDbValueDef($rsnew, $persewaan_lapangan_2D_detail->Kode->CurrentValue, "", FALSE);

			// NamaLapangan
			$persewaan_lapangan_2D_detail->NamaLapangan->SetDbValueDef($rsnew, $persewaan_lapangan_2D_detail->NamaLapangan->CurrentValue, NULL, FALSE);

			// TglSewa
			$persewaan_lapangan_2D_detail->TglSewa->SetDbValueDef($rsnew, ew_UnFormatDateTime($persewaan_lapangan_2D_detail->TglSewa->CurrentValue, 7, FALSE), NULL);

			// JamSewa
			$persewaan_lapangan_2D_detail->JamSewa->SetDbValueDef($rsnew, ew_FormatDateTime($persewaan_lapangan_2D_detail->JamSewa->CurrentValue, 4), NULL, FALSE);

			// HargaSewa
			$persewaan_lapangan_2D_detail->HargaSewa->SetDbValueDef($rsnew, $persewaan_lapangan_2D_detail->HargaSewa->CurrentValue, NULL, FALSE);

			// Call Row Updating event
			$bUpdateRow = $persewaan_lapangan_2D_detail->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($persewaan_lapangan_2D_detail->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($persewaan_lapangan_2D_detail->CancelMessage <> "") {
					$this->setMessage($persewaan_lapangan_2D_detail->CancelMessage);
					$persewaan_lapangan_2D_detail->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$persewaan_lapangan_2D_detail->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterDetail() {
		global $persewaan_lapangan_2D_detail;
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = "";
				$this->sDbDetailFilter = "";
			}
			if ($sMasterTblVar == "persewaan_lapangan_2D_master") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = $persewaan_lapangan_2D_detail->SqlMasterFilter_persewaan_lapangan_2D_master();
				$this->sDbDetailFilter = $persewaan_lapangan_2D_detail->SqlDetailFilter_persewaan_lapangan_2D_master();
				if (@$_GET["ID"] <> "") {
					$GLOBALS["persewaan_lapangan_2D_master"]->ID->setQueryStringValue($_GET["ID"]);
					$persewaan_lapangan_2D_detail->IDM->setQueryStringValue($GLOBALS["persewaan_lapangan_2D_master"]->ID->QueryStringValue);
					$persewaan_lapangan_2D_detail->IDM->setSessionValue($persewaan_lapangan_2D_detail->IDM->QueryStringValue);
					if (!is_numeric($GLOBALS["persewaan_lapangan_2D_master"]->ID->QueryStringValue)) $bValidMaster = FALSE;
					$this->sDbMasterFilter = str_replace("@ID@", ew_AdjustSql($GLOBALS["persewaan_lapangan_2D_master"]->ID->QueryStringValue), $this->sDbMasterFilter);
					$this->sDbDetailFilter = str_replace("@IDM@", ew_AdjustSql($GLOBALS["persewaan_lapangan_2D_master"]->ID->QueryStringValue), $this->sDbDetailFilter);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$persewaan_lapangan_2D_detail->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->lStartRec = 1;
			$persewaan_lapangan_2D_detail->setStartRecordNumber($this->lStartRec);
			$persewaan_lapangan_2D_detail->setMasterFilter($this->sDbMasterFilter); // Set up master filter
			$persewaan_lapangan_2D_detail->setDetailFilter($this->sDbDetailFilter); // Set up detail filter

			// Clear previous master key from Session
			if ($sMasterTblVar <> "persewaan_lapangan_2D_master") {
				if ($persewaan_lapangan_2D_detail->IDM->QueryStringValue == "") $persewaan_lapangan_2D_detail->IDM->setSessionValue("");
			}
		} else {
			$this->sDbMasterFilter = $persewaan_lapangan_2D_detail->getMasterFilter(); //  Restore master filter
			$this->sDbDetailFilter = $persewaan_lapangan_2D_detail->getDetailFilter(); // Restore detail filter
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
}
?>

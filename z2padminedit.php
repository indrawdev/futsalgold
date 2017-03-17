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
$z2padmin_edit = new cz2padmin_edit();
$Page =& $z2padmin_edit;

// Page init
$z2padmin_edit->Page_Init();

// Page main
$z2padmin_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var z2padmin_edit = new ew_Page("z2padmin_edit");

// page properties
z2padmin_edit.PageID = "edit"; // page ID
z2padmin_edit.FormID = "fz2padminedit"; // form ID
var EW_PAGE_ID = z2padmin_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
z2padmin_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_Nama"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($z2padmin->Nama->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Username"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($z2padmin->Username->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Password"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($z2padmin->Password->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Level"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($z2padmin->Level->FldCaption()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
z2padmin_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
z2padmin_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
z2padmin_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
z2padmin_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $z2padmin->TableCaption() ?><br><br>
<a href="<?php echo $z2padmin->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$z2padmin_edit->ShowMessage();
?>
<form name="fz2padminedit" id="fz2padminedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return z2padmin_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="z2padmin">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($z2padmin->Nama->Visible) { // Nama ?>
	<tr<?php echo $z2padmin->Nama->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $z2padmin->Nama->CellAttributes() ?>><span id="el_Nama">
<input type="text" name="x_Nama" id="x_Nama" title="<?php echo $z2padmin->Nama->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $z2padmin->Nama->EditValue ?>"<?php echo $z2padmin->Nama->EditAttributes() ?>>
</span><?php echo $z2padmin->Nama->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($z2padmin->Username->Visible) { // Username ?>
	<tr<?php echo $z2padmin->Username->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $z2padmin->Username->CellAttributes() ?>><span id="el_Username">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<div<?php echo $z2padmin->Username->ViewAttributes() ?>><?php echo $z2padmin->Username->EditValue ?></div>
<input type="hidden" name="x_Username" id="x_Username" value="<?php echo ew_HtmlEncode($z2padmin->Username->CurrentValue) ?>">
<?php } else { ?>
<input type="text" name="x_Username" id="x_Username" title="<?php echo $z2padmin->Username->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $z2padmin->Username->EditValue ?>"<?php echo $z2padmin->Username->EditAttributes() ?>>
<?php } ?>
</span><?php echo $z2padmin->Username->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($z2padmin->Password->Visible) { // Password ?>
	<tr<?php echo $z2padmin->Password->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $z2padmin->Password->CellAttributes() ?>><span id="el_Password">
<input type="text" name="x_Password" id="x_Password" title="<?php echo $z2padmin->Password->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $z2padmin->Password->EditValue ?>"<?php echo $z2padmin->Password->EditAttributes() ?>>
</span><?php echo $z2padmin->Password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($z2padmin->Level->Visible) { // Level ?>
	<tr<?php echo $z2padmin->Level->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $z2padmin->Level->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $z2padmin->Level->CellAttributes() ?>><span id="el_Level">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<div<?php echo $z2padmin->Level->ViewAttributes() ?>><?php echo $z2padmin->Level->EditValue ?></div>
<?php } else { ?>
<select id="x_Level" name="x_Level" title="<?php echo $z2padmin->Level->FldTitle() ?>"<?php echo $z2padmin->Level->EditAttributes() ?>>
<?php
if (is_array($z2padmin->Level->EditValue)) {
	$arwrk = $z2padmin->Level->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($z2padmin->Level->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php } ?>
</span><?php echo $z2padmin->Level->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<input type="hidden" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($z2padmin->ID->CurrentValue) ?>">
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
$z2padmin_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cz2padmin_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = '2padmin';

	// Page object name
	var $PageObjName = 'z2padmin_edit';

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
	function cz2padmin_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (z2padmin)
		$GLOBALS["z2padmin"] = new cz2padmin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		global $objForm, $Language, $gsFormError, $z2padmin;

		// Load key from QueryString
		if (@$_GET["ID"] <> "")
			$z2padmin->ID->setQueryStringValue($_GET["ID"]);
		if (@$_POST["a_edit"] <> "") {
			$z2padmin->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$z2padmin->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$z2padmin->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$z2padmin->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($z2padmin->ID->CurrentValue == "")
			$this->Page_Terminate("z2padminlist.php"); // Invalid key, return to list
		switch ($z2padmin->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("z2padminlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$z2padmin->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $z2padmin->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$z2padmin->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$z2padmin->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $z2padmin;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $z2padmin;
		$z2padmin->Nama->setFormValue($objForm->GetValue("x_Nama"));
		$z2padmin->Username->setFormValue($objForm->GetValue("x_Username"));
		$z2padmin->Password->setFormValue($objForm->GetValue("x_Password"));
		$z2padmin->Level->setFormValue($objForm->GetValue("x_Level"));
		$z2padmin->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $z2padmin;
		$z2padmin->ID->CurrentValue = $z2padmin->ID->FormValue;
		$this->LoadRow();
		$z2padmin->Nama->CurrentValue = $z2padmin->Nama->FormValue;
		$z2padmin->Username->CurrentValue = $z2padmin->Username->FormValue;
		$z2padmin->Password->CurrentValue = $z2padmin->Password->FormValue;
		$z2padmin->Level->CurrentValue = $z2padmin->Level->FormValue;
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
		} elseif ($z2padmin->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Nama
			$z2padmin->Nama->EditCustomAttributes = "";
			$z2padmin->Nama->EditValue = ew_HtmlEncode($z2padmin->Nama->CurrentValue);

			// Username
			$z2padmin->Username->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin
				$z2padmin->Username->CurrentValue = $Security->CurrentUserID();
			$z2padmin->Username->EditValue = $z2padmin->Username->CurrentValue;
			$z2padmin->Username->CssStyle = "";
			$z2padmin->Username->CssClass = "";
			$z2padmin->Username->ViewCustomAttributes = "";
			} else {
			$z2padmin->Username->EditValue = ew_HtmlEncode($z2padmin->Username->CurrentValue);
			}

			// Password
			$z2padmin->Password->EditCustomAttributes = "";
			$z2padmin->Password->EditValue = ew_HtmlEncode($z2padmin->Password->CurrentValue);

			// Level
			$z2padmin->Level->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$z2padmin->Level->EditValue = "********";
			} else {
			$arwrk = array();
			$arwrk[] = array("-1", "Administrator");
			$arwrk[] = array("0", "Default");
			$arwrk[] = array("1", "Operator");
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$z2padmin->Level->EditValue = $arwrk;
			}

			// Edit refer script
			// Nama

			$z2padmin->Nama->HrefValue = "";

			// Username
			$z2padmin->Username->HrefValue = "";

			// Password
			$z2padmin->Password->HrefValue = "";

			// Level
			$z2padmin->Level->HrefValue = "";
		}

		// Call Row Rendered event
		if ($z2padmin->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$z2padmin->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $z2padmin;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($z2padmin->Nama->FormValue) && $z2padmin->Nama->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $z2padmin->Nama->FldCaption();
		}
		if (!is_null($z2padmin->Username->FormValue) && $z2padmin->Username->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $z2padmin->Username->FldCaption();
		}
		if (!is_null($z2padmin->Password->FormValue) && $z2padmin->Password->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $z2padmin->Password->FldCaption();
		}
		if (!is_null($z2padmin->Level->FormValue) && $z2padmin->Level->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $z2padmin->Level->FldCaption();
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
		global $conn, $Security, $Language, $z2padmin;
		$sFilter = $z2padmin->KeyFilter();
		$z2padmin->CurrentFilter = $sFilter;
		$sSql = $z2padmin->SQL();
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

			// Nama
			$z2padmin->Nama->SetDbValueDef($rsnew, $z2padmin->Nama->CurrentValue, "", FALSE);

			// Username
			$z2padmin->Username->SetDbValueDef($rsnew, $z2padmin->Username->CurrentValue, "", FALSE);

			// Password
			$z2padmin->Password->SetDbValueDef($rsnew, $z2padmin->Password->CurrentValue, "", FALSE);

			// Level
						if ($Security->CanAdmin()) { // System admin
			$z2padmin->Level->SetDbValueDef($rsnew, $z2padmin->Level->CurrentValue, 0, FALSE);
			}

			// Call Row Updating event
			$bUpdateRow = $z2padmin->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($z2padmin->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($z2padmin->CancelMessage <> "") {
					$this->setMessage($z2padmin->CancelMessage);
					$z2padmin->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$z2padmin->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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

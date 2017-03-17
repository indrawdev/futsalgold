<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "penjualan_2D_detailinfo.php" ?>
<?php include "z2padmininfo.php" ?>
<?php include "penjualan_2D_masterinfo.php" ?>
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
$penjualan_2D_detail_edit = new cpenjualan_2D_detail_edit();
$Page =& $penjualan_2D_detail_edit;

// Page init
$penjualan_2D_detail_edit->Page_Init();

// Page main
$penjualan_2D_detail_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var penjualan_2D_detail_edit = new ew_Page("penjualan_2D_detail_edit");

// page properties
penjualan_2D_detail_edit.PageID = "edit"; // page ID
penjualan_2D_detail_edit.FormID = "fpenjualan_2D_detailedit"; // form ID
var EW_PAGE_ID = penjualan_2D_detail_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
penjualan_2D_detail_edit.ValidateForm = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_detail->Kode->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Nama_Barang"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_detail->Nama_Barang->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Satuan"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($penjualan_2D_detail->Satuan->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Harga_Jual"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($penjualan_2D_detail->Harga_Jual->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Jumlah"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($penjualan_2D_detail->Jumlah->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Diskon"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($penjualan_2D_detail->Diskon->FldErrMsg()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
penjualan_2D_detail_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
penjualan_2D_detail_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
penjualan_2D_detail_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
penjualan_2D_detail_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $penjualan_2D_detail->TableCaption() ?><br><br>
<a href="<?php echo $penjualan_2D_detail->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$penjualan_2D_detail_edit->ShowMessage();
?>
<form name="fpenjualan_2D_detailedit" id="fpenjualan_2D_detailedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return penjualan_2D_detail_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="penjualan_2D_detail">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($penjualan_2D_detail->Kode->Visible) { // Kode ?>
	<tr<?php echo $penjualan_2D_detail->Kode->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $penjualan_2D_detail->Kode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $penjualan_2D_detail->Kode->CellAttributes() ?>><span id="el_Kode">
<?php $penjualan_2D_detail->Kode->EditAttrs["onchange"] = "ew_AjaxAutoFill(this); " . @$penjualan_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select id="x_Kode" name="x_Kode" title="<?php echo $penjualan_2D_detail->Kode->FldTitle() ?>"<?php echo $penjualan_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($penjualan_2D_detail->Kode->EditValue)) {
	$arwrk = $penjualan_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($penjualan_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `Kode` AS FIELD0, `Nama Barang` AS FIELD1, `Satuan` AS FIELD2, `Harga Jual` AS FIELD3 FROM `daftar produk`";
$sWhereWrk = "(`Kode` = '{query_value}')";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x_Kode" id="sf_x_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Kode" id="ln_x_Kode" value="x_Kode,x_Nama_Barang,x_Satuan,x_Harga_Jual">
</span><?php echo $penjualan_2D_detail->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($penjualan_2D_detail->Nama_Barang->Visible) { // Nama Barang ?>
	<tr<?php echo $penjualan_2D_detail->Nama_Barang->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $penjualan_2D_detail->Nama_Barang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $penjualan_2D_detail->Nama_Barang->CellAttributes() ?>><span id="el_Nama_Barang">
<input type="text" name="x_Nama_Barang" id="x_Nama_Barang" title="<?php echo $penjualan_2D_detail->Nama_Barang->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $penjualan_2D_detail->Nama_Barang->EditValue ?>"<?php echo $penjualan_2D_detail->Nama_Barang->EditAttributes() ?>>
</span><?php echo $penjualan_2D_detail->Nama_Barang->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($penjualan_2D_detail->Satuan->Visible) { // Satuan ?>
	<tr<?php echo $penjualan_2D_detail->Satuan->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $penjualan_2D_detail->Satuan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $penjualan_2D_detail->Satuan->CellAttributes() ?>><span id="el_Satuan">
<input type="text" name="x_Satuan" id="x_Satuan" title="<?php echo $penjualan_2D_detail->Satuan->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $penjualan_2D_detail->Satuan->EditValue ?>"<?php echo $penjualan_2D_detail->Satuan->EditAttributes() ?>>
</span><?php echo $penjualan_2D_detail->Satuan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($penjualan_2D_detail->Harga_Jual->Visible) { // Harga Jual ?>
	<tr<?php echo $penjualan_2D_detail->Harga_Jual->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $penjualan_2D_detail->Harga_Jual->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $penjualan_2D_detail->Harga_Jual->CellAttributes() ?>><span id="el_Harga_Jual">
<input type="text" name="x_Harga_Jual" id="x_Harga_Jual" title="<?php echo $penjualan_2D_detail->Harga_Jual->FldTitle() ?>" size="30" value="<?php echo $penjualan_2D_detail->Harga_Jual->EditValue ?>"<?php echo $penjualan_2D_detail->Harga_Jual->EditAttributes() ?>>
</span><?php echo $penjualan_2D_detail->Harga_Jual->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($penjualan_2D_detail->Jumlah->Visible) { // Jumlah ?>
	<tr<?php echo $penjualan_2D_detail->Jumlah->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $penjualan_2D_detail->Jumlah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $penjualan_2D_detail->Jumlah->CellAttributes() ?>><span id="el_Jumlah">
<input type="text" name="x_Jumlah" id="x_Jumlah" title="<?php echo $penjualan_2D_detail->Jumlah->FldTitle() ?>" size="30" value="<?php echo $penjualan_2D_detail->Jumlah->EditValue ?>"<?php echo $penjualan_2D_detail->Jumlah->EditAttributes() ?>>
</span><?php echo $penjualan_2D_detail->Jumlah->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($penjualan_2D_detail->Diskon->Visible) { // Diskon ?>
	<tr<?php echo $penjualan_2D_detail->Diskon->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $penjualan_2D_detail->Diskon->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $penjualan_2D_detail->Diskon->CellAttributes() ?>><span id="el_Diskon">
<input type="text" name="x_Diskon" id="x_Diskon" title="<?php echo $penjualan_2D_detail->Diskon->FldTitle() ?>" size="30" value="<?php echo $penjualan_2D_detail->Diskon->EditValue ?>"<?php echo $penjualan_2D_detail->Diskon->EditAttributes() ?>>
</span><?php echo $penjualan_2D_detail->Diskon->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<input type="hidden" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($penjualan_2D_detail->ID->CurrentValue) ?>">
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
$penjualan_2D_detail_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cpenjualan_2D_detail_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'penjualan - detail';

	// Page object name
	var $PageObjName = 'penjualan_2D_detail_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $penjualan_2D_detail;
		if ($penjualan_2D_detail->UseTokenInUrl) $PageUrl .= "t=" . $penjualan_2D_detail->TableVar . "&"; // Add page token
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
		global $objForm, $penjualan_2D_detail;
		if ($penjualan_2D_detail->UseTokenInUrl) {
			if ($objForm)
				return ($penjualan_2D_detail->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($penjualan_2D_detail->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cpenjualan_2D_detail_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (penjualan_2D_detail)
		$GLOBALS["penjualan_2D_detail"] = new cpenjualan_2D_detail();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Table object (penjualan_2D_master)
		$GLOBALS['penjualan_2D_master'] = new cpenjualan_2D_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'penjualan - detail', TRUE);

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
		global $penjualan_2D_detail;

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
			$this->Page_Terminate("penjualan_2D_detaillist.php");
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
		global $objForm, $Language, $gsFormError, $penjualan_2D_detail;

		// Load key from QueryString
		if (@$_GET["ID"] <> "")
			$penjualan_2D_detail->ID->setQueryStringValue($_GET["ID"]);

		// Set up master detail parameters
		$this->SetUpMasterDetail();
		if (@$_POST["a_edit"] <> "") {
			$penjualan_2D_detail->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$penjualan_2D_detail->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$penjualan_2D_detail->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$penjualan_2D_detail->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($penjualan_2D_detail->ID->CurrentValue == "")
			$this->Page_Terminate("penjualan_2D_detaillist.php"); // Invalid key, return to list
		switch ($penjualan_2D_detail->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("penjualan_2D_detaillist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$penjualan_2D_detail->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $penjualan_2D_detail->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$penjualan_2D_detail->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$penjualan_2D_detail->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $penjualan_2D_detail;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $penjualan_2D_detail;
		$penjualan_2D_detail->Kode->setFormValue($objForm->GetValue("x_Kode"));
		$penjualan_2D_detail->Nama_Barang->setFormValue($objForm->GetValue("x_Nama_Barang"));
		$penjualan_2D_detail->Satuan->setFormValue($objForm->GetValue("x_Satuan"));
		$penjualan_2D_detail->Harga_Jual->setFormValue($objForm->GetValue("x_Harga_Jual"));
		$penjualan_2D_detail->Jumlah->setFormValue($objForm->GetValue("x_Jumlah"));
		$penjualan_2D_detail->Diskon->setFormValue($objForm->GetValue("x_Diskon"));
		$penjualan_2D_detail->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $penjualan_2D_detail;
		$penjualan_2D_detail->ID->CurrentValue = $penjualan_2D_detail->ID->FormValue;
		$this->LoadRow();
		$penjualan_2D_detail->Kode->CurrentValue = $penjualan_2D_detail->Kode->FormValue;
		$penjualan_2D_detail->Nama_Barang->CurrentValue = $penjualan_2D_detail->Nama_Barang->FormValue;
		$penjualan_2D_detail->Satuan->CurrentValue = $penjualan_2D_detail->Satuan->FormValue;
		$penjualan_2D_detail->Harga_Jual->CurrentValue = $penjualan_2D_detail->Harga_Jual->FormValue;
		$penjualan_2D_detail->Jumlah->CurrentValue = $penjualan_2D_detail->Jumlah->FormValue;
		$penjualan_2D_detail->Diskon->CurrentValue = $penjualan_2D_detail->Diskon->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $penjualan_2D_detail;
		$sFilter = $penjualan_2D_detail->KeyFilter();

		// Call Row Selecting event
		$penjualan_2D_detail->Row_Selecting($sFilter);

		// Load SQL based on filter
		$penjualan_2D_detail->CurrentFilter = $sFilter;
		$sSql = $penjualan_2D_detail->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$penjualan_2D_detail->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $penjualan_2D_detail;
		$penjualan_2D_detail->ID->setDbValue($rs->fields('ID'));
		$penjualan_2D_detail->Kode->setDbValue($rs->fields('Kode'));
		if (array_key_exists('EV__Kode', $rs->fields)) {
			$penjualan_2D_detail->Kode->VirtualValue = $rs->fields('EV__Kode'); // Set up virtual field value
		} else {
			$penjualan_2D_detail->Kode->VirtualValue = ""; // Clear value
		}
		$penjualan_2D_detail->Nama_Barang->setDbValue($rs->fields('Nama Barang'));
		$penjualan_2D_detail->Isi->setDbValue($rs->fields('Isi'));
		$penjualan_2D_detail->Satuan->setDbValue($rs->fields('Satuan'));
		$penjualan_2D_detail->Harga_Pokok->setDbValue($rs->fields('Harga Pokok'));
		$penjualan_2D_detail->Harga_Jual->setDbValue($rs->fields('Harga Jual'));
		$penjualan_2D_detail->Jumlah->setDbValue($rs->fields('Jumlah'));
		$penjualan_2D_detail->Total_Jumlah->setDbValue($rs->fields('Total Jumlah'));
		$penjualan_2D_detail->Berat->setDbValue($rs->fields('Berat'));
		$penjualan_2D_detail->Diskon->setDbValue($rs->fields('Diskon'));
		$penjualan_2D_detail->Total_HP->setDbValue($rs->fields('Total HP'));
		$penjualan_2D_detail->Total_HJ->setDbValue($rs->fields('Total HJ'));
		$penjualan_2D_detail->Saldo->setDbValue($rs->fields('Saldo'));
		$penjualan_2D_detail->Retur->setDbValue($rs->fields('Retur'));
		$penjualan_2D_detail->User->setDbValue($rs->fields('User'));
		$penjualan_2D_detail->IDM->setDbValue($rs->fields('IDM'));
		$penjualan_2D_detail->Waktu->setDbValue($rs->fields('Waktu'));
		$penjualan_2D_detail->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $penjualan_2D_detail;

		// Initialize URLs
		// Call Row_Rendering event

		$penjualan_2D_detail->Row_Rendering();

		// Common render codes for all row types
		// Kode

		$penjualan_2D_detail->Kode->CellCssStyle = ""; $penjualan_2D_detail->Kode->CellCssClass = "";
		$penjualan_2D_detail->Kode->CellAttrs = array(); $penjualan_2D_detail->Kode->ViewAttrs = array(); $penjualan_2D_detail->Kode->EditAttrs = array();

		// Nama Barang
		$penjualan_2D_detail->Nama_Barang->CellCssStyle = ""; $penjualan_2D_detail->Nama_Barang->CellCssClass = "";
		$penjualan_2D_detail->Nama_Barang->CellAttrs = array(); $penjualan_2D_detail->Nama_Barang->ViewAttrs = array(); $penjualan_2D_detail->Nama_Barang->EditAttrs = array();

		// Satuan
		$penjualan_2D_detail->Satuan->CellCssStyle = ""; $penjualan_2D_detail->Satuan->CellCssClass = "";
		$penjualan_2D_detail->Satuan->CellAttrs = array(); $penjualan_2D_detail->Satuan->ViewAttrs = array(); $penjualan_2D_detail->Satuan->EditAttrs = array();

		// Harga Jual
		$penjualan_2D_detail->Harga_Jual->CellCssStyle = ""; $penjualan_2D_detail->Harga_Jual->CellCssClass = "";
		$penjualan_2D_detail->Harga_Jual->CellAttrs = array(); $penjualan_2D_detail->Harga_Jual->ViewAttrs = array(); $penjualan_2D_detail->Harga_Jual->EditAttrs = array();

		// Jumlah
		$penjualan_2D_detail->Jumlah->CellCssStyle = ""; $penjualan_2D_detail->Jumlah->CellCssClass = "";
		$penjualan_2D_detail->Jumlah->CellAttrs = array(); $penjualan_2D_detail->Jumlah->ViewAttrs = array(); $penjualan_2D_detail->Jumlah->EditAttrs = array();

		// Diskon
		$penjualan_2D_detail->Diskon->CellCssStyle = ""; $penjualan_2D_detail->Diskon->CellCssClass = "";
		$penjualan_2D_detail->Diskon->CellAttrs = array(); $penjualan_2D_detail->Diskon->ViewAttrs = array(); $penjualan_2D_detail->Diskon->EditAttrs = array();
		if ($penjualan_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			if ($penjualan_2D_detail->Kode->VirtualValue <> "") {
				$penjualan_2D_detail->Kode->ViewValue = $penjualan_2D_detail->Kode->VirtualValue;
			} else {
			if (strval($penjualan_2D_detail->Kode->CurrentValue) <> "") {
				$sFilterWrk = "`Kode` = '" . ew_AdjustSql($penjualan_2D_detail->Kode->CurrentValue) . "'";
			$sSqlWrk = "SELECT `Kode`, `Nama Barang` FROM `daftar produk`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				if ($sWhereWrk <> "") $sWhereWrk .= " AND ";
				$sWhereWrk .= "(" . $sFilterWrk . ")";
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Kode` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$penjualan_2D_detail->Kode->ViewValue = $rswrk->fields('Kode');
					$penjualan_2D_detail->Kode->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('Nama Barang');
					$rswrk->Close();
				} else {
					$penjualan_2D_detail->Kode->ViewValue = $penjualan_2D_detail->Kode->CurrentValue;
				}
			} else {
				$penjualan_2D_detail->Kode->ViewValue = NULL;
			}
			}
			$penjualan_2D_detail->Kode->CssStyle = "";
			$penjualan_2D_detail->Kode->CssClass = "";
			$penjualan_2D_detail->Kode->ViewCustomAttributes = "";

			// Nama Barang
			$penjualan_2D_detail->Nama_Barang->ViewValue = $penjualan_2D_detail->Nama_Barang->CurrentValue;
			$penjualan_2D_detail->Nama_Barang->CssStyle = "";
			$penjualan_2D_detail->Nama_Barang->CssClass = "";
			$penjualan_2D_detail->Nama_Barang->ViewCustomAttributes = "";

			// Satuan
			$penjualan_2D_detail->Satuan->ViewValue = $penjualan_2D_detail->Satuan->CurrentValue;
			$penjualan_2D_detail->Satuan->CssStyle = "";
			$penjualan_2D_detail->Satuan->CssClass = "";
			$penjualan_2D_detail->Satuan->ViewCustomAttributes = "";

			// Harga Jual
			$penjualan_2D_detail->Harga_Jual->ViewValue = $penjualan_2D_detail->Harga_Jual->CurrentValue;
			$penjualan_2D_detail->Harga_Jual->ViewValue = ew_FormatNumber($penjualan_2D_detail->Harga_Jual->ViewValue, 0, -2, -2, -2);
			$penjualan_2D_detail->Harga_Jual->CssStyle = "text-align:right;";
			$penjualan_2D_detail->Harga_Jual->CssClass = "";
			$penjualan_2D_detail->Harga_Jual->ViewCustomAttributes = "";

			// Jumlah
			$penjualan_2D_detail->Jumlah->ViewValue = $penjualan_2D_detail->Jumlah->CurrentValue;
			$penjualan_2D_detail->Jumlah->CssStyle = "text-align:center;";
			$penjualan_2D_detail->Jumlah->CssClass = "";
			$penjualan_2D_detail->Jumlah->ViewCustomAttributes = "";

			// Diskon
			$penjualan_2D_detail->Diskon->ViewValue = $penjualan_2D_detail->Diskon->CurrentValue;
			$penjualan_2D_detail->Diskon->ViewValue = ew_FormatNumber($penjualan_2D_detail->Diskon->ViewValue, 0, -2, -2, -2);
			$penjualan_2D_detail->Diskon->CssStyle = "text-align:center;";
			$penjualan_2D_detail->Diskon->CssClass = "";
			$penjualan_2D_detail->Diskon->ViewCustomAttributes = "";

			// Total HJ
			$penjualan_2D_detail->Total_HJ->ViewValue = $penjualan_2D_detail->Total_HJ->CurrentValue;
			$penjualan_2D_detail->Total_HJ->ViewValue = ew_FormatNumber($penjualan_2D_detail->Total_HJ->ViewValue, 0, -2, -2, -2);
			$penjualan_2D_detail->Total_HJ->CssStyle = "text-align:right;";
			$penjualan_2D_detail->Total_HJ->CssClass = "";
			$penjualan_2D_detail->Total_HJ->ViewCustomAttributes = "";

			// Kode
			$penjualan_2D_detail->Kode->HrefValue = "";
			$penjualan_2D_detail->Kode->TooltipValue = "";

			// Nama Barang
			$penjualan_2D_detail->Nama_Barang->HrefValue = "";
			$penjualan_2D_detail->Nama_Barang->TooltipValue = "";

			// Satuan
			$penjualan_2D_detail->Satuan->HrefValue = "";
			$penjualan_2D_detail->Satuan->TooltipValue = "";

			// Harga Jual
			$penjualan_2D_detail->Harga_Jual->HrefValue = "";
			$penjualan_2D_detail->Harga_Jual->TooltipValue = "";

			// Jumlah
			$penjualan_2D_detail->Jumlah->HrefValue = "";
			$penjualan_2D_detail->Jumlah->TooltipValue = "";

			// Diskon
			$penjualan_2D_detail->Diskon->HrefValue = "";
			$penjualan_2D_detail->Diskon->TooltipValue = "";
		} elseif ($penjualan_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Kode
			$penjualan_2D_detail->Kode->EditCustomAttributes = "";
				$sFilterWrk = "";
			$sSqlWrk = "SELECT `Kode`, `Kode`, `Nama Barang`, '' AS SelectFilterFld FROM `daftar produk`";
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
			$penjualan_2D_detail->Kode->EditValue = $arwrk;

			// Nama Barang
			$penjualan_2D_detail->Nama_Barang->EditCustomAttributes = "";
			$penjualan_2D_detail->Nama_Barang->EditValue = ew_HtmlEncode($penjualan_2D_detail->Nama_Barang->CurrentValue);

			// Satuan
			$penjualan_2D_detail->Satuan->EditCustomAttributes = "";
			$penjualan_2D_detail->Satuan->EditValue = ew_HtmlEncode($penjualan_2D_detail->Satuan->CurrentValue);

			// Harga Jual
			$penjualan_2D_detail->Harga_Jual->EditCustomAttributes = "";
			$penjualan_2D_detail->Harga_Jual->EditValue = ew_HtmlEncode($penjualan_2D_detail->Harga_Jual->CurrentValue);

			// Jumlah
			$penjualan_2D_detail->Jumlah->EditCustomAttributes = "";
			$penjualan_2D_detail->Jumlah->EditValue = ew_HtmlEncode($penjualan_2D_detail->Jumlah->CurrentValue);

			// Diskon
			$penjualan_2D_detail->Diskon->EditCustomAttributes = "";
			$penjualan_2D_detail->Diskon->EditValue = ew_HtmlEncode($penjualan_2D_detail->Diskon->CurrentValue);

			// Edit refer script
			// Kode

			$penjualan_2D_detail->Kode->HrefValue = "";

			// Nama Barang
			$penjualan_2D_detail->Nama_Barang->HrefValue = "";

			// Satuan
			$penjualan_2D_detail->Satuan->HrefValue = "";

			// Harga Jual
			$penjualan_2D_detail->Harga_Jual->HrefValue = "";

			// Jumlah
			$penjualan_2D_detail->Jumlah->HrefValue = "";

			// Diskon
			$penjualan_2D_detail->Diskon->HrefValue = "";
		}

		// Call Row Rendered event
		if ($penjualan_2D_detail->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$penjualan_2D_detail->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $penjualan_2D_detail;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($penjualan_2D_detail->Kode->FormValue) && $penjualan_2D_detail->Kode->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $penjualan_2D_detail->Kode->FldCaption();
		}
		if (!is_null($penjualan_2D_detail->Nama_Barang->FormValue) && $penjualan_2D_detail->Nama_Barang->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $penjualan_2D_detail->Nama_Barang->FldCaption();
		}
		if (!is_null($penjualan_2D_detail->Satuan->FormValue) && $penjualan_2D_detail->Satuan->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $penjualan_2D_detail->Satuan->FldCaption();
		}
		if (!ew_CheckInteger($penjualan_2D_detail->Harga_Jual->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $penjualan_2D_detail->Harga_Jual->FldErrMsg();
		}
		if (!ew_CheckNumber($penjualan_2D_detail->Jumlah->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $penjualan_2D_detail->Jumlah->FldErrMsg();
		}
		if (!ew_CheckNumber($penjualan_2D_detail->Diskon->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $penjualan_2D_detail->Diskon->FldErrMsg();
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
		global $conn, $Security, $Language, $penjualan_2D_detail;
		$sFilter = $penjualan_2D_detail->KeyFilter();
		$penjualan_2D_detail->CurrentFilter = $sFilter;
		$sSql = $penjualan_2D_detail->SQL();
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
			$penjualan_2D_detail->Kode->SetDbValueDef($rsnew, $penjualan_2D_detail->Kode->CurrentValue, "", FALSE);

			// Nama Barang
			$penjualan_2D_detail->Nama_Barang->SetDbValueDef($rsnew, $penjualan_2D_detail->Nama_Barang->CurrentValue, "", FALSE);

			// Satuan
			$penjualan_2D_detail->Satuan->SetDbValueDef($rsnew, $penjualan_2D_detail->Satuan->CurrentValue, "", FALSE);

			// Harga Jual
			$penjualan_2D_detail->Harga_Jual->SetDbValueDef($rsnew, $penjualan_2D_detail->Harga_Jual->CurrentValue, 0, FALSE);

			// Jumlah
			$penjualan_2D_detail->Jumlah->SetDbValueDef($rsnew, $penjualan_2D_detail->Jumlah->CurrentValue, 0, FALSE);

			// Diskon
			$penjualan_2D_detail->Diskon->SetDbValueDef($rsnew, $penjualan_2D_detail->Diskon->CurrentValue, 0, FALSE);

			// Call Row Updating event
			$bUpdateRow = $penjualan_2D_detail->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($penjualan_2D_detail->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($penjualan_2D_detail->CancelMessage <> "") {
					$this->setMessage($penjualan_2D_detail->CancelMessage);
					$penjualan_2D_detail->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$penjualan_2D_detail->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterDetail() {
		global $penjualan_2D_detail;
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = "";
				$this->sDbDetailFilter = "";
			}
			if ($sMasterTblVar == "penjualan_2D_master") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = $penjualan_2D_detail->SqlMasterFilter_penjualan_2D_master();
				$this->sDbDetailFilter = $penjualan_2D_detail->SqlDetailFilter_penjualan_2D_master();
				if (@$_GET["ID"] <> "") {
					$GLOBALS["penjualan_2D_master"]->ID->setQueryStringValue($_GET["ID"]);
					$penjualan_2D_detail->IDM->setQueryStringValue($GLOBALS["penjualan_2D_master"]->ID->QueryStringValue);
					$penjualan_2D_detail->IDM->setSessionValue($penjualan_2D_detail->IDM->QueryStringValue);
					if (!is_numeric($GLOBALS["penjualan_2D_master"]->ID->QueryStringValue)) $bValidMaster = FALSE;
					$this->sDbMasterFilter = str_replace("@ID@", ew_AdjustSql($GLOBALS["penjualan_2D_master"]->ID->QueryStringValue), $this->sDbMasterFilter);
					$this->sDbDetailFilter = str_replace("@IDM@", ew_AdjustSql($GLOBALS["penjualan_2D_master"]->ID->QueryStringValue), $this->sDbDetailFilter);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$penjualan_2D_detail->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->lStartRec = 1;
			$penjualan_2D_detail->setStartRecordNumber($this->lStartRec);
			$penjualan_2D_detail->setMasterFilter($this->sDbMasterFilter); // Set up master filter
			$penjualan_2D_detail->setDetailFilter($this->sDbDetailFilter); // Set up detail filter

			// Clear previous master key from Session
			if ($sMasterTblVar <> "penjualan_2D_master") {
				if ($penjualan_2D_detail->IDM->QueryStringValue == "") $penjualan_2D_detail->IDM->setSessionValue("");
			}
		} else {
			$this->sDbMasterFilter = $penjualan_2D_detail->getMasterFilter(); //  Restore master filter
			$this->sDbDetailFilter = $penjualan_2D_detail->getDetailFilter(); // Restore detail filter
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

<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "pembelian_2D_detailinfo.php" ?>
<?php include "z2padmininfo.php" ?>
<?php include "pembelian_2D_masterinfo.php" ?>
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
$pembelian_2D_detail_edit = new cpembelian_2D_detail_edit();
$Page =& $pembelian_2D_detail_edit;

// Page init
$pembelian_2D_detail_edit->Page_Init();

// Page main
$pembelian_2D_detail_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var pembelian_2D_detail_edit = new ew_Page("pembelian_2D_detail_edit");

// page properties
pembelian_2D_detail_edit.PageID = "edit"; // page ID
pembelian_2D_detail_edit.FormID = "fpembelian_2D_detailedit"; // form ID
var EW_PAGE_ID = pembelian_2D_detail_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
pembelian_2D_detail_edit.ValidateForm = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Kode->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Nama_Barang"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Nama_Barang->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Satuan"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Satuan->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Harga_Beli"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Harga_Beli->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Harga_Beli"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($pembelian_2D_detail->Harga_Beli->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Jumlah"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Jumlah->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Jumlah"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($pembelian_2D_detail->Jumlah->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Total_Jumlah"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($pembelian_2D_detail->Total_Jumlah->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Total_Jumlah"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($pembelian_2D_detail->Total_Jumlah->FldErrMsg()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
pembelian_2D_detail_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
pembelian_2D_detail_edit.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
pembelian_2D_detail_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
pembelian_2D_detail_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $pembelian_2D_detail->TableCaption() ?><br><br>
<a href="<?php echo $pembelian_2D_detail->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$pembelian_2D_detail_edit->ShowMessage();
?>
<form name="fpembelian_2D_detailedit" id="fpembelian_2D_detailedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return pembelian_2D_detail_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="pembelian_2D_detail">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($pembelian_2D_detail->Kode->Visible) { // Kode ?>
	<tr<?php echo $pembelian_2D_detail->Kode->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $pembelian_2D_detail->Kode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $pembelian_2D_detail->Kode->CellAttributes() ?>><span id="el_Kode">
<?php $pembelian_2D_detail->Kode->EditAttrs["onchange"] = "ew_AjaxAutoFill(this); " . @$pembelian_2D_detail->Kode->EditAttrs["onchange"]; ?>
<select id="x_Kode" name="x_Kode" title="<?php echo $pembelian_2D_detail->Kode->FldTitle() ?>"<?php echo $pembelian_2D_detail->Kode->EditAttributes() ?>>
<?php
if (is_array($pembelian_2D_detail->Kode->EditValue)) {
	$arwrk = $pembelian_2D_detail->Kode->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pembelian_2D_detail->Kode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `Kode` AS FIELD0, `Nama Barang` AS FIELD1, `Satuan` AS FIELD2, `Harga Pokok` AS FIELD3 FROM `daftar produk`";
$sWhereWrk = "(`Kode` = '{query_value}')";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Kode` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x_Kode" id="sf_x_Kode" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Kode" id="ln_x_Kode" value="x_Kode,x_Nama_Barang,x_Satuan,x_Harga_Beli">
</span><?php echo $pembelian_2D_detail->Kode->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($pembelian_2D_detail->Nama_Barang->Visible) { // Nama Barang ?>
	<tr<?php echo $pembelian_2D_detail->Nama_Barang->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $pembelian_2D_detail->Nama_Barang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $pembelian_2D_detail->Nama_Barang->CellAttributes() ?>><span id="el_Nama_Barang">
<input type="text" name="x_Nama_Barang" id="x_Nama_Barang" title="<?php echo $pembelian_2D_detail->Nama_Barang->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $pembelian_2D_detail->Nama_Barang->EditValue ?>"<?php echo $pembelian_2D_detail->Nama_Barang->EditAttributes() ?>>
</span><?php echo $pembelian_2D_detail->Nama_Barang->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($pembelian_2D_detail->Satuan->Visible) { // Satuan ?>
	<tr<?php echo $pembelian_2D_detail->Satuan->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $pembelian_2D_detail->Satuan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $pembelian_2D_detail->Satuan->CellAttributes() ?>><span id="el_Satuan">
<input type="text" name="x_Satuan" id="x_Satuan" title="<?php echo $pembelian_2D_detail->Satuan->FldTitle() ?>" size="30" maxlength="255" value="<?php echo $pembelian_2D_detail->Satuan->EditValue ?>"<?php echo $pembelian_2D_detail->Satuan->EditAttributes() ?>>
</span><?php echo $pembelian_2D_detail->Satuan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($pembelian_2D_detail->Harga_Beli->Visible) { // Harga Beli ?>
	<tr<?php echo $pembelian_2D_detail->Harga_Beli->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $pembelian_2D_detail->Harga_Beli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $pembelian_2D_detail->Harga_Beli->CellAttributes() ?>><span id="el_Harga_Beli">
<input type="text" name="x_Harga_Beli" id="x_Harga_Beli" title="<?php echo $pembelian_2D_detail->Harga_Beli->FldTitle() ?>" size="30" value="<?php echo $pembelian_2D_detail->Harga_Beli->EditValue ?>"<?php echo $pembelian_2D_detail->Harga_Beli->EditAttributes() ?>>
</span><?php echo $pembelian_2D_detail->Harga_Beli->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($pembelian_2D_detail->Jumlah->Visible) { // Jumlah ?>
	<tr<?php echo $pembelian_2D_detail->Jumlah->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $pembelian_2D_detail->Jumlah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $pembelian_2D_detail->Jumlah->CellAttributes() ?>><span id="el_Jumlah">
<input type="text" name="x_Jumlah" id="x_Jumlah" title="<?php echo $pembelian_2D_detail->Jumlah->FldTitle() ?>" size="30" value="<?php echo $pembelian_2D_detail->Jumlah->EditValue ?>"<?php echo $pembelian_2D_detail->Jumlah->EditAttributes() ?>>
</span><?php echo $pembelian_2D_detail->Jumlah->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($pembelian_2D_detail->Total_Jumlah->Visible) { // Total Jumlah ?>
	<tr<?php echo $pembelian_2D_detail->Total_Jumlah->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $pembelian_2D_detail->Total_Jumlah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $pembelian_2D_detail->Total_Jumlah->CellAttributes() ?>><span id="el_Total_Jumlah">
<input type="text" name="x_Total_Jumlah" id="x_Total_Jumlah" title="<?php echo $pembelian_2D_detail->Total_Jumlah->FldTitle() ?>" size="30" value="<?php echo $pembelian_2D_detail->Total_Jumlah->EditValue ?>"<?php echo $pembelian_2D_detail->Total_Jumlah->EditAttributes() ?>>
</span><?php echo $pembelian_2D_detail->Total_Jumlah->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<input type="hidden" name="x_ID" id="x_ID" value="<?php echo ew_HtmlEncode($pembelian_2D_detail->ID->CurrentValue) ?>">
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
$pembelian_2D_detail_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cpembelian_2D_detail_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'pembelian - detail';

	// Page object name
	var $PageObjName = 'pembelian_2D_detail_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $pembelian_2D_detail;
		if ($pembelian_2D_detail->UseTokenInUrl) $PageUrl .= "t=" . $pembelian_2D_detail->TableVar . "&"; // Add page token
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
		global $objForm, $pembelian_2D_detail;
		if ($pembelian_2D_detail->UseTokenInUrl) {
			if ($objForm)
				return ($pembelian_2D_detail->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($pembelian_2D_detail->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cpembelian_2D_detail_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (pembelian_2D_detail)
		$GLOBALS["pembelian_2D_detail"] = new cpembelian_2D_detail();

		// Table object (z2padmin)
		$GLOBALS['z2padmin'] = new cz2padmin();

		// Table object (pembelian_2D_master)
		$GLOBALS['pembelian_2D_master'] = new cpembelian_2D_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pembelian - detail', TRUE);

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
		global $pembelian_2D_detail;

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
			$this->Page_Terminate("pembelian_2D_detaillist.php");
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
		global $objForm, $Language, $gsFormError, $pembelian_2D_detail;

		// Load key from QueryString
		if (@$_GET["ID"] <> "")
			$pembelian_2D_detail->ID->setQueryStringValue($_GET["ID"]);

		// Set up master detail parameters
		$this->SetUpMasterDetail();
		if (@$_POST["a_edit"] <> "") {
			$pembelian_2D_detail->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$pembelian_2D_detail->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$pembelian_2D_detail->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$pembelian_2D_detail->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($pembelian_2D_detail->ID->CurrentValue == "")
			$this->Page_Terminate("pembelian_2D_detaillist.php"); // Invalid key, return to list
		switch ($pembelian_2D_detail->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("pembelian_2D_detaillist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$pembelian_2D_detail->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $pembelian_2D_detail->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$pembelian_2D_detail->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$pembelian_2D_detail->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $pembelian_2D_detail;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $pembelian_2D_detail;
		$pembelian_2D_detail->Kode->setFormValue($objForm->GetValue("x_Kode"));
		$pembelian_2D_detail->Nama_Barang->setFormValue($objForm->GetValue("x_Nama_Barang"));
		$pembelian_2D_detail->Satuan->setFormValue($objForm->GetValue("x_Satuan"));
		$pembelian_2D_detail->Harga_Beli->setFormValue($objForm->GetValue("x_Harga_Beli"));
		$pembelian_2D_detail->Jumlah->setFormValue($objForm->GetValue("x_Jumlah"));
		$pembelian_2D_detail->Total_Jumlah->setFormValue($objForm->GetValue("x_Total_Jumlah"));
		$pembelian_2D_detail->ID->setFormValue($objForm->GetValue("x_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $pembelian_2D_detail;
		$pembelian_2D_detail->ID->CurrentValue = $pembelian_2D_detail->ID->FormValue;
		$this->LoadRow();
		$pembelian_2D_detail->Kode->CurrentValue = $pembelian_2D_detail->Kode->FormValue;
		$pembelian_2D_detail->Nama_Barang->CurrentValue = $pembelian_2D_detail->Nama_Barang->FormValue;
		$pembelian_2D_detail->Satuan->CurrentValue = $pembelian_2D_detail->Satuan->FormValue;
		$pembelian_2D_detail->Harga_Beli->CurrentValue = $pembelian_2D_detail->Harga_Beli->FormValue;
		$pembelian_2D_detail->Jumlah->CurrentValue = $pembelian_2D_detail->Jumlah->FormValue;
		$pembelian_2D_detail->Total_Jumlah->CurrentValue = $pembelian_2D_detail->Total_Jumlah->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $pembelian_2D_detail;
		$sFilter = $pembelian_2D_detail->KeyFilter();

		// Call Row Selecting event
		$pembelian_2D_detail->Row_Selecting($sFilter);

		// Load SQL based on filter
		$pembelian_2D_detail->CurrentFilter = $sFilter;
		$sSql = $pembelian_2D_detail->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$pembelian_2D_detail->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $pembelian_2D_detail;
		$pembelian_2D_detail->ID->setDbValue($rs->fields('ID'));
		$pembelian_2D_detail->Kode->setDbValue($rs->fields('Kode'));
		if (array_key_exists('EV__Kode', $rs->fields)) {
			$pembelian_2D_detail->Kode->VirtualValue = $rs->fields('EV__Kode'); // Set up virtual field value
		} else {
			$pembelian_2D_detail->Kode->VirtualValue = ""; // Clear value
		}
		$pembelian_2D_detail->Nama_Barang->setDbValue($rs->fields('Nama Barang'));
		$pembelian_2D_detail->Isi->setDbValue($rs->fields('Isi'));
		$pembelian_2D_detail->Satuan->setDbValue($rs->fields('Satuan'));
		$pembelian_2D_detail->Harga_Beli->setDbValue($rs->fields('Harga Beli'));
		$pembelian_2D_detail->Jumlah->setDbValue($rs->fields('Jumlah'));
		$pembelian_2D_detail->Total_Jumlah->setDbValue($rs->fields('Total Jumlah'));
		$pembelian_2D_detail->Berat->setDbValue($rs->fields('Berat'));
		$pembelian_2D_detail->Diskon->setDbValue($rs->fields('Diskon'));
		$pembelian_2D_detail->Total_HP->setDbValue($rs->fields('Total HP'));
		$pembelian_2D_detail->Retur->setDbValue($rs->fields('Retur'));
		$pembelian_2D_detail->User->setDbValue($rs->fields('User'));
		$pembelian_2D_detail->Waktu->setDbValue($rs->fields('Waktu'));
		$pembelian_2D_detail->Stamp->setDbValue($rs->fields('Stamp'));
		$pembelian_2D_detail->IDM->setDbValue($rs->fields('IDM'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $pembelian_2D_detail;

		// Initialize URLs
		// Call Row_Rendering event

		$pembelian_2D_detail->Row_Rendering();

		// Common render codes for all row types
		// Kode

		$pembelian_2D_detail->Kode->CellCssStyle = ""; $pembelian_2D_detail->Kode->CellCssClass = "";
		$pembelian_2D_detail->Kode->CellAttrs = array(); $pembelian_2D_detail->Kode->ViewAttrs = array(); $pembelian_2D_detail->Kode->EditAttrs = array();

		// Nama Barang
		$pembelian_2D_detail->Nama_Barang->CellCssStyle = ""; $pembelian_2D_detail->Nama_Barang->CellCssClass = "";
		$pembelian_2D_detail->Nama_Barang->CellAttrs = array(); $pembelian_2D_detail->Nama_Barang->ViewAttrs = array(); $pembelian_2D_detail->Nama_Barang->EditAttrs = array();

		// Satuan
		$pembelian_2D_detail->Satuan->CellCssStyle = ""; $pembelian_2D_detail->Satuan->CellCssClass = "";
		$pembelian_2D_detail->Satuan->CellAttrs = array(); $pembelian_2D_detail->Satuan->ViewAttrs = array(); $pembelian_2D_detail->Satuan->EditAttrs = array();

		// Harga Beli
		$pembelian_2D_detail->Harga_Beli->CellCssStyle = ""; $pembelian_2D_detail->Harga_Beli->CellCssClass = "";
		$pembelian_2D_detail->Harga_Beli->CellAttrs = array(); $pembelian_2D_detail->Harga_Beli->ViewAttrs = array(); $pembelian_2D_detail->Harga_Beli->EditAttrs = array();

		// Jumlah
		$pembelian_2D_detail->Jumlah->CellCssStyle = ""; $pembelian_2D_detail->Jumlah->CellCssClass = "";
		$pembelian_2D_detail->Jumlah->CellAttrs = array(); $pembelian_2D_detail->Jumlah->ViewAttrs = array(); $pembelian_2D_detail->Jumlah->EditAttrs = array();

		// Total Jumlah
		$pembelian_2D_detail->Total_Jumlah->CellCssStyle = ""; $pembelian_2D_detail->Total_Jumlah->CellCssClass = "";
		$pembelian_2D_detail->Total_Jumlah->CellAttrs = array(); $pembelian_2D_detail->Total_Jumlah->ViewAttrs = array(); $pembelian_2D_detail->Total_Jumlah->EditAttrs = array();
		if ($pembelian_2D_detail->RowType == EW_ROWTYPE_VIEW) { // View row

			// Kode
			if ($pembelian_2D_detail->Kode->VirtualValue <> "") {
				$pembelian_2D_detail->Kode->ViewValue = $pembelian_2D_detail->Kode->VirtualValue;
			} else {
			if (strval($pembelian_2D_detail->Kode->CurrentValue) <> "") {
				$sFilterWrk = "`Kode` = '" . ew_AdjustSql($pembelian_2D_detail->Kode->CurrentValue) . "'";
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
					$pembelian_2D_detail->Kode->ViewValue = $rswrk->fields('Kode');
					$pembelian_2D_detail->Kode->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('Nama Barang');
					$rswrk->Close();
				} else {
					$pembelian_2D_detail->Kode->ViewValue = $pembelian_2D_detail->Kode->CurrentValue;
				}
			} else {
				$pembelian_2D_detail->Kode->ViewValue = NULL;
			}
			}
			$pembelian_2D_detail->Kode->CssStyle = "";
			$pembelian_2D_detail->Kode->CssClass = "";
			$pembelian_2D_detail->Kode->ViewCustomAttributes = "";

			// Nama Barang
			$pembelian_2D_detail->Nama_Barang->ViewValue = $pembelian_2D_detail->Nama_Barang->CurrentValue;
			$pembelian_2D_detail->Nama_Barang->CssStyle = "";
			$pembelian_2D_detail->Nama_Barang->CssClass = "";
			$pembelian_2D_detail->Nama_Barang->ViewCustomAttributes = "";

			// Satuan
			$pembelian_2D_detail->Satuan->ViewValue = $pembelian_2D_detail->Satuan->CurrentValue;
			$pembelian_2D_detail->Satuan->CssStyle = "";
			$pembelian_2D_detail->Satuan->CssClass = "";
			$pembelian_2D_detail->Satuan->ViewCustomAttributes = "";

			// Harga Beli
			$pembelian_2D_detail->Harga_Beli->ViewValue = $pembelian_2D_detail->Harga_Beli->CurrentValue;
			$pembelian_2D_detail->Harga_Beli->ViewValue = ew_FormatNumber($pembelian_2D_detail->Harga_Beli->ViewValue, 0, -2, -2, -2);
			$pembelian_2D_detail->Harga_Beli->CssStyle = "text-align:right;";
			$pembelian_2D_detail->Harga_Beli->CssClass = "";
			$pembelian_2D_detail->Harga_Beli->ViewCustomAttributes = "";

			// Jumlah
			$pembelian_2D_detail->Jumlah->ViewValue = $pembelian_2D_detail->Jumlah->CurrentValue;
			$pembelian_2D_detail->Jumlah->CssStyle = "text-align:center;";
			$pembelian_2D_detail->Jumlah->CssClass = "";
			$pembelian_2D_detail->Jumlah->ViewCustomAttributes = "";

			// Total Jumlah
			$pembelian_2D_detail->Total_Jumlah->ViewValue = $pembelian_2D_detail->Total_Jumlah->CurrentValue;
			$pembelian_2D_detail->Total_Jumlah->CssStyle = "";
			$pembelian_2D_detail->Total_Jumlah->CssClass = "";
			$pembelian_2D_detail->Total_Jumlah->ViewCustomAttributes = "";

			// Total HP
			$pembelian_2D_detail->Total_HP->ViewValue = $pembelian_2D_detail->Total_HP->CurrentValue;
			$pembelian_2D_detail->Total_HP->ViewValue = ew_FormatNumber($pembelian_2D_detail->Total_HP->ViewValue, 0, -2, -2, -2);
			$pembelian_2D_detail->Total_HP->CssStyle = "text-align:right;";
			$pembelian_2D_detail->Total_HP->CssClass = "";
			$pembelian_2D_detail->Total_HP->ViewCustomAttributes = "";

			// Kode
			$pembelian_2D_detail->Kode->HrefValue = "";
			$pembelian_2D_detail->Kode->TooltipValue = "";

			// Nama Barang
			$pembelian_2D_detail->Nama_Barang->HrefValue = "";
			$pembelian_2D_detail->Nama_Barang->TooltipValue = "";

			// Satuan
			$pembelian_2D_detail->Satuan->HrefValue = "";
			$pembelian_2D_detail->Satuan->TooltipValue = "";

			// Harga Beli
			$pembelian_2D_detail->Harga_Beli->HrefValue = "";
			$pembelian_2D_detail->Harga_Beli->TooltipValue = "";

			// Jumlah
			$pembelian_2D_detail->Jumlah->HrefValue = "";
			$pembelian_2D_detail->Jumlah->TooltipValue = "";

			// Total Jumlah
			$pembelian_2D_detail->Total_Jumlah->HrefValue = "";
			$pembelian_2D_detail->Total_Jumlah->TooltipValue = "";
		} elseif ($pembelian_2D_detail->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Kode
			$pembelian_2D_detail->Kode->EditCustomAttributes = "";
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
			$pembelian_2D_detail->Kode->EditValue = $arwrk;

			// Nama Barang
			$pembelian_2D_detail->Nama_Barang->EditCustomAttributes = "";
			$pembelian_2D_detail->Nama_Barang->EditValue = ew_HtmlEncode($pembelian_2D_detail->Nama_Barang->CurrentValue);

			// Satuan
			$pembelian_2D_detail->Satuan->EditCustomAttributes = "";
			$pembelian_2D_detail->Satuan->EditValue = ew_HtmlEncode($pembelian_2D_detail->Satuan->CurrentValue);

			// Harga Beli
			$pembelian_2D_detail->Harga_Beli->EditCustomAttributes = "";
			$pembelian_2D_detail->Harga_Beli->EditValue = ew_HtmlEncode($pembelian_2D_detail->Harga_Beli->CurrentValue);

			// Jumlah
			$pembelian_2D_detail->Jumlah->EditCustomAttributes = "";
			$pembelian_2D_detail->Jumlah->EditValue = ew_HtmlEncode($pembelian_2D_detail->Jumlah->CurrentValue);

			// Total Jumlah
			$pembelian_2D_detail->Total_Jumlah->EditCustomAttributes = "";
			$pembelian_2D_detail->Total_Jumlah->EditValue = ew_HtmlEncode($pembelian_2D_detail->Total_Jumlah->CurrentValue);

			// Edit refer script
			// Kode

			$pembelian_2D_detail->Kode->HrefValue = "";

			// Nama Barang
			$pembelian_2D_detail->Nama_Barang->HrefValue = "";

			// Satuan
			$pembelian_2D_detail->Satuan->HrefValue = "";

			// Harga Beli
			$pembelian_2D_detail->Harga_Beli->HrefValue = "";

			// Jumlah
			$pembelian_2D_detail->Jumlah->HrefValue = "";

			// Total Jumlah
			$pembelian_2D_detail->Total_Jumlah->HrefValue = "";
		}

		// Call Row Rendered event
		if ($pembelian_2D_detail->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$pembelian_2D_detail->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $pembelian_2D_detail;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($pembelian_2D_detail->Kode->FormValue) && $pembelian_2D_detail->Kode->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $pembelian_2D_detail->Kode->FldCaption();
		}
		if (!is_null($pembelian_2D_detail->Nama_Barang->FormValue) && $pembelian_2D_detail->Nama_Barang->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $pembelian_2D_detail->Nama_Barang->FldCaption();
		}
		if (!is_null($pembelian_2D_detail->Satuan->FormValue) && $pembelian_2D_detail->Satuan->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $pembelian_2D_detail->Satuan->FldCaption();
		}
		if (!is_null($pembelian_2D_detail->Harga_Beli->FormValue) && $pembelian_2D_detail->Harga_Beli->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $pembelian_2D_detail->Harga_Beli->FldCaption();
		}
		if (!ew_CheckInteger($pembelian_2D_detail->Harga_Beli->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $pembelian_2D_detail->Harga_Beli->FldErrMsg();
		}
		if (!is_null($pembelian_2D_detail->Jumlah->FormValue) && $pembelian_2D_detail->Jumlah->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $pembelian_2D_detail->Jumlah->FldCaption();
		}
		if (!ew_CheckNumber($pembelian_2D_detail->Jumlah->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $pembelian_2D_detail->Jumlah->FldErrMsg();
		}
		if (!is_null($pembelian_2D_detail->Total_Jumlah->FormValue) && $pembelian_2D_detail->Total_Jumlah->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $pembelian_2D_detail->Total_Jumlah->FldCaption();
		}
		if (!ew_CheckNumber($pembelian_2D_detail->Total_Jumlah->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $pembelian_2D_detail->Total_Jumlah->FldErrMsg();
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
		global $conn, $Security, $Language, $pembelian_2D_detail;
		$sFilter = $pembelian_2D_detail->KeyFilter();
		$pembelian_2D_detail->CurrentFilter = $sFilter;
		$sSql = $pembelian_2D_detail->SQL();
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
			$pembelian_2D_detail->Kode->SetDbValueDef($rsnew, $pembelian_2D_detail->Kode->CurrentValue, "", FALSE);

			// Nama Barang
			$pembelian_2D_detail->Nama_Barang->SetDbValueDef($rsnew, $pembelian_2D_detail->Nama_Barang->CurrentValue, "", FALSE);

			// Satuan
			$pembelian_2D_detail->Satuan->SetDbValueDef($rsnew, $pembelian_2D_detail->Satuan->CurrentValue, "", FALSE);

			// Harga Beli
			$pembelian_2D_detail->Harga_Beli->SetDbValueDef($rsnew, $pembelian_2D_detail->Harga_Beli->CurrentValue, 0, FALSE);

			// Jumlah
			$pembelian_2D_detail->Jumlah->SetDbValueDef($rsnew, $pembelian_2D_detail->Jumlah->CurrentValue, 0, FALSE);

			// Total Jumlah
			$pembelian_2D_detail->Total_Jumlah->SetDbValueDef($rsnew, $pembelian_2D_detail->Total_Jumlah->CurrentValue, 0, FALSE);

			// Call Row Updating event
			$bUpdateRow = $pembelian_2D_detail->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($pembelian_2D_detail->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($pembelian_2D_detail->CancelMessage <> "") {
					$this->setMessage($pembelian_2D_detail->CancelMessage);
					$pembelian_2D_detail->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$pembelian_2D_detail->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterDetail() {
		global $pembelian_2D_detail;
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = "";
				$this->sDbDetailFilter = "";
			}
			if ($sMasterTblVar == "pembelian_2D_master") {
				$bValidMaster = TRUE;
				$this->sDbMasterFilter = $pembelian_2D_detail->SqlMasterFilter_pembelian_2D_master();
				$this->sDbDetailFilter = $pembelian_2D_detail->SqlDetailFilter_pembelian_2D_master();
				if (@$_GET["ID"] <> "") {
					$GLOBALS["pembelian_2D_master"]->ID->setQueryStringValue($_GET["ID"]);
					$pembelian_2D_detail->IDM->setQueryStringValue($GLOBALS["pembelian_2D_master"]->ID->QueryStringValue);
					$pembelian_2D_detail->IDM->setSessionValue($pembelian_2D_detail->IDM->QueryStringValue);
					if (!is_numeric($GLOBALS["pembelian_2D_master"]->ID->QueryStringValue)) $bValidMaster = FALSE;
					$this->sDbMasterFilter = str_replace("@ID@", ew_AdjustSql($GLOBALS["pembelian_2D_master"]->ID->QueryStringValue), $this->sDbMasterFilter);
					$this->sDbDetailFilter = str_replace("@IDM@", ew_AdjustSql($GLOBALS["pembelian_2D_master"]->ID->QueryStringValue), $this->sDbDetailFilter);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$pembelian_2D_detail->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->lStartRec = 1;
			$pembelian_2D_detail->setStartRecordNumber($this->lStartRec);
			$pembelian_2D_detail->setMasterFilter($this->sDbMasterFilter); // Set up master filter
			$pembelian_2D_detail->setDetailFilter($this->sDbDetailFilter); // Set up detail filter

			// Clear previous master key from Session
			if ($sMasterTblVar <> "pembelian_2D_master") {
				if ($pembelian_2D_detail->IDM->QueryStringValue == "") $pembelian_2D_detail->IDM->setSessionValue("");
			}
		} else {
			$this->sDbMasterFilter = $pembelian_2D_detail->getMasterFilter(); //  Restore master filter
			$this->sDbDetailFilter = $pembelian_2D_detail->getDetailFilter(); // Restore detail filter
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

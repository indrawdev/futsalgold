<?php

// Global variable for table object
$Rekapitulasi_Penjualan = NULL;

//
// Table class for Rekapitulasi Penjualan
//
class cRekapitulasi_Penjualan extends cTable {
	var $ID;
	var $Tgl;
	var $No_Faktur;
	var $TotHPokok;
	var $TotHJual;
	var $Disk2E_25;
	var $Grand_Total;
	var $Laba;
	var $Kode_Pelanggan;
	var $Kode_Kasir;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'Rekapitulasi_Penjualan';
		$this->TableName = 'Rekapitulasi Penjualan';
		$this->TableType = 'CUSTOMVIEW';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// ID
		$this->ID = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_ID', 'ID', '`penjualan - master`.ID', '`penjualan - master`.ID', 3, -1, FALSE, '`penjualan - master`.ID', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ID'] = &$this->ID;

		// Tgl
		$this->Tgl = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_Tgl', 'Tgl', '`penjualan - master`.Tgl', 'DATE_FORMAT(`penjualan - master`.Tgl, \'%d/%m/%Y\')', 133, 7, FALSE, '`penjualan - master`.Tgl', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Tgl->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Tgl'] = &$this->Tgl;

		// No Faktur
		$this->No_Faktur = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_No_Faktur', 'No Faktur', '`penjualan - master`.`No Faktur`', '`penjualan - master`.`No Faktur`', 200, -1, FALSE, '`penjualan - master`.`No Faktur`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['No Faktur'] = &$this->No_Faktur;

		// TotHPokok
		$this->TotHPokok = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_TotHPokok', 'TotHPokok', '`penjualan - master`.`Total HP`', '`penjualan - master`.`Total HP`', 3, -1, FALSE, '`penjualan - master`.`Total HP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->TotHPokok->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['TotHPokok'] = &$this->TotHPokok;

		// TotHJual
		$this->TotHJual = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_TotHJual', 'TotHJual', '`penjualan - master`.`Total HJ`', '`penjualan - master`.`Total HJ`', 3, -1, FALSE, '`penjualan - master`.`Total HJ`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->TotHJual->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['TotHJual'] = &$this->TotHJual;

		// Disk. %
		$this->Disk2E_25 = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_Disk2E_25', 'Disk. %', '`penjualan - master`.Diskon', '`penjualan - master`.Diskon', 5, -1, FALSE, '`penjualan - master`.Diskon', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Disk2E_25->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Disk. %'] = &$this->Disk2E_25;

		// Grand Total
		$this->Grand_Total = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_Grand_Total', 'Grand Total', '`penjualan - master`.`Grand Total`', '`penjualan - master`.`Grand Total`', 3, -1, FALSE, '`penjualan - master`.`Grand Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Grand_Total->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Grand Total'] = &$this->Grand_Total;

		// Laba
		$this->Laba = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_Laba', 'Laba', '`penjualan - master`.Laba', '`penjualan - master`.Laba', 3, -1, FALSE, '`penjualan - master`.Laba', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Laba->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Laba'] = &$this->Laba;

		// Kode Pelanggan
		$this->Kode_Pelanggan = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_Kode_Pelanggan', 'Kode Pelanggan', '`penjualan - master`.`Kode Pelanggan`', '`penjualan - master`.`Kode Pelanggan`', 200, -1, FALSE, '`penjualan - master`.`Kode Pelanggan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode Pelanggan'] = &$this->Kode_Pelanggan;

		// Kode Kasir
		$this->Kode_Kasir = new cField('Rekapitulasi_Penjualan', 'Rekapitulasi Penjualan', 'x_Kode_Kasir', 'Kode Kasir', '`penjualan - master`.`Kode Kasir`', '`penjualan - master`.`Kode Kasir`', 200, -1, FALSE, '`penjualan - master`.`Kode Kasir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode Kasir'] = &$this->Kode_Kasir;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`penjualan - master`";
	}

	function SqlSelect() { // Select
		return "SELECT `penjualan - master`.ID, `penjualan - master`.Tgl, `penjualan - master`.`No Faktur`, `penjualan - master`.`Total HP` AS `TotHPokok`, `penjualan - master`.`Total HJ` AS `TotHJual`, `penjualan - master`.Diskon AS `Disk. %`, `penjualan - master`.`Grand Total` AS `Grand Total`, `penjualan - master`.Laba, `penjualan - master`.`Kode Pelanggan`, `penjualan - master`.`Kode Kasir` FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "`penjualan - master`.ID DESC";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 8) == 8);
			case "search":
				return (($allow & 8) == 8);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`penjualan - master`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "Rekapitulasi_Penjualanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "Rekapitulasi_Penjualanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("Rekapitulasi_Penjualanview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("Rekapitulasi_Penjualanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "Rekapitulasi_Penjualanadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("Rekapitulasi_Penjualanedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("Rekapitulasi_Penjualanadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("Rekapitulasi_Penjualandelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->ID->setDbValue($rs->fields('ID'));
		$this->Tgl->setDbValue($rs->fields('Tgl'));
		$this->No_Faktur->setDbValue($rs->fields('No Faktur'));
		$this->TotHPokok->setDbValue($rs->fields('TotHPokok'));
		$this->TotHJual->setDbValue($rs->fields('TotHJual'));
		$this->Disk2E_25->setDbValue($rs->fields('Disk. %'));
		$this->Grand_Total->setDbValue($rs->fields('Grand Total'));
		$this->Laba->setDbValue($rs->fields('Laba'));
		$this->Kode_Pelanggan->setDbValue($rs->fields('Kode Pelanggan'));
		$this->Kode_Kasir->setDbValue($rs->fields('Kode Kasir'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// ID

		$this->ID->CellCssStyle = "white-space: nowrap;";

		// Tgl
		// No Faktur
		// TotHPokok
		// TotHJual
		// Disk. %
		// Grand Total
		// Laba

		$this->Laba->CellCssStyle = "white-space: nowrap;";

		// Kode Pelanggan
		// Kode Kasir
		// ID

		$this->ID->ViewValue = $this->ID->CurrentValue;
		$this->ID->ViewCustomAttributes = "";

		// Tgl
		$this->Tgl->ViewValue = $this->Tgl->CurrentValue;
		$this->Tgl->ViewValue = ew_FormatDateTime($this->Tgl->ViewValue, 7);
		$this->Tgl->ViewCustomAttributes = "";

		// No Faktur
		$this->No_Faktur->ViewValue = $this->No_Faktur->CurrentValue;
		$this->No_Faktur->CssStyle = "font-weight: bold;";
		$this->No_Faktur->CellCssStyle .= "text-align: center;";
		$this->No_Faktur->ViewCustomAttributes = "";

		// TotHPokok
		$this->TotHPokok->ViewValue = $this->TotHPokok->CurrentValue;
		$this->TotHPokok->CellCssStyle .= "text-align: right;";
		$this->TotHPokok->ViewCustomAttributes = "";

		// TotHJual
		$this->TotHJual->ViewValue = $this->TotHJual->CurrentValue;
		$this->TotHJual->CellCssStyle .= "text-align: right;";
		$this->TotHJual->ViewCustomAttributes = "";

		// Disk. %
		$this->Disk2E_25->ViewValue = $this->Disk2E_25->CurrentValue;
		$this->Disk2E_25->CellCssStyle .= "text-align: center;";
		$this->Disk2E_25->ViewCustomAttributes = "";

		// Grand Total
		$this->Grand_Total->ViewValue = $this->Grand_Total->CurrentValue;
		$this->Grand_Total->ViewValue = ew_FormatNumber($this->Grand_Total->ViewValue, 0, -2, -2, -2);
		$this->Grand_Total->CellCssStyle .= "text-align: right;";
		$this->Grand_Total->ViewCustomAttributes = "";

		// Laba
		$this->Laba->ViewValue = $this->Laba->CurrentValue;
		$this->Laba->ViewValue = ew_FormatNumber($this->Laba->ViewValue, 0, -2, -2, -2);
		$this->Laba->CellCssStyle .= "text-align: right;";
		$this->Laba->ViewCustomAttributes = "";

		// Kode Pelanggan
		if (strval($this->Kode_Pelanggan->CurrentValue) <> "") {
			$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode_Pelanggan->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaPenyewa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar pelanggan`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->Kode_Pelanggan, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Kode_Pelanggan->ViewValue = $rswrk->fields('DispFld');
				$this->Kode_Pelanggan->ViewValue .= ew_ValueSeparator(1,$this->Kode_Pelanggan) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->Kode_Pelanggan->ViewValue = $this->Kode_Pelanggan->CurrentValue;
			}
		} else {
			$this->Kode_Pelanggan->ViewValue = NULL;
		}
		$this->Kode_Pelanggan->ViewCustomAttributes = "";

		// Kode Kasir
		if (strval($this->Kode_Kasir->CurrentValue) <> "") {
			$sFilterWrk = "`Username`" . ew_SearchString("=", $this->Kode_Kasir->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Username`, `Username` AS `DispFld`, `Nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `2padmin`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->Kode_Kasir, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Username` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Kode_Kasir->ViewValue = $rswrk->fields('DispFld');
				$this->Kode_Kasir->ViewValue .= ew_ValueSeparator(1,$this->Kode_Kasir) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->Kode_Kasir->ViewValue = $this->Kode_Kasir->CurrentValue;
			}
		} else {
			$this->Kode_Kasir->ViewValue = NULL;
		}
		$this->Kode_Kasir->ViewCustomAttributes = "";

		// ID
		$this->ID->LinkCustomAttributes = "";
		$this->ID->HrefValue = "";
		$this->ID->TooltipValue = "";

		// Tgl
		$this->Tgl->LinkCustomAttributes = "";
		$this->Tgl->HrefValue = "";
		$this->Tgl->TooltipValue = "";

		// No Faktur
		$this->No_Faktur->LinkCustomAttributes = "";
		if (!ew_Empty($this->ID->CurrentValue)) {
			$this->No_Faktur->HrefValue = "penjualan_2D_detaillist.php?showmaster=penjualan_2D_master&ID=" . ((!empty($this->ID->ViewValue)) ? $this->ID->ViewValue : $this->ID->CurrentValue); // Add prefix/suffix
			$this->No_Faktur->LinkAttrs["target"] = "_blank"; // Add target
			if ($this->Export <> "") $this->No_Faktur->HrefValue = ew_ConvertFullUrl($this->No_Faktur->HrefValue);
		} else {
			$this->No_Faktur->HrefValue = "";
		}
		$this->No_Faktur->TooltipValue = "";

		// TotHPokok
		$this->TotHPokok->LinkCustomAttributes = "";
		$this->TotHPokok->HrefValue = "";
		$this->TotHPokok->TooltipValue = "";

		// TotHJual
		$this->TotHJual->LinkCustomAttributes = "";
		$this->TotHJual->HrefValue = "";
		$this->TotHJual->TooltipValue = "";

		// Disk. %
		$this->Disk2E_25->LinkCustomAttributes = "";
		$this->Disk2E_25->HrefValue = "";
		$this->Disk2E_25->TooltipValue = "";

		// Grand Total
		$this->Grand_Total->LinkCustomAttributes = "";
		$this->Grand_Total->HrefValue = "";
		$this->Grand_Total->TooltipValue = "";

		// Laba
		$this->Laba->LinkCustomAttributes = "";
		$this->Laba->HrefValue = "";
		$this->Laba->TooltipValue = "";

		// Kode Pelanggan
		$this->Kode_Pelanggan->LinkCustomAttributes = "";
		$this->Kode_Pelanggan->HrefValue = "";
		$this->Kode_Pelanggan->TooltipValue = "";

		// Kode Kasir
		$this->Kode_Kasir->LinkCustomAttributes = "";
		$this->Kode_Kasir->HrefValue = "";
		$this->Kode_Kasir->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			if (is_numeric($this->Grand_Total->CurrentValue))
				$this->Grand_Total->Total += $this->Grand_Total->CurrentValue; // Accumulate total
			if (is_numeric($this->Laba->CurrentValue))
				$this->Laba->Total += $this->Laba->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->Grand_Total->CurrentValue = $this->Grand_Total->Total;
			$this->Grand_Total->ViewValue = $this->Grand_Total->CurrentValue;
			$this->Grand_Total->ViewValue = ew_FormatNumber($this->Grand_Total->ViewValue, 0, -2, -2, -2);
			$this->Grand_Total->CellCssStyle .= "text-align: right;";
			$this->Grand_Total->ViewCustomAttributes = "";
			$this->Grand_Total->HrefValue = ""; // Clear href value
			$this->Laba->CurrentValue = $this->Laba->Total;
			$this->Laba->ViewValue = $this->Laba->CurrentValue;
			$this->Laba->ViewValue = ew_FormatNumber($this->Laba->ViewValue, 0, -2, -2, -2);
			$this->Laba->CellCssStyle .= "text-align: right;";
			$this->Laba->ViewCustomAttributes = "";
			$this->Laba->HrefValue = ""; // Clear href value
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				if ($this->Tgl->Exportable) $Doc->ExportCaption($this->Tgl);
				if ($this->No_Faktur->Exportable) $Doc->ExportCaption($this->No_Faktur);
				if ($this->TotHPokok->Exportable) $Doc->ExportCaption($this->TotHPokok);
				if ($this->TotHJual->Exportable) $Doc->ExportCaption($this->TotHJual);
				if ($this->Disk2E_25->Exportable) $Doc->ExportCaption($this->Disk2E_25);
				if ($this->Grand_Total->Exportable) $Doc->ExportCaption($this->Grand_Total);
				if ($this->Kode_Pelanggan->Exportable) $Doc->ExportCaption($this->Kode_Pelanggan);
				if ($this->Kode_Kasir->Exportable) $Doc->ExportCaption($this->Kode_Kasir);
			} else {
				if ($this->Tgl->Exportable) $Doc->ExportCaption($this->Tgl);
				if ($this->No_Faktur->Exportable) $Doc->ExportCaption($this->No_Faktur);
				if ($this->TotHPokok->Exportable) $Doc->ExportCaption($this->TotHPokok);
				if ($this->TotHJual->Exportable) $Doc->ExportCaption($this->TotHJual);
				if ($this->Disk2E_25->Exportable) $Doc->ExportCaption($this->Disk2E_25);
				if ($this->Grand_Total->Exportable) $Doc->ExportCaption($this->Grand_Total);
				if ($this->Laba->Exportable) $Doc->ExportCaption($this->Laba);
				if ($this->Kode_Pelanggan->Exportable) $Doc->ExportCaption($this->Kode_Pelanggan);
				if ($this->Kode_Kasir->Exportable) $Doc->ExportCaption($this->Kode_Kasir);
			}
			$Doc->EndExportRow();
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);
				$this->AggregateListRowValues(); // Aggregate row values

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->Tgl->Exportable) $Doc->ExportField($this->Tgl);
					if ($this->No_Faktur->Exportable) $Doc->ExportField($this->No_Faktur);
					if ($this->TotHPokok->Exportable) $Doc->ExportField($this->TotHPokok);
					if ($this->TotHJual->Exportable) $Doc->ExportField($this->TotHJual);
					if ($this->Disk2E_25->Exportable) $Doc->ExportField($this->Disk2E_25);
					if ($this->Grand_Total->Exportable) $Doc->ExportField($this->Grand_Total);
					if ($this->Kode_Pelanggan->Exportable) $Doc->ExportField($this->Kode_Pelanggan);
					if ($this->Kode_Kasir->Exportable) $Doc->ExportField($this->Kode_Kasir);
				} else {
					if ($this->Tgl->Exportable) $Doc->ExportField($this->Tgl);
					if ($this->No_Faktur->Exportable) $Doc->ExportField($this->No_Faktur);
					if ($this->TotHPokok->Exportable) $Doc->ExportField($this->TotHPokok);
					if ($this->TotHJual->Exportable) $Doc->ExportField($this->TotHJual);
					if ($this->Disk2E_25->Exportable) $Doc->ExportField($this->Disk2E_25);
					if ($this->Grand_Total->Exportable) $Doc->ExportField($this->Grand_Total);
					if ($this->Laba->Exportable) $Doc->ExportField($this->Laba);
					if ($this->Kode_Pelanggan->Exportable) $Doc->ExportField($this->Kode_Pelanggan);
					if ($this->Kode_Kasir->Exportable) $Doc->ExportField($this->Kode_Kasir);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}

		// Export aggregates (horizontal format only)
		if ($Doc->Horizontal) {
			$this->RowType = EW_ROWTYPE_AGGREGATE;
			$this->ResetAttrs();
			$this->AggregateListRow();
			$Doc->BeginExportRow(-1);
			$Doc->ExportAggregate($this->Tgl, '');
			$Doc->ExportAggregate($this->No_Faktur, '');
			$Doc->ExportAggregate($this->TotHPokok, '');
			$Doc->ExportAggregate($this->TotHJual, '');
			$Doc->ExportAggregate($this->Disk2E_25, '');
			$Doc->ExportAggregate($this->Grand_Total, 'TOTAL');
			$Doc->ExportAggregate($this->Laba, 'TOTAL');
			$Doc->ExportAggregate($this->Kode_Pelanggan, '');
			$Doc->ExportAggregate($this->Kode_Kasir, '');
			$Doc->EndExportRow();
		}
		$Doc->ExportTableFooter();
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

		$this->TotHPokok->ViewValue = number_format($this->TotHPokok->ViewValue);    
		$this->TotHJual->ViewValue = number_format($this->TotHJual->ViewValue); 
		$this->Grand_Total->ViewValue = number_format($this->Grand_Total->ViewValue);    
		$this->Laba->ViewValue = number_format($this->Laba->ViewValue); 
	}                                          

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>

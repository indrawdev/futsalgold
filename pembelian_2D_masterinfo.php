<?php

// Global variable for table object
$pembelian_2D_master = NULL;

//
// Table class for pembelian - master
//
class cpembelian_2D_master extends cTable {
	var $ID;
	var $Tgl;
	var $Faktur;
	var $No_Faktur;
	var $Diskon;
	var $Ppn;
	var $Ongkir;
	var $Paking;
	var $Lain_2D_lain;
	var $Hutang;
	var $Total_Berat;
	var $Total_HP;
	var $Total_HJ;
	var $Grand_Total;
	var $Dibayar;
	var $Kembali;
	var $SisaDibayar;
	var $Kode_Kasir;
	var $Nama_Kasir;
	var $Kode_Supplier;
	var $Nama_Supplier;
	var $Nama_Form;
	var $No;
	var $Waktu;
	var $Stamp;
	var $Hitung;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pembelian_2D_master';
		$this->TableName = 'pembelian - master';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// ID
		$this->ID = new cField('pembelian_2D_master', 'pembelian - master', 'x_ID', 'ID', '`ID`', '`ID`', 3, -1, FALSE, '`ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ID'] = &$this->ID;

		// Tgl
		$this->Tgl = new cField('pembelian_2D_master', 'pembelian - master', 'x_Tgl', 'Tgl', '`Tgl`', 'DATE_FORMAT(`Tgl`, \'%d/%m/%Y\')', 133, 7, FALSE, '`Tgl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Tgl->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Tgl'] = &$this->Tgl;

		// Faktur
		$this->Faktur = new cField('pembelian_2D_master', 'pembelian - master', 'x_Faktur', 'Faktur', '`Faktur`', '`Faktur`', 200, -1, FALSE, '`Faktur`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Faktur'] = &$this->Faktur;

		// No Faktur
		$this->No_Faktur = new cField('pembelian_2D_master', 'pembelian - master', 'x_No_Faktur', 'No Faktur', '`No Faktur`', '`No Faktur`', 200, -1, FALSE, '`No Faktur`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['No Faktur'] = &$this->No_Faktur;

		// Diskon
		$this->Diskon = new cField('pembelian_2D_master', 'pembelian - master', 'x_Diskon', 'Diskon', '`Diskon`', '`Diskon`', 5, -1, FALSE, '`Diskon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Diskon->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Diskon'] = &$this->Diskon;

		// Ppn
		$this->Ppn = new cField('pembelian_2D_master', 'pembelian - master', 'x_Ppn', 'Ppn', '`Ppn`', '`Ppn`', 3, -1, FALSE, '`Ppn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Ppn->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Ppn'] = &$this->Ppn;

		// Ongkir
		$this->Ongkir = new cField('pembelian_2D_master', 'pembelian - master', 'x_Ongkir', 'Ongkir', '`Ongkir`', '`Ongkir`', 3, -1, FALSE, '`Ongkir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Ongkir->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Ongkir'] = &$this->Ongkir;

		// Paking
		$this->Paking = new cField('pembelian_2D_master', 'pembelian - master', 'x_Paking', 'Paking', '`Paking`', '`Paking`', 3, -1, FALSE, '`Paking`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Paking->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Paking'] = &$this->Paking;

		// Lain - lain
		$this->Lain_2D_lain = new cField('pembelian_2D_master', 'pembelian - master', 'x_Lain_2D_lain', 'Lain - lain', '`Lain - lain`', '`Lain - lain`', 3, -1, FALSE, '`Lain - lain`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Lain_2D_lain->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Lain - lain'] = &$this->Lain_2D_lain;

		// Hutang
		$this->Hutang = new cField('pembelian_2D_master', 'pembelian - master', 'x_Hutang', 'Hutang', '`Hutang`', '`Hutang`', 3, -1, FALSE, '`Hutang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Hutang->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Hutang'] = &$this->Hutang;

		// Total Berat
		$this->Total_Berat = new cField('pembelian_2D_master', 'pembelian - master', 'x_Total_Berat', 'Total Berat', '`Total Berat`', '`Total Berat`', 5, -1, FALSE, '`Total Berat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Total_Berat->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Total Berat'] = &$this->Total_Berat;

		// Total HP
		$this->Total_HP = new cField('pembelian_2D_master', 'pembelian - master', 'x_Total_HP', 'Total HP', '`Total HP`', '`Total HP`', 3, -1, FALSE, '`Total HP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Total_HP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Total HP'] = &$this->Total_HP;

		// Total HJ
		$this->Total_HJ = new cField('pembelian_2D_master', 'pembelian - master', 'x_Total_HJ', 'Total HJ', '`Total HJ`', '`Total HJ`', 3, -1, FALSE, '`Total HJ`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Total_HJ->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Total HJ'] = &$this->Total_HJ;

		// Grand Total
		$this->Grand_Total = new cField('pembelian_2D_master', 'pembelian - master', 'x_Grand_Total', 'Grand Total', '`Grand Total`', '`Grand Total`', 3, -1, FALSE, '`Grand Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Grand_Total->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Grand Total'] = &$this->Grand_Total;

		// Dibayar
		$this->Dibayar = new cField('pembelian_2D_master', 'pembelian - master', 'x_Dibayar', 'Dibayar', '`Dibayar`', '`Dibayar`', 3, -1, FALSE, '`Dibayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Dibayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dibayar'] = &$this->Dibayar;

		// Kembali
		$this->Kembali = new cField('pembelian_2D_master', 'pembelian - master', 'x_Kembali', 'Kembali', '`Kembali`', '`Kembali`', 3, -1, FALSE, '`Kembali`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Kembali->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Kembali'] = &$this->Kembali;

		// SisaDibayar
		$this->SisaDibayar = new cField('pembelian_2D_master', 'pembelian - master', 'x_SisaDibayar', 'SisaDibayar', '`SisaDibayar`', '`SisaDibayar`', 3, -1, FALSE, '`SisaDibayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->SisaDibayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['SisaDibayar'] = &$this->SisaDibayar;

		// Kode Kasir
		$this->Kode_Kasir = new cField('pembelian_2D_master', 'pembelian - master', 'x_Kode_Kasir', 'Kode Kasir', '`Kode Kasir`', '`Kode Kasir`', 200, -1, FALSE, '`Kode Kasir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode Kasir'] = &$this->Kode_Kasir;

		// Nama Kasir
		$this->Nama_Kasir = new cField('pembelian_2D_master', 'pembelian - master', 'x_Nama_Kasir', 'Nama Kasir', '`Nama Kasir`', '`Nama Kasir`', 200, -1, FALSE, '`Nama Kasir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nama Kasir'] = &$this->Nama_Kasir;

		// Kode Supplier
		$this->Kode_Supplier = new cField('pembelian_2D_master', 'pembelian - master', 'x_Kode_Supplier', 'Kode Supplier', '`Kode Supplier`', '`Kode Supplier`', 200, -1, FALSE, '`Kode Supplier`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode Supplier'] = &$this->Kode_Supplier;

		// Nama Supplier
		$this->Nama_Supplier = new cField('pembelian_2D_master', 'pembelian - master', 'x_Nama_Supplier', 'Nama Supplier', '`Nama Supplier`', '`Nama Supplier`', 200, -1, FALSE, '`Nama Supplier`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nama Supplier'] = &$this->Nama_Supplier;

		// Nama Form
		$this->Nama_Form = new cField('pembelian_2D_master', 'pembelian - master', 'x_Nama_Form', 'Nama Form', '`Nama Form`', '`Nama Form`', 200, -1, FALSE, '`Nama Form`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nama Form'] = &$this->Nama_Form;

		// No
		$this->No = new cField('pembelian_2D_master', 'pembelian - master', 'x_No', 'No', '`No`', '`No`', 3, -1, FALSE, '`No`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->No->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['No'] = &$this->No;

		// Waktu
		$this->Waktu = new cField('pembelian_2D_master', 'pembelian - master', 'x_Waktu', 'Waktu', '`Waktu`', 'DATE_FORMAT(`Waktu`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Waktu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Waktu->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Waktu'] = &$this->Waktu;

		// Stamp
		$this->Stamp = new cField('pembelian_2D_master', 'pembelian - master', 'x_Stamp', 'Stamp', '`Stamp`', 'DATE_FORMAT(`Stamp`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Stamp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Stamp->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Stamp'] = &$this->Stamp;

		// Hitung
		$this->Hitung = new cField('pembelian_2D_master', 'pembelian - master', 'x_Hitung', 'Hitung', '`Hitung`', '`Hitung`', 200, -1, FALSE, '`Hitung`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Hitung'] = &$this->Hitung;
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

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "pembelian_2D_detail") {
			$sDetailUrl = $GLOBALS["pembelian_2D_detail"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&IDM=" . $this->ID->CurrentValue;
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "pembelian_2D_masterlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`pembelian - master`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
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
		return "`ID` DESC";
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
		global $Security;

		// Add User ID filter
		if (!$this->AllowAnonymousUser() && $Security->CurrentUserID() <> "" && !$Security->IsAdmin()) { // Non system admin
			$sFilter = $this->AddUserIDFilter($sFilter);
		}
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = $this->UserIDAllowSecurity;
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
	var $UpdateTable = "`pembelian - master`";

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
			if (array_key_exists('ID', $rs))
				ew_AddFilter($where, ew_QuotedName('ID') . '=' . ew_QuotedValue($rs['ID'], $this->ID->FldDataType));
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
		return "`ID` = @ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@ID@", ew_AdjustSql($this->ID->CurrentValue), $sKeyFilter); // Replace key value
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
			return "pembelian_2D_masterlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "pembelian_2D_masterlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("pembelian_2D_masterview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("pembelian_2D_masterview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "pembelian_2D_masteradd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("pembelian_2D_masteredit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("pembelian_2D_masteredit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("pembelian_2D_masteradd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("pembelian_2D_masteradd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pembelian_2D_masterdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->ID->CurrentValue)) {
			$sUrl .= "ID=" . urlencode($this->ID->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
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
			$arKeys[] = @$_GET["ID"]; // ID

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
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
			$this->ID->CurrentValue = $key;
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
		$this->Faktur->setDbValue($rs->fields('Faktur'));
		$this->No_Faktur->setDbValue($rs->fields('No Faktur'));
		$this->Diskon->setDbValue($rs->fields('Diskon'));
		$this->Ppn->setDbValue($rs->fields('Ppn'));
		$this->Ongkir->setDbValue($rs->fields('Ongkir'));
		$this->Paking->setDbValue($rs->fields('Paking'));
		$this->Lain_2D_lain->setDbValue($rs->fields('Lain - lain'));
		$this->Hutang->setDbValue($rs->fields('Hutang'));
		$this->Total_Berat->setDbValue($rs->fields('Total Berat'));
		$this->Total_HP->setDbValue($rs->fields('Total HP'));
		$this->Total_HJ->setDbValue($rs->fields('Total HJ'));
		$this->Grand_Total->setDbValue($rs->fields('Grand Total'));
		$this->Dibayar->setDbValue($rs->fields('Dibayar'));
		$this->Kembali->setDbValue($rs->fields('Kembali'));
		$this->SisaDibayar->setDbValue($rs->fields('SisaDibayar'));
		$this->Kode_Kasir->setDbValue($rs->fields('Kode Kasir'));
		$this->Nama_Kasir->setDbValue($rs->fields('Nama Kasir'));
		$this->Kode_Supplier->setDbValue($rs->fields('Kode Supplier'));
		$this->Nama_Supplier->setDbValue($rs->fields('Nama Supplier'));
		$this->Nama_Form->setDbValue($rs->fields('Nama Form'));
		$this->No->setDbValue($rs->fields('No'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
		$this->Hitung->setDbValue($rs->fields('Hitung'));
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
		// Faktur

		$this->Faktur->CellCssStyle = "white-space: nowrap;";

		// No Faktur
		// Diskon

		$this->Diskon->CellCssStyle = "white-space: nowrap;";

		// Ppn
		$this->Ppn->CellCssStyle = "white-space: nowrap;";

		// Ongkir
		$this->Ongkir->CellCssStyle = "white-space: nowrap;";

		// Paking
		$this->Paking->CellCssStyle = "white-space: nowrap;";

		// Lain - lain
		$this->Lain_2D_lain->CellCssStyle = "white-space: nowrap;";

		// Hutang
		$this->Hutang->CellCssStyle = "white-space: nowrap;";

		// Total Berat
		$this->Total_Berat->CellCssStyle = "white-space: nowrap;";

		// Total HP
		$this->Total_HP->CellCssStyle = "white-space: nowrap;";

		// Total HJ
		$this->Total_HJ->CellCssStyle = "white-space: nowrap;";

		// Grand Total
		// Dibayar
		// Kembali

		$this->Kembali->CellCssStyle = "white-space: nowrap;";

		// SisaDibayar
		// Kode Kasir
		// Nama Kasir

		$this->Nama_Kasir->CellCssStyle = "white-space: nowrap;";

		// Kode Supplier
		// Nama Supplier

		$this->Nama_Supplier->CellCssStyle = "white-space: nowrap;";

		// Nama Form
		$this->Nama_Form->CellCssStyle = "white-space: nowrap;";

		// No
		$this->No->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";

		// Hitung
		$this->Hitung->CellCssStyle = "white-space: nowrap;";

		// ID
		$this->ID->ViewValue = $this->ID->CurrentValue;
		$this->ID->ViewCustomAttributes = "";

		// Tgl
		$this->Tgl->ViewValue = $this->Tgl->CurrentValue;
		$this->Tgl->ViewValue = ew_FormatDateTime($this->Tgl->ViewValue, 7);
		$this->Tgl->ViewCustomAttributes = "";

		// Faktur
		$this->Faktur->ViewValue = $this->Faktur->CurrentValue;
		$this->Faktur->ViewCustomAttributes = "";

		// No Faktur
		$this->No_Faktur->ViewValue = $this->No_Faktur->CurrentValue;
		$this->No_Faktur->CssStyle = "font-weight: bold;";
		$this->No_Faktur->CellCssStyle .= "text-align: center;";
		$this->No_Faktur->ViewCustomAttributes = "";

		// Diskon
		$this->Diskon->ViewValue = $this->Diskon->CurrentValue;
		$this->Diskon->ViewCustomAttributes = "";

		// Ppn
		$this->Ppn->ViewValue = $this->Ppn->CurrentValue;
		$this->Ppn->ViewCustomAttributes = "";

		// Ongkir
		$this->Ongkir->ViewValue = $this->Ongkir->CurrentValue;
		$this->Ongkir->ViewCustomAttributes = "";

		// Paking
		$this->Paking->ViewValue = $this->Paking->CurrentValue;
		$this->Paking->ViewCustomAttributes = "";

		// Lain - lain
		$this->Lain_2D_lain->ViewValue = $this->Lain_2D_lain->CurrentValue;
		$this->Lain_2D_lain->ViewCustomAttributes = "";

		// Hutang
		$this->Hutang->ViewValue = $this->Hutang->CurrentValue;
		$this->Hutang->ViewCustomAttributes = "";

		// Total Berat
		$this->Total_Berat->ViewValue = $this->Total_Berat->CurrentValue;
		$this->Total_Berat->ViewCustomAttributes = "";

		// Total HP
		$this->Total_HP->ViewValue = $this->Total_HP->CurrentValue;
		$this->Total_HP->ViewValue = ew_FormatNumber($this->Total_HP->ViewValue, 0, -2, -2, -2);
		$this->Total_HP->CellCssStyle .= "text-align: right;";
		$this->Total_HP->ViewCustomAttributes = "";

		// Total HJ
		$this->Total_HJ->ViewValue = $this->Total_HJ->CurrentValue;
		$this->Total_HJ->ViewCustomAttributes = "";

		// Grand Total
		$this->Grand_Total->ViewValue = $this->Grand_Total->CurrentValue;
		$this->Grand_Total->ViewValue = ew_FormatNumber($this->Grand_Total->ViewValue, 0, -2, -2, -2);
		$this->Grand_Total->CellCssStyle .= "text-align: right;";
		$this->Grand_Total->ViewCustomAttributes = "";

		// Dibayar
		$this->Dibayar->ViewValue = $this->Dibayar->CurrentValue;
		$this->Dibayar->ViewValue = ew_FormatNumber($this->Dibayar->ViewValue, 0, -2, -2, -2);
		$this->Dibayar->CellCssStyle .= "text-align: right;";
		$this->Dibayar->ViewCustomAttributes = "";

		// Kembali
		$this->Kembali->ViewValue = $this->Kembali->CurrentValue;
		$this->Kembali->ViewCustomAttributes = "";

		// SisaDibayar
		$this->SisaDibayar->ViewValue = $this->SisaDibayar->CurrentValue;
		$this->SisaDibayar->ViewValue = ew_FormatNumber($this->SisaDibayar->ViewValue, 0, -2, -2, -2);
		$this->SisaDibayar->CellCssStyle .= "text-align: right;";
		$this->SisaDibayar->ViewCustomAttributes = "";

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

		// Nama Kasir
		$this->Nama_Kasir->ViewValue = $this->Nama_Kasir->CurrentValue;
		$this->Nama_Kasir->ViewCustomAttributes = "";

		// Kode Supplier
		if (strval($this->Kode_Supplier->CurrentValue) <> "") {
			$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode_Supplier->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `Nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar suplier`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->Kode_Supplier, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Kode_Supplier->ViewValue = $rswrk->fields('DispFld');
				$this->Kode_Supplier->ViewValue .= ew_ValueSeparator(1,$this->Kode_Supplier) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->Kode_Supplier->ViewValue = $this->Kode_Supplier->CurrentValue;
			}
		} else {
			$this->Kode_Supplier->ViewValue = NULL;
		}
		$this->Kode_Supplier->ViewCustomAttributes = "";

		// Nama Supplier
		$this->Nama_Supplier->ViewValue = $this->Nama_Supplier->CurrentValue;
		$this->Nama_Supplier->ViewCustomAttributes = "";

		// Nama Form
		$this->Nama_Form->ViewValue = $this->Nama_Form->CurrentValue;
		$this->Nama_Form->ViewCustomAttributes = "";

		// No
		$this->No->ViewValue = $this->No->CurrentValue;
		$this->No->ViewCustomAttributes = "";

		// Waktu
		$this->Waktu->ViewValue = $this->Waktu->CurrentValue;
		$this->Waktu->ViewValue = ew_FormatDateTime($this->Waktu->ViewValue, 7);
		$this->Waktu->ViewCustomAttributes = "";

		// Stamp
		$this->Stamp->ViewValue = $this->Stamp->CurrentValue;
		$this->Stamp->ViewValue = ew_FormatDateTime($this->Stamp->ViewValue, 7);
		$this->Stamp->ViewCustomAttributes = "";

		// Hitung
		$this->Hitung->ViewValue = $this->Hitung->CurrentValue;
		$this->Hitung->ViewCustomAttributes = "";

		// ID
		$this->ID->LinkCustomAttributes = "";
		$this->ID->HrefValue = "";
		$this->ID->TooltipValue = "";

		// Tgl
		$this->Tgl->LinkCustomAttributes = "";
		$this->Tgl->HrefValue = "";
		$this->Tgl->TooltipValue = "";

		// Faktur
		$this->Faktur->LinkCustomAttributes = "";
		$this->Faktur->HrefValue = "";
		$this->Faktur->TooltipValue = "";

		// No Faktur
		$this->No_Faktur->LinkCustomAttributes = "";
		$this->No_Faktur->HrefValue = "";
		$this->No_Faktur->TooltipValue = "";

		// Diskon
		$this->Diskon->LinkCustomAttributes = "";
		$this->Diskon->HrefValue = "";
		$this->Diskon->TooltipValue = "";

		// Ppn
		$this->Ppn->LinkCustomAttributes = "";
		$this->Ppn->HrefValue = "";
		$this->Ppn->TooltipValue = "";

		// Ongkir
		$this->Ongkir->LinkCustomAttributes = "";
		$this->Ongkir->HrefValue = "";
		$this->Ongkir->TooltipValue = "";

		// Paking
		$this->Paking->LinkCustomAttributes = "";
		$this->Paking->HrefValue = "";
		$this->Paking->TooltipValue = "";

		// Lain - lain
		$this->Lain_2D_lain->LinkCustomAttributes = "";
		$this->Lain_2D_lain->HrefValue = "";
		$this->Lain_2D_lain->TooltipValue = "";

		// Hutang
		$this->Hutang->LinkCustomAttributes = "";
		$this->Hutang->HrefValue = "";
		$this->Hutang->TooltipValue = "";

		// Total Berat
		$this->Total_Berat->LinkCustomAttributes = "";
		$this->Total_Berat->HrefValue = "";
		$this->Total_Berat->TooltipValue = "";

		// Total HP
		$this->Total_HP->LinkCustomAttributes = "";
		$this->Total_HP->HrefValue = "";
		$this->Total_HP->TooltipValue = "";

		// Total HJ
		$this->Total_HJ->LinkCustomAttributes = "";
		$this->Total_HJ->HrefValue = "";
		$this->Total_HJ->TooltipValue = "";

		// Grand Total
		$this->Grand_Total->LinkCustomAttributes = "";
		$this->Grand_Total->HrefValue = "";
		$this->Grand_Total->TooltipValue = "";

		// Dibayar
		$this->Dibayar->LinkCustomAttributes = "";
		$this->Dibayar->HrefValue = "";
		$this->Dibayar->TooltipValue = "";

		// Kembali
		$this->Kembali->LinkCustomAttributes = "";
		$this->Kembali->HrefValue = "";
		$this->Kembali->TooltipValue = "";

		// SisaDibayar
		$this->SisaDibayar->LinkCustomAttributes = "";
		$this->SisaDibayar->HrefValue = "";
		$this->SisaDibayar->TooltipValue = "";

		// Kode Kasir
		$this->Kode_Kasir->LinkCustomAttributes = "";
		$this->Kode_Kasir->HrefValue = "";
		$this->Kode_Kasir->TooltipValue = "";

		// Nama Kasir
		$this->Nama_Kasir->LinkCustomAttributes = "";
		$this->Nama_Kasir->HrefValue = "";
		$this->Nama_Kasir->TooltipValue = "";

		// Kode Supplier
		$this->Kode_Supplier->LinkCustomAttributes = "";
		$this->Kode_Supplier->HrefValue = "";
		$this->Kode_Supplier->TooltipValue = "";

		// Nama Supplier
		$this->Nama_Supplier->LinkCustomAttributes = "";
		$this->Nama_Supplier->HrefValue = "";
		$this->Nama_Supplier->TooltipValue = "";

		// Nama Form
		$this->Nama_Form->LinkCustomAttributes = "";
		$this->Nama_Form->HrefValue = "";
		$this->Nama_Form->TooltipValue = "";

		// No
		$this->No->LinkCustomAttributes = "";
		$this->No->HrefValue = "";
		$this->No->TooltipValue = "";

		// Waktu
		$this->Waktu->LinkCustomAttributes = "";
		$this->Waktu->HrefValue = "";
		$this->Waktu->TooltipValue = "";

		// Stamp
		$this->Stamp->LinkCustomAttributes = "";
		$this->Stamp->HrefValue = "";
		$this->Stamp->TooltipValue = "";

		// Hitung
		$this->Hitung->LinkCustomAttributes = "";
		if (!ew_Empty($this->ID->CurrentValue)) {
			$this->Hitung->HrefValue = "AppHitungPembelian.php?id=" . ((!empty($this->ID->ViewValue)) ? $this->ID->ViewValue : $this->ID->CurrentValue); // Add prefix/suffix
			$this->Hitung->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->Hitung->HrefValue = ew_ConvertFullUrl($this->Hitung->HrefValue);
		} else {
			$this->Hitung->HrefValue = "";
		}
		$this->Hitung->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
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
				if ($this->Grand_Total->Exportable) $Doc->ExportCaption($this->Grand_Total);
				if ($this->Dibayar->Exportable) $Doc->ExportCaption($this->Dibayar);
				if ($this->SisaDibayar->Exportable) $Doc->ExportCaption($this->SisaDibayar);
				if ($this->Kode_Kasir->Exportable) $Doc->ExportCaption($this->Kode_Kasir);
				if ($this->Kode_Supplier->Exportable) $Doc->ExportCaption($this->Kode_Supplier);
			} else {
				if ($this->Tgl->Exportable) $Doc->ExportCaption($this->Tgl);
				if ($this->No_Faktur->Exportable) $Doc->ExportCaption($this->No_Faktur);
				if ($this->Grand_Total->Exportable) $Doc->ExportCaption($this->Grand_Total);
				if ($this->Dibayar->Exportable) $Doc->ExportCaption($this->Dibayar);
				if ($this->SisaDibayar->Exportable) $Doc->ExportCaption($this->SisaDibayar);
				if ($this->Kode_Kasir->Exportable) $Doc->ExportCaption($this->Kode_Kasir);
				if ($this->Kode_Supplier->Exportable) $Doc->ExportCaption($this->Kode_Supplier);
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

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->Tgl->Exportable) $Doc->ExportField($this->Tgl);
					if ($this->No_Faktur->Exportable) $Doc->ExportField($this->No_Faktur);
					if ($this->Grand_Total->Exportable) $Doc->ExportField($this->Grand_Total);
					if ($this->Dibayar->Exportable) $Doc->ExportField($this->Dibayar);
					if ($this->SisaDibayar->Exportable) $Doc->ExportField($this->SisaDibayar);
					if ($this->Kode_Kasir->Exportable) $Doc->ExportField($this->Kode_Kasir);
					if ($this->Kode_Supplier->Exportable) $Doc->ExportField($this->Kode_Supplier);
				} else {
					if ($this->Tgl->Exportable) $Doc->ExportField($this->Tgl);
					if ($this->No_Faktur->Exportable) $Doc->ExportField($this->No_Faktur);
					if ($this->Grand_Total->Exportable) $Doc->ExportField($this->Grand_Total);
					if ($this->Dibayar->Exportable) $Doc->ExportField($this->Dibayar);
					if ($this->SisaDibayar->Exportable) $Doc->ExportField($this->SisaDibayar);
					if ($this->Kode_Kasir->Exportable) $Doc->ExportField($this->Kode_Kasir);
					if ($this->Kode_Supplier->Exportable) $Doc->ExportField($this->Kode_Supplier);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Add User ID filter
	function AddUserIDFilter($sFilter) {
		global $Security;
		$sFilterWrk = "";
		$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->UserIDAllow($id) && !$Security->IsAdmin()) {
			$sFilterWrk = $Security->UserIDList();
			if ($sFilterWrk <> "")
				$sFilterWrk = '`Kode Kasir` IN (' . $sFilterWrk . ')';
		}

		// Call Row Rendered event
		$this->UserID_Filtering($sFilterWrk);
		ew_AddFilter($sFilter, $sFilterWrk);
		return $sFilter;
	}

	// User ID subquery
	function GetUserIDSubquery(&$fld, &$masterfld) {
		global $conn;
		$sWrk = "";
		$sSql = "SELECT " . $masterfld->FldExpression . " FROM `pembelian - master`";
		$sFilter = $this->AddUserIDFilter("");
		if ($sFilter <> "") $sSql .= " WHERE " . $sFilter;

		// Use subquery
		if (EW_USE_SUBQUERY_FOR_MASTER_USER_ID) {
			$sWrk = $sSql;
		} else {

			// List all values
			if ($rs = $conn->Execute($sSql)) {
				while (!$rs->EOF) {
					if ($sWrk <> "") $sWrk .= ",";
					$sWrk .= ew_QuotedValue($rs->fields[0], $masterfld->FldDataType);
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if ($sWrk <> "") {
			$sWrk = $fld->FldExpression . " IN (" . $sWrk . ")";
		}
		return $sWrk;
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

		$this->Grand_Total->ViewValue = number_format($this->Grand_Total->ViewValue);
		$this->Dibayar->ViewValue = number_format($this->Dibayar->ViewValue);
		$this->SisaDibayar->ViewValue = number_format($this->SisaDibayar->ViewValue);
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>

<?php

// Global variable for table object
$persewaan_lapangan_2D_master = NULL;

//
// Table class for persewaan lapangan - master
//
class cpersewaan_lapangan_2D_master extends cTable {
	var $ID;
	var $No;
	var $No_Faktur;
	var $Faktur;
	var $Tgl;
	var $Kode;
	var $Nama;
	var $Alamat;
	var $Kota;
	var $Telepon;
	var $Main;
	var $Total;
	var $Bayar;
	var $Sisa;
	var $Sub_Total;
	var $Diskon;
	var $Potongan;
	var $Grand_Total;
	var $Kode_Kasir;
	var $Status;
	var $Nama_Kasir;
	var $Waktu;
	var $Stamp;
	var $Hitung;
	var $Cetak_Struk;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'persewaan_lapangan_2D_master';
		$this->TableName = 'persewaan lapangan - master';
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
		$this->ID = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_ID', 'ID', '`ID`', '`ID`', 3, -1, FALSE, '`ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ID'] = &$this->ID;

		// No
		$this->No = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_No', 'No', '`No`', '`No`', 3, -1, FALSE, '`No`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->No->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['No'] = &$this->No;

		// No Faktur
		$this->No_Faktur = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_No_Faktur', 'No Faktur', '`No Faktur`', '`No Faktur`', 200, -1, FALSE, '`No Faktur`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['No Faktur'] = &$this->No_Faktur;

		// Faktur
		$this->Faktur = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Faktur', 'Faktur', '`Faktur`', '`Faktur`', 200, -1, FALSE, '`Faktur`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Faktur'] = &$this->Faktur;

		// Tgl
		$this->Tgl = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Tgl', 'Tgl', '`Tgl`', 'DATE_FORMAT(`Tgl`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Tgl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Tgl->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Tgl'] = &$this->Tgl;

		// Kode
		$this->Kode = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Kode', 'Kode', '`Kode`', '`Kode`', 200, -1, FALSE, '`EV__Kode`', TRUE, TRUE, TRUE, 'FORMATTED TEXT');
		$this->fields['Kode'] = &$this->Kode;

		// Nama
		$this->Nama = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Nama', 'Nama', '`Nama`', '`Nama`', 200, -1, FALSE, '`Nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nama'] = &$this->Nama;

		// Alamat
		$this->Alamat = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Alamat', 'Alamat', '`Alamat`', '`Alamat`', 200, -1, FALSE, '`Alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Alamat'] = &$this->Alamat;

		// Kota
		$this->Kota = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Kota', 'Kota', '`Kota`', '`Kota`', 200, -1, FALSE, '`Kota`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kota'] = &$this->Kota;

		// Telepon
		$this->Telepon = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Telepon', 'Telepon', '`Telepon`', '`Telepon`', 200, -1, FALSE, '`Telepon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Telepon'] = &$this->Telepon;

		// Main
		$this->Main = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Main', 'Main', '`Main`', '`Main`', 3, -1, FALSE, '`Main`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Main->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Main'] = &$this->Main;

		// Total
		$this->Total = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Total', 'Total', '`Total`', '`Total`', 3, -1, FALSE, '`Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Total->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Total'] = &$this->Total;

		// Bayar
		$this->Bayar = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Bayar', 'Bayar', '`Bayar`', '`Bayar`', 3, -1, FALSE, '`Bayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Bayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Bayar'] = &$this->Bayar;

		// Sisa
		$this->Sisa = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Sisa', 'Sisa', '`Sisa`', '`Sisa`', 3, -1, FALSE, '`Sisa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Sisa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Sisa'] = &$this->Sisa;

		// Sub Total
		$this->Sub_Total = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Sub_Total', 'Sub Total', '`Sub Total`', '`Sub Total`', 3, -1, FALSE, '`Sub Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Sub_Total->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Sub Total'] = &$this->Sub_Total;

		// Diskon
		$this->Diskon = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Diskon', 'Diskon', '`Diskon`', '`Diskon`', 3, -1, FALSE, '`Diskon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Diskon->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Diskon'] = &$this->Diskon;

		// Potongan
		$this->Potongan = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Potongan', 'Potongan', '`Potongan`', '`Potongan`', 3, -1, FALSE, '`Potongan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Potongan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Potongan'] = &$this->Potongan;

		// Grand Total
		$this->Grand_Total = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Grand_Total', 'Grand Total', '`Grand Total`', '`Grand Total`', 3, -1, FALSE, '`Grand Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Grand_Total->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Grand Total'] = &$this->Grand_Total;

		// Kode Kasir
		$this->Kode_Kasir = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Kode_Kasir', 'Kode Kasir', '`Kode Kasir`', '`Kode Kasir`', 200, -1, FALSE, '`Kode Kasir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode Kasir'] = &$this->Kode_Kasir;

		// Status
		$this->Status = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Status', 'Status', '`Status`', '`Status`', 200, -1, FALSE, '`Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status'] = &$this->Status;

		// Nama Kasir
		$this->Nama_Kasir = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Nama_Kasir', 'Nama Kasir', '`Nama Kasir`', '`Nama Kasir`', 200, -1, FALSE, '`Nama Kasir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nama Kasir'] = &$this->Nama_Kasir;

		// Waktu
		$this->Waktu = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Waktu', 'Waktu', '`Waktu`', 'DATE_FORMAT(`Waktu`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Waktu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Waktu->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Waktu'] = &$this->Waktu;

		// Stamp
		$this->Stamp = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Stamp', 'Stamp', '`Stamp`', 'DATE_FORMAT(`Stamp`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Stamp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Stamp->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Stamp'] = &$this->Stamp;

		// Hitung
		$this->Hitung = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Hitung', 'Hitung', '`Hitung`', '`Hitung`', 200, -1, FALSE, '`Hitung`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Hitung'] = &$this->Hitung;

		// Cetak Struk
		$this->Cetak_Struk = new cField('persewaan_lapangan_2D_master', 'persewaan lapangan - master', 'x_Cetak_Struk', 'Cetak Struk', '`Cetak Struk`', '`Cetak Struk`', 200, -1, FALSE, '`Cetak Struk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Cetak Struk'] = &$this->Cetak_Struk;
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
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
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
		if ($this->getCurrentDetailTable() == "persewaan_lapangan_2D_detail") {
			$sDetailUrl = $GLOBALS["persewaan_lapangan_2D_detail"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&IDM=" . $this->ID->CurrentValue;
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "persewaan_lapangan_2D_masterlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`persewaan lapangan - master`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlSelectList() { // Select for List page
		return "SELECT * FROM (" .
			"SELECT *, (SELECT CONCAT(`Kode`,'" . ew_ValueSeparator(1, $this->Kode) . "',`NamaPenyewa`) FROM `daftar pelanggan` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`Kode` = `persewaan lapangan - master`.`Kode` LIMIT 1) AS `EV__Kode` FROM `persewaan lapangan - master`" .
			") `EW_TMP_TABLE`";
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
		if ($this->UseVirtualFields()) {
			$sSort = $this->getSessionOrderByList();
			return ew_BuildSelectSql($this->SqlSelectList(), $this->SqlWhere(), $this->SqlGroupBy(), 
				$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
		} else {
			$sSort = $this->getSessionOrderBy();
			return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
				$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
		}
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = ($this->UseVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Check if virtual fields is used in SQL
	function UseVirtualFields() {
		$sWhere = $this->getSessionWhere();
		$sOrderBy = $this->getSessionOrderByList();
		if ($sWhere <> "")
			$sWhere = " " . str_replace(array("(",")"), array("",""), $sWhere) . " ";
		if ($sOrderBy <> "")
			$sOrderBy = " " . str_replace(array("(",")"), array("",""), $sOrderBy) . " ";
		if ($this->BasicSearch->getKeyword() <> "")
			return TRUE;
		if ($this->Kode->AdvancedSearch->SearchValue <> "" ||
			$this->Kode->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->Kode->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->Kode->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		return FALSE;
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
	var $UpdateTable = "`persewaan lapangan - master`";

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
			return "persewaan_lapangan_2D_masterlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "persewaan_lapangan_2D_masterlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("persewaan_lapangan_2D_masterview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("persewaan_lapangan_2D_masterview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "persewaan_lapangan_2D_masteradd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("persewaan_lapangan_2D_masteredit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("persewaan_lapangan_2D_masteredit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("persewaan_lapangan_2D_masteradd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("persewaan_lapangan_2D_masteradd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("persewaan_lapangan_2D_masterdelete.php", $this->UrlParm());
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
		$this->No->setDbValue($rs->fields('No'));
		$this->No_Faktur->setDbValue($rs->fields('No Faktur'));
		$this->Faktur->setDbValue($rs->fields('Faktur'));
		$this->Tgl->setDbValue($rs->fields('Tgl'));
		$this->Kode->setDbValue($rs->fields('Kode'));
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Kota->setDbValue($rs->fields('Kota'));
		$this->Telepon->setDbValue($rs->fields('Telepon'));
		$this->Main->setDbValue($rs->fields('Main'));
		$this->Total->setDbValue($rs->fields('Total'));
		$this->Bayar->setDbValue($rs->fields('Bayar'));
		$this->Sisa->setDbValue($rs->fields('Sisa'));
		$this->Sub_Total->setDbValue($rs->fields('Sub Total'));
		$this->Diskon->setDbValue($rs->fields('Diskon'));
		$this->Potongan->setDbValue($rs->fields('Potongan'));
		$this->Grand_Total->setDbValue($rs->fields('Grand Total'));
		$this->Kode_Kasir->setDbValue($rs->fields('Kode Kasir'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Nama_Kasir->setDbValue($rs->fields('Nama Kasir'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
		$this->Hitung->setDbValue($rs->fields('Hitung'));
		$this->Cetak_Struk->setDbValue($rs->fields('Cetak Struk'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// ID

		$this->ID->CellCssStyle = "white-space: nowrap;";

		// No
		$this->No->CellCssStyle = "white-space: nowrap;";

		// No Faktur
		// Faktur

		$this->Faktur->CellCssStyle = "white-space: nowrap;";

		// Tgl
		// Kode
		// Nama
		// Alamat

		$this->Alamat->CellCssStyle = "white-space: nowrap;";

		// Kota
		$this->Kota->CellCssStyle = "white-space: nowrap;";

		// Telepon
		$this->Telepon->CellCssStyle = "white-space: nowrap;";

		// Main
		$this->Main->CellCssStyle = "white-space: nowrap;";

		// Total
		$this->Total->CellCssStyle = "white-space: nowrap;";

		// Bayar
		// Sisa
		// Sub Total
		// Diskon
		// Potongan
		// Grand Total
		// Kode Kasir

		$this->Kode_Kasir->CellCssStyle = "width: 100px;";

		// Status
		// Nama Kasir

		$this->Nama_Kasir->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";

		// Hitung
		$this->Hitung->CellCssStyle = "white-space: nowrap;";

		// Cetak Struk
		$this->Cetak_Struk->CellCssStyle = "white-space: nowrap;";

		// ID
		$this->ID->ViewValue = $this->ID->CurrentValue;
		$this->ID->ViewCustomAttributes = "";

		// No
		$this->No->ViewValue = $this->No->CurrentValue;
		$this->No->ViewCustomAttributes = "";

		// No Faktur
		$this->No_Faktur->ViewValue = $this->No_Faktur->CurrentValue;
		$this->No_Faktur->CssStyle = "font-weight: bold;";
		$this->No_Faktur->CellCssStyle .= "text-align: center;";
		$this->No_Faktur->ViewCustomAttributes = "";

		// Faktur
		$this->Faktur->ViewValue = $this->Faktur->CurrentValue;
		$this->Faktur->ViewCustomAttributes = "";

		// Tgl
		$this->Tgl->ViewValue = $this->Tgl->CurrentValue;
		$this->Tgl->ViewValue = ew_FormatDateTime($this->Tgl->ViewValue, 7);
		$this->Tgl->ViewCustomAttributes = "";

		// Kode
		if ($this->Kode->VirtualValue <> "") {
			$this->Kode->ViewValue = $this->Kode->VirtualValue;
		} else {
		if (strval($this->Kode->CurrentValue) <> "") {
			$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaPenyewa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar pelanggan`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->Kode, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Kode->ViewValue = $rswrk->fields('DispFld');
				$this->Kode->ViewValue .= ew_ValueSeparator(1,$this->Kode) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->Kode->ViewValue = $this->Kode->CurrentValue;
			}
		} else {
			$this->Kode->ViewValue = NULL;
		}
		}
		$this->Kode->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// Alamat
		$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
		$this->Alamat->ViewCustomAttributes = "";

		// Kota
		$this->Kota->ViewValue = $this->Kota->CurrentValue;
		$this->Kota->ViewCustomAttributes = "";

		// Telepon
		$this->Telepon->ViewValue = $this->Telepon->CurrentValue;
		$this->Telepon->ViewCustomAttributes = "";

		// Main
		$this->Main->ViewValue = $this->Main->CurrentValue;
		$this->Main->ViewCustomAttributes = "";

		// Total
		$this->Total->ViewValue = $this->Total->CurrentValue;
		$this->Total->ViewValue = ew_FormatNumber($this->Total->ViewValue, 0, -2, -2, -2);
		$this->Total->CellCssStyle .= "text-align: right;";
		$this->Total->ViewCustomAttributes = "";

		// Bayar
		$this->Bayar->ViewValue = $this->Bayar->CurrentValue;
		$this->Bayar->ViewValue = ew_FormatNumber($this->Bayar->ViewValue, 0, -2, -2, -2);
		$this->Bayar->CellCssStyle .= "text-align: right;";
		$this->Bayar->ViewCustomAttributes = "";

		// Sisa
		$this->Sisa->ViewValue = $this->Sisa->CurrentValue;
		$this->Sisa->ViewValue = ew_FormatNumber($this->Sisa->ViewValue, 0, -2, -2, -2);
		$this->Sisa->CellCssStyle .= "text-align: right;";
		$this->Sisa->ViewCustomAttributes = "";

		// Sub Total
		$this->Sub_Total->ViewValue = $this->Sub_Total->CurrentValue;
		$this->Sub_Total->ViewValue = ew_FormatNumber($this->Sub_Total->ViewValue, 0, -2, -2, -2);
		$this->Sub_Total->CellCssStyle .= "text-align: right;";
		$this->Sub_Total->ViewCustomAttributes = "";

		// Diskon
		$this->Diskon->ViewValue = $this->Diskon->CurrentValue;
		$this->Diskon->CellCssStyle .= "text-align: center;";
		$this->Diskon->ViewCustomAttributes = "";

		// Potongan
		$this->Potongan->ViewValue = $this->Potongan->CurrentValue;
		$this->Potongan->ViewValue = ew_FormatNumber($this->Potongan->ViewValue, 0, -2, -2, -2);
		$this->Potongan->CellCssStyle .= "text-align: right;";
		$this->Potongan->ViewCustomAttributes = "";

		// Grand Total
		$this->Grand_Total->ViewValue = $this->Grand_Total->CurrentValue;
		$this->Grand_Total->ViewValue = ew_FormatNumber($this->Grand_Total->ViewValue, 0, -2, -2, -2);
		$this->Grand_Total->CellCssStyle .= "text-align: right;";
		$this->Grand_Total->ViewCustomAttributes = "";

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

		// Status
		if (strval($this->Status->CurrentValue) <> "") {
			switch ($this->Status->CurrentValue) {
				case $this->Status->FldTagValue(1):
					$this->Status->ViewValue = $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->CurrentValue;
					break;
				case $this->Status->FldTagValue(2):
					$this->Status->ViewValue = $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->CurrentValue;
					break;
				case $this->Status->FldTagValue(3):
					$this->Status->ViewValue = $this->Status->FldTagCaption(3) <> "" ? $this->Status->FldTagCaption(3) : $this->Status->CurrentValue;
					break;
				case $this->Status->FldTagValue(4):
					$this->Status->ViewValue = $this->Status->FldTagCaption(4) <> "" ? $this->Status->FldTagCaption(4) : $this->Status->CurrentValue;
					break;
				case $this->Status->FldTagValue(5):
					$this->Status->ViewValue = $this->Status->FldTagCaption(5) <> "" ? $this->Status->FldTagCaption(5) : $this->Status->CurrentValue;
					break;
				default:
					$this->Status->ViewValue = $this->Status->CurrentValue;
			}
		} else {
			$this->Status->ViewValue = NULL;
		}
		$this->Status->ViewCustomAttributes = "";

		// Nama Kasir
		$this->Nama_Kasir->ViewValue = $this->Nama_Kasir->CurrentValue;
		$this->Nama_Kasir->ViewCustomAttributes = "";

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

		// Cetak Struk
		$this->Cetak_Struk->ViewValue = $this->Cetak_Struk->CurrentValue;
		$this->Cetak_Struk->ViewCustomAttributes = "";

		// ID
		$this->ID->LinkCustomAttributes = "";
		$this->ID->HrefValue = "";
		$this->ID->TooltipValue = "";

		// No
		$this->No->LinkCustomAttributes = "";
		$this->No->HrefValue = "";
		$this->No->TooltipValue = "";

		// No Faktur
		$this->No_Faktur->LinkCustomAttributes = "";
		$this->No_Faktur->HrefValue = "";
		$this->No_Faktur->TooltipValue = "";

		// Faktur
		$this->Faktur->LinkCustomAttributes = "";
		$this->Faktur->HrefValue = "";
		$this->Faktur->TooltipValue = "";

		// Tgl
		$this->Tgl->LinkCustomAttributes = "";
		$this->Tgl->HrefValue = "";
		$this->Tgl->TooltipValue = "";

		// Kode
		$this->Kode->LinkCustomAttributes = "";
		$this->Kode->HrefValue = "";
		$this->Kode->TooltipValue = "";

		// Nama
		$this->Nama->LinkCustomAttributes = "";
		$this->Nama->HrefValue = "";
		$this->Nama->TooltipValue = "";

		// Alamat
		$this->Alamat->LinkCustomAttributes = "";
		$this->Alamat->HrefValue = "";
		$this->Alamat->TooltipValue = "";

		// Kota
		$this->Kota->LinkCustomAttributes = "";
		$this->Kota->HrefValue = "";
		$this->Kota->TooltipValue = "";

		// Telepon
		$this->Telepon->LinkCustomAttributes = "";
		$this->Telepon->HrefValue = "";
		$this->Telepon->TooltipValue = "";

		// Main
		$this->Main->LinkCustomAttributes = "";
		$this->Main->HrefValue = "";
		$this->Main->TooltipValue = "";

		// Total
		$this->Total->LinkCustomAttributes = "";
		$this->Total->HrefValue = "";
		$this->Total->TooltipValue = "";

		// Bayar
		$this->Bayar->LinkCustomAttributes = "";
		$this->Bayar->HrefValue = "";
		$this->Bayar->TooltipValue = "";

		// Sisa
		$this->Sisa->LinkCustomAttributes = "";
		$this->Sisa->HrefValue = "";
		$this->Sisa->TooltipValue = "";

		// Sub Total
		$this->Sub_Total->LinkCustomAttributes = "";
		$this->Sub_Total->HrefValue = "";
		$this->Sub_Total->TooltipValue = "";

		// Diskon
		$this->Diskon->LinkCustomAttributes = "";
		$this->Diskon->HrefValue = "";
		$this->Diskon->TooltipValue = "";

		// Potongan
		$this->Potongan->LinkCustomAttributes = "";
		$this->Potongan->HrefValue = "";
		$this->Potongan->TooltipValue = "";

		// Grand Total
		$this->Grand_Total->LinkCustomAttributes = "";
		$this->Grand_Total->HrefValue = "";
		$this->Grand_Total->TooltipValue = "";

		// Kode Kasir
		$this->Kode_Kasir->LinkCustomAttributes = "";
		$this->Kode_Kasir->HrefValue = "";
		$this->Kode_Kasir->TooltipValue = "";

		// Status
		$this->Status->LinkCustomAttributes = "";
		$this->Status->HrefValue = "";
		$this->Status->TooltipValue = "";

		// Nama Kasir
		$this->Nama_Kasir->LinkCustomAttributes = "";
		$this->Nama_Kasir->HrefValue = "";
		$this->Nama_Kasir->TooltipValue = "";

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
			$this->Hitung->HrefValue = "AppHitung.php?id=" . ((!empty($this->ID->ViewValue)) ? $this->ID->ViewValue : $this->ID->CurrentValue); // Add prefix/suffix
			$this->Hitung->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->Hitung->HrefValue = ew_ConvertFullUrl($this->Hitung->HrefValue);
		} else {
			$this->Hitung->HrefValue = "";
		}
		$this->Hitung->TooltipValue = "";

		// Cetak Struk
		$this->Cetak_Struk->LinkCustomAttributes = "";
		if (!ew_Empty($this->ID->CurrentValue)) {
			$this->Cetak_Struk->HrefValue = "AppCetakLapangan.php?id=" . ((!empty($this->ID->ViewValue)) ? $this->ID->ViewValue : $this->ID->CurrentValue); // Add prefix/suffix
			$this->Cetak_Struk->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->Cetak_Struk->HrefValue = ew_ConvertFullUrl($this->Cetak_Struk->HrefValue);
		} else {
			$this->Cetak_Struk->HrefValue = "";
		}
		$this->Cetak_Struk->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			if (is_numeric($this->Bayar->CurrentValue))
				$this->Bayar->Total += $this->Bayar->CurrentValue; // Accumulate total
			if (is_numeric($this->Sisa->CurrentValue))
				$this->Sisa->Total += $this->Sisa->CurrentValue; // Accumulate total
			if (is_numeric($this->Sub_Total->CurrentValue))
				$this->Sub_Total->Total += $this->Sub_Total->CurrentValue; // Accumulate total
			if (is_numeric($this->Grand_Total->CurrentValue))
				$this->Grand_Total->Total += $this->Grand_Total->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->Bayar->CurrentValue = $this->Bayar->Total;
			$this->Bayar->ViewValue = $this->Bayar->CurrentValue;
			$this->Bayar->ViewValue = ew_FormatNumber($this->Bayar->ViewValue, 0, -2, -2, -2);
			$this->Bayar->CellCssStyle .= "text-align: right;";
			$this->Bayar->ViewCustomAttributes = "";
			$this->Bayar->HrefValue = ""; // Clear href value
			$this->Sisa->CurrentValue = $this->Sisa->Total;
			$this->Sisa->ViewValue = $this->Sisa->CurrentValue;
			$this->Sisa->ViewValue = ew_FormatNumber($this->Sisa->ViewValue, 0, -2, -2, -2);
			$this->Sisa->CellCssStyle .= "text-align: right;";
			$this->Sisa->ViewCustomAttributes = "";
			$this->Sisa->HrefValue = ""; // Clear href value
			$this->Sub_Total->CurrentValue = $this->Sub_Total->Total;
			$this->Sub_Total->ViewValue = $this->Sub_Total->CurrentValue;
			$this->Sub_Total->ViewValue = ew_FormatNumber($this->Sub_Total->ViewValue, 0, -2, -2, -2);
			$this->Sub_Total->CellCssStyle .= "text-align: right;";
			$this->Sub_Total->ViewCustomAttributes = "";
			$this->Sub_Total->HrefValue = ""; // Clear href value
			$this->Grand_Total->CurrentValue = $this->Grand_Total->Total;
			$this->Grand_Total->ViewValue = $this->Grand_Total->CurrentValue;
			$this->Grand_Total->ViewValue = ew_FormatNumber($this->Grand_Total->ViewValue, 0, -2, -2, -2);
			$this->Grand_Total->CellCssStyle .= "text-align: right;";
			$this->Grand_Total->ViewCustomAttributes = "";
			$this->Grand_Total->HrefValue = ""; // Clear href value
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
				if ($this->No_Faktur->Exportable) $Doc->ExportCaption($this->No_Faktur);
				if ($this->Tgl->Exportable) $Doc->ExportCaption($this->Tgl);
				if ($this->Kode->Exportable) $Doc->ExportCaption($this->Kode);
				if ($this->Nama->Exportable) $Doc->ExportCaption($this->Nama);
				if ($this->Bayar->Exportable) $Doc->ExportCaption($this->Bayar);
				if ($this->Sisa->Exportable) $Doc->ExportCaption($this->Sisa);
				if ($this->Sub_Total->Exportable) $Doc->ExportCaption($this->Sub_Total);
				if ($this->Diskon->Exportable) $Doc->ExportCaption($this->Diskon);
				if ($this->Potongan->Exportable) $Doc->ExportCaption($this->Potongan);
				if ($this->Grand_Total->Exportable) $Doc->ExportCaption($this->Grand_Total);
				if ($this->Kode_Kasir->Exportable) $Doc->ExportCaption($this->Kode_Kasir);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
			} else {
				if ($this->No_Faktur->Exportable) $Doc->ExportCaption($this->No_Faktur);
				if ($this->Tgl->Exportable) $Doc->ExportCaption($this->Tgl);
				if ($this->Kode->Exportable) $Doc->ExportCaption($this->Kode);
				if ($this->Nama->Exportable) $Doc->ExportCaption($this->Nama);
				if ($this->Bayar->Exportable) $Doc->ExportCaption($this->Bayar);
				if ($this->Sisa->Exportable) $Doc->ExportCaption($this->Sisa);
				if ($this->Sub_Total->Exportable) $Doc->ExportCaption($this->Sub_Total);
				if ($this->Diskon->Exportable) $Doc->ExportCaption($this->Diskon);
				if ($this->Potongan->Exportable) $Doc->ExportCaption($this->Potongan);
				if ($this->Grand_Total->Exportable) $Doc->ExportCaption($this->Grand_Total);
				if ($this->Kode_Kasir->Exportable) $Doc->ExportCaption($this->Kode_Kasir);
				if ($this->Status->Exportable) $Doc->ExportCaption($this->Status);
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
					if ($this->No_Faktur->Exportable) $Doc->ExportField($this->No_Faktur);
					if ($this->Tgl->Exportable) $Doc->ExportField($this->Tgl);
					if ($this->Kode->Exportable) $Doc->ExportField($this->Kode);
					if ($this->Nama->Exportable) $Doc->ExportField($this->Nama);
					if ($this->Bayar->Exportable) $Doc->ExportField($this->Bayar);
					if ($this->Sisa->Exportable) $Doc->ExportField($this->Sisa);
					if ($this->Sub_Total->Exportable) $Doc->ExportField($this->Sub_Total);
					if ($this->Diskon->Exportable) $Doc->ExportField($this->Diskon);
					if ($this->Potongan->Exportable) $Doc->ExportField($this->Potongan);
					if ($this->Grand_Total->Exportable) $Doc->ExportField($this->Grand_Total);
					if ($this->Kode_Kasir->Exportable) $Doc->ExportField($this->Kode_Kasir);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
				} else {
					if ($this->No_Faktur->Exportable) $Doc->ExportField($this->No_Faktur);
					if ($this->Tgl->Exportable) $Doc->ExportField($this->Tgl);
					if ($this->Kode->Exportable) $Doc->ExportField($this->Kode);
					if ($this->Nama->Exportable) $Doc->ExportField($this->Nama);
					if ($this->Bayar->Exportable) $Doc->ExportField($this->Bayar);
					if ($this->Sisa->Exportable) $Doc->ExportField($this->Sisa);
					if ($this->Sub_Total->Exportable) $Doc->ExportField($this->Sub_Total);
					if ($this->Diskon->Exportable) $Doc->ExportField($this->Diskon);
					if ($this->Potongan->Exportable) $Doc->ExportField($this->Potongan);
					if ($this->Grand_Total->Exportable) $Doc->ExportField($this->Grand_Total);
					if ($this->Kode_Kasir->Exportable) $Doc->ExportField($this->Kode_Kasir);
					if ($this->Status->Exportable) $Doc->ExportField($this->Status);
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
			$Doc->ExportAggregate($this->No_Faktur, '');
			$Doc->ExportAggregate($this->Tgl, '');
			$Doc->ExportAggregate($this->Kode, '');
			$Doc->ExportAggregate($this->Nama, '');
			$Doc->ExportAggregate($this->Bayar, 'TOTAL');
			$Doc->ExportAggregate($this->Sisa, 'TOTAL');
			$Doc->ExportAggregate($this->Sub_Total, 'TOTAL');
			$Doc->ExportAggregate($this->Diskon, '');
			$Doc->ExportAggregate($this->Potongan, '');
			$Doc->ExportAggregate($this->Grand_Total, 'TOTAL');
			$Doc->ExportAggregate($this->Kode_Kasir, '');
			$Doc->ExportAggregate($this->Status, '');
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

		$this->Bayar->ViewValue = number_format($this->Bayar->ViewValue);
		$this->Sisa->ViewValue = number_format($this->Sisa->ViewValue);
		$this->Sub_Total->ViewValue = number_format($this->Sub_Total->ViewValue);
		$this->Potongan->ViewValue = number_format($this->Potongan->ViewValue);
		$this->Grand_Total->ViewValue = number_format($this->Grand_Total->ViewValue);
	}                                                              

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>

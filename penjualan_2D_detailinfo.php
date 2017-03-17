<?php

// Global variable for table object
$penjualan_2D_detail = NULL;

//
// Table class for penjualan - detail
//
class cpenjualan_2D_detail extends cTable {
	var $ID;
	var $Kode;
	var $Nama_Barang;
	var $Isi;
	var $Satuan;
	var $Harga_Pokok;
	var $Harga_Jual;
	var $Jumlah;
	var $Total_Jumlah;
	var $Berat;
	var $Diskon;
	var $Total_HP;
	var $Total_HJ;
	var $Saldo;
	var $Retur;
	var $User;
	var $IDM;
	var $Waktu;
	var $Stamp;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'penjualan_2D_detail';
		$this->TableName = 'penjualan - detail';
		$this->TableType = 'TABLE';
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
		$this->ID = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_ID', 'ID', '`ID`', '`ID`', 3, -1, FALSE, '`ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ID'] = &$this->ID;

		// Kode
		$this->Kode = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Kode', 'Kode', '`Kode`', '`Kode`', 200, -1, FALSE, '`EV__Kode`', TRUE, TRUE, TRUE, 'FORMATTED TEXT');
		$this->fields['Kode'] = &$this->Kode;

		// Nama Barang
		$this->Nama_Barang = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Nama_Barang', 'Nama Barang', '`Nama Barang`', '`Nama Barang`', 200, -1, FALSE, '`Nama Barang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nama Barang'] = &$this->Nama_Barang;

		// Isi
		$this->Isi = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Isi', 'Isi', '`Isi`', '`Isi`', 5, -1, FALSE, '`Isi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Isi->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Isi'] = &$this->Isi;

		// Satuan
		$this->Satuan = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Satuan', 'Satuan', '`Satuan`', '`Satuan`', 200, -1, FALSE, '`Satuan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Satuan'] = &$this->Satuan;

		// Harga Pokok
		$this->Harga_Pokok = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Harga_Pokok', 'Harga Pokok', '`Harga Pokok`', '`Harga Pokok`', 3, -1, FALSE, '`Harga Pokok`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Harga_Pokok->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Harga Pokok'] = &$this->Harga_Pokok;

		// Harga Jual
		$this->Harga_Jual = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Harga_Jual', 'Harga Jual', '`Harga Jual`', '`Harga Jual`', 3, -1, FALSE, '`Harga Jual`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Harga_Jual->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Harga Jual'] = &$this->Harga_Jual;

		// Jumlah
		$this->Jumlah = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Jumlah', 'Jumlah', '`Jumlah`', '`Jumlah`', 5, -1, FALSE, '`Jumlah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Jumlah->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Jumlah'] = &$this->Jumlah;

		// Total Jumlah
		$this->Total_Jumlah = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Total_Jumlah', 'Total Jumlah', '`Total Jumlah`', '`Total Jumlah`', 5, -1, FALSE, '`Total Jumlah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Total_Jumlah->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Total Jumlah'] = &$this->Total_Jumlah;

		// Berat
		$this->Berat = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Berat', 'Berat', '`Berat`', '`Berat`', 5, -1, FALSE, '`Berat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Berat->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Berat'] = &$this->Berat;

		// Diskon
		$this->Diskon = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Diskon', 'Diskon', '`Diskon`', '`Diskon`', 5, -1, FALSE, '`Diskon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Diskon->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Diskon'] = &$this->Diskon;

		// Total HP
		$this->Total_HP = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Total_HP', 'Total HP', '`Total HP`', '`Total HP`', 3, -1, FALSE, '`Total HP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Total_HP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Total HP'] = &$this->Total_HP;

		// Total HJ
		$this->Total_HJ = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Total_HJ', 'Total HJ', '`Total HJ`', '`Total HJ`', 3, -1, FALSE, '`Total HJ`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Total_HJ->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Total HJ'] = &$this->Total_HJ;

		// Saldo
		$this->Saldo = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Saldo', 'Saldo', '`Saldo`', '`Saldo`', 3, -1, FALSE, '`Saldo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Saldo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Saldo'] = &$this->Saldo;

		// Retur
		$this->Retur = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Retur', 'Retur', '`Retur`', '`Retur`', 3, -1, FALSE, '`Retur`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Retur->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Retur'] = &$this->Retur;

		// User
		$this->User = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_User', 'User', '`User`', '`User`', 200, -1, FALSE, '`User`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['User'] = &$this->User;

		// IDM
		$this->IDM = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_IDM', 'IDM', '`IDM`', '`IDM`', 3, -1, FALSE, '`IDM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->IDM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IDM'] = &$this->IDM;

		// Waktu
		$this->Waktu = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Waktu', 'Waktu', '`Waktu`', 'DATE_FORMAT(`Waktu`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Waktu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Waktu->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Waktu'] = &$this->Waktu;

		// Stamp
		$this->Stamp = new cField('penjualan_2D_detail', 'penjualan - detail', 'x_Stamp', 'Stamp', '`Stamp`', 'DATE_FORMAT(`Stamp`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Stamp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Stamp->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Stamp'] = &$this->Stamp;
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

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "penjualan_2D_master") {
			if ($this->IDM->getSessionValue() <> "")
				$sMasterFilter .= "`ID`=" . ew_QuotedValue($this->IDM->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "penjualan_2D_master") {
			if ($this->IDM->getSessionValue() <> "")
				$sDetailFilter .= "`IDM`=" . ew_QuotedValue($this->IDM->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_penjualan_2D_master() {
		return "`ID`=@ID@";
	}

	// Detail filter
	function SqlDetailFilter_penjualan_2D_master() {
		return "`IDM`=@IDM@";
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`penjualan - detail`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlSelectList() { // Select for List page
		return "SELECT * FROM (" .
			"SELECT *, (SELECT CONCAT(`Kode`,'" . ew_ValueSeparator(1, $this->Kode) . "',`Nama Barang`) FROM `daftar produk` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`Kode` = `penjualan - detail`.`Kode` LIMIT 1) AS `EV__Kode` FROM `penjualan - detail`" .
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
		return "";
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
			if ($this->getCurrentMasterTable() == "penjualan_2D_master" || $this->getCurrentMasterTable() == "")
				$sFilter = $this->AddDetailUserIDFilter($sFilter, "penjualan_2D_master"); // Add detail User ID filter
		}
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
	var $UpdateTable = "`penjualan - detail`";

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
			return "penjualan_2D_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "penjualan_2D_detaillist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("penjualan_2D_detailview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("penjualan_2D_detailview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "penjualan_2D_detailadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("penjualan_2D_detailedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("penjualan_2D_detailadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("penjualan_2D_detaildelete.php", $this->UrlParm());
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
		$this->Kode->setDbValue($rs->fields('Kode'));
		$this->Nama_Barang->setDbValue($rs->fields('Nama Barang'));
		$this->Isi->setDbValue($rs->fields('Isi'));
		$this->Satuan->setDbValue($rs->fields('Satuan'));
		$this->Harga_Pokok->setDbValue($rs->fields('Harga Pokok'));
		$this->Harga_Jual->setDbValue($rs->fields('Harga Jual'));
		$this->Jumlah->setDbValue($rs->fields('Jumlah'));
		$this->Total_Jumlah->setDbValue($rs->fields('Total Jumlah'));
		$this->Berat->setDbValue($rs->fields('Berat'));
		$this->Diskon->setDbValue($rs->fields('Diskon'));
		$this->Total_HP->setDbValue($rs->fields('Total HP'));
		$this->Total_HJ->setDbValue($rs->fields('Total HJ'));
		$this->Saldo->setDbValue($rs->fields('Saldo'));
		$this->Retur->setDbValue($rs->fields('Retur'));
		$this->User->setDbValue($rs->fields('User'));
		$this->IDM->setDbValue($rs->fields('IDM'));
		$this->Waktu->setDbValue($rs->fields('Waktu'));
		$this->Stamp->setDbValue($rs->fields('Stamp'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// ID

		$this->ID->CellCssStyle = "white-space: nowrap;";

		// Kode
		// Nama Barang
		// Isi

		$this->Isi->CellCssStyle = "white-space: nowrap;";

		// Satuan
		// Harga Pokok

		$this->Harga_Pokok->CellCssStyle = "white-space: nowrap;";

		// Harga Jual
		// Jumlah
		// Total Jumlah

		$this->Total_Jumlah->CellCssStyle = "white-space: nowrap;";

		// Berat
		$this->Berat->CellCssStyle = "white-space: nowrap;";

		// Diskon
		// Total HP

		$this->Total_HP->CellCssStyle = "white-space: nowrap;";

		// Total HJ
		// Saldo

		$this->Saldo->CellCssStyle = "white-space: nowrap;";

		// Retur
		$this->Retur->CellCssStyle = "white-space: nowrap;";

		// User
		$this->User->CellCssStyle = "white-space: nowrap;";

		// IDM
		$this->IDM->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";

		// ID
		$this->ID->ViewValue = $this->ID->CurrentValue;
		$this->ID->CellCssStyle .= "text-align: center;";
		$this->ID->ViewCustomAttributes = "";

		// Kode
		if ($this->Kode->VirtualValue <> "") {
			$this->Kode->ViewValue = $this->Kode->VirtualValue;
		} else {
		if (strval($this->Kode->CurrentValue) <> "") {
			$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `Nama Barang` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar produk`";
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

		// Nama Barang
		$this->Nama_Barang->ViewValue = $this->Nama_Barang->CurrentValue;
		$this->Nama_Barang->ViewCustomAttributes = "";

		// Isi
		$this->Isi->ViewValue = $this->Isi->CurrentValue;
		$this->Isi->ViewCustomAttributes = "";

		// Satuan
		$this->Satuan->ViewValue = $this->Satuan->CurrentValue;
		$this->Satuan->ViewCustomAttributes = "";

		// Harga Pokok
		$this->Harga_Pokok->ViewValue = $this->Harga_Pokok->CurrentValue;
		$this->Harga_Pokok->ViewCustomAttributes = "";

		// Harga Jual
		$this->Harga_Jual->ViewValue = $this->Harga_Jual->CurrentValue;
		$this->Harga_Jual->ViewValue = ew_FormatNumber($this->Harga_Jual->ViewValue, 0, -2, -2, -2);
		$this->Harga_Jual->CellCssStyle .= "text-align: right;";
		$this->Harga_Jual->ViewCustomAttributes = "";

		// Jumlah
		$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
		$this->Jumlah->CellCssStyle .= "text-align: center;";
		$this->Jumlah->ViewCustomAttributes = "";

		// Total Jumlah
		$this->Total_Jumlah->ViewValue = $this->Total_Jumlah->CurrentValue;
		$this->Total_Jumlah->ViewCustomAttributes = "";

		// Berat
		$this->Berat->ViewValue = $this->Berat->CurrentValue;
		$this->Berat->ViewCustomAttributes = "";

		// Diskon
		$this->Diskon->ViewValue = $this->Diskon->CurrentValue;
		$this->Diskon->ViewValue = ew_FormatNumber($this->Diskon->ViewValue, 0, -2, -2, -2);
		$this->Diskon->CellCssStyle .= "text-align: center;";
		$this->Diskon->ViewCustomAttributes = "";

		// Total HP
		$this->Total_HP->ViewValue = $this->Total_HP->CurrentValue;
		$this->Total_HP->ViewCustomAttributes = "";

		// Total HJ
		$this->Total_HJ->ViewValue = $this->Total_HJ->CurrentValue;
		$this->Total_HJ->ViewValue = ew_FormatNumber($this->Total_HJ->ViewValue, 0, -2, -2, -2);
		$this->Total_HJ->CellCssStyle .= "text-align: right;";
		$this->Total_HJ->ViewCustomAttributes = "";

		// Saldo
		$this->Saldo->ViewValue = $this->Saldo->CurrentValue;
		$this->Saldo->ViewCustomAttributes = "";

		// Retur
		$this->Retur->ViewValue = $this->Retur->CurrentValue;
		$this->Retur->ViewCustomAttributes = "";

		// User
		$this->User->ViewValue = $this->User->CurrentValue;
		$this->User->ViewCustomAttributes = "";

		// IDM
		$this->IDM->ViewValue = $this->IDM->CurrentValue;
		$this->IDM->ViewCustomAttributes = "";

		// Waktu
		$this->Waktu->ViewValue = $this->Waktu->CurrentValue;
		$this->Waktu->ViewValue = ew_FormatDateTime($this->Waktu->ViewValue, 7);
		$this->Waktu->ViewCustomAttributes = "";

		// Stamp
		$this->Stamp->ViewValue = $this->Stamp->CurrentValue;
		$this->Stamp->ViewValue = ew_FormatDateTime($this->Stamp->ViewValue, 7);
		$this->Stamp->ViewCustomAttributes = "";

		// ID
		$this->ID->LinkCustomAttributes = "";
		$this->ID->HrefValue = "";
		$this->ID->TooltipValue = "";

		// Kode
		$this->Kode->LinkCustomAttributes = "";
		$this->Kode->HrefValue = "";
		$this->Kode->TooltipValue = "";

		// Nama Barang
		$this->Nama_Barang->LinkCustomAttributes = "";
		$this->Nama_Barang->HrefValue = "";
		$this->Nama_Barang->TooltipValue = "";

		// Isi
		$this->Isi->LinkCustomAttributes = "";
		$this->Isi->HrefValue = "";
		$this->Isi->TooltipValue = "";

		// Satuan
		$this->Satuan->LinkCustomAttributes = "";
		$this->Satuan->HrefValue = "";
		$this->Satuan->TooltipValue = "";

		// Harga Pokok
		$this->Harga_Pokok->LinkCustomAttributes = "";
		$this->Harga_Pokok->HrefValue = "";
		$this->Harga_Pokok->TooltipValue = "";

		// Harga Jual
		$this->Harga_Jual->LinkCustomAttributes = "";
		$this->Harga_Jual->HrefValue = "";
		$this->Harga_Jual->TooltipValue = "";

		// Jumlah
		$this->Jumlah->LinkCustomAttributes = "";
		$this->Jumlah->HrefValue = "";
		$this->Jumlah->TooltipValue = "";

		// Total Jumlah
		$this->Total_Jumlah->LinkCustomAttributes = "";
		$this->Total_Jumlah->HrefValue = "";
		$this->Total_Jumlah->TooltipValue = "";

		// Berat
		$this->Berat->LinkCustomAttributes = "";
		$this->Berat->HrefValue = "";
		$this->Berat->TooltipValue = "";

		// Diskon
		$this->Diskon->LinkCustomAttributes = "";
		$this->Diskon->HrefValue = "";
		$this->Diskon->TooltipValue = "";

		// Total HP
		$this->Total_HP->LinkCustomAttributes = "";
		$this->Total_HP->HrefValue = "";
		$this->Total_HP->TooltipValue = "";

		// Total HJ
		$this->Total_HJ->LinkCustomAttributes = "";
		$this->Total_HJ->HrefValue = "";
		$this->Total_HJ->TooltipValue = "";

		// Saldo
		$this->Saldo->LinkCustomAttributes = "";
		$this->Saldo->HrefValue = "";
		$this->Saldo->TooltipValue = "";

		// Retur
		$this->Retur->LinkCustomAttributes = "";
		$this->Retur->HrefValue = "";
		$this->Retur->TooltipValue = "";

		// User
		$this->User->LinkCustomAttributes = "";
		$this->User->HrefValue = "";
		$this->User->TooltipValue = "";

		// IDM
		$this->IDM->LinkCustomAttributes = "";
		$this->IDM->HrefValue = "";
		$this->IDM->TooltipValue = "";

		// Waktu
		$this->Waktu->LinkCustomAttributes = "";
		$this->Waktu->HrefValue = "";
		$this->Waktu->TooltipValue = "";

		// Stamp
		$this->Stamp->LinkCustomAttributes = "";
		$this->Stamp->HrefValue = "";
		$this->Stamp->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			if (is_numeric($this->Jumlah->CurrentValue))
				$this->Jumlah->Total += $this->Jumlah->CurrentValue; // Accumulate total
			if (is_numeric($this->Total_HJ->CurrentValue))
				$this->Total_HJ->Total += $this->Total_HJ->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->Jumlah->CurrentValue = $this->Jumlah->Total;
			$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
			$this->Jumlah->CellCssStyle .= "text-align: center;";
			$this->Jumlah->ViewCustomAttributes = "";
			$this->Jumlah->HrefValue = ""; // Clear href value
			$this->Total_HJ->CurrentValue = $this->Total_HJ->Total;
			$this->Total_HJ->ViewValue = $this->Total_HJ->CurrentValue;
			$this->Total_HJ->ViewValue = ew_FormatNumber($this->Total_HJ->ViewValue, 0, -2, -2, -2);
			$this->Total_HJ->CellCssStyle .= "text-align: right;";
			$this->Total_HJ->ViewCustomAttributes = "";
			$this->Total_HJ->HrefValue = ""; // Clear href value
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
				if ($this->Kode->Exportable) $Doc->ExportCaption($this->Kode);
				if ($this->Nama_Barang->Exportable) $Doc->ExportCaption($this->Nama_Barang);
				if ($this->Satuan->Exportable) $Doc->ExportCaption($this->Satuan);
				if ($this->Harga_Jual->Exportable) $Doc->ExportCaption($this->Harga_Jual);
				if ($this->Jumlah->Exportable) $Doc->ExportCaption($this->Jumlah);
				if ($this->Diskon->Exportable) $Doc->ExportCaption($this->Diskon);
				if ($this->Total_HJ->Exportable) $Doc->ExportCaption($this->Total_HJ);
			} else {
				if ($this->Kode->Exportable) $Doc->ExportCaption($this->Kode);
				if ($this->Nama_Barang->Exportable) $Doc->ExportCaption($this->Nama_Barang);
				if ($this->Satuan->Exportable) $Doc->ExportCaption($this->Satuan);
				if ($this->Harga_Jual->Exportable) $Doc->ExportCaption($this->Harga_Jual);
				if ($this->Jumlah->Exportable) $Doc->ExportCaption($this->Jumlah);
				if ($this->Diskon->Exportable) $Doc->ExportCaption($this->Diskon);
				if ($this->Total_HJ->Exportable) $Doc->ExportCaption($this->Total_HJ);
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
					if ($this->Kode->Exportable) $Doc->ExportField($this->Kode);
					if ($this->Nama_Barang->Exportable) $Doc->ExportField($this->Nama_Barang);
					if ($this->Satuan->Exportable) $Doc->ExportField($this->Satuan);
					if ($this->Harga_Jual->Exportable) $Doc->ExportField($this->Harga_Jual);
					if ($this->Jumlah->Exportable) $Doc->ExportField($this->Jumlah);
					if ($this->Diskon->Exportable) $Doc->ExportField($this->Diskon);
					if ($this->Total_HJ->Exportable) $Doc->ExportField($this->Total_HJ);
				} else {
					if ($this->Kode->Exportable) $Doc->ExportField($this->Kode);
					if ($this->Nama_Barang->Exportable) $Doc->ExportField($this->Nama_Barang);
					if ($this->Satuan->Exportable) $Doc->ExportField($this->Satuan);
					if ($this->Harga_Jual->Exportable) $Doc->ExportField($this->Harga_Jual);
					if ($this->Jumlah->Exportable) $Doc->ExportField($this->Jumlah);
					if ($this->Diskon->Exportable) $Doc->ExportField($this->Diskon);
					if ($this->Total_HJ->Exportable) $Doc->ExportField($this->Total_HJ);
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
			$Doc->ExportAggregate($this->Kode, '');
			$Doc->ExportAggregate($this->Nama_Barang, '');
			$Doc->ExportAggregate($this->Satuan, '');
			$Doc->ExportAggregate($this->Harga_Jual, '');
			$Doc->ExportAggregate($this->Jumlah, 'TOTAL');
			$Doc->ExportAggregate($this->Diskon, '');
			$Doc->ExportAggregate($this->Total_HJ, 'TOTAL');
			$Doc->EndExportRow();
		}
		$Doc->ExportTableFooter();
	}

	// Add master User ID filter
	function AddMasterUserIDFilter($sFilter, $sCurrentMasterTable) {
		$sFilterWrk = $sFilter;
		if ($sCurrentMasterTable == "penjualan_2D_master") {
			$sFilterWrk = $GLOBALS["penjualan_2D_master"]->AddUserIDFilter($sFilterWrk);
		}
		return $sFilterWrk;
	}

	// Add detail User ID filter
	function AddDetailUserIDFilter($sFilter, $sCurrentMasterTable) {
		$sFilterWrk = $sFilter;
		if ($sCurrentMasterTable == "penjualan_2D_master") {
			$mastertable = $GLOBALS["penjualan_2D_master"];
			if (!$mastertable->UserIDAllow()) {
				$sSubqueryWrk = $mastertable->GetUserIDSubquery($this->IDM, $mastertable->ID);
				ew_AddFilter($sFilterWrk, $sSubqueryWrk);
			}
		}
		return $sFilterWrk;
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

		$this->Total_HJ->ViewValue = number_format($this->Total_HJ->ViewValue);   
		$this->Harga_Jual->ViewValue = number_format($this->Harga_Jual->ViewValue); 
	}                            

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>

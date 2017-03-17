<?php

// Global variable for table object
$daftar_produk = NULL;

//
// Table class for daftar produk
//
class cdaftar_produk extends cTable {
	var $ID;
	var $TglStok;
	var $Kode;
	var $Nama_Barang;
	var $Isi;
	var $Satuan;
	var $Berat;
	var $Harga_Pokok;
	var $Harga_Jual;
	var $Jumlah;
	var $Jumlah_Total;
	var $Supplier;
	var $Departemen;
	var $Foto;
	var $Waktu;
	var $Stamp;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'daftar_produk';
		$this->TableName = 'daftar produk';
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
		$this->ID = new cField('daftar_produk', 'daftar produk', 'x_ID', 'ID', '`ID`', '`ID`', 3, -1, FALSE, '`ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ID'] = &$this->ID;

		// TglStok
		$this->TglStok = new cField('daftar_produk', 'daftar produk', 'x_TglStok', 'TglStok', '`TglStok`', '`TglStok`', 200, -1, FALSE, '`TglStok`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['TglStok'] = &$this->TglStok;

		// Kode
		$this->Kode = new cField('daftar_produk', 'daftar produk', 'x_Kode', 'Kode', '`Kode`', '`Kode`', 200, -1, FALSE, '`Kode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode'] = &$this->Kode;

		// Nama Barang
		$this->Nama_Barang = new cField('daftar_produk', 'daftar produk', 'x_Nama_Barang', 'Nama Barang', '`Nama Barang`', '`Nama Barang`', 200, -1, FALSE, '`Nama Barang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nama Barang'] = &$this->Nama_Barang;

		// Isi
		$this->Isi = new cField('daftar_produk', 'daftar produk', 'x_Isi', 'Isi', '`Isi`', '`Isi`', 3, -1, FALSE, '`Isi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Isi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Isi'] = &$this->Isi;

		// Satuan
		$this->Satuan = new cField('daftar_produk', 'daftar produk', 'x_Satuan', 'Satuan', '`Satuan`', '`Satuan`', 200, -1, FALSE, '`Satuan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Satuan'] = &$this->Satuan;

		// Berat
		$this->Berat = new cField('daftar_produk', 'daftar produk', 'x_Berat', 'Berat', '`Berat`', '`Berat`', 5, -1, FALSE, '`Berat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Berat->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Berat'] = &$this->Berat;

		// Harga Pokok
		$this->Harga_Pokok = new cField('daftar_produk', 'daftar produk', 'x_Harga_Pokok', 'Harga Pokok', '`Harga Pokok`', '`Harga Pokok`', 3, -1, FALSE, '`Harga Pokok`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Harga_Pokok->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Harga Pokok'] = &$this->Harga_Pokok;

		// Harga Jual
		$this->Harga_Jual = new cField('daftar_produk', 'daftar produk', 'x_Harga_Jual', 'Harga Jual', '`Harga Jual`', '`Harga Jual`', 3, -1, FALSE, '`Harga Jual`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Harga_Jual->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Harga Jual'] = &$this->Harga_Jual;

		// Jumlah
		$this->Jumlah = new cField('daftar_produk', 'daftar produk', 'x_Jumlah', 'Jumlah', '`Jumlah`', '`Jumlah`', 3, -1, FALSE, '`Jumlah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Jumlah->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Jumlah'] = &$this->Jumlah;

		// Jumlah Total
		$this->Jumlah_Total = new cField('daftar_produk', 'daftar produk', 'x_Jumlah_Total', 'Jumlah Total', '`Jumlah Total`', '`Jumlah Total`', 3, -1, FALSE, '`Jumlah Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Jumlah_Total->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Jumlah Total'] = &$this->Jumlah_Total;

		// Supplier
		$this->Supplier = new cField('daftar_produk', 'daftar produk', 'x_Supplier', 'Supplier', '`Supplier`', '`Supplier`', 200, -1, FALSE, '`Supplier`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Supplier'] = &$this->Supplier;

		// Departemen
		$this->Departemen = new cField('daftar_produk', 'daftar produk', 'x_Departemen', 'Departemen', '`Departemen`', '`Departemen`', 200, -1, FALSE, '`Departemen`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Departemen'] = &$this->Departemen;

		// Foto
		$this->Foto = new cField('daftar_produk', 'daftar produk', 'x_Foto', 'Foto', '`Foto`', '`Foto`', 205, -1, TRUE, '`Foto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Foto'] = &$this->Foto;

		// Waktu
		$this->Waktu = new cField('daftar_produk', 'daftar produk', 'x_Waktu', 'Waktu', '`Waktu`', 'DATE_FORMAT(`Waktu`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Waktu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Waktu->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Waktu'] = &$this->Waktu;

		// Stamp
		$this->Stamp = new cField('daftar_produk', 'daftar produk', 'x_Stamp', 'Stamp', '`Stamp`', 'DATE_FORMAT(`Stamp`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Stamp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`daftar produk`";
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
	var $UpdateTable = "`daftar produk`";

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
			return "daftar_produklist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "daftar_produklist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("daftar_produkview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("daftar_produkview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "daftar_produkadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("daftar_produkedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("daftar_produkadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("daftar_produkdelete.php", $this->UrlParm());
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
		$this->TglStok->setDbValue($rs->fields('TglStok'));
		$this->Kode->setDbValue($rs->fields('Kode'));
		$this->Nama_Barang->setDbValue($rs->fields('Nama Barang'));
		$this->Isi->setDbValue($rs->fields('Isi'));
		$this->Satuan->setDbValue($rs->fields('Satuan'));
		$this->Berat->setDbValue($rs->fields('Berat'));
		$this->Harga_Pokok->setDbValue($rs->fields('Harga Pokok'));
		$this->Harga_Jual->setDbValue($rs->fields('Harga Jual'));
		$this->Jumlah->setDbValue($rs->fields('Jumlah'));
		$this->Jumlah_Total->setDbValue($rs->fields('Jumlah Total'));
		$this->Supplier->setDbValue($rs->fields('Supplier'));
		$this->Departemen->setDbValue($rs->fields('Departemen'));
		$this->Foto->Upload->DbValue = $rs->fields('Foto');
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

		// TglStok
		$this->TglStok->CellCssStyle = "white-space: nowrap;";

		// Kode
		// Nama Barang
		// Isi

		$this->Isi->CellCssStyle = "white-space: nowrap;";

		// Satuan
		// Berat

		$this->Berat->CellCssStyle = "white-space: nowrap;";

		// Harga Pokok
		// Harga Jual
		// Jumlah
		// Jumlah Total

		$this->Jumlah_Total->CellCssStyle = "white-space: nowrap;";

		// Supplier
		// Departemen

		$this->Departemen->CellCssStyle = "white-space: nowrap;";

		// Foto
		$this->Foto->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";

		// ID
		$this->ID->ViewValue = $this->ID->CurrentValue;
		$this->ID->ViewCustomAttributes = "";

		// TglStok
		$this->TglStok->ViewValue = $this->TglStok->CurrentValue;
		$this->TglStok->ViewCustomAttributes = "";

		// Kode
		$this->Kode->ViewValue = $this->Kode->CurrentValue;
		$this->Kode->ViewCustomAttributes = "";

		// Nama Barang
		$this->Nama_Barang->ViewValue = $this->Nama_Barang->CurrentValue;
		$this->Nama_Barang->ViewCustomAttributes = "";

		// Isi
		$this->Isi->ViewValue = $this->Isi->CurrentValue;
		$this->Isi->ViewCustomAttributes = "";

		// Satuan
		if (strval($this->Satuan->CurrentValue) <> "") {
			$sFilterWrk = "`Satuan`" . ew_SearchString("=", $this->Satuan->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Satuan`, `Satuan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar satuan`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->Satuan, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Satuan` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Satuan->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Satuan->ViewValue = $this->Satuan->CurrentValue;
			}
		} else {
			$this->Satuan->ViewValue = NULL;
		}
		$this->Satuan->ViewCustomAttributes = "";

		// Berat
		$this->Berat->ViewValue = $this->Berat->CurrentValue;
		$this->Berat->ViewCustomAttributes = "";

		// Harga Pokok
		$this->Harga_Pokok->ViewValue = $this->Harga_Pokok->CurrentValue;
		$this->Harga_Pokok->ViewValue = ew_FormatNumber($this->Harga_Pokok->ViewValue, 0, -2, -2, -2);
		$this->Harga_Pokok->CellCssStyle .= "text-align: right;";
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

		// Jumlah Total
		$this->Jumlah_Total->ViewValue = $this->Jumlah_Total->CurrentValue;
		$this->Jumlah_Total->ViewCustomAttributes = "";

		// Supplier
		if (strval($this->Supplier->CurrentValue) <> "") {
			$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Supplier->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `Nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar suplier`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->Supplier, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Kode` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Supplier->ViewValue = $rswrk->fields('DispFld');
				$this->Supplier->ViewValue .= ew_ValueSeparator(1,$this->Supplier) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->Supplier->ViewValue = $this->Supplier->CurrentValue;
			}
		} else {
			$this->Supplier->ViewValue = NULL;
		}
		$this->Supplier->ViewCustomAttributes = "";

		// Departemen
		$this->Departemen->ViewValue = $this->Departemen->CurrentValue;
		$this->Departemen->ViewCustomAttributes = "";

		// Foto
		if (!ew_Empty($this->Foto->Upload->DbValue)) {
			$this->Foto->ViewValue = $this->Foto->FldCaption();
		} else {
			$this->Foto->ViewValue = "";
		}
		$this->Foto->ViewCustomAttributes = "";

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

		// TglStok
		$this->TglStok->LinkCustomAttributes = "";
		$this->TglStok->HrefValue = "";
		$this->TglStok->TooltipValue = "";

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

		// Berat
		$this->Berat->LinkCustomAttributes = "";
		$this->Berat->HrefValue = "";
		$this->Berat->TooltipValue = "";

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

		// Jumlah Total
		$this->Jumlah_Total->LinkCustomAttributes = "";
		$this->Jumlah_Total->HrefValue = "";
		$this->Jumlah_Total->TooltipValue = "";

		// Supplier
		$this->Supplier->LinkCustomAttributes = "";
		$this->Supplier->HrefValue = "";
		$this->Supplier->TooltipValue = "";

		// Departemen
		$this->Departemen->LinkCustomAttributes = "";
		$this->Departemen->HrefValue = "";
		$this->Departemen->TooltipValue = "";

		// Foto
		$this->Foto->LinkCustomAttributes = "";
		if (!empty($this->Foto->Upload->DbValue)) {
			$this->Foto->HrefValue = "daftar_produk_Foto_bv.php?ID=" . $this->ID->CurrentValue;
			$this->Foto->LinkAttrs["target"] = "_blank";
			if ($this->Export <> "") $this->Foto->HrefValue = ew_ConvertFullUrl($this->Foto->HrefValue);
		} else {
			$this->Foto->HrefValue = "";
		}
		$this->Foto->HrefValue2 = "daftar_produk_Foto_bv.php?ID=" . $this->ID->CurrentValue;
		$this->Foto->TooltipValue = "";

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
				if ($this->Kode->Exportable) $Doc->ExportCaption($this->Kode);
				if ($this->Nama_Barang->Exportable) $Doc->ExportCaption($this->Nama_Barang);
				if ($this->Satuan->Exportable) $Doc->ExportCaption($this->Satuan);
				if ($this->Harga_Pokok->Exportable) $Doc->ExportCaption($this->Harga_Pokok);
				if ($this->Harga_Jual->Exportable) $Doc->ExportCaption($this->Harga_Jual);
				if ($this->Jumlah->Exportable) $Doc->ExportCaption($this->Jumlah);
				if ($this->Supplier->Exportable) $Doc->ExportCaption($this->Supplier);
			} else {
				if ($this->Kode->Exportable) $Doc->ExportCaption($this->Kode);
				if ($this->Nama_Barang->Exportable) $Doc->ExportCaption($this->Nama_Barang);
				if ($this->Satuan->Exportable) $Doc->ExportCaption($this->Satuan);
				if ($this->Harga_Pokok->Exportable) $Doc->ExportCaption($this->Harga_Pokok);
				if ($this->Harga_Jual->Exportable) $Doc->ExportCaption($this->Harga_Jual);
				if ($this->Jumlah->Exportable) $Doc->ExportCaption($this->Jumlah);
				if ($this->Supplier->Exportable) $Doc->ExportCaption($this->Supplier);
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
					if ($this->Kode->Exportable) $Doc->ExportField($this->Kode);
					if ($this->Nama_Barang->Exportable) $Doc->ExportField($this->Nama_Barang);
					if ($this->Satuan->Exportable) $Doc->ExportField($this->Satuan);
					if ($this->Harga_Pokok->Exportable) $Doc->ExportField($this->Harga_Pokok);
					if ($this->Harga_Jual->Exportable) $Doc->ExportField($this->Harga_Jual);
					if ($this->Jumlah->Exportable) $Doc->ExportField($this->Jumlah);
					if ($this->Supplier->Exportable) $Doc->ExportField($this->Supplier);
				} else {
					if ($this->Kode->Exportable) $Doc->ExportField($this->Kode);
					if ($this->Nama_Barang->Exportable) $Doc->ExportField($this->Nama_Barang);
					if ($this->Satuan->Exportable) $Doc->ExportField($this->Satuan);
					if ($this->Harga_Pokok->Exportable) $Doc->ExportField($this->Harga_Pokok);
					if ($this->Harga_Jual->Exportable) $Doc->ExportField($this->Harga_Jual);
					if ($this->Jumlah->Exportable) $Doc->ExportField($this->Jumlah);
					if ($this->Supplier->Exportable) $Doc->ExportField($this->Supplier);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
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

		$this->Harga_Pokok->ViewValue = number_format($this->Harga_Pokok->ViewValue);
		$this->Harga_Jual->ViewValue = number_format($this->Harga_Jual->ViewValue); 
		$this->Jumlah_Total->ViewValue = number_format($this->Jumlah_Total->ViewValue); 
	}                                                 

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>

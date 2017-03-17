<?php

// Global variable for table object
$Sisa_Stok = NULL;

//
// Table class for Sisa Stok
//
class cSisa_Stok extends cTable {
	var $Kode;
	var $Nama_Barang;
	var $Stok_Awal;
	var $Stok_Beli;
	var $Stok_Jual;
	var $Kode_Jual;
	var $Kode_Beli;
	var $Stok_Akhir;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'Sisa_Stok';
		$this->TableName = 'Sisa Stok';
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

		// Kode
		$this->Kode = new cField('Sisa_Stok', 'Sisa Stok', 'x_Kode', 'Kode', '`daftar produk`.Kode', '`daftar produk`.Kode', 200, -1, FALSE, '`daftar produk`.Kode', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode'] = &$this->Kode;

		// Nama Barang
		$this->Nama_Barang = new cField('Sisa_Stok', 'Sisa Stok', 'x_Nama_Barang', 'Nama Barang', '`daftar produk`.`Nama Barang`', '`daftar produk`.`Nama Barang`', 200, -1, FALSE, '`daftar produk`.`Nama Barang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Nama Barang'] = &$this->Nama_Barang;

		// Stok Awal
		$this->Stok_Awal = new cField('Sisa_Stok', 'Sisa Stok', 'x_Stok_Awal', 'Stok Awal', '`daftar produk`.Jumlah', '`daftar produk`.Jumlah', 3, -1, FALSE, '`daftar produk`.Jumlah', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Stok_Awal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Stok Awal'] = &$this->Stok_Awal;

		// Stok Beli
		$this->Stok_Beli = new cField('Sisa_Stok', 'Sisa Stok', 'x_Stok_Beli', 'Stok Beli', 'Sum(`pembelian - detail`.Jumlah)', 'Sum(`pembelian - detail`.Jumlah)', 5, -1, FALSE, 'Sum(`pembelian - detail`.Jumlah)', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Stok_Beli->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Stok Beli'] = &$this->Stok_Beli;

		// Stok Jual
		$this->Stok_Jual = new cField('Sisa_Stok', 'Sisa Stok', 'x_Stok_Jual', 'Stok Jual', 'Sum(`penjualan - detail`.Jumlah)', 'Sum(`penjualan - detail`.Jumlah)', 5, -1, FALSE, 'Sum(`penjualan - detail`.Jumlah)', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Stok_Jual->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Stok Jual'] = &$this->Stok_Jual;

		// Kode Jual
		$this->Kode_Jual = new cField('Sisa_Stok', 'Sisa Stok', 'x_Kode_Jual', 'Kode Jual', '`penjualan - detail`.Kode', '`penjualan - detail`.Kode', 200, -1, FALSE, '`penjualan - detail`.Kode', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode Jual'] = &$this->Kode_Jual;

		// Kode Beli
		$this->Kode_Beli = new cField('Sisa_Stok', 'Sisa Stok', 'x_Kode_Beli', 'Kode Beli', '`pembelian - detail`.Kode', '`pembelian - detail`.Kode', 200, -1, FALSE, '`pembelian - detail`.Kode', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode Beli'] = &$this->Kode_Beli;

		// Stok Akhir
		$this->Stok_Akhir = new cField('Sisa_Stok', 'Sisa Stok', 'x_Stok_Akhir', 'Stok Akhir', 'Sum(`daftar produk`.Jumlah - `penjualan - detail`.Jumlah)', 'Sum(`daftar produk`.Jumlah - `penjualan - detail`.Jumlah)', 5, -1, FALSE, 'Sum(`daftar produk`.Jumlah - `penjualan - detail`.Jumlah)', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Stok_Akhir->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Stok Akhir'] = &$this->Stok_Akhir;
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
		return "`daftar produk` Left Join `penjualan - detail` On `daftar produk`.Kode = `penjualan - detail`.Kode Left Join `pembelian - detail` On `daftar produk`.Kode = `pembelian - detail`.Kode";
	}

	function SqlSelect() { // Select
		return "SELECT `daftar produk`.Kode As Kode, `daftar produk`.`Nama Barang` As `Nama Barang`, `daftar produk`.Jumlah As `Stok Awal`, Sum(`penjualan - detail`.Jumlah) As `Stok Jual`, Sum(`pembelian - detail`.Jumlah) As `Stok Beli`, `penjualan - detail`.Kode As `Kode Jual`, `pembelian - detail`.Kode As `Kode Beli`, Sum(`daftar produk`.Jumlah - `penjualan - detail`.Jumlah) As `Stok Akhir` FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "`daftar produk`.Kode, `daftar produk`.`Nama Barang`, `daftar produk`.Jumlah, `penjualan - detail`.Kode, `pembelian - detail`.Kode";
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
	var $UpdateTable = "`daftar produk` Left Join `penjualan - detail` On `daftar produk`.Kode = `penjualan - detail`.Kode Left Join `pembelian - detail` On `daftar produk`.Kode = `pembelian - detail`.Kode";

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
			return "Sisa_Stoklist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "Sisa_Stoklist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("Sisa_Stokview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("Sisa_Stokview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "Sisa_Stokadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("Sisa_Stokedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("Sisa_Stokadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("Sisa_Stokdelete.php", $this->UrlParm());
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
		$this->Kode->setDbValue($rs->fields('Kode'));
		$this->Nama_Barang->setDbValue($rs->fields('Nama Barang'));
		$this->Stok_Awal->setDbValue($rs->fields('Stok Awal'));
		$this->Stok_Beli->setDbValue($rs->fields('Stok Beli'));
		$this->Stok_Jual->setDbValue($rs->fields('Stok Jual'));
		$this->Kode_Jual->setDbValue($rs->fields('Kode Jual'));
		$this->Kode_Beli->setDbValue($rs->fields('Kode Beli'));
		$this->Stok_Akhir->setDbValue($rs->fields('Stok Akhir'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Kode
		// Nama Barang
		// Stok Awal
		// Stok Beli
		// Stok Jual
		// Kode Jual
		// Kode Beli
		// Stok Akhir
		// Kode

		$this->Kode->ViewValue = $this->Kode->CurrentValue;
		$this->Kode->ViewCustomAttributes = "";

		// Nama Barang
		$this->Nama_Barang->ViewValue = $this->Nama_Barang->CurrentValue;
		$this->Nama_Barang->ViewCustomAttributes = "";

		// Stok Awal
		$this->Stok_Awal->ViewValue = $this->Stok_Awal->CurrentValue;
		$this->Stok_Awal->CellCssStyle .= "text-align: center;";
		$this->Stok_Awal->ViewCustomAttributes = "";

		// Stok Beli
		$this->Stok_Beli->ViewValue = $this->Stok_Beli->CurrentValue;
		$this->Stok_Beli->CellCssStyle .= "text-align: center;";
		$this->Stok_Beli->ViewCustomAttributes = "";

		// Stok Jual
		$this->Stok_Jual->ViewValue = $this->Stok_Jual->CurrentValue;
		$this->Stok_Jual->CellCssStyle .= "text-align: center;";
		$this->Stok_Jual->ViewCustomAttributes = "";

		// Kode Jual
		$this->Kode_Jual->ViewValue = $this->Kode_Jual->CurrentValue;
		$this->Kode_Jual->ViewCustomAttributes = "";

		// Kode Beli
		$this->Kode_Beli->ViewValue = $this->Kode_Beli->CurrentValue;
		$this->Kode_Beli->ViewCustomAttributes = "";

		// Stok Akhir
		$this->Stok_Akhir->ViewValue = $this->Stok_Akhir->CurrentValue;
		$this->Stok_Akhir->CellCssStyle .= "text-align: center;";
		$this->Stok_Akhir->ViewCustomAttributes = "";

		// Kode
		$this->Kode->LinkCustomAttributes = "";
		$this->Kode->HrefValue = "";
		$this->Kode->TooltipValue = "";

		// Nama Barang
		$this->Nama_Barang->LinkCustomAttributes = "";
		$this->Nama_Barang->HrefValue = "";
		$this->Nama_Barang->TooltipValue = "";

		// Stok Awal
		$this->Stok_Awal->LinkCustomAttributes = "";
		$this->Stok_Awal->HrefValue = "";
		$this->Stok_Awal->TooltipValue = "";

		// Stok Beli
		$this->Stok_Beli->LinkCustomAttributes = "";
		$this->Stok_Beli->HrefValue = "";
		$this->Stok_Beli->TooltipValue = "";

		// Stok Jual
		$this->Stok_Jual->LinkCustomAttributes = "";
		$this->Stok_Jual->HrefValue = "";
		$this->Stok_Jual->TooltipValue = "";

		// Kode Jual
		$this->Kode_Jual->LinkCustomAttributes = "";
		$this->Kode_Jual->HrefValue = "";
		$this->Kode_Jual->TooltipValue = "";

		// Kode Beli
		$this->Kode_Beli->LinkCustomAttributes = "";
		$this->Kode_Beli->HrefValue = "";
		$this->Kode_Beli->TooltipValue = "";

		// Stok Akhir
		$this->Stok_Akhir->LinkCustomAttributes = "";
		$this->Stok_Akhir->HrefValue = "";
		$this->Stok_Akhir->TooltipValue = "";

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
				if ($this->Stok_Awal->Exportable) $Doc->ExportCaption($this->Stok_Awal);
				if ($this->Stok_Beli->Exportable) $Doc->ExportCaption($this->Stok_Beli);
				if ($this->Stok_Jual->Exportable) $Doc->ExportCaption($this->Stok_Jual);
				if ($this->Kode_Jual->Exportable) $Doc->ExportCaption($this->Kode_Jual);
				if ($this->Kode_Beli->Exportable) $Doc->ExportCaption($this->Kode_Beli);
				if ($this->Stok_Akhir->Exportable) $Doc->ExportCaption($this->Stok_Akhir);
			} else {
				if ($this->Kode->Exportable) $Doc->ExportCaption($this->Kode);
				if ($this->Nama_Barang->Exportable) $Doc->ExportCaption($this->Nama_Barang);
				if ($this->Stok_Awal->Exportable) $Doc->ExportCaption($this->Stok_Awal);
				if ($this->Stok_Beli->Exportable) $Doc->ExportCaption($this->Stok_Beli);
				if ($this->Stok_Jual->Exportable) $Doc->ExportCaption($this->Stok_Jual);
				if ($this->Kode_Jual->Exportable) $Doc->ExportCaption($this->Kode_Jual);
				if ($this->Kode_Beli->Exportable) $Doc->ExportCaption($this->Kode_Beli);
				if ($this->Stok_Akhir->Exportable) $Doc->ExportCaption($this->Stok_Akhir);
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
					if ($this->Stok_Awal->Exportable) $Doc->ExportField($this->Stok_Awal);
					if ($this->Stok_Beli->Exportable) $Doc->ExportField($this->Stok_Beli);
					if ($this->Stok_Jual->Exportable) $Doc->ExportField($this->Stok_Jual);
					if ($this->Kode_Jual->Exportable) $Doc->ExportField($this->Kode_Jual);
					if ($this->Kode_Beli->Exportable) $Doc->ExportField($this->Kode_Beli);
					if ($this->Stok_Akhir->Exportable) $Doc->ExportField($this->Stok_Akhir);
				} else {
					if ($this->Kode->Exportable) $Doc->ExportField($this->Kode);
					if ($this->Nama_Barang->Exportable) $Doc->ExportField($this->Nama_Barang);
					if ($this->Stok_Awal->Exportable) $Doc->ExportField($this->Stok_Awal);
					if ($this->Stok_Beli->Exportable) $Doc->ExportField($this->Stok_Beli);
					if ($this->Stok_Jual->Exportable) $Doc->ExportField($this->Stok_Jual);
					if ($this->Kode_Jual->Exportable) $Doc->ExportField($this->Kode_Jual);
					if ($this->Kode_Beli->Exportable) $Doc->ExportField($this->Kode_Beli);
					if ($this->Stok_Akhir->Exportable) $Doc->ExportField($this->Stok_Akhir);
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

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>

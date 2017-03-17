<?php

// Global variable for table object
$persewaan_lapangan_2D_detail = NULL;

//
// Table class for persewaan lapangan - detail
//
class cpersewaan_lapangan_2D_detail extends cTable {
	var $ID;
	var $Kode;
	var $NamaLapangan;
	var $TglSewa;
	var $JamSewa;
	var $HargaSewa;
	var $Hitung;
	var $Status;
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
		$this->TableVar = 'persewaan_lapangan_2D_detail';
		$this->TableName = 'persewaan lapangan - detail';
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
		$this->ID = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_ID', 'ID', '`ID`', '`ID`', 3, -1, FALSE, '`ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ID'] = &$this->ID;

		// Kode
		$this->Kode = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_Kode', 'Kode', '`Kode`', '`Kode`', 200, -1, FALSE, '`Kode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Kode'] = &$this->Kode;

		// NamaLapangan
		$this->NamaLapangan = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_NamaLapangan', 'NamaLapangan', '`NamaLapangan`', '`NamaLapangan`', 200, -1, FALSE, '`NamaLapangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['NamaLapangan'] = &$this->NamaLapangan;

		// TglSewa
		$this->TglSewa = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_TglSewa', 'TglSewa', '`TglSewa`', 'DATE_FORMAT(`TglSewa`, \'%d/%m/%Y\')', 133, 7, FALSE, '`TglSewa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->TglSewa->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['TglSewa'] = &$this->TglSewa;

		// JamSewa
		$this->JamSewa = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_JamSewa', 'JamSewa', '`JamSewa`', 'DATE_FORMAT(`JamSewa`, \'%d/%m/%Y\')', 134, 4, FALSE, '`JamSewa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->JamSewa->FldDefaultErrMsg = $Language->Phrase("IncorrectTime");
		$this->fields['JamSewa'] = &$this->JamSewa;

		// HargaSewa
		$this->HargaSewa = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_HargaSewa', 'HargaSewa', '`HargaSewa`', '`HargaSewa`', 3, -1, FALSE, '`HargaSewa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->HargaSewa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['HargaSewa'] = &$this->HargaSewa;

		// Hitung
		$this->Hitung = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_Hitung', 'Hitung', '`Hitung`', '`Hitung`', 200, -1, FALSE, '`Hitung`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Hitung'] = &$this->Hitung;

		// Status
		$this->Status = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_Status', 'Status', '`Status`', '`Status`', 200, -1, FALSE, '`Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Status'] = &$this->Status;

		// IDM
		$this->IDM = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_IDM', 'IDM', '`IDM`', '`IDM`', 3, -1, FALSE, '`IDM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->IDM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IDM'] = &$this->IDM;

		// Waktu
		$this->Waktu = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_Waktu', 'Waktu', '`Waktu`', 'DATE_FORMAT(`Waktu`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Waktu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Waktu->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Waktu'] = &$this->Waktu;

		// Stamp
		$this->Stamp = new cField('persewaan_lapangan_2D_detail', 'persewaan lapangan - detail', 'x_Stamp', 'Stamp', '`Stamp`', 'DATE_FORMAT(`Stamp`, \'%d/%m/%Y\')', 135, 7, FALSE, '`Stamp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		if ($this->getCurrentMasterTable() == "persewaan_lapangan_2D_master") {
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
		if ($this->getCurrentMasterTable() == "persewaan_lapangan_2D_master") {
			if ($this->IDM->getSessionValue() <> "")
				$sDetailFilter .= "`IDM`=" . ew_QuotedValue($this->IDM->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_persewaan_lapangan_2D_master() {
		return "`ID`=@ID@";
	}

	// Detail filter
	function SqlDetailFilter_persewaan_lapangan_2D_master() {
		return "`IDM`=@IDM@";
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`persewaan lapangan - detail`";
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
	var $UpdateTable = "`persewaan lapangan - detail`";

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
			return "persewaan_lapangan_2D_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "persewaan_lapangan_2D_detaillist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("persewaan_lapangan_2D_detailview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("persewaan_lapangan_2D_detailview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "persewaan_lapangan_2D_detailadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("persewaan_lapangan_2D_detailedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("persewaan_lapangan_2D_detailadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("persewaan_lapangan_2D_detaildelete.php", $this->UrlParm());
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
		$this->NamaLapangan->setDbValue($rs->fields('NamaLapangan'));
		$this->TglSewa->setDbValue($rs->fields('TglSewa'));
		$this->JamSewa->setDbValue($rs->fields('JamSewa'));
		$this->HargaSewa->setDbValue($rs->fields('HargaSewa'));
		$this->Hitung->setDbValue($rs->fields('Hitung'));
		$this->Status->setDbValue($rs->fields('Status'));
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
		// NamaLapangan
		// TglSewa
		// JamSewa
		// HargaSewa
		// Hitung

		$this->Hitung->CellCssStyle = "white-space: nowrap;";

		// Status
		$this->Status->CellCssStyle = "white-space: nowrap;";

		// IDM
		$this->IDM->CellCssStyle = "white-space: nowrap;";

		// Waktu
		$this->Waktu->CellCssStyle = "white-space: nowrap;";

		// Stamp
		$this->Stamp->CellCssStyle = "white-space: nowrap;";

		// ID
		$this->ID->ViewValue = $this->ID->CurrentValue;
		$this->ID->ViewCustomAttributes = "";

		// Kode
		if (strval($this->Kode->CurrentValue) <> "") {
			$sFilterWrk = "`Kode`" . ew_SearchString("=", $this->Kode->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `Kode`, `Kode` AS `DispFld`, `NamaLapangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `daftar lapangan`";
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
		$this->Kode->ViewCustomAttributes = "";

		// NamaLapangan
		$this->NamaLapangan->ViewValue = $this->NamaLapangan->CurrentValue;
		$this->NamaLapangan->ViewCustomAttributes = "";

		// TglSewa
		$this->TglSewa->ViewValue = $this->TglSewa->CurrentValue;
		$this->TglSewa->ViewValue = ew_FormatDateTime($this->TglSewa->ViewValue, 7);
		$this->TglSewa->CellCssStyle .= "text-align: center;";
		$this->TglSewa->ViewCustomAttributes = "";

		// JamSewa
		if (strval($this->JamSewa->CurrentValue) <> "") {
			switch ($this->JamSewa->CurrentValue) {
				case $this->JamSewa->FldTagValue(1):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(1) <> "" ? $this->JamSewa->FldTagCaption(1) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(2):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(2) <> "" ? $this->JamSewa->FldTagCaption(2) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(3):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(3) <> "" ? $this->JamSewa->FldTagCaption(3) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(4):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(4) <> "" ? $this->JamSewa->FldTagCaption(4) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(5):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(5) <> "" ? $this->JamSewa->FldTagCaption(5) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(6):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(6) <> "" ? $this->JamSewa->FldTagCaption(6) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(7):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(7) <> "" ? $this->JamSewa->FldTagCaption(7) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(8):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(8) <> "" ? $this->JamSewa->FldTagCaption(8) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(9):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(9) <> "" ? $this->JamSewa->FldTagCaption(9) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(10):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(10) <> "" ? $this->JamSewa->FldTagCaption(10) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(11):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(11) <> "" ? $this->JamSewa->FldTagCaption(11) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(12):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(12) <> "" ? $this->JamSewa->FldTagCaption(12) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(13):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(13) <> "" ? $this->JamSewa->FldTagCaption(13) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(14):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(14) <> "" ? $this->JamSewa->FldTagCaption(14) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(15):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(15) <> "" ? $this->JamSewa->FldTagCaption(15) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(16):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(16) <> "" ? $this->JamSewa->FldTagCaption(16) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(17):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(17) <> "" ? $this->JamSewa->FldTagCaption(17) : $this->JamSewa->CurrentValue;
					break;
				case $this->JamSewa->FldTagValue(18):
					$this->JamSewa->ViewValue = $this->JamSewa->FldTagCaption(18) <> "" ? $this->JamSewa->FldTagCaption(18) : $this->JamSewa->CurrentValue;
					break;
				default:
					$this->JamSewa->ViewValue = $this->JamSewa->CurrentValue;
			}
		} else {
			$this->JamSewa->ViewValue = NULL;
		}
		$this->JamSewa->ViewValue = ew_FormatDateTime($this->JamSewa->ViewValue, 4);
		$this->JamSewa->CellCssStyle .= "text-align: center;";
		$this->JamSewa->ViewCustomAttributes = "";

		// HargaSewa
		$this->HargaSewa->ViewValue = $this->HargaSewa->CurrentValue;
		$this->HargaSewa->ViewValue = ew_FormatNumber($this->HargaSewa->ViewValue, 0, -2, -2, -2);
		$this->HargaSewa->CellCssStyle .= "text-align: right;";
		$this->HargaSewa->ViewCustomAttributes = "";

		// Hitung
		$this->Hitung->ViewValue = $this->Hitung->CurrentValue;
		$this->Hitung->ViewCustomAttributes = "";

		// Status
		if (strval($this->Status->CurrentValue) <> "") {
			switch ($this->Status->CurrentValue) {
				case $this->Status->FldTagValue(1):
					$this->Status->ViewValue = $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->CurrentValue;
					break;
				case $this->Status->FldTagValue(2):
					$this->Status->ViewValue = $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->CurrentValue;
					break;
				default:
					$this->Status->ViewValue = $this->Status->CurrentValue;
			}
		} else {
			$this->Status->ViewValue = NULL;
		}
		$this->Status->ViewCustomAttributes = "";

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

		// NamaLapangan
		$this->NamaLapangan->LinkCustomAttributes = "";
		$this->NamaLapangan->HrefValue = "";
		$this->NamaLapangan->TooltipValue = "";

		// TglSewa
		$this->TglSewa->LinkCustomAttributes = "";
		$this->TglSewa->HrefValue = "";
		$this->TglSewa->TooltipValue = "";

		// JamSewa
		$this->JamSewa->LinkCustomAttributes = "";
		$this->JamSewa->HrefValue = "";
		$this->JamSewa->TooltipValue = "";

		// HargaSewa
		$this->HargaSewa->LinkCustomAttributes = "";
		$this->HargaSewa->HrefValue = "";
		$this->HargaSewa->TooltipValue = "";

		// Hitung
		$this->Hitung->LinkCustomAttributes = "";
		if (!ew_Empty($this->IDM->CurrentValue)) {
			$this->Hitung->HrefValue = "AppHitung.php?id=" . ((!empty($this->IDM->ViewValue)) ? $this->IDM->ViewValue : $this->IDM->CurrentValue); // Add prefix/suffix
			$this->Hitung->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->Hitung->HrefValue = ew_ConvertFullUrl($this->Hitung->HrefValue);
		} else {
			$this->Hitung->HrefValue = "";
		}
		$this->Hitung->TooltipValue = "";

		// Status
		$this->Status->LinkCustomAttributes = "";
		$this->Status->HrefValue = "";
		$this->Status->TooltipValue = "";

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
			if (is_numeric($this->HargaSewa->CurrentValue))
				$this->HargaSewa->Total += $this->HargaSewa->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->HargaSewa->CurrentValue = $this->HargaSewa->Total;
			$this->HargaSewa->ViewValue = $this->HargaSewa->CurrentValue;
			$this->HargaSewa->ViewValue = ew_FormatNumber($this->HargaSewa->ViewValue, 0, -2, -2, -2);
			$this->HargaSewa->CellCssStyle .= "text-align: right;";
			$this->HargaSewa->ViewCustomAttributes = "";
			$this->HargaSewa->HrefValue = ""; // Clear href value
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
				if ($this->NamaLapangan->Exportable) $Doc->ExportCaption($this->NamaLapangan);
				if ($this->TglSewa->Exportable) $Doc->ExportCaption($this->TglSewa);
				if ($this->JamSewa->Exportable) $Doc->ExportCaption($this->JamSewa);
				if ($this->HargaSewa->Exportable) $Doc->ExportCaption($this->HargaSewa);
			} else {
				if ($this->Kode->Exportable) $Doc->ExportCaption($this->Kode);
				if ($this->NamaLapangan->Exportable) $Doc->ExportCaption($this->NamaLapangan);
				if ($this->TglSewa->Exportable) $Doc->ExportCaption($this->TglSewa);
				if ($this->JamSewa->Exportable) $Doc->ExportCaption($this->JamSewa);
				if ($this->HargaSewa->Exportable) $Doc->ExportCaption($this->HargaSewa);
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
					if ($this->NamaLapangan->Exportable) $Doc->ExportField($this->NamaLapangan);
					if ($this->TglSewa->Exportable) $Doc->ExportField($this->TglSewa);
					if ($this->JamSewa->Exportable) $Doc->ExportField($this->JamSewa);
					if ($this->HargaSewa->Exportable) $Doc->ExportField($this->HargaSewa);
				} else {
					if ($this->Kode->Exportable) $Doc->ExportField($this->Kode);
					if ($this->NamaLapangan->Exportable) $Doc->ExportField($this->NamaLapangan);
					if ($this->TglSewa->Exportable) $Doc->ExportField($this->TglSewa);
					if ($this->JamSewa->Exportable) $Doc->ExportField($this->JamSewa);
					if ($this->HargaSewa->Exportable) $Doc->ExportField($this->HargaSewa);
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
			$Doc->ExportAggregate($this->NamaLapangan, '');
			$Doc->ExportAggregate($this->TglSewa, '');
			$Doc->ExportAggregate($this->JamSewa, '');
			$Doc->ExportAggregate($this->HargaSewa, 'TOTAL');
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

		$this->HargaSewa->ViewValue = number_format($this->HargaSewa->ViewValue); 
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>

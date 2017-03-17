<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(37, $Language->MenuPhrase("37", "MenuText"), "index.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(38, $Language->MenuPhrase("38", "MenuText"), "", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(3, $Language->MenuPhrase("3", "MenuText"), "daftar_lapanganlist.php", 38, "", AllowListMenu('{FB59CACA-F11C-4CE1-B69A-4810252F4810}daftar lapangan'), FALSE);
$RootMenu->AddMenuItem(4, $Language->MenuPhrase("4", "MenuText"), "daftar_pelangganlist.php", 38, "", AllowListMenu('{FB59CACA-F11C-4CE1-B69A-4810252F4810}daftar pelanggan'), FALSE);
$RootMenu->AddMenuItem(13, $Language->MenuPhrase("13", "MenuText"), "daftar_produklist.php", 38, "", AllowListMenu('{FB59CACA-F11C-4CE1-B69A-4810252F4810}daftar produk'), FALSE);
$RootMenu->AddMenuItem(15, $Language->MenuPhrase("15", "MenuText"), "daftar_suplierlist.php", 38, "", AllowListMenu('{FB59CACA-F11C-4CE1-B69A-4810252F4810}daftar suplier'), FALSE);
$RootMenu->AddMenuItem(14, $Language->MenuPhrase("14", "MenuText"), "daftar_satuanlist.php", 38, "", AllowListMenu('{FB59CACA-F11C-4CE1-B69A-4810252F4810}daftar satuan'), FALSE);
$RootMenu->AddMenuItem(39, $Language->MenuPhrase("39", "MenuText"), "", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(40, $Language->MenuPhrase("40", "MenuText"), "persewaan_lapangan_2D_masterlist.php?t=persewaan_lapangan_2D_master&z_Status=LIKE&x_Status=Booking&psearch=&Submit=Search+%28*%29&psearchtype=", 39, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(41, $Language->MenuPhrase("41", "MenuText"), "persewaan_lapangan_2D_masterlist.php?cmd=reset", 39, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(42, $Language->MenuPhrase("42", "MenuText"), "persewaan_lapangan_2D_masteradd.php", 39, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(43, $Language->MenuPhrase("43", "MenuText"), "", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(44, $Language->MenuPhrase("44", "MenuText"), "Bookinglist.php?cmd=reset", 43, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(45, $Language->MenuPhrase("45", "MenuText"), "", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(47, $Language->MenuPhrase("47", "MenuText"), "penjualan_2D_masterlist.php", 45, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(48, $Language->MenuPhrase("48", "MenuText"), "pembelian_2D_masterlist.php", 45, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(49, $Language->MenuPhrase("49", "MenuText"), "", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(50, $Language->MenuPhrase("50", "MenuText"), "", 49, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(53, $Language->MenuPhrase("53", "MenuText"), "Laporan_Daftar_Lapanganreport.php", 50, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(54, $Language->MenuPhrase("54", "MenuText"), "Laporan_Daftar_Pelangganreport.php", 50, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(51, $Language->MenuPhrase("51", "MenuText"), "", 49, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(55, $Language->MenuPhrase("55", "MenuText"), "Rekapitulasi_Persewaanlist.php", 51, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(56, $Language->MenuPhrase("56", "MenuText"), "Sisa_Bayarlist.php", 51, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(52, $Language->MenuPhrase("52", "MenuText"), "", 49, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(57, $Language->MenuPhrase("57", "MenuText"), "Rekapitulasi_Penjualanlist.php", 52, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(58, $Language->MenuPhrase("58", "MenuText"), "Rekapitulasi_Pembelianlist.php", 52, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(59, $Language->MenuPhrase("59", "MenuText"), "lapstokedit.php?ID=1", 52, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(60, $Language->MenuPhrase("60", "MenuText"), "Penjualan_Belum_Lunaslist.php", 52, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(61, $Language->MenuPhrase("61", "MenuText"), "Pembelian_Belum_Lunaslist.php", 52, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(46, $Language->MenuPhrase("46", "MenuText"), "", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(1, $Language->MenuPhrase("1", "MenuText"), "_2padminlist.php", 46, "", AllowListMenu('{FB59CACA-F11C-4CE1-B69A-4810252F4810}2padmin'), FALSE);
$RootMenu->AddMenuItem(66, $Language->MenuPhrase("66", "MenuText"), "profileedit.php?ID=1", 46, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(62, $Language->MenuPhrase("62", "MenuText"), "", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(67, $Language->MenuPhrase("67", "MenuText"), "AppBackup.php", 62, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(68, $Language->MenuPhrase("68", "MenuText"), "AppRestore.php", 62, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(69, $Language->MenuPhrase("69", "MenuText"), "AppReset.php", 62, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(27, $Language->MenuPhrase("27", "MenuText"), "_menulist.php", -1, "", AllowListMenu('{FB59CACA-F11C-4CE1-B69A-4810252F4810}menu'), FALSE);
$RootMenu->AddMenuItem(64, $Language->MenuPhrase("64", "MenuText"), "AppHelp.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(-1, $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->

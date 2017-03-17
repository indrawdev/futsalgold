<?php

// Compatibility with PHP Report Maker 3
if (!isset($Language)) {
	include_once "ewcfg7.php";
	include_once "ewshared7.php";
	$Language = new cLanguage();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?php echo $Language->ProjectPhrase("BodyTitle") ?></title>
<?php if (@$gsExport == "") { ?>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0/build/button/assets/skins/sam/button.css">
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0/build/container/assets/skins/sam/container.css">
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0/build/autocomplete/assets/skins/sam/autocomplete.css">
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo EW_PROJECT_STYLESHEET_FILENAME ?>">
<?php } ?>
<meta name="generator" content="PHPMaker v7.0.0.0">

<script type="text/javascript" src="Themes/script.js"></script>

<link rel="stylesheet" href="Themes/style.css" type="text/css" media="screen" />

<style type="text/css">
<!--
html { 
	background: url(Image/BG.jpg) no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
-->
</style>

</head>
<body class="yui-skin-sam">
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0/build/utilities/utilities.js"></script>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0/build/button/button-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0/build/container/container-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0/build/datasource/datasource-min.js"></script>
<script type="text/javascript">
<!--
var EW_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EW_DATE_SEPARATOR = "/"; 
if (EW_DATE_SEPARATOR == "") EW_DATE_SEPARATOR = "/"; // Default date separator
var EW_UPLOAD_ALLOWED_FILE_EXT = "gif,jpg,jpeg,bmp,png,doc,xls,pdf,zip"; // Allowed upload file extension
var EW_FIELD_SEP = ", "; // Default field separator

// Ajax settings
var EW_RECORD_DELIMITER = "\r";
var EW_FIELD_DELIMITER = "|";
var EW_LOOKUP_FILE_NAME = "ewlookup7.php"; // lookup file name

// Common JavaScript messages
var EW_ADDOPT_BUTTON_SUBMIT_TEXT = "<?php echo ew_JsEncode2(ew_BtnCaption($Language->Phrase("AddBtn"))) ?>";
var EW_EMAIL_EXPORT_BUTTON_SUBMIT_TEXT = "<?php echo ew_JsEncode2(ew_BtnCaption($Language->Phrase("SendEmailBtn"))) ?>";
var EW_BUTTON_CANCEL_TEXT = "<?php echo ew_JsEncode2(ew_BtnCaption($Language->Phrase("CancelBtn"))) ?>";
var EW_MAX_EMAIL_RECIPIENT = <?php echo EW_MAX_EMAIL_RECIPIENT ?>;

//-->
</script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript" src="js/ewp7.js"></script>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="js/userfn7.js"></script>
<script type="text/javascript">
<!--
<?php echo $Language->ToJSON() ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js");
//-->

</script>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<div class="ewLayoutx">
	<!-- header (begin) --><!-- *** Note: Only licensed users are allowed to change the logo *** -->
 
 <div id="art-main">
        <div class="art-Sheet">
            <div class="art-Sheet-tl"></div>
            <div class="art-Sheet-tr"></div>
            <div class="art-Sheet-bl"></div>
            <div class="art-Sheet-br"></div>
            <div class="art-Sheet-tc"></div>
            <div class="art-Sheet-bc"></div>
            <div class="art-Sheet-cl"></div>
            <div class="art-Sheet-cr"></div>
            <div class="art-Sheet-cc"></div>
            <div class="art-Sheet-body">
                <div class="art-Header">
                    <div class="art-Header-jpeg"></div>
                    
                </div>
				
				
				
                <div class="art-nav">
                	<div class="l"></div>
                	<div class="r"></div>
                	<ul class="art-menu">
					
                		<? if (CurrentUserLevel()==-1 || CurrentUserLevel()==1){ ?>
						<li>
                			<a><span class="l"></span><span class="r"></span><span class="t">Master</span></a>
                			<ul>
                				<li><a href="daftar_lapanganlist.php">Lapangan</a></li>
                				<li><a href="daftar_pelangganlist.php">Pelanggan</a></li>
								<li><a href="daftar_produklist.php">Produk Kantin</a></li>
								<li><a href="daftar_suplierlist.php">Suplier Kantin</a></li>
							    <li><a href="daftar_satuanlist.php">Satuan</a></li> 
                			</ul>
                		</li>
						<? } ?>
						<? if (CurrentUserLevel()==-1 || CurrentUserLevel()==1){ ?>
                		<li>
                			<a><span class="l"></span><span class="r"></span><span class="t">Persewaan</span></a>
                			<ul>
                				<li><a href="persewaan_lapangan_2D_masterlist.php?t=persewaan_lapangan_2D_master&z_Status=LIKE&x_Status=Booking&psearch=&Submit=Search+%28*%29&psearchtype=">Sewa Lapangan / Booking</a></li>
                				<li><a href="persewaan_lapangan_2D_masterlist.php?cmd=reset">Browse Semua Transaksi</a></li>
								<li><a href="persewaan_lapangan_2D_masteradd.php">Transaksi Baru</a></li>									
                			</ul>
                		</li>
						
						<li>
                			<a><span class="l"></span><span class="r"></span><span class="t">Booking</span></a>
                			<ul>
                				<li><a href="Bookinglist.php?cmd=reset">Daftar Booking Lapangan</a></li>
                											
                			</ul>
                		</li>
						
						<li><a><span class="l"></span><span class="r"></span><span class="t">Kantin</span></a>
									<ul>
										<li><a href="penjualan_2D_masterlist.php">Penjualan</a></li>
										<li><a href="pembelian_2D_masterlist.php">Pembelian / Tambah Stok</a></li>										           				
									</ul>								
						</li>
						
						<? } ?>
						<? if (CurrentUserLevel()==-1){ ?>
						<li>
                			<a><span class="l"></span><span class="r"></span><span class="t">Laporan</span></a>
                			<ul>
                            	<li><a>Master</a>
								<ul>	
									<li><a href="Laporan_Daftar_Lapanganreport.php">Master Lapangan</a></li>
									<li><a href="Laporan_Daftar_Pelangganreport.php">Master Pelanggan</a></li>
								</ul>								
								</li>
								
                				<li><a>Persewaan</a>
									<ul>
										<li><a href="Rekapitulasi_Persewaanlist.php">Browse Rekapitulasi Persewaan</a></li>
										<li><a href="Sisa_Bayarlist.php">Browse Transaksi Belum Lunas</a></li>	
									</ul>	
								
								</li>							
                				
								
								<li><a>Kantin</a>
									<ul>
										<li><a href="Rekapitulasi_Penjualanlist.php">Rekapitulasi Penjualan</a></li>
									    <li><a href="Rekapitulasi_Pembelianlist.php">Rekapitulasi Pembelian</a></li>									
										<li><a href="AppCetakStokBarang.php">Stok Barang Kantin</a></li>
										<li><a href="Penjualan_Belum_Lunaslist.php">Penjualan Belum Lunas</a></li>
										<li><a href="Pembelian_Belum_Lunaslist.php">Pembelian Belum Lunas</a></li>	
									</ul>								
								</li>
								
								
                			</ul>
                		</li>						
                		<li>
                			<a><span class="l"></span><span class="r"></span><span class="t">Setting</span></a>
                			<ul>
                				<li><a href="z2padminlist.php">Admin</a></li>
                				<li><a href="profilelist.php">Profil</a></li>
                				<li><a href="AppLisensi.php">Lisensi</a></li>								
                			</ul>
                		</li>
						<li>
                			<a><span class="l"></span><span class="r"></span><span class="t">Tools</span></a>
                			<ul>
                				<li><a href="AppBackup.php">Backup</a></li>
                				<li><a href="AppRestore.php">Restore</a></li>
                				<li><a href="AppReset.php">Reset Data</a></li>								
                			</ul>
                		</li>
                        <li>
                			<a href="AppHelp.php"><span class="l"></span><span class="r"></span><span class="t">Help</span></a>
                		</li>
						<? } ?>
						<? if (CurrentUserLevel()==-1 || CurrentUserLevel()==1){ ?>						
						<li>
                			<a href="logout.php"><span class="l"></span><span class="r"></span><span class="t">Logout</span></a>
                		</li>
						<? } ?>
						
						<? if (CurrentUserLevel()==0){ ?>
						<li>
                			<a href="index.php"><span class="l"></span><span class="r"></span><span class="t">Home</span></a>
                		</li>
						<? } ?>
                	</ul>
                </div>
				
							
				
				
                <div class="art-contentLayout">
                    <div class="art-content">
 
 
	<!-- header (end) -->
	<!-- content (begin) -->
  <table cellspacing="0" class="ewContentTable">
		<tr>	
			<td class="ewMenuColumn">
			<!-- left column (begin) -->
<?php //include "ewmenu.php" ?>
			<!-- left column (end) -->
			</td>
	    <td class="ewContentColumn">
			<!-- right column (begin) -->
				<p class="phpmaker"><b><?php echo $Language->ProjectPhrase("BodyTitle") ?></b></p>
<?php } ?>

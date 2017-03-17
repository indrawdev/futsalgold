<?php

// Compatibility with Report Maker
if (!isset($Language)) {
	include_once "ewcfg10.php";
	include_once "ewshared10.php";
	$Language = new cLanguage();
}
?>
<?php  include "Connections/DS.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $Language->ProjectPhrase("BodyTitle") ?></title>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<?php } ?>
<?php if (@$gsExport == "") { ?>
<link rel="stylesheet" href="phpcss/jquery.fileupload-ui.css">
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo EW_PROJECT_STYLESHEET_FILENAME ?>">
<?php 
mysql_select_db($database_DS, $DS);
$query_Mob = "SELECT * FROM `profile`";
$Mob = mysql_query($query_Mob, $DS) or die(mysql_error());
$row_Mob = mysql_fetch_assoc($Mob);
?>
<?php if (ew_IsMobile() AND $row_Mob['Mobile']==1) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="phpcss/ewmobile.css">
<?php } ?>
<?php if (@$gsExport == "print" && @$_GET["pdf"] == "1" && EW_PDF_STYLESHEET_FILENAME <> "") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo EW_PDF_STYLESHEET_FILENAME ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo ew_jQueryFile("jquery-%v.min.js") ?>"></script>
<?php if (ew_IsMobile() AND $row_Mob['Mobile']==1) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo ew_jQueryFile("jquery.mobile-%v.min.css") ?>">
<script type="text/javascript">
jQuery(document).bind("mobileinit", function() {
	jQuery.mobile.ajaxEnabled = false;
	jQuery.mobile.ignoreContentEnabled = true;
});
</script>
<script type="text/javascript" src="<?php echo ew_jQueryFile("jquery.mobile-%v.min.js") ?>"></script>
<?php } ?>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="jqueryfileupload/jquery.ui.widget.js"></script>
<script type="text/javascript" src="jqueryfileupload/jqueryfileupload.min.js"></script>
<link href="calendar/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="calendar/calendar.min.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script type="text/javascript" src="phpjs/ewcalendar.js"></script>
<script type="text/javascript">
var EW_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EW_DATE_SEPARATOR = "/" || "/"; // Default date separator
var EW_DECIMAL_POINT = "<?php echo $DEFAULT_DECIMAL_POINT ?>";
var EW_THOUSANDS_SEP = "<?php echo $DEFAULT_THOUSANDS_SEP ?>";
var EW_MAX_FILE_SIZE = <?php echo EW_MAX_FILE_SIZE ?>; // Upload max file size
var EW_UPLOAD_ALLOWED_FILE_EXT = "gif,jpg,jpeg,bmp,png,doc,xls,pdf,zip"; // Allowed upload file extension

// Ajax settings
var EW_LOOKUP_FILE_NAME = "ewlookup10.php"; // Lookup file name
var EW_AUTO_SUGGEST_MAX_ENTRIES = <?php echo EW_AUTO_SUGGEST_MAX_ENTRIES ?>; // Auto-Suggest max entries

// Common JavaScript messages
var EW_MAX_EMAIL_RECIPIENT = <?php echo EW_MAX_EMAIL_RECIPIENT ?>;
var EW_DISABLE_BUTTON_ON_SUBMIT = true;
var EW_IMAGE_FOLDER = "phpimages/"; // Image folder
var EW_UPLOAD_URL = "<?php echo EW_UPLOAD_URL ?>"; // Upload url
var EW_UPLOAD_THUMBNAIL_WIDTH = <?php echo EW_UPLOAD_THUMBNAIL_WIDTH ?>; // Upload thumbnail width
var EW_UPLOAD_THUMBNAIL_HEIGHT = <?php echo EW_UPLOAD_THUMBNAIL_HEIGHT ?>; // Upload thumbnail height
var EW_USE_JAVASCRIPT_MESSAGE = false;
<?php if (ew_IsMobile() AND $row_Mob['Mobile']==1) { ?>
var EW_IS_MOBILE = true;
<?php } else { ?>
var EW_IS_MOBILE = false;
<?php } ?>
</script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript" src="phpjs/jsrender.min.js"></script>
<script type="text/javascript" src="phpjs/ewp10.js"></script>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="phpjs/userfn10.js"></script>
<script type="text/javascript">
<?php echo $Language->ToJSON() ?>
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>New Page</title>
		<link rel="stylesheet" href="themes/style.css" type="text/css" media="screen">
		<!--[if IE 6]><link rel="stylesheet" href="./style.ie6.css" type="text/css" media="screen"><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" href="./style.ie7.css" type="text/css" media="screen"><![endif]-->
		<script type="text/javascript" src="themes/jqueryx.js"></script>
		<script type="text/javascript" src="themes/script.js"></script>
<meta name="generator" content="PHPMaker v10.0.1">
</head>
<body>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<?php if (ew_IsMobile() AND $row_Mob['Mobile']==1) { ?>
<div data-role="page">
	<div data-role="header">
		<a href="mobilemenu.php"><?php echo $Language->Phrase("MobileMenu") ?></a>
		<h1 id="ewPageTitle"></h1>
	<?php if (IsLoggedIn()) { ?>
		<a href="logout.php"><?php echo $Language->Phrase("Logout") ?></a>
	<?php } elseif (substr(ew_ScriptName(), 0 - strlen("login.php")) <> "login.php") { ?>
		<a href="login.php"><?php echo $Language->Phrase("Login") ?></a>
	<?php } ?>
	</div>
<?php } ?>
<?php } ?>
<?php if (@!$gbSkipHeaderFooter) { ?>
<?php if (@$gsExport == "") { ?>
<div class="ewLayout">
<?php if ($row_Mob['Mobile']==0) { ?>
	<!-- header (begin) --><!-- *** Note: Only licensed users are allowed to change the logo *** -->
<?php 	

function Ak($Akses){
if ($Akses==-1){
return 9;
}else{
return $Akses;
}
}	
?>
   <div id="art-main">
			<div class="art-sheet">
				<div class="art-sheet-tl"></div>
				<div class="art-sheet-tr"></div>
				<div class="art-sheet-bl"></div>
				<div class="art-sheet-br"></div>
				<div class="art-sheet-tc"></div>
				<div class="art-sheet-bc"></div>
				<div class="art-sheet-cl"></div>
				<div class="art-sheet-cr"></div>
				<div class="art-sheet-cc"></div>
				<div class="art-sheet-body">
					<div class="art-header">
						<div class="art-header-center">
							<div class="art-header-jpeg"></div>
						</div>
						<div class="art-header-fluid-object"></div>
						<div class="art-logo">
							<h1 id="name-text" class="art-logo-name"><a href="./index.html"></a></h1>
						</div>
					</div>
					<div class="art-nav">
						<div class="l"></div>
						<div class="r"></div>
						<ul class="art-menu">
						<?php 
						if (CurrentUserLevel()<>""){
						mysql_select_db($database_DS, $DS);
						$query_MM = "SELECT * FROM `menu` WHERE `Akses` LIKE '%".Ak(CurrentUserLevel())."%' ORDER BY `No` ASC";
						$MM = mysql_query($query_MM, $DS) or die(mysql_error());
					    $row_MM = mysql_fetch_assoc($MM);
						$totalRows_MM = mysql_num_rows($MM);
					    ?>
                		<?php  do{ ?>
						<li>
                			<a href=<?php echo $row_MM['Link'];?>><span class="l"></span><span class="r"></span><span class="t"><?php echo $row_MM['MainMenu'];?></span></a>
								<?php 
								$query_MS1 = "SELECT * FROM `menusub1` WHERE `Akses` LIKE '%".Ak(CurrentUserLevel())."%' AND `Parent`='".$row_MM['MainMenu']."' ORDER BY `No` ASC";
								$MS1 = mysql_query($query_MS1, $DS) or die(mysql_error());
								$row_MS1 = mysql_fetch_assoc($MS1);
								$totalRows_MS1 = mysql_num_rows($MS1);
								?>
								<?php  if ($totalRows_MS1>0){ ?>
								<ul> 
								<?php  do{ ?>
								<li><a href=<?php echo $row_MS1['Link'];?>><?php echo $row_MS1['Menu'];?></a>
								<?php 
									$query_MS2 = "SELECT * FROM `menusub2` WHERE `Akses` LIKE '%".Ak(CurrentUserLevel())."%' AND `Parent`='".$row_MS1['Menu']."' ORDER BY `No` ASC";
									$MS2 = mysql_query($query_MS2, $DS) or die(mysql_error());
									$row_MS2 = mysql_fetch_assoc($MS2);
									$totalRows_MS2 = mysql_num_rows($MS2);
									?>
									<?php  if ($totalRows_MS2>0){ ?>
									<ul> 
									<?php  do{ ?>
									<li><a href=<?php echo $row_MS2['Link'];?>><?php echo $row_MS2['Menu'];?></a>
									<?php } while ($row_MS2 = mysql_fetch_assoc($MS2)); ?>					
									</ul>
									<?php  } ?>					
								</li>
								<?php } while ($row_MS1 = mysql_fetch_assoc($MS1)); ?>					
								</ul>
								<?php  } ?>
						</li>
						<?php } while ($row_MM = mysql_fetch_assoc($MM)); ?>
						<?php  } ?>						
						<?php  if (Ak(CurrentUserLevel())==""){ ?>
						<?php 	
						mysql_select_db($database_DS, $DS);
						$query_MX = "SELECT * FROM `menu` WHERE `Akses` LIKE '0' ORDER BY `No` ASC";
						$MX = mysql_query($query_MX, $DS) or die(mysql_error());
					    $row_MX = mysql_fetch_assoc($MX);
						$totalRows_MX = mysql_num_rows($MX);
						?>
						<?php  do{ ?>
						<li>
                			<a href="<?php echo $row_MX['Link'];?>"><span class="l"></span><span class="r"></span><span class="t"><?php echo $row_MX['MainMenu'];?></span></a>
                		</li>
						<?php } while ($row_MX = mysql_fetch_assoc($MX)); ?>
						<?php  } ?>
                	</ul>
					</div>
					<div class="art-content-layout">
	<!-- header (end) -->
<?php } ?>
<?php if (ew_IsMobile() AND $row_Mob['Mobile']==1) { ?>
	<div data-role="content" data-enhance="false">
	<table id="ewContentTable" class="ewContentTable">
		<tr>
<?php } else { ?>
	<!-- content (begin) -->
	<table id="ewContentTable" cellspacing="0" class="ewContentTable">
		<tr><td id="ewMenuColumn" class="ewMenuColumn">
		</td>
<?php } ?>
		<td id="ewContentColumn" class="ewContentColumn">
			<!-- right column (begin) -->
				<p class="ewSiteTitle"><?php echo $Language->ProjectPhrase("BodyTitle") ?></p>
<?php } ?>
<?php } ?>

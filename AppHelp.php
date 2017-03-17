<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "persewaan_lapangan_2D_masterinfo.php" ?>
<?php include_once "_2padmininfo.php" ?>
<?php include_once "persewaan_lapangan_2D_detailgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "header.php" ?>

<? if (CurrentUserLevel()==-1){ ?>

<?php require_once('Connections/Konek.php'); ?>
<?php include "function.php" ?>
<?=FBR(2);?>
<link rel="stylesheet" href="system.css" type="text/css" media="screen" />

<div align="center">Support teknis silahkan hubungi kami di: <a href="www.sig-it.web.id" target="_blank">www.sig-it.web.id</a> </div>

<? } ?>
<?php include "footer.php" ?>

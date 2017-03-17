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

<form enctype="multipart/form-data" action="AppRestore.php" method="POST">
	<p align="center"><em>Aplikasi ini digunakan untuk <strong><a href="backup/recovery_data.php">restore</a></strong> semua data yang ada didalam database &quot;<strong><?=$database_Konek;?></strong>&quot;.</em></p>
	<table align="center">
	<tr><td>File Backup Database (*.sql) <input type="file" name="datafile" size="30" id="gambar" /></td></tr>
	<tr><td><input type="submit" onclick="return confirm('Apakah Anda yakin akan restore database?')" name="restore" value="Restore Database" /></td>
	</tr>
	</table>
</form>


<?php
if(isset($_POST['restore'])){
	$koneksi=mysql_connect($hostname_Konek,$username_Konek,$password_Konek);
	mysql_select_db($database_Konek,$koneksi);
	
	$nama_file=$_FILES['datafile']['name'];
	$ukuran=$_FILES['datafile']['size'];
	
	//periksa jika data yang dimasukan belum lengkap
	if ($nama_file=="")
	{
		echo "Fatal Error";
	}else{
		//definisikan variabel file dan alamat file
		$uploaddir='./restore/';
		$alamatfile=$uploaddir.$nama_file;

		//periksa jika proses upload berjalan sukses
		if (move_uploaded_file($_FILES['datafile']['tmp_name'],$alamatfile))
		{
			
			$filename = './restore/'.$nama_file.'';
			
			// Temporary variable, used to store current query
			$templine = '';
			// Read in entire file
			$lines = file($filename);
			// Loop through each line
			foreach ($lines as $line)
			{
				// Skip it if it's a comment
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;
			 
				// Add this line to the current segment
				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';')
				{
					// Perform the query
					mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
					// Reset temp variable to empty
					$templine = '';
				}
			}
			echo "<center>Berhasil Restore Database, silahkan di cek.</center>";
		
		}else{
			//jika gagal
			echo "Proses upload gagal, kode error = " . $_FILES['location']['error'];
		}	
	}

}else{
	unset($_POST['restore']);
}
?>
<? } ?>
<?php include "footer.php" ?>

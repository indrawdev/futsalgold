<?
function FC($Cetak){
if ($Cetak==""){
return "-";
}else{
return $Cetak;
}
}

function FKond($Kond1,$Kond2){
if ($Kond1==$Kond2){
return $Kond2;
}else{
return "-";
}
}

// Secure Page
function FSP($Lock,$Admin){
$x = explode(":",$Lock);
foreach ($x as $y){
	if ($Admin==$y){
	$z="ok";
	}	
}
if ($z<>"ok"){	
	$_SESSION['MM_Username'] = NULL;
	unset($_SESSION['MM_Username']);	
	FGO("index.php");
}
$z="";
}

function FDel($Del){
return "<input name=Del[] type=checkbox id=Del[] value=$Del />";
}

function FTB($tombol){
if ($tombol=="Hapus" OR $tombol=="Hapus Barang"){
return "<input type=\"submit\" name='".trim(str_replace(" ","",$tombol))."' id='".trim(str_replace(" ","",$tombol))."' value='".$tombol."' class=tombol onclick=\"return confirm('Hapus Data ? Klik Cancel untuk membatalkan!')\" />";
}else if($tombol=="Tambahkan"){
return "<input type=\"submit\" name='".trim(str_replace(" ","",$tombol))."' id='".trim(str_replace(" ","",$tombol))."' value='".$tombol."' class=tombol onclick=\"return confirm('Tambah Data ?  Klik Cancel untuk membatalkan!')\" />";
}else{
return "<input type=submit name='".trim(str_replace(" ","",$tombol))."' id='".trim(str_replace(" ","",$tombol))."' value='".$tombol."' class=tombol />";
}
}


function FKey($Serial){
$Serial = md5($Serial."qazwsx123");
return $Serial;
}

function FHapus($Tabel,$ID, $hostname_POS, $database_POS, $username_POS, $password_POS){

	$POS = mysql_pconnect($hostname_POS, $username_POS, $password_POS) or trigger_error(mysql_error(),E_USER_ERROR); 	
	
	for ($d=0;$d<=count($ID);$d++){
	
  	$query_Hapus = "DELETE FROM `$Tabel` WHERE ID='".$ID[$d]."'";
	mysql_select_db($database_POS, $POS);             
  	mysql_query($query_Hapus, $POS) or die(mysql_error());
	}

}

function FHead($Head){
 echo "<a href='?sort=".str_replace(" ","",$Head)."'>$Head</a>";
}

function FUrut($Sort,$Default){
	if ($Sort==""){
	return $Default;	
	}else{
	$Sort = trim(str_replace("%20"," ",$Sort));	
	return $Sort;	
	}	
}

function FGo($Url){
echo "<meta http-equiv=refresh content=0;URL=$Url />";
exit;
}

function FBR($J){
for ($i=1;$i<=$J;$i++){
echo "<br>";
}

}

function FGanti($Ganti,$Sisip,$Content){
return trim(str_replace($Ganti,$Sisip,$Content));
}

function FSubTotal($Harga,$Jumlah,$Diskon){ 
	$SubTotal = $Harga * $Jumlah * ( 1 - ($Diskon/100));
	return $SubTotal;
}

function FL($file){
if($_SERVER["PHP_SELF"]=="/$file.php"){ 
echo "Cannot Direct Access";
exit; 
}
}

function FX($val){    
// Karakter yang sering digunakan untuk sqlInjection    
// $char = array ('-','/','\\',',','.','#',':',';','\'','"',"'",'[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
$char = array ('/','\\',',','#',':',';','\'','"',"'",'[',']','{','}',')','(','|','`','~','!','%','$','^','&','*','=','?','+','@','.');    
  
// Hilangkan karakter yang telah disebutkan di array $char  
$cleanval = str_replace($char, '', trim($val));     
    
return $cleanval;    
} 

function FE($val){    
// Karakter yang sering digunakan untuk sqlInjection    
$char = array ('/','\\',',','#',':',';','\'','"',"'",'[',']','{','}',')','(','|','`','~','!','%','$','^','&','*','=','?','+');    
  
// Hilangkan karakter yang telah disebutkan di array $char  
$cleanval = str_replace($char, '', trim($val));     
    
return $cleanval;    
} 

function FMail($To, $FromName, $FromEmail, $Subject, $Message){
$Subject = "$Subject";
$Headers = "Content-Type: text/html; charset=iso-8859-1\n";
$Headers .= "From: ".$FromName." <".$FromEmail.">\n";
$Message  = "$Message";
mail($To, $Subject, $Message, $Headers);
}

function FGetDomain($url){
$nowww = ereg_replace('www\.','',$url);
$domain = parse_url($nowww);
if(!empty($domain["host"]))
{
return $domain["host"];
} else
{
return $domain["path"];
} 
}

function FCurPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


//
function FMoney($Money){
	$Money = number_format($Money).".00";
    return $Money;
}

//
function FStruk($Money){
	$Money = number_format($Money);
    return $Money;
}

// IP
function FNoIP(){
	$FNoIP = $_SERVER["REMOTE_ADDR"];
	return $FNoIP;
}

// Browser
function FBrowser(){
	$FBrowser = getenv("HTTP_USER_AGENT");
	return $FBrowser;
}

// UrlRef 
function FUrlRef(){
	$FUrlRef = $_SERVER["HTTP_REFERER"];
	return $FUrlRef;
} 

// Date
function FDate($D){
	$FDate = date ("d-m-Y", strtotime($D));
	return $FDate; 
}

function FTgl($D){
	$E = explode("-",$D);
	$F = $E[2]."/".$E[1]."/".$E[0];
	return $F;  
}

function FETgl($D){
	$E = explode("/",$D);
	$F = $E[2]."-".$E[1]."-".$E[0];
	return $F; 
}

// Time
function FTime($T){
	$T = date ("H:i:s", strtotime($T));
	return $T; 
}

// Tanggal dan Waktu
function FDateTime($DT){
	$FDateTime = date ("d-m-Y H:i:s", strtotime($DT));
	return $FDateTime; 
}


// Cookies
function FKukis($Nama, $Nilai, $Durasi){		
	if ($_COOKIE["$Nama"]==""){				
			setcookie("$Nama", "$Nilai", time()+(3600*24*$Durasi));		
    }
}

// Session
function FSesi($Nama, $Nilai){		
	$_SESSION["$Nama"]="$Nilai";
	return $_SESSION['$Nama']; 
}

// Yahoo Messenger
function FYM($idym,$t){
$ym = "<a href='ymsgr:sendIM?$idym'><img src='http://opi.yahoo.com/online?u=$idym&m=g&t=$t' alt='yahoo messenger' border='0' /></a>";
return $ym;
}

// Meta Tag
function FMetaTag($author,$robots,$keywords,$desc){
$FMetaTag = "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<meta name='author' content='$author'>
<meta name='robots' content='$robots'>
<meta name='keywords' content='$keywords'>
<meta name='description' content='$desc'>
<link rel='icon' href='favicon.ico' type='image/x-icon'>
<meta http-equiv=Page-Enter content=RevealTrans(Duration=2,Transition=22)>";
return $FMetaTag;
}

// Intro News
function FIntro($content,$limit){
$FIntro = substr($content,0,$limit);
return $FIntro;
}

// Show Image
function FShowImg($src,$width,$height){
$FShowImg = "<img name='' src='$src' width='$width' height='$height' alt='' />";
return $FShowImg;
}

// Redirect
function FRD($tombol,$go){ 
if ($_POST[$tombol]){
FGO($go);
}
return TRUE;
}
?>
<? ini_alter('date.timezone','Asia/Calcutta'); ?>
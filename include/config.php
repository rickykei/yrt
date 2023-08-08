<?php
 
require_once('DB.php'); 
$dsn = 'mysql://wood2014:98014380@localhost/wood2018';
$db = DB::connect($dsn);
$connection = DB::connect($dsn);
if (DB::isError($connection))
 die($connection->getMessage());
$result = $connection->query("SET NAMES 'UTF8'");
   
 if ($_SESSION['username']==''){
 
	 $uname=$_REQUEST['username'];
	 $pass=$_REQUEST['password'];
	 $browseryrt = $_SERVER['HTTP_USER_AGENT'];
	list($LTD,$AREA,$PC) =  split("_",$browseryrt);
	$LTD=strtoupper($LTD);
	$AREA=strtoupper($AREA);
	$PC=strtoupper($PC);
 }else{
	 
	$UNAME=$_SESSION['username'];
	$UROLE=$_SESSION['userrole'];
	$USER=$_SESSION['name'];
	$AREA=$_SESSION['area'];
	$PC=$_SESSION['pc'];
	$LTD=$_SESSION['ltd'];
	$browseryrt = "YRT_".$AREA."_".$PC;
 }
 
$shop_array = array ( "A","Y");
$shopAddress[0]="九龍旺角鴉蘭街5B號中華漆廠大廈地下D舖";
$shopAddress[1]="九龍大角咀通州街2-16號長豐大廈A-M舖地下";
$shopDetail[0]="TEL : 2393-9335, 2787-7678 FAX : 2393-8707";
$shopDetail[1]="TEL : 2412-2335, 2412-2241 FAX : 2413-3373";
$creditcardrate_default=2;
 
?>

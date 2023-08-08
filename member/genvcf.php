<?php
//error_reporting(E_ALL);
//  error_reporting(0);

$debug=0;
 
if(isset($_GET['debug']))$debug = $_GET['debug']; 

  
 
if(!$debug){
header('Content-Type: text/x-vcard');  
header('Content-Disposition: attachment; filename=yrt.vcf');  
header('Connection: close');  
}
  
 
	   include_once("../include/config.php");
   $db = DB::connect($dsn);
    if (DB::isError($connection))
      die($connection->getMessage());
   
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");

  
	$checking=0;
   
	  		$sql=" SELECT member_id,member_name FROM member a where a.vcf='Y'  ";
	  	    $sqlCount= " select count(*) as total FROM member where vcf='Y' ";
	 if ($sqlCount!=""){
	 $result = $db->query($sqlCount);
	   while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$countTotal=$row["total"];
		 }
	}
	
	if ($countTotal>0){
		$result2 = $db->query($sql);
		include_once("include_doc2vcf.php");
		echo $vCard;
	}
	
?>



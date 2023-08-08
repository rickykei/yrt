<?php
$vCard="";
 while ( $row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC) ){
			//$company_name_eng=$document->company_detail[0]['company_name_eng'];	
			//$company_name_chi=$document->company_detail[0]['company_name_chi'];
			//citic
			$mobile_tel=$row2['member_id'];
			$name_eng=$mobile_tel.$row2['member_name'];
	 //prepare vcf Variable
			$vCard  .= "BEGIN:VCARD\r\n";
			$vCard .= "VERSION:3.0\r\n";
			$vCard .= "PRODID:-//Apple Inc.//iPhone OS 16.4.1//EN\r\n";
			 
			  
			if($name_eng!="") $vCard .= "N;CHARSET=utf-8:" . $name_eng ." ". $name_chi ." ". $pro_title."\r\n";
			if($mobile_tel)$vCard .= "TEL;TYPE=CELL:" . $mobile_tel . "\r\n"; 
			$cnt=0;
		 	$vCard.="END:VCARD\r\n";
			 
 }


function chk_null($aa){
	
	if ($aa=="undefined" || $aa=="null" || $aa==null)
		$aa="";
	
	return $aa;
}	
 function get_content($URL){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $URL);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
}
function file_get_contents_curl($url) {
    $ch = curl_init();
  
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
  
    $data = curl_exec($ch);
    curl_close($ch);
  
    return $data;
}
?>

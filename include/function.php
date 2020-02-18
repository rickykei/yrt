<?php
 
function n_f($no){
 return number_format($no,2,'.','');
}
function sub_remark($remark){
	if(strlen($remark)>20)
	echo substr($remark,0,20)."...";
	else
	echo $remark;
	
}
function fin_year($db){
	
	$sql="select year from fin_year where sts='A' ";
	if ($rows=$db->fetch_all_array($sql)){
		
	}
	return $rows[0]['year'];
	
}
function fin_year_admin($db){
	
	$sql="select year from admin_year ";
	if ($rows=$db->fetch_all_array($sql)){
		
	}
	return $rows[0]['year'];
	
}

function checkLoginDateTime(){
	
 global $UNAME;
 global $UROLE;
 global $PC;
 global $AREA;
	//check login time 20180501
	//if normal user 7.45 > < 18.15
   	$ThatTime ="07:45:00";
   	$EndTime = "18:15:00";
	
	if (time() >= strtotime($ThatTime)&&time() <= strtotime($EndTime)){
					
			
	}else{
		if ($PC!='99'){
			$UROLE="";		
			$UNAME="";
		}
	}
	
	if ($UROLE==''){
		$_SESSION='';
		return false;
	}else{
		return true;
	}
	
		
}
?>
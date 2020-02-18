<?php
   include_once("./include/config.php");
  
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");
   
   $status=$_POST['action'];
   $invoice_no_array=$_POST['myCheckboxes'];
   $invoice_no_str=implode(',',$invoice_no_array);
   //print_r($status);
  //print_r($invoice_no_str);
  
  if ($status!="cancel"){
	$sql="update invoice set settle='$status' ";
  
	 if ($status=='A')
		 $sql=$sql." , settledate=now() ";	
	 
	 $sql=$sql." where invoice_no in ($invoice_no_str) ";
    //  echo $sql;
	//cal total count first;
  }else{
	$sql="update invoice set void='I' ,last_update_date=now(),last_update_by='$BROWSERYRT'";
  
	 if ($status=='A')
		 $sql=$sql."  ";	
	 
	 $sql=$sql." where invoice_no in ($invoice_no_str) ";
      
  }
  
  
	 $result = $db->query($sql);
	 
	 
 ?><font color="RED" >成功更改了</font>
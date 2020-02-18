<?php
   include_once("./include/config.php");
  
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");
   
   $status=$_POST['action'];
   $invoice_no_array=$_POST['myCheckboxes'];
   $invoice_no_str=implode(',',$invoice_no_array);
   //print_r($status);
  //print_r($invoice_no_str);
  
  if ($status=="resume"){
 
	$sql="update invoice set void='A' ,last_update_date=now(),last_update_by='$BROWSERYRT'  ";
    $sql=$sql." where invoice_no in ($invoice_no_str)  and void='I' ";
      
  }
   $result = $db->query($sql);
	 
	 
 ?><font color="RED" >成功更改了</font>
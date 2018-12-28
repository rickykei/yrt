<?php
require_once("./include/config.php");
	$connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
   $result = $connection->query("SET NAMES 'UTF8'");
   $shop_array = array ( "Y","B","H","F","A");

   function security_check($AREA,$PC){
	if (($AREA=="Y" && $PC=="1") || ($AREA=="Y" && $PC=="4") || ($AREA=="Y" && $PC=="99")){
		
			return TRUE;}
	else{
		
			return FALSE;
		}
}   


 
if (security_check($AREA,$PC)){ 

 

 $invoice_date=$year.'-'.$month;
 


?>
<table width="" align="center" >
<tr><td><?php  
 include("./pdf2/pdf_misc_monthly.php");
 ?><a href="<?php echo "/statistic/misc_monthly_pdf/".$invoice_date.'_'.$shop.'.pdf'?>"><?php echo $shop;?>鋪PDF</a></td></tr>
</table>  <? } ?>
 
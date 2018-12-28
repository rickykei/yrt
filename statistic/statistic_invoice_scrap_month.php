<?
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

$date_end=$year.'-'.$month.'-'.$day.' 23:59';
$date_start=$year.'-'.$month.'-01 00:01';
echo $date_start.'-to-';
echo $date_end;
//$subtotal="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year  ";
$subtotal="select sum(total_price) as total from invoice_scrap where invoice_scrap.invoice_date>='$date_start' && invoice_scrap.invoice_date<='$date_end' ";

 
	$rows = $connection->query($subtotal);
   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
   $m_day_counter=$row['total'];
   
	
	for ($i=0;$i<count($shop_array);$i++){
	 
		$shop_subtotal[$i]="select sum(total_price) as total from invoice_scrap where invoice_scrap.invoice_date>='$date_start' && invoice_scrap.invoice_date<='$date_end' and branchID='$shop_array[$i]'";
		$settle_shop_subtotal[$i]="select sum(total_price) as total from invoice_scrap where invoice_scrap.settledate>='$date_start' && invoice_scrap.settledate<='$date_end'  and branchID='$shop_array[$i]' ";
		
		 
		if ($AREA==$shop_array[$i] || security_check($AREA,$PC) ){
			 
		   $rows = $connection->query($shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $m_shop_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($settle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $m_settle_shop_subtotal_counter[$i]=$row['total'];
		   
		  
		
   }
		
	}



	?>
 
 
<table width="" align="center" >
  <tr>
    <td >
<div class="demo">
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all">
<table  align="center" >
  <tr>
    <td colspan="<?=count($shop_array)?>"><ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
      <div align="center">月結</div></ul></td>
  </tr>
  <tr>
  <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td width="360"><u><?=$shop_array[$i]?>舖 </u>       </td>
		<?}
    
  ?>
  </tr>
  <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td>總數 <?=number_format($m_shop_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  <tr>
   <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td>入賬<?=number_format($m_settle_shop_subtotal_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
   
  
  
     
   
    <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){
		$fixAmt=$m_settle_shop_subtotal_counter[$i]-$m_return_shop_total_counter[$i];
		$t_fixAmt=$t_fixAmt+$fixAmt;
		?>
		<td>實數 <?=number_format($fixAmt,2,'.',',')?></td>
		<?}?>
  </tr>

    
 
  <tr>
  
    <td colspan="<?=count($shop_array)?>">
    <table width="100%"> <tr><td><div align="center">全月總數
        <?=number_format($m_day_counter,2,'.',',')?>
    </div></td>
     <td colspan="<?=count($shop_array)?>"><div align="center">全月實數
        <?=number_format($t_fixAmt,2,'.',',')?>
    </div></td>
    </tr></table></td>
  </tr>

  </table>
</div></div></td></tr></table>  <? } ?>
<p>
 

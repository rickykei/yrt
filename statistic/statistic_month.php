<?PHP
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
$subtotal="select sum(total_price) as total from invoice where invoice.invoice_date>='$date_start' && invoice.invoice_date<='$date_end'  and void='A' ";

 
	$rows = $connection->query($subtotal);
   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
   $m_day_counter=$row['total'];
   
	
	for ($i=0;$i<count($shop_array);$i++){
		/*20160822
		$shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year and branchID='$shop_array[$i]'";
		$settle_shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.settledate)=$month && year(invoice.settledate)=$year  and branchID='$shop_array[$i]' and settle='A'";
		$unsettle_shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year  and branchID='$shop_array[$i]' and settle='S'";
		$unsettle_shop_deposit[$i]="select sum(deposit) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year  and branchID='$shop_array[$i]' and settle='S'";
		$shop_return_total[$i]="select sum(total_price) as total from returngood where month(returngood.return_date)=$month && year(returngood.return_date)=$year and branchID='$shop_array[$i]'";
		$delivery_total[$i]="select sum(fee) as total from delivery_fee where month(delivery_date)=$month && year(delivery_date)=$year and shop='$shop_array[$i]'";
		*/
		
		$shop_subtotal[$i]="select sum(total_price) as total from invoice where invoice.invoice_date>='$date_start' && invoice.invoice_date<='$date_end' and branchID='$shop_array[$i]'  and void='A' ";
		$settle_shop_subtotal[$i]="select sum(total_price) as total from invoice where invoice.settledate>='$date_start' && invoice.settledate<='$date_end'  and branchID='$shop_array[$i]' and settle='A'  and void='A' ";
		$unsettle_shop_subtotal[$i]="select sum(total_price) as total from invoice where invoice.invoice_date>='$date_start' && invoice.invoice_date<='$date_end'  and branchID='$shop_array[$i]' and settle='S'  and void='A' ";
		$unsettle_shop_deposit[$i]="select sum(deposit) as total from invoice where invoice.invoice_date>='$date_start' && invoice.invoice_date<='$date_end'  and branchID='$shop_array[$i]' and settle='S'  and void='A' ";
		$shop_return_total[$i]="select sum(total_price) as total from returngood where returngood.return_date>='$date_start' && returngood.return_date<='$date_end' and branchID='$shop_array[$i]'";
		$delivery_total[$i]="select sum(fee) as total from delivery_fee where delivery_date>='$date_start' && delivery_date<='$date_end' and shop='$shop_array[$i]'";
		$member_total_deposit[$i]="select sum(deposit_amt) as total from member_deposit where deposit_date <='$date_end' and  	branchID='$shop_array[$i]' ";
		$member_total_spend_on_deposit[$i]="select sum(total_price) as total from invoice where invoice.settledate <= '$date_end' and branchID='$shop_array[$i]' and settle='A' and deposit_method='D'  and void='A' ";
		 
		if ($AREA==$shop_array[$i] || security_check($AREA,$PC) ){
			 
		   $rows = $connection->query($shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $m_shop_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($settle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $m_settle_shop_subtotal_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($unsettle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $m_unsettle_shop_subtotal_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($unsettle_shop_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $m_unsettle_shop_deposit_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($shop_return_total[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $m_return_shop_total_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($delivery_total[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $delivery_total_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_deposit_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_spend_on_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_deposit_counter[$i]=$row['total'];
   }
		
	}



	?>
<body >

 
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
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td>掛單 <?=number_format($m_unsettle_shop_subtotal_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  <tr>
     <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td>掛單訂金 <?=number_format($m_unsettle_shop_deposit_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td>退貨 <?=number_format($m_return_shop_total_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  
    <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">會員存款 <?=number_format($member_total_deposit_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
   <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">會員存款扣數 <?=number_format($member_total_spend_on_deposit_counter[$i],2,'.',',')?></td>
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
    <?
  	for ($i=0;$i<count($shop_array);$i++){
 
		?>
		<td>街車數 <?=number_format($delivery_total_counter[$i],2,'.',',')?></td>
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
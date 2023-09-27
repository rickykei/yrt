<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>花紅百分比計算表</title>
<?php
 
 require_once("../include/config.php");
 
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
   $result = $connection->query("SET NAMES 'UTF8'");
if ($shop=="") 
 $shop_array = array("Y","A");
else
 $shop_array = $shop;

   
   //security_check
  function security_check($AREA,$PC){
	if (($AREA=="Y" && $PC=="1") || ($AREA=="Y" && $PC=="4") || ($AREA=="Y" && $PC=="99")){
		
			return TRUE;
			}else{
		
			return TRUE;
		}
	}   
	//end security_check
	
if (security_check($AREA,$PC)){ 

$date_end=$to_date.' 23:59';
$date_start=$from_date.' 00:01';

 
$subtotal="select sum(total_price) as total from invoice where invoice.invoice_date>='$date_start' && invoice.invoice_date<='$date_end'  and void='A' ";

	$rows = $connection->query($subtotal);
   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
   $m_day_counter=$row['total'];
   
	
	for ($i=0;$i<count($shop_array);$i++){
	 
		
		if ($AREA==$shop_array[$i] || security_check($AREA,$PC) ){
		$settle_shop_subtotal[$i]="select sum(total_price) as total from invoice where invoice.settledate>='$date_start' && invoice.settledate<='$date_end'  and branchID='$shop_array[$i]' and settle='A'  and void='A' ";
	 
		$shop_return_total[$i]="select sum(total_price) as total from returngood where returngood.return_date>='$date_start' && returngood.return_date<='$date_end' and branchID='$shop_array[$i]'";
		
		 
		 
		   $rows = $connection->query($settle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $m_settle_shop_subtotal_counter[$i]=$row['total'];
		    
		   $rows = $connection->query($shop_return_total[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $m_return_shop_total_counter[$i]=$row['total'];
	 	    
			//scrap
		 
		  
		$scrap_settle_shop_subtotal[$i]="select sum(total_price) as total from invoice_scrap where invoice_scrap.settledate>='$date_start' && invoice_scrap.settledate<='$date_end'  and branchID='$shop_array[$i]' ";
		
		  
		   
		   $rows = $connection->query($scrap_settle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $scrap_m_settle_shop_subtotal_counter[$i]=$row['total'];
		   
		   
		   //door
		   
		   
		$door_settle_shop_subtotal[$i]="select sum(total_price) as total from invoice_door where invoice_door.settledate>='$date_start' && invoice_door.settledate<='$date_end'  and branchID='$shop_array[$i]' ";
		 
		   $rows = $connection->query($door_settle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $door_m_settle_shop_subtotal_counter[$i]=$row['total'];
 
		}
		 
		
   }
		  
		
    
}


	
?>
<link href="../include/invoice.css" rel="stylesheet" type="text/css" />
</head>
<body  >
<table width="900"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CC99">
 <tr>
    <td width="4" height="360">&nbsp;</td>
    <td  align="center" valign="top">
	<table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td class="style6" ><table width="100%"  border="1" cellpadding="2" cellspacing="0">
          <tr>
            <td width="14%" height="21" bgcolor="#006633"  class="style6"><a href="index.php" class="style6">花紅百分比計算表</a></td>
            <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
            <td width= >由 <?php echo $from_date;?> 至 <?php echo $to_date;?></td>
            <td width= >百份比<?php echo $percentage;?>%</td>
          </tr>
          <tr><td colspan="4" height="21" align="center">出貨單</td></tr>
           <tr>
			<?
			 
				for ($i=0;$i<count($shop_array);$i++){
				$fixAmt=$m_settle_shop_subtotal_counter[$i]-$m_return_shop_total_counter[$i];
				$t_fixAmt[$i]=$t_fixAmt[$i]+$fixAmt;
				 
				 
				?>
				<td>shop <?=$shop_array[$i]?></td><td >實數:<?=number_format($fixAmt,2,'.',',')?> 花紅:<?=number_format($fixAmt*$percentage/100,2,'.',',')?></td>
				<?}?>
			</tr><tr><td colspan="4" height="21"  align="center"></td></tr>
	   <tr><td colspan="4" height="21"  align="center">碎料</td></tr>
           <tr>
		    <?
			
			for ($i=0;$i<count($shop_array);$i++){
		$fixAmt=$scrap_m_settle_shop_subtotal_counter[$i]-$scrap_m_return_shop_total_counter[$i];
		$t_fixAmt[$i]=$t_fixAmt[$i]+$fixAmt;
		 
		 
		?>
		<td>shop <?=$shop_array[$i]?></td><td >實數:<?=number_format($fixAmt,2,'.',',')?>花紅:<?=number_format($fixAmt*$percentage/100,2,'.',',')?></td>
		<?}?>
			</tr>
			  <tr><td colspan="4" height="21"  align="center">門</td></tr>
           <tr>
		    <?	
  	for ($i=0;$i<count($shop_array);$i++){
		$fixAmt=$door_m_settle_shop_subtotal_counter[$i];
		$t_fixAmt[$i]=$t_fixAmt[$i]+$fixAmt;
		 
		 
		?>
		<td>shop <?=$shop_array[$i]?></td><td >實數:<?=number_format($fixAmt,2,'.',',')?>花紅:<?=number_format($fixAmt*$percentage/100,2,'.',',')?></td>
		<?}?>
			</tr>
			 <tr><td colspan="4" height="21"  align="center">TOTAL</td></tr>
			<tr>
			<? for ($i=0;$i<count($shop_array);$i++){ ?>
			<td> shop <?=$shop_array[$i]?></td><td >實數:<?=number_format($t_fixAmt[$i],2,'.',',')?>花紅:<?=number_format($t_fixAmt[$i]*$percentage/100,2,'.',',')?></td>
			<? } ?>
			 </tr>
			
  </table></td>
     </tr>
	 
    </table>    
     </td>
  </tr>


</table>
</body>
</html>

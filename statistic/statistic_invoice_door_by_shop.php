<?
require_once("./include/config.php");
?>
<script type="text/javascript">
	$(function() {
		$("#accordion3<? echo $_GET['branchID']; ?>").accordion({ 
								  icons: { 'header': 'ui-icon-plus', 'headerSelected': 'ui-icon-minus' },
								  header: "h3" ,
								   
									collapsible:false,
  							activate:true,
  						alwaysOpen:true,
  							autoHeight:false
								  });
	


});

</script>
 
<?

  

$connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
   $result = $connection->query("SET NAMES 'UTF8'");
   
function security_check($AREA,$PC){
	if (($AREA=="Y" && $PC=="1") || ($AREA=="Y" && $PC=="4")  || ($AREA=="Y" && $PC=="99")){
			return TRUE;}
	else{
			return FALSE;
		}
}   
  


if ($day==0 && $year != "")
{
	$subtotal="select sum(total_price) as total from invoice_door where month(invoice_door.invoice_date)=$month && year(invoice_door.invoice_date)=$year && branchID='$branchID' order by invoice_no desc";
	   $rows = $connection->query($subtotal);
   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
   $day_counter=$row['total'];
   
	
	for ($i=0;$i<count($shop_array);$i++){
		$shop_subtotal[$i]="select sum(total_price) as total from invoice_door where month(invoice_door.invoice_date)=$month && year(invoice_door.invoice_date)=$year and branchID='$shop_array[$i]'";
		$settle_shop_subtotal[$i]="select sum(total_price) as total from invoice_door where month(invoice_door.invoice_date)=$month && year(invoice_door.invoice_date)=$year and branchID='$shop_array[$i]' ";
		
		
		
		
		if ($AREA==$shop_array[$i] || security_check($AREA,$PC) ){
			 
			 $rows = $connection->query($shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $shop_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($settle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $settle_shop_subtotal_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($unsettle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $unsettle_shop_subtotal_counter[$i]=$row['total'];

   }
		
	}
	
	

}
else if ($day!="" && $year != "")
{
	
	/* $sql="select 
	inv.invoice_no,
	inv.invoice_date , inv.invoice_date ,inv.delivery_date ,	inv.sales_name   ,
	inv.customer_name  ,	inv.customer_tel  ,	inv.customer_detail , 	inv.member_id  , 	 
	inv.delivery  , 		inv.man_power_price   ,	inv.discount_percent   ,		inv.discount_deduct   ,
	inv.special_man_power_percent   ,	inv.total_price   	,	inv.deposit   	,	inv.settle   	,
	inv.credit_card_rate,mem.member_name
	from member mem RIGHT JOIN invoice inv ON mem.member_id = inv.member_id where  ((month(inv.invoice_date)=$month && year(inv.invoice_date)=$year && DAYOFMONTH(inv.invoice_date)=$day) or (month(inv.settledate)=$month && year(inv.settledate)=$year && DAYOFMONTH(inv.settledate)=$day)) && branchID='$branchID' order by inv.invoice_no desc "; */
	
	$sql="select 
	inv.invoice_no,
	inv.invoice_date , inv.invoice_date ,inv.delivery_date ,	inv.sales_name   ,
	inv.customer_name  ,	inv.customer_tel  ,	inv.customer_detail , 	inv.member_id  , 	 
	inv.delivery  , 		inv.man_power_price   ,	inv.discount_percent   ,		inv.discount_deduct   ,
	inv.special_man_power_percent   ,	inv.total_price   	,	inv.deposit   	,	inv.settle   	,
	inv.credit_card_rate,mem.member_name
	from member mem RIGHT JOIN invoice_door inv ON mem.member_id = inv.member_id where  ((month(inv.settledate)=$month && year(inv.settledate)=$year && DAYOFMONTH(inv.settledate)=$day)) && branchID='$branchID' order by inv.invoice_no desc "; 
	
 
	//echo $sql."<P>";
	$rows = $connection->query($sql);
	$i=0;
	while ( $row = $rows->fetchRow(DB_FETCHMODE_ASSOC)){
		$invoice_no_array[$i] = $row['invoice_no'];
		//	echo $invoice_no_array[$i];
		$invoice_date[$invoice_no_array[$i]]=$row['invoice_date'];
		$delivery_date[$invoice_no_array[$i]]=$row['delivery_date'];
		$entry_date[$invoice_no_array[$i]]=$row['entry_date'];
		$sales_name[$invoice_no_array[$i]]=$row['sales_name'];
		
		if ($row['customer_name']=="")
		$customer_name[$invoice_no_array[$i]]=$row['member_name'];
		else
		$customer_name[$invoice_no_array[$i]]=$row['customer_name'];
		
		$customer_tel[$invoice_no_array[$i]]=$row['customer_tel'];
		$customer_detail[$invoice_no_array[$i]]=$row['customer_detail'];
		$member_id[$invoice_no_array[$i]]=$row['member_id'];
		$branchID[$invoice_no_array[$i]]=$row['branchID'];
		$delivery[$invoice_no_array[$i]]=$row['delivery'];
		$man_power_price[$invoice_no_array[$i]]=$row['man_power_price'];
		$discount_percent[$invoice_no_array[$i]]=$row['discount_percent'];
		$discount_deduct[$invoice_no_array[$i]]=$row['discount_deduct'];
		$special_man_power_percent[$invoice_no_array[$i]]=$row['special_man_power_percent'];
		$total_price[$invoice_no_array[$i]]=$row['total_price'];
		$deposit[$invoice_no_array[$i]]=$row['deposit'];
		if( $row["settle"]=="S") {
			$settle[$invoice_no_array[$i]]= "掛單";
		} else {
			$settle[$invoice_no_array[$i]] = "入賬";
		}
		//$settle[$invoice_no_array[$i]]=$row['settle'];
		$credit_card_rate[$invoice_no_array[$i]]=$row['credit_card_rate'];

		$i++;
	}
	
	for ($i=0;$i<count($invoice_no_array);$i++){
		
	$sql="select 
	ginv.sheet_cd ,ginv.strip_cd,   ginv.qty ,ginv.unit_price , ginv.subtotal 
	from goods_invoice_door ginv  where  ginv.invoice_no = '$invoice_no_array[$i]'";

    //echo "<P>".$sql."<P>";

	$rows = $connection->query($sql);
	
	$a=0;
	

	while ( $row = $rows->fetchRow(DB_FETCHMODE_ASSOC))
	{
		
		$goods_partno[$invoice_no_array[$i]][$a]=$row['sheet_cd'];
		 
		$qty[$invoice_no_array[$i]][$a]=$row['qty'];
	 
		$marketprice[$invoice_no_array[$i]][$a]=$row['unit_price'];
		$subtotal[$invoice_no_array[$i]][$a]=$row['subtotal'];
  
 
		$a++;
	}
	 
	}
}
?>
			<div id="accordion3<? echo $_GET['branchID']; ?>" class="menu noaccordion">
<?            for ($i=0;$i<count($invoice_no_array);$i++){ ?>
				<h3 <? if ($settle[$invoice_no_array[$i]]=="掛單"){ ?>class="ui-state-defaultred .ui-state-activered ui-state-hoverred ui-widget-contentred     ui-accordion-headerred ui-accordionred"<?} ?> ><a href="#">單期:<?=substr($invoice_date[$invoice_no_array[$i]],0,15)?> | 單號:<?=$invoice_no_array[$i]?> |  客名:<?=$customer_name[$invoice_no_array[$i]]?> |
                 客號: <?=$member_id[$invoice_no_array[$i]]?> | 扶費:<?=$man_power_price[$invoice_no_array[$i]]?> | 特扶費:<?=$special_man_power_percent[$invoice_no_array[$i]]?> |折: <?=$discount_percent[$invoice_no_array[$i]]?> | 
                 減:<?=$discount_deduct[$invoice_no_array[$i]]?> | <?=$sales_name[$invoice_no_array[$i]]?> | &nbsp; <b>[總數: <?=$total_price[$invoice_no_array[$i]]?>]</b></a></h3>
                 
				<div <? if ($settle[$invoice_no_array[$i]]=="掛單"){ ?>class="ui-state-defaultred "<?} ?>>
                <table width="100%">
                <thead><tr>
                    <th width="10%" align="left">貨品編號</th>
                   
                    <th>數量</th>
                    <th>市價</th>
                 
                  
					<th>總計</th>  
				</tr>    
                <? for ($j=0;$j<count($goods_partno[$invoice_no_array[$i]]);$j++){ ?>
                <tr>
                    <td bordercolor="#FFFFFF" width="120" align="left" bgcolor="#bbbbbb"><?=$goods_partno[$invoice_no_array[$i]][$j]?></td>
        
                    <td bordercolor="#FFFFFF" align="left" bgcolor="#bbbbbb"><?=$qty[$invoice_no_array[$i]][$j]?></td>
                    <td bordercolor="#FFFFFF"  align="right" bgcolor="#bbbbbb"><?=$marketprice[$invoice_no_array[$i]][$j]?></td>
        
                 
                    <td bordercolor="#FFFFFF" align="right" bgcolor="#bbbbbb"><?=$subtotal[$invoice_no_array[$i]][$j]?></td>
                </tr>
 				<? } ?>
	  
	
<tr><td colspan="13">
   <table width="100%" border="0" cellpadding="1" cellspacing="1">
   <tbody><tr>
     <td>總計 <?=$total_price[$invoice_no_array[$i]]?>  <a href="../invoice_door/invoice_door_edit.php?id=<?php echo $invoice_no_array[$i];?>">&lt;EDIT&gt;</a></td></tr>
   </tbody></table></td></tr></tbody>
                
                </table>
              </div> <br />
<?                } ?>
			</div>
		
    


<?
	$credit_card_total=0;
   $subtotal=$invoice_total[$temp_invoice_no]+$man_power_price[$temp_invoice_no];
   $subtotal=round($subtotal, 2);
  // echo "subtotal=".$subtotal;
   $subsubtotal=($subtotal*((100-$discount_percent[$temp_invoice_no])/100))-$discount_deduct[$temp_invoice_no];
   
   //credit card
   if ($invoice_credit_card_rate[$temp_invoice_no]!=0 and $invoice_credit_card_rate[$temp_invoice_no]!=null)
   {
   		$credit_card_total=round($subsubtotal*$invoice_credit_card_rate[$temp_invoice_no]/100);	
   		$subsubtotal=$credit_card_total+$subsubtotal;
   }
   
   
   for ($i=0;$i<count($shop_array);$i++){
   	if($branchID["$temp_invoice_no"]==$shop_array[$i]){
			$shop_counter[$i]=$shop_counter[$i]+$subsubtotal;
		
				  if($temp_invoice_settle=="S")
				  {
						$unsettle_shop_subtotal_counter[$i]=$unsettle_shop_subtotal_counter[$i]+$subsubtotal;
						$unsettle_shop_deposit_counter[$i]=$unsettle_shop_deposit_counter[$i]+$temp_invoice_deposit;
					}
				  else
				  {
						$settle_shop_subtotal_counter[$i]=$settle_shop_subtotal_counter[$i]+$subsubtotal;
						//$A_deposit_y_counter=$A_deposit_y_counter+$temp_invoice_deposit;
					}
			}		
		}
   

   $day_counter=$day_counter+$subsubtotal;
?>
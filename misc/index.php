<?php

  $invoiceRecord=15;
  $chqRecord=17;
	require_once("./include/config.php");
	require_once("./include/functions.php");
	
	//get Staff name
	    $connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
       $query="SET NAMES 'UTF8'";
   

   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
	$result = $connection->query("SET NAMES 'UTF8'");
	if (DB::isError($result)) die ($result->getMessage());
	$sql="SELECT * FROM staff";
	$staffResult = $connection->query($sql);

	
	$month=date("m");
	$year=date("Y");
	$day=date("d");
	$shop_array = $AREA;
	  
	 $subtotal="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year && DAYOFMONTH(invoice.invoice_date)=$day ";
	$rows = $connection->query($subtotal);
   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
   $day_counter=$row['total'];
   

	for ($i=0;$i<count($shop_array);$i++){
		$shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year && DAYOFMONTH(invoice.invoice_date)=$day and branchID='$shop_array[$i]'";
		
		$shop_invoice_scrap_subtotal[$i]="select sum(total_price) as total from invoice_scrap where month(invoice_scrap.invoice_date)=$month && year(invoice_scrap.invoice_date)=$year && DAYOFMONTH(invoice_scrap.invoice_date)=$day and branchID='$shop_array[$i]'";
		$settle_shop_invoice_scrap_subtotal[$i]="select sum(total_price) as total from invoice_scrap  where month(invoice_scrap.settledate)=$month && year(invoice_scrap.settledate)=$year && DAYOFMONTH(invoice_scrap.settledate)=$day and branchID='$shop_array[$i]' and settle='A'";
		$unsettle_shop_invoice_scrap_subtotal[$i]="select sum(total_price) as total from invoice_scrap where month(invoice_scrap.invoice_date)=$month && year(invoice_scrap.invoice_date)=$year && DAYOFMONTH(invoice_scrap.invoice_date)=$day and branchID='$shop_array[$i]' and settle='S'";
	
	
		$shop_invoice_door_subtotal[$i]="select sum(total_price) as total from invoice_door where month(invoice_door.invoice_date)=$month && year(invoice_door.invoice_date)=$year && DAYOFMONTH(invoice_door.invoice_date)=$day and branchID='$shop_array[$i]'";
		$settle_shop_invoice_door_subtotal[$i]="select sum(total_price) as total from invoice_door  where month(invoice_door.settledate)=$month && year(invoice_door.settledate)=$year && DAYOFMONTH(invoice_door.settledate)=$day and branchID='$shop_array[$i]' and settle='A'";
		$unsettle_shop_invoice_door_subtotal[$i]="select sum(total_price) as total from invoice_door where month(invoice_door.invoice_date)=$month && year(invoice_door.invoice_date)=$year && DAYOFMONTH(invoice_door.invoice_date)=$day and branchID='$shop_array[$i]' and settle='S'";

		
		$settle_shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.settledate)=$month && year(invoice.settledate)=$year && DAYOFMONTH(invoice.settledate)=$day and branchID='$shop_array[$i]' and settle='A'";
		$unsettle_shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year && DAYOFMONTH(invoice.invoice_date)=$day and branchID='$shop_array[$i]' and settle='S'";
		
		
		$dayday=$day+1;
		$unsettle_shop_subtotal_from_day_one[$i]="select sum(total_price) as total from invoice where invoice.invoice_date <= '$year-$month-$dayday' and branchID='$shop_array[$i]' and settle='S'";
		$unsettle_shop_deposit[$i]="select sum(deposit) as total from invoice where month(invoice.settledate)=$month && year(invoice.settledate)=$year && DAYOFMONTH(invoice.settledate)=$day and branchID='$shop_array[$i]' and settle='S'";
		$shop_return_total[$i]="select sum(total_price) as total from returngood where month(returngood.return_date)=$month && year(returngood.return_date)=$year && DAYOFMONTH(returngood.return_date)=$day and branchID='$shop_array[$i]'";
		$delivery_total[$i]="select sum(fee) as total from delivery_fee where month(delivery_date)=$month && year(delivery_date)=$year && DAYOFMONTH(delivery_date)=$day and shop='$shop_array[$i]'";
		$member_total_deposit[$i]="select sum(deposit_amt) as total from member_deposit where month(deposit_date)=$month && year(deposit_date)=$year && DAYOFMONTH(deposit_date)=$day and branchID='$shop_array[$i]' ";
		$member_total_spend_on_deposit[$i]="select sum(total_price) as total from invoice where month(invoice.settledate)=$month && year(invoice.settledate)=$year && DAYOFMONTH(invoice.settledate)=$day and branchID='$shop_array[$i]' and settle='A' and deposit_method='D' ";
		$member_total_all_deposit[$i]="select sum(deposit_amt) as total from member_deposit where deposit_date  <= '$year-$month-$dayday' and  	branchID='$shop_array[$i]' ";
		
		if ($AREA==$shop_array[$i]  ){
			 
		   $rows = $connection->query($shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $shop_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($shop_invoice_scrap_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $shop_invoice_scrap_counter[$i]=$row['total'];
		    
			$rows = $connection->query($unsettle_shop_invoice_scrap_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $unsettle_shop_invoice_scrap_subtotal_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($settle_shop_invoice_scrap_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $settle_shop_invoice_scrap_subtotal_counter[$i]=$row['total'];
		   
			
		   $rows = $connection->query($shop_invoice_door_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $shop_invoice_door_counter[$i]=$row['total'];
		    
			$rows = $connection->query($unsettle_shop_invoice_door_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $unsettle_shop_invoice_door_subtotal_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($settle_shop_invoice_door_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $settle_shop_invoice_door_subtotal_counter[$i]=$row['total'];
			
		   $rows = $connection->query($settle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $settle_shop_subtotal_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($unsettle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $unsettle_shop_subtotal_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($unsettle_shop_subtotal_from_day_one[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $unsettle_shop_subtotal_from_day_one_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($unsettle_shop_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $unsettle_shop_deposit_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($shop_return_total[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $return_shop_total_counter[$i]=$row['total'];
		   
		    $rows = $connection->query($delivery_total[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $delivery_total_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_deposit_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_spend_on_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_deposit_counter[$i]=$row['total'];
		   
		      $rows = $connection->query($member_total_all_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_all_deposit_counter[$i]=$row['total'];
		   
   }
		
	}
	  
	    
  	for ($i=0;$i<count($shop_array);$i++){
		$fixAmt=$settle_shop_subtotal_counter[$i]-$return_shop_total_counter[$i]+$settle_shop_invoice_scrap_subtotal_counter[$i]+$settle_shop_invoice_door_subtotal_counter[$i];
	 

		 } 
?> 
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<? // = $ajax->loadJsCore(true) ?>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/jquery-1.4.1.min.js"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="/misc/misc.js"></script>
<style type="text/css">
 
.style11 {
	font-size: xx-small
	}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFF;
}
a:visited {
	color: #FFF;
}
a:hover {
	color: #FFF;
}
a:active {
	color: #FFF;
}
 
 
</style>
<form action="/?page=misc&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="800"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff"  >
  <tr  >
    <td width="4" height="360">&nbsp;</td>
    <td align="center" valign="top">
	<table width="100%"  border="0" cellpadding="2" cellspacing="0" >
      <tr>
        <td width="14%" height="21" bgcolor="#004d80"><span class="style6"><a href="../">收支日報表</a></span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF" valign="top">
        <td height="24" colspan="4" >
		<table width="100%" border="0" cellpadding="2" cellspacing="0" >
			<tr bgcolor="#004d80" class="style6">
            <td width="80">發票日期：</td>
				<td width="136"><input name="invoice_date" type="text" id="invoice_date" value="<? echo Date("Y-m-d "); ?>" size="16" maxlength="20" readonly="readonly"></td>
				<td width="136">鋪<input name="AREA" type="text" id="AREA" value="<? echo $AREA; ?>" size="1" maxlength="1" readonly="readonly"></td>
				<td width="136"></td>
			</tr>
		</table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="2" style="vertical-align: top;">
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#004d80">
            <td width="20" class="style6"><span >行數</span></td>
            <td width="35" class="style6"><span class="style6">什項支出</span></td>
            <td  class="style6"><span class="style6">金額</span></td>
          </tr>
			<?
			$tab=0;        
			for ($i=0;$i<$invoiceRecord;$i++)          
			{
				?>
						<tr bgcolor="#CCCCCC">
							<td><div align="center"><span class="style7"><?echo $i+1;?></span></div></td>
							<td><input size="39" type="text" name="misc[<?echo $i;?>]" id="misc[<?echo $i;?>]"></td>
							<td><input type="text" size="10" name="misc_amt[<?echo $i;?>]" id="misc_amt[<?echo $i;?>]" onChange="calTotalExpAmt()"></td>
						</tr>
				 
			<?}?> 
        </table>
		
	 
		
		</td><td colspan="2" valign="top">
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#ffffff" >
		<?php 
		 
		 for ($i=0;$i<$chqRecord;$i++){
			 
		 ?>
		  <tr bgcolor="#CCCCCC">
            <td >支票<?php echo $i+1;?>:</td>
            <td ><input type="text" name="cheque[<?php echo $i;?>]" size="28"></td>
            <td ><input type="text" name="cheque_amt[<?php echo $i;?>]" id="cheque_amt[<?php echo $i;?>]" onChange="calTotalChqAmt()" size="10"></td>
          </tr>
		 <?php
		 }
		 ?>
          <tr bgcolor="#CCCCCC" >
           
            <td  >生意總額:</span></td>
            <td ><span class="style6"><input type="text" name="daily_revenue" id="daily_revenue" value="<?php echo $fixAmt;?>" onChange="calDailyIncome()"></span></td>
			 <td  ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
            
            <td >總支出:</span></td>
            <td ><span class="style6"><input type="text" name="daily_expend" id="daily_expend"></span></td><td ></td>
          </tr>
		   <tr bgcolor="#CCCCCC">
         
            <td >支票:</span></td>
            <td  ><span class="style6"><input type="text" name="daily_cheque" id="daily_cheque"></span></td>   <td  ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
           
            <td >信用卡:</span></td>
            <td ><span class="style6"><input type="text" name="daily_creditcard"  id="daily_creditcard"   onChange="calDailyIncome()" ></span></td> <td ></td>
          </tr>
		    <tr bgcolor="#CCCCCC">
          
            <td >銀聯卡:</td>
            <td ><input type="text" name="daily_unionpay" id="daily_unionpay" onChange="calDailyIncome()"></td>  <td ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
            
            <td >EPS:</td>
            <td ><input type="text" name="daily_eps" id="daily_eps" onChange="calDailyIncome()"></td><td ></td>
          </tr>
		 <tr bgcolor="#CCCCCC">
            
            <td >FPS:</td>
            <td ><input type="text" name="daily_fps" id="daily_fps" onChange="calDailyIncome()"></td><td ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
           
            <td >入數:</td>
            <td ><span class="style6"><input type="text" name="daily_income" id="daily_income"></span></td> <td ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
            <td ><span class="style6"></span></td>
            <td ><span class="style6"></span></td>
            <td ><span class="style6"></span></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
          
            <td >是日存柜:</td>
            <td ><input type="text" name="daily_drawer" onChange="calDrawerAmt()" id="daily_drawer"></td>  <td ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
           
            <td >昨日存柜:</td>
            <td ><span class="style6"><input type="text" name="past_daily_drawer" onChange="calDrawerAmt()" id="past_daily_drawer"></span></td> <td ><span class="style6"></span></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
         
            <td>差額:</td>
            <td ><span class="style6"><input type="text" name="drawer_diff" id="drawer_diff"></span></td>   <td ><span class="style6"></span></td>
          </tr>
		  
        </table>
		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#004d80">
            <tr>
              <td ><span class="style6">
                <input name="clear" type="reset" id="clear" value="清除">
              </span></td>
              <td width="10%"> </td>
              <td width="8%">
                <!--<input type="checkbox" name="special_man_power" value="Y" />-->
               </td>
              <td ></td>
            <td width="18%">
              
 </td>
              <td width="17%" class="style6">
                            </td>
              <td width="17%"><span class="style6">
                
               
              </span></td>
              <td width="8%" class="style6"> </td>
              <td width="8%"><input name="submitb" type="button" id="submitb" value="送出" onClick="checkform()"></td>
            </tr>
          </table>          </td>
      </tr>
    
    </table>     </td>
  </tr>
</table>
<input type="hidden" name="AREA" value="<?echo $AREA;?>" />
<input type="hidden" name="PC" value="<?echo $PC;?>" />
</form>

<?php
require_once("./include/config.php");
 
$previous_year=$year;
$previous_month=$month;
$previous_day=$day;
$prev_date_end=$year.'-'.$month.'-'.$day.' 23:59:59';
$prev_date_start=$year.'-'.$month.'-01 00:00:01';

$invoice_date=$year.'-'.$month.'-'.$day;

//echo $prev_date_end;
//echo $prev_date_start;

	$connection = DB::connect($dsn);
   if (DB::isError($connection))
   die($connection->getMessage());
   $result = $connection->query("SET NAMES 'UTF8'");
   
 
   function security_check($AREA,$PC){
	if (($AREA=="Y" && $PC=="1")  || ($AREA=="Y" && $PC=="99")){
		
			return TRUE;}
	else{
		
			return FALSE;
		}
	} 
	
if (security_check($AREA,$PC)){
	$shop_array = array ( "Y","B","H","F","A");
}else{
	$shop_array = array ( $AREA);
	}

  
 //  	$month=date("m");
	//$year=date("Y");

?>
<style type="text/css">
<!--
body,td,th ,tr{
	font-size: 11px;
}
.yrtfont {
	font-size: 13px;
	font-weight: normal;
	font-style: normal;
}
.yrtfontBold {
	font-size: 15px;
	font-weight: bold;
	font-style: normal;
}
-->
</style>
<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="/ui/ui.core.js"></script>
<script type="text/javascript" src="/ui/ui.tabs.js"></script>
<link type="text/css" href="/css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript">
	


	$(function() {
			   
		
		$("#tabs,#tabs2,#tabs3").tabs();	
		$("#accordion").accordion({ 
								  icons: { 'header': 'ui-icon-plus', 'headerSelected': 'ui-icon-minus' },
								  header: "h3" ,
								   
									collapsible:false,
  							activate:true,
  						alwaysOpen:true,
  							autoHeight:false
								  });
	
		$(document).ready(function() {	});


  //Get all the LI from the #tabMenu UL
  $('#tabMenu > li').click(function(){
        
    //remove the selected class from all LI    
    $('#tabMenu > li').removeClass('selected');
    
    //Reassign the LI
    $(this).addClass('selected');
    
    //Hide all the DIV in .boxBody
    $('.boxBody div').slideUp('1500');
    
    //Look for the right DIV in boxBody according to the Navigation UL index, therefore, the arrangement is very important.
    $('.boxBody div:eq(' + $('#tabMenu > li').index(this) + ')').slideDown('1500');
    
  }).mouseover(function() {

    //Add and remove class, Personally I dont think this is the right way to do it, anyone please suggest    
    $(this).addClass('mouseover');
    $(this).removeClass('mouseout');   
    
  }).mouseout(function() {
    
    //Add and remove class
    $(this).addClass('mouseout');
    $(this).removeClass('mouseover');    
    
  });

  //Mouseover with animate Effect for Category menu list
  $('.boxBody #category li').mouseover(function() {

    //Change background color and animate the padding
    $(this).css('backgroundColor','#888');
    $(this).children().animate({paddingLeft:"20px"}, {queue:false, duration:300});
  }).mouseout(function() {
    
    //Change background color and animate the padding
    $(this).css('backgroundColor','');
    $(this).children().animate({paddingLeft:"0"}, {queue:false, duration:300});
  });  
	
  //Mouseover effect for Posts, Comments, Famous Posts and Random Posts menu list.
  $('.boxBody li').click(function(){
    window.location = $(this).find("a").attr("href");
  }).mouseover(function() {
    $(this).css('backgroundColor','#888');
  }).mouseout(function() {
    $(this).css('backgroundColor','');
  });  	
	
});

</script>
<script src="/src/js/jscal2.js"></script>
<script src="/src/js/lang/en.js"></script>
<link type="text/css" rel="stylesheet" href="/src/css/jscal2.css" />
<link type="text/css" rel="stylesheet" href="/src/css/border-radius.css" />
<link id="skinhelper-compact" type="text/css" rel="alternate stylesheet" href="/src/css/reduce-spacing.css" />
<?
 if ($day!="" && $year != ""){
  $subtotal="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year && DAYOFMONTH(invoice.invoice_date)=$day  and void='A' ";
	$rows = $connection->query($subtotal);
   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
   $day_counter=$row['total'];
   

	for ($i=0;$i<count($shop_array);$i++){
		$shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year && DAYOFMONTH(invoice.invoice_date)=$day and branchID='$shop_array[$i]' and void='A' ";
		
		$shop_invoice_scrap_subtotal[$i]="select sum(total_price) as total from invoice_scrap where month(invoice_scrap.invoice_date)=$month && year(invoice_scrap.invoice_date)=$year && DAYOFMONTH(invoice_scrap.invoice_date)=$day and branchID='$shop_array[$i]'";
		$settle_shop_invoice_scrap_subtotal[$i]="select sum(total_price) as total from invoice_scrap  where month(invoice_scrap.settledate)=$month && year(invoice_scrap.settledate)=$year && DAYOFMONTH(invoice_scrap.settledate)=$day and branchID='$shop_array[$i]' and settle='A'";
		$unsettle_shop_invoice_scrap_subtotal[$i]="select sum(total_price) as total from invoice_scrap where month(invoice_scrap.invoice_date)=$month && year(invoice_scrap.invoice_date)=$year && DAYOFMONTH(invoice_scrap.invoice_date)=$day and branchID='$shop_array[$i]' and settle='S'";
	
	
		$shop_invoice_door_subtotal[$i]="select sum(total_price) as total from invoice_door where month(invoice_door.invoice_date)=$month && year(invoice_door.invoice_date)=$year && DAYOFMONTH(invoice_door.invoice_date)=$day and branchID='$shop_array[$i]'";
		$settle_shop_invoice_door_subtotal[$i]="select sum(total_price) as total from invoice_door  where month(invoice_door.settledate)=$month && year(invoice_door.settledate)=$year && DAYOFMONTH(invoice_door.settledate)=$day and branchID='$shop_array[$i]' and settle='A'";
		$unsettle_shop_invoice_door_subtotal[$i]="select sum(total_price) as total from invoice_door where month(invoice_door.invoice_date)=$month && year(invoice_door.invoice_date)=$year && DAYOFMONTH(invoice_door.invoice_date)=$day and branchID='$shop_array[$i]' and settle='S'";

		
		$settle_shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.settledate)=$month && year(invoice.settledate)=$year && DAYOFMONTH(invoice.settledate)=$day and branchID='$shop_array[$i]' and settle='A'  and void='A' ";
		$unsettle_shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year && DAYOFMONTH(invoice.invoice_date)=$day and branchID='$shop_array[$i]' and settle='S'  and void='A' ";
		
		
		$dayday=$day+1;
		$unsettle_shop_subtotal_from_day_one[$i]="select sum(total_price) as total from invoice where invoice.invoice_date <= '$year-$month-$dayday' and branchID='$shop_array[$i]' and settle='S'  and void='A'";
		$unsettle_shop_deposit[$i]="select sum(deposit) as total from invoice where month(invoice.settledate)=$month && year(invoice.settledate)=$year && DAYOFMONTH(invoice.settledate)=$day and branchID='$shop_array[$i]' and settle='S'  and void='A' ";
		$shop_return_total[$i]="select sum(total_price) as total from returngood where month(returngood.return_date)=$month && year(returngood.return_date)=$year && DAYOFMONTH(returngood.return_date)=$day and branchID='$shop_array[$i]'";
		$delivery_total[$i]="select sum(fee) as total from delivery_fee where month(delivery_date)=$month && year(delivery_date)=$year && DAYOFMONTH(delivery_date)=$day and shop='$shop_array[$i]'";
		$member_total_deposit[$i]="select sum(deposit_amt) as total from member_deposit where month(deposit_date)=$month && year(deposit_date)=$year && DAYOFMONTH(deposit_date)=$day and branchID='$shop_array[$i]' ";
		$member_total_bank_deposit[$i]="select sum(deposit_bank_amt) as total from member_deposit where month(deposit_date)=$month && year(deposit_date)=$year && DAYOFMONTH(deposit_date)=$day and branchID='$shop_array[$i]' ";
		
		//today spending memeber cash on invoice
		$member_total_spend_on_deposit[$i]="select sum(total_price) as total from invoice where month(invoice.settledate)=$month && year(invoice.settledate)=$year && DAYOFMONTH(invoice.settledate)=$day and branchID='$shop_array[$i]'  and void='A' and settle='A' and deposit_method='D' ";
		
		//today spending memeber bank on invoice
		$member_total_spend_on_bank_deposit[$i]="select sum(total_price) as total from invoice where month(invoice.settledate)=$month && year(invoice.settledate)=$year && DAYOFMONTH(invoice.settledate)=$day and branchID='$shop_array[$i]'  and void='A' and settle='A' and deposit_method='B' ";
		
		//today spending memeber cash on invoice door
		$member_total_spend_on_deposit_door[$i]="select sum(total_price) as total from invoice_door where month(settledate)=$month && year(settledate)=$year && DAYOFMONTH(settledate)=$day and branchID='$shop_array[$i]'   and settle='A' and deposit_method='D' ";
		
		//today spending memeber bank on invoice door
		$member_total_spend_on_bank_deposit_door[$i]="select sum(total_price) as total from invoice_door where month(settledate)=$month && year(settledate)=$year && DAYOFMONTH(settledate)=$day and branchID='$shop_array[$i]'   and settle='A' and deposit_method='B' ";
		
		
		//all member spending by bank acc on invoice 
		$member_total_spend_on_all_bank_deposit[$i]="select sum(total_price) as total from invoice where branchID='$shop_array[$i]'  and void='A' and settle='A' and deposit_method='B' and invoice.settledate <= '$year-$month-$dayday'";
		//echo $member_total_spend_on_all_bank_deposit[$i];
		//all member spending by cash acc on invoice 
		$member_total_spend_on_all_deposit[$i]="select sum(total_price) as total from invoice where branchID='$shop_array[$i]'  and void='A' and settle='A' and deposit_method='D' and invoice.settledate <= '$year-$month-$dayday'";
		
		//all member spending by bank acc on invoice door 
		$member_total_spend_on_all_bank_deposit_door[$i]="select sum(total_price) as total from invoice_door where branchID='$shop_array[$i]'   and settle='A' and deposit_method='B' and settledate <= '$year-$month-$dayday'";
		//echo $member_total_spend_on_all_bank_deposit_door[$i];
		//all member spending by cash acc on invoice door 
		$member_total_spend_on_all_deposit_door[$i]="select sum(total_price) as total from invoice_door where branchID='$shop_array[$i]'    and settle='A' and deposit_method='D' and settledate <= '$year-$month-$dayday'";
				
				
		// all member deposit by cash acc
		$member_total_all_deposit[$i]="select sum(deposit_amt) as total from member_deposit where deposit_date  <= '$year-$month-$dayday' and  	branchID='$shop_array[$i]' ";
		
		// all member deposit by bank
		$member_total_all_bank_deposit[$i]="select sum(deposit_bank_amt) as total from member_deposit where deposit_date  <= '$year-$month-$dayday' and  	branchID='$shop_array[$i]' ";
		
		if ($AREA==$shop_array[$i] || security_check($AREA,$PC) ){
			 
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
		   
		   $rows = $connection->query($member_total_bank_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_bank_deposit_counter[$i]=$row['total'];
		   
		   
		   $rows = $connection->query($member_total_spend_on_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_deposit_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_spend_on_bank_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_bank_deposit_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_spend_on_deposit_door[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_deposit_door_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_spend_on_bank_deposit_door[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_bank_deposit_door_counter[$i]=$row['total'];
		   
		   
		   $rows = $connection->query($member_total_all_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_all_deposit_counter[$i]=$row['total'];
		     
		   $rows = $connection->query($member_total_all_bank_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_all_bank_deposit_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_spend_on_all_bank_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_all_bank_deposit_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_spend_on_all_deposit[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_all_deposit_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_spend_on_all_bank_deposit_door[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_all_bank_deposit_door_counter[$i]=$row['total'];
		   
		   $rows = $connection->query($member_total_spend_on_all_deposit_door[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $member_total_spend_on_all_deposit_door_counter[$i]=$row['total'];
		   
   }
		
	}



}
	?>
<body >
<form name="form1" method="POST" action="/?page=statistic&subpage=statistic.php">
<input type="hidden" name="year" id="year" value="" />
<input type="hidden" name="month" id="month" value="" />
<input type="hidden" name="day" id="day" value="" />
<table width="100%" align="center">
      <tr>
        <td width="400" valign="top" >
          <div id="cont"></div>
          <script type="text/javascript">
            var LEFT_CAL = Calendar.setup({
                    cont: "cont",
                    weekNumbers: true,
                    selectionType: Calendar.SEL_MULTIPLE,
                    showTime: 24
                    // titleFormat: "%B %Y"
            })
          </script></td>
		<td>
<input type="text" id="f_selection" name="f_selection"  value="<?=$f_selection?>"/> <input type="submit"  name="submit" />
<input type="button"  name="monthreportsubmit" id="monthreportsubmit"  onclick="javascript:monthreportsubmit()"/>
<script type="text/javascript">
LEFT_CAL.addEventListener("onSelect", function(){
var ta = document.getElementById("f_selection");
var year = document.getElementById("year");
var month = document.getElementById("month");
var day = document.getElementById("day");
 ta.value = this.selection.print("%Y/%m/%d").join("\n");
 year.value = this.selection.print("%Y");
  month.value = this.selection.print("%m");
   day.value = this.selection.print("%d");
 });</script>
</td></tr>
</table></form>
<div class="demo">

  <div  id="tabs">
			<ul >
             
            	<? for ($i=0;$i<count($shop_array);$i++){ ?>

				<li ><a href="/?page=statistic&subpage=statistic_by_shop.php&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>&branchID=<?=$shop_array[$i]?>"><span><? echo $shop_array[$i];?></span></a></li> 
                <? } ?>
                				<? /*<li class="ui-corner-top <? if ($i==8) {echo "ui-tabs-selected" ;} ?> ui-state-active"><a href="<? echo "#tabs-".($i+1); ?>"><? echo $shop_array[$i];?></a></li> */?>
                   <? if (security_check($AREA,$PC)){ ?>
				<li class="ui-corner-top  ui-state-active"><a href="/?page=statistic&subpage=statistic_month.php&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>"><span>Month</span></a></li> 
				<li class="ui-corner-top  ui-state-active"><a href="/?page=statistic&subpage=statistic_misc_monthly.php&shop=Y&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>"><span>月收支日報表Y</span></a></li> 
				<li class="ui-corner-top  ui-state-active"><a href="/?page=statistic&subpage=statistic_misc_monthly.php&shop=A&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>"><span>月收支日報表A</span></a></li> 
                <? }?>
			</ul>
			
		

</div>
</div>
<hr>
<div class="demo">

  <div  id="tabs2">
			<ul >
             
            	<? for ($i=0;$i<count($shop_array);$i++){ ?>

				<li ><a href="/?page=statistic&subpage=statistic_invoice_scrap_by_shop.php&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>&branchID=<?=$shop_array[$i]?>"><span><? echo $shop_array[$i];?></span></a></li> 
                <? } ?>
                				<? /*<li class="ui-corner-top <? if ($i==8) {echo "ui-tabs-selected" ;} ?> ui-state-active"><a href="<? echo "#tabs-".($i+1); ?>"><? echo $shop_array[$i];?></a></li> */?>
                   <? if (security_check($AREA,$PC)){ ?>
				<li class="ui-corner-top  ui-state-active"><a href="/?page=statistic&subpage=statistic_invoice_scrap_month.php&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>"><span>Month</span></a></li> 
                <? }?>
			</ul>
			
		

</div>
</div>
<hr>
<div class="demo">

  <div  id="tabs3">
			<ul >
             
            	<? for ($i=0;$i<count($shop_array);$i++){ ?>

				<li ><a href="/?page=statistic&subpage=statistic_invoice_door_by_shop.php&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>&branchID=<?=$shop_array[$i]?>"><span><? echo $shop_array[$i];?></span></a></li> 
                <? } ?>
                				<? /*<li class="ui-corner-top <? if ($i==8) {echo "ui-tabs-selected" ;} ?> ui-state-active"><a href="<? echo "#tabs-".($i+1); ?>"><? echo $shop_array[$i];?></a></li> */?>
                   <? if (security_check($AREA,$PC)){ ?>
				<li class="ui-corner-top  ui-state-active"><a href="/?page=statistic&subpage=statistic_invoice_door_month.php&year=<?=$year?>&month=<?=$month?>&day=<?=$day?>"><span>Month</span></a></li> 
                <? }?>
			</ul>
			
		

</div>
</div>
<hr>
<table width=" " align="center" >
  <tr>
    <td >
<div class="demo">
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all">
<table  align="center" >
  <tr>
    <td colspan="<?=count($shop_array)?>"><ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all"><div align="center" class="yrtfont"><span class="yrtfontBold">日結</span></div></ul></td>
  </tr>
  <tr>
  <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td width="360"><span class="yrtfontBold"><u>
		  <?=$shop_array[$i]?>
		  舖 </u>    </span><span class="yrtfont"> </span>  </td>
		<?}
    
  ?>
  </tr>
  <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">總數 <?=number_format($shop_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  <tr>
   <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">入賬<?=number_format($settle_shop_subtotal_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  <tr>
   <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">掛單 <?=number_format($unsettle_shop_subtotal_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
   <? if (security_check($AREA,$PC))
   { ?>
    <tr>
<?
  	for ($i=0;$i<count($shop_array);$i++){ ?>
		<td class="yrtfont">掛單累計 <?=number_format(    $unsettle_shop_subtotal_from_day_one_counter[$i],2,'.',',')?></td>
		<? } ?>
  </tr>
<? } ?>
  <tr>
     <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">掛單訂金 <?=number_format($unsettle_shop_deposit_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">退貨 <?=number_format($return_shop_total_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  
  <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">木板碎料出貨單總數 <?=number_format($shop_invoice_scrap_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  
    <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">掛單木板碎料 <?=number_format($unsettle_shop_invoice_scrap_subtotal_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  
   <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">入帳木板碎料 <?=number_format($settle_shop_invoice_scrap_subtotal_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  
  
  <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">方邊門出貨單總數 <?=number_format($shop_invoice_door_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
    <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">會員當天現金存款 <?=number_format($member_total_deposit_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
   <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">會員當天銀行存款 <?=number_format($member_total_bank_deposit_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
   <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">會員當天現金存款扣數 <?=number_format($member_total_spend_on_deposit_counter[$i]-$member_total_spend_on_deposit_door_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
   <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">會員當天存銀行款扣數 <?=number_format($member_total_spend_on_bank_deposit_counter[$i]-$member_total_spend_on_bank_deposit_door_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">會員現金總存款 <?=number_format($member_total_all_deposit_counter[$i]-$member_total_spend_on_all_deposit_counter[$i]-$member_total_spend_on_all_deposit_door_counter[$i],2,'.',',')?> </td>
		<?}?>
  </tr>
   <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){?>
		<td class="yrtfont">會員銀行總存款 <?=number_format($member_total_all_bank_deposit_counter[$i]-$member_total_spend_on_all_bank_deposit_counter[$i]-$member_total_spend_on_all_bank_deposit_door_counter[$i],2,'.',',')?>(<?=number_format($member_total_all_bank_deposit_counter[$i],2,'.',',')?>-<?=number_format($member_total_spend_on_all_bank_deposit_counter[$i],2,'.',',')?>)</td>
		<?}?>
  </tr>
   <tr>
    <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){
		$fixAmt=$settle_shop_subtotal_counter[$i]-$return_shop_total_counter[$i]+$settle_shop_invoice_scrap_subtotal_counter[$i]+$settle_shop_invoice_door_subtotal_counter[$i];
		$t_fixAmt=$t_fixAmt+$fixAmt;
		$day_counter=$day_counter+$unsettle_shop_subtotal[$i]+$unsettle_shop_invoice_door_subtotal[$i];
		?>
		<td class="yrtfont">實數 <?=number_format($fixAmt,2,'.',',')?></td>
		<?}?>
  </tr>
   <tr>
    <?
  	for ($i=0;$i<count($shop_array);$i++){
		  
		?>
		<td class="yrtfont">街車數 <?=number_format($delivery_total_counter[$i],2,'.',',')?></td>
		<?}?>
  </tr>
  
  <?   if (security_check($AREA,$PC)){ ?>
  <tr>
  
    <td colspan="<?=count($shop_array)?>">
    <table width="100%"> <tr><td><div align="center"><span class="yrtfontBold">全日總數
<?=number_format($day_counter,2,'.',',')?></span>
    </div></td>
     <td colspan="<?=count($shop_array)?>"><div align="center"><span class="yrtfontBold">全日實數
<?=number_format($t_fixAmt,2,'.',',')?></span>
    </div></td>
    </tr></table></td>
  </tr>
  <? } ?>
  </table>
</div></div></td></tr></table>
<p> 

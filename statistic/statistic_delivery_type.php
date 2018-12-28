<?php
require_once("./include/config.php");

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
	 

  
 //  	$month=date("m");
	//$year=date("Y");

?>
<style type="text/css">
<!--
body,td,th ,tr{
	font-size: 14px;
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
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<!--<link type="text/css" href="../themes/base/ui.all.css" rel="stylesheet" />-->
<!--<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>-->
<script type="text/javascript" src="./js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="./ui/ui.core.js"></script>
<script type="text/javascript" src="./ui/ui.tabs.js"></script>
<!--<link type="text/css" href="../css/demos.css" rel="stylesheet" />-->
<link type="text/css" href="./css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script src="./src/js/jscal2.js"></script>
<script src="./src/js/lang/en.js"></script>
<link type="text/css" rel="stylesheet" href="./src/css/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./src/css/border-radius.css" />
<link id="skinhelper-compact" type="text/css" rel="alternate stylesheet" href="./src/css/reduce-spacing.css" />
<?
 
	   
	   
 if ($day!="" && $year != ""){
	 
	 
	//search day invoice items 
	$invoice="select delivery,branchID, sum(total_price) as total_price from invoice where month(invoice.delivery_date)=$month && year(invoice.delivery_date)=$year && DAYOFMONTH(invoice.delivery_date)=$day  and void='A' group by branchID,delivery";
    
 
	$invoiceresult = $connection->query($invoice);
	$i=0;
		while($row=$invoiceresult->fetchRow(DB_FETCHMODE_ASSOC)){
	   
	   if ($row['delivery']=="Y"){$invoiceItem[$i]['delivery']= "送貨";}
	   if ($row['delivery']=="C"){$invoiceItem[$i]['delivery']= "街車";} 
	   if ($row['delivery']=="S"){$invoiceItem[$i]['delivery']= "自取";}
	   
		   //$invoiceItem[$i]['delivery']=$row['delivery'];
		   $invoiceItem[$i]['total_price']=$row['total_price'];
		  $invoiceItem[$i]['branchID']=$row['branchID'];
			 
		   $i++;
		}
    
		//search day delivery_fee items 
	$del="select  fee,fee_2,shop from delivery_fee where month(delivery_date)=$month && year(delivery_date)=$year && DAYOFMONTH(delivery_date)=$day ";
    
 
	$delresult = $connection->query($del);
	$i=0;
		while($row=$delresult->fetchRow(DB_FETCHMODE_ASSOC)){
	   
		   $delItem[$i]['fee']=$row['fee'];
			$delItem[$i]['fee_2']=$row['fee_2'];	 
			$delItem[$i]['shop']=$row['shop'];	 
		   $i++;
		}
	//search month invoice item
	$invoice_month="select delivery,branchID , sum(total_price) as total_price from invoice where month(invoice.delivery_date)=$month && year(invoice.delivery_date)=$year   and void='A' group by delivery,branchID";
	$invoice_month_result = $connection->query($invoice_month);
	$i=0;
		while($row=$invoice_month_result->fetchRow(DB_FETCHMODE_ASSOC)){
	    if ($row['delivery']=="Y"){$invoiceMonthItem[$i]['delivery']= "送貨";}
	   if ($row['delivery']=="C"){$invoiceMonthItem[$i]['delivery']= "街車";} 
	   if ($row['delivery']=="S"){$invoiceMonthItem[$i]['delivery']= "自取";}
	   
		 //  $invoiceMonthItem[$i]['delivery']=$row['delivery'];
		   $invoiceMonthItem[$i]['total_price']=$row['total_price'];
		    $invoiceMonthItem[$i]['branchID']=$row['branchID'];
			 
		   $i++;
		}
	 
		//search month del item
	$del_month="select  sum(fee) as fee , sum(fee_2) as fee_2, shop from delivery_fee where month(delivery_date)=$month && year(delivery_date)=$year group by shop";
	$del_month_result = $connection->query($del_month);
 
 $i=0;
		while($row=$del_month_result->fetchRow(DB_FETCHMODE_ASSOC)){
		
		   $delMonthItem[$i]['fee']=$row['fee'];
		 	$delMonthItem[$i]['fee_2']=$row['fee_2'];	 
			$delMonthItem[$i]['shop']=$row['shop'];	 
			$i++;
		}
}

 
	?>
<body >
<form name="form1" method="POST" action="/?page=statistic&subpage=statistic_delivery_type.php">
<input type="hidden" name="year" id="year" value="<?php echo $year;?>" />
<input type="hidden" name="month" id="month" value="<?php echo $month;?>" />
<input type="hidden" name="day" id="day" value="<?php echo $day;?>" />
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
<input type="text" id="f_selection" name="f_selection"  value="<?=$f_selection?>"/>
 

<input type="submit"  name="submit" id="monthreportsubmit"  />
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
 
<hr>
 
 
 <table border="1" align="center">
 <tr><td colspan="3"><?php echo $day."-".$month."-".$year;?></td></tr>
 <TR><td>分店</td><td>送貨種類</td><td>總銷售</td></tr>
 <?
 $sum=0;
  for ($i=0;$i<count($invoiceItem);$i++)
  {
	  
	 ?><tr><td><?php echo $invoiceItem[$i]['branchID'];?></td><td><?php echo $invoiceItem[$i]['delivery'];?></td><td><?php echo $invoiceItem[$i]['total_price'];?></td></tr><?
	 $sum=$sum+$invoiceItem[$i]['total_price'];
  }
  
  ?>
  <td colspan=4>
  <table border=1>
	  <?php $fee=0; for ($i=0;$i<2;$i++){ ?>  
	  
	  <tr align="right"><td>Shop</td><td ><?php echo $delItem[$i]['shop'];?></td><td>街車費</td><td ><?php echo $delItem[$i]['fee'];?></td><td>森基街車費</td><td colspan="2"><?php echo $delItem[$i]['fee_2'];?></td></tr>
	  
	  <?php 
	  $fee=$fee+$delItem[$i]['fee']+$delItem[$i]['fee_2'];
	  } ?>
  </table>
  </td>
  <tr align="right"><td colspan="3"><?php echo $sum- $fee;?></td></tr>
  </table>


 <table border="1" align="center">
  <tr><td colspan="3">  <?php echo $month."-".$year;?><br></td></tr>
<TR><td>分店</td><td>送貨種類</td><td>總銷售</td></tr>
 <?
 $sum=0;
  for ($i=0;$i<count($invoiceMonthItem);$i++)
  {
	  
	 ?><tr><td><?php echo $invoiceMonthItem[$i]['branchID'];?></td><td><?php echo $invoiceMonthItem[$i]['delivery'];?></td><td><?php echo $invoiceMonthItem[$i]['total_price'];?></td></tr><?
   $sum=$sum+$invoiceMonthItem[$i]['total_price'];
  }
  ?>  
  
  
   <td colspan=4>
  <table border=1>
	  <?php $fee=0; for ($i=0;$i<2;$i++){ ?> 
	  
		<tr align="right"><td>Shop</td><td ><?php echo $delMonthItem[$i]['shop'];?></td><td>街車費</td><td ><?php echo $delMonthItem[$i]['fee'];?></td><td>森基街車費</td><td colspan="2"><?php echo $delMonthItem[$i]['fee_2'];?></td></tr>
   <?php
     $fee=$fee+$delMonthItem[$i]['fee']+$delMonthItem[$i]['fee_2'];
  }
  
  ?>
  </table>
  </td>
  
  <tr align="right"><td colspan="3"><?php echo $sum-$fee;?></td></tr>
  </table>
<?php }?> 
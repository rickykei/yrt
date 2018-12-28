<?php
error_reporting(0);
 ?> 
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script></head>
<link rel="stylesheet" href="./css/count_out_by_goods_partno.css" type="text/css">
<?php
   include_once("./include/config.php");
   $db = DB::connect($dsn);
   if (DB::isError($connection))
   die($connection->getMessage());
   $result = $db->query("SET NAMES 'UTF8'");
   // (Run the query on the winestore through the connection
   
   
   //20110302 search data result
   if ($button!=""){
    $sql="select ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where i.invoice_no=gi.invoice_no and  deductstock='Y' ";
    $inshopSql="select ifnull(sum(qty),0) as qty from inshop i , goods_inshop gi where i.inshop_no=gi.inshop_no and  deductstock='Y' ";
	 $scrapSql="select ifnull(sum(qty),0) as qty from  scrap i , goods_scrap gi where   i.invoice_no=gi.invoice_no and deductstock='Y' ";
   
   
   if ($goods_partno!="") 
	$sql2[]=" goods_partno like '".strtoupper($goods_partno)."'";
  
   if ($invoice_date_start!="")
    $sql2[].=" 	invoice_date >= '".$invoice_date_start." 00:00:00'";

   if ($invoice_date_end!="")
    $sql2[].=" 	invoice_date <= '".$invoice_date_end." 23:59:59'";
      
    $sql2=implode(" and ", $sql2);
   
   if ($goods_partno!="") 
	$sql3[]=" goods_partno like '".strtoupper($goods_partno)."'";
  
   if ($invoice_date_start!="")
    $sql3[].=" 	inshop_date >= '".$invoice_date_start." 00:00:00'";

   if ($invoice_date_end!="")
    $sql3[].=" 	inshop_date <= '".$invoice_date_end." 23:59:59'";
      
    $sql3=implode(" and ", $sql3);
   
     if ($goods_partno!="") 
	$sql4[]=" goods_partno like '".strtoupper($goods_partno)."'";
  
   if ($invoice_date_start!="")
    $sql4[].=" 	invoice_date >= '".$invoice_date_start." 00:00:00'";

   if ($invoice_date_end!="")
    $sql4[].=" 	invoice_date <= '".$invoice_date_end." 23:59:59'";
      
    $sql4=implode(" and ", $sql4);
	
   
   if ($sql2 !=""){
	$sql= $sql." and ".$sql2."  order by id  ";
	$inshopSql=$inshopSql." and ".$sql3."  order by id  ";
	$scrapSql=$scrapSql." and ".$sql4."  order by id  ";
   }
  
    if (DB::isError($result)) die ($result->getMessage());
	 
	$result = $db->query($sql);
 	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	{ 
	$invoiceQTY=$row['qty'];
	}
	
	$result = $db->query($inshopSql);
	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	{ 
	$inshopQTY=$row['qty'];
	}
	
	
	$result = $db->query($scrapSql);
	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	{ 
	$scrapQTY=$row['qty'];
	}
	
}
?>

<form name="form" action="/?page=statistic&subpage=count_out_by_goods_partno.php" method="POST">
<div><label>貨品編號：</label>
<input name="goods_partno" class="buttonstyle" id="goods_partno" size="20" maxlength="20" type="text" value="<?php echo $goods_partno;?>"></div>
<div><label>發票日期：</label>
<input name="invoice_date_start" id="invoice_date_start" class="buttonstyle" type="text"  size="15"  value="<?php echo $invoice_date_start;?>">
<input name="cal" id="calendar" value=".." type="button">
至
<input name="invoice_date_end" id="invoice_date_end" class="buttonstyle" type="text"  size="15"  value="<?php echo $invoice_date_end;?>" />
<input name="cal2" id="calendar2" value=".." type="button" />
</div>
<input name="button" value="查出貨量" type="submit">
</form>

<hr>
<a href="../">回主頁</a>
<hr>
 
<table>
<TR> 
	<Td>出貨量</Td><td>碎料出貨</td><Td>入鋪量</Td><Td>Balance</Td>
</TR><td><?php echo $invoiceQTY;?></td><td><?php echo $scrapQTY;?></td><td><?php echo $inshopQTY;?></td><td><?php echo $inshopQTY-$invoiceQTY;?></td>
   
   </table>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "invoice_date_start",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  Calendar.setup(
    {
      inputField  : "invoice_date_end",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
</script> 
<?if ($update!="1"){
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../include/invoice_style.css" type="text/css">
<title>查存貨excel</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCCCCC;
}

-->
</style>
<style type="text/css">
@import url(../include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="../include/cal/calendar.js"></script>
<script type="text/javascript" src="../include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="../include/cal/calendar-setup.js"></script>
</head>
<body>
<form id="form1" name="form1" method="post" action="costcsv.php">
  <input name="dateTo" type="text" id="dateTo" />
  <input name="cal2" id="cal2" value=".." type="button" />
  <input type="submit" value="搜尋"/>
  <input type="hidden" name="update" value="1"/>

</form>


<script type="text/javascript">


    Calendar.setup(
    {
      inputField  : "dateTo",         // ID of the input field
      ifFormat    : "%Y-%m-%d 00:00",    // the date format
      showsTime      :    true,
      button      : "cal2"       // ID of the button
      
    }
  );
</script>
</html>
<? }else{
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=test.xls");
  include_once("../include/config.php");

    $db = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
	 $result = $db->query("SET NAMES 'UTF8'");
   // (Run the query on the winestore through the connection
 
    
 $instocksql="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.market_price  as market_price 
 , b.instock_date as instock_date from sumgoods 
 left join 
 (select * from (select  goods_partno , market_price , instock_date from goods_instock,instock 
 where instock.instock_no=goods_instock.instock_no
  and instock.instock_date<'".$dateTo."'
  order by goods_partno, instock_date desc) as cc group by cc.goods_partno
) as b on sumgoods.goods_partno =b.goods_partno 
 order by sumgoods.goods_partno ";
 
  $invoicesql="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.qty  as qty 
 from sumgoods 
 left join 
 (select  goods_partno , sum(qty)  qty from goods_invoice,invoice 
 where invoice.invoice_no=goods_invoice.invoice_no
  and invoice.invoice_date<'".$dateTo."'
  group by goods_partno) as b 
 on sumgoods.goods_partno =b.goods_partno 
 order by sumgoods.goods_partno ";
 
 //$invoicesql="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.qty  as qty from sumgoods left join (select  goods_partno , sum(qty)  qty from goods_invoice group by goods_partno) as b on sumgoods.goods_partno =b.goods_partno order by sumgoods.goods_partno ";
 
  $returnsql="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.qty  as qty 
  from sumgoods left join 
  (select  goods_return.goods_partno , sum(goods_return.qty)  qty from goods_return, returngood where returngood.return_no=goods_return.return_no and returngood.return_date<'".$dateTo."' group by goods_partno) as b on sumgoods.goods_partno =b.goods_partno order by sumgoods.goods_partno ";

 // $returnsql="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.qty  as qty from sumgoods left join (select  goods_partno , sum(qty)  qty from goods_return group by goods_partno) as b on sumgoods.goods_partno =b.goods_partno order by sumgoods.goods_partno ";

  
    $instock2sql="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.qty  as qty 
	from sumgoods left join
	 (select  goods_instock.goods_partno , sum(goods_instock.qty)  qty from goods_instock,instock where instock.instock_no=goods_instock.instock_no and instock.instock_date<'".$dateTo."' group by goods_partno)
	  as b on sumgoods.goods_partno =b.goods_partno order by sumgoods.goods_partno ";
  // $instocksql="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.qty  as qty from sumgoods left join (select  goods_partno , sum(qty)  qty from goods_instock group by goods_partno) as b on sumgoods.goods_partno =b.goods_partno order by sumgoods.goods_partno ";
  
 //$invoicesql="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.qty  as qty from sumgoods left join (select  goods_partno , sum(qty)  qty from goods_invoice group by goods_partno) as b on sumgoods.goods_partno =b.goods_partno order by sumgoods.goods_partno ";
 
 
  // $instocksql="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.qty  as qty from sumgoods left join (select  goods_partno , sum(qty)  qty from goods_instock group by goods_partno) as b on sumgoods.goods_partno =b.goods_partno order by sumgoods.goods_partno ";
     $instockresult = $db->query($instocksql);
	 $i=0;
	 while ($row = $instockresult->fetchRow(DB_FETCHMODE_ASSOC))
	 {
	 	$goods_partno[$i][0]=$row["goods_partno"];
    	$goods_partno[$i][1]=$row["goods_detail"];
	 	$goods_partno[$i][2]=$row["market_price"];
		$goods_partno[$i][3]=$row["instock_date"];
		$i++;
	}
	
	 $invoiceresult = $db->query($invoicesql);
	 $returnresult = $db->query($returnsql);
	 $instock2result = $db->query($instock2sql);
	 $i=0;
	 while ($row = $invoiceresult->fetchRow(DB_FETCHMODE_ASSOC))
	 {	
		$goods_partno[$i][4]=$row["qty"];
		$i++;
	 }
	 $i=0;
	 while ($row = $returnresult->fetchRow(DB_FETCHMODE_ASSOC))
	 {
    	$goods_partno[$i][5]=$row["qty"];
		$i++;
	 }
	 $i=0;
	 while ($row = $instock2result->fetchRow(DB_FETCHMODE_ASSOC))
	 {
    	$goods_partno[$i][6]=$row["qty"];
		$i++;
	 }
	
	
	
	 ?> <table><tr><td>貨品編號</td><td>貨品詳情</td><td>最新入貨價</td><td>QTY</td><td>Net Balance</td><td>最新入貨日期</td></tr><?
	
	 
	 for ($i=0;$i<count($goods_partno);$i++){
	 $stock=$goods_partno[$i][5]+$goods_partno[$i][6]-$goods_partno[$i][4];
	 $netbalance=$stock*$goods_partno[$i][2];
	 echo "<tr><td>".$goods_partno[$i][0]."</td><td>".$goods_partno[$i][1]."</td><td>".$goods_partno[$i][2]."</td><td>".$stock."</td><td>".$netbalance."</td><td>".$goods_partno[$i][3]."</td></tr>";
	  }
	 	 ?></table><?
}
?>

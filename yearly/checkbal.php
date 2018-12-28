<?if ($update!="1"){
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../include/invoice_style.css" type="text/css">
<title>盤點</title>
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
 
 
</head>
<body>
<form id="form1" name="form1" method="post" action="checkbal.php">
 
  <input type="submit" value="搜尋"/>
  <input type="hidden" name="update" value="1"/>

</form>


 
</html>
<? }else{
	
if ($_REQUEST['format']==""){
  header("Content-type:application/vnd.ms-excel");
  header("Content-Disposition:filename=test.xls");
}
 
  require_once("../include/config.php");
require_once("../include/functions.php");
$db = DB::connect($dsn);
	if (DB::isError($db))
     die($db->getMessage());
	$query="SET NAMES 'UTF8'";
    if (DB::isError($db)) die($db->getMessage());
	
 
   // (Run the query on the winestore through the connection
 
    
/*	$sumgoodsSQL="select * from sumgoods where status='Y'";*/
$sumgoodsSQL="select sumgoods.goods_partno as goods_partno, sumgoods.goods_detail as goods_detail,b.market_price  as market_price ,sumgoods.model as model
 , b.instock_date as instock_date from sumgoods 
 left join  (select * from (select  goods_partno , market_price , instock_date from goods_instock,instock 
 where instock.instock_no=goods_instock.instock_no
  order by goods_partno, instock_date desc) as cc group by cc.goods_partno
) as b on sumgoods.goods_partno =b.goods_partno 
 order by sumgoods.goods_partno";

 
     $sumgoodsResult = $db->query($sumgoodsSQL);
	 $i=0;
	 while ($row = $sumgoodsResult->fetchRow(DB_FETCHMODE_ASSOC))
	 {
	 	$goods_partno[$i][0]=$row["goods_partno"];
    	$goods_partno[$i][1]=$row["goods_detail"];
	 	$goods_partno[$i][2]=$row["model"];
		$goods_partno[$i][3]=$row["market_price"];
		 
		$partnoResult=findBalFromPartNo(strtoupper($goods_partno[$i][0]),0,0,0,0,$dsn);
		$goods_partno[$i][4]=$partnoResult['stockbal'];
		$i++;
	}
	
	
	
	 ?> <table><tr><td>貨品編號</td><td>貨品詳情</td><td>分類</td><td>最新入貨價</td><td>剩餘量</td></tr><?
	
	 
	 for ($i=0;$i<count($goods_partno);$i++){
 
		 echo "<tr><td>".$goods_partno[$i][0]."</td><td>".$goods_partno[$i][1]."</td><td>".$goods_partno[$i][2]."</td><td>".$goods_partno[$i][3]."</td><td>".$goods_partno[$i][4]."</td></tr>";
	  }
	 	 ?></table><?
}
?>

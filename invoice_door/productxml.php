<?php
	header('Content-Type: text/xml');
	require_once('../include/config.php');
	require_once("../include/functions.php");
	$product_id = $_GET['product_id'];

 
	$goods_partno=strtoupper($goods_partno);
    $partnoResult=findBalFromPartNo($goods_partno,0,$year,$month,$day,$dsn);
	 
	
	$db = DB::connect($dsn);
	if (DB::isError($db))
     die($db->getMessage());
	$query="SET NAMES 'UTF8'";
    if (DB::isError($db)) die($db->getMessage());
	
	
	$query = "SELECT * FROM sumgoods where goods_partno = '$goods_partno' and status='Y'";
	$result =$db->query($query ) or die (mysql_error()."Couldn't execute query: $query");
	$num_results=$result->numRows();
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	
	
	 //gen XML result balance
	 
	/*echo '<?xml version="1.0" encoding="ISO-8859-1"?><product>';*/
    echo '<?xml version="1.0" encoding="utf8"?><product>'; 

	for ($i=0;$i<$num_results;$i++)
	{
       
		echo "<product_goods_partno>" . $row['goods_partno'] . "</product_goods_partno>";
		echo "<product_goods_detail>" . $row['goods_detail'] . "</product_goods_detail>";
		echo "<product_market_price>" . $row['market_price'] . "</product_market_price>";
		echo "<product_market_price_door>" . $row['market_price_door'] . "</product_market_price_door>";
		echo "<thereafter_price>" . $row['thereafter_price'] . "</thereafter_price>";
		echo "<sell_out_unit>" . $row['sell_out_unit'] . "</sell_out_unit>";
		echo "<sell_out_qty>" . $row['sell_out_qty'] . "</sell_out_qty>";
		echo "<product_stock_bal>" . $partnoResult['stockbal'] . "</product_stock_bal>";
		echo "<product_readonly>" . $row['readonly'] . "</product_readonly>";
		

	}
	
	 
	
	echo "</product>";
?>
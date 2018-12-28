<?php
	header('Content-Type: text/xml');
	require('../include/config.php');
	
	$product_id = $_GET['product_id'];

	 $db = DB::connect($dsn);
   if (DB::isError($db))
      die($db->getMessage());
	   $query="SET NAMES 'UTF8'";
    if (DB::isError($db)) die($db->getMessage());
	
	
	 
	$query = "SELECT * FROM sumgoods where goods_partno = '$goods_partno' and status='Y'";
	$result =$db->query($query ) or die (mysql_error()."Couldn't execute query: $query");
	
	/*echo '<?xml version="1.0" encoding="ISO-8859-1"?><product>';*/
    echo '<?xml version="1.0" encoding="utf8"?><product>';
	
	$num_results=$result->numRows();
	for ($i=0;$i<$num_results;$i++)
	{
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		echo "<product_goods_partno>" . $row['goods_partno'] . "</product_goods_partno>";
		echo "<product_goods_detail>" . $row['goods_detail'] . "</product_goods_detail>";
		echo "<product_market_price>" . $row['market_price'] . "</product_market_price>";
		echo "<product_readonly>" . $row['readonly'] . "</product_readonly>";
		

	}
	
	 
	
	echo "</product>";
?>
<?
  include_once("../include/config.php");
  $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
  if (DB::isError($result))
      die ($result->getMessage());
	  $sql="select * from sumgoods where goods_partno='".$_GET['mph']."' and status='Y'";
	  $result = $connection->query($sql);
	  while(  $row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	  {
	  $kph=$row['market_price'];
	  $mps=$row['goods_detail'];
	  }
	  
	 $invoiceSql="select ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where i.invoice_no=gi.invoice_no ";
     $inshopSql="select ifnull(sum(qty),0) as qty from inshop i , goods_inshop gi where i.inshop_no=gi.inshop_no ";
     $result = $connection->query($invoiceSql);
	 while(  $row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	 {
	  $invoiceQty=$row['qty'];
	 }
	 $result = $connection->query($inshopSql);
	 while(  $row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	 {
	  $inshopQty=$row['qty'];
	 }
	  
	  
	  
	  
$mph = 0;
$mph=$_GET['mph'];


echo '<item><name>market_price'.$_GET['num'].'</name><value>'.$kph.'</value></item><item><name>goods_detail'.$_GET['num'].'</name><value>'.$mps.'</value><item><name>stockbal</name><value>.'$inshopQty-$invoiceQty.'</value></item>';


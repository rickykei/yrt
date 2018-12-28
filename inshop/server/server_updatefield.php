<?
  include_once("../include/config.php");
  $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
  if (DB::isError($result))
      die ($result->getMessage());
	  $sql="select ins.market_price,sum.goods_detail from sumgoods sum left join goods_inshop ins on sum.goods_partno= ins.goods_partno where sum.goods_partno='".$_GET['mph']."' and sum.status='Y'  ORDER BY ins.id DESC LIMIT 0 , 1  ";
	  $result = $connection->query($sql);
	  while(  $row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	  {
	  $kph=$row['market_price'];
	  $mps=$row['goods_detail'];
	  }
	 
if ($kph == "" || $kph ==null)
$kph=0; 
echo '<item><name>market_price'.$_GET['num'].'</name><value>'.$kph.'</value></item><item><name>goods_detail'.$_GET['num'].'</name><value>'.$mps.'</value></item>';


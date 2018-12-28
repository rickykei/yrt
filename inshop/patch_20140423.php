<?php
  include_once("../include/config.php");
  $query="SET NAMES 'UTF8'";
   $db = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
$result = $db->query("SET NAMES 'UTF8'");
 
$sql="select * from instock where staff_name not like 'carrie'";
$q1_result = $db->query($sql);

$count_q1=0;
 
while($q1=$q1_result->fetchRow(DB_FETCHMODE_ASSOC)){
echo $q1['instock_no']."<p>";
$instock_no=$q1['instock_no'];
	//insert into inshop
	$db->query("insert into inshop select '',instock_date,entry_date,supplier_name,staff_name,supplier_invoice_no,remark,count_price,discount_percent,total_price from instock where instock_no='$instock_no'");
    
	$result=$db->query('SELECT LAST_INSERT_ID();');
    if (DB::isError($result)) die ($result->getMessage());
    $row=$result->fetchRow();
    $inshop_no=$row[0];
	
    $db->query("insert into goods_inshop select '','$inshop_no',goods_partno,goods_detail,qty,market_price,discount,unit,subtotal,deductstock from goods_instock where instock_no='$instock_no'");	
	

	
$count_q1++;
}
echo "CNT=".$count_q1;
?>
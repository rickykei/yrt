﻿<script language="javascript">
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=600');");
}
</script><?
$ok=0;
$totalcounter=0;
//count input
for ($i=0;$i<17;$i++)
{
	if ($goods_partno[$i]!="")
	$totalcounter++;
}

//get name
include("./include/config.php");
include("./include/functions.php");
   $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result))
      die ($result->getMessage());



  for ($i=0;$i<$totalcounter;$i++)
  {
  //echo $goods_id[$i]."@".$goods_name[$i]."@".$qty[$i]."@".$discount[$i];
  }

  //backup old invoice  20130717
  
   $query="select * from scrap where invoice_no='".$invoice_no."'";
   $oldInvoiceResult = $connection->query($query);
   $oldInvoiceRow = $oldInvoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
   $query="insert into scrap_amend (amend_invoice_id,amend_sales_name,amend_by,amend_date,creation_date,created_by,invoice_no,invoice_date,delivery_date,delivery_timeslot,sales_name,customer_name,customer_tel,customer_detail,member_id,branchID,delivery,man_power_price,discount_percent,discount_deduct,special_man_power_percent,total_price,settle,deposit,credit_card_rate,settledate,receiver) ";
   $query.=" values ('','$sales','$browseryrt',SYSDATE(),'".$oldInvoiceRow['creation_date']."','".$oldInvoiceRow['created_by']."',".$oldInvoiceRow['invoice_no'].",'".$oldInvoiceRow['invoice_date']."','".$oldInvoiceRow['delivery_date']."','".$oldInvoiceRow['delivery_timeslot']."','".$oldInvoiceRow['sales_name']."','".$oldInvoiceRow['customer_name']."','".$oldInvoiceRow['customer_tel']."','".$oldInvoiceRow['customer_detail']."',".$oldInvoiceRow['member_id'].",'".$oldInvoiceRow['branchID']."','".$oldInvoiceRow['delivery']."',".$oldInvoiceRow['man_power_price'].",".$oldInvoiceRow['discount_percent'].",".$oldInvoiceRow['discount_deduct'].",".$oldInvoiceRow['special_man_power_percent'].",".$oldInvoiceRow['total_price'].",'".$oldInvoiceRow['settle']."',".$oldInvoiceRow['deposit'].",".$oldInvoiceRow['credit_card_rate'].",'".$oldInvoiceRow['settledate']."','".$oldInvoiceRow['receiver']."')";
	$result=$connection->query($query);
	
	  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  $row=$result->fetchRow();
   
  $amend_invoice_id=$row[0];
  
  //backup old invoice  20130717
  //backup old invoice item  20130717
  $query="select * from goods_scrap where invoice_no='".$invoice_no."'";
   $oldGoodInvoiceResult = $connection->query($query);
   while($oldGoodInvoiceRow = $oldGoodInvoiceResult->fetchRow(DB_FETCHMODE_ASSOC))
   {
       $query="insert into goods_scrap_amend (id,amend_invoice_id,amend_id,amend_date,invoice_no,goods_partno,qty,discountrate,marketprice,status,subtotal,manpower,goods_detail,deductstock,cutting,delivered) ";
       $query.=" values(".$oldGoodInvoiceRow['id'].",".$amend_invoice_id.",'',sysdate(),".$oldGoodInvoiceRow['invoice_no'].",'".$oldGoodInvoiceRow['goods_partno']."',".$oldGoodInvoiceRow['qty'].",".$oldGoodInvoiceRow['discountrate'].",".$oldGoodInvoiceRow['marketprice'].",'".$oldGoodInvoiceRow['status']."',".$oldGoodInvoiceRow['subtotal'].",'".$oldGoodInvoiceRow['manpower']."','".$oldGoodInvoiceRow['goods_detail']."','".$oldGoodInvoiceRow['deductstock']."','".$oldGoodInvoiceRow['cutting']."','".$oldGoodInvoiceRow['delivered']."')";
	
       $result=$connection->query($query);
   
   }
  
  //backup old invoice item  20130717
  
  //insert invoice
  $query="update scrap set last_update_date=SYSDATE(),call_count=call_count+1,last_update_by='$browseryrt',invoice_date ='$invoice_date' , delivery_date = '$delivery_date' , sales_name= '$sales' ,customer_name = '$mem_name' ,customer_tel = '$mem_tel' ,customer_detail = '$mem_add' ,member_id ='$mem_id',settle='$status',branchID='$branchID', delivery = '$delivery' ,man_power_price= '$man_power_price' ,discount_percent = '$subdiscount', discount_deduct= '$subdeduct',  special_man_power_percent='$special_man_power_percent',total_price='$subsubtotal',deposit='$deposit',credit_card_rate='$creditcardrate' ,settledate = '$settledate' ,receiver = '$receiver' ,delivery_timeslot ='$delivery_timeslot' where invoice_no='".$invoice_no."'";
  
 // $query.=" values ('',now(),'$delivery_date','$sales','$mem_name','$mem_tel','$mem_add','$mem_id','A','$AREA','$delivery','$man_power_price','$discount_percent','$discount_deduct')";
//  echo $query;

//20100112
	sqllog($query);
//20100112

  $result=$connection->query($query);
  if (DB::isError($result))
      die ($result->getMessage());
     // echo $query;
      
	  
	  
	//delete all goods_invoice in old invoice first
	$sql="delete from goods_scrap where invoice_no='".$invoice_no."'";
//20100112
	sqllog($sql);
//20100112
  $result = $connection->query($sql);
   if (DB::isError($result))
   die ($result->getMessage());
   
   
  for ($i=0;$i<$totalcounter;$i++)
  {
   $query="insert into goods_scrap (invoice_no,goods_partno,qty,discountrate,marketprice,status,subtotal,manpower,goods_detail,deductstock,cutting,delivered) ";
   $query.=" values    ('$invoice_no','$goods_partno[$i]','$qty[$i]','$discount[$i]','$market_price[$i]','A','$subtotal[$i]','$manpower[$i]','$goods_detail[$i]','$deductStock[$i]','$cutting[$i]','$delivered[$i]')";
   //20100112
	sqllog($query);
//20100112
  $result=$connection->query($query);
  	if (DB::isError($result))
  	{
      die ($result->getMessage());
      
      $status=0;
      }
      else
      {
      	$status=1;
      }
      
   
  }
  
  if ($status==1)
  //echo "invoice insert Success=".$invoice_no;
  {
  	include_once("./pdf2/pdf.php");
?>
<SCRIPT LANGUAGE="JavaScript">
popUp("/scrap/pdf/<?=$invoice_no?>.pdf");
window.location="/?page=scrap&subpage=scraplist.php";
</script><?
}
  
?>
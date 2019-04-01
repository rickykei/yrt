<script language="javascript">
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
	if ($width[$i]!="")
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
  
   $query="select * from invoice_scrap where invoice_no='".$invoice_no."'";
   $oldInvoiceResult = $connection->query($query);
   $oldInvoiceRow = $oldInvoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
   
  
  
  //insert invoice
  $query="update invoice_scrap set last_update_date=SYSDATE(),call_count=call_count+1,last_update_by='$browseryrt',invoice_date ='$invoice_date' , delivery_date = '$delivery_date' , sales_name= '$sales' ,customer_name = '$mem_name' ,customer_tel = '$mem_tel' ,customer_detail = '$mem_add' ,member_id ='$mem_id',settle='$status',branchID='$branchID', delivery = '$delivery' ,man_power_price= '$man_power_price' ,discount_percent = '$subdiscount', discount_deduct= '$subdeduct',  special_man_power_percent='$special_man_power_percent',total_price='$subsubtotal',deposit='$deposit',credit_card_rate='$creditcardrate' ,settledate = '$settledate' ,receiver = '$receiver' ,delivery_timeslot ='$delivery_timeslot' ,cal_unit='$cal_unit' where invoice_no='".$invoice_no."'";
 

  $result=$connection->query($query);
  if (DB::isError($result))
      die ($result->getMessage());
     // echo $query;
      
	  
	  
	//delete all goods_invoice in old invoice first
	$sql="delete from goods_invoice_scrap where invoice_no='".$invoice_no."'";
 
  $result = $connection->query($sql);
   if (DB::isError($result))
   die ($result->getMessage());
   
   
  for ($i=0;$i<$totalcounter;$i++)
  {
    $query="insert into goods_invoice_scrap (invoice_no,  goods_partno, width,height, qty,unit_price,status,subtotal ) ";
   $query.=" values ('$invoice_no', '$partno[$i]', '$width[$i]','$height[$i]',   $qty[$i],$unit_price[$i],'A',$subtotal[$i] ) ";
   
   //echo $query;
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
  	  if($_REQUEST['print']=='3col'){
		include_once("./pdf3/pdf_invoice_scrap_v2.php");
	  }else{
  	 include_once("./pdf2/pdf_invoice_scrap.php");
	  }
?>
<SCRIPT LANGUAGE="JavaScript">
popUp("/invoice_scrap/pdf/<?=$invoice_no?>.pdf");
window.location="/?page=invoice_scrap&subpage=list.php";
</script><?
}
  
?>
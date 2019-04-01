 
<script type="text/javascript" src="./include/functions.js"></script>
 
 
<?
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
    $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result))
      die ($result->getMessage());

 

  //insert invoice Door
  $query="insert into invoice_scrap (cal_unit,creation_date,created_by,invoice_no,invoice_date,delivery_date,delivery_timeslot,sales_name,customer_name,customer_tel,customer_detail,member_id,branchID,delivery,man_power_price,discount_percent,discount_deduct,special_man_power_percent,total_price,settle,deposit,credit_card_rate,settledate,receiver) ";
  $query.=" values ('$cal_unit',SYSDATE(),'$browseryrt','',now(),'$delivery_date',$delivery_timeslot,'$sales','$mem_name','$mem_tel','$mem_add','$mem_id','$AREA','$delivery','$man_power_price','$subdiscount','$subdeduct','$special_man_power_percent','$subsubtotal','$status','$deposit','$creditcardrate','$settledate','$receiver')";
 
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  
  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  
  if (DB::isError($result)) die ($result->getMessage());
 
  $row=$result->fetchRow();
  //echo "invoice no=".$row[0];
  $invoice_no=$row[0];

 
  for ($i=0;$i<$totalcounter;$i++)
  {

   $query="insert into goods_invoice_scrap (invoice_no, goods_partno,width,height,qty,unit_price,status,subtotal) ";
   $query.=" values ('$invoice_no','$partno[$i]','$width[$i]','$height[$i]',$qty[$i],$unit_price[$i],'A',$subtotal[$i]) ";
 
  
  $result=$connection->query($query);
  	if (DB::isError($result))
  	{
      die ($result->getMessage());
      
      $ok=0;
      }
      else
      {
      	$ok=1;
      }
      
   
  }
  
  if ($ok==1)
  //echo "invoice insert Success=".$invoice_no;
  {
	   if($_REQUEST['print']=='3col'){
		include_once("./pdf3/pdf_invoice_scrap_v2.php");
	  }else{
  	 include_once("./pdf2/pdf_invoice_scrap.php");
	  }
  	
 //echo "<a href=../pdf2/pdf.php?invoice_no=".$invoice_no.">列印</a>";
?><SCRIPT LANGUAGE="JavaScript">
popUp("/invoice_scrap/pdf/<?=$invoice_no?>.pdf");
window.location="/?page=invoice_scrap&subpage=index.php"; 
</script><?
 //echo "<a href=./pdf/".$invoice_no.".pdf target=\"print\">列印</a>";
}
  /*
	for ($i=0;$i<$totalcounter;$i++)
	{
		$query="select * from sumgoods where goods_id='".$goods_id[$i]."'";
		$result=$connection->query($query);
		if (DB::isError($result)) 
		      die ($result->getMessage());
    $row = $result->fetchRow();
    $goods_name[$i]=$row[3];
    $market_price[$i]=$row[4];
	}*/		      
?>

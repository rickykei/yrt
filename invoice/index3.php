<script language="javascript">

 $(function() {
	 ls=Storages.localStorage;
	ls.remove('myItems');
 });
 
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600');");
}
</script>
 <?
$ok=0;
$totalcounter=0;
//count input
for ($i=0;$i<16;$i++)
{
	if ($goods_partno[$i]!="")
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



  for ($i=0;$i<$totalcounter;$i++)
  {
  //echo $goods_id[$i]."@".$goods_name[$i]."@".$qty[$i]."@".$discount[$i];
  }

  //insert invoice
  $query="insert into invoice (lastname,creation_date,created_by,invoice_no,invoice_date,delivery_date,delivery_timeslot,sales_name,customer_name,customer_tel,customer_detail,member_id,branchID,delivery,man_power_price,discount_percent,discount_deduct,special_man_power_percent,total_price,settle,deposit,deposit_method,credit_card_rate,settledate,receiver) ";
  $query.=" values ('$lastname',SYSDATE(),'$browseryrt','',now(),'$delivery_date',$delivery_timeslot,'$sales','$mem_name','$mem_tel','$mem_add','$mem_id','$AREA','$delivery','$man_power_price','$subdiscount','$subdeduct','$special_man_power_percent','$subsubtotal','$status','$deposit','$deposit_method','$creditcardrate','$settledate','$receiver')";

  
 
 
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

   $query="insert into goods_invoice (invoice_no,goods_partno,qty,discountrate,marketprice,status,subtotal,manpower,goods_detail,deductstock,cutting,delivered) ";
   $query.=" values ('$invoice_no','$goods_partno[$i]',$qty[$i],$discount[$i],$market_price[$i],'A',$subtotal[$i],'$manpower[$i]','$goods_detail[$i]','$deductStock[$i]','$cutting[$i]','$delivered[$i]') ";
 
 
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
  echo "CMP3";
  if ($ok==1)
  //echo "invoice insert Success=".$invoice_no;
  {
	  if($_REQUEST['print']=='3col'){
		  include_once("./pdf3/pdf_v2.php");
	  }else{
  	include_once("./pdf2/pdf.php");
	  }
 //echo "<a href=../pdf2/pdf.php?invoice_no=".$invoice_no.">列印</a>";
?><SCRIPT LANGUAGE="JavaScript">
popUp("/invoice/pdf/<?=$invoice_no?>.pdf");
 window.location="/?page=invoice&subpage=index.php"; 
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

﻿<script language="javascript">
 $(function() {
	 ls=Storages.localStorage;
	ls.remove('myItems');
	 
	ls=Storages.localStorage;
	ls.remove('invoiceno');
	 
 });
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=600');");
}
</script><?
$ok=0;
$totalcounter=0;
//count input
for ($i=0;$i<16;$i++)
{
	if ($goods_partno[$i]!="")
	$totalcounter++;
}

//get name
include_once("./include/config.php");
include_once("./include/functions.php");
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
  
   $query="select * from invoice where invoice_no='".$invoice_no."'";
   $oldInvoiceResult = $connection->query($query);
   $oldInvoiceRow = $oldInvoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
   
      //20181110 remove <low price backup , request by alvin  backup all modified invoice now
 //if ($oldInvoiceRow['total_price']>$subsubtotal){
  //backup old invoice item  20130717
  // insert amend log if the subtotal amount is changed 20170115
  
  $query="insert into invoice_amend (lastname,amend_invoice_id,amend_sales_name,amend_by,amend_date,creation_date,created_by,invoice_no,invoice_date,delivery_date,delivery_timeslot,sales_name,customer_name,customer_tel,customer_detail,member_id,branchID,delivery,man_power_price,discount_percent,discount_deduct,special_man_power_percent,total_price,settle,deposit,deposit_method,credit_card_rate,settledate,receiver) ";
  $query.=" values ('$lastname','','$sales','$browseryrt',SYSDATE(),'".$oldInvoiceRow['creation_date']."','".$oldInvoiceRow['created_by']."',".$oldInvoiceRow['invoice_no'].",'".$oldInvoiceRow['invoice_date']."','".$oldInvoiceRow['delivery_date']."','".$oldInvoiceRow['delivery_timeslot']."','".$oldInvoiceRow['sales_name']."','".$oldInvoiceRow['customer_name']."','".$oldInvoiceRow['customer_tel']."','".$oldInvoiceRow['customer_detail']."',".$oldInvoiceRow['member_id'].",'".$oldInvoiceRow['branchID']."','".$oldInvoiceRow['delivery']."',".$oldInvoiceRow['man_power_price'].",".$oldInvoiceRow['discount_percent'].",".$oldInvoiceRow['discount_deduct'].",".$oldInvoiceRow['special_man_power_percent'].",".$oldInvoiceRow['total_price'].",'".$oldInvoiceRow['settle']."',".$oldInvoiceRow['deposit'].",'".$oldInvoiceRow['deposit_method']."',".$oldInvoiceRow['credit_card_rate'].",'".$oldInvoiceRow['settledate']."','".$oldInvoiceRow['receiver']."')";
  $result=$connection->query($query);
	  
	 
  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  $row=$result->fetchRow();
  $amend_invoice_id=$row[0];
  
 
 

  $query="select * from goods_invoice where invoice_no='".$invoice_no."'";
   $oldGoodInvoiceResult = $connection->query($query);
   while($oldGoodInvoiceRow = $oldGoodInvoiceResult->fetchRow(DB_FETCHMODE_ASSOC))
   {
       $query="insert into goods_invoice_amend (id,amend_invoice_id,amend_id,amend_date,invoice_no,goods_partno,qty,discountrate,marketprice,status,subtotal,manpower,goods_detail,deductstock,cutting,delivered) ";
       $query.=" values(".$oldGoodInvoiceRow['id'].",".$amend_invoice_id.",'',sysdate(),".$oldGoodInvoiceRow['invoice_no'].",'".$oldGoodInvoiceRow['goods_partno']."',".$oldGoodInvoiceRow['qty'].",".$oldGoodInvoiceRow['discountrate'].",".$oldGoodInvoiceRow['marketprice'].",'".$oldGoodInvoiceRow['status']."',".$oldGoodInvoiceRow['subtotal'].",'".$oldGoodInvoiceRow['manpower']."','".$oldGoodInvoiceRow['goods_detail']."','".$oldGoodInvoiceRow['deductstock']."','".$oldGoodInvoiceRow['cutting']."','".$oldGoodInvoiceRow['delivered']."')";
	
       $result=$connection->query($query);
	    if (DB::isError($result)) die ($result->getMessage());
   
   }
 //}
  //backup old invoice item  20130717
  
  if($void=="")
	  $void='A';
  //insert invoice
  $query="update invoice set void='$void',lastname='$lastname',last_update_date=SYSDATE(),call_count=call_count+1,last_update_by='$browseryrt',invoice_date ='$invoice_date' , delivery_date = '$delivery_date' , sales_name= '$sales' ,customer_name = '$mem_name' ,customer_tel = '$mem_tel' ,customer_detail = '$mem_add' ,member_id ='$mem_id',settle='$status',branchID='$branchID', delivery = '$delivery' ,man_power_price= '$man_power_price' ,discount_percent = '$subdiscount', discount_deduct= '$subdeduct',  special_man_power_percent='$special_man_power_percent',total_price='$subsubtotal',deposit='$deposit',deposit_method='$deposit_method',credit_card_rate='$creditcardrate' ,settledate = '$settledate' ,receiver = '$receiver' ,delivery_timeslot ='$delivery_timeslot' where invoice_no='".$invoice_no."'";
  
 // $query.=" values ('',now(),'$delivery_date','$sales','$mem_name','$mem_tel','$mem_add','$mem_id','A','$AREA','$delivery','$man_power_price','$discount_percent','$discount_deduct')";
 
//20100112
	sqllog($query);
//20100112

  $result=$connection->query($query);
  if (DB::isError($result))
      die ($result->getMessage());
     // echo $query;
      
	  
	  
	//delete all goods_invoice in old invoice first
	$sql="delete from goods_invoice where invoice_no='".$invoice_no."'";
//20100112
	sqllog($sql);
//20100112
  $result = $connection->query($sql);
   if (DB::isError($result))
   die ($result->getMessage());
   
   
  for ($i=0;$i<$totalcounter;$i++)
  {
   $query="insert into goods_invoice (invoice_no,goods_partno,qty,discountrate,marketprice,status,subtotal,manpower,goods_detail,deductstock,cutting,delivered) ";
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
  
 
  //20170110
  // add high risk invoice audit log  if $oldInvoiceRow['total_price']>$subsubtotal
  if ( ($oldInvoiceRow['total_price']>$subsubtotal && substr($oldInvoiceRow['last_update_date'],0,10)==date("Y-m-d")) or ($oldInvoiceRow['total_price']>$subsubtotal && substr($oldInvoiceRow['creation_date'],0,10)==date("Y-m-d"))){
	  echo "highrisk";
	   $query=" insert into invoice_high_risk (id,invoice_no,from_total,to_total,staffName,amend_by,creation_date,branchID) values ('','$invoice_no','".$oldInvoiceRow['total_price']."','$subsubtotal','$sales','$browseryrt','".$oldInvoiceRow['creation_date']."','".$oldInvoiceRow['branchID']."') ";
	 
	  $result=$connection->query($query);
  	if (DB::isError($result))
  	{
      die ($result->getMessage());
	}
	  
  }
  
  if ($status==1)
  //echo "invoice insert Success=".$invoice_no;
  {
   if($_REQUEST['print']=='3col'){
	   echo "3col";
		  include_once("./pdf3/pdf_v2.php");
		}else if($_REQUEST['print']=='boss'){
		  include_once("./pdf3/pdf_vboss.php");
	  }else{
			include_once("./pdf3/pdf.php");
	  }

	
	if($returnpage==""){
	?>
	<SCRIPT LANGUAGE="JavaScript">
	popUp("/invoice/pdf/<?=$invoice_no?>.pdf");
	 window.location="/?page=invoice&subpage=invoicelist.php";
	</script>
	<?
	}else{
	?>
	<SCRIPT LANGUAGE="JavaScript">
	popUp("/invoice/pdf/<?=$invoice_no?>.pdf");
	 window.location="/?page=invoice&subpage=<?php echo $returnpage;?>.php";
	</script>
	<?
	}	
		


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
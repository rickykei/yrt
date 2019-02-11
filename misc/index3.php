<script type="text/javascript" src="./include/functions.js"></script>
<?php
$ok=0;
$totalcounter=0;
//count input

 

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
  $query="insert into misc (id,daily_revenue,daily_expend,daily_cheque,daily_creditcard,daily_unionpay,daily_eps,daily_fps,daily_cash,daily_income,daily_drawer,past_daily_drawer,drawer_diff,area,invoice_date,created_by,created_date,pc,modified_by,modified_date,sts) ";
  $query.=" values ('','$daily_revenue','$daily_expend','$daily_cheque','$daily_creditcard','$daily_unionpay','$daily_eps','$daily_fps','$daily_cash','$daily_income','$daily_drawer','$past_daily_drawer','$drawer_diff','$AREA','$invoice_date','$browseryrt',SYSDATE(),'$pc','$browseryrt',now(),'A')";

 
 
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  
  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  
  if (DB::isError($result)) die ($result->getMessage());
 
  $row=$result->fetchRow();
  //echo "invoice no=".$row[0];
  $invoice_no=$row[0];


  for($i=0;$i<15;$i++) {

	if ($misc[$i]!=""){
	   $query="insert into misc_misc (id,misc_id,misc, misc_amt,sts,created_by,created_date,modified_by,modified_date) ";
	   $query.=" values ('','$invoice_no','$misc[$i]','$misc_amt[$i]','A','$browseryrt',now(),'$browseryrt',now()) ";
 
		 $result=$connection->query($query);
		if (DB::isError($result)){
		  die ($result->getMessage());
		  
		  $ok=0;
		  }
		  else
		  {
			$ok=1;
		  }
      
	}
  }
  
  
  for ($i=0;$i<17;$i++) {

	if ($cheque[$i]!=""){
   $query="insert into misc_chq (id,misc_id,cheque,cheque_amt,sts,created_by,created_date,modified_by,modified_date) ";
   $query.=" values ('','$invoice_no','$cheque[$i]','$cheque_amt[$i]','A','$browseryrt',now(),'$browseryrt',now()) ";
 
  
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
  }
  

  for ($i=0;$i<4;$i++)
  {

	if ($cash[$i]!=""){
   $query="insert into misc_cash (id,misc_id,cash,cash_amt,sts,created_by,created_date,modified_by,modified_date) ";
   $query.=" values ('','$invoice_no','$cash[$i]','$cash_amt[$i]','A','$browseryrt',now(),'$browseryrt',now()) ";
 
 
  
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
  }
  if ($ok==1)
   { echo "invoice insert Success=".$invoice_no;
  	include_once("./pdf2/pdf_misc.php");
// echo "<a href=../pdf2/pdf.php?invoice_no=".$invoice_no.">列印</a>";
?><SCRIPT LANGUAGE="JavaScript">
 popUp("./misc/pdf/<?=$invoice_no?>.pdf");
 window.location="/?page=misc&subpage=index.php"; 
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

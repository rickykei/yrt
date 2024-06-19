 
<script type="text/javascript" src="./include/functions.js"></script>
 
<?
$ok=0;
 
//count input

$invoice_no=$_POST['invoice_no'];

 

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
  $query="update misc set daily_revenue='$daily_revenue', daily_expend='$daily_expend',daily_cheque='$daily_cheque',daily_creditcard='$daily_creditcard',daily_unionpay='$daily_unionpay',daily_ae_card='$daily_ae_card',daily_octopus='$daily_octopus',daily_eps='$daily_eps',daily_fps='$daily_fps',daily_cash='$daily_cash',daily_income='$daily_income',daily_drawer='$daily_drawer',past_daily_drawer='$past_daily_drawer',drawer_diff='$drawer_diff',area='$area',invoice_date='$invoice_date',pc='$pc',modified_by='$browseryrt',modified_date=SYSDATE(),sts='A' where id='$invoice_no'";
  
 
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  
  //clean up misc misc

	$sql="delete from misc_misc where misc_id='".$invoice_no."'";

  $result = $connection->query($sql);
   if (DB::isError($result))
   die ($result->getMessage());


 //insert miscmisc
 
  for($i=0;$i<15;$i++)
  {
	if ($misc[$i]!=""){
   $query="insert into misc_misc (id,misc_id,misc, misc_amt,sts,created_by,created_date,modified_by,modified_date) ";
   $query.=" values ('','$invoice_no','$misc[$i]','$misc_amt[$i]','A','$browseryrt',now(),'$browseryrt',now()) ";
   
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
  
    //clean up misc misc

	$sql="delete from misc_chq where misc_id='".$invoice_no."'";

  $result = $connection->query($sql);
   if (DB::isError($result))
   die ($result->getMessage());

//insert misc_chq
    for ($i=0;$i<17;$i++)
  {

	if($cheque[$i]!=""){
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
  
    //clean up misc misc

	$sql="delete from misc_cash where misc_id='".$invoice_no."'";

  $result = $connection->query($sql);
   if (DB::isError($result))
   die ($result->getMessage());

  
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
  echo "invoice insert Success=".$invoice_no;
  {
 	include_once("./pdf2/pdf_misc.php");
 ?><SCRIPT LANGUAGE="JavaScript">
 popUp("/misc/pdf/<?=$invoice_no?>.pdf");
 window.location="/?page=misc&subpage=misc_list.php"; 
</script><?
 
}
     
?> 

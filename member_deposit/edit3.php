<script language="javascript">
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=600');");
}
</script><?
$ok=0;
 
//count input
  
//get name
	include("../include/config.php");
	include("../include/functions.php");
    $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result))
      die ($result->getMessage());
 
  //insert invoice
  $query="update member_deposit set last_update_date=SYSDATE(),call_count=call_count+1,last_update_by=upper('$browseryrt'),deposit_date ='$deposit_date' , entry_date = '$entry_date' , sales_name= '$sales' ,mem_name = '$mem_name'    ,mem_id ='$mem_id',branchID='$AREA', deposit_amt = '$deposit_amt' , deposit_bank_amt = '$deposit_bank_amt'   where mem_dep_id='".$mem_dep_id."'";
 
 echo $query;
  
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
      
    
  if ($status==1)
  //echo "invoice insert Success=".$invoice_no;
  {
		$invoice_no=$mem_dep_id;
		
		echo $invoice_no;
  	 	 include_once("../pdf2/member_deposit_pdf.php");
?>

<SCRIPT LANGUAGE="JavaScript">
popUp("./pdf/<?php echo $invoice_no?>.pdf");
window.location="list.php"; 
</script><?
}
      
?>
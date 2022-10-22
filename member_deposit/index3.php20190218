<script language="javascript">
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
 

//get name
include("./include/config.php");
 require_once("./include/functions.php");
   $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result))
      die ($result->getMessage());
 
  //insert member_deposit
  $query="insert into member_deposit (creation_date,created_by,mem_dep_id,entry_date,deposit_date,deposit_amt,deposit_bank_amt,sales_name,mem_name,mem_id,branchID,sts) ";
  $query.=" values (SYSDATE(),upper('$browseryrt'),'',now(),'$deposit_date','$deposit_amt','$deposit_bank_amt','$sales','$mem_name','$mem_id','$AREA','A')";

 
 //echo $query;
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  
  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
 
  $row=$result->fetchRow();
  //echo "invoice no=".$row[0];
  $invoice_no=$row[0];
  if ($invoice_no <> "")
	  $ok=1;
   
  echo $invoice_no;
  if ($ok==1) {
 include_once("./pdf2/member_deposit_pdf.php");
?>
<SCRIPT LANGUAGE="JavaScript">
popUp("./member_deposit/pdf/<?=$invoice_no?>.pdf");
window.location="/?page=member_deposit&subpage=index.php"; 
</script><?php }  
?> 

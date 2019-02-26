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
 
  //20190218
  //check member name db first before insert.
 
  $query="select count(*) as cnt from member where member_id='".$mem_id."' ";
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
	$row=$result->fetchRow();
 
  echo "member_count(".$row[0].")";
		 if($row[0]==0){
			  //if non member, help to insert member20190218 
			 
			$query="insert into member (member_id,member_name) ";
			$query.=" values ('$mem_id','$mem_name')";  
				$result=$connection->query($query);
				echo "insert member table done ";
		 }
 
 
 //find previous member_deopsit date
  $query="select creation_date from member_deposit where mem_id='".$mem_id."' order by mem_dep_id desc limit 1";
  $result=$connection->query($query);
  $row=$result->fetchRow();
  $last_create_date=$row[0];
  
  //echo "<p>".$last_create_date."</p>";
  
  
  //find invoice record which behind last deposit create date
  // show invoice date  -Invoice NO - deduct amt
  //select invoice_date, invoice_no, total_price from invoice where member_id='98014380' and deposit_method in ('B','C') and invoice_date >'2019-02-01 01:09:45' 
  $query="select invoice_date, invoice_no, total_price,deposit_method from invoice where member_id='".$mem_id."' and deposit_method in ('B','C') and invoice_date >'$last_create_date' ";
   $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  $i=0;
   while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	   $oldrecord[$i]['invoice_date']=$row['invoice_date'];
	   $oldrecord[$i]['invoice_no']=$row['invoice_no'];
	   $oldrecord[$i]['total_price']=$row['total_price'];
	   $oldrecord[$i]['deposit_method']=$row['deposit_method'];
	   $i++;
   }
	   
	 //print_r($oldrecord);
  
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
   
  //echo $invoice_no;
  if ($ok==1) {
include_once("./pdf2/member_deposit_pdf.php");
?>
<SCRIPT LANGUAGE="JavaScript">
popUp("./member_deposit/pdf/<?=$invoice_no?>.pdf");
window.location="/?page=member_deposit&subpage=index.php"; 
</script><?php }  
?> 

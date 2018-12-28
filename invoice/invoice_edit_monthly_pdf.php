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
   $query="SET NAMES 'UTF8'";
   $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   echo "a";
  	include_once("./pdf2/invoice_edit_monthly_pdf.php");
 echo "d";
?><SCRIPT LANGUAGE="JavaScript">
popUp("/invoice/pdf_edit/<?=$date?>.pdf");
window.location="/?page=misc&subpage=misc_list.php"; 
</script><?
 
 
       
?> 

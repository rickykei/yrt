<?

$address = $_POST['address']; // get the username
//$address = trim(htmlentities($address)); // strip some crap out of it

echo check_username($address); // call the check_username function and echo the results.

function check_username($address){
	
	require_once("../include/config.php"); 
	 $connection = DB::connect($dsn);
   if (DB::isError($connection)) die($connection->getMessage());
   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());

   $query="select count(*) as address from address where address like '%$address%'";
  
   $result=mysql_query($query);
   $row= mysql_fetch_array ($result);
   if ($row["address"] >0 ){
			return '<span style="color:#f00">己有此地址</span>';
   }else{
	
	return '<span style="color:#0c0">OK</span>';
   }
}
?>

<? 
   $flag=0;
   require_once("./include/config.php");
   
   $connection = DB::connect($dsn);
   if (DB::isError($connection)) die($connection->getMessage());
   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());

   $query="select * from address where address='$address'";
   $result=mysql_query($query);
   $row= mysql_fetch_array ($result);
   if ($row["address"]!=null)
   $flag=1;
   
   
   
   if ($flag==1)
   {
	   
    $errMsg="[此項 地址 已於早前被輸入資料庫]";
   }
   else
   {

  
       
    $query="insert into address (id,address,alert) values ('','$address','$alert')";
  
      
      if (mysql_query($query))
	  	$alertMsg= "己經存入";
	  else
       	$errMsg= "不能成功存入資料庫";
      

  }
?>
<script language="javascript">
<? if ($alertMsg!=""){ 	?>
alert('<?=$alertMsg?>');
window.location.href = "/?page=address&subpage=index.php"
<? }else{ ?>
alert('<?=$errMsg?>');
history.back();
<? } ?>
</script>
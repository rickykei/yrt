<html>
<body>
<?
include("./include/config.php");
$connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    
echo $goods_partno;
$query="delete from sumgoods where goods_partno=\"$goods_partno\"";

if(!$result = $connection->query($query))
die(mysql_error());
else
echo "入貨名已被刪除";



?>




<SCRIPT LANGUAGE="JavaScript">
window.location="/?page=ingood&subpage=ingoodnameedit.php";
</script>
</body>
</html>

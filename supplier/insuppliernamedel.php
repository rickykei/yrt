<?
include("./include/config.php");
  $connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
           $result = $connection->query("SET NAMES 'UTF8'");
 
$sql="delete from supplier where supplier_id=\"$supplier_id\"";
if (!$connection->query($sql))
die(mysql_error());
else
echo "�J�f�W�w�Q�R��";
 
?>
 
<SCRIPT LANGUAGE="JavaScript">
window.location="/?page=supplier&subpage=insuppliernameedit.php";
</script>
 
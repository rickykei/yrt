<?
include("./include/config.php");
echo $member_id;
$query="delete from member where member_id=\"$member_id\"";
if (!mysql_query($query))
die(mysql_error());
else
echo "客戶名已被刪除";

?>
<SCRIPT LANGUAGE="JavaScript">
window.location="/?page=member&subpage=inmembernameedit.php";
</script>
 
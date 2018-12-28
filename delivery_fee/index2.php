<?
 
//連線mysql
	include("./include/config.php");
	$query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

	if (DB::isError($connection))
		die($connection->getMessage());

//解決mysql中文連線
	$result = $connection->query("SET NAMES 'UTF8'");
		if (DB::isError($result))
      		die ($result->getMessage());

//update

 if($_POST["update"]==3){
	 $query=" update  delivery_fee set staff_name=\"".$_POST['staff_name']."\" , fee=".$_POST['fee']." , fee_2=".$_POST['fee_2']." ,shop=\"".$AREA."\"where id=".$_POST['id'];
	 
	  $result=$connection->query($query);
		  if (DB::isError($result))
			  {
				  ?><SCRIPT LANGUAGE="JavaScript">
				  alert('相同日期不能重入2');
		  window.location="index.php"; 
		</script>
			  <?php }
	 
 }else{
		
//add

  $query="insert into delivery_fee (id,delivery_date,fee,staff_name,creation_date,fee_2,shop) ";
  $query.=" values ('','$delivery_date',$fee,'$staff_name',now(),$fee_2,'$AREA')";

  $result=$connection->query($query);
  if (DB::isError($result))
	  {
		  ?><SCRIPT LANGUAGE="JavaScript">
		  alert('相同日期不能重入');
  window.location="index.php"; 
</script>
	  <?php }
 }
//查詢入貨單編號
  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  $row=$result->fetchRow();
  $return_no=$row[0];

 
?> 
<link href="./include/instock.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
 
<table width="880"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ACC7FF">

  <tr>
    <td>&nbsp;</td>
    <td width="870" align="center" valign="top">
	<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <?php if ( $return_no!=""){
		  ?><SCRIPT LANGUAGE="JavaScript">
		  alert('成功');
  window.location="/?page=delivery_fee&subpage=list.php"; 
</script>
	  <?php }?>
    </table>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
 
 
</form> 
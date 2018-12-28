<?php
//get name

require_once("./include/config.php");
require_once("./include/functions.php");

 
   $query="SET NAMES 'UTF8'";
    $db = DB::connect($dsn);

   if (DB::isError($db)) die($db->getMessage());

   // (Run the query on the winestore through the connection
   $result = $db->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
 
	 
?>

<script language="javascript">
function first_text_box_focus()
{
	document.form1.elements[0].focus();
}

function next_text_box(a)
{
	if (event.keyCode==13)
	{
	//alert(a);
	eval("document.form1.elements["+a+"].focus();");
	//alert(event.keyCode);
	return false;
	}

}

 
</script>
<script type="text/javascript" src="./include/invoice.js"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
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
<form name="form1" action="/?page=member_deposit&subpage=index3.php" method="POST">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  
  <tr>
    <td width="4" height="">&nbsp;</td>
    <td width="801" align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="19%" height="21" bgcolor="#004d80"><span class="style6">會員存款</span></td>
        <td width="29%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="23" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80">
            <td > <span class="style6"> 發票日期： <?echo $entry_date;?></span> </td>
            <td ><span class="style6"></span></td>
               <td ><span class="style6">入賬日期：<?=$deposit_date?></span></td>
            <td><span class="style6"></span></td>
          </tr>
          <tr bgcolor="#004d80">
             <td height="23"><span class="style6">客戶名稱：<?echo $mem_name;?></span></td>
            <td height="23"><span class="style6"></span></td>
			<td><span class="style6">員工姓名：<?echo $sales;?></span></td>
            <td><span class="style6"></span></td>
           
          </tr>
         
          <tr bgcolor="#004d80">
            <td height="23" class="style6">存入金額：<?echo $deposit_amt;?></td>
            <td height="23" class="style6">餘額 :<?php echo $mem_dep_bal;?></td>
            <td height="23" class="style6">客戶編號：<?echo $mem_id;?></td>
            <td height="23" class="style6"></td>
          </tr>
        
        </table></td>
      </tr>
     
     
      <tr>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td>
        
        <input type="hidden" name="entry_date" value="<? echo $entry_date;?>">
        <input type="hidden" name="deposit_date" value="<? echo $deposit_date;?>">
 
 
		<input type="hidden" name="sales" value="<? echo $sales;?>" />
        <input type="hidden" name="mem_id" value="<? echo $mem_id;?>">
        <input type="hidden" name="mem_name" value="<? echo $mem_name;?>">
         
		<input type="hidden" name="AREA" value="<?echo $AREA;?>" />
		<input type="hidden" name="PC" value="<?echo $PC;?>" />
		<input type="hidden" name="deposit_amt" value="<?echo $deposit_amt;?>" />
		<input type="hidden" name="mem_dep_bal" value="<?php echo $mem_dep_bal;?>"/>
        <input name="clear" type="reset" id="clear" value="上一步" onClick="history.back(1);;">
        <input name="submitb" type="submit" id="submitb" value="送出"></td>
      </tr>
    </table></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
 

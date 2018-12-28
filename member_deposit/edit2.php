<?
//get name
require_once("../include/config.php");
require_once("../include/functions.php");
 

   $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result))
      die ($result->getMessage());
 
	 
	
	 
	
 
?>
<html> 
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
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

function AddrWindow(toccbcc){
	///var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	window.open('page_search_partno.php?recid=' + toccbcc,"","width=500,height=360,scrollbars=yes");
}
function checkform(i)
{
	if (i==1)
	{	
	document.form1.act.value=1;
	}
	else if (i==2)
	{
	document.form1.act.value=2;
	}
	
       document.form1.submit();
}
</script>
<script type="text/javascript" src="../include/invoice.js"></script>

<link href="../include/invoice.css" rel="stylesheet" type="text/css" />
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onkeydown="detectKeyBoard(event)">
<form name="form1" action="edit3.php" method="POST">
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
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80">
            <td width="14%" height="21">
                <span class="style6"> 發票日期： </span>            </td>
            <td width="35%"><span class="style6"><?echo $entry_date;?></span></td>
               <td height="24"><span class="style6">入賬日期：</span></td>
            <td height="24"><span class="style6"><?=$deposit_date?></span></td>
           
          </tr>
		  
          <tr bgcolor="#004d80">
             <td height="23"><span class="style6">客戶名稱：</span></td>
            <td height="23"><span class="style6"><?echo $mem_name;?></span></td><td><span class="style6">員工姓名：</span></td>
            <td><span class="style6"><?echo $sales;?></span></td>
           
          </tr>
         
          <tr bgcolor="#004d80">
            <td height="24"><span class="style6">存入金額:</span></td>
            <td height="24"><span class="style6"><?echo $deposit_amt;?></span></td>
            <td height="24" class="style6">客戶編號：</td>
            <td height="24"><span class="style6"><?echo $mem_id;?></span></td>
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
 
		<input type="hidden" name="mem_dep_id" value="<? echo $mem_dep_id;?>">
		<input type="hidden" name="sales" value="<? echo $sales;?>" />
        <input type="hidden" name="mem_id" value="<? echo $mem_id;?>">
        <input type="hidden" name="mem_name" value="<? echo $mem_name;?>">
         
		<input type="hidden" name="AREA" value="<?echo $AREA;?>" />
		<input type="hidden" name="PC" value="<?echo $PC;?>" />
		<input type="hidden" name="deposit_amt" value="<?echo $deposit_amt;?>" />
 
        <input name="clear" type="reset" id="clear" value="上一步" onClick="history.back(1);">
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

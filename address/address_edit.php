<?
include("./include/config.php");
  $db = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $db->query("SET NAMES 'UTF8'");
if	($update==1)
{
 
	$query="update address set address='$address', alert='$alert' where id='$addr_id'";

 

		if	(mysql_query($query))
		$string="資料已經更生";
		else
		$string="Too Bad!";
		$update=0;
}
if	($update==2)
{
   
		$query="select * from address where id= '$addr_id'";
  
		$result=mysql_query($query);

		if	(!empty($result))
		
		$row= mysql_fetch_array ($result);
		
}	

?>

<STYLE TYPE="text/css">
h1 {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"}
h2 {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"}
li { line-height: 14pt }
input {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 12px}
select {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 12px}
.login       { background-color: #CCCCCC; color: #000000; font-size: 9pt; border-style: solid; 
               border-width: 1px }
small {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt; line-height: 14pt}
p { font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt ;font-color: #FFFFFF}
.style1 {color: #000000; border-style: solid; border-width: 1px; background-color: #CCCCCC;}
.style6 {color: #FFFFFF}
</STYLE>

<script language="JavaScript">
function checkform()
{
	if(document.inmembernameeditform.addr_id.value == "")
	{
	alert ("請輸入客戶編號.");
	document.inmembernameeditform.addr_id.focus();
	}else
	{
        document.inmembernameeditform.submit();
        }

}

 
</script>

<div align="center">
  <table height="300" border="0" cellpadding="2" cellspacing="0" bgcolor="#006666" width="750">
    <tr> 
      <td height="24" colspan="2" bgcolor="#006666"> 
        <div align="left"><strong><a href="../">&lt;更改地址警告&gt;</a></strong></div></td>
      <td width="20%" height="24" bgcolor="#CCCCCC">&nbsp;</td>
      <td width="20%" height="24" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <form name="search_member_name" method="post" action="/?page=address&subpge=address_edit.php">
          <input type="text" name="addr_id" maxlength="20" <? if ($addr_id !="") { echo "value=\"".$addr_id."\"";}?> />
          <input type="hidden" name="update" value="2">
          <input name="submit" type="submit" id="submit" value="搜尋">
          (請輸入要更改資料的編號.) 
        </form>      </td>
    </tr>
      
    <form name=inmembernameeditform method="post" action="/?page=address&subpage=address_edit.php">
      <tr bgcolor="#666666"> 
        <td width="20%" height="5"></td>
        <td width="40%" height="5">&nbsp;</td>
        <td width="20%" height="5">&nbsp; </td>
        <td width="20%" height="5">&nbsp;</td>
      </tr>
    
         
            <input name="addr_id" type="hidden" class="style1" value="<?echo $row["id"];?>"/>
            <input name="update" type="hidden" class="style1" value="1"/>
       
		
      
      <tr bgcolor="#999999"> 
        <td width="20%"> 
          <div align="left"><font color="#FFFFFF">地址關鍵字 :</font></div></td>
        <td colspan="3"> 
          <input name="address" type="text" class="style1" id="address" value="<? $address=$row["address"]; echo $address;?>" size="40">        </td>
      </tr>
        <tr bgcolor="#999999"> 
          <td width="20%"> 
          <div align="left"><font color="#FFFFFF">警告字詞:</font></div></td>
          <td colspan="3"> 
          <input name="alert" cols="40" rows="4" class="style1" value="<? $alert=$row["alert"]; echo $alert;?>"/>        </td>
      </tr>
     
    
    
      <tr> 
        <td width="20%">&nbsp;</td>
        <td width="40%" height="20" align="left" valign="middle"> 
          <input type="submit" name="Submit3" value="更新記錄" onClick="javascript:checkform();">
        <input type="reset" name="Submit2" value="清除" ></td>
            
        <td width="20%"></td>
        <td width="20%">&nbsp;</td>
      </tr></form> 
      <tr> 
        <td width="20%"></td>
        <td valign="bottom" width="40%"> 
          <? echo "$string"?>        </td>
        
        <td width="20%">&nbsp;</td>
      </tr>
  </table>  
</div>


<?
include("./include/config.php");
  $db = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $db->query("SET NAMES 'UTF8'");
if	($update==1)
{
	$query="update member set member_name='$member_name', member_add='$member_add', member_tel='$member_tel',member_fax='$member_fax',member_good_type='$member_good_type',transportLevel='$transportLevel',creditLevel='$creditLevel',remark='$remark' where member_id='$member_id'";

	

		if	(mysql_query($query))
		$string="資料已經更生";
		else
		$string="Too Bad!";
		$update=0;
}
if	($update==2)
{
   
		$query="select * from member where member_id='$member_id'";
  
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
	if(document.inmembernameeditform.member_id.value == "")
	{
		 
	document.inmembernameeditform.member_id.focus();
	}else
	{
        document.inmembernameeditform.submit();
        }

}

function check_del(member)
{
 alert('刪除 '+ member);
 document.inmembernamedelform.submit();
}

</script>
</head>

<body bgcolor="#CCCCCC" text="#FFFFFF">


<div align="center">
  <table height="418" border="0" cellpadding="2" cellspacing="0" bgcolor="#006666" width="750">
    <tr> 
      <td height="24" colspan="2" bgcolor="#006666"> 
        <div align="left"><strong>&lt;更改客戶中文名稱&gt;</strong></div></td>
      <td width="20%" height="24" bgcolor="#CCCCCC">&nbsp;</td>
      <td width="20%" height="24" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <form name="search_member_name" method="post" action="/?page=member&subpage=inmembernameedit.php">
          <input type="text" name="member_id" maxlength="20" <? if ($member_id !="") { echo "value=\"".$member_id."\"";}?>>
          <input type="hidden" name="update" value="2">
          <input name="submit" type="submit" id="submit" value="搜尋">
          (請輸入要更改資料的客戶編號.) 
        </form>      </td>
    </tr>
      
    <form name="inmembernameeditform" method="post" action="/?page=member&subpage=inmembernameedit.php">
      <tr bgcolor="#666666"> 
        <td width="20%" height="5"></td>
        <td width="40%" height="5">&nbsp;</td>
        <td width="20%" height="5">&nbsp; </td>
        <td width="20%" height="5">&nbsp;</td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"> 
          <div align="left"><font color="#FFFFFF"> 
            <input name="member_id" type="hidden" class="style1" value=<?echo $row["member_id"];?>>
            <input name="update" type="hidden" class="style1" value=1>
        客戶編號 :</font> </div></td>
        <td width="40%"> 
        <input name="member_id" type="text" class="style1" value="<? echo $row["member_id"];?>">        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"> 
          <div align="left"><font color="#FFFFFF">客戶中文名稱 :</font></div></td>
        <td colspan="3"> 
          <input name="member_name" type="text" class="style1" id="member_name" value="<? $member_name=stripslashes($row["member_name"]); echo $member_name;?>" size="40">        </td>
      </tr>
        <tr bgcolor="#999999"> 
          <td width="20%"> 
          <div align="left"><font color="#FFFFFF">客戶地址 :</font></div></td>
          <td colspan="3"> 
          <textarea name="member_add" cols="40" rows="4" class="style1"><? $member_add=stripslashes($row["member_add"]); echo $member_add;?></textarea>        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"> 
          <div align="left">客戶電話號碼 :</div></td>
        <td colspan="3"> 
          <input name="member_tel" type="text" class="style1" value="<? $member_tel=stripslashes($row["member_tel"]); echo $member_tel;?>">        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"> 
          <div align="left">客戶傳真號碼 :</div></td>
        <td width="40%"> 
        <input name="member_fax" type="text" class="style1" value="<? $member_fax=stripslashes($row["member_fax"]); echo $member_fax;?>">        </td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"><div align="left"><font color="#FFFFFF">客戶貨品類別</font></div></td>
        <td width="40%"> 
        <input name="member_good_type" type="text" class="style1" value="<?echo $row["member_good_type"];?>">        </td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
      </tr>
      <tr bgcolor="#999999">
        <td class="style6">客戶級別 : </td>
        <td bgcolor="#999999" class="style6"><label>
          <select name="creditLevel">
            <option value="A" <? if($row['creditLevel']=="A") echo "selected"?>>A</option>
            <option value="B" <? if($row['creditLevel']=="B") echo "selected"?>>B</option>
            <option value="C" <? if($row['creditLevel']=="C") echo "selected"?>>C</option>
            <option value="D" <? if($row['creditLevel']=="D") echo "selected"?>>D</option>
            <option value="E" <? if($row['creditLevel']=="E") echo "selected"?>>E</option>
          </select>
        </label></td> 
        <td width="20%" bgcolor="#999999">&nbsp;</td>
        <td width="20%" bgcolor="#999999">&nbsp;</td>
      </tr>
	  <tr bgcolor="#999999">
        <td class="style6">備註 : </td>
		
        <td bgcolor="#999999" class="style6"> <textarea name="remark" cols="40" rows="4" class="style1"><? $remark=stripslashes($row["remark"]); echo $remark;?></textarea>  </td> 
        <td width="20%" bgcolor="#999999">&nbsp;</td>
        <td width="20%" bgcolor="#999999">&nbsp;</td>
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
        <td width="20%">
		<form name="inmembernamedelform"  method="post"  action="/?page=member&subpage=inmembernamedel.php">
          <input type="hidden" name="member_id" value="<? echo $member_id;?>" >
          <input type="submit" name="Submit" value="刪除此客戶" onClick="javascript:check_del('<?echo $member_id;?>')">
        </form></td>
        <td width="20%">&nbsp;</td>
      </tr>
  </table>  
</div>
 

<?
include("./include/config.php");
    $connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
           $result = $connection->query("SET NAMES 'UTF8'");
    
if	($update==1)
{
	$sql="update supplier set supplier_name='$supplier_name', supplier_add='$supplier_add', supplier_tel='$supplier_tel',supplier_fax='$supplier_fax',supplier_good_type='$supplier_good_type',supplier_transport='$supplier_transport' where supplier_id='$supplier_id'";
	

		if	($connection->query($sql))
		$string="資料已經更生";
		else
		$string="Too Bad!";
		$update=0;
}
if	($update==2)
{
   		$sql="select * from supplier where supplier_id='$supplier_id'";
  		$result=$connection->query($sql);
  		if	(!empty($result))
				$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
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
</STYLE>

<script language="JavaScript">
function checkform()
{
	if(document.insuppliernameeditform.supplier_id.value == "")
	{
	alert ("請輸入供應商編號.");
	document.insuppliernameeditform.supplier_id.focus();
	}else
	{
        document.insuppliernameeditform.submit();
        }

}

function check_del(supplier)
{
 alert('刪除 '+ supplier);
 document.insuppliernamedelform.submit();
}

</script>
</head>

<body bgcolor="#CCCCCC" text="#FFFFFF">

<div align="center">
  <table height="418" border="0" cellpadding="2" cellspacing="0" bgcolor="#006666" width="750">
    <tr> 
      <td height="24" colspan="2" bgcolor="#006666"> 
      <div align="left"><strong>&lt;更改供應商中文名稱&gt;</strong></div></td>
      <td width="20%" height="24" bgcolor="#CCCCCC">&nbsp;</td>
      <td width="20%" height="24" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <form name="search_supplier_name" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
          <div align="left">
            <input type="text" name="supplier_id" maxlength="20" <? if ($supplier_id !="") { echo "value=\"".$supplier_id."\"";}?>>
            <input type="hidden" name="update" value="2">
            <input name="submit" type="submit" id="submit" value="搜尋">
            (請輸入要更改資料的供應商編號.)          </div>
        </form>      </td>
    </tr>
        
    <form name=insuppliernameeditform method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
      <tr bgcolor="#666666"> 
        <td width="20%" height="5"><div align="left"></div></td>
        <td width="40%" height="5">&nbsp;</td>
        <td width="20%" height="5">&nbsp; </td>
        <td width="20%" height="5">&nbsp;</td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"> 
          <div align="left"><font color="#FFFFFF"> 
            <input name="supplier_id" type="hidden" class="style1" value=<?echo $row["supplier_id"];?>>
            <input name="update" type="hidden" class="style1" value=1>
            供應商編號:</font> </div></td>
        <td width="40%"> 
        <input name="supplier_id" type="text" class="style1" value="<? echo $row["supplier_id"];?>">        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"><div align="left"><font color="#FFFFFF">供應商中文名稱 :</font></div></td>
        <td colspan="3"> 
          <input name="supplier_name" type="text" class="style1" value="<? $supplier_name=stripslashes($row["supplier_name"]); echo $supplier_name;?>" size="40">        </td>
      </tr>
            <tr bgcolor="#999999"> 
              <td width="20%"><div align="left"><font color="#FFFFFF">供應商地址 :</font></div></td>
              <td colspan="3"> 
              <textarea name="supplier_add" cols="40" rows="4" class="style1"><? $supplier_add=stripslashes($row["supplier_add"]); echo $supplier_add;?></textarea>        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"><div align="left">供應商電話碼 :</div></td>
        <td colspan="3"> 
          <input name="supplier_tel" type="text" class="style1" value="<? $supplier_tel=stripslashes($row["supplier_tel"]); echo $supplier_tel;?>">        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"> 
          <div align="left">供應商傳真碼 :</div></td>
        <td width="40%"> 
        <input name="supplier_fax" type="text" class="style1" value="<? $supplier_fax=stripslashes($row["supplier_fax"]); echo $supplier_fax;?>">        </td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"><div align="left"><font color="#FFFFFF">供應商貨品類別</font></div></td>
        <td width="40%"> 
        <input name="supplier_good_type" type="text" class="style1" value="<?echo $row["supplier_good_type"];?>">        </td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="20%"><div align="left"><font color="#FFFFFF">供應商運輸</font></div></td>
        <td width="40%"> 
        <input name="supplier_transport" type="text" class="style1" value="<?echo $row["supplier_transport"];?>">        </td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
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
        <td width="20%"><form name="insuppliernamedelform" method="post" action="/?page=supplier&subpage=insuppliernamedel.php">
          <input type="hidden" name="supplier_id" value="<? echo $supplier_id;?>" >
          <input type="submit" name="Submit" value="刪除此供應商" onClick="javascript:check_del('<?echo $supplier_id;?>')">
        </form></td>
        <td width="20%">&nbsp;</td>
      </tr>
  </table>
</div>
  

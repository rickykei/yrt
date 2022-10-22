<? 
if ($add==1) //after submit
  {
   $flag=0;
   include("./include/config.php");
       $connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $connection->query("SET NAMES 'UTF8'");

   $sql="select * from supplier where supplier_id='$supplier_id'";
   $result=$connection->query($sql);
   	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
   if ($row["supplier_id"]!=null)
   $flag=1;
   
   
   
   if ($flag==1)
   {
    echo "此項 供應商編號 已於早前被輸入資料庫";
   }
   else
   {

    if ($fromdollar==0)
    {
 
    $market_price=$market_price;
       
    $sql="insert into supplier (supplier_id,supplier_name,supplier_add,supplier_tel,supplier_fax,supplier_good_type,supplier_transport) values ('$supplier_id','$supplier_name','$supplier_add','$supplier_tel','$supplier_fax','$supplier_good_type','$supplier_transport')";
  
    }
    
    if ($fromdollar==1)
    {
    $sql="insert into supplier (supplier_id,supplier_name,supplier_add,supplier_tel,supplier_fax,supplier_good_type,supplier_transport) values ('$supplier_id','$supplier_name','$supplier_add','$supplier_tel','$supplier_fax','$supplier_good_type','$supplier_transport')";
    }
      echo "己經存入";
      
      if ($connection->query($sql))
       echo "Success!";
      else
       echo "Too Bad!";
   }

}
?> 
<LINK REL=stylesheet HREF="./include/invoice.css" TYPE="text/css">
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
.style6 {color: #FFFFFF}
.style7 {color: #000000; border-style: solid; border-width: 1px; background-color: #CCCCCC;}
</STYLE>

<script language="JavaScript">
function checkform()
{
	if(document.suppliernameform.supplier_id.value == "")
	{
	alert ("請輸入供應商編號.");
	document.suppliernameform.supplier_id.focus();
	}else
	{
        document.suppliernameform.submit();
   }

}
</script>
 
<form name=suppliernameform method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">

  <div align="center">
    <table width="750" border="0" cellpadding="0" cellspacing="0">
      <tr bgcolor="#006666">
        <td>&nbsp;</td>
        <td withd="86%">&nbsp;</td>
      </tr>
      <tr bgcolor="#666666"> 
        <input name="add" type="hidden" class="style7" value=1>
        <td width="33%"><span class="style6">供應商編號 : </span> </td>
        <td width="82%" withd="86%"> 
          <input name="supplier_id" type="text" style="border-width: 1px; background-color: #CCCCCC;" maxlength="20" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="18%"><span class="style6">供應商中文名稱 : </span> </td>
        <td width="82%"> 
          <input name="supplier_name" type="text" style="border-width: 1px; background-color: #CCCCCC;" value="" size="40" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="18%"><span class="style6">供應商地址 : </span> </td>
        <td width="82%"> 
          <textarea name="supplier_add" cols="40" rows="4" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid"></textarea>        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="18%"><span class="style6">供應商電話號碼 : </span> </td>
        <td width="82%"> 
          <input name="supplier_tel" type="text" style="border-width: 1px; background-color: #CCCCCC;" value="" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#666666"> 
          <td width="18%"><span class="style6">供應商傳真號碼 : </span> </td>
        <td width="82%"> 
          <input name="supplier_fax" type="text" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="18%"><span class="style6">供應貨品種類 : </span> </td>
        <td width="82%"> 
          <input name="supplier_good_type" type="text" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="18%"><span class="style6">供應商運輸 :</span> </td>
        <td width="82%"> 
          <input name="supplier_transport" type="text" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#006666"> 
        <td width="18%">&nbsp;</td>
        <td width="82%" class="style6"><a href="JavaScript:checkform();"><img src="submit.gif" width="49" height="21" border=0 align=bottom></a>        </td>
      </tr>
    </table>
  </div>
</form>
 

<?php
 
  require_once("./include/config.php");
  require_once("./include/functions.php");
	
	//get Staff name
   $connection = DB::connect($dsn);
	  
   if (DB::isError($connection))
      die($connection->getMessage());
      $query="SET NAMES 'UTF8'";
    
   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
	 $sql="SELECT * FROM staff";
	 $staffResult = $connection->query($sql);
 
?> 
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
 
<? // = $ajax->loadJsCore(true) ?>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="./include/invoice.js"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style11 {
	font-size: xx-small
	}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFF;
}
a:visited {
	color: #FFF;
}
a:hover {
	color: #FFF;
}
a:active {
	color: #FFF;
}
-->
</style>

<form action="/?page=member_deposit&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="1000"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  <tr>
    <td width="4" height="">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#004d80"><span class="style6"><a href="../">會員存款</a></span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="1" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80">
            <td width="80">
                <span class="style6">發票日期：</span></td>
            <td width="136"><input name="entry_date" type="text" id="entry_date" value="<? echo Date("Y-m-d H:i"); ?>" size="15" maxlength="20" readonly="readonly"></td>
             <td width="79"><span class="style6">營業員 ： </span></td>
            <td width="60">
              <select name="sales" id="sales">
              <option value="" > </option>
			  <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
                echo "<option value=\"".$row['name'];
                echo "\"";
                if ($USER==$row['name'])
           			echo " selected";
                echo ">".$row['name']."</option>";
				}?>
                </select>			</td>
            <td width="191"></td>
			<td colspan="2">  <label><span class="style6">現金結餘 : </label></span><input name="mem_dep_bal" id="mem_dep_bal" type="text" disabled="disabled" class="blocktextbox" size="10" maxlength="10">
		  <br>
		   <label><span class="style6">銀行結餘 : </label></span><input name="mem_dep_bank_bal" id="mem_dep_bank_bal" type="text" disabled="disabled" class="blocktextbox" size="10" maxlength="10"></td>
			</tr>
			
          <tr bgcolor="#004d80">
            <td ><span class="style6">入賬日期：</span></td>
            <td ><input name="deposit_date" type="text" id="deposit_date" tabindex="39" size="15" maxlength="20" value="<? echo Date("Y-m-d H:i"); ?>"><input name="cal" id="calendar" value=".." type="button"></td>
           
            <td><span class="style6">客戶編號：</span></td>
            <td colspan="2"><input onKeyPress="next_text_box(event,'deposit_date')"  onBlur="javascript:check888();"  name="mem_id" tabindex="38" type="text" id="mem_id"  size="15" onChange="findMemIdAjax()"/> </td>
			 
			<td width="237"><span class="style6">客戶名稱：
			  <input name="mem_name" type="text" id="mem_name">
			  </span></td>
            <td width="188" ><span class="style6">會員級別</span>
              <input name="mem_credit_level" id="mem_credit_level" type="text" disabled="disabled" class="blocktextbox" size="3" maxlength="3"></td>
          </tr>
		  
		    
		  
          <tr bgcolor="#004d80">
         
            <td><span class="style6">存入金額</span></td>
            <td colspan="4"><input onKeyPress="next_text_box(event,'mem_id')" tabindex="37" name="deposit_amt" type="text" id="deposit_amt" size="60" maxlength="255" onChange="findAddressAlertAjax()" /></td>
			<td><input type="text" id="warning" name="warning" readonly="readonly" /></td>
			<td> <input name="submitb" type="submit" id="submitb" value="送出"></td>
           </tr>
         <tr bgcolor="#004d80">
         
            <td><span class="style6">存入銀行金額</span></td>
            <td colspan="4"><input onKeyPress="next_text_box(event,'mem_id')" tabindex="37" name="deposit_bank_amt" type="text" id="deposit_bank_amt" size="60" maxlength="255" onChange="findAddressAlertAjax()" /></td>
			<td> </td>
			<td> </td>
           </tr>
        </table></td>
      </tr>
       
          
         
       
   
  </tr>
</table>
<input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" />
 
</form>
<script type="text/javascript">
 
  Calendar.setup(
    {
      inputField  : "deposit_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %I:%M",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
   
 
</script>

<?php
    $invoiceRecord=17;
	require_once("./include/config.php");
	require_once("./include/functions.php");
	 
	if (DB::isError($connection)) die($connection->getMessage());

    //(Run the query on the winestore through the connection
	$result = $connection->query("SET NAMES 'UTF8'");
	if (DB::isError($result)) die ($result->getMessage());
	$sql="SELECT * FROM staff";
	$staffResult = $connection->query($sql);
 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<title>木板碎料出貨單</title>
<? // = $ajax->loadJsCore(true) ?>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/jquery-1.4.1.min.js"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="./invoice_scrap/invoice.js?date=20200509"></script>
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

<form action="/?page=invoice_scrap&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="1000"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#004d80"><span class="style6"><a href="../">木板碎料出貨單</a></span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80">
            <td width="80">
                <span class="style6">發票日期：</span></td>
            <td width="136"><input name="invoice_date" type="text" id="invoice_date" value="<? echo Date("Y-m-d H:i"); ?>" size="16" maxlength="20" readonly="readonly"></td>
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
            <td width="191"><span class="style6">收貨人：
              <input  name="receiver" tabindex="38" type="text" id="receiver"  size="15" />
            </span></td>
			<td colspan="2"><input id="status1" name="status" type="radio" value="A" checked>
			  <span class="style6">入帳</span>
			  <input id="status2" name="status" type="radio" value="S">
			  <span class="style6">掛單</span><span class="style6">
			  <input id="status1" name="status" type="radio" value="D" >
			  <span class="style6">訂金</span>
			    &nbsp;&nbsp;&nbsp;&nbsp;
			    <input name="delivery" type="radio" id="delivery1" value="Y" checked="checked" />
			    送貨</span> <span class="style6">
				<input name="delivery" type="radio" id="delivery2" value="S" />
			      自取
				<input name="delivery" type="radio" id="delivery3" value="C" />
			      街車即走</span></td>
			</tr>
			
          <tr bgcolor="#004d80">
            <td ><span class="style6">送貨日期：</span></td>
            <td ><input name="delivery_date" type="text" id="delivery_date" tabindex="39" size="12" maxlength="20" value="<? echo Date("Y-m-d"); ?>"><input name="cal" id="calendar" value=".." type="button"></td>
           
            <td><span class="style6">客戶編號：</span></td>
            <td colspan="2"><input onKeyPress="next_text_box(event,'delivery_date')"  onBlur="javascript:check888();"  name="mem_id" tabindex="38" type="text" id="mem_id"  size="15" onChange="findMemIdAjax()"/> </td>
			 
			<td width="237"><span class="style6">客戶名稱：
			  <input name="mem_name" type="text" id="mem_name">
			  </span></td>
            <td width="188" ><span class="style6">會員級別</span>
              <input name="mem_credit_level" id="mem_credit_level" type="text" disabled="disabled" class="blocktextbox" size="3" maxlength="3"></td>
          </tr>
		  
		   <tr bgcolor="#004d80">
            <td ><span class="style6">送貨時間：</span></td>
			 
            <td colspan="4">
			<select name="delivery_timeslot" id="delivery_timeslot">
              <option value="1" <?php if (choose_timeslot()==1) {echo "selected";}?>> 早 08:00-11:00</option> 
			  <option value="2" <?php if (choose_timeslot()==2) {echo "selected";}?>> 午 11:01-14:00</option> 
			  <option value="3" <?php if (choose_timeslot()==3) { echo "selected";}?>> 晚 14:01-18:00</option> 
			  </select>
			 </td>
			 <td><span class="style6">尺寸計法： </span><select name="cal_unit" id="cal_unit" onChange="find_input_item()"><option value="mm">毫米mm</option><option value="in">寸inch</option></select></td>
			 <td></td>
           </tr>
		  
          <tr bgcolor="#004d80">
          <td><span class="style6">入賬日期：</span></td>
                    <td><input name="settledate" type="text" id="settledate" value="<? echo Date("Y-m-d H:i"); ?>" size="12" maxlength="20"><input name="cal2" id="calendar2" value=".." type="button"></td>
                
            <td><span class="style6">送貨地址：</span></td>
            <td colspan="3"><input onKeyPress="next_text_box(event,'mem_id')" tabindex="37" name="mem_add" type="text" id="mem_add" size="60" maxlength="255" onChange="findAddressAlertAjax()" /></td>
			<td><input type="text" id="warning" name="warning" readonly="readonly" /></td>
                </tr>
         
        </table></td>
      </tr>
	  <tr bgcolor="#FFFFFF"> <td colspan=4 align="center">1/8 = 0.125， 2/8 = 0.25， 3/8 = 0.375， 4/8 = 0.5， 5/8 = 0.625， 6/8 = 0.75， 7/8 = 0.875</td></tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#004d80">
            <td width="4%"><span class="style6">行數</span></td>
            
            <td width="7%"><span class="style6">木板碎料</span></td>
         
            <td width="7%"><span class="style6">濶</span></td>
            <td width="7%"><span class="style6">高</span></td>
            
         
			<td width="6%"><span class="style6">數量</span></td>
			<td width="9%"><span class="style6"><span class="style6">單價</span></span></td>
			<td width="9%"><span class="style6"><span class="style6">總金</span></span></td>
          </tr>
<?


$tab=0;        
for ($i=0;$i<$invoiceRecord;$i++)          
{
	?>
          <tr bgcolor="#CCCCCC">
            <td>
				<div align="center"><span class="style7"><?echo $i+1;?></span></div>
			</td>
            <td>
				<input type="text" name="partno[<?echo $i;?>]"  id="partno[<?echo $i;?>]" onKeyPress="next_text_box(event,'width<?=$i;?>')" onChange="findPartNoAjax('<?=$i?>')">
			</td>
			 
			<td>
				<input name="width[<?echo $i;?>]" type="text" id="width[<?echo $i;?>]" size="5" maxlength="10" value="" onChange="findPartNoAjax('<?=$i?>')">
			</td>
            <td>
				<input name="height[<?echo $i;?>]" type="text" id="height[<?echo $i;?>]"  size="5" maxlength="10" onChange="findPartNoAjax('<?=$i?>')">
			</td>
			<td>
			<input name="qty[<?echo $i;?>]" type="text" id="qty[<?echo $i;?>]" size="5" maxlength="5" value="1"    onChange="findPartNoAjax('<?=$i?>')" ></td>
                       
			 <td><div align="center">
              <input name="unit_price[<?echo $i;?>]" type="text" id="unit_price[<?echo $i;?>]" size="10" maxlength="10" readonly="readonly"/>
             </div></td>
			 <td><div align="center">
              <input name="subtotal[<?echo $i;?>]" type="text" id="subtotal[<?echo $i;?>]"     size="10" maxlength="10" readonly="readonly"/>
             </div></td>
			 
          </tr>
	 
<?}?>
          
        
            
        </table>          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#004d80">
            <tr>
              <td width="7%"><span class="style6">
                <input name="clear" type="reset" id="clear" value="清除">
              </span></td>
              <td width="10%"> </td>
              <td width="8%">
                <!--<input type="checkbox" name="special_man_power" value="Y" />-->
               </td>
              <td width="7%"><span class="style6">總折扣</span></td>
            <td width="18%"><span class="style6">
              <label>
              <input name="subdiscount" type="text" id="subdiscount" value="0" size="5" maxlength="3">
              </label>
%<strong>
<input name="subdeduct" type="text" id="subdeduct" value="0" size="7" maxlength="7">
$</strong></span></td>
              <td width="17%" class="style6">訂金
                  <input name="deposit" type="text" class="disabled" id="deposit" size="10" />              </td>
              <td width="17%"><span class="style6">
                <input type="button" name="Submit" value="暫計" onClick="calTotalAmt()">
                <input name="totalamt" type="text" class="disabled" id="totalamt" size="10" />
              </span></td>
              <td width="8%" class="style6">信用卡
                <input type="checkbox" name="creditcard" id="creditcard"></td>
              <td width="8%"><input name="submitb" type="button" id="submitb" value="送出" onClick="checkform(0)"></td>
            </tr>
          </table>          </td>
      </tr>
    
    </table>     </td>
  </tr>
</table>
<input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" />
<? 
for ($i=0;$i<$invoiceRecord;$i++)
 {?>
 <input type="hidden" name="delivered[]" id="delivered<?echo $i;?>" value="N"/>
<input type="hidden" name="manpower[]" id="manpower<?echo $i;?>" value="N"/>
<input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="Y"/>
<input type="hidden" name="cutting[]" id="cutting<?echo $i;?>" value="N"/>
<?}?>
</form>
 
<script type="text/JavaScript">
  first_text_box_focus();
  Calendar.setup(
    {
      inputField  : "delivery_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
    Calendar.setup(
    {
      inputField  : "settledate",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
  
 
</script> 

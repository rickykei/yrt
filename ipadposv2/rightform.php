<?php
	$invoiceRecord=16;
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
 
 
<script type="text/javascript">
 
 

 $(function() {
	
	 var items = localStorage.getItem(pos+'_memid');
		items = JSON.parse(items);
		$(items).each(function (index, data) {
			$('#mem_id').val(data);
		});
		var items = localStorage.getItem(pos+'_memadd');
		items = JSON.parse(items);
		$(items).each(function (index, data) {
			$('#mem_add').val(data);
		});
	var items = localStorage.getItem(pos+'_receiver');
		items = JSON.parse(items);
		$(items).each(function (index, data) {
			$('#receiver').val(data);
		});
	

		
		$(document).on('input','[id^=qty],[id^=discount]',function () { 
			count_total();
		});
	

	$("table.order-list2").on("click", ".ibtnDel", function (event) {
		   
			pointer=$(this).attr("data");
			
			$('#goods_partno'+pointer).val("");
			$('#qty'+pointer).val("");
			$('#market_price'+pointer).val("");
			$(this).closest("tr").remove();       
			
			
				   
			var item=[];
			 var items = localStorage.getItem(pos+'_myItems');
			if (items != null) {
			items = JSON.parse(items);
			} else {
			items = new Array();
			}
			items.splice(pointer,1);
			localStorage.setItem(pos+'_myItems',
			JSON.stringify(items));
			
			
			
			 count_total();
			 $('#subsubtotal').val($('#countid').val());
	});
	
   refresh();
   findAddressAlertAjax();
   	findMemIdAjax('pos');
		
   selectall_delivered();
 });
 </script>
 
<form action="/?page=ipadposv2&subpage=index5.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1" >
<table  width="100%" bgcolor="#99d6ff"  valign="top" >

  <tr >
    
    <td align="left" valign="top">
	<table  width="100%" >
	
	
	    <tr bgcolor="#FFFFFF">
        <td colspan="4">
		<table width="100%"  bgcolor="#FFFFFF">
        
		  
		  <tr><td >
		    <table width="100%"  id="myTable"   class="table order-list">
		  
		    <tr bgcolor="#004d80">
            <td ><span class="style6">行數</span></td>
            <td ><span class="style6">貨品編號</span></td>
            <td ><span class="style6">數量</span></td>
            <td  ><span class="style6">項目</span></td>
            <td ><span class="style6"><span class="style6">單價</span></span></td>
            <td ><span class="style6">折扣%</span></td>
            <td class="style6"><div align="center">行送</div></td>
            <td class="style6"><div align="center">界板</div></td>
			 <td><span class="style6">出貨
              <input name="delivered" type="checkbox" id="alldelivered0" onChange="javascript:selectall_delivered();"/>
            </span></td> 
          </tr>
		 
		  </table>
		  <table width="100%"  id="myTable"   class="table order-list2">
		  
		     
		 
		  </table>
		  </td></tr>
        </table> 
		</td>
      </tr>
	  
	  
		<tr bgcolor="#FFFFFF">
        <td >
          <table  width="100%" cellspacing="0" bgcolor="#004d80">
            <tr>
          
              <td><span class="style6">扶力費折扣：</span></td>
			  <td>
                <!--<input type="checkbox" name="special_man_power" value="Y" />-->
                <input name="special_man_power_percent" type="text" id="special_man_power_percent" value="6" size="3" maxlength="5" />
				</td><td>
                <span class="style6"><strong>%</strong></span>
			  </td>
              
			  
            <td  ><span class="style6">總折扣</span></td>  
            <td >
			<span class="style6">
              <label>
              <input name="subdiscount" type="text" id="subdiscount" value="0" size="5" maxlength="3">
              </label>
			  </td><td>
			%</td></tr>
			  <tr>
			<td>
			
			<input name="subdeduct" type="text" id="subdeduct" value="0" size="7" maxlength="7">
			</td><td><strong>$</strong></span>
			</td>
			<td  class="style6">訂金</td><td>
                  <input name="deposit" type="text" class="disabled" id="count" size="10" />              </td>
			</tr><tr>
              
              <td >
                <input type="button" name="Submit" value="暫計" onClick="javascript:count_total()">
				</td><td><span class="style6">
                <input name="count" type="text" class="disabled" id="countid" size="10" />
              </span></td>
              <td  class="style6">信用卡
                <input type="checkbox" name="creditcard" id="creditcard"></td>
              <td > </td>
            </tr>
          </table>          </td>
      </tr>
      <tr bgcolor="#FFFFFF"  width="100%">
        <td height="24" ><table  width="100%"  cellspacing="0">
          <tr bgcolor="#004d80">
            <td >
                <span class="style6">發票日期：</span></td>
            <td ><input name="invoice_date" type="text" id="invoice_date" value="<? echo Date("Y-m-d H:i"); ?>" size="15" maxlength="20" readonly="readonly"></td>
             <td  ><span class="style6">營業員 ： </span></td>
            <td  >
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
			</tr>
			<tr  bgcolor="#004d80">
            	
			 
			<td colspan=2>
			
			<fieldset data-role="controlgroup" data-theme="b" data-type="horizontal">
					<input id="status1" name="status" type="radio" value="A" checked>
						<label for="status1">入賑</label>
					  <input id="status2" name="status" type="radio" value="S">
						<label for="status2">掛單</label>
					  <input id="status3" name="status" type="radio" value="D" >
						 <label for="status3">訂金</label>
			</fieldset>
			</td>
			
			<td colspan=2>
				<fieldset data-role="controlgroup" data-theme="c" data-type="horizontal">
			    <input name="delivery" type="radio" id="delivery1" value="Y" checked="checked" />
			    <label for="delivery1">送貨</label>
				<input name="delivery" type="radio" id="delivery2" value="S" />
			    <label for="delivery2">自取</label>
				<input name="delivery" type="radio" id="delivery3" value="C" />
			       <label for="delivery3">街車即走</label>
				 <input name="delivery" type="radio" id="delivery4" value="W" />
			      <label for="delivery4">等電</label>
			</fieldset>	
				 </td>
			
			</tr><tr bgcolor="#004d80">
			
			<td colspan=4>
			<fieldset data-role="controlgroup" data-theme="c" data-type="horizontal">
				 <input id="deposit_method1" name="deposit_method" type="radio" value="C" checked>
				  <label for="deposit_method1">現金入賑</label>
				<input id="deposit_method2" name="deposit_method" type="radio" value="D" >
				<label for="deposit_method2">會員賑戶扣數</label>
			</fieldset>
			</td>
		
			</tr>
			
          <tr bgcolor="#004d80">
            <td ><span class="style6">送貨日期：</span></td>
            <td ><input name="delivery_date" type="text" id="delivery_date" tabindex="39" size="12" maxlength="20" value="<? echo Date("Y-m-d"); ?>"><input name="cal" id="calendar" value=".." type="button"></td>
           
            <td ><span class="style6">客戶編號：</span></td>
            <td colspan="1" ><input onKeyPress="next_text_box(event,'delivery_date')"  onBlur="javascript: check888();"  name="mem_id" tabindex="38" type="text" id="mem_id"  size="15" onChange="findMemIdAjax()"/> </td>
			</tr><tr bgcolor="#004d80"> 
			<td ><span class="style6">客戶名稱：</td><td>
			  <input name="mem_name" type="text" id="mem_name">
			  </span></td>
            <td ><span class="style6">會員級別</span></td><td>
              <input name="mem_credit_level" id="mem_credit_level" type="text" disabled="disabled" class="blocktextbox" size="3" maxlength="3">
		  </td>
		  </tr><tr bgcolor="#004d80">
		  <td>
		 <input name="sum_dep_amt" id="sum_dep_amt" type="hidden" disabled="disabled" class="blocktextbox" size="10" maxlength="10"> 
		 
		 <input name="sum_inv_dep_amt" id="sum_inv_dep_amt" type="hidden" disabled="disabled" class="blocktextbox" size="10" maxlength="10"> 
		
		  <label><span class="style6">結餘 : </label></span> </td><td><input name="mem_dep_bal" id="mem_dep_bal" type="text" disabled="disabled" class="blocktextbox" size="10" maxlength="10">
		  </td>
         
					<td ><span class="style6">送貨時間：</span></td>
					
					<td colspan="1">
					<select name="delivery_timeslot" id="delivery_timeslot">
					  <option value="1" <?php if (choose_timeslot()==1) {echo "selected";}?>> 早 08:00-11:00</option> 
					  <option value="2" <?php if (choose_timeslot()==2) {echo "selected";}?>> 午 11:01-14:00</option> 
					  <option value="3" <?php if (choose_timeslot()==3) { echo "selected";}?>> 晚 14:01-18:00</option> 
					  </select>
					 </td>
		 </tr>
		  
		   <tr bgcolor="#004d80">			 
					 <td colspan="1">
					  <span class="style6">收貨人： </span></td>
					  <td colspan="1">
					  <input  name="receiver" tabindex="38" type="text" id="receiver"  size="15" />
					 </td>
					 <td >
					    <span class="style6">姓氏： </span>
						</td><td><input  name="lastname" tabindex="38" type="text" id="receiver"  size="15" />
					 </td>
             </tr>
		  
		     <tr bgcolor="#004d80">
					<td ><span class="style6">會員remark： </span></td>
					 
					 <td colspan=2 >
					  <input  name="mem_remark"   type="text" id="mem_remark"/>
					 </td>
					 <td><input type="text" id="warning" name="warning" readonly="readonly" /></td>
					  
             </tr>
			 
          <tr bgcolor="#004d80">
          <td><span class="style6">入賬日期：</span></td>
                    <td><input name="settledate" type="text" id="settledate" value="<? echo Date("Y-m-d H:i"); ?>"  maxlength="20"><input name="cal2" id="calendar2" value=".." type="button"></td>
                
            <td><span class="style6">送貨地址：</span></td>
            <td ><input onKeyPress="next_text_box(event,'mem_id')" tabindex="37" name="mem_add" type="text" id="mem_add"   maxlength="255" onChange="findAddressAlertAjax()" /></td>
			
                </tr>
         
        </table></td>
      </tr>
  
      
    
    </table>     </td>
  </tr>
</table>
<?php 
//20060426
		if ($status=="A")
{
	?>	<input type="hidden" name="deposit" value="<?=$subsubtotal?>"/>
		<? }else{?>
		<input type="hidden" name="deposit" value="<?=$deposit?>"/>
<? }
$subsubtotal=($total_man_power_price+$total_price)*(100-$subdiscount)/100-$subdeduct;
 if ($creditcard=="on"){
		 			$creditcardrate=3;
		 			$creditcardtotal=round($subsubtotal*$creditcardrate/100);
					$subsubtotal=$subsubtotal+$creditcardtotal;
		 }
	?>	 
<input type="hidden" name="AREA" value="<?echo $AREA;?>" />
<input type="hidden" name="PC" value="<?echo $PC;?>" />
<input type="hidden" name="subsubtotal" value="<?=$subsubtotal?>"/>
<input type="hidden" name="pos" value="<?=$pos?>"/>


		
		<input type="hidden" name="creditcardtotal" value="<?=$creditcardtotal?>"/>
   		<input type="hidden" name="creditcardrate" value="<?=$creditcardrate?>"/>
		<input type="hidden" name="subsubtotal" id="subsubtotal" value="<?=$subsubtotal?>"/>
 
		<input type="hidden" name="man_power_price" value="<? echo $total_man_power_price;?>" />
<? 
for ($i=0;$i<$invoiceRecord;$i++)
 {?>
 
 
  <input type="hidden" name="delivered[]" id="delivered<?echo $i;?>" value="N"/>
<input type="hidden" name="manpower[]" id="manpower<?echo $i;?>" value="N"/>
<input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="Y"/>
<input type="hidden" name="cutting[]" id="cutting<?echo $i;?>" value="N"/>
 
<?}?>
</form>
 
<script type="text/javascript">
 
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
<?php
    
	
  $invoiceRecord=17;
  require_once("./include/config.php");
  require_once("./include/functions.php");
 
  include_once("./include/timestamp.php");
  $ts = new TIMESTAMP;
	//db connection
	$connection = DB::connect($dsn);
	   if (DB::isError($connection))
      die($connection->getMessage());
	   $result = $connection->query("SET NAMES 'UTF8'");
	//get Staff name	  
	  $sql="SELECT * FROM staff";
	 $staffResult = $connection->query($sql);
      
	 //select invoice
    
	 $sql="Select * from invoice_door where invoice_no = ".$id;
	 $invoiceResult = $connection->query($sql);
	$invoicerow = $invoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
	
	for ($i=0;$i<$invoiceRecord;$i++)
	{
		$goods_invoice[$i]['discountrate']=0;
		$goods_invoice[$i]['qty']=0;
	}
	
	$sql_prod= "select * from sumgoods where model='現貨膠板' and goods_partno like 'YR%' ; ";
	$sql_prod_result = $connection->query($sql_prod);
  	$i=0;
	while ($row_prod = $sql_prod_result->fetchRow(DB_FETCHMODE_ASSOC)){
		  $row_prod_arr[]=$row_prod;
	}
	
		//膠邊
	$sql_prod_side= "select * from sumgoods where model='膠水什項' and goods_partno like 'Y%' ; ";
	$sql_prod_side_result = $connection->query($sql_prod_side);
	$i=0;
	while ($row_prod_side = $sql_prod_side_result->fetchRow(DB_FETCHMODE_ASSOC)){
	    $row_prod_side_arr[]=$row_prod_side;
	}		  
			 
		//鋁抽
	$sql_prod_hand= "select * from sumgoods where model='五金' and goods_partno like 'KA%' ; ";
	$sql_prod_hand_result = $connection->query($sql_prod_hand);
	$i=0;
	while ($row_prod_hand = $sql_prod_hand_result->fetchRow(DB_FETCHMODE_ASSOC)){
	    $row_prod_hand_arr[]=$row_prod_hand;
	}		
	
	// get goods_invoice detail
	$sql="select * from goods_invoice_door where invoice_no=".$id." order by id asc";
	$goods_invoiceResult = $connection->query($sql);
	$i=0;
	while($goods_invoicerow = $goods_invoiceResult->fetchRow(DB_FETCHMODE_ASSOC))
	{
		
		$goods_invoice[$i]['cut_type']=$goods_invoicerow['cut_type'];
		$goods_invoice[$i]['sheet_cd']=$goods_invoicerow['sheet_cd'];
		$goods_invoice[$i]['strip_cd']=$goods_invoicerow['strip_cd'];
		$goods_invoice[$i]['width']=$goods_invoicerow['width'];
		$goods_invoice[$i]['height']=$goods_invoicerow['height'];
		$goods_invoice[$i]['upcutpoint']=$goods_invoicerow['upcutpoint'];
		$goods_invoice[$i]['downcutpoint']=$goods_invoicerow['downcutpoint'];
		$goods_invoice[$i]['pattern']=$goods_invoicerow['pattern'];
		$goods_invoice[$i]['double_side']=$goods_invoicerow['double_side'];
		$goods_invoice[$i]['small_window']=$goods_invoicerow['small_window'];
		$goods_invoice[$i]['big_window']=$goods_invoicerow['big_window'];
		$goods_invoice[$i]['draw_cd']=$goods_invoicerow['draw_cd'];
		$goods_invoice[$i]['qty']=$goods_invoicerow['qty'];
		$goods_invoice[$i]['unit_price']=$goods_invoicerow['unit_price'];
		$goods_invoice[$i]['subtotal']=$goods_invoicerow['subtotal'];
		$goods_invoice[$i]['status']=$goods_invoicerow['status'];
		
		$sql_read_only="select readonly from sumgoods where goods_partno='".$goods_invoicerow['goods_partno']."'";
		$goods_c= $connection->query($sql_read_only);
		$goods_p =$goods_c->fetchRow(DB_FETCHMODE_ASSOC);
		$goods_invoice[$i]['readonly']=$goods_p['readonly'];
		 
		
		//search good detail
		if ($goods_invoice[$i]['goods_detail']==""){
		$sql="select * from sumgoods where goods_partno='".$goods_invoicerow['goods_partno']."'";
		$goods_c= $connection->query($sql);
		$goods_p =$goods_c->fetchRow(DB_FETCHMODE_ASSOC);
		//20060409 if detail have stored on wood.goods_invoice
		$goods_invoice[$i]['goods_detail']=$goods_p['goods_detail'];
		}
		$i++;
	}

?>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="./invoice_door/invoice_door.js?20180217"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css">
<form action="/?page=invoice_door&subpage=invoice_door_edit2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">

<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td  align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="13%" height="21" bgcolor="#004d80"><span class="style6"><a href="invoice_door_list.php">方邊門出貨單</a></span></td>
        <td width="35%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?>[<?php echo $id;?>]</td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80">
            <td width="80">
                <span class="style6"> 發票日期： </span>            </td>
            <td width="141" ><input name="invoice_date" id="invoice_date" type="text" READONLY="READONLY"  value="<?php $ts->getDate($invoicerow['invoice_date']);?>" size="12" maxlength="20"><input name="cal_invoice_date" id="cal_invoice_date" value=".." type="button"> </td>
            <td width="73" ><span class="style6">營業員 ：</span></td>
            <td width="94" > <select name="sales" id="sales">
			  <?php
			  // 20100329 disable change staff name on invoice editing RW
				//   Fung request add bonus issue
				 //
			  if (!($AREA=="Y" && $PC=="99") && !($AREA=="Y" && $PC=="1") ){
					echo "<option value=\"".$invoicerow['sales_name']."\" ";	
					echo "selected";
					echo ">".$invoicerow['sales_name']."</option>";
			  }
			  else
			  {
				  while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
				  {
					echo "<option value=\"".$row['name']."\" ";
					if ($invoicerow['sales_name']==$row['name'])
					echo "selected";
					echo ">".$row['name']."</option>";
					}
			  }
			?>
                    
                </select><span class="style6"><?=$invoicerow['sales_name']?></span></td>
            <td width="181" >
            <span class="style6">收貨人：<input  name="receiver" tabindex="38" type="text" id="receiver"  size="15" value="<?php echo $invoicerow['receiver'];?>" />
            </span></td>
            <td colspan="2" ><input name="status" type="radio" value="A" <?php if($invoicerow['settle']=="A"){echo "checked";}?>>
              <span class="style6">入帳</span>
              <input name="status" type="radio" value="S" <?php if($invoicerow['settle']=="S"){echo "checked";}?>>
              <span class="style6">掛單</span><span class="style5">&nbsp; 
			  <input id="status1" name="status" type="radio" value="D" <?php if($invoicerow['settle']=="D"){echo "checked";}?> >
			  <span class="style6">訂金</span>
                <input name="delivery" type="radio" id="delivery" value="Y" <?php if ($invoicerow['delivery']=="Y"){echo "checked";}?>/>
                </span><span class="style6">送貨
                  <input name="delivery" type="radio" id="radio" value="S" <?php if ($invoicerow['delivery']=="S"){echo "checked";}?>/>
                  自取
  <input name="delivery" type="radio" id="radio2" value="C" <?php if ($invoicerow['delivery']=="C"){echo "checked";}?>/>
                  街車即走</span>&nbsp; <span class="style6">分店</span>:
              
              <select name="branchID" id="branchID">
                <?
              		for ($i=0;$i<count($shop_array);$i++){
              	   ?><option value="<?=$shop_array[$i]?>" <? if($invoicerow["branchID"]==$shop_array[$i]) {echo "selected";}?>><?=$shop_array[$i]?></option>	
              	   <?
              		}
              		?>
              </select>           </td>
            </tr>
          <tr bgcolor="#004d80">
            <td ><span class="style6">送貨日期：</span></td>
            <td ><div align="left">
              <input name="delivery_date" type="text" id="delivery_date3" tabindex="39" onFocus="javascript:document.getElementById('check_mem_id').click();" value="<?php $ts->getDate($invoicerow['delivery_date']);?>" size="12" maxlength="20"><input name="cal" id="calendar" value=".." type="button">
            </div>
             </td>
            <td ><span class="style6">客戶編號：</span></td>
            <td colspan="2" ><input name="mem_id" type="text" tabindex="38" id="mem_id" value="<?php echo $invoicerow['member_id'];?>" size="15" onKeyPress="next_text_box(event,'delivery_date3')" onChange="findMemIdAjax()" >
              <input name="check_mem_id" id="check_mem_id" type="button" value="?"></td>
			  
            <td width="108" ><span class="style6">客戶名稱：</span></td>
            <td width="286" ><input name="mem_name" type="text" id="mem_name" value="<?php echo $invoicerow['customer_name'];?>">
              <span class="style6">會員級別</span>
              <input name="mem_credit_level" id="mem_credit_level" type="text" disabled="disabled" class="blocktextbox" size="2" maxlength="2"></td>
          </tr>
		  
		   <tr bgcolor="#004d80">
            <td ><span class="style6">送貨時間：</span></td>
			 
            <td colspan="2">
			<select name="delivery_timeslot" id="delivery_timeslot">
              <option value="1" <?php if ($invoicerow['delivery_timeslot']==1) {echo "selected";}?>> 早 08:00-12:00</option> 
			  <option value="2" <?php if  ($invoicerow['delivery_timeslot']==2) {echo "selected";}?>> 午 12:01-14:00</option> 
			  <option value="3" <?php if  ($invoicerow['delivery_timeslot']==3) { echo "selected";}?>> 晚 14:01-18:00</option> 
			  </select>
			  	 
		  </td>
		  <td><label><span class="style6">結餘 : </label></span></td>
		  <td  colspan="2"><input name="mem_dep_bal" id="mem_dep_bal" type="text" disabled="disabled" class="blocktextbox" size="10" maxlength="10">
		 
			 </td>
			  <td ><span class="style6">尺寸計法： </span><select name="cal_unit" id="cal_unit" onChange="count_line_total('<?=$i?>')"><option value="mm" <?php if ($invoicerow['cal_unit']=='mm') echo 'selected';?>>毫米mm</option><option value="in" <?php if ($invoicerow['cal_unit']=='in') echo 'selected';?>>寸inch</option></select></td>
			  
           </tr>
				  
          <tr bgcolor="#004d80">
            <td height="24" ><span class="style6">入賬日期：</span></td>
            <td height="24" ><input name="settledate" type="text" id="settledate" value="<?php $ts->getDate($invoicerow['settledate']);?>" size="12" maxlength="20"><input name="cal2" id="calendar2" value=".." type="button"></td>
            <td height="24" ><span class="style6">送貨地址：</span></td>
            <td height="24" colspan="3" ><input name="mem_add" tabindex="37" onKeyPress="next_text_box(event,'mem_id')" type="text" id="mem_add" size="50" value="<?php echo $invoicerow['customer_detail'];?>" onChange="findAddressAlertAjax()"></td>
            <td height="24" ><input type="text" id="warning" name="warning" readonly="readonly" /></td>
            </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
               <tr bgcolor="#004d80">
            <td width="4%"><span class="style6">行數</span></td>
            <td width="5%"><span class="style6">抽手</span></td>
            <td width="7%"><span class="style6">現貨膠板</span></td>
            <td width="7%"><span class="style6">膠邊</span></td>
            <td width="7%"><span class="style6">濶</span></td>
            <td width="7%"><span class="style6">高</span></td>
            <td width="7%" class="style6"><div align="center">上中位mm</div></td>
            <td width="7%" class="style6"><div align="center">下中位mm</div></td>
            <td width="6%"><span class="style6">追紋<input name="allmanpower" type="checkbox" id="allmanpower0" onChange="javascript:selectall();"/>
            </span></td>
			<td width="6%"><span class="style6">雙面<input name="allmanpower" type="checkbox" id="allmanpower0" onChange="javascript:selectall();"/>
            </span></td>
				<td width="6%"><span class="style6">大窗<input name="allmanpower" type="checkbox" id="allmanpower0" onChange="javascript:selectall();"/></span></td>
			<td width="6%"><span class="style6">小窗<input name="allmanpower" type="checkbox" id="allmanpower0" onChange="javascript:selectall();"/></span></td>
			<td width="6%"><span class="style6">鋁抽 
            </span></td>
		 
			 <td width="6%"><span class="style6">數量
             
            </span></td>
			<td width="9%"><span class="style6"><span class="style6">單價</span></span></td>
			<td width="9%"><span class="style6"><span class="style6">總金</span></span></td>
          </tr>
<? $elements_counter=15;

$tab=0; 
for ($i=0;$i<$invoiceRecord;$i++)          
{
	?>
          <tr bgcolor="#CCCCCC">
            <td><div align="center"><?echo $i+1;?></div></td>
            <td>
			<select tabindex="<?$tab++;echo $tab?>" id="cut_type[<?echo $i;?>]" name="cut_type[<?echo $i;?>]" onChange="count_line_total('<?=$i?>')">
			<option value=""></option>
			<option value="1" <?php if ($goods_invoice[$i]['cut_type']=="1") {echo "Selected";}?>>平口</option>
			<option value="2" <?php if ($goods_invoice[$i]['cut_type']=="1") {echo "Selected";}?>>尖口</option>
			</select>
			</td>
       
			<td>
			<input type="text" name="sheet_cd[<?echo $i;?>]"  id="sheet_cd[<?echo $i;?>]" onChange="count_line_total('<?=$i?>')" value="<?php echo $goods_invoice[$i]['sheet_cd'];?>">
			 </td>
			
            <td>
			<input type="text" name="strip_cd[<?echo $i;?>]"  id="strip_cd[<?echo $i;?>]" onChange="count_line_total('<?=$i?>')" value="<?php echo $goods_invoice[$i]['strip_cd'];?>">
		
</td>
			
			   <td><input name="width[<?echo $i;?>]" type="text" id="width[<?echo $i;?>]" size="5" maxlength="10" value="<?php echo $goods_invoice[$i]['width'];?>" onChange="count_line_total('<?=$i?>')"></td>
            <td><input name="height[<?echo $i;?>]" type="text" id="height[<?echo $i;?>]"  size="5" maxlength="10" value="<?php echo $goods_invoice[$i]['height'];?>" onChange="count_line_total('<?=$i?>')"></td>
			<td><input name="upcutpoint[<?echo $i;?>]" type="text" id="upcutpoint<?echo $i;?>" size="5" maxlength="10" value="<?php echo $goods_invoice[$i]['upcutpoint'];?>"></td>
			<td><input name="downcutpoint[<?echo $i;?>]" type="text" id="downcutpoint<?echo $i;?>"  size="5" maxlength="10" value="<?php echo $goods_invoice[$i]['downcutpoint'];?>"></td>
			
			
            <td><div align="center">
              <input name="pattern[<?echo $i;?>]" type="checkbox" id="pattern[<?echo $i;?>]" value="Y" onClick="count_line_total('<?=$i?>')" <?php if ("Y"==$goods_invoice[$i]['pattern']) {echo "CHECKED";}?>>
            </div></td>
            <td><div align="center">
              <input name="double_side[<?echo $i;?>]" type="checkbox"  id="double_side[<?echo $i;?>]" value="Y" onClick="count_line_total('<?=$i?>')" <?php if ("Y"==$goods_invoice[$i]['pattern']) {echo "CHECKED";}?>>
            </div></td>
			 <td><div align="center">
              <input name="big_window[<?echo $i;?>]" type="checkbox"  id="big_window[<?echo $i;?>]" value="Y" onClick="count_line_total('<?=$i?>')" <?php if ("Y"==$goods_invoice[$i]['big_window']) {echo "CHECKED";}?>>
            </div></td>
			 <td><div align="center">
              <input name="small_window[<?echo $i;?>]" type="checkbox"  id="small_window[<?echo $i;?>]" value="Y" onClick="count_line_total('<?=$i?>')" <?php if ("Y"==$goods_invoice[$i]['small_window']) {echo "CHECKED";}?>>
            </div></td>
          	<td>   <input name="draw_cd[<?echo $i;?>]" type="checkbox"  id="draw_cd[<?echo $i;?>]" value="Y" onClick="count_line_total('<?=$i?>')" <?php if ("Y"==$goods_invoice[$i]['draw_cd']){echo "CHECKED";}?>>
			 </td>
      
			
            <td><input name="qty[<?echo $i;?>]" type="text" id="qty[<?echo $i;?>]" size="5" maxlength="5" value="<?php echo $goods_invoice[$i]['qty'];?>" tabindex="<?$tab++;echo $tab?>"   onChange="count_line_total('<?=$i?>')" ></td>
                  
			  
			    <td><div align="center">
              <input name="unit_price[<?echo $i;?>]" type="text" id="unit_price[<?echo $i;?>]" size="10" maxlength="10" readonly="readonly" value="<?php echo $goods_invoice[$i]['unit_price'];?>"/>
             </div></td>
			 <td><div align="center">
              <input name="subtotal[<?echo $i;?>]" type="text" id="subtotal[<?echo $i;?>]"     size="10" maxlength="10" readonly="readonly" value="<?php echo $goods_invoice[$i]['subtotal'];?>"/>
             </div></td>
			 
			 
          </tr><script type="text/javascript">
		
		</script>
<?}?>
          
        
            
        </table>          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#006633">
            <tr>
              <td width="6%" bgcolor="#666666"><span class="style6">
                <input name="clear" type="reset" id="clear" value="清除">
              </span></td>
              <td width="11%" bgcolor="#666666"><span class="style6">扶力費折扣：</span></td>
              <td width="8%" bgcolor="#666666"><input name="special_man_power_percent" type="text" id="special_man_power_percent" size="3" maxlength="5" value="<?php echo $invoicerow['special_man_power_percent'];?>"/>
                <span class="style6"><strong>%                </strong></span></td>
              <td width="6%" bgcolor="#666666"><span class="style6">總折扣</span></td>
            <td width="19%" bgcolor="#666666"><span class="style6">
              <label>
              <input name="subdiscount" type="text" id="subdiscount" value="<?=$invoicerow['discount_percent']?>" size="5" maxlength="3" >
              </label>
%<strong>
<input name="subdeduct" type="text" id="subdeduct" value="<?=$invoicerow['discount_deduct']?>" size="7" maxlength="7">
$</strong></span></td>
              <td width="17%" bgcolor="#666666"><span class="style6">訂金$
                  <input name="deposit" type="text" class="disabled" id="count" value="<?=$invoicerow['deposit']?>" size="10" />
              </span></td>
              <td width="18%" bgcolor="#666666" class="style6"><input type="button" name="Submit" value="暫計" onClick="javascript:count_total()">
                <input name="count" type="text" class="disabled" id="totalamt" size="10" /></td>
              <td width="10%" bgcolor="#666666"><span class="style6">信用卡
              <? if ($invoicerow['credit_card_rate']!=0 and $invoicerow['credit_card_rate']!=null){
			  ?>
                <input type="checkbox" name="creditcard" id="creditcard" checked/>
                <? }else{ ?>
                  <input type="checkbox" name="creditcard" id="creditcard">
                  <? } ?>
              </span></td>
              <td width="5%" bgcolor="#666666"><input name="submitb" type="button" id="submitb" value="送出" onClick="checkform()"></td>
            </tr>
          </table>          </td>
      </tr>
    </table></td>
    <td width="0">&nbsp;</td>
  </tr>
</table>
 <input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" />
<input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $id;?>" /><?

?>
</form>
<script type="text/javascript">
first_text_box_focus();
  Calendar.setup(
    {
      inputField  : "delivery_date3",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
    Calendar.setup(
    {
      inputField  : "invoice_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "cal_invoice_date"       // ID of the button
      
    }
  );   Calendar.setup(
    {
      inputField  : "settledate",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
</script>



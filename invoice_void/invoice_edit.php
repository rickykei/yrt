<?php
    
	
  $invoiceRecord=16;
  require_once("../include/config.php");
  require_once("../include/functions.php");
 // include_once ('../include/ajax/phpAjaxTags.inc.php'); 
	//pat_Js(array('jsPath'=>'../include/ajax/js'));
  include_once("../include/timestamp.php");
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
    
	 $sql="Select * from invoice where invoice_no = ".$id;
	 $invoiceResult = $connection->query($sql);
	$invoicerow = $invoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
	
	for ($i=0;$i<$invoiceRecord;$i++)
	{
		$goods_invoice[$i]['discountrate']=0;
		$goods_invoice[$i]['qty']=0;
	}
	
	
	
	
	// get goods_invoice detail
	$sql="select * from goods_invoice where invoice_no=".$id." order by id asc";
	$goods_invoiceResult = $connection->query($sql);
	$i=0;
	while($goods_invoicerow = $goods_invoiceResult->fetchRow(DB_FETCHMODE_ASSOC))
	{
		
		$goods_invoice[$i]['goods_partno']=$goods_invoicerow['goods_partno'];
		$goods_invoice[$i]['qty']=$goods_invoicerow['qty'];
		$goods_invoice[$i]['discountrate']=$goods_invoicerow['discountrate'];
		$goods_invoice[$i]['goods_detail']=$goods_invoicerow['goods_detail'];
		$goods_invoice[$i]['status']=$goods_invoicerow['status'];
		$goods_invoice[$i]['marketprice']=$goods_invoicerow['marketprice'];
		$goods_invoice[$i]['subtotal']=$goods_invoicerow['subtotal'];
		$goods_invoice[$i]['manpower']=$goods_invoicerow['manpower'];
		$goods_invoice[$i]['cutting']=$goods_invoicerow['cutting'];
		$goods_invoice[$i]['deductstock']=$goods_invoicerow['deductstock'];
		$goods_invoice[$i]['delivered']=$goods_invoicerow['delivered'];
		
		$sql_read_only="select readonly from sumgoods where goods_partno='".$goods_invoicerow['goods_partno']."'";
		$goods_c= $connection->query($sql_read_only);
		$goods_p =$goods_c->fetchRow(DB_FETCHMODE_ASSOC);
		$goods_invoice[$i]['readonly']=$goods_p['readonly'];
		 
		
		
		if ($goods_invoice[$i]['goods_detail']==""){
		$sql="select * from sumgoods where goods_partno='".$goods_invoicerow['goods_partno']."'";
		$goods_c= $connection->query($sql);
		$goods_p =$goods_c->fetchRow(DB_FETCHMODE_ASSOC);
		//20060409 if detail have stored on wood.goods_invoice
		$goods_invoice[$i]['goods_detail']=$goods_p['goods_detail'];
		}
		$i++;
	}

?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice</title>

<style type="text/css">
@import url(../include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="../include/cal/calendar.js"></script>
<script type="text/javascript" src="../include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="../include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="../include/invoice.js"></script>
<script type="text/javascript" src="../include/functions.js"></script>
<script type="text/javascript" src="../include/jquery-1.4.1.min.js"></script>
<link href="../include/invoice_edit.css" rel="stylesheet" type="text/css">
 <script type="text/javascript" src="../js/js.storage.min.js"></script> 
 <script type="text/javascript">
 	  function backPOS(){
		  
			var item=[];
			var i=0;
			var items =[];
			
					 
			for(i=0;i<16;i++) {
			 
				 if ($('#goods_partno'+i).val()!=""){
					item[0] = $('#qty'+i).val();
					item[1] = $('#goods_partno'+i).val();
					item[2] = $('#goods_detail'+i).val();
					item[3] = $('#market_price'+i).val();
					
					
					items.push(item);
					 localStorage.setItem('myItems',JSON.stringify(items));
					 item=[];
				 }
			}
			
			var invoiceno=<?php echo $id;?>;
			 
					 localStorage.setItem('invoiceno',JSON.stringify(invoiceno));
			
				 
			 window.location.href="/invoice_pos/";
 	};

 $(function() {

	
	function refresh(){

	var items = localStorage.getItem('myItems');
	  if (items != null) {
			items = JSON.parse(items);
			$(items).each(function (index, data) {
			 $('#goods_partno'+index).val(data[1]);
			  $('#qty'+index).val(data[0]);
			  $('#goods_detail'+index).val(data[2]);
			  $('#market_price'+index).val(data[3]);
			  $('#goods_partno'+index).focus();
			  findPartNoAjax(index);
			});
		}
	};
	
	
	
   refresh(); 
 });
 </script>
<style type="text/css">

</style></head>
<body onkeydown="detectKeyBoard(event)">
<form action="invoice_edit2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">

<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CC99">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td  align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="13%" height="21" bgcolor="#666666"><span class="style6"><a href="invoicelist.php">更改出貨單</a> <a href="javascript:backPOS()">POS</a></span></td>
        <td width="35%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?>[<?php echo $id;?>]</td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="1" cellpadding="2" cellspacing="0">
          <tr bgcolor="#3366CC">
            <td width="77" height="21" bgcolor="#006633">
                <span class="style6"> 發票日期： </span>            </td>
            <td width="141" bgcolor="#006633"><input name="invoice_date" id="invoice_date" type="text" READONLY="READONLY"  value="<?php $ts->getDate($invoicerow['invoice_date']);?>" size="12" maxlength="20"><input name="cal_invoice_date" id="cal_invoice_date" value=".." type="button"> </td>
            <td width="73" bgcolor="#006633"><span class="style6">營業員 ：</span></td>
            <td width="94" bgcolor="#006633" colspan=2> <select name="sales" id="sales">
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
           
            <td colspan="2" bgcolor="#006633"><input name="status" type="radio" value="A" <?php if($invoicerow['settle']=="A"){echo "checked";}?>>
              <span class="style6">入帳</span>
              <input name="status" type="radio" value="S" <?php if($invoicerow['settle']=="S"){echo "checked";}?>>
              <span class="style6">掛單</span><span class="style5">&nbsp; 
			  <input id="status1" name="status" type="radio" value="D" <?php if($invoicerow['settle']=="D"){echo "checked";}?> >
			  <span class="style6">訂金</span> <br>
				 <input id="deposit_method1" name="deposit_method" type="radio" value="C" <?php if($invoicerow['deposit_method']=="C"){echo "checked";}?>>
				<span class="style6">現金入賑</span>
			  <input id="deposit_method2" name="deposit_method" type="radio" value="D" <?php if($invoicerow['deposit_method']=="D"){echo "checked";}?>>
			  <span class="style6">會員賑戶扣數</span><span class="style6">
			 
			  <br>
                <input name="delivery" type="radio" id="delivery" value="Y" <?php if ($invoicerow['delivery']=="Y"){echo "checked";}?>/>
                </span><span class="style6">送貨
                  <input name="delivery" type="radio" id="radio" value="S" <?php if ($invoicerow['delivery']=="S"){echo "checked";}?>/>
                  自取
  <input name="delivery" type="radio" id="radio2" value="C" <?php if ($invoicerow['delivery']=="C"){echo "checked";}?>/>
                  街車即走</span>&nbsp; 
				   <input name="delivery" type="radio" id="delivery1" value="W" <?php if ($invoicerow['delivery']=="W"){echo "checked";}?>/>
			     <span class="style6">等電</span> 
				  <span class="style6">分店</span>:
              
              <select name="branchID" id="branchID">
                <?
              		for ($i=0;$i<count($shop_array);$i++){
              	   ?><option value="<?=$shop_array[$i]?>" <? if($invoicerow["branchID"]==$shop_array[$i]) {echo "selected";}?>><?=$shop_array[$i]?></option>	
              	   <?
              		}
              		?>
              </select>           </td>
            </tr>
          <tr bgcolor="#006633">
            <td bgcolor="#006633"><span class="style6">送貨日期：</span></td>
            <td bgcolor="#006633"><div align="left">
              <input name="delivery_date" type="text" id="delivery_date3" tabindex="39" onFocus="javascript:document.getElementById('check_mem_id').click();" value="<?php $ts->getDate($invoicerow['delivery_date']);?>" size="12" maxlength="20"><input name="cal" id="calendar" value=".." type="button">
            </div>
             </td>
            <td bgcolor="#006633"><span class="style6">客戶編號：</span></td>
            <td colspan="2" bgcolor="#006633"><input name="mem_id" type="text" tabindex="38" id="mem_id" value="<?php echo $invoicerow['member_id'];?>" size="15" onKeyPress="next_text_box(event,'delivery_date3')" onChange="findMemIdAjax()" >
              <input name="check_mem_id" id="check_mem_id" type="button" value="?"></td>
			  
            <td width="108" bgcolor="#006633"><span class="style6">客戶名稱：</span></td>
            <td width="286" bgcolor="#006633"><input name="mem_name" type="text" id="mem_name" value="<?php echo $invoicerow['customer_name'];?>">
              <span class="style6">會員級別</span>
              <input name="mem_credit_level" id="mem_credit_level" type="text" disabled="disabled" class="blocktextbox" size="2" maxlength="2"></td>
          </tr>
		  
		   <tr bgcolor="#006633">
            <td ><span class="style6">送貨時間：</span></td>
			 
            <td colspan="1">
			<select name="delivery_timeslot" id="delivery_timeslot">
              <option value="1" <?php if ($invoicerow['delivery_timeslot']==1) {echo "selected";}?>> 早 08:00-12:00</option> 
			  <option value="2" <?php if  ($invoicerow['delivery_timeslot']==2) {echo "selected";}?>> 午 12:01-14:00</option> 
			  <option value="3" <?php if  ($invoicerow['delivery_timeslot']==3) { echo "selected";}?>> 晚 14:01-18:00</option> 
			  </select>
			 </td>
			 <td colspan="2">
			   <span class="style6">收貨人：<input  name="receiver" tabindex="38" type="text" id="receiver"  size="15" value="<?php echo $invoicerow['receiver'];?>" />
            </span>
			<td>
			<td colspan="2">
			   <span class="style6">姓氏：<input  name="lastname" tabindex="38" type="text" id="lastname"  size="15" value="<?php echo $invoicerow['lastname'];?>" />
            </span>
			</td>
           </tr>
				  
          <tr bgcolor="#006633">
            <td height="24" bgcolor="#006633"><span class="style6">入賬日期：</span></td>
            <td height="24" bgcolor="#006633"><input name="settledate" type="text" id="settledate" value="<?php $ts->getDate($invoicerow['settledate']);?>" size="12" maxlength="20"><input name="cal2" id="calendar2" value=".." type="button"></td>
            <td height="24" bgcolor="#006633"><span class="style6">送貨地址：</span></td>
            <td height="24" colspan="3" bgcolor="#006633"><input name="mem_add" tabindex="37" onKeyPress="next_text_box(event,'mem_id')" type="text" id="mem_add" size="50" value="<?php echo $invoicerow['customer_detail'];?>" onChange="findAddressAlertAjax()"></td>
            <td height="24" bgcolor="#006633"><input type="text" id="warning" name="warning" readonly="readonly" /><span class="style6">取消單 </span><input type="checkbox" name="sts" value="I"></td>
            </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#006633">
            <td width="4%" bgcolor="#666666"><span class="style6">行數</span></td>
            <td width="21%" bgcolor="#666666"><span class="style6">貨品編號</span></td>
            <td width="7%" bgcolor="#666666"><span class="style6">數量</span></td>
            <td width="36%" bgcolor="#666666"><span class="style6">項目</span></td>
            <td width="10%" bgcolor="#666666"><span class="style6"><span class="style5">單價</span></span></td>
            <td width="5%" bgcolor="#666666"><span class="style6">折扣</span></td>
			<td width="4%" bgcolor="#666666" class="style6"><div align="center">行送</div></td>
            <td width="5%" bgcolor="#666666" class="style6"><div align="center">界板</div></td>
           <!---// <td width="8%" bgcolor="#666666" class="style6">扶力
              <input name="allmanpower" type="checkbox" id="allmanpower0" onChange="javascript:selectall();"/>            </td>//--->
			   <td width="6%" bgcolor="#666666" class="style6"> 出貨
              <input name="delivered" type="checkbox" id="alldelivered0" onChange="javascript:selectall_delivered();"/>
             </td>
          </tr>
<? $elements_counter=15;

$tab=0; 
for ($i=0;$i<$invoiceRecord;$i++)          
{
	?>
          <tr bgcolor="#CCCCCC">
            <td><div align="center"><?echo $i+1;?></div></td>
            <td><input name="goods_partno[]" type="text" id="goods_partno<?echo $i;?>" size="20" maxlength="25"  tabindex="<?$tab++;echo $tab?>" value="<?php echo $goods_invoice[$i]['goods_partno'];?>" onKeyPress="next_text_box(event,'qty<?=$i;?>')" onChange="findPartNoAjax('<?=$i?>')" />
             <input type=button name="search" value="." onClick="javascript:AddrWindow(<?echo $i;?>);" ><div width="5" class="style7" style="display: inline" id="stockbal_<?echo $i;?>"></div>
             </td>
            <td><input name="qty[]" type="text" id="qty<?echo $i;?>" size="8" maxlength="10" tabindex="<?$tab++;echo $tab?>" onKeyPress="next_text_box(event,'goods_id<?=$i+1;?>')"  value="<?php echo $goods_invoice[$i]['qty'];?>" onFocus="javascript:document.getElementById('action<?=$i?>').click();"></td>
                       <td><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<?echo $i;?>" value="<?php echo $goods_invoice[$i]['goods_detail'];?>" size="40" maxlength="40">
            </div></td>
			 <td><div align="center">
			  <?php if ($goods_invoice[$i]['readonly']=='Y'){ ?>
              <input name="market_price[]" type="text" id="market_price<?echo $i;?>"  value="<?php echo $goods_invoice[$i]['marketprice'];?>"  size="10" maxlength="10" readonly="readonly" />
			  <?php }else{ ?>
			  <input name="market_price[]" type="text" id="market_price<?echo $i;?>"  value="<?php echo $goods_invoice[$i]['marketprice'];?>"  size="10" maxlength="10" />
			  <?php } ?>
             </div></td>
            <td><div align="center">
              <input name="discount[]" type="text" id="discount<?echo $i;?>" size="3" maxlength="3" value="<?php echo $goods_invoice[$i]['discountrate'];?>">
            </div></td>
			   <td><div align="center">
			   <?php if ($goods_invoice[$i]['deductstock']=='N'){ ?>
              <input name="deductStockX[]" type="checkbox" id="deductStockX<?echo $i;?>" value="N" onClick="javascript:clickCheckBoxDeductStock(<?echo $i;?>)" checked/>
			    <input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="N"/>
			  <?php }else{?>
			  <input name="deductStockX[]" type="checkbox" id="deductStockX<?echo $i;?>" value="Y" onClick="javascript:clickCheckBoxDeductStock(<?echo $i;?>)">
			    <input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="Y"/>
				<?php }?>
            </div></td>
            <td><div align="center">
			<?php if ($goods_invoice[$i]['cutting']=='Y'){ ?>
              <input name="cuttingX[]" type="checkbox"  id="cuttingX<?echo $i;?>" value="Y" onClick="javascript:clickCheckBoxCutting(<?echo $i;?>)" checked/>
			   <input type="hidden" name="cutting[]" id="cutting<?echo $i;?>" value="Y"/>
			    <?php }else{?>
				 <input name="cuttingX[]" type="checkbox"  id="cuttingX<?echo $i;?>" value="N" onClick="javascript:clickCheckBoxCutting(<?echo $i;?>)"/>
				  <input type="hidden" name="cutting[]" id="cutting<?echo $i;?>" value="N"/>
				 <?php }?>
            </div></td>
          <!---//
            <td>
              <div align="center">
			  <?php if ($goods_invoice[$i]['manpower']=='Y'){ ?>
  			           <input name="manpowerX[]" type="checkbox"  id="manpowerX<?echo $i;?>" value="Y" onClick="javascript:clickCheckBox(<?echo $i;?>)" checked/>
					    <input type="hidden" name="manpower[]" id="manpower<?echo $i;?>" value="Y"/>
					   <?php } else{ ?>
			           <input name="manpowerX[]" type="checkbox"  id="manpowerX<?echo $i;?>" value="N" onClick="javascript:clickCheckBox(<?echo $i;?>)" />
					    <input type="hidden" name="manpower[]" id="manpower<?echo $i;?>" value="N"/>
					   <?php }?>
              </div></td>//-->
			  
			   <td>
              <div align="center">
			  <?php if ($goods_invoice[$i]['delivered']=='Y'){ ?>
                <input name="deliveredX[]" type="checkbox"  id="deliveredX<?echo $i;?>" value="Y" onClick="javascript:clickCheckBoxDelivered(<?echo $i;?>)" checked/>
				 <input type="hidden" name="delivered[]" id="delivered<?echo $i;?>" value="Y"/>
				 <?php }else{?>
				 <input name="deliveredX[]" type="checkbox"  id="deliveredX<?echo $i;?>" value="N" onClick="javascript:clickCheckBoxDelivered(<?echo $i;?>)"/>
				 <input type="hidden" name="delivered[]" id="delivered<?echo $i;?>" value="N"/>
				 <?php }?>
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
                <input name="count" type="text" class="disabled" id="countid" size="10" /></td>
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



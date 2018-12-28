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
       
?><META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
 
<? // = $ajax->loadJsCore(true) ?>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./js/inshop.js"></script>
<link href="./css/inshop.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
 
  var pos='<?php echo $pos;?>';
  
 	  function backPOS(){
		  
			var item=[];
			var i=0;
			var items =[];
			
					 
			for(i=0;i<16;i++) {
			 
				 if ($('#goods_partno'+i).val()!="" && $('#goods_partno'+i).val()!=null){
					item[0] = $('#qty'+i).val();
					item[1] = $('#goods_partno'+i).val();
					item[2] = $('#goods_detail'+i).val();
					item[3] = $('#market_price'+i).val();
					item[4] = item[0]*item[3];
					
					items.push(item);
					 localStorage.setItem(pos+'_myItems',JSON.stringify(items));
					 item=[];
				 }
			}
				 
			 window.location.href="/?page=pos_inshop&subpage=index.php&pos=<?php echo $pos;?>";
 	};

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
	
	
	function refresh(){
		
		items = localStorage.getItem(pos+'_myItems');
			if (items != null) {
		
			items = JSON.parse(items);
			var counter = 0;
			var total_price=0;
			$(items).each(function (index, data) {
			 
			 
			  $('#qty'+index).val(data[0]);
			  $('#goods_detail'+index).val(data[2]);
			  $('#market_price'+index).val(data[3]);
			  $('#subtotal'+index).val(parseFloat(data[3])*parseFloat(data[0]));
			  $('#goods_partno'+index).focus();
			 // findPartNoAjax(index);
			    
				
 
				var newRow = $("<tr bgcolor='#CCCCCC'>");
				var cols = "";

				
				if (data[5]=='Y'){
					cols += '<td><div align="center"><span class="style7">'+(counter+1)+'</span></div></td></td>';
					cols += '<td><input name="goods_partno[]" type="text" id="goods_partno'+counter+'"   readonly="readonly" value="'+data[1]+'" /></td>';
					cols += '<td><input name="qty[]" type="text" id="qty'+counter+'"  value="'+data[0]+'"  onChange="findPartNoAjax('+counter+')"  ></td>';
					cols += '<td><input name="goods_detail[]" type="text" id="goods_detail'+counter+'"  size="35" value="'+data[2]+'" readonly="readyonly"></td>';
					cols += '<td> <input name="market_price[]" type="text" id="market_price'+counter+'"  value="'+data[3]+'"    readonly="readonly"/></td>';
					cols += '<td> <input name="discount[]" type="text" id="discount'+counter+'"  value="0"   /></td>';
					cols += '<td><input name="subtotal[]" type="text" id="subtotal'+counter+'" tabindex=""  onfocus="" value="'+parseFloat(data[3])*parseFloat(data[0])+'"  size="10" maxlength="10"/></td>';
					cols += '<td> <input name="deliveredX[]" type="checkbox"  id="deliveredX'+counter+'" value="Y" onClick="javascript:clickCheckBoxDelivered('+counter+')" /></td>';
					cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger " data="'+counter+'" value="Delete"></td>';
				}else{
					cols += '<td><div align="center"><span class="style7">'+(counter+1)+'</span></div></td></td>';
					cols += '<td><input name="goods_partno[]" type="text" id="goods_partno'+counter+'"   readonly="readonly" value="'+data[1]+'"/></td>';
					cols += '<td><input name="qty[]" type="text" id="qty'+counter+'"  value="'+data[0]+'"  onChange="findPartNoAjax('+counter+')"  ></td>';
					cols += '<td><input name="goods_detail[]" type="text" id="goods_detail'+counter+'"  size="35" value="'+data[2]+'"  ></td>';
					cols += '<td> <input name="market_price[]" type="text" id="market_price'+counter+'"  value="'+data[3]+'"    /></td>';
					cols += '<td> <input name="discount[]" type="text" id="discount'+counter+'"  value="0"   /></td>';
					cols += '<td><input name="subtotal[]" type="text" id="subtotal'+counter+'" tabindex=""  onfocus="" value="'+parseFloat(data[3])*parseFloat(data[0])+'"  size="10" maxlength="10"/></td>';					
					cols += '<td> <input name="deliveredX[]" type="checkbox"  id="deliveredX'+counter+'" value="Y" onClick="javascript:clickCheckBoxDelivered('+counter+')" /></td>';
					cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger " data="'+counter+'" value="Delete"></td>';
				}
			 
				total_price=total_price+parseFloat(data[3])*parseFloat(data[0]);
				
			
				newRow.append(cols);
				$("table.order-list").append(newRow);
				counter++;
			});
			
			 
			$('#subsubtotal').val($('#countid').val());
    
		}
		
			$('#alldelivered0').attr('checked',true);
		 
			count_total();
	};
		
		$(document).on('input','[id^=qty],[id^=discount]',function () { 
			count_total();
		});
	

	$("table.order-list").on("click", ".ibtnDel", function (event) {
		   
			pointer=$(this).attr("data");
			
			$('#goods_partno'+pointer).val("");
			$('#qty'+pointer).val("");
			$('#market_price'+pointer).val("");
			$(this).closest("tr").remove();       
			
			 count_total();
			 $('#subsubtotal').val($('#countid').val());
	});
	
   refresh(); findAddressAlertAjax();
   	findMemIdAjax();
		
   selectall_delivered();
 });
 </script>
 

<form action="/?page=pos_inshop&subpage=index5.php&pos=<?php echo $pos;?>" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="1000"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
       <tr>
        <td width="14%" height="21" bgcolor="#006666" ><span class="style6">入舖單</span> <a href="/?page=pos_inshop&subpage=index.php&pos=<?php echo $pos;?>"><span class="style6">POS</span></a></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666" >
            <td width="20%" height="21">
                <span class="style6"> <span class="style5">入舖單</span>日期 ：</span></td>
            <td width="28%" ><input name="inshop_date" type="text" id="inshop_date" value=""><input name="cal" id="calendar" value=".." type="button"></td>
            <td width="17%" ><span class="style6">職員 : </span></td>
            <td width="35%" ><select name="staff_name" id="staff_name">
             <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
                echo "<option value=\"".$row['name'];
                echo "\"";
                if ($USER==$row['name'])
           			echo " SELECTED";
                echo ">".$row['name']."</option>";
				}?>
            </select></td>
          </tr>
          <tr bgcolor="#006666" >
            <td ><span class="style6">供應商 ：</span></td>
            <td >
			<input type="text" name="supplier_name" id="supplier_name" size="25" />
			<input name="supplier_id" id="supplier_id" type="hidden" />
			<input type="button" name="search2" value=".." onclick="javascript:popUp('/?page=inshop&subpage=page_search_supplier.php','650','350')"></td>
            <td ><span class="style6">供應商發票編號：</span></td>
            <td><input name="supplier_invoice_no" type="text" id="supplier_invoice_no" /></td>
          </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
        
		  
		  <tr><td colspan="9"><table id="myTable" class="table order-list">
		  
		    <tr bgcolor="#006666">
           <td width="6%"><span class="style6">行數</span></td>
            <td width="24%"><span class="style6">貨品編號</span></td>
            <td width="7%"><span class="style6">數量</span></td>
            <td width="30%"><span class="style6">項目</span></td>
            <td width="8%"><span class="style5"><span class="style6">單價</span></span></td>
            <td width="5%" class="style6">折扣</td>
            <td width="11%" class="style6">金額</td>
              <td width="9%" class="style6"><div align="center">行送</div></td>
            </span></td>
          </tr>
		  </table></td></tr>
        </table> 
		</td>
      </tr>
        <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#006666">
            <tr>
              <td class="style6">備註欄</td>
              <td colspan="4"><label>
                <textarea name="remark" cols="65" rows="2" id="remark"></textarea>
              </label></td>
              <td>&nbsp;</td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="right" class="style6">總數 : </div></td>
              <td><input name="count_price" type="text" class="disabled" id="count_price"  onfocus="javascript:count_total()" value="0" size="10"/></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="right" class="style6">折扣 : </div></td>
              <td><input name="sub_discount" type="text" class="disabled" id="sub_discount" value="0" size="10" /></td>
              <td></td>
            </tr>
            <tr>
              <td width="14%">&nbsp;</td>
              <td width="13%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
            <td width="35%"><div align="right"><span class="style6">
            <input name="button" type="button" id="button" value="暫計" onclick="javascript:count_total()"/>
            </span></div></td>
              <td width="15%"><div align="right" class="style6">                應付金額 : </div></td>
              <td width="12%"><input name="total_price" type="text" class="disabled" id="total_price" value="0" size="10" /></td>
              <td width="1%"></td>
            </tr>
          </table>          </td>
      </tr>
     <tr>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height=""><input type="hidden" name="AREA" value="<? echo $AREA; ?>" /><input type="hidden" name="PC" value="<? echo $PC; ?>" /></td>
        <td><input name="clear" type="reset" id="clear" value="清除">
         <input name="submitb" type="button" id="submitb" value="送出" onClick="checkform()"></td>
      </tr>
    </table>     </td>
  </tr>
</table>
<input type="hidden" name="AREA" value="<? echo $AREA; ?>" /><input type="hidden" name="PC" value="<? echo $PC; ?>" />
 <?
for ($i=0;$i<$inshopRecord;$i++)
 {?>

<input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="Y"/>

<? }?>
</form>
 
<script type="text/javascript">
//first_text_box_focus();
  Calendar.setup(
    {
      inputField  : "inshop_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
</script> 
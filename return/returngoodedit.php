<?php 
  $callajax="/invoice/sampleAjaxServer.php";
  require_once("./include/config.php");
  include_once ('./include/ajax/phpAjaxTags.inc.php'); 
  pat_Js(array('jsPath'=>'./include/ajax/js'));
  $returnRecord=10;


	
// Sql Connection
	$connection = DB::connect($dsn);
	if (DB::isError($connection))
		die($connection->getMessage());
			$result = $connection->query("SET NAMES 'UTF8'");
//get Staff name

	$sql="SELECT * FROM staff";
	$staffResult = $connection->query($sql);
	
//get returngood

	$sql="SELECT * FROM returngood where return_no=$return_no";
	$returnresult = $connection->query($sql);
	$returnrow = $returnresult->fetchRow(DB_FETCHMODE_ASSOC);

//get instock_goods

	$sql="SELECT * FROM goods_return where return_no=$return_no";
	$goods_returnresult = $connection->query($sql);


	?> 
<link href="./include/return.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

-->
</style><style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/return.js"></script>
</head>
<form action="/?page=return&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="880" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ACC7FF">

  <tr>
    <td height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#6699CC"><span class="style6">修改退貨單</span></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%"></td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#6699CC">
            <td height="21"><label><span class="style6">退貨單編號 :</span> </label></td>
            <td colspan="2"><label><span class="style6"><?php echo $returnrow['return_no']; ?></span><input type="hidden" name="return_no" value="<?=$returnrow['return_no'];?>"> </label></td>
            <td width="39%">&nbsp;</td>
          </tr>
          <tr bgcolor="#6699CC">
            <td width="20%" height="21">
                <span class="style6"> <span class="style5">退貨</span>日期 ：</span></td>
            <td width="29%"><input name="return_date" type="text" id="return_date" value="<? echo $returnrow['return_date']; ?>">
              <input name="cal" id="calendar" value=".." type="button" /></td>
            <td width="12%"><span class="style6">職員 : </span></td>
            <td><select name="staff_name" id="staff_name">
              <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
			  
			  	if ($row['name']==$returnrow['staff_name'])
				echo "<option value=\"".$row['name']."\" selected>".$row['name']."</option>";
				else
                echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
				}?>
            </select></td>
          </tr>
          <tr bgcolor="#6699CC">
            <td ><span class="style6">YRT發票編號：</span></td>
            <td ><input name="invoice_no" type="text" id="invoice_no" value="<?=$returnrow['invoice_no'];?>"/></td>
            <td><span class="style6">客戶名稱：</span></td>
            <td><input name="customer_name" type="text" id="customer_name" value="<?=$returnrow['customer_name']?>" /></td>
          </tr>
          <tr bgcolor="#6699CC">
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td class="style6">分店：<?=$returnrow["branchID"]?></td>
            <td><select name="branchID" id="branchID">
                <?
              		for ($i=0;$i<count($shop_array);$i++){
              	   ?><option value="<?=$shop_array[$i]?>" <? if($returnrow["branchID"]==$shop_array[$i]) {echo "selected";}?>><?=$shop_array[$i]?></option>	
              	   <?
              		}
              		?>
              </select>           </td>
          </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#6699CC">
            <td width="5%"><span class="style6">行數</span></td>
            <td width="20%"><span class="style6">貨品編號</span></td>
            <td width="10%"><span class="style6">數量</span></td>
            <td width="30%"><span class="style6">項目</span></td>
            <td width="10%"><span class="style5"><span class="style6">單價</span></span></td>
            <td width="7%" class="style6">折扣</td>
            <td width="4%"><span class="style6"><strong>金額</strong></span></td>
            </tr>
<?$elements_counter=4;
$i=0;
        $tab=0;
while($goods_returnrow = $goods_returnresult->fetchRow(DB_FETCHMODE_ASSOC))          
	{
	    if ( $goods_partno==$goods_returnrow['goods_partno']) {
      $bgcolor="#CCFF##";
    } else {
    	$bgcolor="#CCCCCC";}   

	?>
          <tr bgcolor="<?=$bgcolor?>">
            <td><div align="center"><?=$i+1?></div></td>
            <td><input  name="goods_partno[]" type="text" id="goods_partno<?echo $i;?>" value="<? echo $goods_returnrow['goods_partno']; ?>" tabindex="<?$tab++;echo $tab?>" size="10" maxlength="10"  />
            <input type=button name="search" value=".." onClick="javascript:AddrWindow(<?echo $elements_counter;$elements_counter=$elements_counter+7;?>)" >
            <input name="action<?=$i?>" type="button" id="action<?=$i?>"  value="?" /></td>
            <td><input name="qty[]" type="text" id="qty<?echo $i;?>"  onFocus="javascript:document.getElementById('action<?=$i?>').click();" tabindex="<?$tab++;echo $tab?>"  value="<? echo $goods_returnrow['qty']; ?>" size="7" maxlength="7"></td>
                       <td><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<?echo $i;?>" value="<? echo $goods_returnrow['goods_detail']; ?>" size="35" maxlength="40">
            </div></td>
			 <td><div align="center">
			   <input name="market_price[]" type="text" id="market_price<?echo $i;?>" tabindex="<?$tab++;echo $tab?>" value="<? echo $goods_returnrow['market_price']; ?>" size="6" maxlength="6">
			 </div></td>
            <td><div align="center"><input name="discount[]" type="text" id="discount<?echo $i;?>" tabindex="<?$tab++;echo $tab?>" value="<? echo $goods_returnrow['discount']; ?>"  size="8" maxlength="8" /></div></td>
            <td><input name="subtotal[]" type="text" tabindex="<?$tab++;echo $tab?>" id="subtotal<?echo $i;?>"  value="<? echo $goods_returnrow['subtotal']; ?>"  size="8" maxlength="8" onfocus="javascipt:countSubTotal(<?=$i?>)"/></td>
            </tr>
		   <script type="text/javascript">
		<?
			pat_updateField(array(
			'baseUrl'=>''.$callajax.'',
			'parameters'=>'action=updatefield&mph={goods_partno'.$i.'}&num='.$i.'',
			'action'=>"action$i",
			'target'=>'goods_detail'.$i.'',
			'source'=>"goods_partno$i",
		));
		?>
		</script>
<?
$i++;
}
for ($y=$i;$y<$returnRecord;$y++)
{
?>
    <tr bgcolor="#CCCCCC">
            <td><div align="center"><?=$y+1?></div></td>
            <td><input  name="goods_partno[]" type="text" id="goods_partno<?echo $y;?>" value="" tabindex="<?$tab++;echo $tab?>" size="10" maxlength="10"  />
            <input type=button name="search" value=".." onClick="javascript:AddrWindow(<?echo $elements_counter;$elements_counter=$elements_counter+7;?>)" >
            <input name="action<?=$i?>2" type="button" id="action<?=$y?>"  value="?" /></td>
            <td><input  name="qty[]" type="text" id="qty<?echo $y;?>" onFocus="javascript:document.getElementById('action<?=$y?>').click();" tabindex="<?$tab++;echo $tab?>"  value="0" size="7" maxlength="7"></td>
                       <td><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<?echo $y;?>" value="" size="35" maxlength="40">
            </div></td>
			 <td><div align="center">
			   <input name="market_price[]" type="text" id="market_price<?echo $y;?>" tabindex="<?$tab++;echo $tab?>" value="0" size="6" maxlength="6">
			 </div></td>
            <td>
              <div align="center">
                <input name="discount[]" type="text" id="discount<?echo $y;?>"  tabindex="<?$tab++;echo $tab?>" value="0"  size="8" maxlength="8" />
              </div></td>
            <td><input name="subtotal[]" type="text" id="subtotal<?echo $y;?>" tabindex="<?$tab++;echo $tab?>" onfocus="javascipt:countSubTotal(<?=$y?>)"  value="0"  size="8" maxlength="8" /></td>
            </tr>
		   <script type="text/javascript">
		<?
			pat_updateField(array(
			'baseUrl'=>''.$callajax.'',
			'parameters'=>'action=updatefield&mph={goods_partno'.$i.'}&num='.$i.'',
			'action'=>"action$i",
			'target'=>'goods_detail'.$i.',market_price'.$i.'',
			'source'=>"goods_partno$i",
		));
		?>
		</script>
<?}
?>
          
        
            
        </table>
          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#6699CC">
            <tr>
              <td width="7%"><span class="style6"><strong>備註欄</strong></span></td>
              <td width="1%" ><label></label></td>
              <td><textarea name="remark" cols="65" rows="2" id="remark"><? echo $returnrow['remark']; ?></textarea></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="right" class="style6"><strong>總數 : </strong></div></td>
              <td><input name="count_price" type="text" class="disabled" id="count_price" value="<? echo $returnrow['count_price']; ?>" size="10" /></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="right" class="style6"><strong>折扣 : </strong></div></td>
              <td><input name="sub_discount" type="text" class="disabled" id="sub_discount" value="<? echo $returnrow['discount_percent']; ?>" size="10" /></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td width="67%"><div align="right"><span class="style6">
              <input name="button" type="button" id="button" value="暫計" onclick="javascript:count_total()"/>
            </span></div></td>
              <td width="14%"><div align="right" class="style6"><strong>應付金額 : </strong></div></td>
              <td width="10%"><input name="total_price" type="text" class="disabled" id="total_price" value="<? echo $returnrow['total_price']; ?>" size="10" /></td>
              <td width="1%"></td>
            </tr>
          </table>          </td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height=""><input type="hidden" name="update" value="3" /><input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" /></td>
        <td><input name="clear" type="reset" id="clear" value="清除">
          <input name="submitb" type="submit" id="submitb" value="更新記錄" >
          <label></label></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<script type="text/javascript">
first_text_box_focus();
  Calendar.setup(
    {
      inputField  : "return_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
</script>
</body></html>

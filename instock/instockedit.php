<?php 
  $callajax="/instock/sampleAjaxServer.php";
  require_once("./include/config.php");
  include_once ('./include/ajax/phpAjaxTags.inc.php'); 
  pat_Js(array('jsPath'=>'./include/ajax/js'));
  $instockRecord=18;


	
// Sql Connection
	$connection = DB::connect($dsn);
	if (DB::isError($connection))
		die($connection->getMessage());
		
//get Supplier name
	$sql="SELECT * FROM supplier";
	$result = $connection->query("SET NAMES 'UTF8'");
	$supplierResult = $connection->query($sql);

//get Staff name

	$sql="SELECT * FROM staff";
	$staffResult = $connection->query($sql);
	
//get instock

	$sql="SELECT * FROM instock where instock_no=$instock_no";
	$instockresult = $connection->query($sql);
	$instockrow = $instockresult->fetchRow(DB_FETCHMODE_ASSOC);

//get instock_goods

	$sql="SELECT * FROM goods_instock where instock_no=$instock_no";
	$instockresult = $connection->query($sql);


	?> 
<link href="./include/instock.css" rel="stylesheet" type="text/css">
 <style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/instock.js"></script>
</head>
<form action="/?page=instock&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="940" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CCCC">

  <tr>
    <td height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006666"><span class="style6">修改入倉單</span></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%"></td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666">
            <td height="21"><label><span class="style6">入倉單編號 :</span> </label></td>
            <td colspan="2"><label><span class="style6"><?php echo $instockrow['instock_no']; ?></span><input type="hidden" name="instock_no" value="<?=$instockrow['instock_no'];?>"> </label></td>
            <td width="29%">&nbsp;</td>
          </tr>
          <tr bgcolor="#006666">
            <td width="14%" height="21">
                <span class="style6"> <span class="style5">發票</span>日期 ：</span></td>
            <td width="40%"><input name="instock_date" type="text" id="instock_date" value="<? echo $instockrow['instock_date']; ?>">
              <input name="cal" id="calendar" value=".." type="button" /></td>
            <td width="17%"><span class="style6">職員 : <?=$instockrow['staff_name']?>*</span></td>
            <td><select name="staff_name" id="staff_name">
              <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
			  
			  	if ($row['name']==$instockrow['staff_name'])
				echo "<option value=\"".$row['name']."\" selected>".$row['name']."</option>";
				else
                echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
				}?>
            </select></td>
          </tr>
          <tr bgcolor="#006666">
            <td><span class="style6">供應商 ：</span></td>
            <td>
              <select name="supplier_name" id="supplier_name">
			  <?php while ($row = $supplierResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
				if ($row['supplier_name']==$instockrow['supplier_name'])
				echo "<option value=\"".$row['supplier_name']."\" selected>".$row['supplier_name']."</option>";
				else
                echo "<option value=\"".$row['supplier_name']."\">".$row['supplier_name']."</option>";
				}?>
                </select>			</td>
            <td><span class="style6">供應商發票編號：</span></td>
            <td><input name="supplier_invoice_no" type="text" id="supplier_invoice_no" value="<? echo $instockrow['supplier_invoice_no']; ?>" /></td>
          </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#006666">
            <td width="5%"><span class="style6">行數</span></td>
            <td width="20%"><span class="style6">貨品編號</span></td>
            <td width="10%"><span class="style6">數量</span></td>
            <td width="30%"><span class="style6">項目</span></td>
            <td width="10%"><span class="style5"><span class="style6">單價</span></span></td>
            <td width="7%" class="style6">折扣</td>
            <td width="4%"><span class="style6"><strong>金額</strong></span></td>
            <td width="4%" class="style6"><div align="center"><strong>行送</strong></div></td>
          </tr>
<?$elements_counter=4;
$i=0;
$tab=0;
$bgcolor="#CCCCCC";
while($goods_instockrow = $instockresult->fetchRow(DB_FETCHMODE_ASSOC))          
	{
	//20090409
    //add goods_partno searching caiteria
    if ( ( preg_match("/".$goods_detail."/", $goods_instockrow['goods_detail'], $matches) && $goods_detail!="" ) || $goods_partno==$goods_instockrow['goods_partno'] || (preg_match("/".$goods_partno2."/", $goods_instockrow['goods_partno'], $matches)  && $goods_partno2!="") || $market_price == $goods_instockrow['market_price'])
    {
      $bgcolor="#CCFF##";
    } else {
    	$bgcolor="#CCCCCC";
    }   
	?>
          <tr bgcolor="<?=$bgcolor?>">
            <td><div align="center"><?=$i+1?></div></td>
            <td><input  name="goods_partno[]" type="text" id="goods_partno<?echo $i;?>" value="<? echo $goods_instockrow['goods_partno']; ?>" tabindex="<?$tab++;echo $tab?>" size="15" maxlength="30"  />
            <input type=button name="search" value=".." onClick="javascript:AddrWindow(<?echo $elements_counter;$elements_counter=$elements_counter+7;?>)" >
            <input name="action<?=$i?>" type="button" id="action<?=$i?>"  value="?" /></td>
            <td><input name="qty[]" type="text" id="qty<?echo $i;?>"  onFocus="javascript:document.getElementById('action<?=$i?>').click();" tabindex="<?$tab++;echo $tab?>"  value="<? echo $goods_instockrow['qty']; ?>" size="7" maxlength="7"></td>
                       <td><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<?echo $i;?>" value="<? echo htmlspecialchars($goods_instockrow['goods_detail']); ?>" size="35" maxlength="40">
            </div></td>
			 <td><div align="center">
			   <input name="market_price[]" type="text" id="market_price<?echo $i;?>" tabindex="<?$tab++;echo $tab?>" value="<? echo $goods_instockrow['market_price']; ?>" size="6" maxlength="6">
			 </div></td>
            <td><div align="center"><input name="discount[]" type="text" id="discount<?echo $i;?>" tabindex="<?$tab++;echo $tab?>" value="<? echo $goods_instockrow['discount']; ?>"  size="8" maxlength="8" /></div></td>
            <td><input name="subtotal[]" type="text" tabindex="<?$tab++;echo $tab?>" id="subtotal<?echo $i;?>"  value="<? echo $goods_instockrow['subtotal']; ?>"  size="8" maxlength="8" onfocus="javascipt:countSubTotal(<?=$i?>)"/></td>
            <td><?php if ($goods_instockrow['deductstock']=='N'){ ?>
              <input name="deductStockX[]" type="checkbox" id="deductStockX<?echo $i;?>" value="N" onClick="javascript:clickCheckBoxDeductStock(<?echo $i;?>)" checked/>
			  <input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="N"/>
			  <?php }else{?>
			  <input name="deductStockX[]" type="checkbox" id="deductStockX<?echo $i;?>" value="Y" onClick="javascript:clickCheckBoxDeductStock(<?echo $i;?>)">
			  <input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="Y"/>
			  <?php }?></td>
          </tr>
		   <script type="text/javascript">
		<?
			pat_updateField(array(
			'baseUrl'=>''.$callajax.'',
			'parameters'=>'action=updatefield&mph={goods_partno'.$i.'}&num='.$i.'',
			'action'=>"action$i",
				'target'=>'goods_detail'.$i.',market_price'.$i.'',
//			'target'=>'goods_detail'.$i.'',
			'source'=>"goods_partno$i",
		));
		?>
		</script>
<?
$i++;
}
for ($y=$i;$y<$instockRecord;$y++)
{
?>
    <tr bgcolor="#CCCCCC">
            <td><div align="center"><?=$y+1?></div></td>
            <td><input  name="goods_partno[]" type="text" id="goods_partno<?echo $y;?>" value="<? echo $goods_instockrow['goods_partno']; ?>" tabindex="<?$tab++;echo $tab?>" size="15" maxlength="30"  />
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
            <td><input name="deductStockX[]2" type="checkbox" id="deductStockX[]" value="N" onclick="javascript:clickCheckBoxDeductStock(<?echo $i;?>)" /></td>
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
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#006666">
            <tr>
              <td width="7%"><span class="style6"><strong>備註欄</strong></span></td>
              <td width="1%" ><label></label></td>
              <td><textarea name="remark" cols="65" rows="2" id="remark"><? echo $instockrow['remark']; ?></textarea></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="right" class="style6"><strong>總數 : </strong></div></td>
              <td><input name="count_price" type="text" class="disabled" id="count_price" value="<? echo $instockrow['count_price']; ?>" size="10" /></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td><div align="right" class="style6"><strong>折扣 : </strong></div></td>
              <td><input name="sub_discount" type="text" class="disabled" id="sub_discount" value="<? echo $instockrow['discount_percent']; ?>" size="10" /></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td width="67%"><div align="right"><span class="style6">
              <input name="button" type="button" id="button" value="暫計" onclick="javascript:count_total()"/>
            </span></div></td>
              <td width="14%"><div align="right" class="style6"><strong>應付金額 : </strong></div></td>
              <td width="10%"><input name="total_price" type="text" class="disabled" id="total_price" value="<? echo $instockrow['total_price']; ?>" size="10" /></td>
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
      inputField  : "instock_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
</script> 

<?php
  $callajax="/return/sampleAjaxServer.php";
  require_once("./include/config.php");
  include_once ('./include/ajax/phpAjaxTags.inc.php'); 
  pat_Js(array('jsPath'=>'./include/ajax/js'));
  $returnRecord=10;


	
//get Staff name
	$connection = DB::connect($dsn);
	if (DB::isError($connection))
		die($connection->getMessage());
		 $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
	$sql="SELECT * FROM staff";
	$staffResult = $connection->query($sql);
	
?>
 <style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/return.js"></script>
<link href="./include/return.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style11 {font-size: xx-small}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>

 </head>
<body onload="">
<form action="/?page=return&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="900" height="412" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ACC7FF">

  <tr>
    <td height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#6699CC" ><span class="style6">退貨單</span></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666" >
            <td width="20%" height="21" bgcolor="#6699CC">
                <span class="style6"> <span class="style5">退貨單</span>日期 ：</span></td>
            <td width="28%" bgcolor="#6699CC" ><input name="return_date" type="text" id="return_date" value="">
              <input name="cal" id="calendar" value=".." type="button"></td>
            <td width="17%" bgcolor="#6699CC" ><span class="style6">職員 : </span></td>
            <td width="35%" bgcolor="#6699CC" ><select name="staff_name" id="staff_name">
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
            <td bgcolor="#6699CC" ><span class="style6">YRT發票編號：</span></td>
            <td bgcolor="#6699CC" ><input name="invoice_no" type="text" id="invoice_no" /></td>
            <td bgcolor="#6699CC" ><span class="style6">客戶名稱：</span></td>
            <td bgcolor="#6699CC"><input name="customer_name" type="text" id="customer_name" /></td>
          </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#006666">
            <td width="6%" bgcolor="#6699CC"><span class="style6">行數</span></td>
            <td width="24%" bgcolor="#6699CC"><span class="style6">貨品編號</span></td>
            <td width="7%" bgcolor="#6699CC"><span class="style6">數量</span></td>
            <td width="30%" bgcolor="#6699CC"><span class="style6">項目</span></td>
            <td width="8%" bgcolor="#6699CC"><span class="style5"><span class="style6">單價</span></span></td>
            <td width="5%" bgcolor="#6699CC" class="style6">折扣</td>
            <td width="11%" bgcolor="#6699CC" class="style6">金額</td>
            </tr>
<?$elements_counter=4;

        
for ($i=0;$i<$returnRecord;$i++)          
{
	?>
          <tr bgcolor="#CCCCCC">
            <td><div align="center"><?= $i+1; ?></div></td>
            <td><input name="goods_partno[]" type="text" id="goods_partno<? echo $i; ?>" size="15" maxlength="30" tabindex="<?$tab++;echo $tab?>" onKeyPress="next_text_box(event,'qty<?=$i;?>')" />
            <input type=button name="search" value=".." onclick="javascript:AddrWindow('<?=$i; ?>')" >
            <input name="action<?=$i?>" type="button" id="action<?=$i?>"  value="?"></td>
            <td><input name="qty[]" type="text" id="qty<? echo $i; ?>" onFocus="javascript:document.getElementById('action<?=$i?>').click();" value="1" size="7" maxlength="7" tabindex="<?$tab++;echo $tab?>" onKeyPress="next_text_box(event,'goods_partno<?=$i+1;?>');"></td>
                       <td><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<? echo $i; ?>" size="35" maxlength="40">
            </div></td>
			 <td><div align="center">
			   <input name="market_price[]" type="text" tabindex="<?$tab++;echo $tab?>" id="market_price<? echo $i; ?>" value="0" size="7" maxlength="7">
			 </div></td>
            <td><input name="discount[]" type="text" id="discount<? echo $i; ?>" tabindex="<?$tab++;echo $tab?>" value="0" size="3" maxlength="3" /></td>
            <td><input name="subtotal[]" type="text" id="subtotal<? echo $i; ?>" tabindex="<?$tab++;echo $tab?>"  onfocus="javascipt:countSubTotal(<?=$i?>)" value="0"  size="10" maxlength="10"/></td>
            </tr>
        <script type="text/javascript">
		<?
			pat_updateField(array(
			'baseUrl'=>''.$callajax.'',
			'parameters'=>'action=updatefield&mph={goods_partno'.$i.'}&num='.$i.'',
			'action'=>"action$i",
			'target'=>'goods_detail'.$i.',market_price'.$i.'',
			//'target'=>'goods_detail'.$i.'',
			'source'=>"goods_partno$i",
		));
		?>
		</script>
<?}?>
          
        
            
        </table>
          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#6699CC">
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
              <td width="7%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
              <td width="7%">&nbsp;</td>
            <td width="51%"><div align="right"><span class="style6">
            <input name="button" type="button" id="button" value="暫計" onclick="javascript:count_total()"/>
            </span></div></td>
              <td width="12%"><div align="right" class="style6">                應退金額 : </div></td>
              <td width="13%"><input name="total_price" type="text" class="disabled" id="total_price" value="0" size="10" /></td>
              <td width="0%"></td>
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
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table><?
for ($i=0;$i<$returnRecord;$i++)
 {?>

<input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="Y"/>

<? }?>
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
 
<?
//get name
require_once("./include/config.php");
require_once("./include/functions.php");

$invoiceRecord=17;
$totalcounter=0;
//count input

for ($i=0;$i<$invoiceRecord;$i++)
{
	if ($width[$i]!="")
	$totalcounter++;
}

//correct time slot to del date 20151231

	$delivery_date=correct_delTimeSlot_to_delDate($delivery_date,$delivery_timeslot);
 

   $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result))
      die ($result->getMessage());
  
 
	 
?>
 
<script language="javascript">
function first_text_box_focus()
{
	document.form1.elements[0].focus();
}

function next_text_box(a)
{
	if (event.keyCode==13)
	{
	//alert(a);
	eval("document.form1.elements["+a+"].focus();");
	//alert(event.keyCode);
	return false;
	}

}

function AddrWindow(toccbcc){
	///var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	window.open('page_search_partno.php?recid=' + toccbcc,"","width=500,height=360,scrollbars=yes");
}
function checkform(i)
{
	if (i==1)
	{	
	document.form1.act.value=1;
	}
	else if (i==2)
	{
	document.form1.act.value=2;
	}
	
       document.form1.submit();
}
</script>
<script type="text/javascript" src="./include/invoice.js"></script>

<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
<form name="form1" id="form1" action="/?page=invoice_scrap&subpage=invoice_scrap_edit3.php" method="POST">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td width="801" align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="19%" height="21" bgcolor="#004d80"><span class="style6">出貨單</span></td>
        <td width="29%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80">
            <td width="14%" height="21">
                <span class="style6"> 發票日期： </span>            </td>
            <td width="35%"><span class="style6"><?echo $invoice_date;?></span></td>
            <td width="16%"><span class="style6">送貨日期：</span></td>
            <td width="35%"><span class="style6"><?echo $delivery_date;?></span></td>
          </tr>
		    <tr bgcolor="#004d80">
            <td width="14%" height="21"></td>
            <td width="35%"><span class="style6"></span></td>
            <td width="16%"><span class="style6">送貨時間：</span></td>
            <td width="35%"><span class="style6"><?php
			if ($delivery_timeslot==1) echo "早 9-12";
			if ($delivery_timeslot==2) echo "午 12-2";
			if ($delivery_timeslot==3) echo "晚  2-6";
			?></span></td>
          </tr>
          <tr bgcolor="#004d80">
            <td><span class="style6">員工姓名：</span></td>
            <td><span class="style6"><?echo $sales;?></span></td>
            <td><span class="style6">送貨：</span></td>
            <td><span class="style6"><?if ($delivery=="Y") {echo "是";}else if($delivery=="S") {echo "自取";} else {echo "街車送貨";}?></span></td>
          </tr>
          <tr bgcolor="#004d80">
            <td height="23"><span class="style6">客戶名稱：</span></td>
            <td height="23"><span class="style6"><?echo $mem_name;?></span></td>
            <td height="23"><span class="style6">收貨人：</span></td>
            <td height="23"><span class="style6"><?echo $receiver;?></span></td>
          </tr>
          <tr bgcolor="#004d80">
            <td height="24"><span class="style6">客戶地址：</span></td>
            <td height="24"><span class="style6"><?echo $mem_add;?></span></td>
            <td height="24" class="style6">客戶編號：</td>
            <td height="24"><span class="style6"><?echo $mem_id;?></span></td>
          </tr>
          <tr bgcolor="#004d80">
            <td height="24"><span class="style6">入賬日期：</span></td>
            <td height="24"><span class="style6"><?=$settledate?></span></td>
            <td height="24" class="style6">&nbsp;</td>
            <td height="24"><span class="style6">
              <?if ($status=="A"){echo "入賑";}else if ($status=="S"){echo "掛單";} else {echo "訂金";};?>
            </span></td>
          </tr>
		  <tr bgcolor="#004d80">
            <td height="24"><span class="style6"> </span></td>
            <td height="24"><span class="style6"></span></td>
            <td height="24" class="style6">尺寸計法:&nbsp;</td>
            <td height="24"><span class="style6"><?php if($cal_unit=='in') echo "吋" ; else echo "毫米"; ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
            <tr bgcolor="#004d80">
            <td width="4%"><span class="style6">行數</span></td>
            <td width="7%"><span class="style6">現貨膠板</span></td>
            <td width="7%"><span class="style6">濶</span></td>
            <td width="7%"><span class="style6">高</span></td>
            
			 <td width="6%"><span class="style6">數量
             
            </span></td>
			<td width="9%"><span class="style6"><span class="style6">單價</span></span></td>
			<td width="9%"><span class="style6"><span class="style6">總金</span></span></td>
          </tr>
		  <? 
		  $total_price=0.00;
		  for($i=0;$i<$totalcounter;$i++)
		  {?>
          <tr bgcolor="#CCCCCC">
            <td><span class="style7"><?echo $i+1;?></span></td>
		 
            <td><span class="style7"><?echo $partno[$i];?></span></td>
            
            <td><span class="style7"><?echo $width[$i];?></span></td>
            <td><span class="style7"><?echo $height[$i];?></span></td>
            
            <td><span class="style7"><?echo $qty[$i];?></span></td>
			<td><span class="style7"><?echo $unit_price[$i];?></span></td>
          <td><span class="style7"><?echo $subtotal[$i];?></span></td>
          </tr>
		  <?
		  $total_price=$total_price+$subtotal[$i];
		  }
	
		  ?>
        </table>          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#004d80">
            <tr>
              <td width="16%">&nbsp;</td>
              <td width="13%">&nbsp;</td>
              <td width="15%">&nbsp;</td>
            <td width="39%">&nbsp;</td>
              <td width="8%">&nbsp;</td>
              <td width="9%">&nbsp;</td>
            </tr>
				<tr bgcolor="#CCCCCC"><td colspan='3'></td><td><div align="right"><span class="style7">合計</span><span class="style7">：</span></div></td>
				  <td colspan="4"><div align="left" class="style7">$<?php echo number_format($total_price, 2, '.', ',');?></div></td>
			    </tr>
		  
			 
			 <tr bgcolor="#CCCCCC"><td colspan='3'></td><td><div align="right"><span class="style7">總折扣</span><span class="style7">：</span></div></td>
			   <td colspan="4"><div align="left" class="style7">減<?php echo $subdiscount;?>% 減<?php echo number_format($subdeduct, 2, '.', ',');?>元 </div></td>
			   </tr>
			 <tr bgcolor="#CCCCCC">
			   <td height="23" colspan='3'></td>
			   <td align="right" class="style7">訂金：</td>
			   <td colspan="4"><span class="style7">$<?
		$subsubtotal=($total_man_power_price+$total_price)*(100-$subdiscount)/100-$subdeduct;
//20060426
		if ($status=="A"|| $status=="D")
{
 echo number_format($subsubtotal, 2, '.', ',');
  }else{
		 echo number_format($deposit, 2, '.', ',');
		 }
			  
			   ?></span></td>
			   </tr>
			 <tr bgcolor="#CCCCCC">
			   <td height="23" colspan='3'></td>
			   <td align="right" class="style7">信用卡：</td>
			   <td colspan="4">
			     <div align="left"><span class="style7">
			       $<?
		   $creditcardtotal=0;
			$creditcardrate=0;
		 if ($creditcard=="on"){
		 			$creditcardrate=1.5;
		 			$creditcardtotal=round($subsubtotal*$creditcardrate/100);
					$subsubtotal=$subsubtotal+$creditcardtotal;
		 }
		echo  number_format($creditcardtotal, 2, '.', ',');

			  
			   ?>
			       <br />
			     </span></div></td>
			   </tr>
			 <tr bgcolor="#CCCCCC">
			   <td height="23" colspan='3'></td>
			   <td align="right"><span class="style7">總合計</span><span class="style7">：</span></td>
			   <td colspan="4"><span class="style7">$<?php
					
				  echo number_format($subsubtotal, 2, '.', ',');
				  ?>
			   </span></td>
			   </tr>
          </table>          </td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td>
          <input type="hidden" name="invoice_no" value="<? echo $invoice_no;?>" />
        <input type="hidden" name="invoice_date" value="<? echo $invoice_date;?>">
        <input type="hidden" name="delivery_date" value="<? echo $delivery_date;?>">
		<input type="hidden" name="delivery_timeslot" value="<? echo $delivery_timeslot;?>">
        <input type="hidden" name="settledate" value="<? echo $settledate;?>">
		<input type="hidden" name="sales" value="<? echo $sales;?>" />
        <input type="hidden" name="mem_id" value="<? echo $mem_id;?>">
        <input type="hidden" name="mem_name" value="<? echo $mem_name;?>">
        <input type="hidden" name="mem_add" value="<? echo $mem_add;?>">
        <input type="hidden" name="mem_tel" value="<? echo $mem_tel;?>">
		<input type="hidden" name="AREA" value="<?echo $AREA;?>" />
		<input type="hidden" name="PC" value="<?echo $PC;?>" />
		<input type="hidden" name="delivery" value="<?echo $delivery;?>" />
			<input type="hidden" name="branchID" value="<?echo $branchID;?>" />
		<input type="hidden" name="cal_unit" value="<?echo $cal_unit;?>" />
        <input type="hidden" name="receiver" value="<?=$receiver?>" />
		<input type="hidden" name="status" value="<?php echo $status?>"/>
        <?php
        for($i=0;$i<$totalcounter;$i++)
        {
        ?>
        
        <input type="hidden" name="partno[<?php echo $i;?>]" value="<? echo $partno[$i];?>">
        <input type="hidden" name="width[<?php echo $i;?>]" value="<? echo $width[$i];?>">
        <input type="hidden" name="height[<?php echo $i;?>]" value="<? echo $height[$i];?>">
        <input type="hidden" name="qty[<?php echo $i;?>]" value="<? echo $qty[$i];?>" />
		<input type="hidden" name="unit_price[<?php echo $i;?>]" value="<? echo $unit_price[$i];?>" />
		<input type="hidden" name="subtotal[<?php echo $i;?>]" value="<? echo $subtotal[$i];?>" />
		
        <?php }?>
	 
		
<?
//20060426
		if ($status=="A")
{
	?>	<input type="hidden" name="deposit" value="<?=$subsubtotal?>"/>
		<? }else{?>
		<input type="hidden" name="deposit" value="<?=$deposit?>"/>
<? }?>
		<input type="hidden" name="creditcardtotal" value="<?=$creditcardtotal?>"/>
   		<input type="hidden" name="creditcardrate" value="<?=$creditcardrate?>"/>
		<input type="hidden" name="subsubtotal" value="<?=$subsubtotal?>"/>
		<input type="hidden" name="subdiscount" value="<? echo $subdiscount;?>" />
		<input type="hidden" name="subdeduct" value="<? echo $subdeduct;?>" />
 
        <input name="clear" type="reset" id="clear" value="上一步" onClick="history.back(1);">
        <input name="submitb" type="submit" id="submitb" value="送出">
		<input name="print" type="hidden" id="print" value="">
		<input type="button" value="出3色單" onclick="print3color();">
		</td>
      </tr>
    </table></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

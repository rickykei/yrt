<?
$invoiceRecord=16;
$totalcounter=0;
//count input
for ($i=0;$i<$invoiceRecord;$i++)
{
	if ($goods_partno[$i]!="")
	$totalcounter++;
}
 
require_once("./include/config.php");
require_once("./include/functions.php");


//20160825 remove del_timeslot when delivery="w"
if ($delivery=='W')
{$delivery_timeslot=0;
$delivery_date='';}

//correct time slot to del date 20151211

$delivery_date=correct_delTimeSlot_to_delDate($delivery_date,$delivery_timeslot);

//correct time slot to del date 20151211

   $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());

	$total_man_power_price=0;

	for ($i=0;$i<$totalcounter;$i++)
	{
		$query="select * from sumgoods where goods_partno='".$goods_partno[$i]."'";
		$result=$connection->query($query);
		if (DB::isError($result)) die ($result->getMessage());
	    $row = $result->fetchRow(DB_FETCHMODE_ASSOC);

		//20060409 trim special char from input
		$goods_detail[$i]=htmlspecialchars(stripslashes($goods_detail[$i]));
		if ($goods_detail[$i]=="")
		$goods_detail[$i]=$row["goods_detail"];
		if ($market_price[$i]=="")
		$market_price[$i]=$row["market_price"]; 
	
	
		 
		$query2="select IFNULL(sum(qty),0) as qty from goods_invoice, invoice where invoice.invoice_no= goods_invoice.invoice_no and goods_partno='".$goods_partno[$i]."'
		and sales_name='".$sales."' and invoice.settledate >='".$delivery_date." 00:01' and invoice.settledate <='".$settledate." 23:59'";
 
		$result=$connection->query($query2);
		if (DB::isError($result)) die ($result->getMessage());
	    $row2 = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$qty[$i]=$row2["qty"]; 
		 
		
	} 
	
	 
?>  

<script language="javascript">


 
  
</script>
<script type="text/javascript" src="../include/bonus.js?20230927"></script>
<link href="../include/invoice.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>

<form id="form1" name="form1" action="/?page=invoice&subpage=index3.php" method="POST">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  
  <tr>
    <td width="4" height="">&nbsp;</td>
    <td width="801" align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="19%" height="21" bgcolor="#004d80"><span class="style6">出貨單</span></td>
        <td width="29%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4">
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80"> <td height="24"><span class="style6">由日期：</span></td>
            <td height="24"><span class="style6"><?=$delivery_date?></span></td>
           
            <td width="16%"><span class="style6">至日期：</span></td>
            <td width="35%"><span class="style6"><?echo $settledate;?></span></td>
          </tr>
		     
         
          <tr bgcolor="#004d80">
            <td><span class="style6">員工姓名：</span></td>
            <td><span class="style6"><?echo $sales;?></span></td>
              <td width="16%"> </td>
            <td width="35%"> </td>
          </tr>
         
		   
          
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#004d80">
            <td width="5%"><span class="style6">行數</span></td>
            <td width="24%" class="style6">貨品編號</td>
            <td width="32%" class="style6">項目</td>
            <td width="5%" class="style6">賣出數量</td>
            <td width="13%" class="style6">佣</td>
            <td width="4%" class="style6">總計</td>
            
         
          </tr>
		  <? 
		  $total_price=0;
		  for($i=0;$i<$totalcounter;$i++)
		  {?>
          <tr bgcolor="#CCCCCC">
            <td><span class="style7"><?echo $i+1;?></span></td>
            <td><span class="style7"><?echo $goods_partno[$i];?></span></td>
            <td><span class="style7"><?echo $goods_detail[$i];?></span></td>
            <td><span class="style7"><?echo number_format($qty[$i]);?></span></td>
            <td><span class="style7">$<?echo $market_price[$i];?></span></td>
           
          <td><span class="style7"><?$subtotal[$i]=$market_price[$i]*$qty[$i];echo "$".number_format($subtotal[$i], 2, '.', ', ');?></span></td>
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
				 
			 
			 
			 
			 <tr bgcolor="#CCCCCC">
			   <td height="23" colspan='3'></td>
			   <td align="right"><span class="style7">總合計</span><span class="style7">：</span></td>
			   <td colspan="4"><span class="style7">$<?php
					
				  echo number_format($total_price, 2, '.', ',');
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
        
        <input type="hidden" name="invoice_date" value="<? echo $invoice_date;?>">
        <input type="hidden" name="delivery_date" value="<? echo $delivery_date;?>">
 
        <input type="hidden" name="settledate" value="<? echo $settledate;?>">
		<input type="hidden" name="sales" value="<? echo $sales;?>" />
       
		<input type="hidden" name="AREA" value="<?echo $AREA;?>" />
		<input type="hidden" name="PC" value="<?echo $PC;?>" />
		 
		
        <?php
        for($i=0;$i<$totalcounter;$i++)
        {
        ?>
        <input type="hidden" name="goods_partno[]" value="<? echo $goods_partno[$i];?>">
        <input type="hidden" name="goods_detail[]" value="<? echo $goods_detail[$i];?>">
        <input type="hidden" name="qty[]" value="<? echo $qty[$i];?>">
        <input type="hidden" name="market_price[]" value="<? echo $market_price[$i];?>">
 
        <input type="hidden" name="subtotal[]" value="<? echo $subtotal[$i];?>">
		< 
        <?php }?>
		
		<input type="hidden" name="status" value="<?=$status?>"/>
<?
//20060426
		if ($status=="A")
{
	?>	<input type="hidden" name="deposit" value="<?=$subsubtotal?>"/>
		<? }else{?>
		<input type="hidden" name="deposit" value="<?=$deposit?>"/>
<? }?>
		<input type="hidden" name="deposit_method" value="<?=$deposit_method?>"/>
 
		<input type="hidden" name="subsubtotal" value="<?=$subsubtotal?>"/>
 
		<input type="hidden" name="subdeduct" value="<? echo $subdeduct;?>" />
 
        <input name="clear" type="button" id="clear" value="上一步" onClick="history.back(1);;">
		
   
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
 

<?
 
$totalcounter=0;
//count input
 
 
require_once("./include/config.php");
require_once("./include/functions.php");

 
//correct time slot to del date 20151211

$delivery_date=correct_delTimeSlot_to_delDate($delivery_date,$delivery_timeslot);

//correct time slot to del date 20151211

   $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
 
 
 // for admin view
if ($sales=='ALL'){
		$query2="select IFNULL(sum( goods_invoice.qty * sumgoods.commission),0) as commission ,invoice.sales_name as sales_name from goods_invoice, invoice,sumgoods 
		where invoice.invoice_no= goods_invoice.invoice_no  
		AND sumgoods.goods_partno = goods_invoice.goods_partno 
		and  invoice.settledate >='".$delivery_date." 00:01' 
		and invoice.settledate <='".$settledate." 23:59' 
		group by invoice.sales_name ";
		$result=$connection->query($query2);
		if (DB::isError($result)) die ($result->getMessage());
 
		$i=0;
		while( $row2 = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			$commission[$i]=$row2["commission"]; 
			$sales_name[$i]=$row2["sales_name"];
			$i++;
		}
 
}else{
	 //staff view
		$query2="select IFNULL(sum(qty),0) as qty ,goods_invoice.goods_partno from goods_invoice, invoice where invoice.invoice_no= goods_invoice.invoice_no  
		and sales_name='".$sales."' and invoice.settledate >='".$delivery_date." 00:01' and invoice.settledate <='".$settledate." 23:59' group by goods_invoice.goods_partno ";
 
		$result=$connection->query($query2);
		if (DB::isError($result)) die ($result->getMessage());
	    
		$i=0;
		while( $row2 = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			$qty[$i]=$row2["qty"]; 
			$goods_partno[$i]=$row2["goods_partno"];
			$i++;
		}
		 
		for ($j=0;$j<$i;$j++) {
		$query="select commission,goods_detail from sumgoods where goods_partno='".$goods_partno[$j]."'";
		$result=$connection->query($query);
		if (DB::isError($result)) die ($result->getMessage());
			
			while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
				$goods_detail[$j]=htmlspecialchars(stripslashes($row['goods_detail']));
				$commission[$j]=$qty[$j]*$row['commission'];
			}
		}
	 
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
        <td width="19%" height="21" bgcolor="#004d80"><span class="style6">貨品花紅計算</span></td>
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
	  
	  <?php if ($sales!='ALL'){ ?>
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
		  for($i=0;$i<$j;$i++)
		  {
			  if ($commission[$i]!=0){?>
          <tr bgcolor="#CCCCCC">
            <td><span class="style7"><?echo $i+1;?></span></td>
            <td><span class="style7"><?echo $goods_partno[$i];?></span></td>
            <td><span class="style7"><?echo $goods_detail[$i];?></span></td>
            <td><span class="style7"><?echo number_format($qty[$i]);?></span></td>
            <td><span class="style7">$<?echo $commission[$i];?></span></td>
           
          <td><span class="style7"><?$subtotal[$i]=$commission[$i]*$qty[$i];echo "$".number_format($subtotal[$i], 2, '.', ', ');?></span></td>
          </tr>
		  <?
		  $total_price=$total_price+$subtotal[$i];
			  }
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
      <?php }else{ 
	  //admin view
	  ?>
	   <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#004d80">
            <td width="5%"><span class="style6">行數</span></td>
            <td align="right" class="style6">Sales</td>
            <td class="style6">佣金</td> 
          </tr>
		  <? 
		  $total_price=0;
		  for($j=0;$j<$i;$j++)
		  {?>
          <tr bgcolor="#CCCCCC">
            <td><span class="style7"><?echo $j+1;?></span></td>
            <td align="right"><span class="style7"><?echo $sales_name[$j];?></span></td>
 
            <td><span class="style7">$<?echo $commission[$j];?></span></td>
           
          
          </tr>
		  <?
		  $total_price=$total_price+$commission[$j];
	  }}
	
		  ?><tr bgcolor="#CCCCCC">
			   <td height="23" ></td>
			   <td align="right"><span class="style7">總合計</span><span class="style7">：</span></td>
			   <td ><span class="style7">$<?php
					
				 echo $total_price;
				  ?>
			   </span></td>
			   </tr>
        </table>          </td>
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
 

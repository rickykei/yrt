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
   $result3 = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
 
 
 // for admin view
 
		 
		$query3="select  IFNULL(sum(qty),0) as qty , goods_invoice.goods_partno ,sumgoods.goods_detail as goods_detail from goods_invoice, invoice ,sumgoods where invoice.invoice_no= goods_invoice.invoice_no  AND sumgoods.goods_partno = goods_invoice.goods_partno
		and  invoice.settledate >='".$delivery_date." 00:01' and invoice.settledate <='".$settledate." 23:59' and invoice.settle='A' and sumgoods.commission <> 0  group by   goods_invoice.goods_partno";
		 
	 
		$result3=$connection->query($query3);
		if (DB::isError($result3)) die ($result3->getMessage());
 
		$i=0;
		while( $row3 = $result3->fetchRow(DB_FETCHMODE_ASSOC)){
			$goods_partno[$i]=$row3["goods_partno"]; 
			$qty[$i]=$row3["qty"]; 
			$goods_detail[$i]=$row3["goods_detail"];
			$i++;
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
		     
         
          
		   
          
        </table></td>
      </tr>
	  
	  
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#004d80">
            <td width="5%"><span class="style6">行數</span></td>
            <td width="24%" class="style6">貨品編號 (只顯示有標註佣金的貨品)</td>
            <td width="32%" class="style6">項目</td>
            <td width="5%" class="style6">賣出數量</td>
            
            
            
         
          </tr>
		  <? 
		  $total_price=0;
		  $j=$i;
		  for($i=0;$i<$j;$i++)
		  {
			  ?>
          <tr bgcolor="#CCCCCC">
            <td><span class="style7"><?echo $i+1;?></span></td>
            <td><span class="style7"><?echo $goods_partno[$i];?></span></td>
            <td><span class="style7"><?echo $goods_detail[$i];?></span></td>
            <td><span class="style7"><?echo number_format($qty[$i]);?></span></td>
              
          </tr>
		  <?
		  $total_qty=$total_qty+$qty[$i];
			  
		  }
	
		  ?>
        </table>          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#004d80">
            <tr>
              <td width="">&nbsp;</td>
              <td width="">&nbsp;</td>
              <td width="">&nbsp;</td>
            <td width=""  class="style6" align="right">總合計</td>
              <td width="8%"  class="style6" align="left"><?php  echo $total_qty;  ?></td>
               
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
 

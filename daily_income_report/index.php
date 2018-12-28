<?php
  $invoiceRecord=17;
  require_once("../include/config.php");

	
	//get Staff name
	    $connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
       $query="SET NAMES 'UTF8'";
   

   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
	  
	$month=date("m");
	$year=date("Y");
	$day=date("d");
	
 
	
   function security_check($AREA,$PC){
	if (($AREA=="Y" && $PC=="1")  || ($AREA=="Y" && $PC=="99")){
		
			return TRUE;}
	else{
		
			return FALSE;
		}
	} 
	
 
	$shop_array = array ( $AREA);
 
 
	
	if ($day!="" && $year != ""){
 // $subtotal="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year && DAYOFMONTH(invoice.invoice_date)=$day ";
	//$rows = $connection->query($subtotal);
   //$row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
   //$day_counter=$row['total'];
   
	
	for ($i=0;$i<count($shop_array);$i++){
		$shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.invoice_date)=$month && year(invoice.invoice_date)=$year && DAYOFMONTH(invoice.invoice_date)=$day and branchID='$shop_array[$i]'";
	 $settle_shop_subtotal[$i]="select sum(total_price) as total from invoice where month(invoice.settledate)=$month && year(invoice.settledate)=$year && DAYOFMONTH(invoice.settledate)=$day and branchID='$shop_array[$i]' and settle='A'";
	 $shop_return_total[$i]="select sum(total_price) as total from returngood where month(returngood.return_date)=$month && year(returngood.return_date)=$year && DAYOFMONTH(returngood.return_date)=$day and branchID='$shop_array[$i]'";
	 
		if ($AREA==$shop_array[$i] || security_check($AREA,$PC) ){
			 
			 $rows = $connection->query($shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $shop_counter[$i]=$row['total'];
		   
		    $rows = $connection->query($settle_shop_subtotal[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $settle_shop_subtotal_counter[$i]=$row['total'];
		    $rows = $connection->query($shop_return_total[$i]);
		   $row = $rows->fetchRow(DB_FETCHMODE_ASSOC);
		   $return_shop_total_counter[$i]=$row['total'];
		   
		   $fixAmt=$settle_shop_subtotal_counter[$i]-$return_shop_total_counter[$i];
   }
		
	}



}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<title>收支日報表:</title>
<? // = $ajax->loadJsCore(true) ?>
<style type="text/css">
@import url(../include/cal/calendar-win2k-1.css);
</style>
 
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 
<link href="../include/invoice.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style11 {
	font-size: xx-small
	}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFF;
}
a:visited {
	color: #FFF;
}
a:hover {
	color: #FFF;
}
a:active {
	color: #FFF;
}
-->
</style>
<script>
    $(document).ready(function(){
 
        //iterate through each textboxes and add keyup
        //handler to trigger sum event
        $(".spend_amt , .cheque_amt , #today, #yestarday,#eps, #cashcoupon,#visa" ).each(function() {
 
            $(this).keyup(function(){
                calculateSum();
            });
        });
 
    });
 
    function calculateSum() {
	  
        var sum = 0;
        //iterate through each textboxes and add the values
        $(".spend_amt").each(function() {
 
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sum += parseFloat(this.value);
            }
 
        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#total_expend").val(sum.toFixed(2));
		 sum = 0;
		 $(".cheque_amt").each(function() {
 
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sum += parseFloat(this.value);
            }
 
        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#total_cheque").val(sum.toFixed(2));
		
		$("#inmoney").val($("#shopTotal").val()-$("#total_cheque").val()-$("#total_expend").val()-$("#eps").val()-$("#cashcoupon").val()-$("#visa").val());
		
		
		$("#different").val($("#today").val()-$("#yestarday").val());
    }
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onkeydown="detectKeyBoard(event)">
<form action="/pdf2/daily_income_pdf.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="1200"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CC99">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006633"><span class="style6"><a href="../">收支日報表:</a></span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006633" align="left">
            <td width="80"><span class="style6"> 日期：</span><input name="invoice_date" type="text" id="invoice_date" value="<? echo Date("Y-m-d H:i "); ?>" size="15" maxlength="20" readonly="readonly"></td>
            <td width="136"><span class="style6">總數</span> <input name="shopTotal" id="shopTotal" type="text" value="<?=$fixAmt?>" readonly="readyonly"></td>
          </tr>
         
       
         
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#006633">
            <td width="4%" align="center"><span class="style6">行數</span></td>
            <td width="7%"><span class="style6">什項支出</span></td>
            <td width="7%"><span class="style6">金額 $</span></td>
            <td width="8%"><span class="style6"></span></td>
            <td width="9%"><span class="style6"><span class="style6">銀行</span></span></td>
            <td width="7%"><span class="style6">支票NO.</span></td>
            <td width="5%" class="style6"><div  >金額 $</div></td>
			<td width="6%" class="style6"><div align="center"></div></td>
 
          
          </tr>
<?


$tab=0;        
for ($i=0;$i<$invoiceRecord;$i++)          
{
	?>
          <tr bgcolor="#CCCCCC">
            <td><div align="center"><span class="style7"><?echo $i+1;?></span></div></td>
            <td><input name="spending[]" type="text" id="spending<?echo $i;?>" size="18"   tabindex="<?$tab++;echo $tab?>" onKeyPress="next_text_box(event,'spend_amt<?=$i;?>')"  />
			 
              </td>

            <td><input name="spend_amt[]" class="spend_amt" type="text" id="spend_amt<?echo $i;?>" size="10"   tabindex="<?$tab++;echo $tab?>" onKeyPress="next_text_box(event,'spending<?=$i+1;?>');" onFocus="" ></td>
                       <td>
                   </td>
			 <td><div  >
              <input name="bank[]" type="text" id="bank<?echo $i;?>"   onKeyPress="next_text_box(event,'checkno<?=$i;?>')"  size="20"    />
             </div></td>
            <td><div  >
               <input name="chequeno[]" type="text" id="chequeno<?echo $i;?>"   onKeyPress="next_text_box(event,'market_price<?=$i;?>')"    size="20"  />
            </div></td>
            <td><div  >
               <input name="cheque_amt[]" type="text" class="cheque_amt" id="cheque_amt<?echo $i;?>" onKeyPress="next_text_box(event,'bank<?=$i;?>')"    size="10" maxlength="10"  />
            </div></td>
            <td><div align="center">
               
            </div></td>
           
          </tr>
	 
<?}?>
          
        
            
        </table>          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#006633">
            <tr>
            
             <td width=" "><span class="style6">總支出</span> <input name="total_expend" type="text" id="total_expend"  size="8" readonly="readonly" /></td>
             <td width=" "><span class="style6">支票</span> <input name="total_cheque" type="text" id="total_cheque"  size="8"  readonly="readonly" /></td>
             <td width=" "><span class="style6">VISA</span> <input name="visa" type="text" id="visa"   size="8"   /></td>
             <td width=" "><span class="style6">EPS</span>
  
              <input name="eps" type="text" id="eps" value="0" size="8" >
   
</td>
        <td width="  "><span class="style6">現金券 :
</span>
  
              <input name="cashcoupon" type="text" id="cashcoupon" value="0" size="8"  >
   
</td>
              <td width=" " class="style6">入數 :

                  <input name="deposit" type="text"  id="inmoney" size="10" readonly="readonly" />              </td>
              <td width=" "><span class="style6">是日存柜 :

                
                <input name="today" type="text"  id="today" size="10" />
              </span></td>
              <td  class="style6">昨日存柜 :
                  <input name="yestarday" type="text"  id="yestarday" size="10" /></td>
				  <td  class="style6">差額 :

                  <input name="different" type="text"   id="different" size="10" /></td>
              <td  >
			  
              <td  ><input name="submitb" type="submit" id="submitb" value="送出"  "></td>
            </tr>
          </table>          </td>
      </tr>
    
    </table>     </td>
  </tr>
</table>
<input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" />
 
</form>
</body>
<script type="text/javascript">
 
    
</script></html>

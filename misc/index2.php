<?php

  $invoiceRecord=15;
  $chqRecord=17;
	require_once("./include/config.php");
	require_once("./include/functions.php");
	
 
	
?><META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<? // = $ajax->loadJsCore(true) ?>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/jquery-1.4.1.min.js"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="/misc/misc.js"></script>
<style type="text/css">
 
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
 
 
</style> 
<form action="/?page=misc&subpage=index3.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="800"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#004d80"><span class="style6"><a href="../">收支日報表</a></span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4">
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
			<tr bgcolor="#004d80" class="style6">
            <td width="80">發票日期：</td>
				<td width="136"><? echo $invoice_date; ?></td>
				<td width="136">鋪<? echo $AREA; ?></td>
				<td width="136"></td>
			</tr>
		</table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="2" style="vertical-align: top;">
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#004d80">
            <td width="20" class="style6"><span >行數</span></td>
            <td width="35" class="style6"><span class="style6">什項支出</span></td>
            <td  class="style6"><span class="style6">金額</span></td>
          </tr>
			<?
			$tab=0;        
			for ($i=0;$i<$invoiceRecord;$i++)          
			{
				?>
						<tr bgcolor="#CCCCCC">
							<td><div align="center"><span class="style7"><?echo $i+1;?></span></div></td>
							<td><?php echo $misc[$i];?></td>
							
							<td><?php if ($misc_amt[$i]!=""){echo number_format($misc_amt[$i],2);}?></td>
						</tr>
				 
			<?}?> 
        </table>
		
		 
		
		</td><td colspan="2" valign="top">
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#ffffff" >
		
		     <?php
		 for ($i=0;$i<$chqRecord;$i++)          
			{
				?>
		  <tr bgcolor="#CCCCCC">
            <td >支票<?php echo $i+1;?>:</td>
            <td ><?php echo $cheque[$i];?></td>
            <td ><?php if ($cheque_amt[$i]!=""){ echo number_format($cheque_amt[$i],2);}?></td>
          </tr>
		<?php
			}?>
		 
          <tr bgcolor="#CCCCCC" >
           
            <td width="100">生意總額:</span></td>
            <td ><span class=""><?php echo number_format($daily_revenue,2);?></span></td>
			 <td width="100"></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
           
            <td >總支出:</span></td>
            <td ><span class=""><?php echo number_format($daily_expend,2);?></span></td> <td ></td>
          </tr>
		   <tr bgcolor="#CCCCCC">
           
            <td >支票: </td>
            <td > <?php echo number_format($daily_cheque,2);?> </td> <td ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
           
            <td >信用卡:</span></td>
            <td ><span class=""><?php echo number_format($daily_creditcard,2);?></span></td> <td ></td>
          </tr>
		    <tr bgcolor="#CCCCCC">
          
            <td >銀聯卡:</td>
            <td ><?php echo number_format($daily_unionpay,2);?></td>  <td ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
           
            <td >EPS:</td>
            <td ><?php echo number_format($daily_eps,2);?></td> <td ></td>
          </tr>
		    <tr bgcolor="#CCCCCC">
           
            <td >FPS:</td>
            <td ><?php echo number_format($daily_fps,2);?></td> <td ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
            
            <td >現金入數:</td>
            <td ><?php echo number_format($daily_cash,2);?></td><td ></span></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
           
            <td >入數:</td>
            <td ><span class=""><?php echo number_format($daily_income,2);?></span></td> <td ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
            <td  height="30"><span class=""></span></td>
            <td ><span class=""></span></td>
            <td ><span class=""></span></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
            
            <td >是日存柜:</td>
            <td ><?php echo number_format($daily_drawer,2);?></td><td ></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
            
            <td >昨日存柜:</td>
            <td ><span class=""><?php echo number_format($past_daily_drawer,2);?></span></td><td ><span class=""></span></td>
          </tr>
		  <tr bgcolor="#CCCCCC">
           
            <td>差額:</td>
            <td ><span class=""><?php echo number_format($drawer_diff,2);?></span></td> <td ><span class=""></span></td>
          </tr>
		  
        </table>
		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#004d80">
            <tr>
              <td ><span class="style6">
                <input name="clear" type="reset" id="clear" value="清除">
              </span></td>
              <td width="10%"> </td>
              <td width="8%">
                <!--<input type="checkbox" name="special_man_power" value="Y" />-->
               </td>
              <td ></td>
            <td width="18%">
              
 </td>
              <td width="17%" class="style6">
                            </td>
              <td width="17%"><span class="style6">
             
              </span></td>
              <td width="8%" class="style6"> </td>
              <td width="8%"><input name="submitb" type="button" id="submitb" value="送出" onClick="checkform(0)"></td>
            </tr>
          </table>          </td>
      </tr>
    
    </table>     </td>
  </tr>
</table>
<input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" />
<? 
for ($i=0;$i<$invoiceRecord;$i++)
 {?>
<input type="hidden" name="misc[<?php echo $i;?>]" id="misc[<?php echo $i;?>]" value="<?php echo $misc[$i];?>"/>
<input type="hidden" name="misc_amt[<?php echo $i;?>]" id="misc_amt[<?php echo $i;?>]" value="<?php echo $misc_amt[$i];?>"/>
 <?}?>
 <? 
for ($i=0;$i<$chqRecord=17;$i++)
 {?>
<input type="hidden" name="cheque[<?php echo $i;?>]" id="cheque[<?php echo $i;?>]" value="<?php echo $cheque[$i];?>"/>
<input type="hidden" name="cheque_amt[<?php echo $i;?>]" id="cheque_amt[<?php echo $i;?>]" value="<?php echo $cheque_amt[$i];?>"/>
 <?}?>
 
 <? 
for ($i=0;$i<4;$i++)
 {?>
<input type="hidden" name="cash[<?php echo $i;?>]" id="cash[<?php echo $i;?>]" value="<?php echo $cash[$i];?>"/>
<input type="hidden" name="cash_amt[<?php echo $i;?>]" id="cash_amt[<?php echo $i;?>]" value="<?php echo $cash_amt[$i];?>"/>
 <?}?>
 
<input type="hidden" name="daily_revenue" id="daily_revenue" value="<?php echo $daily_revenue;?>"/>
<input type="hidden" name="daily_expend" id="daily_expend" value="<?php echo $daily_expend;?>"/>
<input type="hidden" name="daily_cheque" id="daily_cheque" value="<?php echo $daily_cheque;?>"/>
<input type="hidden" name="daily_creditcard" id="daily_creditcard" value="<?php echo $daily_creditcard;?>"/>
<input type="hidden" name="daily_unionpay" id="daily_unionpay" value="<?php echo $daily_unionpay;?>"/>
<input type="hidden" name="daily_eps" id="daily_eps" value="<?php echo $daily_eps;?>"/>
<input type="hidden" name="daily_fps" id="daily_fps" value="<?php echo $daily_fps;?>"/>
<input type="hidden" name="daily_cash" id="daily_cash" value="<?php echo $daily_cash;?>"/>
<input type="hidden" name="daily_income" id="daily_income" value="<?php echo $daily_income;?>"/>
<input type="hidden" name="past_daily_drawer" id="past_daily_drawer" value="<?php echo $past_daily_drawer;?>"/>
<input type="hidden" name="daily_drawer" id="daily_drawer" value="<?php echo $daily_drawer;?>"/>
<input type="hidden" name="drawer_diff" id="drawer_diff" value="<?php echo $drawer_diff;?>"/>
<input type="hidden" name="area" id="area" value="<?php echo $AREA;?>"/>
<input type="hidden" name="pc" id="pc" value="<?php echo $PC;?>"/>
<input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo $invoice_date;?>"/>

</form> 

 
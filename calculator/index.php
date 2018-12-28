<?php
  $invoiceRecord=8;
  require_once("./include/config.php");

	 
?>
<script type="text/javascript" src="./include/wood_cal.js"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function() {
	 first_text_box_focus();
 
});

</script>
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
<form action="/?page=calculator&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="1000"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CC99">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006633"><span class="style6"><a href="../">木板碎料計算表</a></span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <td width="85" bgcolor="#006633" class="style6">1分=0.125</td>
    <td width="85" bgcolor="#006633" class="style6">2分=0.250</td>
    <td width="85" bgcolor="#006633" class="style6">3分=0.375</td>
    <td width="85" bgcolor="#006633" class="style6">4分=0.5</td>
    <td width="85" bgcolor="#006633" class="style6">5分=0.625</td>
    <td width="85" bgcolor="#006633" class="style6">6分=0.750</td>
    <td width="85" bgcolor="#006633" class="style6">7分=0.785</td>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#006633">
            <td width="4%"><span class="style6">項目</span></td>
            <td width="15%"><span class="style6">闊度(寸)</span></td>
            <td width="3%" class="style6"> <div align="center">X</div></td>
            <td width="15%"><span class="style6">高度(寸)</span></td>
            <td width="15%"><span class="style6">數量</span></td>
            <td width="15%"><span class="style6"><span class="style6">平方呎</span></span></td>
            <td width="15%"><span class="style6">單價($)</span></td>
            <td width="15%" class="style6"><div align="center">共銀($)</div></td>
            </tr>
<?


$tab=0;        
for ($i=0;$i<$invoiceRecord;$i++)          
{
	?>
          <tr bgcolor="#CCCCCC">
            <td><div align="center"><span class="style7"><?echo $i+1;?></span></div></td>
            <td><input name="width[]" type="text" id="width<?echo $i;?>" size="5" maxlength="5" tabindex="<?$tab++;echo $tab?>" onkeyup="next_text_box(event,'height<?=$i;?>')" onChange="findPartNoAjax('<?=$i?>')"/>
			
        
              </td>
            <td><div align="center">X</div></td>

            <td><input name="height[]" type="text" id="height<?echo $i;?>" size="5" maxlength="5" tabindex="<?$tab++;echo $tab?>" onkeyup="cal_feet(event,'qty<?=$i;?>',<?=$i?>);"   ></td>
                       <td>
              <input name="qty[]" type="text" id="qty<?echo $i;?>"  size="5" maxlength="5"  value="1" tabindex="<?$tab++;echo $tab?>"  onkeyup="next_text_box(event,'unitprice<?=$i;?>');">            </td>
			 <td><div align="left">
              <input name="feet[]" type="text" id="feet<?echo $i;?>"  size="10" maxlength="10" readonly="readonly"/>
             </div></td>
            <td><div align="left">
              <input name="unitprice[]" type="text" id="unitprice<?echo $i;?>" tabindex="<?$tab++;echo $tab?>" onkeyup="cal_total(event,'width<?=$i+1;?>',<?=$i?>);" size="5" maxlength="5" value="0">
            </div></td>
            <td><div align="left">
              <input name="total<?echo $i;?>" type="text" id="total<?echo $i;?>" size="3" maxlength="3" value="0" readonly="readonly">
            </div></td>
            </tr>
	 
<?}?>
          
        
            
        </table>          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#006633">
            <tr>
              <td width="7%"><span class="style6">
                
              </span></td>
              <td width="10%"> </td>
              <td width="8%">
                
              
                 </td>
              <td width="7%"> </td>
            <td width="18%"> 
 </td>
              <td width="17%" class="style6">               </td>
              <td width="17%"><span class="style6">
                <input type="button" name="Submit" value="暫計"  >
                <input name="countid" type="text" class="" id="countid" size="10" />
              </span></td>
              <td width="8%" class="style6"> 
                </td>
              <td width="8%"> </td>
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
<input type="hidden" name="manpower[]" id="manpower<?echo $i;?>" value="N"/>
<input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="Y"/>
<input type="hidden" name="cutting[]" id="cutting<?echo $i;?>" value="N"/>
<?}?>
</form>

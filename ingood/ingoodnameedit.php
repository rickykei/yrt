<?
   include_once("./include/config.php");
    $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
   $query="SET NAMES 'UTF8'";
 $result1=mysql_query($query);

if ($update==1)
  {
   $goods_detail=addslashes($goods_detail);
   
      if ($partno_sub==""){
   $query="update sumgoods set pos_display='$pos_display', pos_seq='$pos_seq', status='$status', pos_label='$pos_label',model='$model',model2='$model2',model3='$model3',model3_x='$model3_x',model3_y='$model3_y',goods_detail='$goods_detail',market_price=$market_price ,remark='$remark' , unitid='$unitid', inshop_quota='$inshop_quota' ,inshop_box = '$inshop_box' , sell_out_unit='$sell_out_unit',sell_out_qty='$sell_out_qty',buy_in_unit='$buy_in_unit', thereafter_price='$thereafter_price', thereafter_qty='$thereafter_qty' ,market_price_door='$market_price_door' where goods_partno='$goods_partno'";
	  }else{
	$query="update sumgoods set  pos_display='$pos_display', pos_seq='$pos_seq',status='$status',pos_label='$pos_label',model='$model',model2='$model2',model3='$model3',model3_x='$model3_x',model3_y='$model3_y',goods_detail='$goods_detail',market_price=$market_price ,remark='$remark' , unitid='$unitid', inshop_quota='$inshop_quota' ,inshop_box = '$inshop_box', mix='Y' ,sell_out_unit='$sell_out_unit', sell_out_qty='$sell_out_qty', buy_in_unit='$buy_in_unit',thereafter_price='$thereafter_price' , thereafter_qty='$thereafter_qty' ,market_price_door='$market_price_door' where goods_partno='$goods_partno'";	  
	  }
	  
	  
	 
   if (mysql_query($query))
   $string="資料已經更生";
   else
   $string="Too Bad!";
   $update=0;
   
	   if ($partno_sub!=""){
			
			 
			$partno_sub_arr = explode(",", $partno_sub);
			$partno_sub_qty_arr = explode(",", $partno_sub_qty);
		 
		 
			//delete from master code on mix table
			 $query="delete from sumgoods_mix where partno_src='$goods_partno'";
			  if (mysql_query($query))
				   $string="資料已經更生";
		
			//insert mix table
			for ($i=0;$i<count($partno_sub_arr);$i++){
			$query="insert into sumgoods_mix (partno_src,partno_sub,qty,sts) values ('$goods_partno','".$partno_sub_arr[$i]."','".$partno_sub_qty_arr[$i]."','Y')";
			 mysql_query($query);
			 
			 
			 //update sumgood subcode to slave
			 $query="update sumgoods set mix='S' where goods_partno='".$partno_sub_arr[$i]."'";	  
			 
			  mysql_query($query);
			}
			
			
	   }

   } 
     if ($update==2)
   {
   
   $query="select * from sumgoods where goods_partno='$goods_partno'";
   $query2="select sum(qty) from goods_invoice where goods_partno='$goods_partno'";
  
   $query3="select sum(qty) from goods_instock where goods_partno='$goods_partno'";
   
   //20151201
   $query4="select sum(qty) from goods_inshop where goods_partno='$goods_partno'";
   
   
   $result=mysql_query($query);
   $result2=mysql_query($query2);
   $result3=mysql_query($query3);
   $result4=mysql_query($query4);
   if (!empty($result))
   $row= mysql_fetch_array ($result);
   if (!empty($result2))
   $row2=mysql_fetch_array ($result2);
   if (!empty($result3))
   $row3=mysql_fetch_array ($result3);
	if (!empty($result4))
   $row4=mysql_fetch_array ($result4);
   
   if ($row['mix']=='Y'){
	   //find sub code
		$sql5="select partno_sub,qty from sumgoods_mix where partno_src='$goods_partno'";
		 
	    $result5=mysql_query($sql5);
		if (!empty($result5))
		while($row5= mysql_fetch_array ($result5)){
			$partno_sub.=$row5['partno_sub'].',';
			$partno_sub_qty.=$row5['qty'].',';
		}
		$partno_sub=rtrim($partno_sub, ",");
		$partno_sub_qty=rtrim($partno_sub_qty, ",");
   }
   

	}
   $unitResult = $connection->query("SELECT id,unit_name_chi ,unit_cd FROM unit");
   
   if (DB::isError($unitResult))
     die ($unitResult->getMessage());
  
  $i=0;
  	while ($unitrow = $unitResult->fetchRow(DB_FETCHMODE_ASSOC))
	{
		$unit_arr[$i]['id']=$unitrow['id'];
		$unit_arr[$i]['chi_name']=$unitrow['unit_name_chi'] ;
		$unit_arr[$i]['unit_cd']=$unitrow['unit_cd'] ;
		 
		$i++;
    }
  
  
		 $type0Result = $connection->query("SELECT * FROM type where level='0'");
      if (DB::isError($type0Result))
      die ($type0Result->getMessage());
  
   $type1Result = $connection->query("SELECT * FROM type where level='1'");
    if (DB::isError($type1Result))
      die ($type1Result->getMessage());
  
   $type2Result = $connection->query("SELECT * FROM type where level='2'");
    if (DB::isError($type2Result))
      die ($type2Result->getMessage());
  
?> 
<STYLE TYPE="text/css">
h1 {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"}
h2 {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"}
li { line-height: 14pt }
input,textarea,select {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 12px}

.login       { background-color: #CCCCCC; color: #000000; font-size: 9pt; border-style: solid; 
               border-width: 1px }
small {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt; line-height: 14pt}
p { font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt ;font-color: #FFFFFF}
.style2 {color: #000000}
</STYLE>
<link href="./include/invoice.css" rel="stylesheet" type="text/css">
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
<script language="JavaScript">
function checkform()
{
	if(document.ingoodnameform.goods_detail.value == "")
	{
	alert ("請輸入貨品編號.");
	document.ingoodnameform.goods_detail.focus();
	}else
	{
        document.ingoodnameform.submit();
        }

}

function check_del(aa)
{
 alert('刪除 '+ aa);
 document.ingood_del_form.submit();
}

</script>
 
<div align="center">
<table width="900"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CC99">
  <tr>
    <td width="4" height="">&nbsp;</td>
    <td align="center" valign="top">
    <table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006633"><span class="style6">更改入貨名</span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">  <span class="style2"><? echo "$string"?></span></td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#669933">
        <td height="24" colspan="4">
  <table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="">
    <tr> 
      <td colspan="4"> 
        <form name="form1" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
          <input type="text" name="goods_partno" maxlength="20" <? if ($goods_partno !="") { echo "value=\"".$goods_partno."\"";}?>>
          <input type="hidden" name="update" value=2>
          <input name="submit" type="submit" id="submit" value="搜尋">
          (請輸入要更改資料的PART_NO.) 
          </form>      </td>
    </tr>
    <tr> 
      <td width="113"><strong><font face="新細明體" color=#FFFFFF size="3"> 
        <? echo "  出貨 = ".$row2["sum(qty)"];?>
        </font></strong></td>
      <td width="275"><strong><font face="新細明體" color=#FFFFFF size="3"> 
        <? echo "  入貨 = ".$row4["sum(qty)"];?>
        </font></strong></td>
      <td width="142"><strong> 
        <? $a=$row4["sum(qty)"]-$row2["sum(qty)"];
if ($a<0)
{
 echo "<font face=新細明體 color=#FF0000 size=4>";
}
else
{ echo "<font face=新細明體 color=#FFFFFF size=4>";}
 echo "  存貨 = ".$a;?>
        </strong></td>
      <td width="346">&nbsp;</td>
    </tr>
    <form name="ingoodnameform" method="post" action="/?page=ingood&subpage=ingoodnameedit.php">
      <tr bgcolor="#999999"> 
        <td width="113" align="left"> 
          <font face="新細明體" color="#FFFFFF" size="2"> 
            <input type="hidden" name="update" value=1 >
            <span class="style6">貨品編號:</span></font>         </td>
        <td width="275"> 
          <span class="style6"><? echo $row["goods_partno"];?> </span>       </td>
        <td width="142"> 
          <div align="right"></div>        </td>
        <td width="346">&nbsp;        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="113"> 
        <div class="style6"><font face="新細明體" color="#FFFFFF" size="2">貨品描述:</font></div>        </td>
        <td colspan="3"> 
        <textarea name="goods_detail" cols="50" rows="8" class="login"><? $goods_detail=stripslashes($row["goods_detail"]); echo $goods_detail;?></textarea>        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="113"> 
        <div ><font size="2" class="style6">備註:</font></div>        </td>
        <td colspan="3"> 
        <textarea name="remark" cols="50" rows="5" class="login"><? $remark=stripslashes($row["remark"]); echo $remark;?></textarea>        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="113"> 
        <div align="left" class="style6">種類:</div>        </td>
        <td width="275">   <select name="model" id="model">
		<? 

	  while ($type0row = $type0Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		 
	echo "<option value=\"".$type0row['typeName']."\"";
	$model=stripslashes($row["model"]); 
	if ($model==$type0row['typeName'])
	echo " selected ";
	echo ">".$type0row['typeName']."</option>";
    }?>
        </select>                </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>   
	  
  <tr bgcolor="#999999"> 
        <td width="113"> 
        <div align="left" class="style6">種類2:</div>        </td>
        <td width="275">   <select name="model2" id="model2">
		<? 

	  while ($type1row = $type1Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		 
	echo "<option value=\"".$type1row['typeName']."\"";
	$model2=stripslashes($row["model2"]); 
	if ($model2==$type1row['typeName'])
	echo " selected ";
	echo ">".$type1row['typeName']."</option>";
    }?>
        </select>                </td>
        <td width="142"></td>
        <td width="346">&nbsp;</td>
      </tr>  
  <tr bgcolor="#999999"> 
        <td width="113"> 
        <div align="left" class="style6">種類3:</div>        </td>
        <td width="275">   <select name="model3" id="model3">
		<? 

	  while ($type2row = $type2Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		 
	echo "<option value=\"".$type2row['typeName']."\"";
	$model3=stripslashes($row["model3"]); 
	if ($model3==$type2row['typeName'])
	echo " selected ";
	echo ">".$type2row['typeName']."</option>";
    }?>
        </select>                </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>  

	  
	  <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">種類3 x:</font></td>
        <td width="275"> 
        <input type="text" name="model3_x" maxlength="9" class="login" value="<?=$row["model3_x"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  
	  <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">種類3 y:</font></td>
        <td width="275"> 
        <input type="text" name="model3_y" maxlength="9" class="login" value="<?=$row["model3_y"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	   <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">POS 貨名:</font></td>
        <td width="275"> 
        <input type="text" name="pos_label" maxlength="10" class="login" value="<?=$row["pos_label"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
       <tr  bgcolor="#999999"> 
      <td  ><font size="3" face="新細明體" class="style6">單位：</font></td>
      <td  > 
        <select name="unitid" id="unitid">
		<? for ($i=0;$i<count($unit_arr);$i++)
		 {
		 
	echo "<option value=\"".$unit_arr[$i]['id']."\"";
	$unitid=stripslashes($row["unitid"]); 
	if ($unitid==$unit_arr[$i]['id'])
	echo " selected ";
	echo ">".$unit_arr[$i]['chi_name']."</option>";
    }?>
        </select>
      </td><td></td><td></td>
    </tr>
       <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">出貨單賣出價格:$</font></td>
        <td width="275"> 
        <input type="text" name="market_price" maxlength="9" class="login" value="<?=$row["market_price"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">方邊門賣出頭:</font></td>
        <td width="275"> 
        <input type="text" name="sell_out_qty" maxlength="9" class="login" value="<?=$row["sell_out_qty"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">方邊門賣出單位:</font></td>
        <td width="275"> 
         <select name="sell_out_unit" id="sell_out_unit">
		<? for ($i=0;$i<count($unit_arr);$i++)
		 {
		 
	echo "<option value=\"".$unit_arr[$i]['unit_cd']."\"";
	$sell_out_unit_cd=stripslashes($row["sell_out_unit"]); 
	if ($sell_out_unit_cd==$unit_arr[$i]['unit_cd'])
	echo " selected ";
	echo ">".$unit_arr[$i]['chi_name']."</option>";
    }?>
        </select>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  
	    <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">方邊門賣出價格:$</font></td>
        <td width="275"> 
        <input type="text" name="market_price_door" maxlength="9" class="login" value="<?=$row["market_price_door"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	 
	   <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">方邊門賣出其後毎:</font></td>
        <td width="275"> 
        <input type="text" name="thereafter_qty" maxlength="9" class="login" value="<?=$row["thereafter_qty"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">方邊門賣出其後價:</font></td>
        <td width="275"> 
        <input type="text" name="thereafter_price" maxlength="9" class="login" value="<?=$row["thereafter_price"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  
	  
	    <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">方邊門賣入單位:</font></td>
        <td width="275"> 
         <select name="buy_in_unit" id="buy_in_unit">
		<? for ($i=0;$i<count($unit_arr);$i++)
		 {
		 
	echo "<option value=\"".$unit_arr[$i]['unit_cd']."\"";
	$buy_in_unit_cd=stripslashes($row["buy_in_unit"]); 
	if ($buy_in_unit_cd==$unit_arr[$i]['unit_cd'])
	echo " selected ";
	echo ">".$unit_arr[$i]['chi_name']."</option>";
    }?>
        </select>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  <tr bgcolor="#999999"> <td color="#FFFFFF" size="2" class="style6"> 入舖備用量</td><td colspan="3"><input class="login" type="text" name="inshop_quota" value="<?=$row["inshop_quota"];?>"/>
	  </td></tr>
	  
	     <tr bgcolor="#999999"> <td color="#FFFFFF" size="2" class="style6"> 1箱幾件:</td><td colspan="3"><input class="login" type="text" name="inshop_box" value="<?=$row["inshop_box"];?>"/>
	  </td></tr>
	  	  <tr bgcolor="#999999"> <td color="#FFFFFF" size="2" class="style6"> 子產品</td><td colspan="3"><input class="login" type="text" name="partno_sub" value="<?php echo $partno_sub;?>"/>
	  </td></tr>
	    <tr bgcolor="#999999"> <td color="#FFFFFF" size="2" class="style6"> 子產品數量</td><td colspan="3"><input class="login" type="text" name="partno_sub_qty" value="<?php echo $partno_sub_qty;?>"/>
	  </td></tr>
	  
	  
	   <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">Y=在銷 , N=沽清:</font></td>
        <td width="275"> 
         <select name="status" id="status">
		 <option></option>
		 <option value="Y" <?php if($row["status"]=="Y") echo "Selected";?>>Y</option>
	 	 <option value="N" <?php if($row["status"]=="N") echo "Selected";?>>N</option>
 
        </select>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	    <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2"  class="style6">POS 顯示些產品?</font></td>
        <td width="275"> 
         <select name="pos_display" id="pos_display">
		 <option value="Y" <?php if($row["pos_display"]=="Y") echo "Selected";?>>Y</option>
	 	 <option value="N"  <?php if($row["pos_display"]=="N") echo "Selected";?>>N</option>
 
        </select>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	    <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2"  class="style6">POS 順序 (0至999) 小的排先</font></td>
        <td width="275"> 
         <input type="text" name="pos_seq" id="pos_seq" value="<?php echo $row["pos_seq"];?>" >
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  <tr> 
        <td width="113">&nbsp;</td>
        <td width="275" height="20" align="left" valign="middle"> 
		<input type="hidden" name="goods_partno" value="<?echo $row["goods_partno"];?>" >
          <input type="submit" name="Submit3" value="更新記錄" onClick="javascript:checkform();">
        <input type="reset" name="Submit2" value="清除" ></td>
      
        <td width="142"></td>
        <td width="346">&nbsp;</td>
      </tr>
	  
	 
	  
	  </form> 
      <tr> 
        <td width="113"></td>
        <td valign="bottom" width="275">&nbsp;        </td>
        <td width="142"><form name="ingood_del_form" method="POST" action="/?page=ingood&subpage=ingoodname_del.php">
		<input type="hidden" name="goods_partno" value="<?echo $row["goods_partno"];?>" >
        <input type="submit" name="Submit" value="刪除此項貨品名" onClick="javascript:check_del('<?echo $goods_partno;?>')">
        </form></td>
        <td width="346">&nbsp;</td>
      </tr>
  </table></td>
      </tr>
</table>     </td>
  </tr>
</table>
  <strong><font face="新細明體" color=#FFFFFF size="3"> </font> </font> </strong> 
</div>

  <p>&nbsp; </p>
  <p>&nbsp;</p>
  <p>&nbsp; </p>
  <p>&nbsp;</p>
  

  
  
 

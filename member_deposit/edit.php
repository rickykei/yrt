<?php
    
	 
  require_once("../include/config.php");
  require_once("../include/functions.php");
  include_once("../include/timestamp.php");
  $ts = new TIMESTAMP;
	//db connection
	$db = DB::connect($dsn);
	   if (DB::isError($connection))
      die($db->getMessage());
	   $result = $db->query("SET NAMES 'UTF8'");
	//get Staff name	  
	  $sql="SELECT * FROM staff";
	 $staffResult = $db->query($sql);
      
	 //select invoice
    
	$sql="select * from member_deposit where mem_dep_id=".$id." order by mem_dep_id asc";
	 $invoiceResult = $db->query($sql);
	$invoicerow = $invoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
	 
  	// sum of dep amt
				$sum_dep_amt_sql="SELECT sum( deposit_amt ) as sum FROM member_deposit WHERE mem_id ='".$invoicerow['mem_id']."' ";
				
				$sum_dep_amt_result = $db->query($sum_dep_amt_sql);
				while ( $sum_dep_amt_result_row = $sum_dep_amt_result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$sum_dep_amt=$sum_dep_amt_result_row["sum"];
				//echo $sum_dep_amt;
				}
				
				// sum of invoice amt for member used deposit saving
				$sum_inv_dep_amt_sql="SELECT sum( total_price ) as sum FROM invoice WHERE member_id ='".$invoicerow['mem_id']."' and deposit_method='D' ";
				$sum_inv_dep_amt_result = $db->query($sum_inv_dep_amt_sql);
				while ( $sum_inv_dep_amt_result_row = $sum_inv_dep_amt_result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$sum_inv_dep_amt=$sum_inv_dep_amt_result_row["sum"];
				//echo $sum_inv_dep_amt;
				}

?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>會員存款</title>

<style type="text/css">
@import url(../include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="../include/cal/calendar.js"></script>
<script type="text/javascript" src="../include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="../include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="../include/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="../include/functions.js"></script>
<script type="text/javascript" src="../include/invoice.js"></script>

<link href="../include/invoice_edit.css" rel="stylesheet" type="text/css">
<style type="text/css">

</style></head>
<body onkeydown="detectKeyBoard(event)">
<form action="edit2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="1000"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  <tr>
    <td width="4" height="">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#004d80"><span class="style6"><a href="../">會員存款</a></span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="1" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80">
            <td width="80">
                <span class="style6">發票日期：</span></td>
            <td width="136"><input name="entry_date" type="text" id="entry_date" value="<? echo $invoicerow['entry_date']; ?>" size="15" maxlength="20" readonly="readonly"></td>
             <td width="79"><span class="style6">營業員 ： </span></td>
            <td width="60">
              <select name="sales" id="sales">
			  <?php
			  // 20100329 disable change staff name on invoice editing RW
				//   Fung request add bonus issue
				 //
			  if (!($AREA=="Y" && $PC=="99") && !($AREA=="Y" && $PC=="1") ){
					echo "<option value=\"".$invoicerow['sales_name']."\" ";	
					echo "selected";
					echo ">".$invoicerow['sales_name']."</option>";
			  }
			  else
			  {
				  while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
				  {
					echo "<option value=\"".$row['name']."\" ";
					if ($invoicerow['sales_name']==$row['name'])
					echo "selected";
					echo ">".$row['name']."</option>";
					}
			  }
			?>
                    
                </select>		</td>
            <td width="191"> </td>
			<td colspan="2"> <span class="style6">餘額 :</span><input name="mem_dep_bal" id="mem_dep_bal" value="<?php echo $sum_dep_amt-$sum_inv_dep_amt;?>" readonly="readonly"> </td>
			</tr>
			
          <tr bgcolor="#004d80">
            <td ><span class="style6">入賬日期：</span></td>
            <td ><input name="deposit_date" type="text" id="deposit_date" tabindex="39" size="15" maxlength="20" value="<? echo $invoicerow['deposit_date']; ?>"><input name="cal" id="calendar" value=".." type="button"></td>
           
            <td><span class="style6">客戶編號：</span></td>
            <td colspan="2"><input onKeyPress="next_text_box(event,'deposit_date')"  onBlur="check888();"  value="<? echo $invoicerow['mem_id']; ?>" name="mem_id" tabindex="38" type="text" id="mem_id"  size="15" onChange="findMemIdAjax();"/> </td>
			 
			<td width="237"><span class="style6">客戶名稱：
			  <input name="mem_name" type="text" id="mem_name" value="<? echo $invoicerow['mem_name']; ?>">
			  </span></td>
            <td width="188" ><span class="style6">會員級別</span>
              <input name="mem_credit_level" id="mem_credit_level" type="text" disabled="disabled" class="blocktextbox" size="3" maxlength="3"></td>
          </tr>
		  
		    
		  
          <tr bgcolor="#004d80">
         
            <td><span class="style6">存入金額</span></td>
            <td colspan="4"><input onKeyPress="next_text_box(event,'mem_id')" tabindex="37" name="deposit_amt" type="text" id="deposit_amt" size="60" value="<? echo $invoicerow['deposit_amt']; ?>" maxlength="255" onChange="findAddressAlertAjax()" /></td>
			<td><input type="text" id="warning" name="warning" readonly="readonly" /></td>
			<td> <input name="submitb" type="submit" id="submitb" value="送出"></td>
                </tr>
         
        </table></td>
      </tr>
       
          
         
       
   
  </tr>
</table>
<input type="hidden" name="AREA" value="<?echo $AREA;?>" />
<input type="hidden" name="PC" value="<?echo $PC;?>" />
 <input type="hidden" name="mem_dep_id" value="<?echo $id;?>" />
</form><script type="text/javascript">
 
  Calendar.setup(
    {
      inputField  : "deposit_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %I:%M",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  
</script>



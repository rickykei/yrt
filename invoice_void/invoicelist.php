<?php
   include_once("./include/config.php");
?>
<link rel="stylesheet" href="./include/invoice_style.css" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #5E5E5E}
-->

@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script></head>
<?php
   
   $db = DB::connect($dsn);
    if (DB::isError($connection))
      die($connection->getMessage());
   
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");
  $sql="SELECT * FROM staff where name !='' ";
	 $staffResult = $db->query($sql);
  
	$checking=0;
   	if ($created_by=="" && $invoice_no!="" && $mem_id=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end==""  && $sales=="" && $delivery=="" && $receiver==""&& $deposit_method==""){
		
	//search by invoiceno
	  $sql="SELECT  a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice a where void='I' and a.invoice_no = '".$invoice_no."'";
	}else if ($created_by=="" &&  $mem_id!="" && $invoice_no=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end==""  && $sales=="" && $delivery=="" && $receiver=="" && $deposit_method==""){
		//searc by mem id
	   $sql="SELECT  a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice a where void='I' and a.member_id='".$mem_id."'";
	    $sqlCount= " Select count(*) as total  from invoice a where a.member_id='".$mem_id."'";
		}else if ($created_by=="" &&  $mem_id=="" && $invoice_no=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end==""  && $sales=="" && $delivery=="" && $receiver!=""){
		//searc by receiver
	   $sql="SELECT  a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice a where void='I' and a.receiver='".$receiver."'";
	    $sqlCount= " Select count(*) as total  from invoice a where a.receiver='".$receiver."'";
    }else if ($created_by=="" &&  $goods_partno!="" && $mem_id=="" && $invoice_no=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end==""  && $sales=="" && $delivery==""){
			//sear by goodNo
	   $sql ="SELECT  a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.call_count,a.total_price, a.total_price,a.invoice_no,a.invoice_date, a.delivery_date,a.customer_name,a.member_id,a.branchID,a.delivery, a.sales_name,a.settle  from invoice a ,goods_invoice b where a.void='I' and a.invoice_no=b.invoice_no and b.goods_partno='".$goods_partno."'";
	    $sqlCount= " Select count(*) as total   from invoice a ,goods_invoice b where a.invoice_no=b.invoice_no and b.goods_partno='".$goods_partno."'";
	   } else if ($created_by=="" &&  $customer_detail!="" && $mem_id=="" && $invoice_no=="" && $goods_partno=="" &&  $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end==""  && $sales=="" && $delivery==""){
		   
	   //by custom detail
	   $sql="SELECT  a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice a where a.customer_detail like '%".$customer_detail."%'";
	   }  else if ($created_by=="" && $invoice_status!="" && $mem_id=="" && $invoice_no=="" && $goods_partno=="" && $customer_detail ==""  && $invoice_date_start=="" && $invoice_date_end==""  && $sales=="" && $delivery=="")
	   $sql="SELECT a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice a where a.settle like 'S' ";
	   else if ($created_by==""  && $invoice_date_start!="" && $invoice_date_end!="" && $mem_id=="" && $invoice_no=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status==""  && $sales=="" && $delivery=="")
	   $sql="SELECT a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice a where a.void='I' and a.invoice_date >= '".$invoice_date_start." 00:00:00' and a.invoice_date <='".$invoice_date_end." 23:59:00' ";
		else if ($created_by==""  && $delivery_date_start!="" && $delivery_date_end!="" && $mem_id=="" && $invoice_no=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status==""  && $sales=="" && $delivery=="" )
	   $sql="SELECT a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice a where a.void='I' and a.delivery_date >= '".$delivery_date_start." 00:00:00' and a.delivery_date <='".$delivery_date_end." 23:59:00' ";
	   else if ($created_by=="" && $invoice_no=="" && $mem_id=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end=="" && $sales=="" && $delivery=="" && $deposit_method=="")	{
	  		$sql="SELECT a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,call_count,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle,status FROM invoice a where a.void='I' ";
	  	    $sqlCount= " Select count(*) as total FROM invoice a ";
	// $sql="SELECT * FROM invoice order by invoice_no desc";
		} else{
			
			//join invoice_item
			if ($goods_partno!=""){
				$sql="SELECT a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.total_price,a.invoice_no,a.invoice_date,a.delivery_date,a.customer_name,a.member_id,a.branchID,a.delivery, a.sales_name,a.settle  from invoice as a,goods_invoice as b where a.void='I' and a.invoice_no=b.invoice_no and b.goods_partno='".$goods_partno."' ";
				$checking=1;
			}else{
				$sql="SELECT a.customer_detail,a.deposit_method,a.created_by,a.last_update_by,a.total_price,a.invoice_no,a.invoice_date,a.delivery_date,a.customer_name,a.member_id,a.branchID,a.delivery, a.sales_name,a.settle  from invoice as a where a.void='I' ";
				$checking=1;
			}
			
			if ($invoice_no!=""){
				if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.invoice_no='".$invoice_no."' ";
				$checking++;
			}
			if ($mem_id!=""){
						if ($checking>=1) 
					$sql.=" and ";
					$sql.=" a.member_id='".$mem_id."' ";
							$checking++;
			}
			if ($receiver!=""){
						if ($checking>=1) 
					$sql.=" and ";
					$sql.=" a.receiver='".$receiver."' ";
							$checking++;
			}
			if ($customer_detail!=""){
						if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.customer_detail like '".$customer_detail."' ";
						$checking++;
			}
			if ($invoice_status!=""){
						if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.settle='".$invoice_status."' ";
						$checking++;
			}
			if ($invoice_date_start!="" && $invoice_date_end!=""){
				if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.invoice_date >='".$invoice_date_start." 00:00:00' and a.invoice_date <='".$invoice_date_end." 23:59:00' ";
						$checking++;
			}	
			if ($delivery_date_start!="" && $delivery_date_end==""){
					if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.delivery_date >='".$delivery_date_start." 00:00:00' and a.delivery_date <='".$delivery_date_start." 23:59:00' ";
						$checking++;
			}
			if ($delivery!="" ){
					if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.delivery='".$delivery."' ";
						$checking++;
			}
			
			if ($sales!=""){
					if ($checking>=1) 
					$sql.=" and ";
					$sql.= " a.sales_name ='".$sales."' ";
					$checking++;
			}
			
			 
			if ($deposit_method!=""){
				if ($checking>=1) 
					$sql.=" and ";
					$sql.= " a.deposit_method ='D' ";
					$checking++;
			
			if ($checking>=1) 
					$sql.=" and ";
					$sql.= " a.void!='I' ";
					$checking++;			
				//member deposit checking 20161217
		 
				// sum of dep amt
				$sum_dep_amt_sql="SELECT sum( deposit_amt ) as sum FROM member_deposit WHERE mem_id ='".$mem_id."' ";
				
				$sum_dep_amt_result = $db->query($sum_dep_amt_sql);
				while ( $sum_dep_amt_result_row = $sum_dep_amt_result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$sum_dep_amt=$sum_dep_amt_result_row["sum"];
				//echo $sum_dep_amt;
				}
				
				// sum of invoice amt for member used deposit saving
				$sum_inv_dep_amt_sql="SELECT sum( total_price ) as sum FROM invoice WHERE member_id ='".$mem_id."' and deposit_method='D' ";
				$sum_inv_dep_amt_result = $db->query($sum_inv_dep_amt_sql);
				while ( $sum_inv_dep_amt_result_row = $sum_inv_dep_amt_result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$sum_inv_dep_amt=$sum_inv_dep_amt_result_row["sum"];
				//echo $sum_inv_dep_amt;
				}
			}
	
	   }
		$sql.=" order by a.invoice_no desc ";   
  
 
	//cal total count first;
	if ($sqlCount!=""){
	 $result = $db->query($sqlCount);
		 while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$countTotal=$row["total"];
		 }
	}
 
   require_once("./include/Pager.class.php");

   include_once('./invoice/Pager_header.php');

 
   ?>
  <hr/><div id="response">    <pre></pre></div>
 
<form name="search" action="/?page=invoice_void&subpage=invoicelist.php" method="POST">
<div><label>發票編號：</label>
<input name="invoice_no" type="text" class="buttonstyle"  id="invoice_no" size="10" maxlength="10" /></div>
<div><label class="style7">客戶編號：</label>
<input name="mem_id" type="text" class="buttonstyle"  id="mem_id" size="10" maxlength="10" /></div>
<div><label class="style7">收貨人：</label>
<input name="receiver" type="text" class="buttonstyle"  id="receiver" size="10" maxlength="10" /></div>
<div><label class="style7">貨品編號：</label>
<input name="goods_partno" type="text" class="buttonstyle"  id="goods_partno" size="20" maxlength="20" /></div>
<div><label>送貨地址：</label>
<input name="customer_detail" type="text" class="buttonstyle"  id="customer_detail" size="20" maxlength="20" /></div>
<div><label>發票日期：</label>
<input name="invoice_date_start" id="invoice_date_start" class="buttonstyle" type="text"  size="15"><input name="cal" id="calendar" value=".." type="button">
至
<input name="invoice_date_end" id="invoice_date_end" class="buttonstyle" type="text"  size="15" />
<input name="cal2" id="calendar2" value=".." type="button" />
</div>
<div><label>送貨日期：</label>
<input name="delivery_date_start" id="delivery_date_start" class="buttonstyle" type="text"  size="15"><input name="cal" id="calendar3" value=".." type="button">
至
<input name="delivery_date_end" id="delivery_date_end" class="buttonstyle" type="text"  size="15" />
<input name="cal2" id="calendar4" value=".." type="button" />
</div>
<div><label>掛單：</label>
  <input name="invoice_status" type="checkbox" id="invoice_status" value="S" />
</div>
<div><label>等電</label>
  <input name="delivery" type="checkbox" id="delivery" value="W" />
</div>
 
<div><label>售貨員</label>
  <select name="sales" id="sales">
              <option value="" > </option>
			  <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
                echo "<option value=\"".$row['name'];
                echo "\"";
                
                echo ">".$row['name']."</option>";
				}?>
                </select>
</div>
 <div><label>會員賑戶扣數 </label>
  <input name="deposit_method" type="checkbox" id="deposit_method" value="D" />
</div>
<input type="submit" name="button" value="查貨單"/>
</form>

<input type="button" name="button" value="重新回覆單" onclick="submitForm('resume')"/>

<hr/>
<a href="../">回主頁</a>
<?php if ($deposit_method!=""){ ?>
   <hr/>
<font color="red"> 
會員賑戶存入: <?php echo $sum_dep_amt;?><br><br>
會員賑戶扣數: <?php echo $sum_inv_dep_amt; ?><br><br>
戶口結餘: <?php echo $sum_dep_amt-$sum_inv_dep_amt;?>

</font>
<?php } ?>
   <hr/>
<?=$turnover?>
<table  width="100%" bgcolor="#2E2E2E" border="0" cellpadding="1" cellspacing="1">

<TR bgcolor="#5E5E5E" align="center" style="font-weight:bold" >
<TD width="20" height="23" bgcolor="#006633"> ID <input name="invoice_action_all" type="checkbox" id="invoice_action_all" value="B" /></TD>
<TD width="50" height="23" bgcolor="#006633"> 發票編號</TD>
<TD width="107" bgcolor="#006633"> 發票日期</TD>
<TD width="107" bgcolor="#006633">送貨日期 </TD>
<td width="78" bgcolor="#006633">客戶名稱</td>
<TD width="94" bgcolor="#006633">會員編號</TD>
<TD width="67" bgcolor="#006633">分店</TD>
<TD width="88" bgcolor="#006633">送貨</td>
<TD width="88" bgcolor="#006633">地址</td>
<TD width="100" bgcolor="#006633">售貨員</TD>
<TD width="100" bgcolor="#006633">單總</TD>
<TD width="40" bgcolor="#006633">入賑方法</TD>
<?php 
//20100525
if (($AREA=="Y" && $PC=="99") || ($AREA=="Y" && $PC=="1") ){ 
?>
<TD width="100" bgcolor="#006633">機號</TD>
<?php 
} 
?>
<TD width="32" bgcolor="#006633">唯讀</td>
 
<TD width="32" bgcolor="#006633">列印</td>
</TR>

    <?php 
	
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   ?><tr valign="middle" align="center"  <? 
if($row['settle']=="S" || $row['settle']=="") {echo "class='b'\"";echo " onMouseOut=\"this.className='b'\"";echo " onMouseOver=\"this.className='normal'\"";}
else if ($row['settle']=="A") { echo " onMouseOut=\"this.className='normal'\"";echo " onMouseOver=\"this.className='highlight'\"";} else if ($row['settle']=="D") { echo "class='deposit'\""; echo " onMouseOut=\"this.className='deposit'\"";echo " onMouseOver=\"this.className='highlight'\"";}
?>   />
<TD width="20"   > <input name="invoice_action[]" type="checkbox" id="invoice_action[]" value="<?=$row['invoice_no']?>" /></TD>
   <td><? if ($row['call_count']>0) echo "*" ; ?><?=$row['invoice_no']?></td>
   <td><?=$row['invoice_date']?></td>
   <td><?=$row['delivery_date']?></td>
   
   <td><?=$row['customer_name']?></td>
   <td><?=$row['member_id']?></td>
   <td><?=$row['branchID']?></td>
   <td><?php if ($row['delivery']=="Y"){echo "送貨";} if ($row['delivery']=="C"){echo "街車";} if ($row['delivery']=="S"){echo "自取";} if($row['delivery']=="W"){echo "等電";}?></td>
   <td><?=$row['customer_detail']?></td>
   <td><?=$row['sales_name']?></td>
    <td><?=$row['total_price']?></td>
	  <td><? if ($row['deposit_method']=='D') echo "會員賑戶扣數";?></td>
	<?php 
	//20100525
	if (($AREA=="Y" && $PC=="99") || ($AREA=="Y" && $PC=="1") ){ 
	?>
	<td><?echo $row['created_by']."/".$row['last_update_by'];?></td>
	<?php 
	} 
	?>
    <td><a href="/?page=invoice_void&subpage=invoice_view.php&id=<?=$row['invoice_no']?>">View</a></td>
  
   <td><a  href="/invoice/pdf/<?=$row['invoice_no']?>.pdf">Print</a></td></tr>
		 <? }
   ?>
</table><?php echo $turnover;?>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "invoice_date_start",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  Calendar.setup(
    {
      inputField  : "invoice_date_end",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
    Calendar.setup(
    {
      inputField  : "delivery_date_start",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar3"       // ID of the button
      
    }
  );
    Calendar.setup(
    {
      inputField  : "delivery_date_end",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar4"       // ID of the button
      
    }
  );
  
  
  $('#invoice_action_all').click(function(e){
    var table= $(e.target).closest('table');
    $('td input:checkbox',table).prop('checked',this.checked);
});

function submitForm(action) {
	 
        var myCheckboxes = new Array();
		var checked_box = $('input[name="invoice_action[]"]:checked');
		
		if (checked_box.length>0){
        $('input[name="invoice_action[]"]:checked').each(function() {
           myCheckboxes.push($(this).val());
        });

        $.ajax({
            type: "POST",
            url: "/?page=invoice_void&subpage=invoicelist_action.php",
            dataType: 'html',
            data: { 
                    myCheckboxes:myCheckboxes,action:action },
            success: function( data){
                    $('#response pre').html( data );
                } 
		});
		
		}
		console.log(myCheckboxes);
		 
		return false;
} 
</script>
 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<? 
include_once("../include/config.php");
if (($AREA=="Y" && $PC=="1")  || ($AREA=="Y" && $PC=="99")){ ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-TW" lang="zh-TW">
<head>
<link rel="stylesheet" href="../include/invoice_style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #5E5E5E}
-->
</style>
<style type="text/css">
@import url(../include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="../include/cal/calendar.js"></script>
<script type="text/javascript" src="../include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="../include/cal/calendar-setup.js"></script></head>
<body><?php
   
   $db = DB::connect($dsn);
    if (DB::isError($connection))
      die($connection->getMessage());
   
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");
  $sql="SELECT * FROM staff where name !='' ";
	 $staffResult = $db->query($sql);
  
	$checking=0;
   	if ($created_by=="" && $invoice_no!="" && $mem_id=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end==""  && $sales=="")
	  $sql="SELECT a.amend_invoice_id,a.amend_by,a.amend_date,a.amend_sales_name,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice_amend a where a.invoice_no = '".$invoice_no."'";
	   else if ($created_by=="" &&  $mem_id!="" && $invoice_no=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end==""  && $sales==""){
	   $sql="SELECT a.amend_invoice_id,a.amend_by,a.amend_date,a.amend_sales_name,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice_amend a where a.member_id='".$mem_id."'";
	    $sqlCount= " Select count(*) as total  from invoice_amend a where a.member_id='".$mem_id."'";
	   }
	   else if ($created_by=="" &&  $goods_partno!="" && $mem_id=="" && $invoice_no=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end==""  && $sales==""){
	   $sql ="SELECT a.amend_invoice_id,a.amend_by,a.amend_date,a.amend_sales_name,a.created_by,a.last_update_by,a.call_count,a.total_price, a.total_price,a.invoice_no,a.invoice_date, a.delivery_date,a.customer_name,a.member_id,a.branchID,a.delivery, a.sales_name,a.settle  from invoice_amend a ,goods_invoice_amend b where a.invoice_no=b.invoice_no and b.goods_partno='".$goods_partno."'";
	    $sqlCount= " Select count(*) as total   from invoice_amend a ,goods_invoice_amend b where a.invoice_no=b.invoice_no and b.goods_partno='".$goods_partno."'";
	   }
	   else if ($created_by=="" &&  $customer_detail!="" && $mem_id=="" && $invoice_no=="" && $goods_partno=="" &&  $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end==""  && $sales=="")
	   $sql="SELECT a.amend_invoice_id,a.amend_by,a.amend_date,a.amend_sales_name,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice_amend a where a.customer_detail like '%".$customer_detail."%'";
	   else if ($created_by=="" && $invoice_status!="" && $mem_id=="" && $invoice_no=="" && $goods_partno=="" && $customer_detail ==""  && $invoice_date_start=="" && $invoice_date_end==""  && $sales=="")
	   $sql="SELECT a.amend_invoice_id,a.amend_by,a.amend_date,a.amend_sales_name,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice_amend a where a.settle like 'S' ";
	   else if ($created_by==""  && $invoice_date_start!="" && $invoice_date_end!="" && $mem_id=="" && $invoice_no=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status==""  && $sales=="" )
	   $sql="SELECT a.amend_invoice_id,a.amend_by,a.amend_date,a.amend_sales_name,a.created_by,a.last_update_by,a.call_count,a.total_price,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle  from invoice_amend a where a.invoice_date >= '".$invoice_date_start." 00:00:00' and a.invoice_date <='".$invoice_date_end." 23:59:00' ";
	   else if ($created_by=="" && $invoice_no=="" && $mem_id=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end=="" && $sales=="")	{
	  		$sql="SELECT a.amend_invoice_id,a.amend_by,a.amend_date,a.amend_sales_name,a.created_by,a.last_update_by,call_count,total_price,invoice_no,invoice_date,delivery_date,customer_name,member_id,branchID,delivery, sales_name,settle FROM invoice_amend a";
	  	    $sqlCount= " Select count(*) as total FROM invoice_amend a ";
	// $sql="SELECT * FROM invoice order by invoice_no desc";
		} else{
			
			//join invoice_item
			if ($goods_partno!=""){
				$sql="SELECT a.amend_invoice_id,a.amend_by,a.amend_date,a.amend_sales_name,a.created_by,a.last_update_by,a.total_price,a.invoice_no,a.invoice_date,a.delivery_date,a.customer_name,a.member_id,a.branchID,a.delivery, a.sales_name,a.settle  from invoice_amend as a,goods_invoice_amend_amend as b where a.invoice_no=b.invoice_no and b.goods_partno='".$goods_partno."' ";
				$checking=1;
			}else{
				$sql="SELECT a.amend_invoice_id,a.amend_by,a.amend_date,a.amend_sales_name,a.created_by,a.last_update_by,a.total_price,a.invoice_no,a.invoice_date,a.delivery_date,a.customer_name,a.member_id,a.branchID,a.delivery, a.sales_name,a.settle  from invoice_amend as a where ";
				$checking=0;
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
			if ($invoice_date_start!="" && $invoice_date_end==""){
					if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.invoice_date >='".$invoice_date_start." 00:00:00' and a.invoice_date <='".$invoice_date_start." 23:59:00' ";
						$checking++;
			}
		    
			
			if ($sales!=""){
					if ($checking>=1) 
					$sql.=" and ";
					$sql.= " a.sales_name ='".$sales."' ";
					$checking++;
			}
	
	   }
		$sql.=" order by a.amend_invoice_id desc ";   
  
	//cal total count first;
	if ($sqlCount!=""){
	 $result = $db->query($sqlCount);
		 while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$countTotal=$row["total"];
		 }
	}
	//echo $countTotal;
	 
   require "../include/Pager.class.php";

   include('Pager_header.php');

	
 // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?>
   
<form name="search" action="invoicelist_amend.php" method="POST">
<div><label>發票編號：</label>
<input name="invoice_no" type="text" class="buttonstyle"  id="invoice_no" size="10" maxlength="10" /></div>
<div><label class="style7">客戶編號：</label>
<input name="mem_id" type="text" class="buttonstyle"  id="mem_id" size="10" maxlength="10" /></div>
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
<div><label>掛單：</label>
  <input name="invoice_status" type="checkbox" id="invoice_status" value="S" />
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
 
<input type="submit" name="button" value="查貨單"/>
</form>
<hr/>
<a href="../">回主頁</a>
   <hr/>
<?=$turnover?>
<table  width="100%" bgcolor="#2E2E2E" border="0" cellpadding="1" cellspacing="1">
<TR bgcolor="#5E5E5E" align="center" style="font-weight:bold" ><TD width="50" height="23" bgcolor="#006633"> 更改編號</TD>
<TD width="50" height="23" bgcolor="#006633"> 更改員工</TD>
<TD width="50" height="23" bgcolor="#006633"> 更改員工電腦</TD>
<TD width="50" height="23" bgcolor="#006633"> 更改時間</TD>
<TD width="50" height="23" bgcolor="#006633"> 發票編號</TD>
<TD width="107" bgcolor="#006633"> 發票日期</TD>
<TD width="107" bgcolor="#006633">送貨日期 </TD>
<td width="78" bgcolor="#006633">客戶名稱</td>
<TD width="94" bgcolor="#006633">會員編號</TD>
<TD width="67" bgcolor="#006633">分店</TD>
<TD width="88" bgcolor="#006633">送貨</td>
<TD width="100" bgcolor="#006633">售貨員</TD>
<TD width="100" bgcolor="#006633">單總</TD>
<?php 
//20100525
if (($AREA=="Y" && $PC=="99") || ($AREA=="Y" && $PC=="1") ){ 
?>
<TD width="100" bgcolor="#006633">機號</TD>
<?php 
} 
?>
<TD width="32" bgcolor="#006633">編輯</td>
 
</TR>

    <?php 
	
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   ?><tr valign="middle" align="center"  <? if($row['settle']=="S"){echo "class='b'\"";echo " onMouseOut=\"this.className='b'\"";echo " onMouseOver=\"this.className='normal'\"";}else if ($row['settle']=="A") { echo " onMouseOut=\"this.className='normal'\"";echo " onMouseOver=\"this.className='highlight'\"";} else if ($row['settle']=="D") { echo "class='deposit'\""; echo " onMouseOut=\"this.className='deposit'\"";echo " onMouseOver=\"this.className='highlight'\"";}?>   " />
   <td><?=$row['amend_invoice_id']?></td>
     <td><?=$row['amend_sales_name']?></td>
     <td><?=$row['amend_by']?></td>
   <td><?=$row['amend_date']?></td>
   <td><? if ($row['call_count']>0) echo "*" ; ?><?=$row['invoice_no']?></td>
   <td><?=$row['invoice_date']?></td>
   <td><?=$row['delivery_date']?></td>
   
   <td><?=$row['customer_name']?></td>
   <td><?=$row['member_id']?></td>
   <td><?=$row['branchID']?></td>
   <td><?=$row['delivery']?></td>
   <td><?=$row['sales_name']?></td>
    <td><?=$row['total_price']?></td>
	<?php 
	//20100525
	if (($AREA=="Y" && $PC=="99") || ($AREA=="Y" && $PC=="1") ){ 
	?>
	<td><?echo $row['created_by']."/".$row['last_update_by'];?></td>
	<?php 
	} 
	?>
   <td><a  href="invoice_edit_amend.php?id=<?=$row['amend_invoice_id']?>">Edit</a></td>
   </tr>
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
</script>
</body></html>
<? } ?>
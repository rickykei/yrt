
<link rel="stylesheet" href="./include/invoice_style.css" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #5E5E5E}
-->
</style>
<?php
// US national format, using () for negative numbers
// and 10 digits for left precision
setlocale(LC_MONETARY, 'en_US');
   include_once("./include/config.php");
   $db = DB::connect($dsn);
    if (DB::isError($connection))
      die($connection->getMessage());
   
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");
  $sql="SELECT * FROM staff where name !='' ";
	 $staffResult = $db->query($sql);
  
	$checking=0;
	if ($created_by=="" && $invoice_no=="" && $mem_id=="" && $goods_partno=="" && $customer_detail =="" && $invoice_status=="" && $invoice_date_start=="" && $invoice_date_end=="" && $sales=="")	{
	  		$sql="SELECT id,daily_revenue,daily_expend,daily_cheque,daily_creditcard,daily_unionpay,daily_eps,daily_cash,daily_income,daily_drawer,past_daily_drawer,drawer_diff,area,invoice_date,created_by,created_date,pc,modified_by,modified_date,sts FROM misc a";
	  	    $sqlCount= " Select count(*) as total FROM misc a ";
	// $sql="SELECT * FROM invoice order by invoice_no desc";
		} else{
			
		 
	   }
		$sql.=" order by id desc ";   
  
 
	//cal total count first;
	if ($sqlCount!=""){
	 $result = $db->query($sqlCount);
		 while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$countTotal=$row["total"];
		 }
	}
	//echo $countTotal;
	 
   require "./include/Pager.class.php";

   include('./misc/Pager_header.php');



	
 // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?>
   
<form name="search" action="/?page=misc&subpage=misc_list.php" method="POST">
 
 
<div><label>鋪</label>
  <select name="sales" id="sales">
              <option value="" > </option>
			  <option value="A" >A</option>
			   <option value="Y" >Y</option>
                </select>
</div>
 
<input type="submit" name="button" value="查貨單"/>
</form>
<hr/>
<a href="../">回主頁</a>
   <hr/>
<?=$turnover?>
<table  width="100%" bgcolor="#2E2E2E" border="0" cellpadding="1" cellspacing="1">
<TR bgcolor="#5E5E5E" align="center" style="font-weight:bold" ><TD width="50" height="23" bgcolor="#006633"> 發票編號</TD>
<TD width="107" bgcolor="#006633"> 發票日期</TD>
<TD width="107" bgcolor="#006633">分店 </TD>
<td width="78" bgcolor="#006633">生意總額</td>
<TD width="94" bgcolor="#006633">總支出</TD>
<TD width="67" bgcolor="#006633">支票</TD>
<TD width="67" bgcolor="#006633">信用卡</TD>
<TD width="67" bgcolor="#006633">銀聯卡</TD>
<TD width="67" bgcolor="#006633">EPS</TD>
<TD width="67" bgcolor="#006633">現金入數</TD>
<TD width="67" bgcolor="#006633">入數</TD>
<TD width="67" bgcolor="#006633">是日存柜</TD>
<TD width="67" bgcolor="#006633">昨日存柜</TD>
<TD width="67" bgcolor="#006633">差額</TD>
<TD width="67" bgcolor="#006633">PC</TD>
<TD width="67" bgcolor="#006633">PDF</TD> 
<TD width="67" bgcolor="#006633">更改出貨單PDF</TD> 
 
<TD width="32" bgcolor="#006633">EDIT</td>

</TR>

    <?php 
	
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   ?><tr valign="middle" align="center"   />
   <td><?=$row['id']?></td>
   <td><?=$row['invoice_date']?></td>
   <td><?=$row['area']?></td>
   <td><?=number_format($row['daily_revenue'],2)?></td>
   <td><?=number_format($row['daily_expend'],2)?></td>
   <td><?=number_format($row['daily_cheque'],2)?></td>
   <td><?=number_format($row['daily_creditcard'],2)?></td>
   <td><?=number_format($row['daily_daily_unionpay'],2)?></td>
   <td><?=number_format($row['daily_eps'],2)?></td>
   <td><?=number_format($row['daily_cash'],2)?></td>
   <td><?=number_format($row['daily_income'],2)?></td>
   <td><?=number_format($row['daily_drawer'],2)?></td>
   <td><?=number_format($row['past_daily_drawer'],2)?></td>
   <td><?=number_format($row['drawer_diff'],2)?></td>
   <td><?=$row['pc']?></td>
     <td><a  href="/misc/pdf/<?=$row['id']?>.pdf">Print</a></td>
       <td><a  href="/?page=invoice&subpage=invoice_edit_monthly_pdf.php&branchID=<?=$row['area']?>&date=<?=$row['invoice_date']?>">Print</a></td>
 
   <td><a  href="/?page=misc&subpage=misc_edit.php&id=<?=$row['id']?>">Edit</a></td>
 
		 <? }
   ?>
</table><?php echo $turnover;?>
  

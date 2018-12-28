<link rel="stylesheet" href="./css/inshop_style.css" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCCCCC;
}

-->
</style>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./js/inshop.js"></script></head>
<?php
  include_once("./include/config.php");
      require "./include/Pager.class.php";
   $query="SET NAMES 'UTF8'";
    $db = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $db->query("SET NAMES 'UTF8'");
 
 $sql_Search_Supplier="select * from supplier ";
 $SupplierResult = $db->query($sql_Search_Supplier);
 
   // (Run the query on the winestore through the connection 
   ?>
<body>
<form id="form1" name="form1" method="post" action="/?page=inshop&subpage=inshoplist.php">
    <div><label>供應商發票編號：</label>
  <input name="supplier_invoice_no" type="text" id="supplier_invoice_no" size="20" maxlength="20" class="buttonstyle"/>
</div>
   <div><label>入舖單編號：</label>
  <input type="text" name="inshop_no" class="buttonstyle" />
</div>
  <div><label>貨品編號：</label>
  <input name="goods_partno" class="buttonstyle"type="text" id="goods_partno" />
  </div>
    <div><label>貨品編號*：</label>
  <input name="goods_partno2" class="buttonstyle"type="text" id="goods_partno2" />
  </div>
      <div><label>入舖價：</label>
  <input name="market_price" class="buttonstyle"type="text" id="market_price" />
  </div>
  <div><label>貨品名稱：</label>
  <input name="goods_detail" class="buttonstyle"type="text" id="goods_detail" />
  </div>
  
  <div><label>入舖單日期：</label>
<input name="inshop_date_start" id="inshop_date_start" class="buttonstyle" type="text"  size="15"><input name="cal" id="calendar" value=".." type="button">
至
<input name="inshop_date_end" id="inshop_date_end" class="buttonstyle" type="text"  size="15" />
  <input name="cal2" id="calendar2" value=".." type="button" />
  </div><div><label>供應商：</label>
    <input name="suppliername" class="buttonstyle"type="text" id="supplier_name" />
    <input type="button" name="search2" value=".." onclick="javascript:popUp('/?page=inshop&subpage=page_search_supplier.php','650','350')" />
  </div>
  <input type="submit" value="搜尋"/>
 <input type="hidden" name="update" value="2"/>
</form>
<?php

 $checking=0;
     	 if ($suppliername=="" && $supplier_invoice_no!="" && $inshop_no=="" && $goods_partno=="" && $goods_partno2=="" && $market_price=="" && $inshop_date_start=="" && $inshop_date_end=="" && $goods_detail=="")
	 	$sql="SELECT * FROM inshop a where a.supplier_invoice_no like \"%".$supplier_invoice_no."%\"";
	 else if ($suppliername=="" && $inshop_no!="" && $invoice_no=="" && $goods_partno=="" && $inshop_date_start=="" && $inshop_date_end=="" && $goods_detail=="" && $goods_partno2=="" && $market_price=="")
	 	$sql="SELECT * FROM inshop a where a.inshop_no=".$inshop_no;
	 else if ($suppliername=="" && $goods_partno!="" && $inshop_no=="" && $supplier_invoice_no=="" && $inshop_date_start=="" && $inshop_date_end=="" && $goods_detail=="" && $goods_partno2=="" && $market_price=="")
	 	$sql="select a.inshop_date as inshop_date, a.inshop_no as inshop_no, a.supplier_name as supplier_name,a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name,a.count_price as count_price,a.discount_percent as discount_percent,a.total_price as total_price ,b.market_price as market_price,b.discount good_discount from goods_inshop b ,inshop a where b.inshop_no = a.inshop_no and b.goods_partno like \"".$goods_partno."\" group by a.inshop_no";
	 else if ($suppliername=="" && $inshop_date_start!="" && $inshop_date_end!="" && $goods_partno=="" && $inshop_no=="" && $supplier_invoice_no=="" && $goods_detail=="" && $goods_partno2=="" && $market_price=="")
	 	$sql="SELECT * from inshop a where a.inshop_date >= '".$inshop_date_start." 00:00:00' and a.inshop_date <='".$inshop_date_end." 23:59:00'";
		 else if ($suppliername!="" && $inshop_date_start=="" && $inshop_date_end=="" && $goods_partno=="" && $inshop_no=="" && $supplier_invoice_no=="" && $goods_detail=="" && $goods_partno2=="" && $market_price=="")
		 {
		// $sql=" select * from supplier where supplier.supplier_id='".$suppliername."'";
		//echo $sql;
		//  $SupplierResult = $db->query($sql);
		//  $supplierrow = $SupplierResult->fetchRow(DB_FETCHMODE_ASSOC);
		//20071006  
		 $sql="SELECT a.inshop_date as inshop_date,a.supplier_name as supplier_name, a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name, a.count_price as count_price, a.discount_percent as discount_percent,a.total_price as total_price,  a.inshop_no as inshop_no from inshop a where a.supplier_name like \"%".$suppliername."%\"";
		 }
		  else if ($suppliername=="" && $inshop_date_start=="" && $inshop_date_end=="" && $goods_partno=="" && $inshop_no=="" && $supplier_invoice_no=="" && $goods_detail!="" && $goods_partno2=="" && $market_price=="")
		 {
		 $sql="SELECT a.inshop_date as inshop_date,a.supplier_name as supplier_name, a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name, a.count_price as count_price, a.discount_percent as discount_percent,a.total_price as total_price,  a.inshop_no as inshop_no from inshop a, goods_inshop b where a.inshop_no=b.inshop_no and b.goods_detail like \"%".$goods_detail."%\"";
		 }
		 else if ($suppliername=="" && $inshop_date_start=="" && $inshop_date_end=="" && $goods_partno=="" && $inshop_no=="" && $supplier_invoice_no=="" && $goods_detail=="" && $goods_partno2!="" && $market_price=="")
		 {
		$sql="select a.inshop_date as inshop_date, a.inshop_no as inshop_no, a.supplier_name as supplier_name,a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name,a.count_price as count_price,a.discount_percent as discount_percent,a.total_price as total_price ,b.market_price as market_price from goods_inshop b ,inshop a where b.inshop_no = a.inshop_no and b.goods_partno like \"%".$goods_partno2."%\" group by a.inshop_no";
		 }
		  else if ($suppliername=="" && $inshop_date_start=="" && $inshop_date_end=="" && $goods_partno=="" && $inshop_no=="" && $supplier_invoice_no=="" && $goods_detail=="" && $goods_partno2=="" && $market_price!="")
		 {
		$sql="select a.inshop_date as inshop_date, a.inshop_no as inshop_no, a.supplier_name as supplier_name,a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name,a.count_price as count_price,a.discount_percent as discount_percent,a.total_price as total_price ,b.market_price as market_price from goods_inshop b ,inshop a where b.inshop_no = a.inshop_no and b.market_price = ".$market_price." group by a.inshop_no";
		 }
		 else if ($suppliername=="" && $inshop_date_start=="" && $inshop_date_end=="" && $goods_partno=="" && $inshop_no=="" && $supplier_invoice_no=="" && $goods_detail=="" && $goods_partno2=="" && $market_price=="")
		$sql="SELECT * FROM inshop a ";
	 else {
	 	if ($goods_partno!=""){
	 		$sql="select a.inshop_date as inshop_date,a.inshop_no as inshop_no, a.supplier_name as supplier_name,a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name,a.count_price as count_price,a.discount_percent as discount_percent,a.total_price as total_price ,b.market_price as market_price from goods_inshop  as b,inshop as a  where b.inshop_no = a.inshop_no and b.goods_partno like \"%".$goods_partno."%\" ";
			$checking=1;
	 	}else{
	 		$sql="select * from inshop as a  where ";
			$checking=0;
		}
		if ($supplier_invoice_no!=""){
			if ($checking==1) $sql.=" and ";
			$sql.=" a.supplier_invoice_no='".$supplier_invoice_no."' ";
		}
		if ($inshop_no!=""){
			if($checking==1) $sql.=" and ";
			$sql.=" a.inshop_no='".$inshop_no."' ";
		}
		if ($inshop_date_start!="" && $inshop_date_end!=""){
			if($checking==1) $sql.=" and ";
			$sql.=" a.inshop_date >= '".$inshop_date_start." 00:00:00' and a.inshop_date <='".$inshop_date_end." 23:59:00' ";
		}
		if ($suppliername!=""){
		    if($checking==1) $sql.=" and ";
			$sql.=" a.supplier_name='".$suppliername."' ";
		}
	}

$sql.=" order by a.inshop_no desc ";
//echo $sql;
   include('./inshop/Pager_header.php');
   ?>

<?

echo $turnover;
echo $Pager->numPages;
?>
<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
  <tr bgcolor="#006666">
    <td width="22" height="23" bgcolor="#006666"><div align="center"><strong>入舖單編號</strong></div></td>
    <td width="66" bgcolor="#006666"><div align="center"><strong>入舖單日期</strong></div></td>
	<td width="66" bgcolor="#006666"><div align="center"><strong>供應商名稱</strong></div></td>
    <td width="33" bgcolor="#006666"><div align="center"><strong>供應商發票編號</strong></div></td>
    <td width="22" bgcolor="#006666"><div align="center"><strong>職員</strong></div></td>
    <td width="10%" bgcolor="#006666"><div align="center"><strong>總數 </strong></div></td>
    <td width="5%" bgcolor="#006666"><div align="center"><strong>整單折扣</strong></div></td>
    <td width="10%" bgcolor="#006666"><div align="center"><strong>應付金額</strong></div></td>
	<?if ($goods_partno!=""){?>
    <td width="9%" bgcolor="#006666"><div align="center"><strong>搜尋貨品編號</strong></div></td>
	<td width="7%" bgcolor="#006666"><div align="center"><strong>單件入舖價</strong></div></td>
    	<td width="7%" bgcolor="#006666"><div align="center"><strong>單件折扣</strong></div></td>
	<?}?>
    <td width="5%" bgcolor="#006666"><div align="center"><strong>修改</strong></div></td>
  </tr>
  <?php 
	for ($i=0;$i<count($result);$i++)
	{ 
	$row=$result[$i];
	
   ?><tr valign="middle" align="center" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'"><td class="style7">    <?=$row['inshop_no']?>
  </td>
  <td class="style7">    <?=$row['inshop_date']?>  </td>
  <td class="style7">    <?=$row['supplier_name']?>  </td>
  <td class="style7">    <?=$row['supplier_invoice_no']?>  </td>
  <td class="style7">    <?=$row['staff_name']?>  </td>
  <td class="style7">    <?=$row['count_price']?>  </td>
  <td class="style7">    <?=$row['discount_percent']?>  </td>
  <td class="style7">    <?=$row['total_price']?>  </td>
  	<?if ($goods_partno!=""){?>
   	<td class="style7"><div align="center"><?=$goods_partno?></strong></div></td>
	<td class="style7"><div align="center"><?=$row['market_price']?></strong></div></td>
   <td class="style7"><div align="center"><?=$row['good_discount']?></strong></div></td>
	<?}?>
  <td><a href="/?page=inshop&subpage=inshopedit.php&inshop_no=<?=$row['inshop_no']?>&update=2&goods_partno2=<?=$goods_partno2?>&goods_partno=<?=$goods_partno?>&goods_detail=<?=$goods_detail?>&market_price=<?=$market_price?>" class="b">修改</a></td>
  </tr>
<?
		 }
   ?>
</table>
<?php echo $turnover;?>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "inshop_date_start",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  Calendar.setup(
    {
      inputField  : "inshop_date_end",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
</script> 
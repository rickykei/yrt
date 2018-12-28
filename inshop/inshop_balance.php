<link rel="stylesheet" href="./css/inshop_style.css" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCCCCC;
}

-->
</style>
<script type="text/javascript" src="./js/inshop.js"></script>
<?php
  include_once("./include/config.php");
     // require "./include/Pager.class.php";
   $query="SET NAMES 'UTF8'";
    $db = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $db->query("SET NAMES 'UTF8'");
 if ($goods_partno!="")
 $goods_partno_arr=explode(",",$goods_partno);
    
 ?>
<body> 
<form id="form1" name="form1" method="post" action="/?page=inshop&subpage=inshop_balance.php">
     
  <div><label>貨品編號：</label>
  <textarea name="goods_partno" class="buttonstyle"type="text" id="goods_partno" rows="4" cols="50" /><?if ($goods_partno!=""){echo $goods_partno;}else {echo "121-1,131-1,RIC,D161M";}?></textarea>
  </div> 
   
    
  <input type="submit" value="搜尋"/>
 <input type="hidden" name="update" value="2"/>
</form>
<?php

 $checking=0;
   
	
	

//echo $sql;
  // include('./inshop/Pager_header.php');
   ?>

<?

//echo $turnover;
//echo $Pager->numPages;
?>
<table   border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
  <tr  >
    <td   height="23" class="heading2""><div align="center"><strong>貨品編號</strong></div></td>
    <td width="66" class="heading2"><div align="center"><strong>備存量</strong></div></td>
	<td width="66" class="heading2"><div align="center"><strong>入舖量</strong></div></td>
    <td   class="heading2"><div align="center"><strong>出貨量</strong></div></td>
    <td  class="heading2"><div align="center"><strong>碎料出貨量</strong></div></td>
    <td  class="heading2"><div align="center"><strong>餘量</strong></div></td>
    <td   class="heading2"><div align="center"><strong>應補貨量</strong></div></td> 
	 
 
  </tr>
  <?php 
	for ($i=0;$i<count($goods_partno_arr);$i++)
	{ 
	 $goods_partno=trim($goods_partno_arr[$i]);
	
   ?><tr valign="middle" align="center" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'"> 
  <td class="style7">    <?=$goods_partno ?>  </td>
  
  <td class="style7"> 
  <?
   if ($goods_partno!="" ){
		$sql="select inshop_quota from sumgoods where goods_partno=\"$goods_partno\"";
		 
		 $SumGoodsResult = $db->query($sql);
		  $SumGoodsRow = $SumGoodsResult->fetchRow(DB_FETCHMODE_ASSOC);
      echo $SumGoodsRow['inshop_quota'];
   }?></td>
   
  <td class="style7"> 
<?
   if ($goods_partno!="" ){
		$sql="select sum(qty) as sumqty from goods_inshop where goods_partno=\"$goods_partno\" and deductstock='Y'";
		 
		 $GoodsInshopResult = $db->query($sql);
		  $GoodsInshopRow = $GoodsInshopResult->fetchRow(DB_FETCHMODE_ASSOC);
      echo $GoodsInshopRow['sumqty'];
   }?>  
  </td>
  <td class="style7">  
<?
   if ($goods_partno!="" ){
		$sql="select sum(qty) as sumqty from goods_invoice where goods_partno=\"$goods_partno\" and delivered='Y'";
		 
		 $GoodsInvoiceResult = $db->query($sql);
		  $GoodsInvoiceRow = $GoodsInvoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
      echo $GoodsInvoiceRow['sumqty'];
   }?>  
   </td>
  <td class="style7"><?
   if ($goods_partno!="" ){
		$sql="select sum(qty) as sumqty from goods_scrap where goods_partno=\"$goods_partno\" and delivered='Y'";
		 
		 $GoodsScrapResult = $db->query($sql);
		  $GoodsScrapRow = $GoodsScrapResult->fetchRow(DB_FETCHMODE_ASSOC);
      echo $GoodsScrapRow['sumqty'];
   }?>  </td>
  <td class="style7"><? $total= $GoodsInshopRow['sumqty']-$GoodsInvoiceRow['sumqty']-$GoodsScrapRow['sumqty'];echo $total;?></td>
  <td class="style7"><?php echo $SumGoodsRow['inshop_quota']-$total?></td>
   
  </tr>
<?
		 }
   ?>
</table>
<?php echo $turnover;?>
 
</body>
</html>

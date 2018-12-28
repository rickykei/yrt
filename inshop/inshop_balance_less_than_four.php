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
</head>
<?php
  include_once("./include/config.php");
      require "./include/Pager.class.php";
   $query="SET NAMES 'UTF8'";
    $db = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $db->query("SET NAMES 'UTF8'");
 if ($goods_partno!=""){
		$sql="select goods_partno  from sumgoods where goods_partno like \"$goods_partno%\" ";
		  
  }else{
	$sql="select goods_partno from sumgoods where goods_partno in ('D101','D102','D174','D226','D228','D105HG','D107','D110','D115','D116','D118','D119','D120','D121','D123','D124','D125','D134','D140','D146','D150','D151','D152','D155','D156','D157','D162','D165','D172','D173','D177','D179','D180','D181','D185','D186','D188','D191','D192','DS101','DS102','DS106','DS110','DS115','DS116','DS117','DS120','DS121','DS123','DS124','DS125','DS133','DS134','DS140','DS142','DS143','DS144','DS146','DS150','DS151','DS152','DS155','DS156','DS157','DS160','DS164','DS165','DS166','DS173','DS179','DS180','DS181','DS182','DS183','DS185','DS186','DS188','DS191','DS192','DS195','DS197','DS198','DS199','DS228','DPI352','DPS353','DPS354','DPS356','DPS357','DPS358','DPS359','DPS360','DPS361','DPS362','DPS363','DPS364','DPS365','DS325','DS326','DS339','DS343','DS344','DS345','DS346','DS347','DS349','DS350','DS380','DS381','DS382','DS384','DS385','DS387','DS388','DS389','DS390','DS391','DS392','DS394','DS395','DS396','DS397','DS398','DS399','DS501','DS502','DS503','DS504','DS505','D1331','D1332','D1334','D1329G','D1330G','D1335G','D1336G','D1337G','D1338G','D1339G','D318G','D319G','D111','DS111','D111G','D163','DS163','D100G','DS341','D5100','D158G','D225','DS100','D100M','V8101','V8102','V8107','V8110','V8115','V8116','V8118','V8119','V8120','V8121','V8123','V8124','V8125','V8134','V8140','V8146','V8150','V8151','V8152','V8155','V8156','V8157','V8162','V8165','V8172','V8173','V8174','V8177','V8179','V8180','V8181','V8185','V8186','V8188','V8191','V8192','V8225','V8226','V9259','V9260','V9261','V9269','V9270','V9279','V9280','V9281','V9284','V9291','V9295','V9296','V9300','V9302','V9303','V9307','V9310','V9320','V9322','V9326','V9338','V9340','V9343','V9344','V9345','V9348','V9349','V9353','V9354','V9356','V9372','V9393','V9374','V9375','V9376','V9377','V9378','V9379','V9380','V9381','V9382','V9383','V9384','V9385','V9386','V9389','V9390','V9391','V9392','V9393','V9394','V9395','V9396','V9397','V9398','V9399','V9400','V9401','V9402','V9403','V8100G','V8163','V8111','V8111G','D223','D122','D187','DS122','DS159','D260','DS336','DS386','D393','V8122','V8187','V9888','D161','D323','D159','D238','D113','DPS325','D236','D114','D115','DS329','DS189','DS171','DS383','V9325A','V9347','V9388','DPS344','D327G','D328G','D331G','DS170','V9297','D223','D170','V8170','D276', 'D275','D274','D272','D261','D260','D258','D256','D252','D251','D275','D273','D262','D263','D271','D272','D274','D254','D256','D258','D259','D261')";
	}
 ?>
<body> 
<form id="form1" name="form1" method="post" action="/?page=inshop&subpage=inshop_balance_less_than_four.php">
     
  <div><label>貨品編號：</label>
  <textarea name="goods_partno" class="buttonstyle"type="text" id="goods_partno" rows="1" cols="50" /><?if ($goods_partno!=""){echo $goods_partno;}else {echo "";}?></textarea>
  
  </div> 
 
  <label> 數量小於：</label><input type="text" name="quota" id="quota" value="<?if ($quota!=""){echo $quota;}else {echo "4";}?>"   class="buttonstyle"> 
   
  <input type="submit" value="搜尋"/>
    <br>
	  <br>
 <input type="hidden" name="update" value="2"/>
</form>
<?php

 $checking=0;
   
	
	

//echo $sql;
   include('./inshop/Pager_header2.php');
   ?>

<?

echo $turnover;
echo $Pager->numPages;

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
  
 
  for ($i=0;$i<count($result);$i++)
	{ 
	$aa=$result[$i];
	$goods_partno=$aa['goods_partno'];
	
	  
		if ($goods_partno!="" ){
			 //cal inshop quota
			$sql="select inshop_quota from sumgoods where goods_partno=\"$goods_partno\"";
			$SumGoodsResult = $db->query($sql);
			$SumGoodsRow = $SumGoodsResult->fetchRow(DB_FETCHMODE_ASSOC);
		    $tmp_sumgood=$SumGoodsRow['inshop_quota'];
		 
		    $sql="select sum(qty) as sumqty from goods_inshop where goods_partno=\"$goods_partno\" and deductstock='Y'";
		    $GoodsInshopResult = $db->query($sql);
		    $GoodsInshopRow = $GoodsInshopResult->fetchRow(DB_FETCHMODE_ASSOC);
		    $tmp_goods_inshop= $GoodsInshopRow['sumqty'];
		  
			$sql="select sum(qty) as sumqty from goods_invoice where goods_partno=\"$goods_partno\" and delivered='Y'";
			$GoodsInvoiceResult = $db->query($sql);
			$GoodsInvoiceRow = $GoodsInvoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
			$tmp_goods_invoice=$GoodsInvoiceRow['sumqty'];
			
			$sql="select sum(qty) as sumqty from goods_scrap where goods_partno=\"$goods_partno\" and delivered='Y'";
			$GoodsScrapResult = $db->query($sql);
			$GoodsScrapRow = $GoodsScrapResult->fetchRow(DB_FETCHMODE_ASSOC);
			$tmp_goods_scrap=$GoodsScrapRow['sumqty'];
			
			$total= $tmp_goods_inshop-$tmp_goods_invoice-$tmp_goods_scrap;
			$fillintotal= $tmp_sumgood-$total;
	   }
	  
	 if ($total<$quota){
   ?><tr valign="middle" align="center" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'"> 
  <td class="style7">    <?=$goods_partno ?>  </td>
  
  <td class="style7"> <?php echo $tmp_sumgood;?>  </td>
  <td class="style7"> <?php echo $tmp_goods_inshop;?>      </td>
  <td class="style7">   <?php echo $tmp_goods_invoice;?>    </td>
  <td class="style7"><?php echo $tmp_goods_scrap;?></td>
  <td class="style7"><?php echo $total; ?></td>
  <td class="style7"><?php echo $fillintotal;?></td>
   
  </tr>
<?
	}
}
   ?>
</table>
<?php echo $turnover;?>
 
 

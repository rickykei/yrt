<?php
require_once("./include/config.php");
require_once("./include/functions.php");
$connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
   $result = $connection->query("SET NAMES 'UTF8'");
   
 
   function security_check($AREA,$PC){
	if (($AREA=="Y" && $PC=="1")  || ($AREA=="Y" && $PC=="99")){
		
			return TRUE;}
	else{
		
			return TRUE;
		}
	} 
	
if (security_check($AREA,$PC)){
 

  
 //  	$month=date("m");
	//$year=date("Y");

?><style type="text/css">
<!--
body,td,th ,tr{
	font-size: 11px;
}
.yrtfont {
	font-size: 13px;
	font-weight: normal;
	font-style: normal;
}
.yrtfontBold {
	font-size: 15px;
	font-weight: bold;
	font-style: normal;
}
-->
</style>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<!--<link type="text/css" href="../themes/base/ui.all.css" rel="stylesheet" />-->
<!--<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>-->
<script type="text/javascript" src="./js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="./ui/ui.core.js"></script>
<script type="text/javascript" src="./ui/ui.tabs.js"></script>
<!--<link type="text/css" href="../css/demos.css" rel="stylesheet" />-->
<link type="text/css" href="./css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script src="./src/js/jscal2.js"></script>
<script src="./src/js/lang/en.js"></script>
<link type="text/css" rel="stylesheet" href="./src/css/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./src/css/border-radius.css" />
<link id="skinhelper-compact" type="text/css" rel="alternate stylesheet" href="./src/css/reduce-spacing.css" />
</head>
<?
//find modelname
$modelsql="select model from sumgoods group by model";
 
	$modelResult = $connection->query($modelsql);
	
	$i=0;
		while($row=$modelResult->fetchRow(DB_FETCHMODE_ASSOC)){
			
			$modelSelect[$i]=$row['model'];
			$i++;
		}
	   
	   
 if ($day!="" && $year != ""){
	 
	$invoiceItem=predictSpecifyDate($day,$month,$year,$modelSelectR,0,"");

}

 
	?>
<form name="form1" method="POST" action="/?page=prediction&subpage=index.php">
<input type="hidden" name="year" id="year" value="<?php echo $year;?>" />
<input type="hidden" name="month" id="month" value="<?php echo $month;?>" />
<input type="hidden" name="day" id="day" value="<?php echo $day;?>" />
<table width="100%" align="center">
      <tr>
        <td width="400" valign="top" >
          <div id="cont"></div>
          <script type="text/javascript">
            var LEFT_CAL = Calendar.setup({
                    cont: "cont",
                    weekNumbers: true,
                    selectionType: Calendar.SEL_MULTIPLE,
                    showTime: 24
                    // titleFormat: "%B %Y"
            })
          </script></td>
		<td>
<input type="text" id="f_selection" name="f_selection"  value="<?=$f_selection?>"/>
<select name="modelSelectR" id="modelSelectR">
<?php 
for ($i=0;$i<count($modelSelect);$i++){
?><option value="<?php echo $modelSelect[$i];?>"><?php echo $modelSelect[$i];?></option>	
<?
}

?></select>

<input type="submit"  name="submit" id="monthreportsubmit"  />
<script type="text/javascript">
LEFT_CAL.addEventListener("onSelect", function(){
var ta = document.getElementById("f_selection");
var year = document.getElementById("year");
var month = document.getElementById("month");
var day = document.getElementById("day");
 ta.value = this.selection.print("%Y/%m/%d").join("\n");
 year.value = this.selection.print("%Y");
  month.value = this.selection.print("%m");
   day.value = this.selection.print("%d");
 });</script>
</td></tr>
</table></form>
 


<hr>
 

 <?php 
 for($j=1;$j<4;$j++){
	 
	 if($j==1)
		  echo "<div align=\"center\">早 8 - 11</div>";
	 if($j==2)
		 echo "<div align=\"center\">午 11-2</div>";
	 if($j==3)
		 echo "<div align=\"center\">晚 2-6</div>";
	 
	 ?>
	  <table border="1" align="center">
 <TR><td>貨品編號</td><td>貨品名稱</td><td>分類</td><td>出單量</td><td>碎料出貨量</td><td>入鋪量</td><td>儲貨量</td><td>入貨預測(件)</td><td>入貨預測(箱)</td><td>(箱)</td><td>(入舖備用量)</td><td>今天出貨量</td></tr>
 <?
  for ($i=0;$i<count($invoiceItem[$j]);$i++)
  {
	  $bal=$invoiceItem[$j][$i]['in']-$invoiceItem[$j][$i]['out']-$invoiceItem[$j][$i]['scrap'];
	  $quota=$invoiceItem[$j][$i]['quota'];
	  $inqty=$invoiceItem[$j][$i]['quota']-$bal;
	  if($inqty<1)$inqty=0;
	  if ($invoiceItem[$j][$i]['box']!=0)
	  $inbox=ceil($inqty/$invoiceItem[$j][$i]['box']);
		else
			$inbox="沒有箱紀錄";
	 ?><tr><td><?php echo $invoiceItem[$j][$i]['goods_partno'];?></td><td><?php echo $invoiceItem[$j][$i]['goods_detail'];?></td><td><?php echo $invoiceItem[$j][$i]['model'];?></td><td><?php echo $invoiceItem[$j][$i]['out'];?></td><td><?php echo $invoiceItem[$j][$i]['scrap'];?></td><td><?php echo $invoiceItem[$j][$i]['in'];?></td><td><?php echo $bal;?></td><td><?php echo $inqty ?></td><td><?php echo $inbox ?></td><td><?php echo $invoiceItem[$j][$i]['box']?></td><td><?php echo $quota;?></td><td><?php echo $invoiceItem[$j][$i]['todayPartNoOutTotal'];?></td></tr><?
  }
  ?> </table><p><?php
 }
?>
<hr>
  <?php 
   $tmps_exclude_item_for_3days="";
 for($j=1;$j<4;$j++){
	 
	 if($j==1)
		  echo "<div align=\"center\">早 8 - 11</div>";
	 if($j==2)
		 echo "<div align=\"center\">午 11-2</div>";
	 if($j==3)
		 echo "<div align=\"center\">晚 2-6</div>";
	 
	 ?>
	  <table border="1" align="center">
	  <tr><td colspan="11">提貨單預測: 將需要反貨</td></tr>
 <TR><td>貨品編號</td><td>貨品名稱</td><td>分類</td><td>出單量</td><td>碎料出貨量</td><td>入鋪量</td><td>儲貨量</td><td>入貨預測(件)</td><td>入貨預測(箱)</td><td>(箱)</td><td>(入舖備用量)</td><td>今天出貨量</td></tr>
 <?

  for ($i=0;$i<count($invoiceItem[$j]);$i++)
  {
	   
	  $tmps_exclude_item_for_3days=$tmps_exclude_item_for_3days.'"'.$invoiceItem[$j][$i]['goods_partno'].'",';
	  $bal=$invoiceItem[$j][$i]['in']-$invoiceItem[$j][$i]['out']-$invoiceItem[$j][$i]['scrap'];
	  $quota=$invoiceItem[$j][$i]['quota'];
	  $inqty=$invoiceItem[$j][$i]['quota']-$bal;
	  if($inqty<1)$inqty=0;
	  if ($invoiceItem[$j][$i]['box']!=0)
	  $inbox=ceil($inqty/$invoiceItem[$j][$i]['box']);
		else
		$inbox="沒有箱紀錄";
	
	
	
	if ($inqty>0){ 
	 ?><tr><td><?php echo $invoiceItem[$j][$i]['goods_partno'];?></td><td><?php echo $invoiceItem[$j][$i]['goods_detail'];?></td><td><?php echo $invoiceItem[$j][$i]['model'];?></td><td><?php echo $invoiceItem[$j][$i]['out'];?></td><td><?php echo $invoiceItem[$j][$i]['scrap'];?></td><td><?php echo $invoiceItem[$j][$i]['in'];?></td><td><?php echo $bal;?></td><td><?php echo $inqty ?></td><td><?php echo $inbox ?></td><td><?php echo $invoiceItem[$j][$i]['box']?></td><td><?php echo $quota;?></td><td><?php echo $invoiceItem[$j][$i]['todayPartNoOutTotal'];?></td></tr><?
  }
  }
  ?> </table><p><?php
 }
?>


<hr>
  <?php 
 
  $invoiceItem=predictSpecifyDate($day,$month,$year,$modelSelectR,1,substr($tmps_exclude_item_for_3days, 0,-1));
  
 for($j=1;$j<4;$j++){
	 
	 if($j==1)
		  echo "<div align=\"center\">早 8 - 11</div>";
	 if($j==2)
		 echo "<div align=\"center\">午 11-2</div>";
	 if($j==3)
		 echo "<div align=\"center\">晚 2-6</div>";
	 
	 ?>
	  <table border="1" align="center">
	  <tr><td colspan="11">3日前提貨單預測:</td></tr>
 <TR><td>貨品編號</td><td>貨品名稱</td><td>分類</td><td>出單量</td><td>碎料出貨量</td><td>入鋪量</td><td>儲貨量</td><td>入貨預測(件)</td><td>入貨預測(箱)</td><td>(箱)</td><td>(入舖備用量)</td><td>今天出貨量</td></tr>
 <?
  for ($i=0;$i<count($invoiceItem[$j]);$i++)
  {
	  $bal=$invoiceItem[$j][$i]['in']-$invoiceItem[$j][$i]['out']-$invoiceItem[$j][$i]['scrap'];
	  $quota=$invoiceItem[$j][$i]['quota'];
	  $inqty=$invoiceItem[$j][$i]['quota']-$bal;
	  if($inqty<1)$inqty=0;
	  if ($invoiceItem[$j][$i]['box']!=0)
	  $inbox=ceil($inqty/$invoiceItem[$j][$i]['box']);
		else
		$inbox="沒有箱紀錄";
	
	if ($inqty>0){ 
	 ?><tr><td><?php echo $invoiceItem[$j][$i]['goods_partno'];?></td><td><?php echo $invoiceItem[$j][$i]['goods_detail'];?></td><td><?php echo $invoiceItem[$j][$i]['model'];?></td><td><?php echo $invoiceItem[$j][$i]['out'];?></td><td><?php echo $invoiceItem[$j][$i]['scrap'];?></td><td><?php echo $invoiceItem[$j][$i]['in'];?></td><td><?php echo $bal;?></td><td><?php echo $inqty ?></td><td><?php echo $inbox ?></td><td><?php echo $invoiceItem[$j][$i]['box']?></td><td><?php echo $quota;?></td><td><?php echo $invoiceItem[$j][$i]['todayPartNoOutTotal'];?></td></tr><?
  }
  }
  ?> </table><p><?php
 }
?>


<?php }?>
  

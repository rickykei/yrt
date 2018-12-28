<link rel="stylesheet" href="./include/instock_style.css" type="text/css">
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCCCCC;
}
.style8 {
	font-size: 12px;
	font-weight: bold;
}</style>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/instock.js"></script></head>
</style> 
 
<?php
  include_once("./include/config.php");
   $query="SET NAMES 'UTF8'";
    $db = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $db->query("SET NAMES 'UTF8'");
   // (Run the query on the winestore through the connection
   if ($invoice_no!="")
   {
    $sql="SELECT return_no ,invoice_no,return_date,staff_name,branchID,discount_percent,total_price FROM returngood where invoice_no=".$invoice_no." order by return_date desc";
	}
	else if ($return_no!="")
	{    $sql="SELECT return_no ,invoice_no,return_date,staff_name,branchID,discount_percent,total_price FROM returngood where return_no=".$return_no;	}
	else if ($goods_partno!="")
	{   
	 $sql="SELECT a.return_no return_no,a.invoice_no invoice_no,a.return_date return_date,a.staff_name staff_name,a.branchID branchID,a.discount_percent discount_percent,a.total_price total_price,b.market_price market_price FROM returngood a ,goods_return b where b.goods_partno='".$goods_partno."' and a.return_no = b.return_no group by a.return_no order by return_date desc";	
	 }
	 else if ($return_date_start!="" && $return_date_end!="" && $goods_partno=="" && $return_no=="" && $invoice_no=="" )
	 	{
		    $sql="SELECT return_no ,invoice_no,return_date,staff_name,branchID,discount_percent,total_price FROM returngood where return_date >= '".$return_date_start." 00:00:00' and return_date <='".$return_date_end." 23:59:00' order by return_date desc";	}
	else
   {
   $sql="SELECT return_no ,invoice_no,return_date,staff_name,branchID,discount_percent,total_price FROM returngood order by return_date desc";}
   

     require "./include/Pager.class.php";
   include('./return/Pager_header.php');
?>
<form id="form1" name="form1" method="post" action="/?page=return&subpage=returngoodlist.php">
      <div><label>退貨單編號</label>
  <input name="return_no" type="text" id="return_no" class="buttonstyle" size="20" maxlength="20" />
  </div>
  <div>
  <label>YRT發票編號</label>
  <input type="text" name="invoice_no" class="buttonstyle" /><input type="submit" value="搜尋"/>
  </div>
    <div><label>貨品編號：</label>
  <input name="goods_partno" class="buttonstyle" type="text" id="goods_partno" />
  </div>
   <div><label>退貨單日期：</label>
<input name="return_date_start" id="return_date_start" class="buttonstyle" type="text"  size="15">
<input name="cal" id="calendar" value=".." type="button">
至
<input name="return_date_end" id="return_date_end" class="buttonstyle" type="text"  size="15" />
  <input name="cal2" id="calendar2" value=".." type="button" />
  </div>
   <input type="submit" value="搜尋"/>
 <input type="hidden" name="update" value="2"/>
</form>
<?
echo $turnover;
echo $Pager->numPages;
   // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?>
<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
  <tr bgcolor="#006666">
    <td width="8%" height="23" bgcolor="#6699CC"><div align="center"><strong>退貨單編號</strong></div></td>
    <td width="11%" bgcolor="#6699CC"><div align="center"><strong>YRT發票編號</strong></div></td>

    <td width="16%" bgcolor="#6699CC"><div align="center" class="style6 style8">退貨日期</div></td>
    <td width="5%" bgcolor="#6699CC"><div align="center"><strong>職員</strong></div></td>
    <td width="7%" bgcolor="#6699CC"><div align="center"><strong>分鋪</strong></div></td>
    <td width="5%" bgcolor="#6699CC"><div align="center"><strong>折扣</strong></div></td>
    <td width="10%" bgcolor="#6699CC"><div align="center"><strong>退還金額</strong></div></td>
    	<?if ($goods_partno!=""){?>
    <td width="9%" bgcolor="#6699CC"><div align="center"><strong>搜尋貨品編號</strong></div></td>
	<td width="7%" bgcolor="#6699CC"><div align="center"><strong>單件退貨價</strong></div></td>
	<?}?>
    <td width="15%" bgcolor="#6699CC"><div align="center"><strong>修改</strong></div></td>
    <td width="11%" bgcolor="#6699CC"><div align="center">列印</div></td>
  </tr>
  <?php 
	for ($i=0;$i<count($result);$i++)
	{ 
	$row=$result[$i];
	
   ?><tr valign="middle" align="center" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'"><td class="style7">    <?=$row['return_no']?>
  </td>
 <td class="style7">    <?=$row['invoice_no']?>  </td>
 <td class="style7"><?=$row['return_date']?></td>
  <td class="style7"><?=$row['staff_name']?></td>
  <td class="style7">    <?=$row['branchID']?>  </td>
  <td class="style7">   <?=$row['discount_percent']?>  </td>
  <td class="style7">   <?=$row['total_price']?>  </td>
    	<?if ($goods_partno!=""){?>
   	<td class="style7"><div align="center"><?=$goods_partno?></strong></div></td>
	<td class="style7"><div align="center"><?=$row['market_price']?></strong></div></td>
	<?}?>
  <td><a href="/?page=return&subpage=returngoodedit.php&return_no=<?=$row['return_no']?>&update=2&goods_partno=<?=$goods_partno?>" class="b">修改</a></td>
  <td><a href="./return/pdf/<?=$row['return_no']?>.pdf" class="b">列印</a></td>
  </tr>
<?
		 }
   ?>
</table>
<?php echo $turnover;?>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "return_date_start",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  Calendar.setup(
    {
      inputField  : "return_date_end",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
</script>
 

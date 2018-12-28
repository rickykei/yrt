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
   
   $delivery_date=$_POST['delivery_date'];
   
   if ($delivery_date=="")
   {
    $sql="SELECT * FROM delivery_fee  order by delivery_date desc";
	}
	 
	 else if ($delivery_date!="" )
	 	{
		    $sql="SELECT * FROM delivery_fee where delivery_date = '".$delivery_date."'  order by delivery_date desc";	}
	else
   {
   $sql="SELECT * FROM delivery_fee order by delivery_date desc";}
   

     require "./include/Pager.class.php";
   include('./delivery_fee/Pager_header.php');
?>
<form id="form1" name="form1" method="post" action="/?page=delivery_fee&subpage=list.php">
   
   <div><label>入數日期：</label>
<input name="delivery_date" id="delivery_date" class="buttonstyle" type="text"  size="15">
<input name="cal" id="calendar" value=".." type="button">
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
    <td width="8%" height="23" bgcolor="#6699CC"><div align="center"><strong>id</strong></div></td>
    <td width="11%" bgcolor="#6699CC"><div align="center"><strong>入數日期：</strong></div></td>
	<td width="3%" bgcolor="#6699CC"><div align="center"><strong>分店:</strong></div></td>
 <td width="11%" bgcolor="#6699CC"><div align="center"><strong>車數</strong></div></td>
 <td width="11%" bgcolor="#6699CC"><div align="center"><strong>森基車數</strong></div></td>

 
    <td width="5%" bgcolor="#6699CC"><div align="center"><strong>職員</strong></div></td>
    <td width="7%" bgcolor="#6699CC"><div align="center"><strong>入機日期：</strong></div></td>
 
 
    <td width="15%" bgcolor="#6699CC"><div align="center"><strong>修改</strong></div></td>
 
  </tr>
  <?php 
	for ($i=0;$i<count($result);$i++)
	{ 
	$row=$result[$i];
	
   ?><tr valign="middle" align="center" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'"><td class="style7">    <?=$row['id']?>
  </td>
 <td class="style7">    <?=date("Y-m-d",strtotime($row['delivery_date']))?>  </td>
 <td class="style7">    <?=$row['shop']?>  </td>
  <td class="style7"><?=$row['fee']?></td>
  <td class="style7"><?=$row['fee_2']?></td>
 <td class="style7"><?=$row['staff_name']?></td>
  <td class="style7"><?=$row['creation_date']?></td>
 
     
  <td><a href="/?page=delivery_fee&subpage=delivery_fee_edit.php&id=<?=$row['id']?>&update=2 class="b">修改</a></td>
  
  </tr>
<?
		 }
   ?>
</table>
<?php echo $turnover;?>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "delivery_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  
</script> 

<?php
 
  require_once("./include/config.php");
 
  
	
//get Staff name
	$connection = DB::connect($dsn);
	if (DB::isError($connection))
		die($connection->getMessage());
		 $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
	$sql="SELECT * FROM staff";
	$staffResult = $connection->query($sql);
	
	$day=date("d");
	$month=date("m");
	
	$delivery_month_sql="select sum(fee) as fee1 , sum(fee_2) as fee2 from delivery_fee where month(delivery_date)= \"$month\" ";
 
	$delivery_month_sql_Result = $connection->query($delivery_month_sql);
	$row = $delivery_month_sql_Result->fetchRow(DB_FETCHMODE_ASSOC);

	
?> 
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/delivery.js"></script>
<link href="./include/delivery.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style11 {font-size: xx-small}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->

<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 00px;
	margin-bottom: 0px;
}
-->
</style></head>
<body onload="">
<form action="/?page=delivery_fee&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="900"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ACC7FF">

  <tr>
    <td >&nbsp;</td>
    <td align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#6699CC" ><span class="style6">街車入數</span></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="">本月街車=<?php	echo $row["fee1"];?>
	 </td>
        <td width="">本月森基=<?php	echo $row["fee2"];?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666" >
            <td width="20%" height="21" bgcolor="#6699CC">
                <span class="style6"> <span class="style5">街車入數</span>日期 ：</span></td>
            <td width="28%" bgcolor="#6699CC" ><input name="delivery_date" type="text" id="delivery_date" value="<?php echo date("Y-m-d");?>">
              <input name="cal" id="calendar" value=".." type="button"></td>
            <td width="17%" bgcolor="#6699CC" ><span class="style6">職員 : </span></td>
            <td width="35%" bgcolor="#6699CC" ><select name="staff_name" id="staff_name">
      			  <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
                echo "<option value=\"".$row['name'];
                echo "\"";
                if ($USER==$row['name'])
           			echo " SELECTED";
                echo ">".$row['name']."</option>";
				}?>
            </select></td>
          </tr>
          <tr bgcolor="#006666" >
            <td bgcolor="#6699CC" ><span class="style6">街車價錢</span></td>
            <td bgcolor="#6699CC" ><input name="fee" type="text" id="fee" /></td>
            <td bgcolor="#6699CC" ><span class="style6">森基價錢</span></td>
            <td bgcolor="#6699CC"> <input name="fee_2" type="text" id="fee_2" /></td>
          </tr>
        </table></td>
      </tr>
   
     </td></td></tr>
	<tr align="right">
	<td colspan=5><input name="submitb" type="button" id="submitb" value="送出" onClick="checkform()">
	</td>
	</tr>
</table> 
 
</form>
</table>
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
 
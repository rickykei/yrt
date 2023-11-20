<?php
	$invoiceRecord=16;
	require_once("./include/config.php");
	require_once("./include/functions.php");
	
	//get Staff name
	$connection = DB::connect($dsn);
    if (DB::isError($connection))
      die($connection->getMessage());
       $query="SET NAMES 'UTF8'";
    
    if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
	  $sql="SELECT * FROM staff";
	 $staffResult = $connection->query($sql);
       
	   
	  

?> 
<? // = $ajax->loadJsCore(true) ?>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/functions.js?20210427"></script>
<script type="text/javascript" src="./include/bonus.js?20230928"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="./js/js.storage.min.js"></script> 
 
 
<style type="text/css">
<!--
.style11 {
	font-size: xx-small
	}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFF;
}
a:visited {
	color: #FFF;
}
a:hover {
	color: #FFF;
}
a:active {
	color: #FFF;
}
-->
</style>
 
<form action="/?page=bonus_by_staff&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="1000"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  <tr>
    <td width="4" >&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#004d80"><span class="style6"><a href="../">貨品花紅計算</a>  </span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >".$USER;?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4">
		<table width="100%" border="1" cellpadding="2" cellspacing="0">
          
          <tr bgcolor="#004d80">
            <td ><span class="style6">花紅計算日期由：</span></td>
            <td ><input name="delivery_date" type="text" id="delivery_date" tabindex="39" size="12" maxlength="20" value="<? echo Date("Y-m-d"); ?>"><input name="cal" id="calendar" value=".." type="button"></td>
             <td><span class="style6">至花紅計算日期：</span></td>
                    <td><input name="settledate" type="text" id="settledate" value="<? echo Date("Y-m-d"); ?>" size="15" maxlength="20"><input name="cal2" id="calendar2" value=".." type="button"></td>
             
          </tr> 
         <tr bgcolor="#004d80">
		    <td width="73" ><span class="style6">營業員 ：</span></td>
            <td width="94"  colspan=3> <select name="sales" id="sales">
			  <?php 
			  if (($AREA=="Y" && $PC=="99") || ($AREA=="Y" && $PC=="1") )
			  {
				  
					echo "<option value='ALL'>ALL</option>";
					
			  }
			  while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
				  {
			 
				
					echo "<option value=\"".$row['name']."\" ";	
					  if ($USER==$row['name'])
					echo "selected";
					echo ">".$row['name']."</option>";
				   
			  }
				 
			?>
                    
                </select><span class="style6"><?=$invoicerow['sales_name']?></span></td>
		 </tr>
        </table></td>
      </tr>
      
  
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#004d80">
            <tr>
              <td  ><span class="style6">
                <input name="clear" type="reset" id="clear" value="清除">
              </span></td> 
              
              <td align="right" ><input name="submitb" type="button" id="submitb" value="送出" onClick="checkform()"></td>
            </tr>
          </table>          </td>
      </tr>
    
    </table>     </td>
  </tr>
</table>
<input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" />
 
</form>
 
<script type="text/javascript">
 
  Calendar.setup(
    {
      inputField  : "delivery_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
    Calendar.setup(
    {
      inputField  : "settledate",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
  
 
 
</script> 

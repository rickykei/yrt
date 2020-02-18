<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>花紅計算表</title><?php
 
  require_once("../include/config.php");

?>

<style type="text/css">
@import url(../include/cal/calendar-win2k-1.css);
</style>
<link href="../include/invoice.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../include/cal/calendar.js"></script>
<script type="text/javascript" src="../include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="../include/cal/calendar-setup.js"></script>
</head>
<body >
<form action="index2.php" method="POST"  name="form1">
<table width="900"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CC99">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td width="892" align="center" valign="top">
    <table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006633" class="style6"><a href="../index.php" class="style6">花紅計算表</a></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr >
        <td height="24" colspan="4">由: 
          <input name="from_date" type="text" id="from_date" tabindex="39" size="12" maxlength="20" value="<?php echo date("Y-m-d");?>">
          <input name="cal" id="calendar" value=".." type="button"> 
          至:<input name="to_date" type="text" id="to_date" tabindex="39" size="12" maxlength="20" value="<?php echo date("Y-m-d");?>">
          <input name="cal2" id="calendar2" value=".." type="button">  <input type="submit" name="button" id="button" value="Submit">
          <input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" />
          </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</body>
<script type="text/javascript">

  Calendar.setup(
    {
      inputField  : "from_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
    Calendar.setup(
    {
      inputField  : "to_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d ",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
</script></html>

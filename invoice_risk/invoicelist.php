<link rel="stylesheet" href="./include/invoice_style.css" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #5E5E5E}
-->
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script></head>
 <?php
   include_once("./include/config.php");
 
   
  $sql="SELECT * FROM staff where name !='' ";
	 $staffResult = $db->query($sql);
  
	$checking=0;
   	if ($amend_by=="" && $invoice_no=="" && $staffName=="" && $invoice_modify_date_start=="" && $invoice_modify_date_end==""  ){
	 
	$sql="SELECT * from invoice_high_risk  where 1=1 ";
			
	}else{ //join invoice_item
			 
			 $sql="SELECT * from invoice_high_risk where 1=1 ";
			
			if ($amend_by!=""){
				 
				$sql.=" and ";
				$sql.=" amend_by='".$amend_by."' ";
				$checking++;
			}
			if ($invoice_no!=""){
						 
					$sql.=" and ";
					$sql.=" invoice_no='".$invoice_no."' ";
							$checking++;
			}
			if ($staffName!=""){
				 
					$sql.=" and ";
					$sql.=" staffName='".$staffName."' ";
							$checking++;
			}
		 
			if ($invoice_modify_date_start!="" && $invoice_modify_date_end!=""){
				 
				$sql.=" and ";
				$sql.=" a.modify_date >='".$invoice_modify_date_start." 00:00:00' and a.modify_date <='".$invoice_modify_date_end." 23:59:00' ";
						$checking++;
			}	 
			
				
			
		
	
	   }
	   if (!($AREA=='Y' && $PC=='99'))
	   $sql.=" and branchID='$AREA' ";
	     $sql.=" order by modify_date desc ";   
 
 
	//cal total count first;
	if ($sqlCount!=""){
	 $result = $db->query($sqlCount);
		 while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$countTotal=$row["total"];
		 }
	}
	 
	 
   require_once("./include/Pager.class.php");

   include_once('./invoice_risk/Pager_header.php');

	
 // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?>
   
<form name="search" action="/?page=invoice_risk&subpage=invoicelist.php" method="POST">
<div><label>發票編號：</label>
<input name="invoice_no" type="text" class="buttonstyle"  id="invoice_no" size="10" maxlength="10" /></div>
 
<div><label>改單日</label>
<input name="invoice_modify_date_start" id="invoice_modify_date_start" class="buttonstyle" type="text"  size="15">
<input name="cal" id="calendar" value=".." type="button">
至
<input name="invoice_modify_date_end" id="invoice_modify_date_end" class="buttonstyle" type="text"  size="15" />
<input name="cal2" id="calendar2" value=".." type="button" />
</div>
 
 
<div><label>售貨員</label>
  <select name="staffName" id="sales">
              <option value="" > </option>
			  <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
                echo "<option value=\"".$row['name'];
                echo "\"";
                
                echo ">".$row['name']."</option>";
				}?>
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
<TD width="107" bgcolor="#006633"> 單總由</TD>
<TD width="107" bgcolor="#006633">單總至 </TD>
<TD width="100" bgcolor="#006633">售貨員</TD>
<TD width="100" bgcolor="#006633">開單日</TD>
<TD width="100" bgcolor="#006633">改單日</TD>
<TD width="100" bgcolor="#006633">相差日數</TD>
<TD width="100" bgcolor="#006633">機號</TD>
 
</TR>

    <?php 
	
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   ?><tr valign="middle" align="center"     />
   <td><?=$row['invoice_no']?></td>
   <td><?=$row['from_total']?></td>
   <td><?=$row['to_total']?></td>
   <td><?=$row['staffName']?></td>
   <td><?=$row['creation_date']?></td>
   <td><?=$row['modify_date']?></td>
   
   <td><? $dd=strtotime($row['modify_date'])-strtotime($row['creation_date']); echo round($dd/60/60/24);?> </td>
   <td><?=$row['amend_by']?></td>
	<?php }?>
</table><?php echo $turnover;?>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "invoice_modify_date_start",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  Calendar.setup(
    {
      inputField  : "invoice_modify_date_end",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
 
</script>
 

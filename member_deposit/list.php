<link rel="stylesheet" href="./include/invoice_style.css" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #5E5E5E}
-->
</style>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script></head>
<?php
   include_once("./include/config.php");
   $db = DB::connect($dsn);
    if (DB::isError($connection))
      die($connection->getMessage());
   
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");
  $sql="SELECT * FROM staff where name !='' ";
	 $staffResult = $db->query($sql);
  
	$checking=0;
   	if ($created_by=="" && $mem_dep_id!="" && $mem_id=="" && $deposit_date_start=="" && $deposit_date_end==""  && $sales=="" && $deposit_amt=="" ){
		
	//search by invoiceno
	  $sql="SELECT  * from member_deposit a where a.mem_dep_id = '".$mem_dep_id."'";
	}
	   else if ($created_by==""  && $deposit_date_start!="" && $deposit_date_end!="" && $mem_id=="" && $mem_dep_id==""   && $sales=="" && $deposit_amt=="")
	   $sql="SELECT * from member_deposit a where a.deposit_date >= '".$deposit_date_start." 00:00:00' and a.deposit_date <='".$deposit_date_end." 23:59:00' ";
	   else if ($created_by=="" && $mem_dep_id=="" && $mem_id=="" && $deposit_date_start=="" && $deposit_date_end=="" && $sales=="" && $deposit_amt=="")	{
	  		$sql="SELECT * FROM member_deposit a";
	  	   
	// $sql="SELECT * FROM invoice order by invoice_no desc";
		} else{
			
			   $sql="SELECT  * from member_deposit a where ";
			
			if ($mem_dep_id!=""){
				if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.mem_dep_id='".$mem_dep_id."' ";
				$checking++;
			}
			if ($mem_id!=""){
						if ($checking>=1) 
					$sql.=" and ";
					$sql.=" a.mem_id='".$mem_id."' ";
							$checking++;
			}
			 
			 
			if ($deposit_date_start!="" && $deposit_date_end!=""){
				if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.deposit_date >='".$deposit_date_start." 00:00:00' and a.deposit_date <='".$deposit_date_end." 23:59:00' ";
						$checking++;
			}	
		 
			if ($deposit_amt!="" ){
					if ($checking>=1) 
				$sql.=" and ";
				$sql.=" a.deposit_amt='".$deposit_amt."' ";
						$checking++;
			}
			
			if ($sales!=""){
					if ($checking>=1) 
					$sql.=" and ";
					$sql.= " a.sales_name ='".$sales."' ";
					$checking++;
			}
	
	   }
		$sql.=" order by a.mem_dep_id desc ";   
  
 
  
	//cal total count first;
 
	//echo $countTotal;
	 
   require_once "./include/Pager.class.php";

   include_once('./member_deposit/Pager_header.php');
 
   ?>
<form name="search" action="/?page=member_deposit&subpage=list.php" method="POST">
<div><label>發票編號：</label>
<input name="mem_dep_id" type="text" class="buttonstyle"  id="mem_dep_id" size="10" maxlength="10" /></div>
<div><label class="style7">客戶編號：</label>
<input name="mem_id" type="text" class="buttonstyle"  id="mem_id" size="10" maxlength="10" /></div>
   
<div><label>發票日期：</label>
<input name="deposit_date_start" id="deposit_date_start" class="buttonstyle" type="text"  size="15"><input name="cal" id="calendar" value=".." type="button">
至
<input name="deposit_date_end" id="deposit_date_end" class="buttonstyle" type="text"  size="15" />
<input name="cal2" id="calendar2" value=".." type="button" />
</div> 
 
 
 
<div><label>售貨員</label>
  <select name="sales" id="sales">
              <option value="" > </option>
			  <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
                echo "<option value=\"".$row['name'];
                echo "\"";
                
                echo ">".$row['name']."</option>";
				}?>
                </select>
</div>
 
<input type="submit" name="button" value="查存款記錄"/>
</form>
<hr/>
<a href="../">回主頁</a>
   <hr/>
<?=$turnover?>
<table  width="100%" bgcolor="#2E2E2E" border="0" cellpadding="1" cellspacing="1">
<TR bgcolor="#5E5E5E" align="center" style="font-weight:bold" ><TD width="50" height="23" bgcolor="#006633"> 發票編號</TD>
<TD width="107" bgcolor="#006633"> 發票日期</TD>
 
<td width="78" bgcolor="#006633">客戶名稱</td>
<TD width="94" bgcolor="#006633">會員編號</TD>
<TD width="67" bgcolor="#006633">分店</TD>
 
<TD width="100" bgcolor="#006633">售貨員</TD>
<TD width="100" bgcolor="#006633">單總</TD>
<?php 
//20100525
if (($AREA=="Y" && $PC=="99") || ($AREA=="Y" && $PC=="1") ){ 
?>
<TD width="100" bgcolor="#006633">機號</TD>
<?php 
} 
?>
<TD width="32" bgcolor="#006633">編輯</td>
<TD width="32" bgcolor="#006633">列印</td>
</TR>

    <?php 
	
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   ?><tr valign="middle" align="center"  <? 
if($row['settle']=="S" || $row['settle']=="") {echo "class='b'\"";echo " onMouseOut=\"this.className='b'\"";echo " onMouseOver=\"this.className='normal'\"";}
else if ($row['settle']=="A") { echo " onMouseOut=\"this.className='normal'\"";echo " onMouseOver=\"this.className='highlight'\"";} else if ($row['settle']=="D") { echo "class='deposit'\""; echo " onMouseOut=\"this.className='deposit'\"";echo " onMouseOver=\"this.className='highlight'\"";}
?>   />
   <td><? if ($row['call_count']>0) echo "*" ; ?><?=$row['mem_dep_id']?></td>
   <td><?=$row['deposit_date']?></td>
 
   
   <td><?=$row['mem_name']?></td>
   <td><?=$row['mem_id']?></td>
   <td><?=$row['branchID']?></td>
 
   <td><?=$row['sales_name']?></td>
    <td><?=$row['deposit_amt']?></td>
	<?php 
	//20100525
	if (($AREA=="Y" && $PC=="99") || ($AREA=="Y" && $PC=="1") ){ 
	?>
	<td><?echo $row['created_by']."/".$row['last_update_by'];?></td>
	<?php 
	} 
	?>
   <td><a  href="edit.php?id=<?=$row['mem_dep_id']?>">Edit</a></td>
   <td><a  href="./pdf/<?=$row['mem_dep_id']?>.pdf">Print</a></td></tr>
		 <? }
   ?>
</table><?php echo $turnover;?>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "deposit_date_start",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  Calendar.setup(
    {
      inputField  : "deposit_date_end",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  ); 
</script>
 
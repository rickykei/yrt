<link rel="stylesheet" href="./include/member_style.css" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #5E5E5E}
-->
</style>
<?php

   include_once("./include/config.php");
   $db = DB::connect($dsn);
    if (DB::isError($connection))
      die($connection->getMessage());
   
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");

  
	$checking=0;
  if ($search_address=="" && $search_alert=="" )	{
	  		$sql=" SELECT * FROM address a  ";
	  	    $sqlCount= " Select count(*) as total FROM address a ";
	// $sql="SELECT * FROM invoice order by invoice_no desc";
		}else if ($search_address!="" && $search_alert=="" ){
			$sql=" SELECT * FROM address a where address like '%".$search_address."%' ";
		}else if  ($search_address=="" && $search_alert!="" ){
		$sql=" SELECT * FROM address a where alert like '%".$search_alert."%' ";
		}
		 

		$sql.=" order by a.id desc ";   
 
 
	//cal total count first;
	if ($sqlCount!=""){
	 $result = $db->query($sqlCount);
		 while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$countTotal=$row["total"];
		 }
	}
	//echo $countTotal;
	 
   require "./include/Pager.class.php";

   include('./address/Pager_header.php');

	
 // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?>
   <form name="search" action="/?page=address&subpage=index.php" method="POST">
<div><label class="style7">地址:</label>
<input name="search_address" type="text" class="buttonstyle"  id="address" size="10" maxlength="10" /></div>
<div>
<label class="style7">警告:</label>
<input name="search_alert" type="text" class="buttonstyle"  id="alert" size="20" maxlength="20" />
<input type="submit" name="button" value="Search"/>
</div>
</form>
<p><hr></p>
<a href="/?page=address&subpage=add.php">新加警告</a>
<p><hr></p>
<?=$turnover?>
<table  width="100%" bgcolor="#2E2E2E" border="0" cellpadding="1" cellspacing="1">
<TR bgcolor="#5E5E5E" align="center" style="font-weight:bold" >
<TD width="89" height="23" bgcolor="#006633">ID</TD>
<TD width="121" bgcolor="#006633">地址 </TD>
<TD width="326" bgcolor="#006633">警告 </TD>
<TD width="67" bgcolor="#006633">編輯</td>

</TR>

    <?php 
	
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   ?><tr valign="middle" align="center"  <? if($row['creditLevel']=="S"){echo "class='b'\"";echo "onMouseOut=\"this.className='b'\"";}else{ echo "onMouseOut=\"this.className='normal'\"";} ?>   onMouseOver="this.className='highlight'" />
   <td><?=$row['id']?></td>
   <td><?=$row['address']?></td>
   <td><?=$row['alert']?></td>
   <td><a  href="/?page=address&subpage=address_edit.php&update=2&addr_id=<?=$row['id']?>" target="_blank">Edit</a></td>
		 <? }
   ?> 
</table><?php echo $turnover;?>
 

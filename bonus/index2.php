<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>花紅計算表</title>
<?php

  $invoiceRecord=18;
  require_once("../include/config.php");

	//get Staff name
	    $connection = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
       $query="SET NAMES 'UTF8'";
   

   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
   
	  if ($AREA=='Y' && ($PC=='99' || $PC=='1')){   
		$sql="SELECT sales_name,sum(total_price) as total_price, count(invoice_no) inv_cnt ,branchid FROM `invoice` WHERE `invoice_date` > '".$from_date." 00:00' and invoice_date < '".$to_date." 23:59' and void = 'A' group by sales_name , branchID ";
		$sql_return="SELECT sales_name,sum(total_price) as total_price, count(invoice_no) inv_cnt ,branchid FROM `invoice` WHERE `settledate` > '".$from_date." 00:00' and settledate < '".$to_date." 23:59' and settle = 'A' and void = 'A' group by sales_name , branchID ";
	  }else{
		$sql="SELECT sales_name,sum(total_price) as total_price, count(invoice_no) inv_cnt ,branchid FROM `invoice` WHERE `invoice_date` > '".$from_date." 00:00' and invoice_date < '".$to_date." 23:59' and branchID ='".$AREA."' and void = 'A' group by sales_name, branchID";
		$sql_return="SELECT sales_name,sum(total_price) as total_price, count(invoice_no) inv_cnt ,branchid FROM `invoice` WHERE `settledate` > '".$from_date." 00:00' and settledate < '".$to_date." 23:59' and settle = 'A' and void = 'A' group by sales_name , branchID ";
	  }
	  
	 //echo $sql;
	// echo $sql_return;
	  
	 $staffResult = $connection->query($sql);
       $staffReturnResult = $connection->query($sql_return);
	
?>
<link href="../include/invoice.css" rel="stylesheet" type="text/css" />
</head>
<body  >
<table width="900"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CC99">
 <tr>
    <td width="4" height="360">&nbsp;</td>
    <td  align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td class="style6" ><table width="100%"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td width="14%" height="21" bgcolor="#006633"  class="style6"><a href="index.php" class="style6">花紅計算表</a></td>
            <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
            <td width= >由 <?php echo $from_date;?> 至 <?php echo $to_date;?></td>
            
          </tr>
          <tr><td colspan="3" align="center"></td></tr>
          <tr>
            <td colspan="4" valign="middle">
			出貨<br>
            <table width="100%" align="center" border="2" cellpadding="0" cellspacing="0" bgcolor="#006633">
              <tr>
                <td width="12%" bgcolor="#777777" class="style6">售貨員</td>
                <td width="20%" bgcolor="#777777" class="style6" align="center">總營業額</td>
                <td width="20%" bgcolor="#777777" class="style6" align="center">出單數量</td>
                <td width="20%" bgcolor="#777777" class="style6" align="center">分店</td>
              </tr>
              <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  { ?>
              <tr>
                <td class="style6"><?php echo $row['sales_name'] ;?></td>
                <td class="style6" align="right"><?php echo $row['total_price'] ;?></td>
                <td class="style6" align="right"><?php echo $row['inv_cnt'] ;?></td>
                <td class="style6" align="right"><?php echo $row['branchid'] ;?></td>                
              </tr>
              <?php
				$sales_name=$row['sales_name'];
				$bal[$sales_name]=$bal[$sales_name]+$row['total_price'];
			  
				}
				?>
            </table>
			實數<br>
			 <table width="100%" align="center" border="2" cellpadding="0" cellspacing="0" bgcolor="#006633">
              <tr>
                <td width="12%" bgcolor="#777777" class="style6">售貨員</td>
                <td width="20%" bgcolor="#777777" class="style6" align="center">總營業額</td>
                <td width="20%" bgcolor="#777777" class="style6" align="center">出單數量</td>
                <td width="20%" bgcolor="#777777" class="style6" align="center">分店</td>
              </tr>
              <?php while ($row = $staffReturnResult->fetchRow(DB_FETCHMODE_ASSOC))
			  { ?>
              <tr>
                <td class="style6"><?php echo $row['sales_name'] ;?></td>
                <td class="style6" align="right"><?php echo $row['total_price'] ;?></td>
                <td class="style6" align="right"><?php echo $row['inv_cnt'] ;?></td>
                <td class="style6" align="right"><?php echo $row['branchid'] ;?></td>                
              </tr>
              <?php 
			  $sales_name=$row['sales_name'];
				$bal[$sales_name]=$bal[$sales_name]-$row['total_price'];
			  
				}
				?>
            </table>
			 
 
          </table></td>
      </tr>
	  <tr><td>
	  
	  </td></tr>
  </table></td>
     </tr>
	 
    </table>    
     </td>
  </tr>


</table>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-TW" lang="zh-TW" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>
<body><table border=1><?php
   include("config.php");
   $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   $result = $connection->query("SELECT * FROM supplier");

   if (DB::isError($result))
      die ($result->getMessage());

   // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?><TR><TD>ID</TD><TD>SUPPLIER ID</TD><TD>SUPPLIER NAME</TD><TD>SUPPLIER ADDRESS</TD><TD>SUPPLIER TEL</TD><TD>SUPPLIER FAX</TD><TD>SUPPLIER TYPE</TD><TD>SUPPLIER TRANSPORT</TD><? /* <TD>SUPPLIER LEVEL</TD> */ ?> <TD>Edit</TD></TR>
    <?php
	
     // Print out each element in $row, that is, print the values of
      // the attributes
      
	while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) )
{  
 echo "<tr>";
 echo "<td>".$row['id']."</td><td>".$row['supplier_id']."</td><td>".$row['supplier_name']."</td><td>".$row['supplier_add']."</td><td>".$row['supplier_tel']."</td><td>".$row['supplier_fax']."</td><td>".$row['supplier_good_type']."</td><td>".$row['supplier_transport']."</td><td><a href='http://yrt.rickykei.com/supplier/insuppliernameedit.php?supplier_id=".$row['supplier_id']."&update=2'>edit </a></td>";
 echo "</tr>";   
   }
   ?></table>
</body></html>

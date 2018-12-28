<?php
	header('Content-Type: text/xml');
	require('../include/config.php');
	
	$mem_id = $_GET['mem_id'];

	 $db = DB::connect($dsn);
   if (DB::isError($db))
      die($db->getMessage());
	   $query="SET NAMES 'UTF8'";
    if (DB::isError($db)) die($db->getMessage());
	
	
	 
	//$query = "select * from member where member_id='".$_GET['mem_id']."'";
	$query = " SELECT member_id,member_add,member_name,creditLevel,(select alert from address addr where mem.member_add like concat('%',addr.address,'%') limit 0,1) alert  FROM member mem WHERE mem.member_id='".$_GET['mem_id']."'  ";
	$result =$db->query($query ) or die (mysql_error()."Couldn't execute query: $query");
	
	/*echo '<?xml version="1.0" encoding="ISO-8859-1"?><product>';*/
    echo '<?xml version="1.0" encoding="utf8"?><member>';
	
	$num_results=$result->numRows();
	for ($i=0;$i<$num_results;$i++)
	{
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		echo "<mem_id>" . $row['member_id'] . "</mem_id>";
		echo "<mem_name>" . $row['member_name'] . "</mem_name>";
		echo "<mem_credit_level>" . $row['creditLevel'] . "</mem_credit_level>";
		echo "<mem_add>" . $row['member_add'] . "</mem_add>";
		echo "<mem_alert>" . $row['alert'] . "</mem_alert>";

	}
	
	 
	
	echo "</member>";
?>
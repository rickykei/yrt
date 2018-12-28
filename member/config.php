<?php
	require_once 'DB.php';
	$dsn = 'mysql://wood:wood2006@localhost/wood';
	mysql_connect("localhost", "wood", "wood2006") or die("Could not connect: " . mysql_error());
	mysql_select_db("wood");

?>

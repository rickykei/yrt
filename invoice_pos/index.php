<!doctype html>
<?php 
 include_once("../include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

	 $type00Result = $connection->query("SELECT * FROM type where level='0'");
      if (DB::isError($type00Result))
      die ($type00Result->getMessage());
  
 
  ?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>invoice POS 2017 </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
   <link rel="stylesheet" href="styles.css">
  <script src="/js/js.storage.min.js"></script>
   <script src="pos.js"></script>
  <script type="text/javascript">

  $( function() {
	  
  
	ls.set('curr_page','model1');
	//alert(ls.get('curr_page'));
	
	
	 
  } );
  </script>
</head>
<body>
<div style=""> 
	<div   id="controlpanel">
		<?php include_once('menu.php');?>
	<hr>
		<div id="page_footage">
			[分類1]	 
		</div>
	<hr>
		<div id="model">
		<table border="0">
		<?php 
		$i=0;
		  while ($typerow = $type00Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			 if ($i==0){
				 echo "<tr>";
				 $i=0;
			 }
			 
			?>
			 <td><a class="ui-button ui-widget ui-corner-all" href="index2.php?parent1_name=<?php echo stripslashes($typerow['typeName']);?>&parent_id=<?php echo stripslashes($typerow['id']);?>"  rel="external" ><?php echo stripslashes($typerow['typeName']);?></a></td>
			 <?php
			 if ($i==7){
				 echo "</tr>";
				 $i=0;
			 }
			 $i++; 
		}
		?>
			</table>
	 
		</div>
	</div>
	<div    style="margin-right:15px;position: fixed; right: 0;top :0;" id="list-items">
	 <ul ></ul>
	<input type="hidden" name="qty" id="qty" value="">
	<input type="hidden" name="partno" id="partno" value="">
	<input type="hidden" name="desc" id="desc" value="">
	<input type="hidden" name="price" id="price" value="">
	</div>
</div>
 
 

 
 
</body>
</html>
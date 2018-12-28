<!doctype html>
<?php 
 include_once("../include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

		$parent_id=$_GET['parent_id'];
	 $type1Result = $connection->query("SELECT * FROM type where level='1' and parent_id=".$parent_id);
      if (DB::isError($type1Result))
      die ($type1Result->getMessage());
  
  $model1=$_GET['parent1_name'];
  
  if ($PC=='99')
  $index3_page="index3_admin";
	else
  $index3_page="index3";
 
  ?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>invoice POS 2017 <?php echo $AREA;
  echo $PC;?> </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
<link rel="stylesheet" href="styles.css">
  <script src="/js/js.storage.min.js"></script>
 <script src="pos.js"></script>

  <script type="text/javascript">

  $(function() {
	   
	 
	
 
	ls.set('curr_page','model2');
	//alert(ls.get('selected_model1'));
	aa=$('#page_footage').text();
	$('#page_footage').text(ls.get('selected_model1')+aa);
	
	$('#model a[href]').click(function(){
		//alert($(this).text());
		ls.set('selected_model2',$(this).text());
		//alert(ls.get('selected_model2'));
	});
 
	
 

	
  } );
  </script>
</head>
<body>
<div style=""> 
	<div id="controlpanel"  >
		 <?php include_once('menu.php');?>
	<hr>
		<div id="page_footage">
			->	 
		</div>
	<hr>
		<div id="model">
		<table border="0">
		<?php 
		  while ($typerow = $type1Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			  if ($i==0){
				 echo "<tr>";
				 $i=0;
			 }
			
			?>
			<td><a class="ui-button ui-widget ui-corner-all" href="<?php echo $index3_page;?>.php?model1=<?php echo $model1;?>&model2=<?php echo stripslashes($typerow['typeName']);?>&parent_id=<?php echo stripslashes($typerow['id']);?>" rel="external"><?php echo stripslashes($typerow['typeName']);?></a></td>
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
	<div    style="margin-right:3em;position: fixed; right: 0;top :0;" id="list-items">
	 <ul ></ul>
	<input type="hidden" name="qty" id="qty" value="">
	<input type="hidden" name="partno" id="partno" value="">
	<input type="hidden" name="desc" id="desc" value="">
	<input type="hidden" name="price" id="price" value="">
	</div>
</div>
 
 

 
 
</body>
</html>
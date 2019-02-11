<?php 
 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

	 $type00Result = $connection->query("SELECT * FROM type where level='0'");
      if (DB::isError($type00Result))
      die ($type00Result->getMessage());
  
   include_once("index_edit_js.php");
?>
 
<script type="text/javascript">
	 
  $( function() {
 
  $('#qty').numpad();
  ls=Storages.localStorage;
  ls.set('curr_page','model1');
	  
  } );
  
   $.fn.numpad.defaults.onKeypadOpen= function(){
		$(this).find('.nmpd-display').val(0);
	} 
	
	
  $.fn.numpad.defaults.onKeypadCreate = function(){$(this).enhanceWithin();};
  $.fn.numpad.defaults.onKeypadClose = function(){
	  //alert(ls.get('partno.1.id'));
	  //alert(ls.get('partno.1.qty'));
	  if($(this).find('.nmpd-display').val()!="" && $(this).find('.nmpd-display').val()!=0 && $('#desc').val()!=""){
		storeItem();
		$('#quickinput').val('');
		$('#quickinput').focus();
	  }
				
  };
 		 
	 

  </script>
</head>
<body>
<div class="split-me-container"> 
	<div class="split-me">
		 
		<div   style="overflow:scroll; ">
			<?php 
				include_once('./ipadposv2/menu.php');
	  
	  include_once('./ipadposv2/footage.php');?>
	
		 
			<div id="pos2row">
			<?php
			$i=0; 
			  while ($typerow = $type00Result->fetchRow(DB_FETCHMODE_ASSOC))
			 {
				 if ($i==0){
					 
					 $i=0;
				 }
				 
				?>
				 <a class="ui-button ui-widget ui-corner-all" href="/?pos=<?php echo $pos;?>&page=ipadposv2&subpage=index2.php&parent1_name=<?php echo stripslashes($typerow['typeName']);?>&parent_id=<?php echo stripslashes($typerow['id']);?>"  rel="external" ><?php echo stripslashes($typerow['typeName']);?></a>
				 <?php
				 if ($i==4){
					 
					 $i=0;
				 }
				 $i++; 
			}
			?>
			</div>
		</div>
	  
		<div  style="overflow:scroll; " class="scroll-auto"> 
		  <?php include_once('rightform.php');?>
		</div>

	</div>
	
</div>

	<script>
		splitter1 = $('.split-me').touchSplit({leftMax:300, leftMin:150, thickness: 10, dock:"left"});
	</script>
  
</body>
</html>
<?php 
 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

		$parent_id=$_GET['parent_id'];
	 $type1Result = $connection->query("SELECT * FROM type where level='2' and parent_id=".$parent_id);
	 $model1=$_GET['model1'];
	  $model3=$_GET['model2'];
	 $sql="SELECT * FROM sumgoods where model='".$model1."' and model2='".$model2."' and status='Y'";
	  $type1Result = $connection->query($sql);
	 
	 
      if (DB::isError($type1Result))
      die ($type1Result->getMessage());
	$z=0;
    while ($typerow = $type1Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			 $inputname[$z]['partno']=$typerow['goods_partno'];
			 $inputname[$z]['market_price']=$typerow['market_price'];
			 $inputname[$z]['pos_label']=$typerow['pos_label'];
			 $inputname[$z]['goods_detail']=$typerow['goods_detail'];
			 $z++;
		 }
   include_once("index_edit_js.php");
  ?>
  
  <script  type="text/javascript">
   
  $( function() {
    $( document ).tooltip();
 
	$('#qty').numpad();
	ls=Storages.localStorage;
	
	ls.set('curr_page','model3');
	//alert(ls.get('selected_model1'));
 
	$('#pos2row a[href]').click(function(){
		 
		//	ls.set('partno.1.id',$(this).text());
		//$.jStorage.set('partno_1', $(this).text());
	 	//ls.set('partno.1.qty',$('#qty').val());
		$('#action').val('');
		$('#partno').val($(this).attr('partno'));
		$('#desc').val($(this).attr('desc'));
		$('#price').val($(this).attr('price'));
        $('#qty').click();
	});
 
  });
   
   $.fn.numpad.defaults.onKeypadOpen= function(){
	$(this).find('.nmpd-display').val(0);
	} 
  $.fn.numpad.defaults.onKeypadCreate = function(){$(this).enhanceWithin();};
  $.fn.numpad.defaults.onKeypadClose = function(){
	  
	   if($(this).find('.nmpd-display').val()!="" && $(this).find('.nmpd-display').val()!=0 && $('#desc').val()!=""){
		storeItem();
		$('#quickinput').val('');
		//$('#quickinput').focus();
	  } 
				
  };
  

			
  </script>
  
</head>
<body>
<div class="split-me-container"> 
	<div class="split-me">
		 
		<div style="overflow:scroll; ">
		  
			<?php include_once('./ipadposv2/menu.php');?>
		  
			<div id="pos2row">
		 
			<?php 
			 
			?><tr><?php
				 
				for ($i=0;$i<$z;$i++){
					
				?>
				<td>
				<a  href="#" class="ui-button ui-widget ui-corner-all" partno="<?php echo stripslashes($inputname[$i]['partno']);?>" desc="<?php echo stripslashes($inputname[$i]['goods_detail']);?>" price="<?php echo stripslashes($inputname[$i]['market_price']);?>"><?php if($inputname[$i]['pos_label']!=""){echo $inputname[$i]['pos_label'];}else{echo stripslashes($inputname[$i]['goods_detail']);}?></a>
				</td>
				 <?php
				}
			?></tr><?php
			 
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
 <input type="hidden" name="qty" id="qty" value="">
	<input type="hidden" name="partno" id="partno" value="">
	<input type="hidden" name="desc" id="desc" value="">
	<input type="hidden" name="price" id="price" value="">
	<input type="hidden" name="action" id="action" value="">
 

  
 
ls=Storages.localStorage;
var pos='pos1';
	  $(function () { 
		refresh2();  
	  });
	
		function refresh(){
		 
		items = localStorage.getItem(pos+'_myItems');
			if (items != null) {
		
			items = JSON.parse(items);
			var counter = 0;
			var total_price=0;
			 $(".order-list2").html('');
			$(items).each(function (index, data) {
			 
			 
			  $('#qty'+index).val(data[0]);
			  $('#goods_detail'+index).val(data[2]);
			  $('#market_price'+index).val(data[3]);
			  $('#goods_partno'+index).focus();
			 // findPartNoAjax(index);
			     
 
				var newRow = $("<tr bgcolor='#004d80'>");
				var cols = "";
 
				if (data[4]=='Y'){
					cols += '<td><div align="center"><span class="style7">'+(counter+1)+'</span></div></td></td>';
					cols += '<td><input name="goods_partno[]" type="text" id="goods_partno'+counter+'"   readonly="readonly" value="'+data[1]+'"/></td>';
					cols += '<td><input name="qty[]" type="text" id="qty'+counter+'"  value="'+data[0]+'"   ></td>';
					cols += '<td><input name="goods_detail[]" type="text" id="goods_detail'+counter+'"    value="'+data[2]+'" readonly="readyonly"></td>';
					cols += '<td> <input name="market_price[]" type="text" id="market_price'+counter+'"  value="'+data[3]+'"    readonly="readonly"/></td>';
					cols += '<td> <input name="discount[]" type="text" id="discount'+counter+'"  value="0"   /></td>';
					cols += '<td width=10> <input name="deductStockX[]" type="checkbox"  id="deductStockX'+counter+'" value="N" onClick="javascript:clickCheckBoxDeductStock('+counter+')"/></td>';
					cols += '<td  width=10> <input name="cuttingX[]" type="checkbox"  id="cuttingX'+counter+'" value="Y" onClick="javascript:clickCheckBoxCutting('+counter+')" /></td>';
					cols += '<td  width=10> <input name="deliveredX[]" type="checkbox"  id="deliveredX'+counter+'" value="Y" onClick="javascript:clickCheckBoxDelivered('+counter+')" /></td>';
					cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger " data="'+counter+'" value="Delete"></td>';
				}else{
					cols += '<td><div align="center"><span class="style7">'+(counter+1)+'</span></div></td></td>';
					cols += '<td><input name="goods_partno[]" type="text" id="goods_partno'+counter+'"   readonly="readonly" value="'+data[1]+'"/></td>';
					cols += '<td><input name="qty[]" type="text" id="qty'+counter+'"  value="'+data[0]+'"   ></td>';
					cols += '<td><input name="goods_detail[]" type="text" id="goods_detail'+counter+'"  size="35" value="'+data[2]+'"  ></td>';
					cols += '<td> <input name="market_price[]" type="text" id="market_price'+counter+'"  value="'+data[3]+'"    /></td>';
					cols += '<td> <input name="discount[]" type="text" id="discount'+counter+'"  value="0"   /></td>';
					cols += '<td  width=10> <input name="deductStockX[]" type="checkbox"  id="deductStockX'+counter+'" value="N" onClick="javascript:clickCheckBoxDeductStock('+counter+')"/></td>';
					cols += '<td  width=10> <input name="cuttingX[]" type="checkbox"  id="cuttingX'+counter+'" value="Y" onClick="javascript:clickCheckBoxCutting('+counter+')" /></td>';
					cols += '<td  width=10> <input name="deliveredX[]" type="checkbox"  id="deliveredX'+counter+'" value="Y" onClick="javascript:clickCheckBoxDelivered('+counter+')" /></td>';
					cols += '<td ><input type="button" class="ibtnDel btn btn-md btn-danger " data="'+counter+'" value="Delete"></td>';
				}
			 
				total_price=total_price+parseFloat(data[3])*parseFloat(data[0]);
				 
				newRow.append(cols);
				$(".order-list2").append(newRow);
					$(".order-list2").trigger('create');
				counter++;
			});
			
			 
			$('#subsubtotal').val($('#countid').val());
    
		}
		
			$('#alldelivered0').attr('checked',true);
		 
			count_total();
	};
	
	
	 function refresh2() {
		
		var total=0;

		var items = localStorage.getItem(pos+'_memid'); 
		var ul = $('#rightlist');
		ul.html('');
	 
		
		items = localStorage.getItem(pos+'_memadd');		
		 
		
		items = localStorage.getItem(pos+'_receiver');		
	 
		
		items = localStorage.getItem(pos+'_myItems');
		// ul = $('ul');
		//ul.html('');
		if (items != null) {
			items = JSON.parse(items);
			$(items).each(function (index, data) {
				var tmp=index+1;
				total=total+(parseFloat(data[3])*parseFloat(data[0]));
				console.log('totalprice='+total);
			ul.append('<tr><td>['+tmp+']</td><td>' + data[2] +'</td> <td> <a class="chgQty" data="'+index+'" dataDesc="'+data[2]+'" >'+ data[0] +'  件</a></td><td>($'+data[3]+')</td><td> <a class="remove" data="'+index+'">X</a></td></tr>');
			});
				ul.append('<tr><td colspan="1">總數:</td><td colspan="3"> <b>'+total+'</b></td></tr>');
		}
		
		
		var ino = localStorage.getItem('invoiceno');
		 
	 
		 var inoh=$('#ino');
		  
	}
	
	

	
   $(document).on('click', '#cleanall', function(){
	ls=Storages.localStorage;
	ls.remove(pos+'_myItems');
	ls.remove(pos+'_memadd');
	ls.remove(pos+'_memid');
	ls.remove(pos+'_receiver');
	ls.remove('invoiceno');
	 
	inoh.show();
	 refresh(); 
	});
  
  
    $(document).on('click', '.chgQty', function(){
		var id=$(this).attr("data");
		 $('#desc') .val('tempdesc');
		$('#action').val(id);
	 	$('#qty').click();
		
	});
  
    $(document).on('click', '.remove', function(){
	  var del_id=$(this).attr("data");
	  	 var item=[];
			 var items = localStorage.getItem(pos+'_myItems');
			if (items != null) {
			items = JSON.parse(items);
			} else {
			items = new Array();
			}
			items.splice(del_id,1);
			localStorage.setItem(pos+'_myItems',
			JSON.stringify(items));
			refresh();
	});
	
	 $( function() {
		 
		
		$("#backlink").click(function(event) {
			event.preventDefault();
			history.back(1);
		});
		
		$("#nextlink").click(function(event) {
		 	event.preventDefault();
			history.go(1);
		});
	
		$('#model a[href], #modelmenu a[href]').click(function(){
		//alert($(this).text());
			ls.set('selected_model1',$(this).text());
		//alert(ls.get('selected_model1'));
		});
		
			$('#model2 a[href]').click(function(){
		//alert($(this).text());
		ls.set('selected_model2',$(this).text());
		//alert(ls.get('selected_model2'));
		});
 
		
		$('#quickinput').keypress(function (e) {
			if (e.which == 13) {
				  quickinput();
				return false;     
			}
		});
		 
		$("#quickinput").autocomplete({
			minLength: 1,
		    source: "./ipadposv2/search_partno.php",
			focus: function (event, ui) {
				$("#quickinput").val(ui.item.value);
				return false;
			},
			select: function (event, ui) {
				$("#quickinput").val(ui.item.value);
               return false;
			}
		}).data("ui-autocomplete")._renderItem = function (ul, item) {
			return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<a>" + item.label + " ($" + item.desc + ")</a>")
            .appendTo(ul);
		};
			
	
		//quick input click
		$('.quickinput').click(function(){
			  quickinput();
			
		});
		// click mem_id
		$(' .quickinput_memid').click(function(){
			  quickinputMemID();
		});
		// click mem_add
		$('.quickinput_memadd').click(function(){
			  quickinputMemAdd();
		});
		// click receiver
		$('.quickinput_receiver').click(function(){
			  quickinputReceiver();
		});

		 
		
	  });
	  
	   function quickinputMemAdd(){
		  
				var items = localStorage.getItem(pos+'_memadd');
				items = new Array();
				items.push($('#mem_add').val());
				localStorage.setItem(pos+'_memadd',JSON.stringify(items));
				refresh();
	  }
	  
	  function quickinputMemID(){
		var items = localStorage.getItem(pos+'_memid');
		items = new Array();
		items.push($('#mem_id').val());
		localStorage.setItem(pos+'_memid',JSON.stringify(items));
		refresh();
	  }
	  
	  function quickinput(){
		  $('#partno').val($('#quickinput').val());
			findPartNo($('#partno').val());
		 	$('#qty').click();
	  }
	  
	  function quickinputReceiver(){
		var items = localStorage.getItem(pos+'_receiver');
		items = new Array();
		items.push($('#receiver').val());
		localStorage.setItem(pos+'_receiver',JSON.stringify(items));
		refresh();
	  }
	  
	 function storeItem() {
		 
		 
				var item=[];
				var items = localStorage.getItem(pos+'_myItems');
				var id=0;
				id=$('#action').val();
		 
		if(id=='' ){
			 
				item[0] = $('#qty').val();
				item[1] =$('#partno').val();
				item[2] = $('#desc').val();
				item[3] = $('#price').val();
				item[4] = $('#readonly').val();		
					 
				if (items != null) {
					items = JSON.parse(items);
				} else {
					items = new Array();
				}
				
				var count = Object.keys(items).length;
				if (count<16){
		 				items.push(item);
				}else{
					alert('不能輸入多於16件貨');
				}
					
		}else{
			items = JSON.parse(items);
			items[id][0] = $('#qty').val();
		}
		
		$('#action').val('');
		localStorage.setItem(pos+'_myItems',JSON.stringify(items));
		
		refresh();
	}

 function findPartNo(goods_partno, stockFlag) {
 
	 $.ajax({
		 type: 'GET',
		 dataType: "xml",
		 url: "/pos/productxml.php?goods_partno="+goods_partno,
		 success: function(xml){
			 $('#price').val($(xml).find('product_market_price').text());
			// alert( $('#price').val());
    		$('#desc').val($(xml).find('product_goods_detail').text());
			$('#readonly').val($(xml).find('product_readonly').text());
			  // alert( $('#desc').val());
		 }
	 })
		
 
	 
} 
 

			


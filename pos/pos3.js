ls=Storages.localStorage;
var pos='pos3';
 
	  $(function () { 
		refresh(); 
	  });
	
	 function refresh() {
	
		var items = localStorage.getItem(pos+'_memid'); 
		var ul = $('ul');
		ul.html('');
		if (items != null) {
			items = JSON.parse(items);
			$(items).each(function (index, data) {
				var tmp=index+1;
			ul.append('<li>客戶編號 : '+ data+'</li>');
			});
		}
		
		items = localStorage.getItem(pos+'_memadd');		
		 if (items != null) {
			items = JSON.parse(items);
			$(items).each(function (index, data) {
				var tmp=index+1;
			ul.append('<li>地址 : '+ data+'</li>');
			});
		}
		
		items = localStorage.getItem(pos+'_myItems');
		// ul = $('ul');
		//ul.html('');
		if (items != null) {
			items = JSON.parse(items);
			$(items).each(function (index, data) {
				var tmp=index+1;
			ul.append('<li>['+tmp+']' + data[2] +' / '+ data[0] +' <a class="chgQty" data="'+index+'" dataDesc="'+data[2]+'" > 件</a> <a class="remove" data="'+index+'">X</a></li>');
			});
		}
		
		
		var ino = localStorage.getItem(pos+'_invoiceno');
		 
		 var inoed=$('#ino_ed');
		 var inoh=$('#ino');
		 
		  if (ino!=null && ino!=''){
			inoed.html('更改出貨單'+ino);
			inoed.attr("href","/?target=frompos&page=invoice&subpage=invoice_edit.php&id="+ino+"&pos="+pos);
			inoh.hide();
		  }else{
			  inoed.hide();
		  }
		  
		
	
	}
	
	

	
   $(document).on('click', '#cleanall', function(){
	ls=Storages.localStorage;
	ls.remove(pos+'_myItems');
	ls.remove(pos+'_memadd');
	ls.remove(pos+'_memid');
	ls.remove(pos+'_invoiceno');
	inoh.show();
	 refresh(); 
	});
  
  
    $(document).on('click', '.chgQty', function(){
		var id=$(this).attr("data");
		 
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
		    source: "./pos/search_partno.php",
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
		$('#page_footage_div .quickinput').click(function(){
			  quickinput();
			
		});
		// click mem_id
		$('#page_footage_div .quickinput_memid').click(function(){
			  quickinputMemID();
		});
		// click mem_add
		$('.quickinput_memadd').click(function(){
			  quickinputMemAdd();
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
 

			


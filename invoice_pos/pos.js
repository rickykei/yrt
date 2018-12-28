  ls=Storages.localStorage;

 
	  $(function () { refresh(); });
	
	 function refresh() {
	var items = localStorage.getItem('myItems');
	var ul = $('ul');
	ul.html('');
	if (items != null) {
	items = JSON.parse(items);
	$(items).each(function (index, data) {
		var tmp=index+1;
	ul.append('<li>['+tmp+']' + data[2] +' / '+ data[0] +'件 <a class="remove" data="'+index+'">X</a></li>');
	});
	}
	
	
	var ino = localStorage.getItem('invoiceno');
	 
	 var inoed=$('#ino_ed');
	 var inoh=$('#ino');
	 
	  if (ino!=null && ino!=''){
		inoed.html('更改出貨單'+ino);
		inoed.attr("href","../invoice/invoice_edit.php?id="+ino);
		inoh.hide();
	  }else{
		  inoed.hide();
	  }
	}
	
	

	
   $(document).on('click', '#cleanall', function(){
	ls=Storages.localStorage;
	ls.remove('myItems');
	 
	ls=Storages.localStorage;
	ls.remove('invoiceno');
	inoh.show();
	 refresh(); 
	});
  
  
    $(document).on('click', '.remove', function(){
	  var del_id=$(this).attr("data");
	  	 var item=[];
			 var items = localStorage.getItem('myItems');
			if (items != null) {
			items = JSON.parse(items);
			} else {
			items = new Array();
			}
			items.splice(del_id,1);
			localStorage.setItem('myItems',
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
	  });
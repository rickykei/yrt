//first select box

function checkform()
{
	if (document.form1.mem_name.value=="")
	{
		alert('請輸入客戶名稱');
		document.form1.mem_name.focus();
	}
	else
	{
 		document.form1.submit();
		
	}
}


function first_text_box_focus(){
	  $('#width\\[0\\]').focus();
}
 
function check888(){
	
	   if (document.getElementById('mem_id').value=='888')
	   {
		   
		   document.getElementById('status1').checked=true;
		   document.getElementById('delivery2').checked=true;

	   }
}

 

function count_line_total(row_no){
	var total=0.00;
	var squareOfSheet=0;
	var price6AO=25;
	var sheet_org_price=0;
 
	var width=[];
	var height=[];
	var total_amt=0.00;
	var cal_unit=0;
	var no_of_pastic_sheets_count=0.00;
	var double_side_price_added=0.00;
	var pattern_price_added=0.00;
	cal_unit=$('#cal_unit option:selected').val();
	var base_door_price=0;
	var draw_price=0;

		
	 //cal price only , the logic not for stock control
	 
	//cal sheet QTY
	width=$('#width\\['+row_no+'\\]').val();
	height=$('#height\\['+row_no+'\\]').val();
	
	//if missing input val
	if (width<=0||height<=0)
		return false;
	
	//find sheet price
	sheet_selected=$('#sheet_cd\\['+row_no+'\\] option:selected').val();
	result=get_prod_info(sheet_selected);
	sheet_org_price=result['market_price_door'];
	
	//find draw price
	draw_selected=$('#draw_cd\\['+row_no+'\\] option:selected').val();
	if (isNaN(draw_selected)){
		result=get_prod_info(draw_selected);	
		draw_org_price=result['market_price_door'];
		draw_sell_out_qty=result['sell_out_qty'];
		draw_sell_out_unit=result['sell_out_unit'];
		 draw_thereafter_price=result['thereafter_price'];
		
			if (cal_unit=='mm'){
				drawQty=Math.floor(width/draw_sell_out_qty);
				drawQty++;
			}
		 
		draw_price=	draw_org_price*1;
		 
		if(drawQty>1){
			draw_price=draw_price+draw_thereafter_price*(drawQty-1);
		}
	}
	 
	
	//find cut type price
	cutType_selected=$('#cut_type\\['+row_no+'\\] option:selected').val();
	
	if (cutType_selected>0){
		cutTypePrice=25;
	}else{
		cutTypePrice=0;		
	}
	
	if (cal_unit=='mm'){
	squareOfSheet=width/25.4*height/25.4/144;}
	else{
	squareOfSheet=width*height/144;	}

	no_of_pastic_sheets_count=Math.round(Math.max(1,squareOfSheet)*1000)/1000;
	 
	 
	
	base_door_price=Math.round((sheet_org_price*Math.round(no_of_pastic_sheets_count*100)/100)*10)/10;
		//alert(base_door_price);
		
	//cal double Side price added
	if ($('#double_side\\['+row_no+'\\]').is(':checked')==true)
	double_side_price_added=base_door_price*0.2;
	//	no_of_pastic_sheets_count=no_of_pastic_sheets_count*2;
	

	//cal patter price added
	if ($('#pattern\\['+row_no+'\\]').is(':checked')==true)
	pattern_price_added=base_door_price*0.05;
	//cal door handle QTY
	 
	total_amt=base_door_price+double_side_price_added+pattern_price_added+draw_price+cutTypePrice;
	 
	$('#unit_price\\['+row_no+'\\]').val(total_amt.toFixed(2));
	$('#subtotal\\['+row_no+'\\]').val(total_amt.toFixed(2)*$('#qty\\['+row_no+'\\]').val());
	 
	 calTotalAmt();
 }
 
 function calTotalAmt(){
	 var row_no=0;
	 var subtotal=0.00;
	 var subtotalStr="";
	 
	 for (row_no=0;row_no<17;row_no++){
		 subtotalStr=$('#subtotal\\['+row_no+'\\]').val();
		  if (subtotalStr!=""){
			subtotal=subtotal+parseFloat(subtotalStr);
		  }
	 }
	$('#totalamt').val(subtotal.toFixed(2));
 }
 
 function get_prod_info(prod_cd){
	 var result=[];
	 var sell_out_unit;
	 var thereafter_price=0;
	 var product_market_price=0;
	 var product_market_price_door=0;
	 var sell_out_qty=0;
	 
	  $.ajax({
			type: "GET",
			url: 'productxml.php?goods_partno='+prod_cd,
			dataType: 'xml',
			async:false,
			success: function(data){
				// Extract relevant data from XML
				var xml_node = $('product',data);
				//console.log( xml_node.find('product_market_price').text() );
				product_market_price = xml_node.find('product_market_price').text();
				product_market_price_door = xml_node.find('product_market_price_door').text();
				thereafter_price=xml_node.find('thereafter_price').text();
			  	sell_out_unit=xml_node.find('sell_out_unit').text();
				sell_out_qty=xml_node.find('sell_out_qty').text();
			},
			error: function(data){
				console.log('Error loading XML data');
			}
		});
	result["price"]=parseInt(product_market_price);
	result["market_price_door"]=parseInt(product_market_price_door);
	result["thereafter_price"]=parseInt(thereafter_price);
	result['sell_out_unit']=sell_out_unit;
	result["sell_out_qty"]=parseInt(sell_out_qty);
	return result;
 }
 
function count_total()
{
	var total=0.00;
	//cal basic total
	for(i=0;i<17;i++)
	{
		total=total+((document.getElementById('market_price'+i).value*document.getElementById('qty'+i).value*(100-document.getElementById('discount'+i).value))/100);
	}
	//find manpower total 找出苦力的total
	var manpower=0.00;
	var z=0;
	for(i=0;i<17;i++)
	{
		if (document.getElementById('manpowerX'+i).checked==true)
		{
		z=1;
		manpower=manpower+(document.getElementById('market_price'+i).value*document.getElementById('qty'+i).value);
		}
	}
	//count manpower total logic
	var totalmanpower=0.00;
	if (z==1){
	if (manpower>=2500)	{	
//	totalmanpower=manpower*0.06;20060625	
	totalmanpower=manpower*document.getElementById('special_man_power_percent').value/100;	
	}
	else	{	
		totalmanpower=2500*document.getElementById('special_man_power_percent').value/100;	

		
		}
		if (totalmanpower<150)
			totalmanpower=150;
		}
	
	//count specialmanpower total logic
	var totalspecialmanpower=0;
	//if (z==1){
	//totalspecialmanpower=manpower*(document.getElementById('special_man_power_percent').value)/100;
	//}
	
//	alert(total);
//	alert(totalmanpower);
//	alert(totalspecialmanpower);
	var subtotal=0;
	subtotal=total+totalmanpower+totalspecialmanpower;
//alert(subtotal);
	var subsubtotal=0;
	subsubtotal=(subtotal*((100-document.getElementById('subdiscount').value)/100))-document.getElementById('subdeduct').value;
	//subtotal - final discount - deuct
	
	//20080110 CreditCard Charge
	if (document.getElementById('creditcard').checked==true){
		subsubtotal=subsubtotal+Math.round(subsubtotal*1.5/100);
	}
	document.getElementById('countid').value=subsubtotal.toFixed(2);
	document.getElementById('mem_add').focus();
}
	
 
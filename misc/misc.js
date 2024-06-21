//first select box

function checkform()
{ 
		 
	if (!$('#misc_amt\\[0\\]').val())	{
	  
	alert('入野')	 
	}else{
		 
 		document.form1.submit();
		
	}
	
}


 
 
 
 
 function calTotalExpAmt(){
	
	 var row_no=0;
	 var subtotal=0.00;
	 var subtotalStr="";
	 
	 for (row_no=0;row_no<15;row_no++){
		 subtotalStr=$('#misc_amt\\['+row_no+'\\]').val();
		  if (subtotalStr!=""){
			subtotal=subtotal+parseFloat(subtotalStr);
		  }
	 }
	   
	$('#daily_expend').val(subtotal.toFixed(2));
	calTotalCashAmt();
 }
  function calTotalChqAmt(){
	
	 var row_no=0;
	 var subtotal=0.00;
	 var subtotalStr="";
	 console.log("calTotalChqAmt");
	 for (row_no=0;row_no<17;row_no++){
		 subtotalStr=$('#cheque_amt\\['+row_no+'\\]').val();
		  if (subtotalStr!=""){
			subtotal=subtotal+parseFloat(subtotalStr);
		  }
	 }
	 
	console.log(subtotal);	 
	$('#daily_cheque').val(subtotal.toFixed(2));
	calDailyIncome();
 }
   function calTotalCashAmt(){
	
	 var row_no=0;
	 var subtotal=0.00;
	 var subtotalStr="";
	  for (row_no=0;row_no<4;row_no++){
		 subtotalStr=$('#cash_amt\\['+row_no+'\\]').val();
		  if (subtotalStr!=""){
			subtotal=subtotal+parseFloat(subtotalStr);
		  }
	 }
	   
	$('#daily_cash').val(subtotal.toFixed(2));
	calDailyIncome();
	  
 }
 
 
    function calDrawerAmt(){
	
	 var row_no=0;
	 var subtotal=0.00;
	 var subtotalStr="";
	  daily_drawerStr=$('#daily_drawer').val();
		 past_daily_drawerStr=$('#past_daily_drawer').val();
		 
		 
		  if (daily_drawerStr!=""){
			subtotal=subtotal+parseFloat(daily_drawerStr);
		  }
		  if (past_daily_drawerStr!=""){
			subtotal=subtotal-parseFloat(past_daily_drawerStr);
		  }
	   
	$('#drawer_diff').val(subtotal.toFixed(2));
	 
	  
 }
 
    function calDailyIncome(){
	
	 var row_no=0;
	 var subtotal=0.00;
	 var subtotalStr="";
	 
	
		 dailyRevenueStr=$('#daily_revenue').val();
		 dailyExpendStr=$('#daily_expend').val();
		 dailyChequeStr=$('#daily_cheque').val();
		 dailyCCStr=$('#daily_creditcard').val();
		 dailyUPStr=$('#daily_octopus').val();
		 dailyEPSStr=$('#daily_eps').val();
		 dailyFPSStr=$('#daily_ae_card').val();
		 
		 
		 
		 
		  if (dailyRevenueStr!=""){
			subtotal=subtotal+parseFloat(dailyRevenueStr);
		  }
		  if (dailyExpendStr!=""){
			subtotal=subtotal-parseFloat(dailyExpendStr);
		  }
  		  if (dailyChequeStr!=""){
			subtotal=subtotal-parseFloat(dailyChequeStr);
		  }
		  if (dailyCCStr!=""){
			subtotal=subtotal-parseFloat(dailyCCStr);
		  }
		  if (dailyUPStr!=""){
			subtotal=subtotal-parseFloat(dailyUPStr);
		  }
		  if (dailyEPSStr!=""){
			subtotal=subtotal-parseFloat(dailyEPSStr);
		  }
		if (dailyFPSStr!=""){
			subtotal=subtotal-parseFloat(dailyFPSStr);
		  }				  
				  		  
	 
	   
	$('#daily_income').val(subtotal.toFixed(2));
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
	
 
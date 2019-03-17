var totalinvoiceRecord=16;
 function print3color(){
	$( "#print" ).val("3col");
	 checkform();
}
 function find_input_item(){
	var i=0;
	for(i=0;i<17;i++){
			if ($('#partno\\['+i+'\\]').val()!=''){
				findPartNoAjax(i);
			}
	}
}
 
function count_total()
{ 
	 
	var total=0.00;
	//cal basic total
	for(i=0;i<totalinvoiceRecord;i++)
	{
		total=total+((document.getElementById('market_price'+i).value*document.getElementById('qty'+i).value*(100-document.getElementById('discount'+i).value))/100);
	}
	//find manpower total 找出苦力的total
	var manpower=0.00;
	var z=0;
	
	//----disable manpower
	//for(i=0;i<totalinvoiceRecord;i++)
	//{
		//if (document.getElementById('manpowerX'+i).checked==true)
		//{
		//z=1;
		//manpower=manpower+(document.getElementById('market_price'+i).value*document.getElementById('qty'+i).value);
		//}
	//}
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
	
function first_text_box_focus()
{
	//document.getElementById('goods_id0');
	document.getElementById('partno[0]').focus();
	
	//<label></label>document.getElementById('goods_id0').focus();
}
function clickCheckBox(a)
{
	// $i 0-17
	if (document.getElementById('manpowerX'+a).checked)
	{
		document.getElementById('manpower'+a).value='Y';
	}
	else
	{
		document.getElementById('manpower'+a).value='N';
	}
	
}
   
  

function checkform()
{
	
	if (document.form1.mem_name.value=="")
	{
		alert('請輸入客戶名稱');
		document.form1.mem_name.focus();
	}
	else if($('#goods_partno0').val()=="")
	{
		alert('請輸入貨品');
		document.form1.mem_name.focus();
	}
	else
	{
		
	
	
		if ($("#deposit_method2").attr('checked')){
				count_total();
				 //alert($('#mem_dep_bal').val());
				 //alert($('#countid').val());
			if (parseInt($('#mem_dep_bal').val())<parseInt($('#countid').val()))
				alert('會員存款不足');
			else
				document.form1.submit();
		}else{
 		document.form1.submit();
		}
		
	}
}

  
 function findPartNoAjax(goods_row, stockFlag) {
	 
	  
	index = goods_row;
	goods_partno = document.getElementById("partno[" + index+"]").value;
	 
	if (goods_partno != '') {
	 	xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null) {
			alert ("Browser does not support HTTP Request");
			return;
		}
		
		//document.getElementById("real_stock" + index).value = 'Retrieving ...';

		xmlhttp.onreadystatechange=stateChanged;
		xmlhttp.open("GET","/invoice_scrap/productxml.php?goods_partno=" + goods_partno,false);
		xmlhttp.send(null);
 
	}
	calTotalAmt();
} 
 

function stateChanged() {
  
	var cal_unit=0;
	cal_unit=$('#cal_unit option:selected').val();
	width=$('#width\\['+index+'\\]').val();
	height=$('#height\\['+index+'\\]').val();
    qty = $('#qty\\['+index+'\\]').val();
	 
	var marketPrice=0;
	var total_amt=0;
	
	if (xmlhttp.readyState==4) {
	 
		xmlDoc=xmlhttp.responseXML;
		
		element = xmlDoc.getElementsByTagName("product_goods_partno")[0];
		//imgElem = document.getElementById("productCheckImg" + index);
		if (element == null) {
			//imgElem.src = "./images/wrong.png";
			//imgElem.style.display = 'inline';
			//document.getElementById("real_stock" + index).value = '0';
			return;
		}
		else {
			//imgElem.style.display = 'none';
		}
 
		document.getElementById("partno[" + index+"]").value = xmlDoc.getElementsByTagName("product_goods_partno")[0].childNodes[0].nodeValue;
		
		node = xmlDoc.getElementsByTagName("product_goods_detail")[0].childNodes[0]
		//if (node != null) document.getElementById("desc[" + index+"]").value = node.nodeValue;
		

		node = xmlDoc.getElementsByTagName("product_market_price")[0].childNodes[0]
		marketPrice=node.nodeValue;
		if (node != null)	document.getElementById("unit_price[" + index+"]").value = node.nodeValue;

		//check readonly
		node = xmlDoc.getElementsByTagName("product_readonly")[0].childNodes[0]
		
		if (node.nodeValue =='N') 
		document.getElementById("unit_price[" + index+"]").readOnly=false;
		else
		document.getElementById("unit_price[" + index+"]").readOnly=true;
		
		
		if (cal_unit=='mm'){
			total_amt=(Math.round(width/25.416)*Math.round(height/25.416))/144*marketPrice/16;
		}else{
			total_amt=(width*height)/144*marketPrice/16;
		}
		
		 	//add stock bal 20151204
		node = xmlDoc.getElementsByTagName("product_stock_bal")[0].childNodes[0]
		if (node != null) 
			$("#stockbal_" + index).html(node.nodeValue)	
		 
	if(total_amt<15)
		total_amt=15;
	
	total_amt=Math.round(total_amt);
	
	
	$('#unit_price\\['+index+'\\]').val(total_amt.toFixed(2));
	 tmp=total_amt.toFixed(2)*Math.round(qty);
	$('#subtotal\\['+index+'\\]').val(tmp.toFixed(2));
	 
 
 	
	
			
// 20101223 adviced by WanChai Yan
	//	document.getElementById("qty" + index).value = "1";
	}
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
	$('#totalamt').val(subtotal.toFixed(3));
 }




 

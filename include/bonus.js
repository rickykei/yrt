//20170907 1957 

var totalinvoiceRecord=16;
 
  
function first_text_box_focus()
{
	//document.getElementById('goods_id0');
	document.getElementById('goods_partno0').focus();
	
	//<label></label>document.getElementById('goods_id0').focus();
} 


function checkform()
{
	
	  if($('#goods_partno0').val()=="")
	{
		alert('請輸入貨品');
		 
	}
	else
	{
		
	 
			document.form1.submit();
	 
	}
}

  
 function findPartNoAjax(goods_row, stockFlag) {
	index = goods_row;
	goods_partno = document.getElementById("goods_partno" + index).value;
	
	if (goods_partno == '') {
	//	document.getElementById("productCheckImg" + index).style.display = 'none';
	//	clearProductField(index);
	//	calSubTotal();
	}
	else {
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null) {
			alert ("Browser does not support HTTP Request");
			return;
		}
		
		//document.getElementById("real_stock" + index).value = 'Retrieving ...';

		xmlhttp.onreadystatechange=stateChanged;
		xmlhttp.open("GET","/bonus_by_item/productxml.php?goods_partno=" + goods_partno,false);
		xmlhttp.send(null);
 
	}
} 
 








 

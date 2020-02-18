<?php
ini_set('error_reporting', E_ERROR );
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

//get post json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
	 //throw new Exception('Content type must be: application/json');
}
$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
if(!is_array($decoded)){
    throw new Exception('Received content contained invalid JSON!');
}

//init form
isset($decoded['cart_data'])? $cart_arr =$decoded['cart_data']:$cart_arr=""; 
isset($decoded['form_data'])? $form_arr =$decoded['form_data']:$form_arr=""; 

if ($form_arr =="" || $cart_arr==""){
	return false;
}


  
$ok=0;
$totalcounter=count($cart_arr);

//init invoice header
 isset($form_arr['lastname'])? $lastname =$form_arr['lastname']:$lastname=""; 
 isset($form_arr['area'])? $area =$form_arr['area']:$area=""; 
 isset($form_arr['area'])? $area =$form_arr['area']:$area=""; 
  
 $browseryrt="YRT_".$form_arr['area']."_".$form_arr['pc'];
 $delivery_date=$form_arr['delivery_date'];
 $delivery_timeslot=$form_arr['delivery_timeslot'];
 $sales=$form_arr['sales'];
 $mem_name=$form_arr['mem_name'];
 $mem_tel="";
 $mem_add=$form_arr['mem_add'];
 $mem_id=$form_arr['mem_id'];
 $AREA=$form_arr['area'];
 $delivery=$form_arr['delivery'];
 $man_power_price=0;
 $subdiscount=$form_arr['subdiscount'];
 $subdeduct=$form_arr['subdeduct'];
 $special_man_power_percent=$form_arr['special_man_power_percent'];
 $subsubtotal=$form_arr['subtotal'];
 $status=$form_arr['status'];
 $deposit=$form_arr['deposit'];
 $deposit_method=$form_arr['deposit_method'];
 $creditcardrate=$form_arr['creditcardrate'];
 $settledate=$form_arr['settledate'];
 $receiver=$form_arr['receiver'];


//count input
for ($i=0;$i<count($cart_arr);$i++)
{
	$goods_partno[$i]=$cart_arr[$i]["goodsId"];
	$qty[$i]=$cart_arr[$i]["qty"];
	$discount[$i]=$cart_arr[$i]["discount"];
	$market_price[$i]=$cart_arr[$i]["market_price"];
	$subtotal[$i]=$cart_arr[$i]["subtotal"];
	//$manpower[$i]=$cart_arr[$i]["manpower"];
	$manpower[$i]=0;
	$goods_detail[$i]=$cart_arr[$i]["goodsName"];
	$deductStock[$i]=$cart_arr[$i]["deductStock"];
	$cutting[$i]=$cart_arr[$i]["cutting"];
	$delivered[$i]=$cart_arr[$i]["delivered"];
}

 
//get name
include("./include/config3.php");
   $query="SET NAMES 'UTF8'";
   $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result))
      die ($result->getMessage());



  for ($i=0;$i<$totalcounter;$i++)
  {
  //echo $goods_id[$i]."@".$goods_name[$i]."@".$qty[$i]."@".$discount[$i];
  }

  //insert invoice
  $query="insert into invoice (lastname,creation_date,created_by,invoice_no,invoice_date,delivery_date,delivery_timeslot,sales_name,customer_name,customer_tel,customer_detail,member_id,branchID,delivery,man_power_price,discount_percent,discount_deduct,special_man_power_percent,total_price,settle,deposit,deposit_method,credit_card_rate,settledate,receiver) ";
  $query.=" values ('$lastname',SYSDATE(),'$browseryrt','',now(),'$delivery_date',$delivery_timeslot,'$sales','$mem_name','$mem_tel','$mem_add','$mem_id','$AREA','$delivery','$man_power_price','$subdiscount','$subdeduct','$special_man_power_percent','$subsubtotal','$status','$deposit','$deposit_method','$creditcardrate','$settledate','$receiver')";

  
 
 
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  
  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
 
  $row=$result->fetchRow();
  //echo "invoice no=".$row[0];
  $invoice_no=$row[0];

 
  for ($i=0;$i<$totalcounter;$i++)
  {

   $query="insert into goods_invoice (invoice_no,goods_partno,qty,discountrate,marketprice,status,subtotal,manpower,goods_detail,deductstock,cutting,delivered) ";
   $query.=" values ('$invoice_no','$goods_partno[$i]',$qty[$i],$discount[$i],$market_price[$i],'A',$subtotal[$i],'$manpower[$i]','$goods_detail[$i]','$deductStock[$i]','$cutting[$i]','$delivered[$i]') ";
 
 
  $result=$connection->query($query);
  	if (DB::isError($result))
  	{
      die ($result->getMessage());
      
      $ok=0;
      }
      else
      {
      	$ok=1;
      }
      
   
  }
  
  if ($ok==1)
  //echo "invoice insert Success=".$invoice_no;
  {
	  /*if($_REQUEST['print']=='3col'){
		  include_once("./pdf3/pdf_v2.php");
	  }else if($_REQUEST['print']=='boss'){
		  include_once("./pdf3/pdf_vboss.php");
	  }else{
		  include_once("./pdf3/pdf.php");
	  }*/
	   include_once("./pdf3/pdf.php");
		$user_arr=array(
        "order_id" => $invoice_no,
		"pdf_url" => "http://yrtdemo.rickykei.com/invoice/pdf/".$invoice_no.".pdf"
		);
		$result = "{\"success\":\"true\", \"data\":". json_encode($user_arr)."}";  
		echo $result;
  }
   
?> 

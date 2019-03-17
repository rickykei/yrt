<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?".">"; ?><?php
define('FPDF_FONTPATH','./font/');
 
require_once('./pdf2/chinese.php');

//require('../fpdf.php');

//class PDF extends FPDF
class PDF extends PDF_Chinese
{
//Current column
var $col=0;
//Ordinate of column start
var $y0;
var $header_title=array();

function Set_header_title($header_title)
{
	$this->header_title=$header_title;
}
function Body($invoice_no)
{
   include("./include/config.php");

    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());
   $result = $connection->query("SET NAMES 'UTF8'");
   $result = $connection->query("SELECT * FROM invoice where invoice_no=".$invoice_no);

      if (DB::isError($result))
      die ($result->getMessage());
	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC))
   {
     // Print out each element in $row, that is, print the values of
      // the attributes
	$resultCust= $connection->query(" Select * from member where member_id like ".$row['member_id']);
    $rowCust=$resultCust->fetchRow(DB_FETCHMODE_ASSOC);
	$invoice_no1=iconv("UTF-8", "BIG5-HKSCS",$row['invoice_no']);
	$delivery_date=iconv("UTF-8", "BIG5-HKSCS",$row['delivery_date']);
	$invoice_date=iconv("UTF-8", "BIG5-HKSCS",$row['invoice_date']);
	$sales_name=$row['sales_name'];
	$sql=" Select * from staff where name = '".$sales_name."'";
	$resultStaff= $connection->query($sql);
	
	$rowStaff=$resultStaff->fetchRow(DB_FETCHMODE_ASSOC);
	
	$staffTel=$rowStaff['telno'];
 
	$customer_name=iconv("UTF-8", "BIG5-HKSCS",$row['customer_name']."    ".$rowCust["creditLevel"]);
	$customer_tel =iconv("UTF-8", "BIG5-HKSCS",$row['member_id']);
	$customer_detail= iconv("UTF-8", "BIG5-HKSCS",$row['customer_detail']);
	$lastname=iconv("UTF-8", "BIG5-HKSCS",$row['lastname']);
	$receiver= $row['receiver'];
	$delivery=$row['delivery'];
	//20100805
	$creditLevel= $rowCust['creditLevel'];
	
	$discount_percent=$row['discount_percent'];
	//if($discount_percent==0)
	$discount_deduct=$row['discount_deduct'];
	
	$creditcardrate=$row['credit_card_rate'];
	
	$man_power_price=$row['man_power_price'];
	
	$branchid=$row['branchID'];
  
	if ($row['delivery']=="Y")
	$delLabel='送貨';
	else if ($row['delivery']=="C")
	{
		$delLabel='街車即走';
		$rightLabel1='收尾數';
		$rightLabel2='車費客付';
	}
	else if ($row['delivery']=="S")
	$delLabel='自取';
	
	//if ($customer_tel=="888")
	//$delLabel='自取';
   }

 $this->SetY(-3);
   //$this->Ln(95);
  // $this->Ln(85);
   $this->SetTextColor(0,0,0);
   $this->SetFont('Big5','',16);
  // $this->SetDrawColor(255,255,255);
  $border=0;
  
  //20170709 disable shopname
  //$printShopName=$shopAddress[array_search($branchid,$shop_array)];
  //$printShopDetail=$shopDetail[array_search($branchid,$shop_array)];
  
  /*
  if ($branchid=="A")  {
  	$printShopName=SHOP_A;
  	$printShopDetail=SHOP_A_DETAIL;
  }
  else if ($branchid=="Y") {
  	$printShopName=SHOP_Y;
  	$printShopDetail=SHOP_Y_DETAIL;
	}
	else 
	{
	  $printShopName=SHOP_H;
  	$printShopDetail=SHOP_H_DETAIL;
	}*/
	
	
	
	
	if ($delivery=="C")
	{
	
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$printShopName),$border,0,'C',0);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",$rightLabel1),"TRL",1,'C',0);
	 
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'C',0);
	 
  $this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$printShopDetail),$border,0,'C',0);
  $this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",$rightLabel2),"BRL",1,'C',0);
  
	}else{	
//   $this->Cell(216,8,iconv("UTF-8", "BIG5-HKSCS",$printShopName),$border,1,'C',0);
//   $this->Cell(216,8,iconv("UTF-8", "BIG5-HKSCS",$printShopDetail),$border,1,'C',0);

	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$printShopName),$border,0,'C',0);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
	$this->SetFont('Big5','',12);
		$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
		$this->SetFont('Big5','',16);
  $this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$printShopDetail),$border,0,'C',0);
  $this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);

  }
    $result->free ();
   
	$this->SetFont('Big5','',16);
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(105,8,iconv("UTF-8", "BIG5-HKSCS",$receiver).$lastname,$border,0,'L',0);
	$this->SetFont('Big5','',14);
	
	$this->Cell(35,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(50,8,iconv("UTF-8", "BIG5-HKSCS",$delLabel),$border,1,'C',0);
	
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(15,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(70,8,$customer_name,$border,0,'L',0);
	$this->Cell(55,8,iconv("UTF-8", "BIG5-HKSCS",$sales_name),$border,0,'C',0);
	$this->Cell(50,8,$branchid.$invoice_no,$border,1,'C',0);

	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(15,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	//20100805
	if ($creditLevel=='E'){
	$border=1;
	$this->Cell(60,8,$customer_tel,$border,0,'L',0);
	$border=0;
	}else{
	$this->Cell(60,8,$customer_tel,$border,0,'L',0);
	}
	$this->Cell(65,8,iconv("UTF-8", "BIG5-HKSCS",$staffTel),$border,0,'C',0);
	$this->Cell(60,8,iconv("UTF-8", "BIG5-HKSCS","落單").$invoice_date,$border,1,'R',0);
	
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(15,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(90,8,$customer_detail,$border,0,'L',0);
	$this->Cell(35,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
if ($customer_tel=="888")
	$this->Cell(60,8,iconv("UTF-8", "BIG5-HKSCS","自取").$delivery_date,$border,1,'R',0);
	else
	$this->Cell(60,8,iconv("UTF-8", "BIG5-HKSCS","送貨").$delivery_date,$border,1,'R',0);
//	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","地址："),0,0,'R',0);
//	$this->Cell(170,8,$customer_detail,0,1,'L',0);

$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(15,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(80,8,"",$border,0,'L',0);
	
		$this->Ln(12);
		/*
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","行數"),0,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","貨品編號"),0,0,'C',0);
	$this->Cell(52,8,iconv("UTF-8", "BIG5-HKSCS","項目"),0,0,'C',0);
	$this->Cell(22,8,iconv("UTF-8", "BIG5-HKSCS","數量"),0,0,'C',0);
	$this->Cell(22,8,iconv("UTF-8", "BIG5-HKSCS","單價"),0,0,'C',0);
	$this->Cell(22,8,iconv("UTF-8", "BIG5-HKSCS","扶力"),0,0,'C',0);
	$this->Cell(22,8,iconv("UTF-8", "BIG5-HKSCS","共銀"),0,1,'C',0);
*/


//print goods_invoice
   $result = $connection->query("SET NAMES 'UTF8'");
   $result = $connection->query("SELECT goods_invoice.deductstock as deductstock, goods_invoice.cutting as cutting ,goods_invoice.goods_partno as goods_partno,goods_invoice.goods_detail as goods_detail,goods_invoice.qty as qty,goods_invoice.marketprice as marketprice,goods_invoice.manpower as manpower ,goods_invoice.subtotal as subtotal,sumgoods.goods_detail as goods_detail2 ,  discountrate,unit_name_chi FROM goods_invoice,sumgoods,unit where sumgoods.goods_partno=goods_invoice.goods_partno and invoice_no=".$invoice_no." and sumgoods.unitid=unit.id order by goods_invoice.id asc");
      if (DB::isError($result))
      die ($result->getMessage());
	  $i=1;
	while ($row2 =& $result->fetchRow(DB_FETCHMODE_ASSOC))
   {
   $cutting='';$deductstock='';
   		if ($row2['cutting']=='Y')
				$cutting='界';
			if ($row2['deductstock']=='N')
				$deductstock='行';
	$this->Cell(5,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);			
	$this->Cell(10,6,iconv("UTF-8", "BIG5-HKSCS",$i),$border,0,'L',0);
	$this->Cell(30,6,iconv("UTF-8", "BIG5-HKSCS",$row2['goods_partno']),$border,0,'L',0);
	
    $this->Cell(10,6,iconv("UTF-8","BIG5-HKSCS",$cutting.$deductstock),$border,0,'L',0);
	
	if($row2['goods_detail']!="")
		$this->Cell(65,6,iconv("UTF-8", "BIG5-HKSCS",$row2['goods_detail']),$border,0,'L',0);
	else
		$this->Cell(65,6,iconv("UTF-8", "BIG5-HKSCS",$row2['goods_detail2']),$border,0,'L',0);
$this->SetFont('Big5','',18);
$this->Cell(18,6,iconv("UTF-8", "BIG5-HKSCS",number_format($row2['qty'])),$border,0,'R',0);
$this->SetFont('Big5','',14);

$this->Cell(9,6,iconv("UTF-8", "BIG5-HKSCS",$row2['unit_name_chi']),$border,0,'R',0);
	
	$this->Cell(22,6,iconv("UTF-8", "BIG5-HKSCS",$row2['marketprice']),$border,0,'R',0);
	
//	$this->Cell(22,6,iconv("UTF-8", "BIG5-HKSCS",$row2['manpower']),0,0,'C',0);
	//20060410
	//$amount=((100-$row2["discountrate"])/100)*$row2["qty"]*$row2["marketprice"];
	$amount=$row2['subtotal'];
	$this->Cell(25,6,iconv("UTF-8", "BIG5-HKSCS",number_format($row2['subtotal'], 2, '.', ',')),$border,0,'R',0);



	//20071006 add discount display
	$this->SetFont('Big5','',12);
	$discountrate="-".$row2['discountrate']."%";
	if ($row2['discountrate']==0)
	$this->Cell(12,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);
	else
	$this->Cell(12,6,iconv("UTF-8", "BIG5-HKSCS","(".$discountrate.")"),$border,1,'C',0);
	$this->SetFont('Big5','',14);

	$i++;
    $total=$total+$amount;
   }
 $result->free ();
 for ($i=$i;$i<=17;$i++){
 $this->Cell(22,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
 }

		$subtotal=$man_power_price+$total;
		$subtotal=$subtotal-($subtotal*$discount_percent/100);
		$subtotal=$subtotal-$discount_deduct;
		 $this->SetFont('Big5','',13);
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	$this->Cell(100,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'L',0);
	$this->Cell(101,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);
 	 $this->SetFont('Big5','',14);
	if ($creditcardrate!=0){
		$creditcardtotal=round($subtotal*$creditcardrate/100);
	$this->Cell(5,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);		
 	$this->Cell(145,6,iconv("UTF-8", "BIG5-HKSCS","@"),$border,0,'R',0);
 	$this->Cell(25,6,iconv("UTF-8", "BIG5-HKSCS",number_format($creditcardtotal, 2, '.', ',')),$border,0,'L',0);
 	$this->Cell(5,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);
	}
	else
	{ 
	
	$this->Cell(22,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
	}

	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	$this->Cell(140,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'L',0);
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);
	
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	$this->SetFont('Big5','',10);
	//$this->Cell(140,7,iconv("UTF-8", "BIG5-HKSCS","訂造貨品，必須貨到後一個月內取，否則視作客戶自動"),$border,0,'L',0);
	$this->Cell(140,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'L',0);
	$this->SetFont('Big5','',17);
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",number_format($subtotal+$creditcardtotal, 2, '.', ',')),$border,0,'R',0);
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);

	//$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	//$this->SetFont('Big5','',14);
	//$this->Cell(140,7,iconv("UTF-8", "BIG5-HKSCS","放棄該貨品及所付訂金，日後不得追究。"),$border,0,'L',0);
	//$this->Cell(130,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	//$this->Cell(10,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	//$this->SetFont('Big5','',17);
	//$this->Cell(30,7,'',$border,0,'R',0);
 	//$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);
 
		$this->Ln(3);

 	
}
function Header()
{
	//Page header
	global $title;
	global $header_title;
	
	
	$w=$this->GetStringWidth($title)+6;
	$this->SetX(2);
	$this->SetDrawColor(255,255,255);
	$this->SetFillColor(233,233,233);
	$this->SetTextColor(0,0,0);
	//20060621$this->Ln(35);
	$this->Ln(19);
	$this->SetLineWidth(0);
	
//      $abc=iconv("UTF-8", "iso-8859-2", "黃河木行有限公司");
	/*$this->SetFont('Big5','B',30);
	$companyName=iconv("UTF-8", "BIG5-HKSCS", "黃河木行有限公司");
	$companyAddress=iconv("UTF-8", "BIG5-HKSCS", "旺角新填地街609-613號地下");
	$companyTel=iconv("UTF-8", "BIG5-HKSCS", "電話:241-22-241  241-22-335  傳真:241-33-373");
	$INVOICE=iconv("UTF-8", "BIG5-HKSCS", "發票");
	$this->Cell(190,14,$companyName,2,1,'C',0);
	$this->SetFont('Big5','',15);
	$this->Cell(190,5,$companyAddress,1,1,'C',0);
	$this->Cell(190,5,$companyTel,1,1,'C',0);
	$this->SetFont('Big5','B',25);
	$this->Cell(190,12,$INVOICE,1,1,'C',0);
	$this->Ln(8);*/
	//Save ordinate
    $this->y0=$this->GetY();
}

function Footer()
{
	//Page footer
	//$this->SetY(-5);
	//$this->SetFont('Big5','',9);
	//$this->SetTextColor(128);
	//$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}






}





//$pdf=new pdf('P','mm',array(216,217));
$pdf=new pdf('P','mm',array(216,217));
$pdf->SetAutoPageBreak(true,2);
$pdf->SetTopMargin(1);
$pdf->SetLeftMargin(0);
$pdf->AddBig5Font();
$title='出貨單';
$header_title=array();
$pdf->Body($invoice_no);
$pdf->SetAuthor('YRT Company Limited');

$filepath='./invoice/pdf/'.$invoice_no.'.pdf';
if (file_exists($filepath)) {
	//move to backup
	$file_timestamp=date("Ymd_His") ;
	$filepathnew='./invoice/backuppdf/'.$invoice_no.'_'.$file_timestamp.'.pdf';
	copy($filepath, $filepathnew);
}
$pdf->Output($filepath,'F');
?>

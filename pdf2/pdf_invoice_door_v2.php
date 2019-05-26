<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?".">"; ?><?php
define('FPDF_FONTPATH','./font/');
 
require('./pdf2/chinese.php');

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
   $result = $connection->query("SELECT * FROM invoice_door where invoice_no=".$invoice_no);

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
	$cal_unit=$row['cal_unit'];
		
	$sql=" Select * from staff where name = '".$sales_name."'";
	$resultStaff= $connection->query($sql);
	
	$rowStaff=$resultStaff->fetchRow(DB_FETCHMODE_ASSOC);
	
	$staffTel=$rowStaff['telno'];
 
	$customer_name=iconv("UTF-8", "BIG5-HKSCS",$row['customer_name']."    ".$rowCust["creditLevel"]);
	$customer_tel =iconv("UTF-8", "BIG5-HKSCS",$row['member_id']);
	$customer_detail= iconv("UTF-8", "BIG5-HKSCS",$row['customer_detail']);
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
  
 
	
	if ($row["delivery"]=="Y")
	$delLabel='送貨';
	else if ($row["delivery"]=="C")
	{
		$delLabel='街車即走';
	//	$rightLabel1='收尾數';
		$rightLabel2='車費客付';
	}
	else if ($row["delivery"]=="S")
	$delLabel='自取';

	//if ($customer_tel=="888")
	//$delLabel='自取';
   }

 $this->SetY(-3);
   //$this->Ln(95);
  // $this->Ln(85);
   //$this->SetTextColor(0,0,0);
   $this->SetFont('Big5','',16);
  // $this->SetDrawColor(255,255,255);
  $border=0;
  
   
 
    $result->free ();
   
	$this->SetFont('Big5','',16);
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
//	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(105,8,iconv("UTF-8", "BIG5-HKSCS","收貨人:".$receiver.$lastname),$border,0,'L',0);
 	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(65,8,iconv("UTF-8", "BIG5-HKSCS",$delLabel),$border,1,'R',0);
	
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	//$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(65,8,iconv("UTF-8", "BIG5-HKSCS","姓名:").$customer_name,$border,0,'L',0);
	$this->Cell(65,8,iconv("UTF-8", "BIG5-HKSCS","售貨員:".$sales_name),$border,0,'C',0);
	$this->Cell(70,8,iconv("UTF-8", "BIG5-HKSCS","發票編號:").$branchid.$invoice_no,$border,1,'R',0);

	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	//$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	//20100805
	if ($creditLevel=='E'){
		$border=0;
	$this->Cell(65,8,iconv("UTF-8", "BIG5-HKSCS","電話:".$customer_tel),$border,0,'L',0);
	$border=0;
	}else{
	$this->Cell(65,8,iconv("UTF-8", "BIG5-HKSCS","電話:".$customer_tel),$border,0,'L',0);
	}
	$this->Cell(65,8,iconv("UTF-8", "BIG5-HKSCS",$staffTel),$border,0,'C',0);
	$this->Cell(70,8,iconv("UTF-8", "BIG5-HKSCS","日期:落單").$invoice_date,$border,1,'R',0);
	
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	//$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(95,8,iconv("UTF-8", "BIG5-HKSCS","地址:").$customer_detail,$border,0,'L',0);
	$this->Cell(35,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
if ($customer_tel=="888")
	$this->Cell(70,8,iconv("UTF-8", "BIG5-HKSCS","自取").$delivery_date,$border,1,'R',0);
	else
	$this->Cell(70,8,iconv("UTF-8", "BIG5-HKSCS","送貨").$delivery_date,$border,1,'R',0);
//	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","地址："),0,0,'R',0);
//	$this->Cell(170,8,$customer_detail,0,1,'L',0);

$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(15,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(80,8,"",$border,0,'L',0);
	
		$this->Ln(3);

		
 	$this->Cell(5,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	$this->Cell(20,6,iconv("UTF-8", "BIG5-HKSCS","抽手"),1,0,'C',0);
	$this->Cell(30,6,iconv("UTF-8", "BIG5-HKSCS","現貨膠板"),1,0,'C',0);
	$this->Cell(35,6,iconv("UTF-8","BIG5-HKSCS", "膠邊"),1,0,'C',0);
	$this->Cell(70,6,iconv("UTF-8", "BIG5-HKSCS","濶高" ),1,0,'C',0);
 
	$this->Cell(10,6,iconv("UTF-8", "BIG5-HKSCS","數量 "),1,0,'R',0);
	$this->Cell(18,6,iconv("UTF-8", "BIG5-HKSCS","單價 "),1,0,'R',0);
	$this->Cell(18,6,iconv("UTF-8", "BIG5-HKSCS","總金 "),1,1,'R',0);


//print goods_invoice
   $sql="SELECT a.cut_type as cut_type, a.sheet_cd as sheet_cd ,a.strip_cd as strip_cd,a.width as width,a.height as height,a.upcutpoint as upcutpoint,a.downcutpoint as downcutpoint ,a.pattern as pattern,a.double_side as double_side ,  draw_cd,qty,unit_price,a.subtotal FROM goods_invoice_door a where invoice_no=".$invoice_no." order by a.id asc";
   $result = $connection->query($sql);
  
      if (DB::isError($result))
      die ($result->getMessage());
	  $i=1;
	  $this->SetFont('Big5','',14);
	while ($row2 =& $result->fetchRow(DB_FETCHMODE_ASSOC))
   {
   
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);			
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",$i),$border,0,'L',0);
	if ($row2['cut_type']=='0')
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'L',0);
	if ($row2['cut_type']=='1')
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",'平口'),$border,0,'L',0);
	if ($row2['cut_type']=='2')
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",'尖口'),$border,0,'L',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$row2['sheet_cd']),$border,0,'L',0);
	$this->Cell(35,8,iconv("UTF-8","BIG5-HKSCS",$row2['strip_cd']),$border,0,'L',0);
	
	if ($cal_unit=="mm"){
		$this->Cell(25,8,iconv("UTF-8","BIG5-HKSCS",$row2['width'].'x'.$row2['height'].'['.$cal_unit.']'),$border,0,'L',0);
	}else{
			$row2['width']=$row2['width']*25.416;
			$row2['height']=$row2['height']*25.416;
		$this->Cell(25,8,iconv("UTF-8","BIG5-HKSCS",round($row2['width']).' x '.round($row2['height']).'[mm]'),$border,0,'L',0);
	}
	
	
	//$this->Cell(35,6,iconv("UTF-8","BIG5-HKSCS",''),$border,0,'L',0);
	if ($row2['pattern']=='Y')
	$this->Cell(10,8,iconv("UTF-8","BIG5-HKSCS","追紋"),$border,0,'L',0);
	else	
	$this->Cell(10,8,iconv("UTF-8","BIG5-HKSCS",""),$border,0,'L',0);

	if ($row2['double_side']=='Y')
	$this->Cell(10,8,iconv("UTF-8","BIG5-HKSCS","雙面"),$border,0,'L',0);
	else	
	$this->Cell(10,8,iconv("UTF-8","BIG5-HKSCS",""),$border,0,'L',0);
	
	if ($row2['draw_cd']!='')
	$this->Cell(20,8,iconv("UTF-8","BIG5-HKSCS",$row2['draw_cd']),$border,0,'L',0);
	else	
	$this->Cell(20,8,iconv("UTF-8","BIG5-HKSCS",""),$border,0,'L',0);
	
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",number_format($row2['qty'])),$border,0,'R',0);
  
  	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",number_format($row2['unit_price'])),$border,0,'R',0);
	
	$amount=$row2['subtotal'];
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",number_format($row2['subtotal'], 2, '.', ',')),$border,1,'R',0);



	//20071006 add discount display
	 
	

	$i++;
    $total=$total+$amount;
   }
   $this->SetFont('Big5','',14);
 $result->free ();
 for ($i=$i;$i<=17;$i++){
 $this->Cell(22,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
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

	
	$this->SetFont('Big5','',10);
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	$this->Cell(140,7,iconv("UTF-8", "BIG5-HKSCS","*如對本公司服務有何意見，請電:6117 6673。*"),$border,0,'L',0);
	$this->Cell(50,7,iconv("UTF-8", "BIG5-HKSCS","*如要入地盤需繳附加費$500*"),$border,0,'R',0);
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);
	
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	$this->Cell(140,7,iconv("UTF-8", "BIG5-HKSCS","為保障客戶利益，收貨時請即點算清楚貨品及數量。訂造貨品，必須"),$border,0,'L',0);
	$this->Cell(50,7,iconv("UTF-8", "BIG5-HKSCS","*如禁區落貨，需附加費$450*"),$border,0,'R',0);
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);
	
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	$this->Cell(140,7,iconv("UTF-8", "BIG5-HKSCS","由訂貨日起到60天內取，否則視作客戶自動放棄該貨品及訂金，日後不得追究"),$border,0,'L',0);
	$this->Cell(50,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);
	
	
	
		$this->SetFont('Big5','',17);
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);	
	
	//$this->Cell(140,7,iconv("UTF-8", "BIG5-HKSCS","訂造貨品，必須貨到後一個月內取，否則視作客戶自動"),$border,0,'L',0);
	$this->Cell(140,7,iconv("UTF-8", "BIG5-HKSCS","收貨人:"),'B',0,'L',0);

	$this->Cell(50,7,iconv("UTF-8", "BIG5-HKSCS", "共銀:".number_format($subtotal+$creditcardtotal, 2, '.', ',')),$border,0,'R',0);
	$this->Cell(5,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'R',0);

		$this->Ln(3);

 	
}
 
function Header()
{
	//Page header
	global $title;
	global $header_title;
	global $invoice_no;
	global $AREA;
	global $delivery;
	
	$w=$this->GetStringWidth($title)+6;
	$this->SetX(2);
	$this->Ln(12);

	//$this->SetDrawColor(255,255,255);
	//$this->SetFillColor(233,233,233);
	//$this->SetTextColor(0,0,0);
	//20060621$this->Ln(35);
	//$this->Ln(19);
	$this->SetLineWidth(0);
	
  $this->SetFont('Big5','',40);

  if ($AREA=='Y'){
	$shopAddress="九龍旺角通州街2-16號長豐大廈A-M舖地下";
	$shopDetail="TEL : 2412-2335, 2412-2241 FAX : 2413-3373";
  }
  else {
	$shopAddress="九龍旺角鴉蘭街5B號中華漆廠大廈地下D舖";
	$shopDetail="TEL : 2393-9335, 2787-7678 FAX : 2393-8707";
  }
	

 
	
	 
	if ($delivery=="Y")
	$delLabel='送貨';
	else if ($delivery=="C")
	{
		$delLabel='街車即走';
	//	$rightLabel1='收尾數';
		$rightLabel2='車費客付';
	}
	else if ($delivery=="S")
	$delLabel='自取';

	if ($delivery=="C")
	{
	$this->Cell(40,18,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(125,18,iconv("UTF-8", "BIG5-HKSCS","黃河木行有限公司"),$border,0,'C',0);
	$this->Cell(40,18,iconv("UTF-8", "BIG5-HKSCS",$rightLabel1),$border,1,'C',0);
	
	 $this->SetFont('Big5','',23);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$shopAddress),$border,0,'C',0);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
	
	$this->SetFont('Big5','',12);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'C',0);
	$this->SetFont('Big5','',16);
	$this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$shopDetail),$border,0,'C',0);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
  
	}else{	
 	$this->Cell(40,18,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(125,18,iconv("UTF-8", "BIG5-HKSCS","黃河木行有限公司"),$border,0,'C',0);
	$this->Cell(40,18,iconv("UTF-8", "BIG5-HKSCS",$rightLabel1),$border,1,'C',0);
	
	$this->SetFont('Big5','',23);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$shopAddress),$border,0,'C',0);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
	
	$this->SetFont('Big5','',12);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->SetFont('Big5','',16);
    $this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$shopDetail),$border,0,'C',0);
    $this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);

  }
  
  
     if ($title=='提貨單'){
		$this->SetTextColor(255,0,0);
		$this->SetFillColor(255,0,0);
		//$this->SetDrawColor(255, 0, 0);
	}else if ($title=='收據'){
		$this->SetTextColor(0,0,255);
		$this->SetFillColor(0,0,255);
		//$this->SetDrawColor(0, 0, 255);
	}
	
     $this->SetFont('Big5','',23);

  	$this->Cell(40,18,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	 if ($title=='提貨單'){
	$this->Cell(125,18,iconv("UTF-8", "BIG5-HKSCS","※※".$title."※※"),$border,0,'C',0);
	 }else{
		 $this->Cell(125,18,iconv("UTF-8", "BIG5-HKSCS",$title),$border,0,'C',0);
	 }
	 
	 if ($delivery=="C")
	{
		$this->Cell(40,18,iconv("UTF-8", "BIG5-HKSCS",$rightLabel2),"BTRL",1,'C',0);
	}else{
		$this->Cell(40,18,iconv("UTF-8", "BIG5-HKSCS",$rightLabel2),$border,1,'C',0);
	}
	
	$this->SetFont('Big5','',12);
  
  
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
$pdf=new pdf('P','mm','A4');
$pdf->SetAutoPageBreak(true,2);
$pdf->SetTextColor(0,0,0);
$pdf->SetTopMargin(1);
$pdf->SetLeftMargin(0);
$pdf->AddBig5Font();
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(0,0,0);
$pdf->SetDrawColor(0, 0, 0);
$header=array('出貨單','出貨單','出貨單','出貨單','出貨單');
$header_title=array();
$title='發票';
$header_title=array();
$pdf->Body($invoice_no);
 
 $title='收據';
$pdf->Body($invoice_no);

$title='提貨單';
$pdf->Body($invoice_no);
 

$pdf->SetAuthor('YRT Company Limited');

$filepath='./invoice_door/pdf/'.$invoice_no.'.pdf';
if (file_exists($filepath)) {
	//move to backup
	$file_timestamp=date("Ymd_His") ;
	$filepathnew='./invoice_door/backuppdf/'.$invoice_no.'_'.$file_timestamp.'.pdf';
	copy($filepath, $filepathnew);
}
$pdf->Output($filepath,'F');
?>

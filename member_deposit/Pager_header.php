<?
if ( isset($_GET['pagenum']) )
{
   $pagenum = (int)$_GET['pagenum'];
}
else
{
   $pagenum = 1;
}



$pager_option = array(
       "sql" => $sql,
       "PageSize" => 10,
       "CurrentPageID" => $pagenum
);


if ( isset($_GET['numItems']) ){
   $pager_option['numItems'] = (int)$_GET['numItems'];
}else{
	$pager_option['numItems'] =$countTotal;
}

// echo "<p>".date("F j, Y, g:i:s")."21</p>"; 

$pager = @new Pager($pager_option);
// echo "<p>".date("F j, Y, g:i:s")."24</p>"; 
$result = $pager->getPageData();
// echo "<p>".date("F j, Y, g:i:s")." 26</p>"; 
if ( $pager->isFirstPage ){
   $turnover = "<span class=\"style7\">第一頁|上一頁|</span>";
}else{
$turnover = "<a  href='/?page=member_deposit&subpage=list.php&sales=$sales&created_by=$created_by&invoice_date_end=$invoice_date_end&invoice_date_start=$invoice_date_start&invoice_status=$invoice_status&customer_detail=$customer_detail&invoice_no=$invoice_no&goods_partno=$goods_partno&mem_id=$mem_id&pagenum=1&numItems=".$pager->numItems."'>首頁</a>|<a href='?page=member_deposit&subpage=list.php&sales=$sales&created_by=$created_by&invoice_date_end=$invoice_date_end&invoice_date_start=$invoice_date_start&invoice_status=$invoice_status&customer_detail=$customer_detail&invoice_no=$invoice_no&goods_partno=$goods_partno&mem_id=$mem_id&pagenum=".$pager->PreviousPageID."&numItems=".$pager->numItems."'> 上一頁</a>|";
}
if ( $pager->isLastPage ){
   $turnover .= "<span class=\"style7\">下一頁|尾頁</span>";
}else{
$turnover .= "<a class=style1 href='?page=member_deposit&subpage=list.php&sales=$sales&created_by=$created_by&invoice_date_end=$invoice_date_end&invoice_date_start=$invoice_date_start&invoice_status=$invoice_status&customer_detail=$customer_detail&invoice_no=$invoice_no&goods_partno=$goods_partno&mem_id=$mem_id&pagenum=".$pager->NextPageID."&numItems=".$pager->numItems."'> 下一頁</a>|<a href='?page=member_deposit&subpage=list.php&sales=$sales&created_by=$created_by&invoice_date_end=$invoice_date_end&invoice_date_start=$invoice_date_start&invoice_status=$invoice_status&customer_detail=$customer_detail&invoice_no=$invoice_no&goods_partno=$goods_partno&mem_id=$mem_id&pagenum=".$pager->numPages."&numItems=".$pager->numItems."'> 尾頁</a>";
}
?>
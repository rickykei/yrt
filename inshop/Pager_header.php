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
}

$pager = @new Pager($pager_option);
$result = $pager->getPageData();

if ( $pager->isFirstPage ){
   $turnover = "<span class=\"style7\">第一頁|上一頁|</span>";
}else{
$turnover = "<a  href='/?page=inshop&subpage=inshoplist.php&suppliername=$suppliername&instock_date_end=$instock_date_end&instock_date_start=$instock_date_start&goods_partno=$goods_partno&supplier_invoice_no=$supplier_invoice_no&instock_no=$instock_no&pagenum=1&numItems=".$pager->numItems."'>首頁</a>|<a href='/?page=inshop&subpage=inshoplist.php&suppliername=$suppliername&instock_date_end=$instock_date_end&instock_date_start=$instock_date_start&goods_partno=$goods_partno&supplier_invoice_no=$supplier_invoice_no&instock_no=$instock_no&pagenum=".$pager->PreviousPageID."&numItems=".$pager->numItems."'> 上一頁</a>|";
}
if ( $pager->isLastPage ){
   $turnover .= "<span class=\"style7\">下一頁|尾頁</span>";
}else{
$turnover .= "<a href='/?page=inshop&subpage=inshoplist.php&suppliername=$suppliername&instock_date_end=$instock_date_end&instock_date_start=$instock_date_start&goods_partno=$goods_partno&supplier_invoice_no=$supplier_invoice_no&instock_no=$instock_no&pagenum=".$pager->NextPageID."&numItems=".$pager->numItems."'> 下一頁</a>|<a  href='/?page=inshop&subpage=inshoplist.php&suppliername=$suppliername&instock_date_end=$instock_date_end&instock_date_start=$instock_date_start&goods_partno=$goods_partno&supplier_invoice_no=$supplier_invoice_no&instock_no=$instock_no&pagenum=".$pager->numPages."&numItems=".$pager->numItems."'> 尾頁</a>";
}
?>
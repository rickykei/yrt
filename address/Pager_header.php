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
$turnover = "<a  href='/?page=address&subpage=index.php&alert=$alert&address=$address&pagenum=1&numItems=".$pager->numItems."'>首頁</a>|<a href='/?page=address&subpage=index.php&alert=$alert&address=$address&pagenum=".$pager->PreviousPageID."&numItems=".$pager->numItems."'> 上一頁</a>|";
}
if ( $pager->isLastPage ){
   $turnover .= "<span class=\"style7\">下一頁|尾頁</span>";
}else{
$turnover .= "<a class=style1 href='/?page=address&subpage=index.php&alert=$alert&address=$address&pagenum=".$pager->NextPageID."&numItems=".$pager->numItems."'> 下一頁</a>|<a href='/?page=address&subpage=index.php&alert=$alert&address=$address&pagenum=".$pager->numPages."&numItems=".$pager->numItems."'> 尾頁</a>";
}
?>
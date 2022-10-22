<?php
error_reporting(0);
require "./include/Pager.class.php";
if ( isset($_GET['pagenum']) )
{
   $pagenum = (int)$_GET['pagenum'];
}
else
{
   $pagenum = 1;
} ?> 
<link rel="stylesheet" href="./css/supplier_style.css" type="text/css">
<?php
   include_once("./include/config.php");
    $db = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $db->query("SET NAMES 'UTF8'");
   // (Run the query on the winestore through the connection
   
   
   //20110302 search data result
   if ($button!=""){
    $sql="select * from supplier ";
   
   if ($supplier_cd!="")
	$sql2[]=" supplier_id like  '%".$supplier_cd."%'";
   if ($supplier_name!="")
    $sql2[].=" supplier_name like '%".$supplier_name."%'";
   if ($supplier_add!="")
    $sql2[].=" supplier_add like '%".$supplier_add."%'";
   if ($supplier_tel!="")
    $sql2[].=" supplier_tel like '%".$supplier_tel."%'";
   if ($supplier_fax!="")
    $sql2[].=" supplier_fax like '%".$supplier_fax."%'";
   if ($supplier_type!="")
    $sql2[].=" supplier_good_type like '%".$supplier_type."%'";
   
   
   $sql2=implode(" and ", $sql2);
   
   if ($sql2 !="")
   $sql= $sql." where ".$sql2."  order by id asc";
  
    
   }
  
  
  //pass post value to next page
  if ($_POST!=""){
	  foreach ($_POST as $key => $value) {
			$test[]=$key."=".$value;
		}	
		$post_value=implode("&",$test);
   }
   
   $test="";
//
  if ($_GET!=""){
  foreach ($_GET as $key => $value) {
	if ($key!="pagenum")
		$test[]=$key."=".$value;
	}	   
	 $get_value=implode("&",$test);
   
   }
   
   
     $post_value.=$get_value;
	 
   //20110302 search data result
   if ($sql2=="")
   $sql="SELECT * FROM supplier order by id";
   $pager_option = array(
       "sql" => $sql,
       "PageSize" => 10,
       "CurrentPageID" => $pagenum
);
if ( isset($_GET['numItems']) )
{
   $pager_option['numItems'] = (int)$_GET['numItems'];
}
$pager = @new Pager($pager_option);
$result = $pager->getPageData();

if ( $pager->isFirstPage )
{
   $turnover = "第一頁|上一頁|";
}
else
{
   $turnover = "<a href='?pagenum=1&numItems=".$pager->numItems."&$post_value'>首頁</a>|<a href='?pagenum=".$pager->PreviousPageID."&numItems=".$pager->numItems."&$post_value'> 上一頁</a>|";
}
if ( $pager->isLastPage )
{
   $turnover .= "下一頁|尾頁";
}
else
{
   $turnover .= "<a href='?pagenum=".$pager->NextPageID."&numItems=".$pager->numItems."&$post_value'> 下一頁</a>|<a href='?pagenum=".$pager->numPages."&numItems=".$pager->numItems."&$post_value'> 尾頁</a>";
}
?>

<form name="form" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
<div><label>供應商編號：</label>
<input name="supplier_cd" class="buttonstyle" id="invoice_no" size="10" maxlength="10" type="text"></div>
<div><label class="style7">供應商名：</label>
<input name="supplier_name" class="buttonstyle" id="mem_id" size="10" maxlength="10" type="text"></div>
<div><label class="style7">供應商地址：</label>
<input name="supplier_add" class="buttonstyle" id="goods_partno" size="20" maxlength="20" type="text"></div>
<div><label>供應商電話：</label>
<input name="supplier_tel" class="buttonstyle" id="customer_detail" size="20" maxlength="20" type="text"></div>
<div><label>供應商傳真號碼：</label>
<input name="supplier_fax" id="supplier_fax" class="buttonstyle" size="15" type="text">
</div>
 <div><label>供應商類別</label>
<input name="supplier_type" id="supplier_type" class="buttonstyle" size="15" type="text">
 
</div>



<input name="button" value="查供應商" type="submit">
</form>
<hr>
<a href="../">回主頁</a>
   <hr>
<?php
echo $turnover;

   // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?><table ><TR><Th >ID</Th>
<th>供應商編號</Th>
<Th>供應商名</Th>
<Th>供應商地址</Th>
<Th>供應商電話</Th>
<Th>供應商傳真號碼</Th>
<Th>供應商類別</Th>
<Th>供應商運輸</Th>
<Th>修改</Th>
</TR>
    <?php 
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   echo "<tr onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\"> ";
         echo "<td>".$row['id']."</td><td>".$row['supplier_id']."</td><td>".$row['supplier_name']."</td><td>".$row['supplier_add']."</td><td>".$row['supplier_tel']."</td><td>".$row['supplier_fax']."</td><td>".$row['supplier_good_type']."</td><td>".$row['supplier_transprot']."</td><td><a href='/?page=supplier&subpage=insuppliernameedit.php&supplier_id=".$row['supplier_id']."&update=2'>edit </a></td></tr>";

		 }
   ?>
   </table>
<?php echo $turnover;?>
 

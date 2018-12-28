<?
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=test.xls");

   include_once("../include/config.php");
   $query="SET NAMES 'UTF8'";
    $db = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());
 	$result = $db->query("SET NAMES 'UTF8'");
 
    
     $sql="SELECT goods_partno,goods_detail,market_price,status FROM sumgoods order by goods_partno";
     $res=$db->query($sql);
		 
 			 
 ?><table width="763" border=1><TR>
<TD width="184">貨品編號</TD>
<TD width="259">貨品名</TD>
<TD width="81">售價</TD>
<TD width="100">種頪</TD>
<TD width="100">出貨量</TD>
<TD width="100">入貨量</TD>
<TD width="100">退貨量</TD>
<TD width="100">Balance</TD>
</TR>
<?
while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
?><tr>
<td><?=$row['goods_partno']?></td>
<td><?=$row['goods_detail']?></td>
<td><?=$row['market_price']?></td>
<td><?=$row['model']?></td>
<td><?$a=check_invoice($row['goods_partno'],$db,'I');echo $a;?></td>
<td><?$b=check_invoice($row['goods_partno'],$db,'S');echo $b;?></td>
<td><?$c=check_invoice($row['goods_partno'],$db,'R');echo $c;?></td>
<td><?echo $c+$b-$a;?></td>
    </tr>
<?
}
?>
</table><?
 function check_invoice($part_no,$db,$type)
{
if ($type=='I')
 $res=$db->query("select sum(qty) qty from goods_invoice where goods_partno='".$part_no."'");
else if  ($type=='S')
  $res=$db->query("select sum(qty) qty from goods_instock where goods_partno='".$part_no."'");
else if ($type=='R')
  $res=$db->query("select sum(qty) qty from goods_return where goods_partno='".$part_no."'");
  
 $row = $res->fetchRow(DB_FETCHMODE_ASSOC);
 return $row['qty'];
}
?>

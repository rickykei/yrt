<?  include_once("./include/config.php");?>
  
<style type="text/css">
<!--
body {
	background-color: #B2DDEB;
	text-align: center;
}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 22px;
}
-->
</style></head>
<LINK REL=stylesheet HREF="english.css" TYPE="text/css">
<body text="#000000"><table border="0" align="center">
  <tr>
    <td bgcolor="#FFFFFF"><table width="800" border="0" height="91" align="center">
      <tr bgcolor="#999999">
        <td height="34" colspan="3">
          <div align="center" class="style1">YRT 2018  [<?php echo $UNAME; ?>]<a href="/logout.php"> LOGOUT</a> 
 </div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td width="25%">
          <div align="center"><a href="/?page=ingood&subpage=ingoodname.php&add=0" target="_blank">入貨名</a></div></td>
        <td width="54%" height="21">
          <div align="center"><a href="/?page=supplier&subpage=insuppliername.php&add=0" target="_blank">入供應商名</a></div></td>
        <td width="21%" height="21"> <div align="center"><a href="/?page=invoice&subpage=index.php" target="invoice">出貨單</a> </div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td>
          <div align="center"><a href="/?page=ingood&subpage=ingoodnameedit.php" target="_blank">更改入貨名資料</a></div></td>
        <td>
          <div align="center"><a href="/?page=supplier&subpage=insuppliernameedit.php" target="_blank">更改供應商資料</a></div></td>
        <td><div align="center"><a href="/?page=invoice&subpage=invoicelist.php" target="invoicelist">所有出貨單</a></div></td>
      </tr>
	  
	  <tr bgcolor="#CCCCCC">
        <td>
          <div align="center"><a href="/?page=ingood&subpage=ingoodnameedit.php" target="_blank"></a></div></td>
        <td>
          <div align="center"><a href="/?page=supplier&subpage=insuppliernameedit.php" target="_blank"></a></div></td>
        <td><div align="center"><a href="/?page=invoice&subpage=invoicelist_s.php" target="invoicelist">所有出貨單(掛單S)</a></div></td>
      </tr>
	  
	  <tr bgcolor="#CCCCCC">
        <td>
             <div align="center"><a href="/?page=ingood&subpage=index.php" target="_blank">所有入貨名</a></div></td>
        <td>
          <div align="center"><a href="/?page=supplier&subpage=index.php" target="_blank">所有供應商名</a></div></td>
        <td><div align="center"><a href="/?page=invoice&subpage=invoicelist_amend.php" target="invoicelistamend">所有更改出貨單</a></div></td>
      </tr>
	   <tr bgcolor="#CCCCCC">
        <td>     <div align="center"> </div></td>
        <td>  <div align="center"></div></td>
        <td><div align="center"> <a href="/?page=invoice_void&subpage=invoicelist.php" target="invoicelistamend">取消 出貨單</a></div></td>
      </tr>
	  	  <tr bgcolor="#CCCCCC">
        <td>  </td>
        <td>  </td>
        <td> </td>
      </tr>
	        <tr bgcolor="#CCCCCC">
         <td align="center"><a href="/ingood/ingoodcsv.php" target="_blank">入貨名Excel</a></td>
        <td><div align="center"><a href="/?page=posv2&subpage=index.php&pos=pos1" target="_blank">POS1</a> <a href="/?page=posv2&subpage=index.php&pos=pos2" target="_blank">POS2</a> <a href="/?page=posv2&subpage=index.php&pos=pos3" target="_blank">POS3</a>  </div></td>
        <td><div align="center"><a href="/?page=invoice_risk&subpage=invoicelist.php" target="_blank">出貨單<高風險></a></div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
         <td align="center"></td>
        <td><div align="center"><a href="/?page=ipadpos&subpage=index.php&pos=pos1" target="_blank">IPAD POS1</a> <a href="/?page=ipadpos&subpage=index.php&pos=pos2" target="_blank">POS2</a> <a href="/?page=pos&subpage=index.php&pos=pos3" target="_blank">POS3</a>  </div></td>
        <td><div align="center"><a href="/invoice/invoicecsv.php" target="_blank">出貨單Excel</a></div></td>
      </tr>
	  
	  <tr bgcolor="#CCCCCC">
         <td align="center"></td>
        <td><div align="center"><a href="/?page=ipadposv2&subpage=index.html&pos=pos1" target="_blank">IPAD POS1</a> <a href="/?page=ipadpos&subpage=index.php&pos=pos2" target="_blank">POS2</a> <a href="/?page=pos&subpage=index.php&pos=pos3" target="_blank">POS3</a>  </div></td>
        <td><div align="center"><a href="/invoice/invoicecsv.php" target="_blank">出貨單Excel</a></div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td align="center"> </td>
        <td><div align="center"></div></td>
        <td>&nbsp;</td>
      </tr>
	     <tr bgcolor="#CCCCCC">
        <td><div align="center"><a href="/?page=ingood&subpage=goodStockList.php" target="_blank">存貨量查詢</a></div></td>
        <td><div align="center"><a href="/?page=member_deposit&subpage=index.php" target="_blank">會員存款 </a></div></td>
        <td><div align="center"><a href="/?page=invoice_door&subpage=index.php" target="_blank">方邊門出貨單</a></div></td>
      </tr>
	       <tr bgcolor="#CCCCCC">
         <td align="center"><a href="ingood/ingoodcsv.php" target="_blank"></a></td>
        <td><div align="center"> <a href="/?page=member_deposit&subpage=list.php" target="_blank">所有會員存款 </a></div></td>
        <td><div align="center"><a href="?page=invoice_door&subpage=invoice_door_list.php" target="_blank">所有方邊門出貨單</a></div></td>
      </tr>
	    <tr bgcolor="#CCCCCC">
        <td align="center"> </td>
        <td><div align="center"></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#CCCCCC">
         <td align="center"> <a href="/?page=instock&subpage=index.php" target="instock">入倉單</a> </td>
        <td>
          <div align="center"><a href="?page=member&subpage=inmembername.php&add=0" target="_blank">入客戶名</a></div></td>
        <td><div align="center"><a href="/?page=return&subpage=index.php" target="_blank">退貨單</a></div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td align="center"> <a href="/?page=instock&subpage=instocklist.php" target="instocklist">所有入倉單</a></td>
        <td>
          <div align="center"><a href="/?page=member&subpage=inmembernameedit.php" target="_blank">更改客戶資料</a></div></td>
        <td><div align="center"><a href="/?page=return&subpage=returngoodlist.php" target="returngoodlist">所有退貨單</a></div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
            <td align="center"><a href="/instock/instockcsv.php" target="_blank">入倉單Excel</a>	</td>
        <td><div align="center"><a href="/?page=member&subpage=memberlist.php" target="_blank">所有客戶名</a></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#CCCCCC">
       <td align="center"></td>
        <td><div align="center"><a href="member/inmembercsv.php" target="_blank">客戶名Excel</a></div></td>
        <td align="center"><a href="bonus/index.php" target="_blank">花紅計算表</a></td>
      </tr>
	   <tr bgcolor="#CCCCCC">
       <td align="center"></td>
        <td><div align="center"></div></td>
        <td align="center"><a href="bonus_percentage/index.php" target="_blank">花紅百份比計算表</a></td>
      </tr>
	   <tr bgcolor="#CCCCCC">
       <td align="center"></td>
        <td><div align="center"></div></td>
        <td align="center"><a href="/?page=bonus_by_item&subpage=index.php" target="_blank">貨品花紅計算</a></td>
      </tr>
        <tr bgcolor="#CCCCCC">
        <td align="center">  </td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td align="center"><a href="/?page=inshop&subpage=index.php" target="inshop">入舖單</a></td>
        <td><div align="center"><a href="/?page=statistic&subpage=statistic.php" target="_blank">日結查詢</a></div></td>
        <td align="center"><span class="style6"><a href="/?page=staff&subpage=index.php" target="_blank">員工設定</a></span></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td align="center"><div align="center"><a href="?page=inshop&subpage=inshoplist.php" target="inshoplist">所有入舖單</a></div></td>
        <td align="center"><a href="/?page=statistic&subpage=count_out_by_goods_partno.php" target="_blank">查出貨量</a></td>
        <td align="center"><span class="style6"></span></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td align="center"><a href="/?page=pos_inshop&subpage=index.php&pos=pos1" target="inshop">入舖單POS</a></td>
        <td><div align="center"><a href="statistic/stockcsv.php" target="_blank">查存貨記錄</a></div></td>
        <td align="center"><a href="/?page=address&subpage=index.php">地址警告</a></td>
      </tr>
	   </tr>
        <tr bgcolor="#CCCCCC">
        <td align="center">  </td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td align="center"><a href="/?page=invoice_scrap&subpage=index.php" target="_blank">木板碎料出貨單</a></td>
        <td><div align="center"><a href="statistic/costcsv.php" target="_blank">查最新入貨價及倉存</a>Excel</div></td>
        <td><div align="center"><a href="/?page=calculator&subpage=index.php" target="_blank">木板碎料計算表</div></td>
      </tr>
	   <tr bgcolor="#CCCCCC">
        <td align="center"><a href="/?page=invoice_scrap&subpage=list.php" target="_blank">所有木板碎料出貨單</a></td>
        <td><div align="center"><a href="daily_income_report/" target="_blank">  </a> </div></td>
        <td><div align="center">  </div></td>
      </tr>
	  <tr bgcolor="#CCCCCC"><td colspan="3" height="20"></td></tr>
	  <tr bgcolor="#CCCCCC">
        <td><div align="center"><a href="/?page=scrap&subpage=index.php" target="scrapindex">碎料出貨單</a></div></td>
        <td><div align="center"><a href="/?page=prediction&subpage=index.php" target="_blank"> 提貨單預測 </a> </div></td>
        <td><div align="center"> <a href="/?page=misc&subpage=index.php" target="_blank">收支日報表 </a></div></td>
      </tr>
	  	  <tr bgcolor="#CCCCCC">
        <td><div align="center"><a href="/?page=scrap&subpage=scraplist.php" target="scraplist">所有碎料出貨單</a></div></td>
        <td><div align="center"><a href="/?page=statistic&subpage=statistic_delivery_type.php" target="_blank"> 生意額分佈 </a> </div></td>
         <td><div align="center"> <a href="/?page=misc&subpage=misc_list.php" target="_blank">收支日報表 list</a></div></td>
      </tr>
	  	  <tr bgcolor="#CCCCCC">
        <td><div align="center"><a href="/?page=inshop&subpage=inshop_balance.php" target="inshop_balance">入舖存量</a></div></td>
        <td><div align="center"><a href="/?page=delivery_fee&subpage=index.php" target="_blank">街車入數</a> </div></td>
        <td><div align="center">  </div></td>
      </tr>
	    <tr bgcolor="#CCCCCC">
        <td><div align="center"><a href="/?page=inshop&subpage=inshop_balance_less_than_four.php" target="inshop_balance">入舖存量 字頭少過四件</a></div></td>
        <td><div align="center"><a href="/?page=delivery_fee&subpage=list.php" target="_blank">所有街車入數</a></div></td>
        <td><div align="center"><a href="yearly/checkbal.php" target="_blank">盤點</div></td>
      </tr>
    </table></td>
  </tr>
</table><br>
</body></html>
 

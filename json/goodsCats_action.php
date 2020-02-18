<?php 
header("Content-type: application/json; charset=utf-8");
$json='[
    {
        "cat_name":"門。門框",
        "child_cats":[{
            "cat_name":"紅櫸門",
            "goods_list":[
                {
                    "goodsId": 1,
                    "goodsImg": "http://oz36epqiu.bkt.clouddn.com/p1.jpg",
                    "goodsName": "紅櫸門 28寸X81寸",
                    "price": 178
                },
                {
                    "goodsId": 2,
                    "goodsImg": "http://oz36epqiu.bkt.clouddn.com/p2.jpg",
                    "goodsName": "紅櫸門 30寸X81寸",
                    "price": 178
                } 
            ]
        },
        {
            "cat_name":"山樟框",
            "goods_list":[
                {
                    "goodsId": 97,
                    "goodsImg": "http://oz36epqiu.bkt.clouddn.com/p1.jpg",
                    "goodsName": "松木圍身板",
                    "price": 754.00
                },
                {
                    "goodsId": 586,
                    "goodsImg": "http://oz36epqiu.bkt.clouddn.com/p12.jpg",
                    "goodsName": "2寸 x 4寸 山樟門框 24寸",
                    "price": 494.00
                } 
            ]
        }
    ]
    },
    {
        "cat_name":"木枋",
        "child_cats":[{
            "cat_name":"2寸 X 3寸",
            "goods_list":[
                {
                    "goodsId": 1,
                    "goodsImg": "http://oz36epqiu.bkt.clouddn.com/p1.jpg",
                    "goodsName": "光方 2 x 3 (12呎)",
                    "price": 178
                },
                {
                    "goodsId": 2,
                    "goodsImg": "http://oz36epqiu.bkt.clouddn.com/p2.jpg",
                    "goodsName": "光方 2 x 3 (8呎)",
                    "price": 178
                } 
            ]
        },
        {
            "cat_name":"2寸 X 2寸",
            "goods_list":[
                {
                    "goodsId": 1,
                    "goodsImg": "http://oz36epqiu.bkt.clouddn.com/p1.jpg",
                    "goodsName": "光方 2 x 2 (12呎)",
                    "price": 178
                },
                {
                    "goodsId": 2,
                    "goodsImg": "http://oz36epqiu.bkt.clouddn.com/p2.jpg",
                    "goodsName": "光方 2 x 2 (8呎)",
                    "price": 178
                } 
            ]
        }]
    }
]';



$obj=json_decode($json);

//var_dump($obj);
 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	
	$result = $connection->query("SET NAMES 'UTF8'");

	
	
	//gather speical subcat LV2
	
	$specialSubCatSql="select * from sumgoods where model in ('五金','腳線','膠水','什項','花飾板及木皮')";
	$search_spec_product_result = $connection->query($specialSubCatSql);
					 $k=0;
					 $spec_goods_list_json_str="";
					   while ($prod_row = $search_spec_product_result->fetchRow(DB_FETCHMODE_ASSOC)){
						   $spec_goods_list_json_str[$k]['goodsId']=$prod_row['goods_partno'];
						   $spec_goods_list_json_str[$k]['goodsName']=urlencode(str_replace(array('.', ' ', "\n", "\t", "\r"), '',$prod_row['goods_detail']));
						   $spec_goods_list_json_str[$k]['price']=$prod_row['market_price'];
						   $k++;
					   }
					//echo $spec_goods_list_json_str; 
	//gather speical subcat LV2
	
	$type00Result = $connection->query("SELECT * FROM type where level='0' ");
      if (DB::isError($type00Result))
      die ($type00Result->getMessage());
  
	$i=0;
	
	
    while ($typerow = $type00Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			 $json_str[$i]['cat_name']=urlencode($typerow['typeName']);
			 $json_str[$i]['cat_id']=urlencode($typerow['id']);
			 
			 //find subcat
			 $subCatSql="select * from type where level=1 and parent_id=".$typerow['id'];
			  $subCatResult = $connection->query($subCatSql);
			  $j=0;$json_str_lv2="";
			   while ($subcatrow = $subCatResult->fetchRow(DB_FETCHMODE_ASSOC)){
				   $json_str_lv2[$j]['cat_name']=urlencode($subcatrow['typeName']);
				   $json_str_lv2[$j]['cat_id']=urlencode($subcatrow['id']);
				   
				   //find subcat product list
					 $search_product_sql="select * from sumgoods where model='".$typerow['typeName']."' and model2='". $subcatrow['typeName']."' ";
					  
					 $search_product_result = $connection->query($search_product_sql);
					 $k=0;$goods_list_json_str="";
					   while ($prod_row = $search_product_result->fetchRow(DB_FETCHMODE_ASSOC)){
						   $goods_list_json_str[$k]['goodsId']=$prod_row['goods_partno'];
						   $goods_list_json_str[$k]['goodsName']=urlencode(str_replace(array('.', ' ', "\n", "\t", "\r"), '',$prod_row['goods_detail']));
						   $goods_list_json_str[$k]['price']=$prod_row['market_price'];
						   $k++;
					   }
					$json_str_lv2[$j]['goods_list']=$goods_list_json_str;  
					
					   $j++;
				}
			
				
				$json_str[$i]['child_cats']=$json_str_lv2;
				
				
				 
			 $i++;
			 
			 $json_str[$i]['cat_name']=urlencode('總項');
			 $json_str[$i]['cat_id']=urlencode('999');
			 
			 	//add special sub cat
				$j=0;$json_str_lv2="";
				 $json_str_lv2[$j]['cat_name']=urlencode('總項');
				$json_str_lv2[$j]['cat_id']=urlencode('999');
				$json_str_lv2[$j]['goods_list']=$spec_goods_list_json_str;
				$j++;
				$json_str[$i]['child_cats']=$json_str_lv2;
				//add special sub cat
			 
		 }
	echo urldecode(json_encode($json_str ));	 
?>
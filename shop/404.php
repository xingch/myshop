<?php
/**静态化处理
@author liquan
**/
include "HttpClientD.php";
$path = pathinfo($_SERVER['REQUEST_URI']);
$ext=$path['extension'];
$filename=strtolower($path['filename']);
$lfilename= 'http://'.$_SERVER['HTTP_HOST'].'/shop/?act='.shopPathInfo($filename);
if(stripos($ext,'html')===0){
	$key=hash('md4',strtolower($filename));
	try{
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		if($redis->exists($key)){
			echo $redis->get($key).'<!--cached by redis-->';
			exit;
		}else{
			$h=new HttpClientD($lfilename);
			$h->open();
			$value=$h->excute();
			if($value){
				$redis->set($key,$value , Array('nx', 'ex'=>7200));
				echo $value.'<!-- no cache-->';
				exit;
			}else{
				echo 'File not found!';
				exit;
			}
		}
		
	}catch(Exception $e){
		$redis->close();
		echo 'server busy now, try it later!';
		exit;
	}
}
/**静态化路由解析**/
function shopPathInfo($path_info) {
        $reg_match_from = array(
            '/^category$/',
            '/^item-(\d+)$/',
            '/^shop-(\d+)$/',
            '/^shop_view-(\d+)-(\d+)-([0-5])-([0-2])-(\d+)$/',
            '/^article-(\d+)$/',
            '/^article_cate-(\d+)$/',
            '/^document-([a-z_]+)$/',
            '/^cate-(\d+)-([0-9_]+)-([0-9_]+)-([0-3])-([0-2])-([0-1])-([0-1])-(\d+)-(\d+)$/',
            '/^brand-(\d+)-([0-3])-([0-2])-([0-1])-([0-1])-(\d+)-(\d+)$/',
            '/^brand$/',

            '/^groupbuy$/',
            '/^groupbuy_detail-(\d+)$/',

            '/^groupbuy_list-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)$/',
            '/^groupbuy_soon-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)$/',
            '/^groupbuy_history-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)$/',

            '/^vr_groupbuy_list-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)$/',
            '/^vr_groupbuy_soon-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)$/',
            '/^vr_groupbuy_history-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)-(\d+)$/',

            '/^integral$/',
            '/^integral_list$/',
            '/^integral_item-(\d+)$/',
            '/^voucher$/',
            '/^grade$/',
            '/^explog-(\d+)$/',
            '/^comments-(\d+)-([0-3])-(\d+)$/'
        );
        $reg_match_to = array(
            'category&op=index',
            'goods&op=index&goods_id=\\1',
            'show_store&op=index&store_id=\\1',
            'show_store&op=goods_all&store_id=\\1&stc_id=\\2&key=\\3&order=\\4&curpage=\\5',
            'article&op=show&article_id=\\1',
            'article&op=article&ac_id=\\1',
            'document&op=index&code=\\1',
            'search&op=index&cate_id=\\1&b_id=\\2&a_id=\\3&key=\\4&order=\\5&type=\\6&gift=\\7&area_id=\\8&curpage=\\9',
            'brand&op=list&brand=\\1&key=\\2&order=\\3&type=\\4&gift=\\5&area_id=\\6&curpage=\\7',
            'brand&op=index',

            'show_groupbuy&op=index',
            'show_groupbuy&op=groupbuy_detail&group_id=\\1',

            'show_groupbuy&op=groupbuy_list&class=\\1&s_class=\\2&groupbuy_price=\\3&groupbuy_order_key=\\4&groupbuy_order=\\5&curpage=\\6',
            'show_groupbuy&op=groupbuy_soon&class=\\1&s_class=\\2&groupbuy_price=\\3&groupbuy_order_key=\\4&groupbuy_order=\\5&curpage=\\6',
            'show_groupbuy&op=groupbuy_history&class=\\1&s_class=\\2&groupbuy_price=\\3&groupbuy_order_key=\\4&groupbuy_order=\\5&curpage=\\6',

            'show_groupbuy&op=vr_groupbuy_list&vr_class=\\1&vr_s_class=\\2&vr_area=\\3&vr_mall=\\4&groupbuy_price=\\5&groupbuy_order_key=\\6&groupbuy_order=\\7&curpage=\\8',
            'show_groupbuy&op=vr_groupbuy_soon&vr_class=\\1&vr_s_class=\\2&vr_area=\\3&vr_mall=\\4&groupbuy_price=\\5&groupbuy_order_key=\\6&groupbuy_order=\\7&curpage=\\8',
            'show_groupbuy&op=vr_groupbuy_history&vr_class=\\1&vr_s_class=\\2&vr_area=\\3&vr_mall=\\4&groupbuy_price=\\5&groupbuy_order_key=\\6&groupbuy_order=\\7&curpage=\\8',

            'pointshop&op=index',
            'pointprod&op=plist',
            'pointprod&op=pinfo&id=\\1',
            'pointvoucher&op=index',
            'pointgrade&op=index',
            'pointgrade&op=exppointlog&curpage=\\1',
            'goods&op=comments_list&goods_id=\\1&type=\\2&curpage=\\3'
        );
        return preg_replace($reg_match_from,$reg_match_to,$path_info);
    }
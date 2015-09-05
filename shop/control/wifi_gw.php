<?php
/**
 * 网关/路由管理
 * @author Jack.Wang
 * @version 2015.09.03
 */

defined('InShopNC') or exit('Access Invalid!');

class wifi_gwControl extends BaseSellerControl {

    /**
     * 构造方法
     *
     */
    public function __construct() {
        parent::__construct();
        Language::read('member_store_index');
    }
    
    /**
     * 搜索
     */
    public function indexOp(){
    	$this->addOp();
    }
    
    /**
     * 添加 
     */
    public function addOp(){
        if(chksubmit()){
            $gw_name    = trim($_POST['gw_name']);
            $gw_account = trim($_POST['gw_account']);
            $model_gw   = Model('wifi_gw');
            $data   = array(
                'gw_name' => $gw_name,
                'gw_account' => strtoupper($gw_account),
                'member_id' => $_SESSION['member_id']
            );
            $rs = $model_gw->add($data);
            if($rs){
                showDialog('添加路由成功！','index.php?act=wifi_gw&op=index','succ');
            }else{
                showDialog('添加失败！');
            }
        }
    	Tpl::showpage('wifi.gw.add_form');
    }

    //AJAX 检查账号是否存在
    public function ajax_check_accountOp(){
        $gw_account    = trim($_POST['gw_account']);
        $condition  = array('gw_account'=>strtoupper($gw_account));
        $model_gw   = Model('wifi_gw');
        $rs = $model_gw->getGwList($condition);
        echo empty($rs) ? false : true;
        exit;
    }
}


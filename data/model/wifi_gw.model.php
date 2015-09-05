<?php
/**
 * 网关模型
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class wifi_gwModel extends Model {
    
    public function __construct() {
        parent::__construct('wifi_gw');
    }

    public function getGwList($condition, $field = '*') {
        return $this->field($field)->where($condition)->select();
    }

    public function add($params){
        if(empty($params)){
            return false;
        }
        $params['gw_addtime']   = time();
        $result = $this->insert($params);
        return $result;
    }

    public function edit($params, $condition){
        if(empty($params) || empty($condition)){
            return false;
        }
        $params['gw_updatetime']   = time();
        $result = $this->update($params, array('where'=>$condition));
        return $result;
    }
}
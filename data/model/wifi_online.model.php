<?php
/**
 * wifi用户
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class wifi_onlineModel extends Model {
    
    public function __construct() {
        parent::__construct('wifi_online');
    }

    public function getList($condition, $field = '*') {
        return $this->field($field)->where($condition)->select();
    }

    public function add($params){
        if(empty($params)){
            return false;
        }
        $params['ol_addtime']   = time();
        $result = $this->insert($params);
        return $result;
    }

    public function edit($params, $condition){
        if(empty($params) || empty($condition)){
            return false;
        }
        $result = $this->update($params, array('where'=>$condition));
        return $result;
    }
}
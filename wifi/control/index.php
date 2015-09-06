<?php
/**
 * WIFI 认证
 *
 */
defined('InShopNC') or exit('Access Invalid!');

class indexControl {
    public function __construct(){
        $path_info  = parse_url($_SERVER['REQUEST_URI']);
        $get = explode("&",$path_info['query']);
        foreach($get as $v) {
            $b = explode("=", $v);
            $_GET[$b[0]] = $b[1];
        }
    }

    public function indexOp() {

    }
    
    /**
     * 接收路由的心跳请求
     * 如果服务器不能正常获取服务器返回“Pong”的返回，则关闭路由的认证功能，2分钟后路由会再次请求 
     */
    public function pingOp(){
        /*
         * 路由请求参数
        gw_id=%s
        sys_uptime=%lu 
        sys_memfree=%u 
        sys_load=%.2f 
        wifidog_uptime=%lu
        check_time＝       检查周期
        gw_mac=                路由器mac地址  jike特有
        client_count=   连入路由器客户端数量   jike特有
        gw_address=   路由器网关地址 
        router_type=   路由器型号 
        wan_ip=       wan地址
        sv＝                        路由固件版本
        */
        
/*         $_GET    =         array (
          'act' => 'index',
          'op' => 'ping',
          'gw_id' => '04:8D:38:75:0F:77',
          'sys_uptime' => '124810',
          'sys_memfree' => '33456',
          'sys_load' => '0.75',
          'wifidog_uptime' => '76',
          'check_time' => '120',
          'gw_mac' => '04:8d:38:75:0f:77',
          'wan_ip' => '114.117.246.247',
          'clientcount' => '3',
          'gw_address' => '192.168.8.1',
          'router_type' => 'Tencent%20Q3',
          'sv' => '4.6.8',
        ); */
        $gw_id  = trim($_GET['gw_id']);
        $condition  = array('gw_account'=>$gw_id);
        $model_gw   = Model('wifi_gw');
        $rs = $model_gw->getGwList($condition);

        if(!$rs){
            echo 0;exit;
        }else{
            echo 'Pong';
            $gw_sys_uptime     = strtotime($_GET['sys_uptime']);
            $gw_sys_memfree    = floatval($_GET['sys_memfree']);
            $gw_sys_load       = floatval($_GET['sys_load']);
            $check_time        = intval($_GET['check_time']);
            $gw_mac            = trim($_GET['gw_mac']);
            $gw_ip             = trim($_GET['gw_address']);
            $gw_type           = trim($_GET['router_type']);
            $gw_sv             = trim($_GET['sv']);
            $gw_client_count    = intval($_GET['clientcount']);
            $gw_wan_ip          = trim($_GET['wan_ip']);
            $data   = array(
                'gw_type' => $gw_type,
                'gw_sv' => $gw_sv,
                'gw_mac' => strtoupper($gw_mac),
                'gw_ip' => $gw_ip,
                'gw_wan_ip'=> $gw_wan_ip,
                'gw_client_count' => $gw_client_count,
                'gw_sys_memfree' => $gw_sys_memfree,
                'gw_sys_load' => $gw_sys_load,
                'gw_check_time' => $check_time
              
            );
            $rs = $model_gw->edit($data, $condition);
        }
        exit;
    } 
    
    /**
     * 认证入口 
     */
    public function authOp(){
        echo 'Auth: 0';exit;
        echo 2;exit;
        /*
        stage= 请求类型!
        ip= 客户端ip地址!
        mac= 客户端mac地址!
        token= 客户授权码!
        incoming= 下载速率!
        outgoing= 上传速率!
        gw_id= 路由器授权码 !  jike特有
        
        ip，mac，token为⽤用户的基本信息!
        incoming，outgoing为⽤用户的连接计数信息。!
        stage为请求类别，值为 counters/ login/ logout，分别表⽰示：已认证/新认证⽤用
        户/超时删除的⽤用户。  
        当为login的时候  跳转到login页面
        
                    回复内容：
            Auth: 状态码 (注意 中间冒号和状态码之间有个空格)! !
            状态码为：!
            0 认证失败!
            1 认证成功!
        */
        $stage  = trim($_GET['stage']);
        $ip     = trim($_GET['ip']);
        $mac    = trim($_GET['mac']);
        $incoming   = trim($_GET['incoming']);
        $outgoing   = trim($_GET['outgoing']);
        switch ($stage){
            case 'counters'://检查是否超时，如果超时   T出
                
                break;
            case 'login'://检查TOKEN
                echo 'Auth: 1';
                break;
            case 'logout':
            default:
                echo 'Auth: 0';
        }
        exit;
    }
    
    /**
     * 登录页面 
     */
    public function loginOp(){
        /*
        gw_id= 热点账号
        gw_address= 网关地址
        gw_port= 网关端⼝口
        mac= 客户端mac地址
        url= 跳转前url
        gw_mac= 路由器mac地址 jike特有
        
                    注册/登录完成  跳转到路由 http://gw_ip/wifidog/auth?token=xxx    再由路由跳转到auth
                    
        array (
          'act' => 'index',
          'op' => 'login',
          'gw_id' => '04:8D:38:75:0F:77',
          'gw_address' => '6.7.163.151',
          'gw_port' => '80',
          'gw_mac' => '04:8D:38:75:0F:77',
          'mac' => '00:30:18:a0:f6:67',
          'co' => 'jike',
          'url' => 'aHR0cDovL3d3dy5zaW5hLmNvbS5jbi8',
        )
        */
        $gw_id  = strtoupper($_GET['gw_id']);
        $gw_address = trim($_GET['gw_address']);
        $mac    = strtoupper($_GET['mac']);
        $url    = trim($_GET['url']);
        $condition  = array('gw_account'=>$gw_id);
        $model_gw   = Model('wifi_gw');
        $rs = $model_gw->getGwList($condition);
        
        if (!$rs){
            echo '您的路由还没登记，请联系管理员登记！';
            exit;
        }
        if (chksubmit()){//验证处理
            $login_type  = $_POST['login_type'];
             switch ($login_type){
                case 'onekey'://一键无验证登录
                    break;
                    
            }
            //查询当前用户是否存在
            $model_online   = Model('wifi_online');
            $rs = $model_online->getList(array('ol_mac'=>$mac));
            $token   = sha1($mac.time());
            if ($rs){//存在则更新
                $data   = array(
                    'ol_token' => $token,
                    'ol_url' => $url,
                    'gw_account' => $gw_id,
                    'ol_logintype' => $login_type
                );
                $rs     = $model_online->edit($data, array('ol_mac'=>$mac));
            }else {
                $data   = array(
                    'ol_token' => $token,
                    'ol_url' => $url,
                    'gw_account' => $gw_id,
                    'ol_logintype' => $login_type,
                    'ol_mac' => $mac,
                );
                $rs     = $model_online->add($data);
            }
            if (!$rs){
                showDialog('系统错误，请重试！', '', 'error');
            }
            redirect('http://'.$gw_address.'/wifidog/auth?token='.$token);
        }
        $data   = array(
            'ol_url' => $url,
            'gw_account' => $gw_id,
            'ol_logintype' => $login_type,
            'ol_mac' => $mac,
            'gw_address' => $gw_address
        );
        Tpl::output('seo_title', '微购WIFI上网认证');
        Tpl::output('data', $data);
        Tpl::showpage('login');
    }
    
    public function portalOp(){
        var_export($_GET);
    }
    
    public function regOp(){

        echo 111234234234234234232;exit;
    }
}
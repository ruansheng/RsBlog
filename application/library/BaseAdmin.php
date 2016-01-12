<?php
/**
 * @name BaseController
 * @author ruansheng
 * @desc 基础控制器
 */
class BaseAdmin extends Yaf_Controller_Abstract {

    protected $adminid = null;
    protected $admininfo = null;

    private $whiteUri = array(
        '/admin/login/index',
        '/admin/login/doLogin',
        '/admin/tool/addAdmin',
    );

    public function init() {
        session_start();
        $requestUri = $_SERVER['REQUEST_URI'];
        if(!in_array($requestUri, $this->whiteUri)) {
            // 获取session
            $adminid = $_SESSION['adminid'];
            if(empty($adminid)) {
                $this->redirect();
            }
            $Admin = new AdminModel();
            $admininfo = $Admin->getAdminInfo($adminid);

            $this->adminid = $adminid;
            $this->admininfo = $admininfo;
            $this->getView()->assign('adminid', $adminid);
            $this->getView()->assign('admininfo', $admininfo);
            $this->getView()->assign('layer_nav_first', '主面板');
        }
    }

    /**
     * 返回json
     * @param int    $en
     * @param string $em
     * @param array  $data
     */
    public function responseJson($en = 200, $em = 'ok', $data = []) {
        header('Content-type:text/json;');
        $ret = array(
            'en' => $en,
            'em' => $em,
            'data' => $data
        );
        exit(json_encode($ret));
    }

    /**
     * 页面跳转
     * @param string $uri
     */
    public function redirect($uri = '/admin/login/index') {
        header('Location:'.$uri);
        exit;
    }

    /**
     * 打印输出
     * @param      $var
     * @param bool $exit
     */
    public function dump($var,$exit = false){
        echo '<pre>';
            print_r($var);
        echo '</pre>';
        if($exit) {
            exit;
        }
    }
}

<?php

/**
 * @name LoginController
 * @author ruansheng
 */
class LoginController extends BaseAdmin {

    public function init() {
        parent::init();
    }

    /**
     * 登录页面
     * @return bool
     */
	public function indexAction() {
        $this->getView()->assign('title', 'blog');
        return true;
	}

    /**
     * 登录流程
     */
    public function doLoginAction() {
        if(!$this->getRequest()->isPost()) {
            $this->responseJson(401, '请求方式不正确');
        }

        //$username = $this->getRequest()->getParam('username','');
        //$password = $this->getRequest()->getParam('password','');

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username) && empty($password)) {
            $this->responseJson(401, '用户名或密码不能为空');
        }

        $admin = new AdminModel();
        $ret = $admin->login($username, $password);
        if($ret[0]) {
            $_SESSION['adminid'] = $ret[2];
            $this->responseJson(200, $ret[1]);
        } else {
            $this->responseJson(401, $ret[1]);
        }
        return false;
    }

    /**
     * 退出登录
     * @return bool
     */
    public function logoutAction() {

    }
}

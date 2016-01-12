<?php

/**
 * @name AdminController
 * @author ruansheng
 */
class AdminController extends BaseAdmin {

    public function init() {
        parent::init();
        $this->getView()->assign('layer_nav_second', '个人中心');
    }

    /**
     * 设置
     * @return bool
     */
	public function settingAction() {
        return true;
	}

    /**
     *  保存
     */
    public function saveSettingAction() {
        if(!$this->getRequest()->isPost()) {
            $this->responseJson(401, '请求方式不正确');
        }

        $password = $_POST['password'];
        if(empty($password)) {
            $this->responseJson(401, '密码不能为空');
        }

        $admin = new AdminModel();
        $ret = $admin->saveSetting($this->adminid, $password);
        if($ret[0]) {
            $this->responseJson(200, $ret[1]);
        } else {
            $this->responseJson(401, $ret[1]);
        }
        return false;
    }
}

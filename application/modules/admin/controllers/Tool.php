<?php

/**
 * @name ToolController
 * @author ruansheng
 */
class ToolController extends BaseAdmin {

    public function init() {
        parent::init();
    }

    /**
     * @return bool
     */
	public function addAdminAction() {
        $Admin = new AdminModel();
        $ret = $Admin->addAdmin('rs', '123');
        if($ret[0]) {
            $this->responseJson();
        } else {
            $this->responseJson(401, $ret[1]);
        }
        return false;
	}
}

<?php

/**
 * @name IndexController
 * @author ruansheng
 */
class IndexController extends BaseAdmin {

    public function init() {
        parent::init();
        $this->getView()->assign('layer_nav_second', '主页');
    }

    /**
     *
     * @return bool
     */
	public function indexAction() {
        return true;
	}
}

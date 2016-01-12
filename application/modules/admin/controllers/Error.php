<?php
/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @author ruansheng
 */
class ErrorController extends Yaf_Controller_Abstract {

    /**
     * @param $exception
     */
	public function errorAction($exception) {
        echo '<pre>';
            print_r($exception);
        echo '</pre>';
	}
}

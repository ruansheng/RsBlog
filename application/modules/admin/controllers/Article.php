<?php

/**
 * @name ArticleController
 * @author ruansheng
 */
class ArticleController extends BaseAdmin {

    public function init() {
        parent::init();
        $this->getView()->assign('layer_nav_second', '文章');
    }

    /**
     * 文章列表
     * @return bool
     */
	public function listAction() {
        //$p = $this->getRequest()->getParam('p',1);
        $p = isset($_GET['p']) ? $_GET['p'] : 1;

        $query = [];
        $fields = [];
        $sort = ['time'=>-1];
        $index = 0;
        $limit = 10;

        $article = new ArticleModel();

        // 查询文章数
        $count = $article->getArticleCount($query);

        // 查询文章列表
        $rows = $article->getArticleList($query, $fields, $sort, $index, $limit);

        $list = [];
        foreach($rows as $v) {
            $v['date'] = date('Y-m-d H:i:s', $v['time']->sec);
            if($v['update_time'] == 0) {
                $v['update_date'] = '--';
            } else {
                $v['update_date'] = date('Y-m-d H:i:s', $v['update_time']->sec);
            }
            $list[] = $v;
        }

        // 计算分页
        $pager = PagerLib::getPager($count, $limit, $p);

        $pagers = $pager['pagers'];

        $this->getView()->assign('list', $list);
        $this->getView()->assign('pagers', $pagers);

        return true;
	}

    /**
     * 添加
     * @return bool
     */
    public function addAction() {
        return true;
    }

    /**
     * 发布
     * @return bool
     */
    public function publishAction() {
        if(!$this->getRequest()->isPost()) {
            $this->responseJson(401, '请求方式不正确');
        }

        //$username = $this->getRequest()->getParam('username','');
        //$password = $this->getRequest()->getParam('password','');

        $title = $_POST['title'];
        $content = $_POST['content'];

        if(empty($title) && empty($content)) {
            $this->responseJson(401, '文章title或内容不能为空');
        }

        $article = new ArticleModel();
        $ret = $article->addArticle($title, $content);
        if($ret[0]) {
            $this->responseJson(200, $ret[1]);
        } else {
            $this->responseJson(401, $ret[1]);
        }
        return false;
    }

    /**
     * mcrypt
     * @return bool
     */
    public function mcryptAction() {
        /*
        echo '<pre>';
            print_r(mcrypt_list_modes());
        echo '</pre>';

        echo '<pre>';
            print_r(mcrypt_list_algorithms());
        echo '</pre>';
        */
        /*
        $cc = 'my secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret textmy secret text';
        $key = 'my secret key';
        $iv = '12345678';

        $cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');

        mcrypt_generic_init($cipher, $key, $iv);
        $encrypted = mcrypt_generic($cipher,$cc);
        mcrypt_generic_deinit($cipher);
        var_dump($encrypted);

        echo '<br/>';

        mcrypt_generic_init($cipher, $key, $iv);
        $decrypted = mdecrypt_generic($cipher,$encrypted);
        mcrypt_generic_deinit($cipher);
        var_dump($decrypted);

        mcrypt_module_close($cipher);
        */

        $encrypt = $this->encrypt('text');
        $decrypt = $this->decrypt($encrypt);
        var_dump($decrypt);

        return false;
    }

    function encrypt($string) {
        $key = 'my secret key';
        $iv = '12345678';
        $cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
        mcrypt_generic_init($cipher, $key, $iv);
        $encrypted = mcrypt_generic($cipher,$string);
        mcrypt_generic_deinit($cipher);
        mcrypt_module_close($cipher);
        return $encrypted;
    }

    function decrypt($string) {
        $key = 'my secret key';
        $iv = '12345678';
        $cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
        mcrypt_generic_init($cipher, $key, $iv);  //
        $decrypted = mdecrypt_generic($cipher,$string);
        mcrypt_generic_deinit($cipher);
        mcrypt_module_close($cipher);
        return $decrypted;
    }

}

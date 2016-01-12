<?php
/**
 * @name AdminModel
 * @author ruansheng
 */
class ArticleModel {

    private $masterArticleCollection = null;

    /**
     * __construct
     */
    public function __construct() {
        $this->masterArticleCollection = MongoClientFactory::getBlogMongoClient()->selectCollection('article');
    }

    /**
     * 获取文章list
     * @param array $query
     * @param array $fields
     * @param array $sort
     * @param int   $index
     * @param int   $limit
     * @return mixed
     */
    public function getArticleList($query = [], $fields = [], $sort = [], $index = 0, $limit = 10) {
        $rows = $this->masterArticleCollection->find($query)->fields($fields)->sort($sort)->skip($index)->limit($limit);
        $list = [];
        foreach($rows as $row) {
            $list[] = $row;
        }
        return $list;
    }

    /**
     * 查询文章数
     * @param array $query
     * @return int
     */
    public function getArticleCount($query = []) {
        $count = $this->masterArticleCollection->find($query)->count();
        return $count;
    }

    /**
     * 获取文章info
     * @param $_id
     * @return array
     */
    public function getArticleInfo($_id) {
        $query = array(
            '_id' => new MongoId($_id)
        );
        $info = $this->masterArticleCollection->findOne($query);
        return $info;
    }

    /**
     * 添加文章
     * @param $title
     * @param $content
     * @return bool
     */
    public function addArticle($title, $content) {
        $data = array(
            'title' => $title,
            'content' => $content,
            'time' => new MongoDate(),
            'update_time' => 0,
            'status' => 1,   // 1 正常  2 删除
        );
        $status = $this->masterArticleCollection->insert($data);
        if(!$status) {
            return array(false, '添加失败');
        }
        return array(true, '添加成功');
    }
}

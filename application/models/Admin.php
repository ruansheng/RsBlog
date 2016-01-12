<?php
/**
 * @name AdminModel
 * @author ruansheng
 */
class AdminModel {

    private $masterAdminCollection = null;

    public function __construct() {
        $this->masterAdminCollection = MongoClientFactory::getBlogMongoClient()->selectCollection('admin');
    }

    /**
     * 登录检测
     * @param $username
     * @param $password
     * @return bool
     */
    public function login($username, $password) {
        $query = array(
            'username' => $username,
            'password' => sha1($password),
        );
        $row = $this->masterAdminCollection->findOne($query);
        if(empty($row)) {
            return array(false, '账号或密码错误');
        }
        return array(true, '登录成功', $row['_id']->{'$id'});
    }

    /**
     * 获取admininfo
     * @param $_id
     * @return array
     */
    public function getAdminInfo($_id) {
        $query = array(
            '_id' => new MongoId($_id)
        );
        $info = $this->masterAdminCollection->findOne($query);
        return $info;
    }

    /**
     * 添加管理员
     * @param $username
     * @param $password
     * @return bool
     */
    public function addAdmin($username, $password) {
        $query = array(
            'username' => $username
        );
        $row = $this->masterAdminCollection->findOne($query);
        if($row) {
            return array(false, '要添加的账号已存在');
        }
        $data = array(
            'username' => $username,
            'password' => sha1($password),
            'time' => new MongoDate(),
        );
        $status = $this->masterAdminCollection->insert($data);
        if(!$status) {
            return array(false, '要添加的账号已存在');
        }
        return array(true, '添加成功');
    }

    /**
     * 保存设置
     * @param $adminid
     * @param $password
     * @return bool
     */
    public function saveSetting($adminid, $password) {
        $query = array(
            '_id' => new MongoId($adminid)
        );
        $row = $this->masterAdminCollection->findOne($query);
        if(empty($row)) {
            return array(false, '账号不存在');
        }
        $data = array(
            'password' => sha1($password),
        );
        $status = $this->masterAdminCollection->update($query, $data);
        if(!$status) {
            return array(false, '更新失败');
        }
        return array(true, '更新成功');
    }
}

<?php

class MenuModel extends Model {

    public $errorInfo = '';

    //返回逻辑表名
    protected function tableName() {
        return 'goods_type';
    }

    /**
     * 获取树状结构。
     * 获取某个分类的所有后代分类。
     * @staticvar array $list
     * @param array $allCat
     * @param integer $rootId
     * @param integer $deep
     * @return array
     */
    private function getTree(array &$allCat, $rootId = 0, $deep = 0) {
        static $list = array();
        foreach ($allCat as $cat) {
            if ($cat['parent_id'] == $rootId) {
                $cat['deep'] = $deep;
                $this->getTree($allCat, $cat['type_id'], $deep + 1);
            }
        }
        return $list;
    }

    /**
     * 获取树状结构接口。
     * @return array
     */
    public function getTreeList() {
        $allCat = $this->getAll();
        return $this->getTree($allCat, 0, 0);
    }

}

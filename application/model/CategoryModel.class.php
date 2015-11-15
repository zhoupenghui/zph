<?php

class CategoryModel extends Model {

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
                $list[] = $cat;
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

    /**
     * 增加分类。
     * @param string $typeName
     * @param integer $parentId
     * @return boolean
     */
    public function addCat($typeName, $parentId) {
        //首先查询是否有同名的分类在同一父级分类下。
        if (!$this->checkCat($typeName, $parentId)) {
            $sql = "insert into " . $this->Table() . " (type_name,parent_id) values('$typeName',$parentId)";
            return $this->db->query($sql);
        } else {
            $this->errorInfo = '错误：分类已存在';
            return false;
        }
    }

    /**
     * 修改分类，判断分类是否合法。
     * @param integer $typeId
     * @param string $typeName
     * @param integer $parentId
     * @return boolean
     */
    public function modifyCat($typeId, $typeName, $parentId) {
        //判断是否有子分类
        $allCat = $this->getAll();
        $list = $this->getTree($allCat, $typeId);
        $ids = array();
        foreach ($list as $item) {
            $ids[] = $item['type_id'];
        }
        $ids[] = $typeId;
        if (in_array($parentId, $ids)) {
            $this->errorInfo = '不能将分类移动到其自身或者后代分类下';
            return false;
        }
        //判断要移动的分类下不能有同名分类
        if (!$this->checkCat($typeName, $parentId)) {
            $data = array('type_name' => $typeName, 'type_id' => $typeId, 'parent_id' => $parentId);
            return $this->updateData($data);
        }
        $this->errorInfo = '错误：分类已存在';
        return false;
    }

    /**
     * 查看指定分类下是否有某个名字的分类。
     * @param type $typeName
     * @param type $parentId
     * @return boolean
     */
    public function checkCat($typeName, $parentId) {
        $sql = "select 1 from " . $this->Table() . " where type_name='$typeName' and parent_id='$parentId'";
        if ($this->db->fetchColumn($sql)) {
            return true;
        }
        return false;
    }

    /**
     * 判断某个分类下是否有子分类。
     * @param integer|string $typeId
     */
    public function checkIsHadCat($typeId) {
        $sql = "select 1 from {$this->table()} where parent_id='$typeId'";
        return $this->db->fetchColumn($sql);
    }

}

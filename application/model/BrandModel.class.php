<?php

class BrandModel extends Model {
    /*
     * 
     */

    protected function tableName() {
        return 'goods_brand';
    }

    /*
     * 实现商品品牌列表
     */

    public function brandList() {
        $sql = "select * from {$this->table()}";
        return $this->db->fetchAll($sql);
    }

    public function getByPage($page, $size, $where = '') {
        $start = ($page - 1) * $size;
        $sql = 'SELECT count(*) as count from ' . $this->table();
        if ($where) {
            $sql .= ' where ' . $where;
        }
        $total = $this->db->fetchColumn($sql);
        $sql = 'SELECT * from ' . $this->table();
        if ($where) {
            $sql .= ' where ' . $where;
        }
        $sql .= ' limit ' . $start . ',' . $size;
        $list = $this->db->fetchAll($sql);
        return array('total' => $total, 'data' => $list);
    }

}

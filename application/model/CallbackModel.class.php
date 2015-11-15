<?php

class CallbackModel extends Model {

    protected function tableName() {
        return 'goods';
    }

    public function getByPage1($page, $size) {
        $start = ($page - 1) * $size;
        $sql = 'SELECT count(*) as count from ' . $this->table() . 'where `goods_delete`= 1';
        $total = $this->db->fetchColumn($sql);
        $sql = 'SELECT * from ' . $this->table();
        $sql .= ' limit ' . $start . ',' . $size;
        $list = $this->db->fetchAll($sql);
        return array('total' => $total, 'data' => $list);
    }

}

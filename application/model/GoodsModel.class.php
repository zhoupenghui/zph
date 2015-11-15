<?php

class GoodsModel extends Model {

    protected function tableName() {
        return 'goods';
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

    public function brQuery($key, $value) {
        $sql = "select * from {$this->table()} where `$key`='$value'";
        return $this->db->fetchAll($sql);
    }

}

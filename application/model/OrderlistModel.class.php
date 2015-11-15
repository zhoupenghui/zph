<?php

class OrderlistModel extends Model {

    protected function tableName() {
        return 'order_list';
    }

    // 静态变量，用于添加订单，搜索会员时，保存会员名
    public static $consignee = "";

    // 分页
    public function getByPage($page, $size, $where = "") {
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

    // 通过订单号查询具体哪一条订单
    public function gettolist($order_sn) {
        $sql = "SELECT * FROM" . $this->table() . "WHERE order_num=$order_sn";
        return $this->db->fetchAll($sql);
    }

    //通过收货人查询具体某一条订单
    public function getWhere($consignee) {
        $sql = "SELECT * FROM " . $this->table() . " WHERE consignee='$consignee'";
        return $this->db->fetchAll($sql);
    }

}

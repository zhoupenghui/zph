<?php

class SearchModel extends Model {

    protected function tableName() {
        return 'goods';
    }

    // 通过商品名称搜索某一件商品
    public function SearchAction($keyword) {
        $sql = "SELECT * FROM" . $this->Table() . "WHERE goods_name='$keyword'";
        return $this->db->fetchAll($sql);
    }

    // 通过商品ID搜索某一件商品
    public function SearchByIdAction($goods_id) {
        $sql = "SELECT * FROM" . $this->Table() . "WHERE goods_id='$goods_id'";
        return $this->db->fetchAll($sql);
    }

}

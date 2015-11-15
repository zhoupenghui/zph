<?php

class AddorderModel extends Model {

    protected function tableName() {
        return 'userinfo';
    }

    // 获取某一条数据
    public function CheckAction($anonymous) {
        $sql = "SELECT * FROM" . $this->Table() . "WHERE user_name='$anonymous'";
        return $this->db->fetchAll($sql);
    }

}

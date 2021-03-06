<?php

class MemberModel extends Model {

    /**
     * 
     */
    //完成抽象方法
    protected function tableName() {
        //返回该模型（控制器所在的表名--后缀）
        return 'userinfo';
    }

    public function getByPage($page, $size, $where = '') {
        //计算起始页
        $start = ($page - 1) * $size;
        //构建获取所有记录的SQL语句
        $sql = "select count(*) count from " . $this->table();
        //判断有没有where条件
        if ($where) {
            //如果有where条件就拼接SQL语句
            $sql.=" where " . $where;
        }
        //发送SQL语句，获取字段的第一个值:这个值就是总记录数
        $total = $this->db->fetchColumn($sql);
        // 通过分页查询所有数据
        $sql = "select * from " . $this->table();
        //判断是否有where条件
        if ($where) {
            //如果有where条件，就拼接SQL语句
            $sql.=" where " . $where;
        }
        //拼接分页查询的关键字和语句
        $sql.=" limit " . $start . ',' . $size;
        //发送SQL语句，获取分页数据组
        $list = $this->db->fetchAll($sql);
        //返回一个数组，数组里包括：总记录数（分页时要用），分页数据
        return array('total' => $total, 'data' => $list);
    }

    //定义一个模糊查询
    public function checkSelect($connect) {
        //判断$connect是否为空
        $sql = "select * from " . $this->table();
        if ($connect) {
            //拼接SQL语句           
            $sql.="  where " . $connect;
        }
        return $this->db->fetchAll($sql);
    }

}

?>

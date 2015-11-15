<?php

abstract class Model {

    /**
     *
     * @var db
     */
    protected $db;
    protected $fields = array(); //存储此表中所有的字段名

    public function __construct() {
        $this->initDb();
        $this->initFields();
    }

    //定义一个抽象方法，要求返回逻辑表名
    abstract protected function tableName();

    //定义一个方法，要求返回一个完整表名
    protected function table() {
        return '`' . $GLOBALS['config']['database']['prefix'] . $this->tableName() . '`';
    }

    //初始化db对象，所有的数据库操作都应当使用db属性
    private function initDb() {
        $this->db = db::getInstance($GLOBALS['config']['database']);
    }

    /**
     * 初始化字段列表，获取主键和所有字段名字。
     * @return null
     */
    private function initFields() {
        $sql = 'DESC ' . $this->table();
        $rst = $this->db->fetchAll($sql);
        foreach ($rst as $field) {
            $this->fields[] = $field['Field'];
            if ($field['Key'] == 'PRI') {
                $this->fields['pk'] = $field['Field'];
            }
        }
    }

    /**
     * 通过主键获取一行记录。
     * @param mixed：integer|string $pk  主键值
     * @return array
     */
    public function getByPk($pk) {
        $sql = "select * from {$this->table()} where `{$this->fields['pk']}`='$pk'";
        return $this->db->fetchRow($sql);
    }

    /**
     * 通过主键删除一条记录
     * @param mixed：string|integer $pk 主键值
     * @return boolean
     */
    public function deleteByPk($pk) {
        $sql = "delete from {$this->table()} where `{$this->fields['pk']}`='$pk'";
        return $this->db->query($sql);
    }

    //更新回收站数据
    public function Restore($value, $goodsid) {
        $sql = "update {$this->table()} set `goods_delete`=$value where `goods_id`=$goodsid";
        return $this->db->query($sql);
    }

    /**
     * 获得所有记录。
     * @return array
     */
    public function getAll() {
        $sql = "select * from {$this->table()}";
        return $this->db->fetchAll($sql);
    }

    //获取指定查询
    public function query($key, $value) {
        if (!$key && !value) {
            $sql = "select * from {$this->table()}";
        }
        $sql = "select * from {$this->table()}";
        $sql .=' where ' . $key . '=' . $value;
        return $this->db->fetchAll($sql);
    }

    /**
     * 插入数据。
     * @param array $data
     * @return type
     */
    public function insertData(array $data) {
        $sql = "insert into {$this->table()} ";
        $fields = array_keys($data); //所有的字段名
        $fieldsTmp = array();
        foreach ($fields as $field) {
            //将不存在的字段剔除掉,过滤掉不合法的字段
            if (in_array($field, $this->fields)) {
                $fieldsTmp[] = '`' . $field . '`'; //如果合法，加上反斜点，避免歧义
            } else {
                unset($data[$field]); //不存在的字段，销毁掉
            }
        }
        $sql .= '(' . implode(',', $fieldsTmp) . ')';
        if ($fieldsTmp) {
            $sql .= ' values ';
            $columnTmp = array();
            foreach ($data as $column) {
                $columnTmp[] = "'" . $column . "'"; //将数据两边添加单引号
            }
            $sql .= '(' . implode(',', $columnTmp) . ')'; //将数据数组转换成字符串，并拼接()
            if ($this->db->query($sql)) {
                return mysql_insert_id(); //返回新建记录的id
            }
        }
        return false;
    }

    /**
     * 通过数据内容，进行记录修改。
     * 1.去除非法数据
     * 2.判断是否还有数据，如果没有，就终止
     * 3.判断是否有条件
     * 4.判断是否有主键
     * 如果3 4都不成立，取消执行
     * @param array $data
     * @param string $where
     * @return boolean
     */
    public function updateData(array $data, $where = '') {

        $sql = "update {$this->table()} set ";
        $fields = array_keys($data);
        $fieldsTmp = array();
        //过滤非法数据，拼凑set子语句
        foreach ($fields as $field) {
            //将不存在的字段剔除掉,过滤掉不合法的字段
            if (in_array($field, $this->fields)) {
                $fieldsTmp[] = '`' . $field . '`=' . "'{$data[$field]}'"; //如果合法，加上反斜点，避免歧义
            } else {
                unset($data[$field]); //不存在的字段，销毁掉
            }
        }
        $sql .= implode(',', $fieldsTmp);
        if ($fieldsTmp) {
            //不允许修改全表，所以判断有没有where条件
            if ($where) {
                $sql .= ' where ' . $where;

                return $this->db->query($sql);
            } elseif (isset($data[$this->fields['pk']])) {//如果没有where条件，就判断是否有主键数据
                $sql .= " where `{$this->fields['pk']}`={$data[$this->fields['pk']]}";
                return $this->db->query($sql);
            }
        }
        return false;
    }

}

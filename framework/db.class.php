<?php

class db {

    private $host = 'localhost';
    private $port = '3306';
    private $user = 'root';
    private $pwd = '123456';
    private $charset = 'utf8';
    private $dbname = 'jingxi2';
    protected $link = null;
    private static $instance = null;

    //构造方法
    private function __construct($params = array()) {
        //初始化属性
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }

        $this->connect();
        $this->charset();
        $this->selectDb();
    }

    /**
     * 获取实例。
     * @return db
     */
    public static function getInstance($params = array()) {
        if (!self::$instance) {
            self::$instance = new self($params);
        }
        return self::$instance;
    }

    private function __clone() {
        
    }

    private function connect() {
        $host = $this->host . ':' . $this->port;
        //连接数据库
        $this->link = mysql_connect($host, $this->user, $this->pwd);
    }

    private function charset() {
        //设置字符集
        mysql_set_charset($this->charset, $this->link);
    }

    private function selectDb() {
        //选择数据库
        mysql_select_db($this->dbname, $this->link);
    }

    //执行sql语句
    public function query($sql) {
        return mysql_query($sql, $this->link);
    }

    public function __destruct() {
        
    }

    /**
     * 获取完整结果技术组，返回二维数组。
     * @param string $sql
     * @return array
     */
    public function fetchAll($sql) {

        $rst = $this->query($sql);
        $list = array();
        if ($rst) {
            while ($row = mysql_fetch_assoc($rst)) {
                $list[] = $row;
            }
        }
        return $list;
    }

    /**
     * 获取第一行记录。返回一维数组
     * @param string $sql
     * @return array
     */
    public function fetchRow($sql) {
        $rst = $this->fetchAll($sql);
        if ($rst) {
            return $rst[0];
        } else {
            return array();
        }
    }

    /**
     * 获取第一行的第一个字段。
     * @param string $sql
     * @return string|null
     */
    public function fetchColumn($sql) {
        $rst = $this->fetchRow($sql);
        if ($rst) {
            return array_shift($rst);
        } else {
            return null;
        }
    }

}

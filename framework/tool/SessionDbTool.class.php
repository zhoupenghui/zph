<?php

class SessionDbTool {

    private static $instance = null;
    public static $db;

    private function __construct() {
        if (session_id()) {
            die('session已经开启，无法使用自定义机制！');
        } else {
            session_set_save_handler(array(__CLASS__, 'sess_open'), array(__CLASS__, 'sess_close'), array(__CLASS__, 'sess_read'), array(__CLASS__, 'sess_write'), array(__CLASS__, 'sess_destroy'), array(__CLASS__, 'sess_gc'));
//            session_set_cookie_params(1440);
            session_start();
        }
    }
    
    //由于session无需启动多次，所以使用单例模式
    public static function getInstance(){
        if(!self::$instance instanceof self){
            self::$instance = new self(); 
        }
        return self::$instance;
    }

    private function __clone() {
    }
    
    //打开session会话时自动触发
    public static function sess_open() {
        $params = $GLOBALS['config']['database'];
        self::$db = db::getInstance($params);
    }

    //当session执行完毕，会自动触发，常见的就是脚本执行结束
    public static function sess_close() {
    }

    //从session存储的位置读取session数据，返回的需要是字符串
    public static function sess_read($sess_id) {
        $sql = 'SELECT sess_data FROM jx_session WHERE sess_id="' . $sess_id . '"';
        return (string) self::$db->fetchColumn($sql);
    }

    //将$_SESSION数组序列化后的结果保存，$sess_data本身就已经被序列化了
    public static function sess_write($sess_id, $sess_data) {
        $sql = "insert into jx_session (sess_id,sess_data,expire )  values ('$sess_id','$sess_data'," . time() . ") on duplicate key update sess_data='$sess_data',expire=" . time();
        self::$db->query($sql);
    }

    //当使用session_destroy函数时，会自动执行
    public static function sess_destroy($sess_id) {
        $sql = "DELETE FROM jx_session where sess_id='$sess_id'";
        self::$db->query($sql);
    }

    //自动回收机制。
    public static function sess_gc($lifetime) {
        $sql = "delete from jx_session where expire+$lifetime<" . time();
        self::$db->query($sql);
    }

}

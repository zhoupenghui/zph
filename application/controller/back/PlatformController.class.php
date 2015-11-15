<?php

class PlatformController extends Controller {

    //构造方法，当子类被实例化时，此方法应当被触发
    public function __construct() {
        $this->checkLogin();
    }

    //检查用户是否已经登录
    private function checkLogin() {
        //判断用户是否登录，如果登录了，什么都不干，如果没有登录，跳转到登录页面
        $ignore = array(
            'action' => array('login', 'signin'),
            'controller' => array('captcha'),
        );

        //判断是否是过滤掉的操作，如果是，不检测是否登录
        if (!in_array(ACTION_NAME, $ignore['action']) && !in_array(CONTROLLER_NAME, $ignore['controller'])) {
            //过滤掉某些操作，不使用此验证
            SessionDbTool::getInstance();
            //如果已经登录过，就直接跳转到首页
            if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] != 'yes') {
                if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
                    $model = new AdminModel;
                    if ($model->checkBySafePassword($_COOKIE['username'], $_COOKIE['password'])) {
                        $_SESSION['is_login'] = 'yes';
                    }
                } else {
                    $url = 'index.php?p=back&c=admin&a=login';
                    $this->jump($url, '请先登录');
                }
            }
        }
    }

}

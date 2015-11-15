<?php

/**
 * 管理员登录控制器
 */
class AdminController extends PlatformController {

    /**
     * 展示登录表单
     */
    public function loginAction() {
        SessionDbTool::getInstance();
        //如果是有session标志直接跳转，如果有cookie标志验证跳转，否则渲染页面
        //如果已经登录过，就直接跳转到首页
        if (isset($_SESSION['is_login']) && $_SESSION['is_login'] == 'yes') {
            $url = 'index.php?p=back&c=index&a=index';
            $this->jump($url);
        } elseif (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            $model = new AdminModel;
            if ($model->checkBySafePassword($_COOKIE['username'], $_COOKIE['password'])) {
                $_SESSION['is_login'] = 'yes';
                $url = 'index.php?p=back&c=index&a=index';
                $this->jump($url);
            }
        }
        require CURRENT_VIEW_PATH . 'admin_login.html';
    }

    /**
     * 验证用户输入的数据是否合法
     * 如果合法，跳转到back/index/index页面
     * 不合法，跳转到back/admin/login页面
     */
    public function signinAction() {
        //1.获取用户提交的数据
        $adminName = empty($_POST['username']) ? '' : $_POST['username'];
        $adminPass = empty($_POST['password']) ? '' : $_POST['password'];
        $validateCode = empty($_POST['captcha']) ? '' : $_POST['captcha'];
        if ($adminName && $adminPass && $validateCode) {
            //判断是否有验证码
            SessionDbTool::getInstance();
            $captchaTool = new CaptchaTool;
            if ($captchaTool->validate($validateCode)) {

                //2.创建模型
                $model = new AdminModel;
                //  2.2验证数据是否合法
                $rst = $model->check($adminName, $adminPass);
                //3.根据验证结果决定跳转地址
                if ($rst) {
                    //如果验证通过并勾选了自动登录，就将用户信息保存到cookie中
                    if (isset($_POST['remember'])) {
                        setcookie('username', $adminName, time() + 3600 * 7 * 24);
                        setcookie('password', AdminModel::mcriptPassword($adminPass), time() + 3600 * 7 * 24);
                    }
                    SessionDbTool::getInstance();
                    setcookie(session_name(), session_id(), time() + 3600); //设置cookie的有效期是session的有效期
                    $_SESSION['is_login'] = 'yes';
                    $url = 'index.php?p=back&c=index&a=index';
                    $this->jump($url, '登录成功');
                } else {
                    setcookie('username', false);
                    setcookie('password', false);
                }
            } else {
                $url = 'index.php?p=back&c=admin&a=login';
                $this->jump($url, '验证码不正确');
            }
        }
        $url = 'index.php?p=back&c=admin&a=login';
        $this->jump($url, '登录失败');
    }

    //退出登录时，清除session
    public function exitAction() {
        SessionDbTool::getInstance();
        session_destroy();
        SessionDbTool::sess_destroy(session_id());
        require CURRENT_VIEW_PATH . 'admin_login.html';
    }

}

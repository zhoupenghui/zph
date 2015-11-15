<?php

class UserController extends Controller {

    /**
     * 展示登录表单
     */
    public function loginAction() {
        SessionDbTool::getInstance();
        //如果是有session标志直接跳转，如果有cookie标志验证跳转，否则渲染页面
        //如果已经登录过，就直接跳转到首页
        if (isset($_SESSION['is_login']) && $_SESSION['is_login'] == 'yes') {
            $url = 'index.php?p=front&c=index&a=index';
            $this->jump($url);
        } elseif (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            $model = new UserModel;
            if ($model->checkBySafePassword($_COOKIE['username'], $_COOKIE['password'])) {
                $_SESSION['is_login'] = 'yes';
                $url = 'index.php?p=front&c=index&a=index2';
                $this->jump($url, '登录成功');
            }
        }
        require CURRENT_VIEW_PATH . 'login.html';
    }

    /**
     * 验证用户输入的数据是否合法
     * 如果合法，跳转到back/index/index页面
     * 不合法，跳转到back/admin/login页面
     */
    public function signinAction() {
        //1.获取用户提交的数据
        $userName = empty($_POST['username']) ? '' : $_POST['username'];
        $userPass = empty($_POST['password']) ? '' : $_POST['password'];
        $validateCode = empty($_POST['captcha']) ? '' : $_POST['captcha'];
        if ($userName && $userPass && $validateCode) {
            //判断是否有验证码
            SessionDbTool::getInstance();
            $captchaTool = new CaptchaTool;
            if ($captchaTool->validate($validateCode)) {
                //2.创建模型
                $model = new UserModel;
                //  2.2验证数据是否合法
                $rst = $model->check($userName, $userPass);
                //3.根据验证结果决定跳转地址
                if ($rst) {
                    //如果验证通过并勾选了自动登录，就将用户信息保存到cookie中
                    if (isset($_POST['remember'])) {
                        setcookie('username', $userName, time() + 3600 * 7 * 24);
                        setcookie('password', UserModel::mcriptPassword($userPass), time() + 3600 * 7 * 24);
                    }
                    SessionDbTool::getInstance();
                    setcookie(session_name(), session_id(), time() + 3600); //设置cookie的有效期是session的有效期
                    $_SESSION['is_login'] = 'yes';
                    // 将用户名保存到session中
                    $_SESSION['name'] = $userName;

                    $url = 'index.php?p=front&c=index&a=index2';
                    $this->jump($url, '登录成功');
                } else {
                    setcookie('username', false);
                    setcookie('password', false);
                }
            } else {
                $url = 'index.php?p=front&c=user&a=login';
                $this->jump($url, '验证码不正确，请重新登录');
            }
        }
        $url = 'index.php?p=front&c=user&a=login';
        $this->jump($url, '登录失败，请重新登录');
    }

}

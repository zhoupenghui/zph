<?php

class RegisterController extends Controller {

    public function loginAction() {

        require CURRENT_VIEW_PATH . 'register.html';
    }

    public function insertAction() {
        $user_name = isset($_POST['username']) ? $_POST['username'] : '';
        $user_pwd = isset($_POST['password1']) ? $_POST['password1'] : '';
        $user_pwd2 = isset($_POST['password2']) ? $_POST['password2'] : '';
        $validateCode = isset($_POST['checkcode']) ? $_POST['checkcode'] : '';
        if ($user_name && $user_pwd) {
            if ($user_pwd == $user_pwd2) {
                //判断是否有验证码 
                SessionDbTool::getInstance();
                $captchaTool = new CaptchaTool();
                $var = $captchaTool->validate($validateCode);
                if ($var) {
                    $model = new RegisterModel();
                    $res = $model->registerInsert($user_name, $user_pwd);
                    if ($res) {
                        $url = "index.php?p=front&a=signin&c=User";
                        $this->jump($url, '注册成功');
                    } else {
                        $url = "index.php?p=front&a=signin&c=User";
                        $this->jump($url, '注册失败');
                    }
                } else {
                    $url = "index.php?p=front&a=login&c=Register";
                    $this->jump($url, '验证码不合法');
                }
            } else {
                $url = "index.php?p=front&a=login&c=Register";
                $this->jump($url, '两次输入密码不同');
            }
        }

        $url = "index.php?p=front&a=login&c=Register";
        $this->jump($url, '数据不完整');
    }

}

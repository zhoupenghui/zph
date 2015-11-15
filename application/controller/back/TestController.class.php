<?php

class TestController extends Controller {

    public function loginAction() {
        $url = 'http://xianrentiao.cn';
        $tips = '操作完成';
        $times = 3;
        require CURRENT_VIEW_PATH . 'test_login.html';
    }

    public function captchaAction() {
        $captcha = new CaptchaTool;
        $captcha->generate();
    }

    public function sessionAction() {
        SessionDbTool::getInstance();
        var_dump($_SESSION);
    }

    public function callbackAction() {
        require CURRENT_VIEW_PATH . 'callback.html';
    }

    public function brandaddAction() {
        require CURRENT_VIEW_PATH . 'brandadd.html';
    }

}

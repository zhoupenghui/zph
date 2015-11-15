<?php

//由于验证码经常会使用，所以这里封装一个单独的控制器
class CaptchaController extends PlatformController {

    public function captchaAction() {
        SessionDbTool::getInstance();
        $captcha = new CaptchaTool;
        $captcha->generate();
    }

}

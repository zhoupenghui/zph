<?php

class CaptchaTool {

    //生成验证码
    public function generate() {
        //1.创建画布
        $bgImage = __DIR__ . '/captcha/captcha_bg' . mt_rand(1, 5) . '.jpg';
        $image = imagecreatefromjpeg($bgImage);

        //3.将码值保存，以便提交时验证
        if(!session_id()){
            session_start();
        }
        $code = $this->createCode();
        
        $_SESSION['code'] = $code;
        //4.在画布上书写码值
        //4.1用什么颜色
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $color = mt_rand(1, 2) == 1 ? $white : $black;
        //4.2在什么位置
        imagestring($image, 5, 58, 2, $code, $color);

        //5.画一个矩形边框
        imagerectangle($image, 0, 0, 144, 19, $white);

        //6.绘制干扰因子
        //6.1绘制干扰点：其实就是随机像素点
        for ($i = 0; $i < 100; ++$i) {
            $x = mt_rand(1, 143);
            $y = mt_rand(1, 18);
            imagesetpixel($image, $x, $y, $color);
        }
        //6.2绘制干扰线
        $x1 = mt_rand(1, 143);
        $y1 = mt_rand(1, 18);
        $x2 = mt_rand(1, 143);
        $y2 = mt_rand(1, 18);
        imageline($image, $x1, $y1, $x2, $y2, $color);

        header('Content-Type: image/jpeg');
        imagejpeg($image);
       
    }

    //生成随机验证码码值
    public function createCode() {
        //2.计算码值
        $charList = array_merge(range(0, 9), range('A', 'Z'));
        shuffle($charList);
        $code = implode('', array_slice($charList, 0, 4));
        return $code;
    }
   

    //验证码值是否匹配
    public function validate($code) {
        
//        var_dump($code);
           
        if(!session_id()){
            session_start();
        }
//        var_dump($_SESSION['code']);
        if(isset($_SESSION['code'])){
//            var_dump($_SESSION['code']);
//            exit;
            $flag = strcasecmp($_SESSION['code'],$code)==0;
            unset($_SESSION['code']);
        } else { 
            $flag = FALSE;
        }
        return $flag;
//        return isset($_SESSION['code']) && $code == $_SESSION['code'] ? true : false;
    }

}

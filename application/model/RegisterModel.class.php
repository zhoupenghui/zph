<?php

class RegisterModel extends Model {

    protected function tableName() {
        return 'user_admin';
    }

    public function registerInsert($user_name, $user_pwd) {
        $user_pwd = self::mcriptPassword($user_pwd);
        $data = array(
            'user_name' => $user_name,
            'user_pwd' => $user_pwd,
            'pwd_salt' => $str
        );
        return $this->insertData($data);
    }

    public static function mcriptPassword($user_pwd) {
        $str = md5('abc');
        return md5($user_pwd . $str);
    }

}

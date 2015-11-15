<?php

class UserModel extends Model {

    //本模型对应的数据表逻辑表名
    protected function tableName() {
        return 'user_admin';
    }

    /**
     * 验证用户名和密码是否匹配。
     * @param string $userName
     * @param string $userPass
     * @return boolean
     */
    public function check($userName, $userPass) {
        $userPass = self::mcriptPassword($userPass);
        //由于只需要判断是否存在符合条件的记录即可，所以不需要查询很多数据，使用1或者任意数字，减少数据传输
        $sql = "SELECT 1 FROM " . $this->table() . " WHERE `user_name`='$userName' AND `user_pwd`='$userPass'";
        $rst = $this->db->fetchRow($sql);
        return $rst != false;
    }

    /**
     * 对密码进行加密。
     * @param string $userPass
     * @return string
     */
    public static function mcriptPassword($userPass) {
        return md5($userPass . md5('abc'));
    }

    /**
     * 验证加密后的密码和用户名是否匹配，用于自动登录。
     * @param string $userName
     * @param string $userPass
     * @return boolean
     */
    public function checkBySafePassword($userName, $userPass) {
        //由于只需要判断是否存在符合条件的记录即可，所以不需要查询很多数据，使用1或者任意数字，减少数据传输
        $sql = "SELECT 1 FROM " . $this->table() . " WHERE `user_name`='$userName' AND `user_pwd`='$userPass'";
        $rst = $this->db->fetchRow($sql);
        return $rst != false;
    }

}

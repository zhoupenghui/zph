<?php

class AdminModel extends Model {

    //本模型对应的数据表逻辑表名
    protected function tableName() {
        return 'adminer_admin';
    }

    /**
     * 验证用户名和密码是否匹配。
     * @param string $adminName
     * @param string $adminPass
     * @return boolean
     */
    public function check($adminName, $adminPass) {
        $adminPass = self::mcriptPassword($adminPass);
        //由于只需要判断是否存在符合条件的记录即可，所以不需要查询很多数据，使用1或者任意数字，减少数据传输
        $sql = "SELECT 1 FROM " . $this->table() . " WHERE `admin_name`='$adminName' AND `admin_pwd`='$adminPass'";
        $rst = $this->db->fetchRow($sql);
        return $rst != false;
    }

    /**
     * 对密码进行加密。
     * @param string $adminPass
     * @return string
     */
    public static function mcriptPassword($adminPass) {
        return md5($adminPass);
    }

    /**
     * 验证加密后的密码和用户名是否匹配，用于自动登录。
     * @param string $adminName
     * @param string $adminPass
     * @return boolean
     */
    public function checkBySafePassword($adminName, $adminPass) {
        //由于只需要判断是否存在符合条件的记录即可，所以不需要查询很多数据，使用1或者任意数字，减少数据传输
        $sql = "SELECT 1 FROM " . $this->table() . " WHERE `admin_name`='$adminName' AND `admin_pwd`='$adminPass'";
        $rst = $this->db->fetchRow($sql);
        return $rst != false;
    }

}

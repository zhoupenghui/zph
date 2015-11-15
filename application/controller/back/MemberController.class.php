<?php

/**
 * 会员模块控制器
 * 作者：周杰
 */
class MemberController extends PlatformController {

    /**
     * 会员列表展示
     */
    public function listAction() {
        //从数据库里获取会员信息
        //如果数据比较多，那么就要分页显示
        //可以在这里获取分页的一些数据，如：当前页码数，页大小
        //获取当前页码数
        $page = isset($_GET['page']) ? $_GET['page'] - 0 : 1;
        //判断当前页面是否合法
        $page = max($page, 1);
        //获取页大小
        $size = isset($_GET['size']) ? $_GET['size'] : 5;
        //判断页大小是否合法
        $size = max($size, 1);
        //实例化一个对象，通过$page，$size，调用方法获取分页显示的数据
        $model = new MemberModel();
        //调用方法getByPage($page, $size，$where=''),获取分页后的数据组
        $res = $model->getByPage($page, $size);
        if ($_POST) {
            //获取搜索条件

            $keyword = empty($_POST['keyword']) ? null : $_POST['keyword'];
            //构建一个数组，存放各个查询条件
            $construct = array();
            //判断各个查找条件是否为空
            if ($keyword) {
                $construct[] = ' user_name  = "' . $keyword . '"';
            }
            //拼接数组--把数组内的数以  and   符号拼接成字符串
            $connect = implode(" and ", $construct);

            //实例化对象,调用方法，查看是否有条件
            $model = new MemberModel();
            $res = $model->getByPage($page, $size, $connect);
        }

        //实例化一个对象，用于获取分页方法
        $PageTool = new PageTool();
        //调用方法，获取分页
        $pageHtml = $PageTool->page($page, $size, $res['total'], 'index.php?p=back&c=Member&a=list');
        //遍历数组$res,获取$res['data']的值
        //定义一个空数组，用来存放$res['data']结果
        $list = array();
        foreach ($res['data'] as $key => $value) {
            $list[] = $value;
        }
        //判断会员等级
        //引用会员视图，获取数据显示
        require CURRENT_VIEW_PATH . 'users.html';
    }

    /**
     * 添加会员页码
     */
    public function addAction() {
        require CURRENT_VIEW_PATH . 'add.html';
    }

    /**
     * 获取添加会员的表单列信息
     */
    public function insertAction() {
        $user_name = isset($_POST['username']) ? $_POST['username'] : ''; //会员（用户）名
        $email = isset($_POST['email']) ? $_POST['email'] : ''; //邮件地址
        $user_pwd = isset($_POST['password']) ? $_POST['password'] : ''; //登录密码:
        $user_pwd2 = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : ''; //确认密码:
        $menber_level = isset($_POST['user_rank']) ? $_POST['user_rank'] - 0 : 0; //会员等级:
        $sex = isset($_POST['sex']) ? $_POST['sex'] : ''; //性别:
        $Year = isset($_POST['birthdayYear']) ? $_POST['birthdayYear'] : ''; //出生日期:年
        $Month = isset($_POST['birthdayMonth']) ? $_POST['birthdayMonth'] : ''; //出生日期:月
        $Year = isset($_POST['birthdayDay']) ? $_POST['birthdayDay'] : ''; //出生日期:日
        $MSN = isset($_POST['extend_field1']) ? $_POST['extend_field1'] : ''; //MSN
        $QQ = isset($_POST['extend_field2']) ? $_POST['extend_field2'] : ''; //QQ
        $office_phone = isset($_POST['extend_field3']) ? $_POST['extend_field3'] : ''; //办公电话:
        $home_phone = isset($_POST['extend_field4']) ? $_POST['extend_field4'] : ''; //家庭电话:
        $telephone = isset($_POST['extend_field5']) ? $_POST['extend_field5'] : ''; //手机:
        //因为要添加到数据库，所以用数组储存以上变量，以便调用方法，储存到数据库中
        $data_user = array(
            'user_name' => $user_name,
            'user_pwd' => $user_pwd,
        );
        $data = array(
            'user_name' => $user_name,
            'email' => $email,
            'menber_level' => $menber_level,
            'sex' => $sex,
            'birth' => $Year . '-' . $Month . '-' . $Year,
            'MSN' => $MSN,
            'QQ' => $QQ,
            'office_phone' => $office_phone,
            'home_phone' => $home_phone,
            'telephone' => $telephone,
            'Registration_Date' => time(),
        );
        //判断密码是否相同
        if (isset($user_pwd) && $user_pwd) {
            if ($user_pwd == $user_pwd2) {
                //如果两次密码输入相同，则添加到数据库
                //实例化对象，添加到数据库
                $model = new MemberModel();
                //添加到数据库
                $res2 = $model->insertData($data);
                if ($res2) {
                    $url = 'index.php?p=back&c=Member&a=list';
                    $this->jump($url, '添加成功！');
                } else {
                    $url = 'index.php?p=back&c=Member&a=list';
                    $this->jump($url, '添加失败！');
                }
            } else {
                echo "<script type='text/javascript'>alert('两次密码输入不同，请重新输入');location.href='index.php?p=back&c=Member&a=add';</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('密码不能为空');location.href='index.php?p=back&c=Member&a=add';</script>";
        }
    }

    /**
     * 编辑对应的记录
     */
    public function editAction() {
        //获取要编辑的id
        $userinfo_id = isset($_GET['userinfo_id']) ? $_GET['userinfo_id'] : null;
        //根据编号获取到指定的数据
        $model = new MemberModel();
        $list = $model->getByPk($userinfo_id);
        //把出生日期分割开来
        $births = explode('-', $list['birth']);
        require CURRENT_VIEW_PATH . 'edit.html';
    }

    /**
     * 获取编辑会员信息的表单信息
     */
    public function updateAction() {
        $user_name = isset($_POST['username']) ? $_POST['username'] : ''; //会员（用户）名
        $email = isset($_POST['email']) ? $_POST['email'] : ''; //邮件地址
        $user_pwd = isset($_POST['password']) ? $_POST['password'] : ''; //登录密码:
        $user_pwd2 = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : ''; //确认密码:
        $menber_level = isset($_POST['user_rank']) ? $_POST['user_rank'] - 0 : 0; //会员等级:
        $sex = isset($_POST['sex']) ? $_POST['sex'] : ''; //性别:
        $Year = isset($_POST['birthdayYear']) ? $_POST['birthdayYear'] : ''; //出生日期:年
        $Month = isset($_POST['birthdayMonth']) ? $_POST['birthdayMonth'] : ''; //出生日期:月
        $Year = isset($_POST['birthdayDay']) ? $_POST['birthdayDay'] : ''; //出生日期:日
        $MSN = isset($_POST['extend_field1']) ? $_POST['extend_field1'] : ''; //MSN
        $QQ = isset($_POST['extend_field2']) ? $_POST['extend_field2'] : ''; //QQ
        $office_phone = isset($_POST['extend_field3']) ? $_POST['extend_field3'] : ''; //办公电话:
        $home_phone = isset($_POST['extend_field4']) ? $_POST['extend_field4'] : ''; //家庭电话:
        $telephone = isset($_POST['extend_field5']) ? $_POST['extend_field5'] : ''; //手机:
        $userinfo_id = isset($_POST['userinfo_id']) ? $_POST['userinfo_id'] : '';
        $data_user = array(
            'user_name' => $user_name,
            'user_pwd' => $user_pwd,
        );
        $data = array(
            'user_name' => $user_name,
            'email' => $email,
            'menber_level' => $menber_level,
            'sex' => $sex,
            'birth' => $Year . '-' . $Month . '-' . $Year,
            'MSN' => $MSN,
            'QQ' => $QQ,
            'office_phone' => $office_phone,
            'home_phone' => $home_phone,
            'telephone' => $telephone,
            'Registration_Date' => time(),
        );
        //判断密码是否相同
        if (isset($user_pwd) && $user_pwd) {
            if ($user_pwd == $user_pwd2) {
                //如果两次密码输入相同，则添加到数据库
                //实例化对象，添加到数据库
                $model = new MemberModel();
                //添加到数据库
                //拼接条件语句
                $userinfo_id = " userinfo_id = " . "'" . $userinfo_id . "'";
                $res2 = $model->updateData($data, $userinfo_id);
                if ($res2) {
                    $url = 'index.php?p=back&c=Member&a=list';
                    $this->jump($url, '修改成功！');
                } else {
                    $url = 'index.php?p=back&c=Member&a=edit';
                    $this->jump($url, '修改失败！');
                }
            } else {
                echo "<script type='text/javascript'>alert('两次密码输入不同，请重新输入');location.href='index.php?p=back&c=Member&a=edit';</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('密码不能为空');location.href='index.php?p=back&c=Member&a=edit';</script>";
        }
    }

    /**
     * 删除指定记录
     */
    public function deleteAction() {
        //获取字段记录的id号
        $userinfo_id = isset($_GET['userinfo_id']) ? $_GET['userinfo_id'] : '';
        //实例化对象，调用model类方法，删除一条记录
        $model = new MemberModel();
        $res = $model->deleteByPk($userinfo_id);
        //判断结果集，是否已经删除
        if ($res) {
            $url = 'index.php?p=back&c=Member&a=list';
            $this->jump($url, '删除成功！');
        } else {
            $url = 'index.php?p=back&c=Member&a=list';
            $this->jump($url, '删除成功！');
        }
    }

}

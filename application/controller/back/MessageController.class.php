<?php

/**
 * 会员留言控制器类
 * 作者：周杰
 */
class MessageController extends PlatformController {

    //显示所有会员留言
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
        $model = new MessageModel();
        //调用方法getByPage($page, $size，$where=''),获取分页后的数据组
        $res = $model->getByPage($page, $size);
        //判断是否有搜索条件
        if ($_POST) {
            //获取搜索条件
            $msg_type = isset($_POST['msg_type']) ? $_POST['msg_type'] : 0;
            $keyword = empty($_POST['keyword']) ? '' : $_POST['keyword'];
            //构建一个数组，存放各个查询条件
            $construct = array();
            //判断各个查找条件是否为空
            if ($keyword) {
                $construct[] = ' user_name  = "' . $keyword . '"';
            }
            if ($msg_type == 0) {
                $construct[] = ' msg_type  = "' . "留言" . '"';
            }
            if ($msg_type == 1) {
                $construct[] = ' msg_type  = "' . "投诉" . '"';
            }
            if ($msg_type == 2) {
                $construct[] = ' msg_type  = "' . "询问" . '"';
            }
            if ($msg_type == 3) {
                $construct[] = ' msg_type  = "' . "售后" . '"';
            }
            if ($msg_type == 4) {
                $construct[] = ' msg_type  = "' . "求购" . '"';
            }
            if ($msg_type == 5) {
                $construct[] = ' msg_type  = "' . "商家留言" . '"';
            }
            //拼接数组--把数组内的数以  and   符号拼接成字符串
            $connect = implode(" and ", $construct);
            //实例化对象,调用方法，查看是否有条件
            $model = new MessageModel();
            $res = $model->getByPage($page, $size, $connect);
        }
        //实例化一个对象，用于获取分页方法
        $PageTool = new PageTool();
        //调用方法，获取分页
        $pageHtml = $PageTool->page($page, $size, $res['total'], 'index.php?p=back&c=Message&a=list');
        //遍历数组$res,获取$res['data']的值
        //定义一个空数组，用来存放$res['data']结果
        $list = array();
        foreach ($res['data'] as $key => $value) {
            $list[] = $value;
        }
        //引用会员留言视图
        require CURRENT_VIEW_PATH . 'message.html';
    }

    //显示留言详情
    public function detailsAction() {
        //获取留言id
        $msg_id = isset($_GET['msg_id']) ? $_GET['msg_id'] : '';
        //设定要查询的键名
        $key = 'msg_id';
        //通过id号获取留言数据
        $model = new MessageModel();
        $res = $model->query($key, $msg_id);
        //定义一个空数组，用来接收返回结果集
        $list = array();
        foreach ($res as $value) {
            $list = $value;
        }
        require CURRENT_VIEW_PATH . 'details.html';
    }

    //管理员回复会员
    public function replyAction() {
        //获取回复内容及会员的id
        $msg_reply = isset($_POST['msg_content']) ? $_POST['msg_content'] : '';
        $msg_id = isset($_POST['msg_id']) ? $_POST['msg_id'] : '';
        //判断回复内容是否为空
        if ($msg_reply) {
            //拼接where条件
            $where = " msg_id =" . $msg_id;
            //构建数组
            $data = array(
                'msg_reply' => $msg_reply
            );
            //实例化对象，把回复的内容添加到相应的记录中
            $model = new MessageModel();
            //调用方法，更新回复内容,并接收结果集
            $res = $model->updateData($data, $where);
            //判断结果集是否为真
            if ($res) {
                echo "<script>alert('回复成功');location.href='index.php?p=back&c=Message&a=list';</script>";
            }
            echo "<script>alert('回复失败');location.href='index.php?p=back&c=Message&a=details&msg_id=$msg_id';</script>";
        }
        echo "<script>alert('回复内容不能为空');location.href='index.php?p=back&c=Message&a=details&msg_id=$msg_id';</script>";
    }

    //删除记录
    public function deleteAction() {
        //获取要删除数据的id号
        $msg_id = isset($_GET['msg_id']) ? $_GET['msg_id'] : '';
        //实例化对象，调用方法，执行删除
        $model = new MessageModel();
        $res = $model->deleteByPk($msg_id);
        //根据结果集，判断是否已经删除
        if ($res) {
            echo "<script>alert('删除成功');location.href='index.php?p=back&c=Message&a=list';</script>";
        }
        echo "<script>alert('删除失败');location.href='index.php?p=back&c=Message&a=list';</script>";
    }

}

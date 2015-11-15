<?php

class OrderlistController extends PlatformController {

    // 展示订单列表及其分页
    public function listAction() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page = max($page, 1);
        $size = isset($_GET['size']) ? $_GET['size'] : 2;
        $size = max($size, 1);
        $model = new OrderlistModel();
        $rst = $model->getByPage($page, $size);
        if ($_POST) {
            $order_sn = empty($_POST['order_sn']) ? '' : $_POST['order_sn'];
            $consignee = empty($_POST['consignee']) ? '' : $_POST['consignee'];
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            //构建一个数组，放在查看的条件
            $construct = array();
            //判断条件是否存在
            if ($order_sn) {
                $construct[] = ' order_num = "' . $order_sn . '"';
            }
            if ($consignee) {
                $construct[] = ' consignee = "' . $consignee . '"';
            }
            //构建一个数组，存放下拉列表的各个值
            $select = array('0' => '待确认', '100' => '待付款', '101' => '待发货', '102' => '已完成', '1' => '付款中', '2' => '取消', '3' => '无效', '4' => '退货', '5' => '部分发货');
            //获取数组的键名
            $select_key = array_keys($select);
            //判断下拉列表value在不在键名中
            if (in_array($status, $select_key)) {
                $construct[] = ' order_status= "' . $select[$status] . '"';
            }
            //拼接条件
            $connect = implode(" and ", $construct);
            //实例化对象，调用方法，查看是否有条件
            $modle = new OrderlistModel();
            //调用方法，返回结果集
            $rst = $model->getByPage($page, $size, $connect);
        }
        $pageTool = new pageTool();
        $pageHtml = $pageTool->page($page, $size, $rst['total'], 'index.php?p=back&c=Orderlist&a=list');
        require CURRENT_VIEW_PATH . 'order_list.html';
    }

    // 渲染订单查询页面
    public function queryAction() {
        require CURRENT_VIEW_PATH . 'query.html';
    }

    // 查询具体某一条订单
    public function querytoAction() {
        $order_sn = $_POST['order_sn'];
        $model = new OrderlistModel();
        $list = $model->gettolist($order_sn);
        if (!$list) {
            $url = 'index.php?p=back&c=Orderlist&a=query';
            $this->jump($url, '您所查询的订单不存在');
        } else {
            require CURRENT_VIEW_PATH . 'query_to.html';
        }
    }

    // 订单添加第一步,进入添加第一个页面
    public function addoneAction() {
        require CURRENT_VIEW_PATH . 'add_orderone.html';
    }

    // 订单添加第二步，判断是否有会员，如果有，才能进入添加订单的第二个页面
    public function addtwoAction() {
        if (empty($_POST['anonymous'])) {
            require CURRENT_VIEW_PATH . 'add_orderone.html';
        } else {
            $anonymous = $_POST['anonymous'];
            $model = new OrderlistModel();
            $rst = $model->getWhere($anonymous);
            if ($rst) {
                $consignee = $this->consignee = $rst[0]['consignee'];  // 把收货人的名字交给一个静态变量
                $keyword = '';
                $rst = array();
                require CURRENT_VIEW_PATH . 'add_ordertwo.html';
            } else {
                $url = 'index.php?p=back&c=Orderlist&a=addone';
                $this->jump($url, '会员不存在');
            }
        }
    }

    // 展示发货单列表及其分页
    public function shiporderAction() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page = max($page, 1);
        $size = isset($_GET['size']) ? $_GET['size'] : 2;
        $size = max($size, 1);
        $model = new ShiporderModel();
        $rst = $model->getByPage($page, $size);
        $pageTool = new pageTool();
        $pageHtml = $pageTool->page($page, $size, $rst['total'], 'index.php?p=back&c=Orderlist&a=shiporder');
        require CURRENT_VIEW_PATH . 'ship_order.html';
    }

    // 删除一条发货单
    public function delAction() {
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 1;
        $model = new ShiporderModel();
        $rst = $model->deleteByPk($order_id);
        if ($rst) {
            $url = 'index.php?p=back&c=Orderlist&a=shiporder';
            $this->jump($url, '删除成功');
        }
    }

    // 订单添加第三步，搜索商品,让其回显在商品列表
    public function searchAction() {
        if (!isset($_POST['keyword'])) {
            $_POST['keyword'] = "";
        } else {
            $consignee = $_POST['consignee'];
            $keyword = $_POST['keyword'];
            $model = new SearchModel();
            $rst = $model->SearchAction($keyword);
            require CURRENT_VIEW_PATH . 'add_ordertwo.html';
        }
    }

    // 搜索商品以后，添加订单 到 订单列表
    public function addthreeAction() {
        $consignee = $_POST['consignee'];
        $arr = array('consignee' => $consignee);
        $model = new OrderlistModel();
        $rst = $model->insertData($arr); //插入一条订单
        if ($rst) {
            $url = 'index.php?p=back&c=Orderlist&a=list';
            $this->jump($url, '订单添加成功');
        } else {
            $url = 'index.php?p=back&c=Orderlist&a=list';
            $this->jump($url, '订单添加失败');
        }
    }

}

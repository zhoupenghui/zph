<?php

class AccountController extends PlatformController {

    public function calAction() {
        // 开启session机制，从中取出登陆者的用户名
        SessionDbTool::getInstance();
        $consignee = $_SESSION["name"];
        $goods_price = empty($_GET["goods_price"]) ? '' : $_GET["goods_price"]; // 获取加入购物车中商品的价格
        $goods_brand = empty($_GET["goods_brand"]) ? '' : $_GET['goods_brand'];
        $goods_type = empty($_GET["goods_type"]) ? '' : $_GET['goods_type'];
        $color = empty($_GET["color"]) ? '' : $_GET['color'];
        $ver = empty($_GET["ver"]) ? '' : $_GET['ver'];
        $amount = empty($_GET["amount"]) ? '' : $_GET['amount'];
        $goods_name = empty($_GET["goods_name"]) ? '' : $_GET['goods_name'];
        $_SESSION['goods_name'] = $goods_name; // 把商品名称保存到session中
        $_SESSION['goods_price'] = $goods_price; // 把商品价格保存到session中
        $model = new OrderlistModel();
        $list = $model->getWhere($consignee);
        require CURRENT_VIEW_PATH . 'flow2.html';
    }

    // 修改收货人的地址
    public function saveAction() {
        $consignee = isset($_POST['consignee']) ? $_POST['consignee'] : "";
        $city = isset($_POST['city']) ? $_POST['city'] : "";
        $area = isset($_POST['area']) ? $_POST['area'] : "";
        $road = isset($_POST['road']) ? $_POST['road'] : "";
        $address = isset($_POST['address']) ? $_POST['address'] : "";
        $phone_number = isset($_POST['phone']) ? $_POST['phone'] : "";
        $data = array(
            'consignee' => $consignee,
            'address' => $city . $area . $road . $address,
            'phone_number' => $phone_number,
        );
        $where = "`consignee` = '$consignee'";
        $model = new OrderlistModel();
        $list = $model->updateData($data, $where);
        if ($list) {
            $url = 'index.php?p=front&c=account&a=cal';
            $this->jump($url, '修改地址成功');
        } else {
            $url = 'index.php?p=front&c=account&a=cal';
            $this->jump($url, '修改地址失败');
        }
    }

    //修改送货方式
    public function methodAction() {
        $consignee = isset($_POST['method_con']) ? $_POST['method_con'] : "";
        $delivery = isset($_POST['delivery']) ? $_POST['delivery'] : "";
        $time = isset($_POST['time']) ? $_POST['time'] : "";
        $data = array(
            'shipping_method' => $delivery . "——时间：" . $time,
        );
        $where = "`consignee` = '$consignee'";
        $model = new OrderlistModel();
        $list = $model->updateData($data, $where);
        if ($list) {
            $url = 'index.php?p=front&c=account&a=cal';
            $this->jump($url, '修改送货方式成功');
        } else {
            $url = 'index.php?p=front&c=account&a=cal';
            $this->jump($url, '修改送货方式失败');
        }
    }

    // 修改支付方式
    public function payAction() {
        $consignee = isset($_POST['pay_con']) ? $_POST['pay_con'] : "";
        $payment = isset($_POST['payment']) ? $_POST['payment'] : "";
        $data = array(
            'payment' => $payment,
        );
        $where = "`consignee` = '$consignee'";
        $model = new OrderlistModel();
        $list = $model->updateData($data, $where);
        if ($list) {
            $url = 'index.php?p=front&c=account&a=cal';
            $this->jump($url, '修改支付方式成功');
        } else {
            $url = 'index.php?p=front&c=account&a=cal';
            $this->jump($url, '修改支付方式失败');
        }
    }

    // 渲染提交订单成功的页面
    public function successAction() {
        $consignee = isset($_POST['consignee']) ? $_POST['consignee'] : "";
        $payment = isset($_POST['payment']) ? $_POST['payment'] : "";
        $address = isset($_POST['address']) ? $_POST['address'] : "";
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : "";
        $data = array(
            'consignee' => $consignee,
            'address' => $address,
            'phone_number' => $phone_number,
            'payment' => $payment,
        );
        $where = "`consignee` = '$consignee'";
        $model = new OrderlistModel();
        $list = $model->insertData($data, $where);
        if ($list) {
            $url = 'index.php?p=front&c=account&a=cc';
            $this->jump($url);
        } else {
            $url = 'index.php?p=front&c=account&a=cc';
            $this->jump($url, '添加订单失败');
        }
    }

    //查看订单信息
    public function checkorderAction() {
        // 开启session机制，从中取出登陆者的用户名
        SessionDbTool::getInstance();
        $consignee = $_SESSION["name"];
        if (!$_SESSION['goods_name']) {
            $url = "index.php?p=front&c=index&a=index";
            header('location:' . $url);
        }
        if (!$_SESSION['goods_price']) {
            $url = "index.php?p=front&c=index&a=index";
            header('location:' . $url);
        }
        $goods_name = $_SESSION['goods_name'];
        $goods_price = $_SESSION['goods_price'];
        $model = new OrderlistModel();
        $list = $model->getWhere($consignee);
        require CURRENT_VIEW_PATH . 'order.html';
    }

    public function ccAction() {

        require CURRENT_VIEW_PATH . 'flow3.html';
    }

    public function ttAction() {
        $list = array();
        require CURRENT_VIEW_PATH . 'order.html';
    }

}

<?php

class ShopController extends Controller {

    public function listAction() {
        SessionDbTool::getInstance();
        $goods_id = isset($_POST['goods_id']) ? $_POST['goods_id'] : "";
        $color = isset($_POST['color']) ? $_POST['color'] : "";
        $ver = isset($_POST['ver']) ? $_POST['ver'] : "";
        $amount = isset($_POST['amount']) ? $_POST['amount'] : 1;
        $model = new SearchModel();
        $list = $model->SearchByIdAction($goods_id);
        require CURRENT_VIEW_PATH . 'flow1.html';
    }

}

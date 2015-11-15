<?php

/**
 * 商品控制器（前台）
 */
class GoodsController extends Controller {

    /**
     * 商品详情界面
     */
    public function goodsAction() {
        SessionDbTool::getInstance();
        //获取goods表中的信息
        $goodsId = $_GET['goods_id'];
        $list = new GoodsModel();
        $data = $list->getByPk($goodsId);

        //获取相册表中的图片信息
        $key = 'goods_id';
        $value = $goodsId;
        $album = new AlbumModel();
        $data2 = $album->query($key, $value);
        //计算图片数
        $len = count($data2);
        require CURRENT_VIEW_PATH . 'goods.html';
    }

    /**
     * 商品列表展示界面
     */
    public function listAction() {
        SessionDbTool::getInstance();
        //获取分页
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page = max($page, 1);
        $size = isset($_GET['size']) ? $_GET['size'] : 3;
        $size = max($size, 1);
        $model = new GoodsModel;
        $rst = $model->getByPage($page, $size);
        if ($_POST) {
            $keyword = empty($_POST['keyword']) ? '' : $_POST['keyword'];
            $construct = array();
            if ($keyword) {
                $construct[] = ' goods_name = "' . $keyword . '"';
            }
            $connect = implode(' and ', $construct);
            $model = new GoodsModel();
            $res = $model->getByPage($page, $size, $connect);
        }
        $pageTool = new pageTool();
        $pageHtml = $pageTool->page($page, $size, $rst['total'], 'index.php?p=front&c=goods&a=list');
        $item = array();
        foreach ($rst['data'] as $key => $value) {
            $item[] = $value;
        }
        //执行筛选条件
        $brCon = isset($_GET['brand_name']) ? $_GET['brand_name'] : '';
        $brCondition = new BrandModel();

        //实现品牌列表
        $brList = new BrandModel();
        $brLis = $brList->getAll();
        $brLen = count($brLis);

        //实现商品列表 
        $brCon = isset($_GET['brand_name']) ? $_GET['brand_name'] : '';
        $data = new GoodsModel();
        //根据品牌筛选
        if ($brCon) {
            $key = 'goods_brand';
            $value = $brCon;
            $list = $data->brQuery($key, $value);
        } else {
            $list = $data->getAll();
        }
        $len = count($list);
        require CURRENT_VIEW_PATH . 'list.html';
    }

    public function showAction() {
        //判断是否登录，如果登录了，直接进入商品选择页面，如果没有，跳转到登录页面
        SessionDbTool::getInstance();
        if (!isset($_SESSION['name'])) {
            $url = 'index.php?p=front&c=user&a=login';
            $this->jump($url, '请先登录');
        } else {
            $url = 'index.php?p=front&c=goods&a=go';
            $this->jump($url);
        }
    }

    public function goAction() {
        // 渲染商品选择页面
        require CURRENT_VIEW_PATH . 'list.html';
    }

}

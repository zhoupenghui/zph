<?php

class GoodsbrandController extends PlatformController {

    /**
     * 品牌列表
     */
    public function brandAction() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page = max($page, 1);
        $size = isset($_GET['size']) ? $_GET['size'] : 5;
        $size = max($size, 1);
        $model = new BrandModel();
        $rst = $model->getByPage($page, $size);
        $pageTool = new pageTool();
        $pageHtml = $pageTool->page($page, $size, $rst['total'], 'index.php?p=back&c=goodsbrand&a=brand');
        $list = array();
        foreach ($rst['data'] as $value) {
            $list[] = $value;
        }
        require CURRENT_VIEW_PATH . 'brand.html';
    }

    /**
     * 品牌添加
     */
    public function brandaddAction() {

        require CURRENT_VIEW_PATH . 'brandadd.html';
    }

    public function insertAction() {
        $brandName = isset($_POST['brand_name']) ? $_POST['brand_name'] : '';
        $brandDescribe = isset($_POST['brand_describe']) ? $_POST['brand_describe'] : '';
        if ($brandName) {
            $data = array(
                'brand_name' => $brandName,
                'brand_describe' => $brandDescribe);
            $insert = new BrandModel();
            $insert->insertData($data);
            $url = "index.php?p=back&c=goodsbrand&a=brand";
            $this->jump($url);
        } else {
            $url = "index.php?p=back&c=goodsbrand&a=brandadd";
            $this->jump($url, '品牌名不能为空');
        }
    }

    //实现删除功能
    public function DelAction() {
        $brandId = isset($_GET['brand_id']) ? $_GET['brand_id'] : '';
        $del = new BrandModel();
        $del->deleteByPk($brandId);
        $url = "index.php?p=back&c=goodsbrand&a=brand";
        $this->jump($url);
    }

    public function brandeditAction() {
        $brandId = isset($_GET['brand_id']) ? $_GET['brand_id'] : '';
        $brand = new BrandModel();
        $list = $brand->brandList();
        foreach ($list as $brand) {
            if ($brand['brand_id'] == $brandId) {
                $brandName = $brand['brand_name'];
                $brandDescribe = $brand['brand_describe'];
            }
        }
        require CURRENT_VIEW_PATH . 'brandedit.html';
    }

    public function updateAction() {
        $brandId = isset($_POST['brand_id']) ? $_POST['brand_id'] : '';
        $brandName = isset($_POST['brand_name']) ? $_POST['brand_name'] : '';
        $brandDescribe = isset($_POST['brand_describe']) ? $_POST['brand_describe'] : '';
        $data = array(
            'brand_name' => $brandName,
            'brand_describe' => $brandDescribe,
        );
        if ($brandName) {
            $where = "me`brand_id`=$brandId";
            $update = new BrandModel();
            $update->updateData($data, $where);
            $url = "index.php?p=back&c=goodsbrand&a=brand";
            $this->jump($url);
        } else {
            $url = "index.php?p=back&c=goodsbrand&a=brandedit&brand_id=$brandId";
            $this->jump($url, '品牌名不能为空');
        }
    }

}

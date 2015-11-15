<?php

class GoodsController extends PlatformController {

    /**
     * 渲染新建商品的视图
     */
    public function addAction() {
        $model = new CategoryModel;
        $list = $model->getTreeList();
        //建立品牌选项
        $brand = new BrandModel();
        $goodsbrand = $brand->getAll();
        require CURRENT_VIEW_PATH . 'add.html';
    }

    /**
     * 获取表单数据，并新增商品。
     */
    public function insertAction() {
        $goodsName = isset($_POST['goods_name']) ? $_POST['goods_name'] : '';
        $goodsBrand = isset($_POST['goods_brand']) ? $_POST['goods_brand'] : '';
        $goodsType = isset($_POST['goods_type']) ? $_POST['goods_type'] : '';
        $goodsNum = !empty($_POST['goods_num']) ? $_POST['goods_num'] : 100;
        $goodsPrice = isset($_POST['goods_price']) ? $_POST['goods_price'] : '';
        $goodsWeight = isset($_POST['goods_weight']) ? $_POST['goods_weight'] : 100;
        $goodsNew = isset($_POST['goods_new']) ? $_POST['goods_new'] : 0;
        $goodsRecommend = isset($_POST['goods_recommend']) ? $_POST['goods_recommend'] : 1;
        $goodsHot = isset($_POST['goods_hot']) ? $_POST['goods_hot'] : 0;
        $goodsDelete = isset($_POST['goods_delete']) ? $_POST['goods_delete'] : 0;
        $goodsCondition = isset($_POST['goods_condition']) ? $_POST['goods_condition'] : 0;
        $goodsDescribe = isset($_POST['goods_describe']) ? $_POST['goods_describe'] : '';
        $goodsSale = isset($_POST['goods_sale']) ? $_POST['goods_sale'] : '';
        $goodsSn = isset($_POST['goods_sn']) ? $_POST['goods_sn'] : '';
        $goodsAddr = isset($_FILES['goods_addr']) ? $_FILES['goods_addr'] : array();
        $imgDesc = isset($_POST['img_desc']) ? $_POST['img_desc'] : '';
        $flag = true;
        if (isset($goodsAddr['tmp_name']) && $goodsAddr['tmp_name']) {
            $uploadTool = new UploadTool();
            $goodsImg = $uploadTool->upload($goodsAddr);
            //为了避免同一文件夹文件过多，我们将所有的文件放置到小时对应的文件夹中
            $path = 'upload/' . date('Ymd');
            $uploadTool->setUploadDir($path);

            //可以用变量保存一个错误信息，然后在视图中展示。
            if (!$goodsImg) {
                $flag = false;
            } else {
                $thumb = new ImageTool();
                $thumbFile = $thumb->thumb($goodsImg, $path, 160, 160);
            }
        }
        $flag = $flag && $goodsName && $goodsPrice;
        if ($flag) {
            $data = array(
                'goods_name' => $goodsName,
                'goods_sn' => $goodsSn,
                'goods_price' => $goodsPrice,
                'goods_weight' => $goodsWeight,
                'goods_addr' => isset($thumbFile) ? $thumbFile : '',
                'goods_brand' => isset($goodsBrand) ? $goodsBrand : '',
                'goods_type' => isset($goodsType) ? $goodsType : '',
                'image_thumb' => isset($thumbFile) ? $thumbFile : '',
                'goods_describe' => $goodsDescribe,
                'goods_num' => $goodsNum,
                'goods_new' => $goodsNew,
                'goods_hot' => $goodsHot,
                'goods_status' => $goodsNum | $goodsNew | $goodsHot,
                'goods_recommend' => $goodsRecommend,
                'goods_condition' => $goodsCondition,
                'goodsslae' => $goodsSale,
                'goods_time' => time(),
            );
            echo '<pre>';
            $model = new GoodsModel();
            $goodId = $model->insertData($data);
            if ($goodId = $model->insertData($data)) {

                //执行图片的批量上传
                $images = isset($_FILES['img_url']) ? $_FILES['img_url'] : array();
                $uploadTool = new UploadTool();
                $list = $uploadTool->multiUpload($images);
                foreach ($list as $key => $value) {
                    $path = 'upload/thumb/' . date('Ymd');
                    $uploadTool = new UploadTool();
                    $uploadTool->setUploadDir($path);
                    $thumb = new ImageTool();
                    $thumbFile1 = $thumb->thumb($value['file'], $path, 350, 350);
                    $thumbFile2 = $thumb->thumb($value['file'], $path, 50, 50);
                    $thumbFile3 = $thumb->thumb($value['file'], $path, 1000, 1000);
                    if ($value['file']) {
                        $data = array(
                            'goods_id' => $goodId,
                            'img_desc' => $imgDesc[$key],
                            'thumb_addr' => $thumbFile1,
                            'thumbs_addr' => $thumbFile2,
                            'thumbb_addr' => $thumbFile3,
                        );
                        $model = new AlbumModel();
                        $model->insertData($data);
                    }
                }
                $url = 'index.php?p=back&c=goods&a=list';
                $this->jump($url, '插入成功');
            } else {
                $url = 'index.php?p=back&c=goods&a=list';
                $this->jump($url, '插入失败');
            }
        } else {
            $url = 'index.php?p=back&c=goods&a=list';
            $this->jump($url, '数据不完整');
        }
    }

    /**
     * 商品列表页。
     */
    public function listAction() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page = max($page, 1);
        $size = isset($_GET['size']) ? $_GET['size'] : 5;
        $size = max($size, 1);
        $model = new GoodsModel;
        $rst = $model->getByPage($page, $size);
        $pageTool = new pageTool();
        $pageHtml = $pageTool->page($page, $size, $rst['total'], 'index.php?p=back&c=goods&a=list');
        $list = array();
        $list1 = array();
        foreach ($rst['data'] as $key => $value) {
            if ($value['goods_status'] & 1) {

                $list[$key]['is_best'] = true;
            } else {
                $list[$key]['goods_best'] = false;
            }
            if ($value['goods_status'] & 2) {
                $list[$key]['goods_new'] = true;
            } else {

                $list[$key]['goods_new'] = false;
            }
            if ($value['goods_status'] & 4) {
                $list[$key]['goods_hot'] = true;
            } else {
                $list[$key]['goods_hot'] = false;
            }

            $list[$key] = array_merge($list[$key], $value);
            if ($list[$key]['goods_delete'] == 0) {
                $list1[] = $list[$key];
            }
        }

        require CURRENT_VIEW_PATH . 'list.html';
    }

    //加入回收站 
    public function backAction() {
        $goodsid = isset($_GET['goods_id']) ? $_GET['goods_id'] : '';
        $Crestore = isset($_GET['restore']) ? $_GET['restore'] : '';
        $restore = new GoodsModel();
        $restore->Restore($Crestore, $goodsid);
        $url = "index.php?p=back&c=goods&a=list";
        $this->jump($url);
    }

    //商品回收站
    public function callbackAction() {
        //分页
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page = max($page, 1);
        $size = isset($_GET['size']) ? $_GET['size'] : 5;
        $size = max($size, 1);
        $model = new CallbackModel;
        $rst = $model->getByPage1($page, $size);
        $pageTool = new pageTool();
        $pageHtml = $pageTool->page($page, $size, $rst['total'], 'index.php?p=back&c=goods&a=callback');

        //显示回收站列表
        $back = new CallbackModel();
        $key = ' goods_delete';
        $value = '1';
        $callback = $back->query($key, $value);
        require CURRENT_VIEW_PATH . 'callback.html';
        $list = array();
    }

    //实现删除、还原功能
    public function DelBackAction() {
        $Crestore = isset($_GET['restore']) ? $_GET['restore'] : '';
        $Cdelete = isset($_GET['delete']) ? $_GET['delete'] : '';
        $goodsid = isset($_GET['goods_id']) ? $_GET['goods_id'] : '';
        $cd = new CallbackModel();
        if ($Cdelete && $goodsid) {
            $cd->deleteByPk($goodsid);
            $url = "index.php?p=back&c=goods&a=callback";
            $this->jump($url);
        } elseif ($Crestore == 0 && $goodsid) {
            $cd->Restore($Crestore, $goodsid);
            $url = "index.php?p=back&c=goods&a=callback";
            $this->jump($url);
        }
    }

    //实现goods编辑
    public function editAction() {
        $model = new CategoryModel;
        $list = $model->getTreeList();
        $goodsId = isset($_GET['goods_id']) ? $_GET['goods_id'] : '';
        $key = 'goods_id';
        $value = $goodsId;
        $list_1 = new GoodsModel();
        $li = $list_1->query($key, $value);
        $list1 = array();
        foreach ($li as $list2) {
            $list1 = $list2;
        }
        require CURRENT_VIEW_PATH . 'edit.html';
    }

}

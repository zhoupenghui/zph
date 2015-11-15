<?php

class SwitchableController extends PlatformController {

    public function addimgAction() {

        require CURRENT_VIEW_PATH . 'switchable.html';
    }

    public function insertAction() {
        //实现图片批量上传
        $imgDesc = isset($_POST['img_desc']) ? $_POST['img_desc'] : '';
        $images = isset($_FILES['img_addr']) ? $_FILES['img_addr'] : array();
        $uploadImg = new UploadTool();
        $upImg = $uploadImg->multiUpload($images);
        foreach ($upImg as $key => $value) {
            $path = 'upload/switchable/' . date('Ymd');
            $uploadImg->setUploadDir($path);
            $switchable = new ImageTool();
            $swiImg = $switchable->thumb($value['file'], $path, 670, 400);
            if ($value['file']) {
                $data = array(
                    'img_describe' => $imgDesc[$key],
                    'img_addr' => $swiImg,
                );
                $model = new SwitchableModel();
                $model->insertData($data);
            }
        }
        $url = 'index.php?p=back&c=switchable&a=addimg';
        $this->jump($url, '插入成功');
    }

}

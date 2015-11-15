<?php

class CategoryController extends PlatformController {

    public function listAction() {
        //1.获取到所有的分类
        $model = new CategoryModel;
        //2.组织分类，形成列表
        $list = $model->getTreeList();
        require CURRENT_VIEW_PATH . 'list.html';
    }

    //增加分类，表单。
    public function addAction() {
        $model = new CategoryModel;
        $list = $model->getTreeList();
        require CURRENT_VIEW_PATH . 'add.html';
    }

    /**
     * 处理表单数据.
     * 数据必须完整。
     * 同一分类下不能存在同名分类。
     */
    public function insertAction() {
        $typeName = empty($_POST['type_name']) ? '' : $_POST['type_name'];
        $parentId = isset($_POST['parent_id']) ? $_POST['parent_id'] : null;
        if ($typeName && isset($parentId)) {
            $model = new CategoryModel;
            $data = array('type_name' => $typeName, 'parent_id' => $parentId);
            if ($model->checkCat($typeName, $parentId)) {
                $url = 'index.php?p=back&c=category&a=list';
                $this->jump($url, '错误：分类已存在');
            } else if ($model->insertData($data)) {
                $url = 'index.php?p=back&c=category&a=list';
                $this->jump($url, '插入成功');
            } else {
                $url = 'index.php?p=back&c=category&a=add';
                $this->jump($url, '插入失败');
            }
        }
        $url = 'index.php?p=back&c=category&a=add';
        $this->jump($url, '数据不完整');
    }

    //edit modify
    public function editAction() {
        $typeId = isset($_GET['type_id']) ? $_GET['type_id'] - 0 : null;
        if (!is_null($typeId)) {
            $model = new CategoryModel;
            $list = $model->getTreeList();
            $cat = $model->getByPk($typeId);
            require CURRENT_VIEW_PATH . 'edit.html';
        } else {
            $url = 'index.php?p=back&c=category&a=add';
            $this->jump($url, '分类不存在，正在跳转到新建页面');
        }
    }

    /**
     * 处理修改的表单提交。
     */
    public function updateAction() {
        $typeId = empty($_POST['type_id']) ? '' : $_POST['type_id'];
        $typeName = empty($_POST['type_name']) ? '' : $_POST['type_name'];
        $parentId = isset($_POST['parent_id']) ? $_POST['parent_id'] : null;
        if ($typeName && isset($parentId)) {
            $model = new CategoryModel;
            if ($model->modifyCat($typeId, $typeName, $parentId)) {
                $url = 'index.php?p=back&c=category&a=list';
                $this->jump($url, '修改成功');
            } else {
                $url = 'index.php?p=back&c=category&a=edit&type_id=' . $typeId;
                $this->jump($url, $model->errorInfo);
            }
        }
        $url = 'index.php?p=back&c=category&a=edit&type_id=' . $typeId;
        $this->jump($url, '数据不合法');
    }

    /**
     * 删除指定分类
     */
    public function removeAction() {
        $typeId = isset($_GET['type_id']) ? $_GET['type_id'] : null;
        $url = 'index.php?p=back&c=category&a=list';
        if (!is_null($typeId)) {
            $model = new CategoryModel;
            if ($model->checkIsHadCat($typeId)) {
                $this->jump($url, '不能删除含有子分类的分类');
            } elseif ($model->deleteByPk($typeId)) {
                $this->jump($url, '删除成功');
            } else {
                $this->jump($url, '删除失败');
            }
        } else {
            $this->jump($url, '数据不完整');
        }
    }

}

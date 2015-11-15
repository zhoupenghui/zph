<?php

class IndexController extends Controller {

    public function indexAction() {

        //商品分类的无限极分类  
        $goodsType = new MenuModel();
        $gootype = $goodsType->getAll();
        foreach ($gootype as $value1) {
            if ($value1['parent_id'] == 0) {
                $value11[] = $value1;
                $valLen11 = count($value11);
                foreach ($gootype as $value2) {
                    if ($value2['parent_id'] == $value1['type_id']) {
                        $value22[] = $value2;
                        $valLen22 = count($value22);
                        foreach ($gootype as $value3) {
                            if ($value3['parent_id'] == $value2['type_id']) {
                                $value33[] = $value3;
                                $valLen33 = count($value33);
                            }
                        }
                    }
                }
            }
        }
        $inList = new GoodsModel();
        //查询推荐商品
        $keyRec = 'goods_recommend';
        $value = 1;
        $recList = $inList->query($keyRec, $value);
        $recLen = count($recList);
        $reclen = ($recLen < 5) ? $recLen : 5;

        //查询热销商品
        $keyHot = 'goods_hot';
        $hotList = $inList->query($keyHot, $value);
        $hotLen = count($hotList);
        $hotlen = ($hotLen < 5) ? $hotLen : 5;

        //查询新品商品
        $keyNew = 'goods_new';
        $newtList = $inList->query($keyNew, $value);
        $newLen = count($newtList);
        $newlen = ($newLen < 5) ? $newLen : 5;

        // 实现图片轮播
        $switchable = new SwitchableModel();
        $imgList = $switchable->getAll();
        $imgLen = count($imgList);
        require CURRENT_VIEW_PATH . 'index.html';
    }

    // 登录后，在首页上显示已登录
    public function index2Action() {
        //商品分类的无限极分类  
        $goodsType = new MenuModel();
        $gootype = $goodsType->getAll();
        foreach ($gootype as $value1) {
            if ($value1['parent_id'] == 0) {
                $value11[] = $value1;
                $valLen11 = count($value11);
                foreach ($gootype as $value2) {
                    if ($value2['parent_id'] == $value1['type_id']) {
                        $value22[] = $value2;
                        $valLen22 = count($value22);
                        foreach ($gootype as $value3) {
                            if ($value3['parent_id'] == $value2['type_id']) {
                                $value33[] = $value3;
                                $valLen33 = count($value33);
                            }
                        }
                    }
                }
            }
        }
        $inList = new GoodsModel();
        //查询推荐商品
        $keyRec = 'goods_recommend';
        $value = 1;
        $recList = $inList->query($keyRec, $value);
        $recLen = count($recList);
        $reclen = ($recLen < 5) ? $recLen : 5;

        //查询热销商品
        $keyHot = 'goods_hot';
        $hotList = $inList->query($keyHot, $value);
        $hotLen = count($hotList);
        $hotlen = ($hotLen < 5) ? $hotLen : 5;

        //查询新品商品
        $keyNew = 'goods_new';
        $newtList = $inList->query($keyNew, $value);
        $newLen = count($newtList);
        $newlen = ($newLen < 5) ? $newLen : 5;

        // 实现图片轮播
        $switchable = new SwitchableModel();
        $imgList = $switchable->getAll();
        $imgLen = count($imgList);
        SessionDbTool::getInstance();

        require CURRENT_VIEW_PATH . 'index2.html';
    }

}

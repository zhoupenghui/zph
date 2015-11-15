<?php

class IndexController extends PlatformController {

    //后台首页
    public function indexAction() {
        //判断是否登录，如果已经登录，就允许访问，否则跳转到登录页面
        require CURRENT_VIEW_PATH . 'index.html';
    }

    //顶部banner
    public function topAction() {
        require CURRENT_VIEW_PATH . 'top.html';
    }

    //左边菜单
    public function menuAction() {
        require CURRENT_VIEW_PATH . 'menu.html';
    }

    //拖动更改尺寸的条
    public function dragAction() {
        require CURRENT_VIEW_PATH . 'drag.html';
    }

    //主显示区域
    public function mainAction() {
        require CURRENT_VIEW_PATH . 'main.html';
    }

}

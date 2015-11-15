<?php

class TestController extends Controller {

    public function indexAction() {
        require CURRENT_VIEW_PATH . 'index.html';
    }

    public function goodsAction() {
        require CURRENT_VIEW_PATH . 'goods.html';
    }

    public function listAction() {
        require CURRENT_VIEW_PATH . 'list.html';
    }

}

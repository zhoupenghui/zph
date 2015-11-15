<?php

class Framework {

    public static function run() {
        self::initPath();
        self::initConfig();
        self::initRequestParam();
        self::registerAutoload();
        self::dispatch();
    }

    //定义路径常量
    private static function initPath() {
        define('DS', '/'); //路径分隔符
        define('ROOT_PATH', dirname(__DIR__) . DS); //根目录
        define('APP_PATH', ROOT_PATH . 'application' . DS); //应用目录
        define('FRAME_PATH', ROOT_PATH . 'framework' . DS); //框架目录
        define('CONF_PATH', APP_PATH . 'config' . DS); //配置目录

        define('CONTRO_PATH', APP_PATH . 'controller' . DS); //控制器目录
        define('MODEL_PATH', APP_PATH . 'model' . DS); //模型目录
        define('VIEW_PATH', APP_PATH . 'views' . DS); //视图目录
        define('TOOL_PATH', FRAME_PATH . 'tool' . DS); //工具类目录
    }

    //初始化配置文件
    private static function initConfig() {
        $GLOBALS['config'] = require CONF_PATH . 'application.config.php'; //应用配置
    }

    //获取请求参数
    private static function initRequestParam() {

        $platform = empty($_GET['p']) ? $GLOBALS['config']['app']['defaultPlatform'] : $_GET['p']; //获取用户要请求的平台
        $control = empty($_GET['c']) ? $GLOBALS['config']['app']['defaultController'] : $_GET['c']; //获取用户要请求的控制器
        $action = empty($_GET['a']) ? $GLOBALS['config']['app']['defaultAction'] : $_GET['a']; //获取用户要请求的操作
        define('PLATFORM', $platform); //平台
        define('CONTROLLER_NAME', $control); //给平台控制器过滤用的
        define('ACTION_NAME', $action); //给平台控制器过滤用的

        define('CURRENT_CONTRO_PATH', CONTRO_PATH . PLATFORM . DS); //当前控制器目录
        define('CURRENT_VIEW_PATH', VIEW_PATH . PLATFORM . DS . CONTROLLER_NAME . DS); //当前视图目录
    }

    //请求分发
    private static function dispatch() {
        $controllerName = CONTROLLER_NAME . 'Controller'; //计算控制器类名
        $actionName = ACTION_NAME . 'Action'; //计算操作方法名
        $controller = new $controllerName(); //实例化控制器对象
        $controller->$actionName(); //调用方法
    }

    //注册自动加载机制。
    private static function registerAutoload() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    //自动加载
    /**
     * 所有的控制器类名都以Controller结尾
     * 所有的模型类名都以Model结尾
     * 其余的认为是特殊情况，都放在框架文件夹
     * @param string $className
     */
    public static function autoload($className) {
        //框架类
        $coreMap = array(
            'Model' => FRAME_PATH . 'Model.class.php',
            'db' => FRAME_PATH . 'db.class.php',
            'Controller' => FRAME_PATH . 'Controller.class.php',
        );

        if (isset($coreMap[$className])) {//之所以将此逻辑提前，是因为基础模型类可能符合下面的条件
            $filename = $coreMap[$className];
        } elseif (substr($className, -10) == 'Controller') {//如果以Controller结尾
            $filename = CURRENT_CONTRO_PATH . $className . '.class.php';
        } elseif (substr($className, -5) == 'Model') {//如果一model结尾的，就去模型文件夹去找
            $filename = MODEL_PATH . $className . '.class.php';
        } elseif (substr($className, -4) == 'Tool') {
            $filename = TOOL_PATH . $className . '.class.php';
        }
        require $filename;
    }

}

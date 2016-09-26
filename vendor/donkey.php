<?php
namespace vendor;
/**
 * Created by PhpStorm.
 * User: Wang han
 * Date: 2016/9/26 0026
 * Time: 下午 4:18
 */
class donkey
{
    public static $classMap = array();
    static public function run()
    {
        $route = new \vendor\lib\route();
        $ctrl = $route->ctrl;
        $action = $route->action;
        $params = $route->params;

        $ctrlFile = APP . '/controllers/' . $ctrl . 'Controller.php';
        $ctrlClass = '\\' . 'app\\' . 'controllers\\' . $ctrl . 'Controller';
        if(is_file($ctrlFile)) {
            $ctrl = new $ctrlClass();
            $ctrl->$action($params);
        }
    }

    static public function load($class)
    {
        // 自动加载类库
        // new \core\route()  new
        // $class = '\vendor\route'
        // VENDOR . '/route.php'
        if(isset(self::$classMap[$class])) {
            return true;
        } else {
            $class = str_replace('\\', '/', $class);
            $classFile = DONKEY . '/' . $class . '.php';
            if(is_file($classFile)) {
                include $classFile;
                self::$classMap[$class] = $class;
            }
        }
    }
}
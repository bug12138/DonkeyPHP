<?php
namespace vendor\lib;
/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/26 0026
 * Time: 下午 4:41
 */
class route
{
    public $ctrl;
    public $action;
    public $params = array();

    public function __construct()
    {
       // var_dump($_SERVER);exit;
        if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            $path = $_SERVER['REQUEST_URI'];
            $pathArr = explode('/', trim($path, '/'));

            if(isset($pathArr[0])) {
                $this->ctrl = $pathArr[0];
                unset($pathArr[0]);
            }
            if(isset($pathArr[1])) {
                $this->action = $pathArr[1];
                unset($pathArr[1]);
            }

            if(count($pathArr) %2 == 0) {
                foreach($pathArr as $k => $v) {
                    if($k %2 == 0)
                        $this->params[$v] = $pathArr[$k+1];
                }
            } else {
                echo '参数错误!请查验';
            }
        } else {
            $this->ctrl = 'index';
            $this->action = 'index';
        }
    }
    public function test()
    {
        echo 'test';
    }
}
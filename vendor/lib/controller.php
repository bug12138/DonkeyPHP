<?php
namespace vendor\lib;
/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/26 0026
 * Time: 下午 6:17
 */
class Controller
{
    public $assign;
    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }

    public function display($file)
    {
        $filePath = APP . '/views/' . $file . '.php';
        if(is_file($filePath)) {
            extract($this->assign);
            include $filePath;
        }
    }
}
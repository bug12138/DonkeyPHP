<?php
namespace vendor\lib;
/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/27 0027
 * Time: 下午 1:32
 */
class Log
{
    static public $class;
    static public function init()
    {
        $driver = config::get('Driver', 'log');

        $class = '\vendor\lib\driver\log\\' . $driver;
        return self::$class = new $class;
    }

//    static function write()
//    {
//        self::$class->log(1222);
//    }
}
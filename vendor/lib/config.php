<?php
namespace vendor\lib;
/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/27 0027
 * Time: 上午 10:36
 */
class config
{
    public static $conf = array();
    static public function get($name, $filename, $filePath = '')
    {
        if(empty($filePath)) {
            $file = APP . '/config/' . $filename . '.php';
        } else {
            $file = $filePath . '/' . $filename . '.php';
        }

        if(isset(self::$conf[$file])) {
            return self::$conf[$file][$name];
        } else {
            if (is_file($file)) {
                $conf = include $file;
                if (isset($conf[$name])) {
                    self::$conf[$file] = $conf;
                    return $conf[$name];
                } else {
                    throw new \Exception("找不到这个配置选项" . $name);
                }
            } else {
                throw new \Exception("找不到这个配置文件" . $file);
            }
        }
    }

    static public function all($filename, $filePath = '')
    {
        if(empty($filePath)) {
            $file = APP . '/config/' . $filename . '.php';
        } else {
            $file = $filePath . '/' . $filename . '.php';
        }

        if(isset(self::$conf[$file])) {
            return self::$conf[$file];
        } else {
            if (is_file($file)) {
                $conf = include $file;
                self::$conf[$file] = $conf;
                return $conf;
            } else {
                throw new \Exception("找不到这个配置文件" . $file);
            }
        }
    }
}
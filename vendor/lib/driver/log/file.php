<?php
namespace vendor\lib\driver\log;
use vendor\lib\config;

/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/27 0027
 * Time: 下午 1:36
 */
class file
{
    public $path;
    public $fileName;
    public function __construct()
    {
        $logParams = config::get('Option', 'log');
        $this->path = $logParams['Path'];
        $this->fileName = $logParams['FileName'];
    }


    public function log($data, $field = '')
    {
        if(!is_dir($this->path)) {
            mkdir($this->path, '0777', true);
        }
        $file = $this->path . "/" . $this->fileName . ".txt";
        $time = date('Y-m-d H:i:s');
        $field = !empty($field)? ("$" . $field . " = "):'';
        return file_put_contents($file, $time .PHP_EOL . $field . var_export($data, true) . PHP_EOL , FILE_APPEND);
    }
}
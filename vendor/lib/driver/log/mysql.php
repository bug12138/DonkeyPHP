<?php
namespace vendor\lib\driver\log;
use vendor\lib\config;

/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/27 0027
 * Time: 下午 2:05
 */
class mysql
{
    public $dbConfig = array();
    public $tableName;
    public function __construct()
    {
        $logParams = config::get('Option', 'log');
        $this->tableName = $logParams['tableName'];
        unset($logParams['tableName']);
        $this->dbConfig = $logParams;
    }

    public function log($data, $field = '')
    {
        // 连接数据库， 创建表， 插入数据 ...
    }
}
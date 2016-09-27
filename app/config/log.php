<?php
/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/27 0027
 * Time: 下午 1:35
 * 文件存储日志的场合
 *  [
 *      'Driver' => 'file',
 *      'Option' => [
 *              'Path' => APP . "/log",
 *              'FileName' => "log"
 *          ]
 *  ]
 * 数据库存储日志的场合
 *  [
 *      'Driver' => 'mysql',
 *      'Option' => [
 *              'dsn' => "mysql:host=localhost;dbname=test",
 *              'username' => 'root',
 *              'password' => '',
 *              'charSet' => 'utf8'
 *              'tableName' => 'log'
 *          ]
 *  ]
 */
return [
    'Driver' => 'file',
    'Option' => [
        'Path' => APP . "/log",
        'FileName' => "log"
    ]
];
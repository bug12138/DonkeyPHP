<?php
/**
 * DonkeyPHP 入口文件
 *
 */
define('DONKEY', realpath(''));

define('VENDOR', DONKEY . '/vendor');

define('APP', DONKEY . '/app');

define('DEBUG', true);

include "vendor/autoload.php";
if(DEBUG) {
    $whoops = new \Whoops\Run;
    $option = new \Whoops\Handler\PrettyPageHandler;
    $option->setPageTitle("DonkeyPHP created by Wang Han");
    $whoops->pushHandler($option);
    $whoops->register();
    ini_set('display_errors', '1');
} else {
    ini_set('display_errors', '0');
}

// 加载系统函数
include VENDOR . '/common/function.php';

include VENDOR . '/Donkey.php';

spl_autoload_register('\vendor\Donkey::load');

// 启动框架
\vendor\Donkey::run();

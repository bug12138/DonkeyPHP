<?php
/**
 * DonkeyPHP 入口文件
 *
 */
define('DONKEY', realpath(''));

define('VENDOR', DONKEY . '/vendor');

define('APP', DONKEY . '/app');

define('DEBUG', true);

if(DEBUG) {
    ini_set('display_errors', '1');
} else {
    ini_set('display_errors', '0');
}

// 加载系统函数
include VENDOR . '/common/function.php';

include VENDOR . '/donkey.php';

spl_autoload_register('\vendor\donkey::load');

// 启动框架
\vendor\donkey::run();

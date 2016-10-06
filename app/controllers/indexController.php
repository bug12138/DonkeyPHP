<?php
namespace app\controllers;
use app\models\Documents;
//use vendor\lib\{Log, Controller}; // PHP7可以这样写

/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/26 0026
 * Time: 下午 5:30
 */
class indexController extends \vendor\lib\Controller
{
    /**
     * 可以在这初始化变量
     */
    public function __construct()
    {
    }

    public function index($params)
    {
        //$conf = \vendor\lib\config::get('default_controller', 'route');
        //$conf = \vendor\lib\config::get('default_action', 'route');
        //$conf = \vendor\lib\config::all('database');

        //Log::init()->log(['aaa' => 2222, 'xxx' => 333], 'warning');

        // 测试Model 范例1
        $documents = Documents::findOne(['id' => 4]);
        // 测试Model 范例2
        $documents = Documents::findAll(['group_id' => 2]);

        foreach($documents as $v) {
            dump($v->title);
        }

        exit;
        $this->assign('data', 'hello hellohellohello');
        $this->assign('title', 'test');
        $this->display('index/index');
    }
}
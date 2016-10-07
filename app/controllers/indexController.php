<?php
namespace app\controllers;
use app\models\Documents;
use vendor\Donkey;

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

        // 测试Model 范例1 更新其中一种方式
        $documents = Documents::findOne(["title" => "zzz111"]);
        $documents->title = "22222";
        $documents->update();
        // 更新第二种方式(集体更新)
        Documents::updateAll(['content' => 'test' ], ['title' => 2]);
        // 更新第三种方式
        $documents = Documents::findOne(["content" => "test"]);
        $documents->title = "22222";
        $documents->save();
        // 新增
        $docObject = new Documents();
        $docObject->title = 'zzz111';
        $docObject->save();
        // 删除第一种方式(集体)
        Documents::deleteAll(['title' => 'zzz111']);
        // 删除第二种方式
        $documents = Documents::findOne(["title" => "22222"]);
        $documents->delete();

        // 测试Model 范例1 查找这里用了yield协程、生成器
        $documents = Documents::findAll(['group_id' => 2]);
        // 单个查找，生成对象返回
        $documents = Documents::findOne(['group_id' => 2]);

        // 开启事务，想法是Donkey::getDb()
        Donkey::getDb()->beginTransaction();
        $docObject = new Documents();
        $docObject->title = 'eee222';
        $docObject->save();
        //Donkey::getDb()->rollBack();
        Donkey::getDb()->commit();

        $this->assign('data', 'hello hellohellohello');
        $this->assign('title', 'test');
        $this->display('index/index');
    }
}
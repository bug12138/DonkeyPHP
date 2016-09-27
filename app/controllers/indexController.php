<?php
namespace app\controllers;
use vendor\lib\log;

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

        log::init()->log(['aaa' => 2222, 'xxx' => 333], 'warning');

        //$model = new \vendor\lib\model();
        //$query = $model->query("select * from documents");
        //$data = $query->fetchAll(\PDO::FETCH_ASSOC);
        //var_dump($data);exit;
        $this->assign('data', 'hello hellohellohello');
        $this->assign('title', 'test');
        $this->display('index/index');
    }
}
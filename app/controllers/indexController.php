<?php
namespace app\controllers;
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
        //$model = new \vendor\lib\model();
        //$query = $model->query("select * from documents");
        //$data = $query->fetchAll(\PDO::FETCH_ASSOC);
        $this->assign('data', 'hello hellohellohello');
        $this->assign('title', 'test');
        $this->display('index/index');
    }
}
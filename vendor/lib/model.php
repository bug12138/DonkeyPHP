<?php
namespace vendor\lib;
/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/26 0026
 * Time: 下午 6:02
 */
class model extends \PDO
{
    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=test";
        $user = 'root';
        $pwd = '';

        try{
            parent::__construct($dsn, $user,$pwd);
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
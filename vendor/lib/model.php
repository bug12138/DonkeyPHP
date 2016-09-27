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
        $database = config::all('database');

        $database['dsn'] = $database['dsn'] . ";charset=" . $database['charSet'];
        try{
            parent::__construct($database['dsn'], $database['username'], $database['password']);
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
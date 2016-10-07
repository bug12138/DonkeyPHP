<?php
namespace vendor\lib;
/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/10/6 0006
 * Time: 下午 10:46
 */
interface ModelInterface
{
    public static function tableName();

    public static function primaryKey();

    public static function findOne($condition);

    public static function findAll($condition);

    public static function updateAll($condition, $attributes);

    public static function deleteAll($condition);

    public function insert();

    public function update();

    public function delete();

    public function save();
}

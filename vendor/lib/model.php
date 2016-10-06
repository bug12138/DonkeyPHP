<?php
namespace vendor\lib;
/**
 * Created by PhpStorm.
 * User: Wang Han
 * Date: 2016/9/26 0026
 * Time: 下午 6:02
 */
class Model implements ModelInterface
{
    /**
     * @var $pdo PDO instance
     */
    public static $pdo;

    /**
     * Get pdo instance
     * @return PDO
     */
    public static function getDb()
    {
        if (empty(static::$pdo)) {
            $database = config::all('database');

            $host = $database['host'];
            //$database['dsn'] = $database['dsn'] . ";charset=" . $database['charset'];
            $dbname = $database['dbname'];
            $username = $database['username'];
            $password = $database['password'];
            // 处理预处理以及防止提取的时候将数值转换为字符串
            $options =  [
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_STRINGIFY_FETCHES => false
            ];
            static::$pdo = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password, $options);
            static::$pdo->exec("set names '" . $database['charset']  . "'");
        }

        return static::$pdo;
    }

    public function __construct()
    {
        //原来直接集成PDO的写法
//        $database = config::all('database');
//
//        $database['dsn'] = $database['dsn'] . ";charset=" . $database['charset'];
//        try{
//            parent::__construct($database['dsn'], $database['username'], $database['password']);
//        }catch (\Exception $e) {
//            echo $e->getMessage();
//        }
    }

    public static function tableName()
    {
        // TODO: Implement tableName() method.
        $tableClassName = get_called_class();
        $tableClassArr = explode('\\', $tableClassName);
        $tableClass = array_pop($tableClassArr);
        // TODO: 表名默认为小写
        return  strtolower($tableClass);
    }

    public static function primaryKey()
    {
        // TODO: Implement primaryKey() method.
    }

    /**
     * Build a sql where part
     * @param mixed $condition a set of column values
     * @param $params
     * @return string
     */
    public static function buildWhere($condition, $params = null)
    {
        if (is_null($params)) {
            $params = [];
        }

        $where = '';
        if (!empty($condition)) {
            $where .= ' where ';
            $keys = [];
            foreach ($condition as $key => $value) {
                array_push($keys, "$key = ?");
                array_push($params, $value);
            }
            $where .= implode(' and ', $keys);
        }
        return [$where, $params];
    }

    /**
     * Convert array to model
     * @param  mixed $row the row data from database
     * @return mixed $model
     */
    public static function arrToModel($row)
    {
        $model = new static();
        foreach ($row as $rowKey => $rowValue) {
            $model->$rowKey = $rowValue;
        }
        return $model;
    }

    public static function findOne($condition = null)
    {
        list($where, $params) = static::buildWhere($condition);
        $sql = 'select * from ' . static::tableName() . $where;

        // 预处理
        $stmt = static::getDb()->prepare($sql);
        $rs = $stmt->execute($params);

        if ($rs) {
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!empty($row)) {
                return static::arrToModel($row);
            }
        }
        // 默认返回null
        return null;
    }

    public static function findAll($condition)
    {
        // TODO: Implement findAll() method.
        list($where, $params) = static::buildWhere($condition);
        $sql = 'select * from ' . static::tableName() . $where;

        $stmt = static::getDb()->prepare($sql);
        $rs = $stmt->execute($params);
        //$models = [];
        if ($rs) {
            // 优化前
//            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
//            foreach ($rows as $row) {
//                if (!empty($row)) {
//                    $model = static::arr2Model($row);
//                    array_push($models, $model);
//                }
//            }
            // 优化思路
            while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                if (!empty($row)) {
                    yield static::arrToModel($row);
                }
            }
        }
        // 优化前
        //return $models;
    }

    public static function updateAll($condition, $attributes)
    {
        // TODO: Implement updateAll() method.
    }

    public static function deleteAll($condition)
    {
        // TODO: Implement deleteAll() method.
    }

    public function insert()
    {
        // TODO: Implement insert() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}
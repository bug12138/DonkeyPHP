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
        return ['id'];
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

    /**
     * 根据条件查找一条记录
     * @param null $condition
     * @return mixed|null
     */
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

    /**
     * 根据条件查询符合的素有记录
     * @param $condition
     * @return \Generator
     */
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

    /**
     * 更新符合条件的记录
     * @param $condition
     * @param $attributes
     */
    public static function updateAll($attributes, $condition)
    {
        // TODO: Implement updateAll() method.
        $sql = "update " . static::tableName();
        $params = [];

        if(!empty($attributes)) {
            $sql .= ' set ';
            $params = array_values($attributes);
            $keys = [];
            foreach($attributes as $key => $value) {
                array_push($keys, "$key = ?");
            }
            $sql .= implode(',', $keys);
        }

        list($where, $params) = static::buildWhere($condition, $params);
        $sql .= $where;

        $stmt = static::getDb()->prepare($sql);
        $execRs = $stmt->execute($params);

        if($execRs) {
            // 获取更新的行数
            $execRs = $stmt->rowCount();
        }
        return $execRs;

    }

    /**
     * 删除符合条件的所有记录
     * @param $condition
     */
    public static function deleteAll($condition)
    {
        // TODO: Implement deleteAll() method.
        list($where, $params) = static::buildWhere($condition);

        $sql = 'delete from ' . static::tableName() . $where;
        $stmt = static::getDb()->prepare($sql);
        $execRs = $stmt->execute($params);

        if($execRs) {
            $execRs = $stmt->rowCount();
        }
        return $execRs;
    }

    /**
     * 插入操作
     */
    public function insert()
    {
        // TODO: Implement insert() method.
        $sql = 'insert into ' . static::tableName();
        $params = [];
        $keys = [];
        foreach($this as $key => $value) {
            array_push($keys, $key);
            array_push($params, $value);
        }
        // 构建?号语句
        $holder = array_fill(0, count($keys), '?');
        $sql .= '(' . implode(',', $keys) . ') values (' . implode(' , ', $holder) . ')';

        $stmt = static::getDb()->prepare($sql);
        $execRs = $stmt->execute($params);

        // 返回一些自增赋回给Model中
        $primaryKeys = static::primaryKey();
        foreach($primaryKeys as $primaryKey) {
            $lastId = static::getDb()->lastInsertId($primaryKey);
            $this->$primaryKey = (int)$lastId;
        }
        return $execRs;
    }

    /**
     * 更新操作
     */
    public function update()
    {
        // TODO: Implement update() method.
        $primaryKeys = static::primaryKey();
        $condition = [];
        foreach($primaryKeys as $primaryKey) {
            $condition[$primaryKey] = isset($this->$primaryKey)? $this->$primaryKey:null;
        }
        $attribute = [];
        foreach($this as $key => $value) {
            if(!in_array($key, $primaryKeys, true)) {
                $attribute[$key] = $value;
            }
        }
        return static::updateAll($attribute, $condition) !== false;
    }

    /**
     * 删除操作
     */
    public function delete()
    {
        // TODO: Implement delete() method.
        $primaryKeys = static::primaryKey();
        $condition = [];
        foreach($primaryKeys as $primaryKey) {
            $condition[$primaryKey] = isset($this->$primaryKey)? $this->$primaryKey:null;
        }
        return static::deleteAll($condition) !== false;
    }

    /**
     * 保存记录(添加或者更新)
     */
    public function save()
    {
        $primaryKeys = static::primaryKey();
        $insertFlag = false;
        foreach($primaryKeys as $primaryKey) {
            if(!isset($this->$primaryKey)) {
                $insertFlag = true;
            }
        }
        // 插入
        return $insertFlag? $this->insert():$this->update();
    }

    public function beginTransaction()
    {
        static::getDb()->beginTransaction();
    }

    public function commit()
    {
        static::getDb()->commit();
    }

    public function rollBack()
    {
        static::getDb()->rollBack();
    }
}
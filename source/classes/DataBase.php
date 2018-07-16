<?php
namespace radio\classes;
use radio\core\BaseConfig;

/**
 * Created by PhpStorm.
 * User: littl
 * Date: 28.04.2018
 * Time: 11:57
 */

class DataBase
{
    private $dbh;
    private $className = 'stdClass';

    public function __construct()
    {
        $dsn = 'mysql:dbname=' . BaseConfig::DATABASE_NAME . ';host=' . BaseConfig::DATABASE_HOST . ';charset=' . BaseConfig::DATABASE_CHARSET;
        $this->dbh = new \PDO($dsn, BaseConfig::DATABASE_USER, BaseConfig::DATABASE_PASSWORD);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Устанавливает имя класса
     * @param $className
     */
    public function setClassName($className)
    {
        $this->className = 'radio\classes\\'. $className;
    }

    /*
     *Возвращает результат запроса
     */
    public function query($sql, $params = [])
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(\PDO::FETCH_CLASS, $this->className);
    }


    public function queryUnbuffered($sql)
    {
        $this->dbh->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        return $sth = $this->dbh->query($sql);
    }

    public function PDOStatement($sql, $params = [])
    {
        $resource = $this->dbh->prepare($sql);
        $resource->execute($params);
        return $resource;
    }

    public function prepare_query($sql, $params = [])
    {
        $resource = $this->dbh->prepare($sql, $params);
        return $resource;
    }

    public function execute_prepared_query($resource, $params = [])
    {
        if (count($params)) {
            $res = $resource->execute($params);
        } else {
            $res = $resource->execute();
        }
        return $res;
    }

    public function bind_param($resource, $param_name, $value, $param_type = false)
    {
        if (!$param_name or !$value) return false;
//        $sth->bindParam(':calories', $calories, PDO::PARAM_INT);
//        $sth->bindParam(':colour', $colour, PDO::PARAM_STR, 12);
        if ($param_type) {
            $resource->bindParam($param_name, $value, $param_type);
        } else {
            $resource->bindParam($param_name, $value);
        }
        return true;
    }

    public function pdo()
    {
        return $this->dbh;
    }

    public function quote($str)
    {
        $pdo = $this->dbh;
        $result = $pdo->quote($str);
        return $result;
    }

    public static function quote_static($str)
    {
        $db = new DataBase();
        $pdo = $db->pdo();
        $result = $pdo->quote($str);
        return $result;
    }

    /**
     * Выполняет запрос и возвращает true или false
     * @param $sql
     * @param array $params
     * @return bool
     */
    public function execute($sql, $params = [])
    {
        $sth = $this->dbh->prepare($sql);
        return $sth->execute($params);
    }

        /**
     * Возвращает ID последней добавленной записи
     * @param $sql
     * @param array $params
     * @return string
     */
    public function insert($sql, $params = [])
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
        return $this->dbh->lastInsertId();
    }
}

<?php
namespace radio\classes;
use radio\core\BaseConfig;
use \PDO;

/**
 * Created by PhpStorm.
 * User: littl
 * Date: 28.04.2018
 * Time: 11:57
 */

class DataBase
{
    /** @var PDO */
    protected static $instance = null;

    public function __construct() {}
    public function __clone() {}

    public static function instance()
    {
        if (self::$instance === null)
        {
            $options  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => TRUE,
                PDO::ATTR_PERSISTENT => TRUE
            );
            $dsn = 'mysql:host='. BaseConfig::DATABASE_HOST.';dbname='.BaseConfig::DATABASE_NAME.';charset='.BaseConfig::DATABASE_CHARSET;
            try {
                self::$instance = new PDO($dsn, BaseConfig::DATABASE_USER, BaseConfig::DATABASE_PASSWORD, $options);
            } catch (\PDOException $e) {
                echo $e->getMessage();die();
            }
        }
        return self::$instance;
    }

    /**
     * Прямой запрос
     * @param $sql
     * @return array
     */
    public static function query($sql)
    {
        $statement  = self::PDO()->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращаем подготовленное состояние с данными
     * @param $sql
     * @param array $params
     * @return \PDOStatement
     */
    public static function PDOStatement($sql, $params = [])
    {
        $statement = self::PDO()->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    /**
     * Получаем подготовленное состояние без данных
     * @param $sql
     * @param array $params
     * @return \PDOStatement
     */
    public static function prepareQuery($sql, $params = [])
    {
        $statement = self::PDO()->prepare($sql, $params);
        return $statement;
    }

    /**
     * Выполняем подготовленный запрос
     * @param $statement
     * @param array $params
     * @return \PDOStatement
     */
    public static function executePreparedQuery($statement, $params = [])
    {
        /** @var $statement \PDOStatement*/
        if (count($params)) {
            $statement = $statement->execute($params);
        } else {
            $statement = $statement->execute();
        }
        return $statement;
    }

    /**
     * Привязываем переменные к запросу
     * @param $resource \PDOStatement
     * @param $paramName
     * @param $value
     * @param bool $paramType
     * @return bool
     */
    public static function bindParam($resource, $paramName, $value, $paramType = false)
    {
        if (!$paramName or !$value)
            return false;

        if ($paramType) {
            $resource->bindParam($paramName, $value, $paramType);
        } else {
            $resource->bindParam($paramName, $value);
        }

        return true;
    }

    /**
     * Получим подключение к базе
     * @return PDO
     */
    public static function PDO()
    {
        return self::$instance;
    }

    /**
     * Выполняет запрос и возвращает true или false
     * @param $sql
     * @param array $params
     * @return bool
     */
    public static function execute($sql, $params = [])
    {
        $sth = self::$instance->prepare($sql);
        return $sth->execute($params);
    }

    /**
     * Функция хелпер для сборки запроса
     * @param $allowed
     * @param array $source
     * @return string
     */
    public static function pdoSet($allowed, $source) {
        $set = '';
        //$fieldTo - заменяющий
        //$fieldFrom - заменяемый ключ
        foreach ($allowed as $fieldFrom => $fieldTo) {
            if (isset($source[$fieldFrom])) {
                $set.="`".str_replace("`","``",$fieldTo)."`". "=:$fieldFrom, ";
            }
        }
        return substr($set, 0, -2);
    }
}

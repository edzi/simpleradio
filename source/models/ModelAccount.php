<?php
namespace radio\models;

use radio\classes\DataBase;
use radio\core\Model;

/**
 * Created by PhpStorm.
 * User: littl
 * Date: 04.06.2018
 * Time: 15:54
 */
class ModelAccount extends Model
{
    private $user;

    public function __construct()
    {
    }

    public function setUserInfo()
    {
        $id = $this->getSessionUID();
        $sql = 'SELECT name, lastname FROM users where id = ?';
        $result = DataBase::PDOStatement($sql, array($id));
        $data = current($result->fetchAll(\PDO::FETCH_ASSOC));
        $this->setData($data);
    }

    public function updateUserInfo() 
    {
        $return['error'] = true;
        $args = [
            'new_name' => FILTER_DEFAULT,
            'new_lastname' => FILTER_DEFAULT,
            'service' => FILTER_VALIDATE_INT,
            'function' => FILTER_VALIDATE_INT,
        ];
        $args = filter_input_array(INPUT_POST, $args);
        unset($args['submit_change_name']);
        $name = $args['new_name'];

        if (mb_strlen($name) < 3 or mb_strlen($name) > 30) {
            $return['message'] = 'Имя может быть длиной от 3 до 30 символов';
            return $return;
        }

        $lastName = $args['new_lastname'];
        if (mb_strlen($lastName) < 3 or mb_strlen($lastName) > 30) {
            $return['message'] = 'Фамилия может быть длиной от 3 до 30 символов';
            return $return;
        }
        
        if (!isset($args['service'])) {
            $return['message'] = 'Выберите подразделение';
            return $return;
        }

        if (!isset($args['function'])) {
            $return['message'] = 'Выберите должность';
            return $return;
        }
        
        $id = $this->getSessionUID();
        $allowed = [
            'new_name' => 'name',
            'new_lastname' => 'lastname',
            'service' => 'id_service',
            'function' => 'id_function'
        ];
        $sql = 'UPDATE users SET '. DataBase::pdoSet($allowed, $args) . ' WHERE id=:id';
        $args['id'] = (int)$id;
        DataBase::execute($sql, $args);
        $return['error'] = false;
        return $return;
    }

    public function setListServices()
    {
        $sql = 'SELECT * FROM service';
        $result = DataBase::query($sql);        
        $this->setData($result, 'services');
    }

    public function setListFunctions()
    {
        $sql = 'SELECT * FROM function';
        $result = DataBase::query($sql);
        $this->setData($result, 'functions');
    }

    private function getSessionUID()
    {
        $hash = $_COOKIE['authID'];
        $sql = "SELECT uid FROM sessions WHERE hash = ?";
        $result = DataBase::PDOStatement($sql, array($hash));

        if ($result->rowCount() == 0) {
            return false;
        }

        return $result->fetch(\PDO::FETCH_ASSOC)['uid'];
    }
}

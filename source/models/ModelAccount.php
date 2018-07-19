<?php
namespace radio\models;

use radio\classes\Auth;
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

    public function getUserInfo()
    {
        echo "<pre>";print_r($_POST);echo "</pre>";
        //select employee.name, employee.lastname from  employee, users where employee.id = users.id_employee and users.email = 'edzi1@mail.ru';
        $auth = new Auth();
        if ($auth->isLogged()) {
            $hash = $_COOKIE['authID'];
            $id = $auth->getSessionUID($hash);
            $sql = 'SELECT name, lastname FROM users where id = ?';
            $result = DataBase::PDOStatement($sql, array($id));
            $data = current($result->fetchAll(\PDO::FETCH_ASSOC));
            return $data;
        }
    }
}

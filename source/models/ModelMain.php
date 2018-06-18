<?php
namespace radio\models;
use radio\classes\DataBase;
use radio\core\Model;

/**
 * Created by PhpStorm.
 * User: littl
 * Date: 21.05.2018
 * Time: 11:55
 */
class ModelMain extends Model
{
    private $dataBase;
    public function __construct()
    {
        $this->dataBase = new DataBase();
    }
}
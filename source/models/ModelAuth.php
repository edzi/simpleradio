<?php
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 08.05.2018
 * Time: 14:42
 */
namespace radio\models;
use radio\core\Model;

class ModelAuth extends Model
{
    private $errors = [];
    
    
    public function __construct()    {
        $this->init();
    }
    
    
    
    private function init()
    {

    }
    
    
    public function getData()
    {
        return $this->data;
    }

    public function getErrors() {
        return $this->errors;
    }
}
<?php
namespace radio\models;
use radio\core\Model;

/**
 * Created by PhpStorm.
 * User: littl
 * Date: 24.05.2018
 * Time: 15:29
 */
class Model404 extends Model {
    
    public function __construct()
    {
        $this->setData($_SESSION);
    }
}
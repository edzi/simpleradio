<?php
namespace radio\core;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 24.04.2018
 * Time: 17:23
 */
class Model 
{
    protected $data = [];
    protected function setData($data) {
        if (is_array($data)) {
            $this->data = array_merge($this->data, $data);
        } else {
            return false;
        }
        return $data;
    }
    
    public function getData() 
    {
        return $this->data;
    }
}
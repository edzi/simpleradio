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
    public function setData($data, $keyData = '') {
        if (strlen($keyData) > 0) {
            if (isset($this->data[$keyData])) {
                echo "<pre>";print_r('Данные для ключа ='. $keyData. '= не установлены. Неуникальный ключ.');echo "</pre>";
            } else {
                $this->data[$keyData] = $data;
            }
        } else  {
            if (is_array($data)) {                
                $this->data = array_merge($this->data, $data);
            } else {
                return false;
            }        
        }
        return $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
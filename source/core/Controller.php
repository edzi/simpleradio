<?php
namespace radio\core;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 24.04.2018
 * Time: 17:23
 */
class Controller
{
    public $model;
    public $view;

    public function __construct($Model)
    {
        $this->model = $Model;
        $this->view = new View();
    }

    public function actionIndex()
    {
        
    }

    public function redirect($redirectUrl)
    {
        if ('/' == substr($redirectUrl, 0, 1)) {
            $redirectUrl = substr($redirectUrl, 1);
        }

        /**
         * Редиректимся и завершаем выполнение скрипта
         */
        header ("Location: " . BaseConfig::BASE_PATH . $redirectUrl);
        exit;
    }
}
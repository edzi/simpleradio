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

    function __construct($Model)
    {
        $this->model = $Model;
        $this->view = new View();
    }

    function actionIndex()
    {
        
    }
}
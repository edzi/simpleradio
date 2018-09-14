<?php
namespace radio\controllers;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 26.07.2018
 * Time: 12:32
 */
use radio\core\Controller;

class ControllerTest extends Controller 
{
    function actionIndex()
    {
        $this->view->generate('test_view.php', 'template_view.php');
    }
}
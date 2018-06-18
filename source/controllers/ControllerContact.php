<?php
namespace radio\controllers;
use radio\core\Controller as Controller;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 26.04.2018
 * Time: 10:47
 */

class ControllerContact extends Controller
{

    function actionIndex()
    {
        $this->view->generate('contacts_view.php', 'template_view.php');
    }
}
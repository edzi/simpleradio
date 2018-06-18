<?php
namespace radio\controllers;
use radio\core\Controller;

/**
 * Created by PhpStorm.
 * User: littl
 * Date: 04.06.2018
 * Time: 15:43
 */
class ControllerAccount extends Controller 
{
    public function actionIndex()
    {
        $this->view->generate('account_view.php', 'template_view.php');
    }
}
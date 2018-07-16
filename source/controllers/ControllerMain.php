<?php
namespace radio\controllers;
use radio\classes\Auth;
use radio\core\Controller as Controller;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 26.04.2018
 * Time: 10:49
 */

class ControllerMain extends Controller
{
    function actionIndex()
    {
        $Auth = new Auth();
        if (!$Auth->isLogged()) {
            $this->redirect('auth/login')     ;
        }
        $this->view->generate('main_view.php', 'template_view.php');
    }
}
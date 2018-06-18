<?php
namespace radio\controllers;
use radio\core\Controller as Controller;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 26.04.2018
 * Time: 10:46
 */

class Controller404 extends Controller
{

    function actionIndex()
    {
        $data = $this->model->getData();
        $this->view->generate('404_view.php', 'template_view.php', $data);
    }

}

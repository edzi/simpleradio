<?php
namespace radio\controllers;
use radio\core\Controller;
use radio\models\ModelAccount;

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

        /**
         * @var $model ModelAccount
         */
        $userData = $this->model->getUserInfo();
        $this->view->generate('account_view.php', 'template_view.php', $userData);
    }
    
    public function actionRename() 
    {
        
    }
}
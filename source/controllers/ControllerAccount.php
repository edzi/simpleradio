<?php
namespace radio\controllers;
use radio\core\Controller;
use radio\models\ModelAccount as ModelAccount;
use radio\classes\Auth;

/**
 * Created by PhpStorm.
 * User: littl
 * Date: 04.06.2018
 * Time: 15:43
 */
class ControllerAccount extends Controller 
{
    /** @var  $model ModelAccount*/
    public $model;
    public function actionIndex()
    {
        $auth = new Auth();
        if ($auth->isLogged()) {
            $this->model->setUserInfo();
        }
        $this->model->setListServices();
        $this->model->setListFunctions();
        $data = $this->model->getData();
        $this->view->generate('account_view.php', 'template_view.php', $data);
    }
    
    public function actionRename() 
    {
        $auth = new Auth();
        if ($auth->isLogged()) {
            $this->model->setUserInfo();
            $this->model->setListServices();
            $this->model->setListFunctions();
            $result = $this->model->updateUserInfo();

            $data = [];
            if (!$result['error']) {
                $this->redirect('account/');
            } else {
                $data = [
                    'message' => $result['message']
                ];
            }
            $this->model->setData($data);
            $data = $this->model->getData();
            $this->view->generate('account_view.php', 'template_view.php', $data);
        }
    }
}
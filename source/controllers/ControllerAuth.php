<?php
namespace radio\controllers;
use radio\classes\Auth;
use radio\core\Controller;
use radio\models\ModelRegistration;

/**
 * Created by PhpStorm.
 * User: littl
 * Date: 08.05.2018
 * Time: 14:41
 */
class ControllerAuth extends Controller {

    public function actionIndex()
    {
        $this->view->generate('registration_view.php', 'template_view.php');
    }

    public function actionRegistration()
    {
        $inputData = $_POST;
        if (empty($inputData)) {
            $this->view->generate('', 'registration_view.php', []);
        } else {
            $auth = new Auth();
            $result = $auth->register($inputData['mail'], $inputData['password'], $inputData['password2']);
            if ($result['error'] == 1) {
                $data = [
                    'message' => $result['message']
                ];
                $this->view->generate('', 'registration_view.php', $data);
            } else {
                $this->redirect('auth/login');
            }
        }
    }

    public function actionLogin()
    {
        $inputData = $_POST;
        if (!empty($inputData) or isset($_COOKIE['authID'])) {
            $auth = new Auth();
            if (!$auth->isLogged()) {
                if ($inputData['remember'] == 'on') {
                    $inputData['remember'] = 1;
                } else {
                    $inputData['remember'] = 0;
                }
                $result = $auth->login($inputData['mail'], $inputData['password'], $inputData['remember']);

                if ($result['error'] == 1) {
                    $data = [
                        'message' => $result['message']
                    ];
                    $this->view->generate('', 'login_view.php', $data);
                } else {
                    setcookie('authID', $result['hash'], time() + 60 * 60 * 24, '/');
                    $this->redirect('account/');
                }
            } else {
                $this->redirect('account/');
            }
        }else {
            $this->view->generate('', 'login_view.php');
        }
    }

    public function actionLogout()
    {
        $Auth = new Auth();
        if ($Auth->isLogged()) {
            $Auth->logout($_COOKIE['authID']);
            setcookie('authID', null, -1, '/');
            $this->redirect('auth/login/');
        }
    }
}
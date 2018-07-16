<?php
namespace radio\core;
use radio\classes\Error;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 24.04.2018
 * Time: 16:48
 */
class Route
{
    static function start()
    {
        $controllerName = 'main';
        $actionName = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if (!empty($routes[1]) )
        {
            $controllerName = $routes[1];
        }

        // получаем имя экшена
        if (!empty($routes[2]) )
        {
            $actionName = $routes[2];
        }

        //добавляем префиксы
        $modelName = 'Model'
                    . ucfirst($controllerName);
        $controllerName = 'Controller'
                        . ucfirst($controllerName);
        $actionName = 'action'
                    . ucfirst($actionName);

        //подключаем модель
        $modelName = 'radio\models\\' . $modelName;
        if (!class_exists($modelName)) {
            Error::setErrorText("Модели: {$modelName} не существует");
            Route::errorPage404();
        } else {
            $Model = new $modelName();
        }

        $controllerName = 'radio\controllers\\'. $controllerName;
        //создаем контроллер
        if (!class_exists($controllerName)) {
            Error::setErrorText("Контроллера: {$controllerName} не существует");
            Route::errorPage404();
        } else {
            $controller = new $controllerName($Model);
        }
        $action = $actionName;
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Error::setErrorText("События: {$actionName} не существует");
            Route::errorPage404();
        }
    }
    
    public static function errorPage404()
    {                
        header('Location:' . BaseConfig::BASE_PATH . '404');
        die;
    }
}
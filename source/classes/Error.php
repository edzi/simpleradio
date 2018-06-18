<?php
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 05.06.2018
 * Time: 10:52
 */

namespace radio\classes;


class Error
{
    private static $error;

    /**
     * @return mixed
     */
    public static function getErrorText()
    {
        $error ='';
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            $_SESSION['error'] = null;
            if (is_array($error)){
                $tempText = implode('<br>', $error);
                return $tempText;
            }
        }

        return $error;
    }

    /**
     * @param mixed $error
     */
    public static function setErrorText($error)
    {
        $_SESSION['error'] = $error;
    }
}
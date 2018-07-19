<?php
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 18.07.2018
 * Time: 11:37
 */

namespace radio\classes;


class DatabaseException extends \PDOException
{
    public function __construct($message=null, $code=null) {
        $this->message = $message;
        $this->code = $code;
    }
}
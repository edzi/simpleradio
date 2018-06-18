<?php
namespace radio\classes;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 10.05.2018
 * Time: 16:03
 */
class User extends Person
{
    private $name = '';
    private $lastname = '';
    private $errors = [];
    public function __construct($login, $password, $confirm_password = null, $email = null)
    {
        if (parent::validateLogin($login)) {
            $this->login = $login;
        } else {
            $this->login = null;
            $this->errors['login'] = 'Ошибка в логине';
        }
        if (parent::validateMail($email)) {
            $this->setMail($email);
        } else {
            $this->setMail(null);
            $this->errors['mail'] = 'Ошибка в почтовом ящике';
        }
        if (parent::validatePassword($password)) {
            if ($password == $confirm_password) {
                $this->setPassword($password);
            } else {
                $this->setPassword(null);
                $this->errors['password'] = 'Пароли не совпадают';
            }
        }
        else {
            $this->setPassword(null);
            $this->errors['password'] = 'Неподходящий пароль';
        }     
        $this->dateRegistration = time();
        $this->lastEnter = time();
    }
    
    public function isValid($login = false) {
        if ($login) {
            if (empty($this->login) or empty($this->password)) {
                return false;
            }                
        } else {
            if (empty($this->login) or empty($this->password) or empty($this->mail)) {
                return false;
            }
        }
        return true;
    }
    
    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setPassword($newPass)
    {
        $this->password = $newPass;
    }

    public function setMail($newMail)
    {
        $this->mail = $newMail;
    }
    
    public function setName($newName) 
    {
        $this->name = $newName;
    }
    
    public function setLastname($newLastname) 
    {
        $this->lastname = $newLastname;
    }
    public function getErrors() {
        return $this->errors;
    }
}
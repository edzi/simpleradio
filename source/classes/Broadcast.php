<?php
namespace radio\classes;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 03.05.2018
 * Time: 11:10
 */
class Broadcast
{
    private $id;
    private $name;
    private $idEmployee;

//    public function __construct($id = null, $name = null, $idEmployee = null)
//    {
//        $this->id = $id;
//        $this->name = $name;
//        $this->idEmployee = $idEmployee;
//    }


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function getIdEmployee() 
    {
        return $this->idEmployee;
    }
    /**
 * @param null $id
 * @param null $name
 * @return bool|static
 */
    public static function createSimpleBroadcast($id = null, $name = null)
    {
        $obj = new static();

        if (empty($id)) return false;
        if (empty($name)) return false;

        $obj->id = $id;
        $obj->name = $name;

        return $obj;


    }

    public static function createEmployeeBroadcast($id = null, $name = null, $idEmployee = null)
    {

        $obj = static::createSimpleBroadcast($id, $name);
        if (empty($idEmployee)) return false;
        $obj->idEmployee = $idEmployee;


        return $obj;


    }
}
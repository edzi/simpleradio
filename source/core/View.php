<?php
namespace radio\core;
/**
 * Created by PhpStorm.
 * User: littl
 * Date: 24.04.2018
 * Time: 17:23
 */
class View
{        
    function generate($contentView, $templateView, $data=[]) 
    {
        foreach($data as $key => $value){
            $$key = $value;
        }
        require 'source/views/' . $templateView;
    }

   
}
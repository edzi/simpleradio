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
    public function generate($contentView = '', $templateView = '', $data=[])
    {
        foreach($data as $key => $value){
            $$key = $value;
        }
        require 'source/views/' . $templateView;
    }

   public static function generateMessageTemplate($messages)
   {
       if (empty($messages)) {
           return '';
       }
       if (is_array($messages)) {
           $message = implode('</br>', $messages);
       } else {
           $message = $messages;
       }
       $html = '<label>'
           . $message
           . '</label>';
       return $html;
   }
}
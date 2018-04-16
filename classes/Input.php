<?php

namespace DigitalWorld\Business;

class Input{
    public static function exists($type = "post"){
        switch($type){
            case "post":
                return (!empty($_POST))? true : false;
                break;
            case "get":
                return (!empty($_GET))? true : false;
                break;
            default:
                return false;
                break;
        }
    }
    public static function get($item){
        
        if(isset($_POST[$item])){
            return $_POST[$item];
        }
        else if(isset($_GET[$item])){
            return $_GET[$item];
        }
    }
    public static function replace($value, $input){
        return str_replace($value, "", $input);
    }
}
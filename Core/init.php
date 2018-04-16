<?php

//Variabelen die globaal te gebruiken zijn
if(!defined('SITE_PATH')){
    define('SITE_PATH', $_SERVER["DOCUMENT_ROOT"] . "/api/");
    define('SITE_URL', "http://localhost/api/");
    
    //allow errors to show
    define('DEBUG', true);
}

//globale config voor de applicatie
$GLOBALS["config"] = array(
    "mysql" => array(
        "host" => "localhost",
        "database" => "buurtslagers_app",
        "wachtwoord" => "",
        "user" => "root"
    )
);

//autload klasses
spl_autoload_register(function($class){
    $class = str_replace("\\", "/", $class);
    $class = basename($class);
    require_once 'classes/' . $class . ".php";
});
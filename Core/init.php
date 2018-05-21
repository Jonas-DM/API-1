<?php

//Variabelen die globaal te gebruiken zijn
if(!defined('SITE_PATH')){
    // define('SITE_PATH', $_SERVER["DOCUMENT_ROOT"] . "/api/");
    // define('SITE_URL', "http://localhost/api/");
    
    //allow errors to show
    define('DEBUG', false);
}

//globale config voor de applicatie
$GLOBALS["config"] = array(
    "mysql" => array(
        "host" => "ID196183_api.db.webhosting.be",
        "database" => "ID196183_api",
        "wachtwoord" => "TOAIM2020",
        "user" => "ID196183_api"
    )
);

//autload klasses
spl_autoload_register(function($class){
    $class = str_replace("\\", "/", $class);
    $class = basename($class);
    require_once 'classes/' . $class . ".php";
});
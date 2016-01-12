<?php

define('APPLICATION_PATH', dirname(__FILE__).'/../');

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

register_shutdown_function(function(){
    set_error_handler('system_error_log', E_ALL);
});

function system_error_log($errorno, $errorstr, $errorfile, $errorline) {

}

$application->bootstrap()->run();

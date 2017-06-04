<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define("WWW_ROOT", dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);


require_once WWW_ROOT. "dao" .DIRECTORY_SEPARATOR. 'MainDAO.php';
require_once WWW_ROOT. "api" .DIRECTORY_SEPARATOR. 'Slim'. DIRECTORY_SEPARATOR .'Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

require_once WWW_ROOT. "api".DIRECTORY_SEPARATOR."routes" .DIRECTORY_SEPARATOR. 'loginregister.php';
require_once WWW_ROOT. "api".DIRECTORY_SEPARATOR."routes" .DIRECTORY_SEPARATOR. 'profile.php';
require_once WWW_ROOT. "api".DIRECTORY_SEPARATOR."routes" .DIRECTORY_SEPARATOR. 'parts.php';

$app->run();

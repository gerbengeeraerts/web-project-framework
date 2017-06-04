<?php
session_start();

define('DS', DIRECTORY_SEPARATOR);
define('WWW_ROOT', __DIR__ . DS);
//
if($_SERVER['REMOTE_ADDR'] == '::1'){
  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);
  define('MY_APP_FOLDER', 'http://localhost/xxx/deploy/');
}else{
  define('MY_APP_FOLDER', '/xxx/');
}

function parse_path() {
  $path = array();
  if (isset($_SERVER['REQUEST_URI'])) {
    $request_path = explode('?', $_SERVER['REQUEST_URI']);

    $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
    $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
    $path['call'] = utf8_decode($path['call_utf8']);
    if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
      //$path['call'] = '';
    }
    $path['call_parts'] = explode('/', $path['call']);

    if(!empty($request_path[1])){

      $path['query_utf8'] = urldecode($request_path[1]);
      $path['query'] = utf8_decode(urldecode($request_path[1]));
      $vars = explode('&', $path['query']);

      foreach ($vars as $var) {
        $t = explode('=', $var);
        $path['query_vars'][$t[0]] = $t[1];
      }
    }
  }
  return $path;
}

$path_info = parse_path();
//echo '<pre>'.print_r($path_info, true).'</pre>';
//echo '<pre>'.print_r($_GET, true).'</pre>';

require_once(WWW_ROOT.'controller'.DS.'routes.php');

if(!$path_info['call_parts'][0]) {

    $path_info['call_parts'][0] = 'home';

}

// if not found in routes.php
if(empty($routes[$path_info['call_parts'][0]])) {
    header('Location: error');
    exit();
}

//$route = $routes[$_GET['p']];
$route = $routes[$path_info['call_parts'][0]];
$controllerName = $route['controller'] . 'Controller';

$_SESSION['APP_LAYOUT'] = $route['layout'];
$_SESSION['APP_PAGE_TITLE'] = $route['title'];
$_SESSION['APP_PAGE_DESCRIPTION'] = $route['description'];
$_SESSION['APP_SHARE_TITLE'] = $_SESSION['APP_PAGE_TITLE'];
$_SESSION['APP_SHARE_DESCRIPTION'] = $_SESSION['APP_PAGE_DESCRIPTION'];
$_SESSION['APP_SHARE_IMAGE'] = MY_APP_FOLDER.'assets/img/view_media_share_image_default.jpg';
$_SESSION['APP_SHARE_URL'] = MY_APP_FOLDER;

require_once WWW_ROOT . 'controller' . DS . $controllerName . ".php";

$controllerObj = new $controllerName();
$controllerObj->route = $route;
$controllerObj->filter();
$controllerObj->render();

/* functions */

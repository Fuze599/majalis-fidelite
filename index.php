<?php
session_start();

define('VIEWS', 'views/');
define('MODELS', 'models/');
define('CONTROLLERS', 'controllers/');

date_default_timezone_set("Europe/Brussels");
define('NOW', date("Y-m-d H:i:s"));

function loadClass($class) {
    require_once 'models/' . $class . '.class.php';
}
spl_autoload_register('loadClass');

if (empty($_GET) or empty($_GET['action'])) {
    header('Location: index.php?action=connect');
    die();
}
$db = Db::getInstance();
require_once (VIEWS . 'header.php');
switch ($_GET['action']) {
    case 'disconnect':
        $_SESSION = array();
        header('Location: index.php?action=connect');
        die();
    case 'operation':
        require_once (CONTROLLERS . 'OperationSending.php');
        $controller = new OperationSending($db);
        break;
    case 'register':
        require_once (CONTROLLERS . 'RegisterController.php');
        $controller = new RegisterController($db);
        break;
    case 'home':
        require_once (CONTROLLERS . 'HomeController.php');
        $controller = new HomeController($db);
        break;
    case 'connect':
        require_once (CONTROLLERS . 'ConnectController.php');
        $controller = new ConnectController();
        break;
    case 'settings':
        require_once (CONTROLLERS . 'SettingController.php');
        $controller = new SettingController($db);
        break;
    default:
        header('Location: index.php?action=connect');
        die();
}
$controller->run();
require_once (VIEWS . 'footer.php');
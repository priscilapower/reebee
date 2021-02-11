<?php
require "bootstrap.php";
use Service\Flyer as FlyerService;
use Service\Page as PageService;
use Service\User as UserService;
use Controller\Flyer as FlyerController;
use Controller\Page as PageController;
use Controller\User as UserController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$param = null;
if (isset($uri[2])) {
    $param = $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
$flyer = false;

switch ($uri[1]) {
    case 'user':
        $service = new UserService($db);
        $controller = new UserController($service, $requestMethod);
        $response = $controller->processRequest();

        header($response['status_code']);
        break;
    case 'flyer':
        $service = new FlyerService($db);
        $controller = new FlyerController($service, $requestMethod, $param);
        $response = $controller->processRequest();

        header($response['status_code']);
        break;
    case 'page':
        if ($param == 'flyer') {
            $param = $uri[3];
            $flyer = true;
        }

        $service = new PageService($db);
        $controller = new PageController($service, $requestMethod, $flyer, $param);
        $response = $controller->processRequest();

        header($response['status_code']);
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        $response['body'] = null;
        exit(404);
}

echo $response['body'];

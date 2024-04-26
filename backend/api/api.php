<?php
require_once '../config/init.php';

// Get the HTTP method, path and input of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

$requestInput = json_decode(file_get_contents('php://input'), true);

// Create a new instance
//$userController = new UserController();
$requestProcessor = new requestProcessor;
$response = $requestProcessor->handleRequest($method,$requestInput);
//echo json_decode($response);
// Handle request based on HTTP mer->handleRequeethod
/*switch ($method) {
  case 'GET':
    break;
  case 'POST':
    //$userController->handleRequest($method, $input);
    $appointmentController->handleRequest($method, $requestInput);

    break;
  case 'PUT':

    break;
  case 'DELETE':

    break;
}*/

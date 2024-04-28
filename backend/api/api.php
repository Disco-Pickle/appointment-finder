<?php
require_once '../config/init.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
//header('Access-Control-Allow-Credentials: true');

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
/*if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  // Respond successfully:
  header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
  exit;
}*/

// Get the HTTP method, path and input of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

$requestInput = json_decode(file_get_contents('php://input'), true);

// Create a new instance
//$userController = new UserController();
$requestProcessor = new RequestProcessor;
$response = $requestProcessor->handleRequest($method, $requestInput);
if ($response === null) {
  response("GET", 418, null);
} else {
  response("GET", 200 , $response);
}

function response($method, $httpStatus, $data)
{
  header("Content-Type: application/json");
  switch ($method) {
    case "GET":
      http_response_code($httpStatus);
      echo json_encode($data);
      break;
    case "POST":
      http_response_code($httpStatus);
      echo json_encode($data);
      break;

    case "OPTIONS":
      header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
      break;
    default:
      http_response_code(418);
      echo ("API ERROR");
  }
}
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

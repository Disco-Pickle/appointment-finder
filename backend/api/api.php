<?php
require_once '../config/init.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

$requestInput = json_decode(file_get_contents('php://input'), true);

$requestProcessor = new RequestProcessor;
$response = $requestProcessor->handleRequest($method, $requestInput);//send request to 

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

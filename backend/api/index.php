<?php
require_once '../config/init.php';

// Get the HTTP method, path and input of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

$input = json_decode(file_get_contents('php://input'), true);

// Create a new instance
$userController = new UserController();
$appointmentController = new AppointmentController();

// Handle request based on HTTP method
switch ($method) {
  case 'GET':
    break;
  case 'POST':
    $UserController->handleRequest($method, $input);
    $AppointmentController->handleRequest($method, $input);

    break;
  case 'PUT':

    break;
  case 'DELETE':

    break;
}

<?php
// init.php

// Display errors for debugging - remove this line when deploying your application
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
require_once '../utilities/Database.php';
require_once '../models/Person.php';
require_once '../controllers/AppointmentController.php';
require_once '../api/requestProcessor.php';
// Add other necessary files here

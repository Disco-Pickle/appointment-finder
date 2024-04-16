<?php
// init.php

// Display errors for debugging - remove this line when deploying your application
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
require_once '../utilities/Database.php';
require_once '../models/Person.php';
require_once '../controllers/UserController.php';
require_once '../controllers/AppointmentController.php';
// Add other necessary files here

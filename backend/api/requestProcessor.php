<?php
include_once("../controllers/UserController.php");
include_once("../controllers/AppointmentController.php");

class RequestProcessor
{
    private $userController;
    private $appointmentController;
    public function __construct()
    {
        $this->userController = new UserController();
        $this->appointmentController = new AppointmentController();
    }

    public function handleRequest($method, $requestInput)
    {
        if ($method == "POST") {
            if (isset($requestInput['action'])) {
                switch ($requestInput['action']) {
                    case 'addAppointment':
                        if (isset($requestInput['author'])&&isset($requestInput['name'])&&isset($requestInput['expired'])&&isset($requestInput['dates'])) {
                            $author= $requestInput['author'];
                            $name= $requestInput['name'];
                            $expired= $requestInput['expired'];
                            $dates= $requestInput['dates'];
                        }else echo 'json error';
                        return $this->appointmentController->addAppointment($author,$name,$expired,$dates);
                        
                    case 'getAppointment':
                        // Assuming you have an appointment ID in the requestInput
                        $appointmentId = $requestInput['appointmentId'];
                        $appointment = $this->appointmentController->getAppointmentById($appointmentId);
                        return $appointment;
                        // Process the retrieved appointment data (e.g., print or return it)
                        // Example: echo json_encode($appointment);
                    case 'getAllAppointments':
                        return $this->appointmentController->getAllAppointments();
                    case 'getAppointmentDates':
                        return $this->appointmentController->getAppointmentDates($requestInput['appointmentId']);
                    default:
                        echo "RequstInput Error";         
                        return ['error' => 'Invalid action'];               
                }
            }else echo "Request Input: " . json_encode($requestInput) . "\n";

        }else {
            http_response_code(418);
            echo json_encode(['method' => 'Not Fouond']);
            echo $method;
            echo $requestInput;
        }
    }
}

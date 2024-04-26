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
                        return $this->appointmentController->addAppointment(
                            $requestInput['author'],
                            $requestInput['name'],
                            $requestInput['dates']
                        );
                        break;
                        
                }
            }else echo 'handle Request error!';
        }else {
            http_response_code(418);
            echo json_encode(['method' => 'Not Fouond']);
            echo $method;
            echo $requestInput;
        }
    }
}

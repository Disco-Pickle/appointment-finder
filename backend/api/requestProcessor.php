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
                    case 'getAppointment':
                        // Assuming you have an appointment ID in the requestInput
                        $appointmentId = $requestInput['appointmentId'];
                        $appointment = $this->appointmentController->getAppointmentById($appointmentId);

                        // Process the retrieved appointment data (e.g., print or return it)
                        // Example: echo json_encode($appointment);
                        break;
                        
                }
            }else echo 'handle Request error!' . $method . $requestInput;
        }else {
            http_response_code(418);
            echo json_encode(['method' => 'Not Fouond']);
            echo $method;
            echo $requestInput;
        }
    }
}

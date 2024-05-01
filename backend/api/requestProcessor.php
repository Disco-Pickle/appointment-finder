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
		    //--------------------------------------------------------
		case 'addAppointment':
		    $appointmentData= $this->prepareAddAppointment($requestInput);
		    return $this->appointmentController->addAppointment($appointmentData);
		    //--------------------------------------------------------
		case 'insertDates':
		    if (isset($requestInput['dates'])&&isset($requestInput['appointmentId'])){
			$dates=$requestInput['dates'];
			$appointmentId=$requestInput['appointmentId'];
		    }else echo "json error";
		    return $this->appointmentController->insertDates($dates,$appointmentId);
		    //--------------------------------------------------------
		case "insertPerson":
			if(isset($requestInput["dateId"])&&isset($requestInput["persons"])){
				return $this->appointmentController->updatePersons($requestInput["dateId"],$requestInput["persons"]);
			}else echo "json error";
			break;
		case "insertComment":
			if(isset($requestInput["appointmentId"])&&isset($requestInput["name"])&&isset( $requestInput["commentString"])){
				return $this->appointmentController->insertComment($requestInput['name'],$requestInput['commentString'],$requestInput['appointmentId']);
			}else echo "json error";
			break;
		case "deleteAppointmentById":
		    if (isset($requestInput["appointmentId"])){
			$appointmentId=$requestInput["appointmentId"];
		    }else echo "json error";
		    return $this->appointmentController->deleteAppointmentById($appointmentId);
		    //--------------------------------------------------------
		case "getComments":
			if(isset($requestInput['appointmentId'])){
				return $this->appointmentController->getComments($requestInput['appointmentId']);
			}else echo "json error";
			break;	
		case 'getAppointment':
		    // Assuming you have an appointment ID in the requestInput
		    $appointmentId = $requestInput['appointmentId'];
		    $appointment = $this->appointmentController->getAppointmentById($appointmentId);
		    return $appointment;
		    // Process the retrieved appointment data (e.g., print or return it)
		    // Example: echo json_encode($appointment);
		    //--------------------------------------------------------
		case 'getAllAppointments':
		    return $this->appointmentController->getAllAppointments();
		    //--------------------------------------------------------
		case 'getAppointmentDates':
		    return $this->appointmentController->getAppointmentDates($requestInput['appointmentId']);
		    //--------------------------------------------------------
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

    private function prepareAddAppointment($payload)
    {
	  if (isset($payload['author'])&&isset($payload['name'])
		&&isset($payload['expired'])&&isset($payload['dates'])
		&& !empty($payload['author'])&& !empty($payload['name'])) {
	
		$author= htmlspecialchars($payload['author']);
		$name= htmlspecialchars($payload['name']);
		$expired= htmlspecialchars($payload['expired']);
		$dates= $payload['dates'];
	  }else{ echo 'json error';
	  }
	  return compact('author','name','expired','dates');
    }
}

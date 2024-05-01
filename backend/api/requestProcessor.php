<?php
include_once("../controllers/CommentsController.php");
include_once("../controllers/AppointmentController.php");
include_once("../controllers/DatesController.php");
include_once("../utilities/Validator.php");
class RequestProcessor
{
	private $validator;
    private $commentsController;
    private $appointmentController;
	private $datesController;
    public function __construct()
    {
	$this->datesController = new DatesController();
	$this->appointmentController = new AppointmentController();
	$this->commentsController = new CommentsController();
	$this->validator = new Validator();
    }

    public function handleRequest($method, $requestInput)
    {
	if ($method == "POST") {
	    if (isset($requestInput['action'])) {
		switch ($requestInput['action']) {
		    //--------------------------------------------------------
		case 'addAppointment':
		    $appointmentData= $this->validator->prepareAddAppointment($requestInput);
		    return $this->appointmentController->addAppointment($appointmentData);
		    //--------------------------------------------------------
		case 'insertDates':
		    $datesData= $this->validator->prepareInsertDates($requestInput);
		    return $this->datesController->insertDates($datesData);
		    //--------------------------------------------------------
		case "insertPerson":
			$personData=$this->validator->prepareUpdatePersons($requestInput);
			return $this->datesController->updatePersons($personData);
		case "insertComment":
			$commentData=$this->validator->prepareInsertComment($requestInput);
			return $this->commentsController->insertComment($commentData);
		case "deleteAppointmentById":
		    if (isset($requestInput["appointmentId"])){
			$appointmentId=$requestInput["appointmentId"];
		    }else echo "json error";
		    return $this->appointmentController->deleteAppointmentById($appointmentId);
		    //--------------------------------------------------------
		case "getComments":
			if(isset($requestInput['appointmentId'])){
				return $this->commentsController->getComments($requestInput['appointmentId']);
			}else echo "json error";
			break;	
		case 'getAppointment':
		    $appointmentId = $requestInput['appointmentId'];
		    $appointment = $this->appointmentController->getAppointmentById($appointmentId);
		    return $appointment;
		    //--------------------------------------------------------
		case 'getAllAppointments':
		    return $this->appointmentController->getAllAppointments();
		    //--------------------------------------------------------
		case 'getAppointmentDates':
		    return $this->datesController->getAppointmentDates($requestInput['appointmentId']);
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

   
}

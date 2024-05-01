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
//big requestRouter
    public function handleRequest($method, $requestInput)
    {
	if ($method == "POST") {
	    if (isset($requestInput['action'])) {
			$action = $this->validator->prepareAction($requestInput['action']);
		switch ($action) {
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
		    $appointmentId=$this->validator->prepareAppointmentId($requestInput);
		    return $this->appointmentController->deleteAppointmentById($appointmentId);
		    //--------------------------------------------------------
		case "getComments":
			$appointmentId=$this->validator->prepareAppointmentId($requestInput);
				return $this->commentsController->getComments($appointmentId);	
		case 'getAppointment':
		    $appointmentId = $this->validator->prepareAppointmentId($requestInput);
		    $appointment = $this->appointmentController->getAppointmentById($appointmentId);
		    return $appointment;
		    //--------------------------------------------------------
		case 'getAllAppointments':
		    return $this->appointmentController->getAllAppointments();
		    //--------------------------------------------------------
		case 'getAppointmentDates':
				$appointmentId=$this->validator->prepareAppointmentId($requestInput);
		    return $this->datesController->getAppointmentDates($appointmentId);
		    //--------------------------------------------------------
		default:
		    echo "RequstInput Error";         
		    return ['error' => 'Invalid action'];               
		}
	    }else return ['action' => 'invalid'];

	}else {
	    http_response_code(418);
	    return ['method' => 'Not Fouond'];
	   }
    }

   
}

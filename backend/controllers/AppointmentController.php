<?php
require_once '../utilities/Database.php';
class AppointmentController
{
    private $db;

    //-------------------------------Constructor
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    } //-----------------------------------------
    //-------------------------------------------------------------------------Add Appointmentpublic function addAppointment($author, $name, $dates)
    public function addAppointment($author, $name, $dates)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("INSERT INTO appointment (author, name) VALUES (?, ?)");
            $stmt->execute([$author, $name]);
            $appointmentId = $this->db->lastInsertId();

            foreach ($dates as $date) {
                // Check that all necessary keys are present in the date
                if (!isset($date['day'], $date['starttime'], $date['endtime'])) {
                    throw new Exception('A date is missing one or more necessary keys.');
                }

                $stmt = $this->db->prepare("INSERT INTO dates (day, starttime, endtime, persons, fk_idappointment) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$date['day'], $date['starttime'], $date['endtime'], $appointmentId]);
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    public function getAppointmentById($appointmentId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM appointment WHERE id = ?");
            $stmt->execute([$appointmentId]);
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$appointment) {
                throw new Exception('Appointment not found.');
            }

            // You can also fetch associated dates for this appointment if needed
            // Example: $appointment['dates'] = $this->getAppointmentDates($appointmentId);
            
            return $appointment;
        } catch (Exception $e) {
            throw $e;
        }
    }
 public function getAppointmentDates($appointmentId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM dates WHERE fk_idappointment = ?");
            $stmt->execute([$appointmentId]);
            $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $dates;
        } catch (Exception $e) {
            throw $e;
        }
    }
}


    //---------------------------------------------------------------------
    //---------------------------------------------------------------------------Request Router
    /*
    public function handleRequest($method, $input)
{
    if ($method == 'POST') {
        if (isset($input['action']) && $input['action'] == 'addAppointment') {
            $dates = $input['dates'];
            $this->addAppointment(
                $input['author'],
                $input['name'],
                $dates
            );
        }
    }
}

    //-----------------------------------------
    */

#$controller = new AppointmentController();
#$controller->handleRequest($method,$input);

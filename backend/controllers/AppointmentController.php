<?php
require_once '../utilities/Database.php';
require_once '../models/Appointment.php';
class AppointmentController
{
    private $db;

    //-------------------------------Constructor
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    } 
    //-------------------------------------------------------------------------Add Appointmentpublic function addAppointment($author, $name, $dates)
/*    public function addAppointment($payload)
    {
	$dates=$payload['dates'];
        $this->db->beginTransaction();
    
        try {
            // Insert appointment data into the 'appointment' table using appointment object
            $stmt = $this->db->prepare("INSERT INTO appointment (author, name, expired) VALUES (?, ?, ?)");
            $appointment=new Appointment($payload['author'],$payload['name'],$payload['expired'],json_encode($dates));
            $stmt->execute([$appointment->author,$appointment->name,$appointment->expired]);
            $appointmentId = $this->db->lastInsertId();
    
            foreach ($dates as $date) {
                if (!isset($date['day'], $date['starttime'], $date['endtime'])) {
                    throw new Exception('A date is missing one or more necessary keys.');
                }
                $stmt = $this->db->prepare("INSERT INTO dates (day, starttime, endtime, fk_idappointment) VALUES (?, ?, ?, ?)");
                $stmt->execute([$date['day'], $date['starttime'], $date['endtime'], $appointmentId]);
            }
            
            $this->db->commit();
            
            return ['message' => 'Appointment added to DB', 'appointmentId' => $appointmentId];

          
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }*/public function addAppointment($payload)
{
    $this->db->beginTransaction();

    try {
        // Insert appointment data into the 'appointment' table using appointment object
        $stmt = $this->db->prepare("INSERT INTO appointment (author, name, expired) VALUES (?, ?, ?)");
        $appointment = new Appointment($payload['author'], $payload['name'], $payload['expired'],$payload['persons']?? null);
        $stmt->execute([$appointment->author, $appointment->name, $appointment->expired]);
        $appointmentId = $this->db->lastInsertId();

        $this->db->commit();

        return ['message' => 'Appointment added to DB', 'appointmentId' => $appointmentId];

    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
}

    public function deleteAppointmentById($appointmentId)
{
    $this->db->beginTransaction();
    try {
         // Also delete associated dates from the 'dates' table
        $stmt = $this->db->prepare("DELETE FROM dates WHERE fk_idappointment = ?");
        $stmt->execute([$appointmentId]);
        // Delete the appointment from the 'appointment' table
        $stmt = $this->db->prepare("DELETE FROM appointment WHERE id = ?");
        $stmt->execute([$appointmentId]);

       

        $this->db->commit(); // Commit the transaction after successful deletion
        return ['message' => 'Appointment deleted successfully'];
    } catch (Exception $e) {
        $this->db->rollBack(); // Roll back the transaction in case of an exception
        throw $e;
    }
}
    public function getAllAppointments()
    {
        try {
            $stmt = $this->db->prepare("SELECT id, author, name, expired FROM appointment");
            $stmt->execute();
            $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
           return $appointments;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    //helper function just in case
    public function getAppointmentById($appointmentId)
    {
        try {
            $stmt = $this->db->prepare("SELECT id, author, name FROM appointment WHERE id = ?");
            $stmt->execute([$appointmentId]);
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$appointment) {
                throw new Exception('Appointment not found.');
            }
           echo json_encode($appointment);
            return $appointment;
        } catch (Exception $e) {
            throw $e;
        }
    }
}

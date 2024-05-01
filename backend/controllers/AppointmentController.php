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
    public function addAppointment($payload)
    {
	$dates=$payload['dates'];
        $this->db->beginTransaction();
    
        try {
            // Insert appointment data into the 'appointment' table
            $stmt = $this->db->prepare("INSERT INTO appointment (author, name, expired) VALUES (?, ?, ?)");
            $stmt->execute([$payload['author'], $payload['name'],$payload['expired']]);
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
    }
    public function updatePersons($dateId, $persons) {
        $this->db->beginTransaction();
        try {
            
            $stmt = $this->db->prepare('SELECT persons FROM dates WHERE id = ?');
            $stmt->execute([$dateId]);
            $currentPersons = $stmt->fetchColumn();

            $currentPersonsArray = $currentPersons ? explode(", ", $currentPersons) : [];
            $mergedPersonsArray = array_merge($currentPersonsArray, $persons);
            $mergedPersonsStr = implode(", ", $mergedPersonsArray);
            $stmt = $this->db->prepare('UPDATE dates SET persons = ? WHERE id = ?');
            $stmt->execute([$mergedPersonsStr, $dateId]);
    
            $this->db->commit();
    
            return ['message' => 'Persons updated for date', 'dateId' => $dateId];
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    

    public function deleteAppointmentById($appointmentId)
{
    $this->db->beginTransaction();
    try {
        
        $stmt = $this->db->prepare("DELETE FROM dates WHERE fk_idappointment = ?");
        $stmt->execute([$appointmentId]);
        // Delete the appointment from the 'appointment' table
        $stmt = $this->db->prepare("DELETE FROM appointment WHERE id = ?");
        $stmt->execute([$appointmentId]);

        // Also delete associated dates from the 'dates' table
       

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

    public function insertDates($dates, $appointmentId)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('INSERT INTO dates (day, starttime, endtime, persons, fk_idappointment) VALUES (?, ?, ?, ?, ?)');
            foreach ($dates as $date) {
                $stmt->execute([$date['day'], $date['starttime'], $date['endtime'], $date['persons'], $appointmentId]);
            }
            $this->db->commit(); // Commit the transaction after successful execution
            return  ['message' => 'Date added to Appointment', 'appointmentId' => $appointmentId]; 
        } catch (Exception $e) {
            $this->db->rollBack(); // Roll back the transaction in case of an exception
            throw $e;
        }
    }


public function insertComment($name, $commentString, $appointmentId) {
    $this->db->beginTransaction();
    try {
        $stmt = $this->db->prepare('INSERT INTO comments (name, commentString, appointmentId_fk) VALUES (?, ?, ?)');
        $stmt->execute([$name, $commentString, $appointmentId]);
        $this->db->commit();
        return ['message' => 'Comment added', 'appointmentId' => $appointmentId];
    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
}
public function getComments($appointmentId) {
    try {
        // Prepare the SQL statement
        $stmt = $this->db->prepare('SELECT * FROM comments WHERE appointmentId_fk = ?');

        // Execute the statement with the appointment ID
        $stmt->execute([$appointmentId]);

        // Fetch all comments
        $comments = $stmt->fetchAll();

        return ['message' => 'Comments fetched', 'appointmentId' => $appointmentId, 'comments' => $comments];
    } catch (Exception $e) {
        throw $e;
    }
}


    //-------------------------------------------------------------------------------------------------------------------------
    public function getAppointmentDates($appointmentId)
    {
        try {
            $stmt = $this->db->prepare("SELECT id, day, starttime, endtime, persons FROM dates WHERE fk_idappointment = ?");
            $stmt->execute([$appointmentId]);
            $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $dates;
        } catch (Exception $e) {
            throw $e;
        }
    }
}

<?php
require_once '../utilities/Database.php';

class DatesController
{
    private $db;
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
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
    public function getAppointmentDates($appointmentId)
    {
        try {
            $stmt = $this->db->prepare("SELECT id, day, starttime, endtime, persons FROM dates WHERE fk_idappointment = ?");
            $stmt->execute([$appointmentId]);
            $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Iterate over each date and add the person count
            foreach ($dates as $key => $date) {
                $persons = $date['persons'];
                // Check if persons is not null or empty
                if (!empty($persons)) {
                    // Split the persons string on comma and count the elements
                    $personCount = count(explode(", ", $persons));
                } else {
                    $personCount = 0;
                }
                // Add the person count to the date array
                $dates[$key]['personCount'] = $personCount;
            }
    
            return $dates;
        } catch (Exception $e) {
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














}
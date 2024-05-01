<?php
require_once '../utilities/Database.php';
require_once '../models/Dates.php';
class DatesController
{
    private $db;
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }


    public function insertDates($payload) {
        $datesPayload = $payload['dates'];
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('INSERT INTO dates (day, starttime, endtime, persons, fk_idappointment) VALUES (?, ?, ?, ?, ?)');
            foreach ($datesPayload as $datePayload) {
                $date = new Dates( $datePayload['day'], $datePayload['starttime'], $datePayload['endtime'], $datePayload['persons'] ?? null);
                $stmt->execute([$date->day, $date->startTime, $date->endTime, $date->persons, $payload['appointmentId']]);
            }
            $this->db->commit();
            return ['message' => 'Date added to Appointment', 'appointmentId' => $payload['appointmentId']];
        } catch (Exception $e) {
            $this->db->rollBack();
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
    
//append persons
    public function updatePersons($payload) {
        $this->db->beginTransaction();
        $persons= $payload['persons'];
        try {
            
            $stmt = $this->db->prepare('SELECT persons FROM dates WHERE id = ?');
            $stmt->execute([$payload['dateId']]);
            $currentPersons = $stmt->fetchColumn();

            $currentPersonsArray = $currentPersons ? explode(", ", $currentPersons) : [];
            $mergedPersonsArray = array_merge($currentPersonsArray, $persons);
            $mergedPersonsStr = implode(", ", $mergedPersonsArray);
            $stmt = $this->db->prepare('UPDATE dates SET persons = ? WHERE id = ?');
            $stmt->execute([$mergedPersonsStr, $payload['dateId']]);
    
            $this->db->commit();
    
            return ['message' => 'Persons updated for date', 'dateId' => $payload['dateId']];
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }














}
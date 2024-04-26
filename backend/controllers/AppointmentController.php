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
                if (!isset($date['day'], $date['month'], $date['year'], $date['persons'], $date['starthour'], $date['startminute'], $date['endhour'], $date['endminute'])) {
                    throw new Exception('A date is missing one or more necessary keys.');
                }

                $stmt = $this->db->prepare("INSERT INTO dates (day, month, year, persons, fk_idappointment, starthour, startminute, endhour, endminute) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$date['day'], $date['month'], $date['year'], $date['persons'], $appointmentId, $date['starthour'], $date['startminute'], $date['endhour'], $date['endminute']]);
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
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

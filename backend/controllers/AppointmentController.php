<?php
require_once '../utilities/Database.php';
class AppointmentController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addAppointment($day, $month, $year, $startTime, $endTime) {
        // Prepare the SQL statement
        $stmt = $this->db->prepare("INSERT INTO Appointment (day, month, year, startTime, endTime) VALUES (?, ?, ?, ?, ?)");
        
        // Format the date and time values
        $date = "$year-$month-$day";
        $startDateTime = "$date $startTime";
        $endDateTime = "$date $endTime";

        // Execute the statement with the appointment data
        $stmt->execute([$day, $month, $year, $startDateTime, $endDateTime]);
    }
}

?>
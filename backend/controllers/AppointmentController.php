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
    }//-----------------------------------------
//-------------------------------------------------------------------------Add Appointment
    public function addAppointment($day, $month, $year, $startTime, $endTime)
    {
        // Prepare the SQL statement
        $stmt = $this->db->prepare("INSERT INTO Appointment (day, month, year, startTime, endTime) VALUES (?, ?, ?, ?, ?)");

        // Format the date and time values
        $date = "$year-$month-$day";
        $startDateTime = "$date $startTime";
        $endDateTime = "$date $endTime";

        // Execute the statement with the appointment data
        $stmt->execute([$day, $month, $year, $startDateTime, $endDateTime]);
    }//---------------------------------------------------------------------
    //---------------------------------------------------------------------------Request Router
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action']) && $_POST['action'] == 'addAppointment') {
                $this->addAppointment(
                        $_POST['day'],
                        $_POST['month'],
                        $_POST['year'],
                        $_POST['startDateTime'],
                        $_POST['endDateTime']
                    );
            }
        }
    }//-----------------------------------------
}
$controller = new AppointmentController();
$controller->handleRequest();
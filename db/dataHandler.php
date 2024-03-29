<?php
include("./models/appointment.php");

// Relevant variable names are in appointment.php
class DataHandler
{
    // Fetches demo data (below)
    public function fetchAppointments()
    {
        return DataHandler::getDemoData();
    }

    // Puts demo data into an array for returning
    public function getAppointments()
    {
        $result = [];
        foreach ($this->fetchAppointments() as $val) 
        {
            $result[] = $val;
        }
        return $result;
    }

    // Has demo data array
    private static function getDemoData()
    {
        return 
        [ 
            new Appointment(29, 03, 2024, "10:00", "12:00", 1),
            new Appointment(02, 04, 2024, "11:00", "13:00", 1),
            new Appointment(05, 04, 2024, "16:00", "18:00", 0),
            new Appointment(13, 04, 2024, "09:00", "11:00", 0),
            new Appointment(03, 05, 2024, "14:30", "16:30", 0)
        ];
    }
}

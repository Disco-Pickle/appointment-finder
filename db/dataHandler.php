<?php
include("./models/appointment.php");

// Relevant variable names are in appointment.php
class DataHandler
{
    // Gets demo data array
    public function getAppointments()
    {
        return DataHandler::getDemoData();
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
    // EXTENSION END
}

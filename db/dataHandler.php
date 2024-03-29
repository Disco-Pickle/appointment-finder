<?php
include("./models/person.php");

// Relevant variable names are in person.php

class DataHandler
{
    // Core functionality, gets demo data array
    public function queryPersons()
    {
        return DataHandler::getDemoData();
    }

    // Querys persons by ID
    public function queryPersonById($id)
    {
        $result = [];
        foreach ($this->queryPersons() as $val) {
            if ($val->id == $id) {
                $result[] = $val;
            }
        }
        return $result;
    }

    // Querys persons by (Last) Name
    public function queryPersonByName($name)
    {
        $result = [];
        foreach ($this->queryPersons() as $val) {
            if (stripos($val->lastname, $name) !== FALSE) {
                $result[] = $val;
            }
        }
        return $result;
    }

    // EXTENSION START
    // Querys persons by Department
    public function queryPersonByDept($department)
    {
        $result = [];
        foreach ($this->queryPersons() as $val) {
            if (stripos($val->department, $department) !== FALSE) {
                $result[] = $val;
            }
        }
        return $result;
    }

    // Querys persons by phone number
    public function queryPersonByPhone($phone)
    {
        $result = [];
        foreach ($this->queryPersons() as $val) {
            if ($val->phone == $phone) {
                $result[] = $val;
            }
        }
        return $result;
    }
    
    private static function getDemoData()
    {
        return [ new Person(1, "Jane", "Doe", "jane.doe@fhtw.at", 1234567, "Central IT"),
                 new Person(2, "John", "Doe", "john.doe@fhtw.at", 34345654, "Help Desk"),
                 new Person(3, "Baby", "Doe", "baby.doe@fhtw.at", 54545455, "Management"),
                 new Person(4, "Mike", "Smith", "mike.smith@fhtw.at", 343477778, "Faculty"),
                 new Person(5, "Cave", "Johnson", "c.johnson@aperture.sci", 10242099, "CEO"),
                 new Person(6, "Caroline", "Brown", "caroline@aperture.sci", 1047003, "Assistant to the CEO"),
                 new Person(7, "Chell", "Test", "chell@riseup.com", 111045, "Test Subjects"),
                 new Person(8, "Wheatley", "Idiot", "wheatley@aperture.com", 1441107, "Personality Cores"),
                 new Person(9, "Doug", "Rattmann", "d.rattmann@aperture.sci", 1417345, "Fired") ];
    }
    // EXTENSION END
}

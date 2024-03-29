<?php
include("db/dataHandler.php");

class SimpleLogic
{
    private $dh;
    
    function __construct()
    {
        $this->dh = new DataHandler();
    }

    function handleRequest($method)
    {
        switch ($method) {
            case "getAppointments":
                return $this->dh->getAppointments();
            default:
                return null;
        }
    }
}

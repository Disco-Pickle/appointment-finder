<?php
include("db/dataHandler.php");

class SimpleLogic
{
    private $dh;
    
    function __construct()
    {
        $this->dh = new DataHandler();
    }

    function handleRequest($method, $param)
    {
        switch ($method) {
            case "queryPersons":
                return $this->dh->queryPersons();
            case "queryPersonById":
                return $this->dh->queryPersonById($param);
            case "queryPersonByName":
                return $this->dh->queryPersonByName($param);
            // EXTENSION START
            case "queryPersonByDept":
                return $this->dh->queryPersonByDept($param);
            case "queryPersonByPhone":
                return $this->dh->queryPersonByPhone($param);
            // EXTENSION END
            default:
                return null;
        }
    }
}

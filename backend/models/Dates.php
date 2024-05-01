<?php

class Dates
{

    public $day;
    public $startTime;
    public $endTime;
    public $persons;

    function __construct($day, $startTime, $endTime, $persons)
    {
        
        $this->day = $day;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->persons = $persons;
    }
}

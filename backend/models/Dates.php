<?php

class Dates
{
    public $id;
    public $day;
    public $startTime;
    public $endTime;
    public $persons;

    function __construct($id, $day, $startTime, $endTime, $persons)
    {
        $this->id = $id;
        $this->day = $day;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->persons = $persons;
    }
}

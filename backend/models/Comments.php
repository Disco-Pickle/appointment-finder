<?php
class Comments{
    public $id;
    public $day;
    public $startime;
    public $endtime;
    public $persons;
    function __construct($id, $day, $startime, $endtime, $persons){
        $this->id = $id;
        $this->day = $day;
        $this->startime = $startime;
        $this->endtime = $endtime;
        $this->persons = $persons;
    }
}
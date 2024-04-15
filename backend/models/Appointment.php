<?php
class Appointment {
    public $day;
    public $month;
    public $year;
    public $startTime;
    public $endTime;

    function __construct($d, $m, $y, $start, $end) {
        $this->day = $d;
        $this->month = $m;
        $this->year = $y;
        $this->startTime = $start;
        $this->endTime = $end;
      }
}
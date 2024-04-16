<?php
class Appointment 
{
  public $day;
  public $month;
  public $year;
  public $startTime;
  public $endTime;
  public $expired;

  function __construct($d, $m, $y, $start, $end, $exp) 
  {
    $this->day = $d;
    $this->month = $m;
    $this->year = $y;
    $this->startTime = $start;
    $this->endTime = $end;
    $this->expired = $exp;
  }
}

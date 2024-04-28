<?php
class Appointment
{
  public $author;
  public $name;
  public $expired;
  public $dates;

  function __construct($author, $name, $expired, $dates)
  {
    $this->author = $author;
    $this->name = $name;
    $this->expired = $expired;
    $this->dates = $dates;
  }
}
?>
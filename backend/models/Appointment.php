<?php
class Appointment
{
  public $author;
  public $name;
  public $dates;

  function __construct($author, $name, $dates)
  {
    $this->author = $author;
    $this->name = $name;
    $this->dates = $dates;
  }
}
?>
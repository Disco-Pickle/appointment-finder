<?php
class Comments{
    public $name;
    public $commentString;
    public $appointmentId_fk;
    function __construct( $name, $commentString, $appointmentId_fk ){
        $this->name = $name;
        $this->commentString = $commentString;
        $this->appointmentId_fk = $appointmentId_fk;
    }
}
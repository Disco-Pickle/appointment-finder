<?php
class Person {

    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $department;
    public $password;

    function __construct($fn, $ln, $mail, $phone, $dept, $password) {
       
        $this->firstname = $fn;
        $this->lastname = $ln;
        $this->email = $mail;
        $this->phone = $phone;
        $this->department = $dept;
        $this->password = $password;
    }
}
?>

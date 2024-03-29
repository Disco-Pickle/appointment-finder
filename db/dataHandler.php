<?php
include("./models/person.php");
class DataHandler
{
    private $db;

    function __construct()
    {
        $this->db = new mysqli('localhost:3306', 'root', 'ourpassword', 'database');
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function queryPersons()
    {
        $result = $this->db->query("SELECT * FROM doodle");
        $persons = [];
        while ($row = $result->fetch_assoc()) {
            $persons[] = new Person($row['id'], $row['firstname'], $row['lastname'], $row['email'], $row['phone'], $row['department']);
        }
        return $persons;
    }

    public function queryPersonById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM persons WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $persons = [];
        while ($row = $result->fetch_assoc()) {
            $persons[] = new Person($row['id'], $row['firstname'], $row['lastname'], $row['email'], $row['phone'], $row['department']);
        }
        return $persons;
    }

    public function queryPersonByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM persons WHERE lastname LIKE ?");
        $name = "%".$name."%";
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $persons = [];
        while ($row = $result->fetch_assoc()) {
            $persons[] = new Person($row['id'], $row['firstname'], $row['lastname'], $row['email'], $row['phone'], $row['department']);
        }
        return $persons;
    }
}
?>

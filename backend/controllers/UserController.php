<?php // UserController.php

// Include the Database.php for database connection
require_once '../utilities/Database.php';

class UserController
{
    private $db;

    //------------------------------------Contructor
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    //-------------------------------------------
    //----------------------------------------------------------------------Register
    public function register($firstname, $lastname, $email, $phone, $department, $password)
    {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO Person (firstname, lastname, email, phone, department, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$firstname, $lastname, $email, $phone, $department, $hashed_password]);
    }
    //----------------------------------------------------------------------

        //----------------------------------------------------------------------Login
    public function login($username, $password)
    {

        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;

            header("Location: /path/to/dashboard");
        } else {
            // Handle login failure
            echo "Invalid username or password.";
        }
    }
        //---------------------------------------------------------

    
        //----------------------------------------------------Handle Request
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action']) && $_POST['action'] == 'register') {

                $this->register($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phone'], $_POST['department'], $_POST['password']);
            } elseif (isset($_POST['action']) && $_POST['action'] == 'login') {
                $this->login($_POST['username'], $_POST['password']);
            }
        }
    }
}


$controller = new UserController();
$controller->handleRequest();

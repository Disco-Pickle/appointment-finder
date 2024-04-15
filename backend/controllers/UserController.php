<?php // UserController.php

// Include the Database.php for database connection
require_once '../utilities/Database.php';

class UserController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function register($firstname, $lastname, $email, $phone, $department, $password) {
        // Validate input and hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Prepare the SQL statement
        $stmt = $this->db->prepare("INSERT INTO Person (firstname, lastname, email, phone, department, password) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Execute the statement with the user data
        $stmt->execute([$firstname, $lastname, $email, $phone, $department, $hashed_password]);
    }
    
    public function login($username, $password) {
        // Prepare the SQL statement
        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Start the session and set session variables
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            // Redirect to the user dashboard or homepage
            header("Location: /path/to/dashboard");
        } else {
            // Handle login failure
            echo "Invalid username or password.";
        }
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action']) && $_POST['action'] == 'register') {
             $this->register( $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phone'], $_POST['department'], $_POST['password']);
            } elseif (isset($_POST['action']) && $_POST['action'] == 'login') {
                $this->login($_POST['username'], $_POST['password']);
            }
        }
    }
}

// Create a new instance of UserController
$controller = new UserController();
// Call the handleRequest method to handle the POST request
$controller->handleRequest();

?>
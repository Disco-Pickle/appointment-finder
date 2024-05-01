<?php
require_once("../utilities/Database.php");

class CommentsController
{

    private $db;
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    public function insertComment($payload) {
    $this->db->beginTransaction();
    try {
        $stmt = $this->db->prepare('INSERT INTO comments (name, commentString, appointmentId_fk) VALUES (?, ?, ?)');
        $stmt->execute([$payload["name"], $payload["commentString"], $payload["appointmentId"]]);
        $this->db->commit();
        return ['message' => 'Comment added', 'appointmentId' => $payload["appointmentId"] ];
    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
}
public function getComments($appointmentId) {
    try {
        // Prepare the SQL statement
        $stmt = $this->db->prepare('SELECT * FROM comments WHERE appointmentId_fk = ?');

        // Execute the statement with the appointment ID
        $stmt->execute([$appointmentId]);

        // Fetch all comments
        $comments = $stmt->fetchAll();

        return ['message' => 'Comments fetched', 'appointmentId' => $appointmentId, 'comments' => $comments];
    } catch (Exception $e) {
        throw $e;
    }
}
}
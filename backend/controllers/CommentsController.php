<?php
require_once("../utilities/Database.php");
require_once("../models/Comments.php");
class CommentsController
{

    private $db;
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    
    //inser using object
    public function insertComment($payload) {
    $this->db->beginTransaction();
    try {
        $stmt = $this->db->prepare('INSERT INTO comments (name, commentString, appointmentId_fk) VALUES (?, ?, ?)');
        $comment=new Comments($payload['name'],$payload['commentString'],$payload['appointmentId']);
        $stmt->execute([$comment->name,$comment->commentString,$comment->appointmentId_fk]);
        $this->db->commit();
        return ['message' => 'Comment added', 'appointmentId' => $payload["appointmentId"] ];
    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
}
public function getComments($appointmentId) {
    try {
        $stmt = $this->db->prepare('SELECT * FROM comments WHERE appointmentId_fk = ?');
        $stmt->execute([$appointmentId]);
        $comments = $stmt->fetchAll();
        return ['message' => 'Comments fetched', 'appointmentId' => $appointmentId, 'comments' => $comments];
    } catch (Exception $e) {
        throw $e;
    }
}
}
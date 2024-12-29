<?php
include_once 'User.php';

class Admin extends User {

    public function __construct($dbConnection) {
        parent::__construct($dbConnection);
    }


    public function getAllUsers() {

        $sql = "SELECT * FROM users"; 
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllReservations() {

        $sql = "SELECT * FROM reservations";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<?php
include_once 'User.php';

class Client extends User {

    public function __construct($dbConnection) {
        parent::__construct($dbConnection);
    }

    public function getClientReservations() {
        $sql = "SELECT * FROM reservations WHERE client_id = :client_id"; 
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':client_id', $this->email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to delete or ban a client (change their role to 'banned')
    public function deleteClient($client_id) {
        // Update the client's role to 'banned' (for banning) or delete them
        $sql = "UPDATE users SET role = 'banned' WHERE id = :client_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':client_id', $client_id);
        return $stmt->execute();
    }
}
?>

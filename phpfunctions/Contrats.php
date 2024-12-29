<?php
class Contrat {
    private $conn;

    // Contract properties
    public $id;
    public $user_id;
    public $car_id;
    public $start_date;
    public $end_date;
    public $total;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to add a contract
    public function addContrat() {
        // SQL query to insert a new contract
        $sql = "INSERT INTO contracts (User_ID, Car_ID, Start_Date, End_Date, Total) 
                VALUES (:client_id, :car_id, :start_date, :end_date, :total)";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters to avoid SQL injection
        $stmt->bindParam(':client_id', $this->user_id);
        $stmt->bindParam(':car_id', $this->car_id);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);
        $stmt->bindParam(':total', $this->total);

        // Execute the query
        return $stmt->execute();
    }

    // Method to fetch all contracts
    public function getContrats() {
        $sql = "SELECT r.ID, u.username AS client_name, v.modele AS car_model, r.Start_Date, r.End_Date, r.Total 
                FROM contracts r 
                JOIN users u ON r.User_ID = u.id 
                JOIN Voitures v ON r.Car_ID = v.num_immatriculation";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to delete a contract
    public function deleteContrat($id) {
        // SQL query to delete a contract by ID
        $sql = "DELETE FROM contracts WHERE ID = :id";
        $stmt = $this->conn->prepare($sql);


        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }
}
?>

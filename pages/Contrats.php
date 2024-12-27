<?php
class Contrat {
    private $conn;
    private $table = 'contracts';
    public $id;
    public $user_id;
    public $car_id;
    public $start_date;
    public $end_date;
    public $total;

    // Constructor to initialize the connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Add a new contract
    public function addContrat() {

        $sql = "INSERT INTO " . $this->table . " (User_ID, Car_ID, Start_Date, End_Date, Total) 
                VALUES ('$this->user_id', '$this->car_id', '$this->start_date', '$this->end_date', '$this->total')";


        if ($this->conn->query($sql)) {
            return true;
        }

        return false;
    }


    public function getContrats() {
        $sql = "SELECT c.ID, u.username AS client_name, v.modele AS car_model, c.Start_Date, c.End_Date, c.Total 
                FROM " . $this->table . " c
                JOIN users u ON c.User_ID = u.id 
                JOIN Voitures v ON c.Car_ID = v.num_immatriculation";

        $result = $this->conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a specific contract by its ID
    public function getContratById($id) {
        $sql = "SELECT c.ID, u.username AS client_name, v.modele AS car_model, c.Start_Date, c.End_Date, c.Total 
                FROM " . $this->table . " c
                JOIN users u ON c.User_ID = u.id 
                JOIN Voitures v ON c.Car_ID = v.num_immatriculation
                WHERE c.ID = $id";

        $result = $this->conn->query($sql);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    // Delete a contract by its ID
    public function deleteContrat($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE ID = $id";
        return $this->conn->query($sql);
    }
}
?>

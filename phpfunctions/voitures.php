<?php
class Voiture {
    private $conn;
    public $table = "Voitures";

    public $num_immatriculation;
    public $marque;
    public $modele;
    public $annee;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new car
    public function create() {
        if (!empty($this->num_immatriculation) && !empty($this->marque) && !empty($this->modele) && !empty($this->annee)) {
            $query = "INSERT INTO $this->table (num_immatriculation, marque, modele, annee) 
            VALUES (:num_immatriculation, :marque, :modele, :annee)";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':num_immatriculation', $this->num_immatriculation);
            $stmt->bindParam(':marque', $this->marque);
            $stmt->bindParam(':modele', $this->modele);
            $stmt->bindParam(':annee', $this->annee);

            // Execute statement
            if ($stmt->execute()) {
                return true;
            } else {
                // Error during insert
                echo "Error during insert: " . $stmt->errorInfo()[2];
                return false;
            }
        }
        return false;
    }

    // Get all cars
    public function All() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    // Delete a car by num_immatriculation
    public function delete($num_immatriculation) {
        $query = "DELETE FROM $this->table WHERE num_immatriculation = :num_immatriculation";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':num_immatriculation', $num_immatriculation);
        return $stmt->execute();
    }
}
?>

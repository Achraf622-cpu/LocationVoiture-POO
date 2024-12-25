<?php
require "../pages/php.php"; 

if (isset($_GET["id"])) {
    $num_immatriculation = $_GET["id"];


    if (empty($num_immatriculation)) {
        echo "Invalid vehicle ID.";
        exit();
    }


    $stmt = $conn->prepare("DELETE FROM Voitures WHERE num_immatriculation = ?");
    if ($stmt) {
        $stmt->bind_param("s", $num_immatriculation);

        if ($stmt->execute()) {

            header("Location: ../pages/voiture.php");
            exit();
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No vehicle ID provided.";
}
?>

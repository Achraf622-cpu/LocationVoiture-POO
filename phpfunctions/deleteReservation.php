<?php
require "../pages/php.php"; // Include the connection script

if (isset($_GET["id"])) {
    $id = $_GET["id"];


    if (!is_numeric($id)) {
        echo "Invalid ID.";
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM contracts WHERE ID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {

            header("Location: ../pages/reservations.php");
            exit();
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No ID provided.";
}
?>

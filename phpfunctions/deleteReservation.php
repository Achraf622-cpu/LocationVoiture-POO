<?php
include '../pages/php.php';

// Create a new instance of the Database class
$database = new Database();
$conn = $database->getConnection(); // Get the PDO connection

// Check if an ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Prepare SQL query to delete the reservation
    $sql = "DELETE FROM contracts WHERE ID = :reservation_id";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the reservation ID to the query
        $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the reservations page with a success message
            header("Location: ../pages/reservations.php?status=success");
            exit();
        } else {
            // Redirect to the reservations page with an error message
            header("Location: ../pages/reservations.php?status=error");
            exit();
        }
    } catch (PDOException $e) {
        // Handle any errors during the process
        echo "Error: " . $e->getMessage();
    }
} else {
    // If no ID is provided, redirect with an error message
    header("Location: ../pages/reservations.php?status=error");
    exit();
}
?>

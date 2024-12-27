<?php
// deleteClient.php
include('../pages/php.php');
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare and execute the DELETE query
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    
    if ($stmt->execute()) {
        // Redirect back to the clients page after deletion
        header("Location: ../pages/clietns.php");
        exit();
    } else {
        echo "Failed to delete the client.";
    }
} else {
    echo "Invalid request.";
}
?>

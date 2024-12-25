<?php
require "../pages/php.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];

    $stmt = $conn->prepare("DELETE FROM Clients WHERE num_client = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../pages/clietns.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid or missing ID.";
}
?>

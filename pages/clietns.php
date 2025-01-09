<?php
include '../phpfunctions/User.php';  // Include the User class

// Include the database connection
include '../phpfunctions/php.php';  // Assuming 'db.php' contains the database connection setup

session_start();  // Start session to manage messages

// Handle delete action if 'delete_id' is provided in the URL
if (isset($_GET['delete_id'])) {
    $client_id = $_GET['delete_id'];  // Get the client ID from the URL

    // Create an instance of the Client class
    $client = new Client();

    try {
        // Call the deleteClient method
        if ($client->deleteClient($client_id)) {
            $_SESSION['message'] = 'Client banned successfully.';
        } else {
            $_SESSION['message'] = 'Failed to ban client.';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();  // Handle errors
    }

    // After deletion, redirect to the same page to refresh the client list
    header('Location: Clients.php');
    exit();
}

// Fetch all clients from the database
$stmt = $conn->prepare("SELECT id, username, email FROM users WHERE role = 'client'");
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients Page</title>
    <link rel="stylesheet" href="../style/clients.css">
</head>
<body>
    <div class="container">
        <?php include('../layout/_HEAD.php'); ?>

        <!-- Client List -->
        <main class="main-content">
            <header class="header">
                <h1 class="header-title">Informations client</h1>
                <p class="header-date">Date: <?php echo date('d/m/Y'); ?></p>
            </header>

            <!-- Feedback Message -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert">
                    <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']); 
                    ?>
                </div>
            <?php endif; ?>

            <!-- Clients Table -->
            <section class="clients-table-section">
                <h2 class="table-title">Liste des Clients</h2>
                <table class="clients-table">
                    <thead class="table-head">
                        <tr class="table-row">
                            <th class="table-header">ID</th>
                            <th class="table-header">Nom</th>
                            <th class="table-header">Email</th>
                            <th class="table-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        <?php if (count($clients) > 0): ?>
                            <?php foreach ($clients as $client): ?>
                                <tr class='table-row'>
                                    <td class='table-data'><?= htmlspecialchars($client['id']); ?></td>
                                    <td class='table-data'><?= htmlspecialchars($client['username']); ?></td>
                                    <td class='table-data'><?= htmlspecialchars($client['email']); ?></td>
                                    <td class='table-data'>
                                        <a href='Clients.php?delete_id=<?= htmlspecialchars($client['id']); ?>' 
                                           class='btn btn-delete' 
                                           onclick="return confirm('Are you sure you want to ban this client?');">
                                           Supprimer
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="table-data">Aucun client trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>

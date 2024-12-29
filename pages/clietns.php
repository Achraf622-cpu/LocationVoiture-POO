<?php
include '../phpfunctions/php.php'; 
include '../phpfunctions/User.php'; 
include '../phpfunctions/Clients.php'; 

session_start();

// Create a new instance of the Client class
$database = new Database();
$conn = $database->getConnection();
$client = new Client($conn);

// Check if a client needs to be deleted (banned)
if (isset($_GET['delete_id'])) {
    $client_id = $_GET['delete_id']; // Get the client ID from the URL
    
    if ($client->deleteClient($client_id)) {
        $_SESSION['message'] = 'Client banned successfully.';
    } else {
        $_SESSION['message'] = 'Failed to ban client.';
    }
    header('Location: Clients.php'); // Redirect back to the Clients page
    exit();
}

// Fetch all clients from the database
$stmt = $conn->prepare("SELECT * FROM users WHERE role = 'client'");
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
        <?php include('../layout/_HEAD.php') ?>

        <!-- Client List -->
        <main class="main-content">
            <header class="header">
                <h1 class="header-title">Informations client</h1>
                <p class="header-date">Date: <?php echo date('d/m/Y'); ?></p>
            </header>

            <!-- Clients Table -->
            <section class="clients-table-section">
                <h2 class="table-title">Liste des Clients</h2>
                <table class="clients-table">
                    <thead class="table-head">
                        <tr class="table-row">
                            <th class="table-header">ID</th>
                            <th class="table-header">Nom</th>
                            <th class="table-header">Téléphone</th>
                            <th class="table-header">Email</th>
                            <th class="table-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        <?php
                        if (count($clients) > 0) {
                            foreach ($clients as $client) {
                                echo "
                                    <tr class='table-row'>
                                        <td class='table-data'>{$client['id']}</td>
                                        <td class='table-data'>{$client['username']}</td>
                                        <td class='table-data'>{$client['email']}</td>
                                        <td class='table-data'>
                                            <a href='Clients.php?delete_id={$client['id']}' class='btn btn-delete'>Supprimer</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='table-data'>Aucun client trouvé.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>

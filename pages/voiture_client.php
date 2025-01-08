<?php
include '../phpfunctions/php.php';
include '../phpfunctions/voitures.php';

// Initialize the database and voiture classes
$db = new Database();
$voiture = new Voiture($db->getConnection());

// Handle form submission to add a car




// Fetch all cars
$cars = $voiture->getAll(); // Use the getAll method to fetch the cars

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voiture Page</title>
    <link rel="stylesheet" href="../style/clients.css">
</head>
<body>
    <div class="container">
    <?php include('../layout/_HEAD_client.php') ?>

    <main class="main-content">
        <header class="header">
            <h1 class="header-title">Informations Voiture</h1>
            <p class="header-date">Date: 27/12/2020</p>
        </header>

     
        <!-- Displaying the list of cars -->
        <section class="clients-table-section">
            <h2 class="table-title">Liste des Voitures</h2>
            <table class="clients-table">
                <thead class="table-head">
                    <tr class="table-row">
                        <th class="table-header">Numéro d'immatriculation</th>
                        <th class="table-header">Marque</th>
                        <th class="table-header">Modèle</th>
                        <th class="table-header">Année</th>
                
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php
                    // Check if there are any cars and display them
                    if ($cars->rowCount() > 0) {
                        // Fetch each car and display in the table
                        while ($row = $cars->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr class='table-row'>
                                    <td class='table-data'>{$row['num_immatriculation']}</td>
                                    <td class='table-data'>{$row['marque']}</td>
                                    <td class='table-data'>{$row['modele']}</td>
                                    <td class='table-data'>{$row['annee']}</td>
                                    
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='table-data'>Aucune voiture trouvée.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

    </main>
    </div>
</body>
</html>

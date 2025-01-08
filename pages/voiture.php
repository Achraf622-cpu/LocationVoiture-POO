<?php
include '../phpfunctions/php.php';
include '../phpfunctions/voitures.php';


$db = new Database();
$voiture = new Voiture($db->conn);


if (isset($_POST['add-voiture'])) {
    // Capture form data
    $voiture->num_immatriculation = $_POST['num_immatriculation'];
    $voiture->marque = $_POST['marque'];
    $voiture->modele = $_POST['modele'];
    $voiture->annee = $_POST['annee'];

    // Check if the form is properly filled out
    if (!empty($voiture->num_immatriculation) && !empty($voiture->marque) && !empty($voiture->modele) && !empty($voiture->annee)) {
        if ($voiture->create()) {
            $_SESSION['success'] = "Voiture ajoutée avec succès!";
        } else {
            $_SESSION['error'] = "Erreur lors de l'ajout de la voiture.";
        }
    } else {
        $_SESSION['error'] = "Tous les champs sont obligatoires!";
    }
}

// Handle car deletion
if (isset($_GET['delete'])) {
    $num_immatriculation = $_GET['delete'];
    if ($voiture->delete($num_immatriculation)) {
        $_SESSION['success'] = "Voiture supprimée avec succès!";
    } else {
        $_SESSION['error'] = "Erreur lors de la suppression de la voiture.";
    }
}

// Fetch all cars
$cars = $voiture->All(); // Use the getAll method to fetch the cars

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
    <?php include('../layout/_HEAD.php') ?>

    <main class="main-content">
        <header class="header">
            <h1 class="header-title">Informations Voiture</h1>
            <p class="header-date">Date: 27/12/2020</p>
        </header>

        <!-- Form to add a car -->
        <section class="client-form-section">
            <form class="client-form" method="POST" action="voiture.php">
                <div class="form-group">
                    <label for="num_immatriculation" class="form-label">Numéro d'immatriculation</label>
                    <input type="text" id="num_immatriculation" name="num_immatriculation" class="form-input" placeholder="Matricule" required>
                </div>
                <div class="form-group">
                    <label for="marque" class="form-label">Marque</label>
                    <input type="text" id="marque" name="marque" class="form-input" placeholder="Marque" required>
                </div>
                <div class="form-group">
                    <label for="modele" class="form-label">Modèle</label>
                    <input type="text" id="modele" name="modele" class="form-input" placeholder="Modèle" required>
                </div>
                <div class="form-group">
                    <label for="annee" class="form-label">Année</label>
                    <input type="text" id="annee" name="annee" class="form-input" placeholder="Année" required>
                </div>
                <input type="submit" value="Enregistrer" name="add-voiture" class="btn btn-save">
            </form>
        </section>

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
                        <th class="table-header">Actions</th>
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
                                    <td class='table-data'>
                                        <a href='?delete={$row['num_immatriculation']}' class='btn btn-delete'>Supprimer</a>
                                    </td>
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

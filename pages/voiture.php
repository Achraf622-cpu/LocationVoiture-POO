<?php
include 'php.php';

if (isset($_POST['add-voiture'])) {  
    $num_immatriculation = $_POST['num_immatriculation'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    if(!empty($num_immatriculation) && !empty($marque) && !empty($modele) && !empty($annee)){
        $sql = "INSERT INTO Voitures (num_immatriculation, marque, modele, annee) 
        VALUES ('$num_immatriculation', '$marque', '$modele', '$annee')";
        mysqli_query($conn, $sql);
    }

   
    
    
    

  
}
$sql = "SELECT * FROM Voitures";
$result = mysqli_query($conn, $sql);




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
    <?php  include('../layout/_HEAD.php') ?>

      

            <!-- Client Form -->
            <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1 class="header-title">Informations voiture</h1>
                <p class="header-date">Date: 27/12/2020</p>
            </header>

            <!-- Client Form -->
            <section class="client-form-section">
 <form class="client-form" method="POST" action="voiture.php">
        <div class="form-group">
            <label for="num_immatriculation" class="form-label">num_immatriculation</label>
            <input type="text" id="client-name" name="num_immatriculation" class="form-input" placeholder="matricule" require>
        </div>
        <div class="form-group">
            <label for="marque" class="form-label">marque</label>
            <input type="text" id="phone" name="marque" class="form-input" placeholder="marque" require>
        </div>
        <div class="form-group">
            <label for="modelle" class="form-label">modele</label>
            <input type="text" id="email" name="modele" class="form-input" placeholder="modele" require>
        </div>
        <div class="form-group">
            <label for="anneee" class="form-label">annee</label>
            <input type="text" id="annee" name="annee" class="form-input" placeholder="annee" require>
        </div>
        <!-- Save button to add client -->
        <input type="submit" value="Enregistrer" name="add-voiture" class="btn btn-save" require>
        
        <!-- Delete button to delete client -->
        
    </form>

  
</section>


            <!-- Clients Table -->
            <section class="clients-table-section">
                <h2 class="table-title">Liste denum_immatriculations Clients</h2>
                <!-- Clients Table -->
<table class="clients-table">
    <thead class="table-head">
        <tr class="table-row">
            
            <th class="table-header">num_immatriculation</th>
            <th class="table-header">marque</th>
            <th class="table-header">modele</th>
            <th class="table-header">annee</th>
            <th class="table-header">Del</th>
        </tr>
    </thead>
    <tbody class="table-body">
        <?php
        // Loop through the results and display them in the table
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
        <tr class='table-row'>
        <td class='table-data'>{$row['num_immatriculation']}</td>
        <td class='table-data'>{$row['marque']}</td>
        <td class='table-data'>{$row['modele']}</td>
        <td class='table-data'>{$row['annee']}</td>
    <td class='table-data'>
        <a href='../phpfunctions/deletVoiture.php?id={$row['num_immatriculation']}' class='btn btn-delete'>Supprimer</a>
    </td>
</tr>";

            }
        } else {
            echo "<tr><td colspan='5' class='table-data'>Aucun voiture trouvé.</td></tr>";
        }
        ?>
    </tbody>
</table>
            </section>
        </main>
    </div>
</body>
</html>

<?php
include 'php.php';

if (isset($_POST['add-client'])) {  
    $nom = $_POST['client-name'];
    $adresse = $_POST['email'];
    $num_telephone = $_POST['phone'];
    
    if(!empty($nom) && !empty($adresse) && !empty($num_telephone)){
        $sql = "INSERT INTO Clients (num_client,nom, adresse, num_telephone) 
        VALUES (null,'$nom', '$adresse', '$num_telephone')";
        mysqli_query($conn, $sql);
    }
  
}
$sql = "SELECT * FROM Clients";
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
 <form class="client-form" method="POST" action="clietns.php">
        <div class="form-group">
            <label for="client-name" class="form-label">Name</label>
            <input type="text" id="client-name" name="client-name" class="form-input" placeholder="Nom du client" require>
        </div>
        <div class="form-group">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" id="phone" name="phone" class="form-input" placeholder="0612345678" require>
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="exemple@email.com" require>
        </div>
        
        <!-- Save button to add client -->
        <input type="submit" value="Enregistrer" name="add-client" class="btn btn-save" require>
        
        <!-- Delete button to delete client -->
        
    </form>

  
</section>


            <!-- Clients Table -->
            <section class="clients-table-section">
                <h2 class="table-title">Liste des Clients</h2>
                <!-- Clients Table -->
<table class="clients-table">
    <thead class="table-head">
        <tr class="table-row">
            <th class="table-header">ID</th>
            <th class="table-header">Nom</th>
            <th class="table-header">Téléphone</th>
            <th class="table-header">Email</th>
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
        <td class='table-data'>{$row['num_client']}</td>
        <td class='table-data'>{$row['nom']}</td>
        <td class='table-data'>{$row['num_telephone']}</td>
        <td class='table-data'>{$row['adresse']}</td>
    <td class='table-data'>
        <a href='../phpfunctions/deleteClient.php?id={$row['num_client']}' class='btn btn-delete'>Supprimer</a>
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

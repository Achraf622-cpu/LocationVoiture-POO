<?php
include './php.php';
include 'Contrats.php';
session_start();


$database = new Database();
$conn = $database->getConnection();

// Create a new instance of the Contrat class
$contrat = new Contrat($conn);

// Handle the form submission for adding a reservation (contract)
if (isset($_POST['add-reservation'])) {
    // Get the form data
    $contrat->user_id = $_POST['client-id']; // Client ID
    $contrat->car_id = $_POST['car-id']; // Car ID
    $contrat->start_date = $_POST['start-date']; // Start Date
    $contrat->end_date = $_POST['end-date']; // End Date
    $contrat->total = $_POST['total']; // Total amount

}

// Fetch data for the dropdowns (clients and cars)
$clients_sql = "SELECT id, username FROM users WHERE role = 'client'"; // Updated query
$clients_stmt = $conn->prepare($clients_sql);
$clients_stmt->execute();
$clients_result = $clients_stmt->fetchAll(PDO::FETCH_ASSOC);

$cars_sql = "SELECT num_immatriculation, modele FROM Voitures";
$cars_stmt = $conn->prepare($cars_sql);
$cars_stmt->execute();
$cars_result = $cars_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch existing reservations using the Contrat class
$reservations_result = $contrat->getContrats(); // Using the getContrats method from Contrat class
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="../style/reservations.css">
</head>
<body>
    <div class="container">
        <?php include('../layout/_HEAD.php'); ?>

        <main class="main-content">
            <header class="header">
                <h1>Reservations</h1>
                <p>Date: <?php echo date('d/m/Y'); ?></p>
            </header>

            <!-- Reservation Form -->
            <section class="reservation-form-section">
                <form method="POST" action="reservations.php">
                    <div class="form-group">
                        <label for="client-id">Client</label>
                        <select id="client-id" name="client-id" required>
                            <option value="" disabled selected>Select Client</option>
                            <?php foreach ($clients_result as $client) {
                                echo "<option value='{$client['id']}'>{$client['username']}</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="car-id">Car</label>
                        <select id="car-id" name="car-id" required>
                            <option value="" disabled selected>Select Car</option>
                            <?php foreach ($cars_result as $car) {
                                echo "<option value='{$car['num_immatriculation']}'>{$car['modele']}</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start-date">Start Date</label>
                        <input type="date" id="start-date" name="start-date" required>
                    </div>
                    <div class="form-group">
                        <label for="end-date">End Date</label>
                        <input type="date" id="end-date" name="end-date" required>
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" id="total" name="total" step="0.01" required>
                    </div>
                    <button type="submit" name="add-reservation">Add Reservation</button>
                </form>
            </section>

            <!-- Reservations Table -->
            <section class="reservations-table-section">
                <h2>Reservations</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Car</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations_result as $reservation) {
                            echo "
                                <tr>
                                    <td>{$reservation['ID']}</td>
                                    <td>{$reservation['client_name']}</td>
                                    <td>{$reservation['car_model']}</td>
                                    <td>{$reservation['Start_Date']}</td>
                                    <td>{$reservation['End_Date']}</td>
                                    <td>{$reservation['Total']}</td>
                                    <td><a href='../phpfunctions/deleteReservation.php?id={$reservation['ID']}' class='btn btn-delete'>Delete</a></td>
                                </tr>";
                        } ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>

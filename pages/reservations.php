<?php
include 'php.php'; // Include your database connection file

if (isset($_POST['add-reservation'])) {  
    $client_id = $_POST['client-id']; // Get Client ID from form
    $car_id = $_POST['car-id']; // Get Car ID from form
    $start_date = $_POST['start-date']; // Get Start Date
    $end_date = $_POST['end-date']; // Get End Date
    $total = $_POST['total']; // Get Total (if manually entered)

    if (!empty($client_id) && !empty($car_id) && !empty($start_date) && !empty($end_date) && !empty($total)) {
        // Insert into contracts table
        $sql = "INSERT INTO contracts (Client_ID, Car_ID, Start_Date, End_Date, Total) 
                VALUES ('$client_id', '$car_id', '$start_date', '$end_date', '$total')";
        mysqli_query($conn, $sql);
    }
}

// Fetch data for the dropdowns
$clients_sql = "SELECT num_client, nom FROM Clients";
$clients_result = mysqli_query($conn, $clients_sql);

$cars_sql = "SELECT num_immatriculation, modele FROM Voitures";
$cars_result = mysqli_query($conn, $cars_sql);

// Fetch existing reservations
$reservations_sql = "
    SELECT r.ID, c.nom AS client_name, v.modele AS car_model, r.Start_Date, r.End_Date, r.Total 
    FROM contracts r 
    JOIN Clients c ON r.Client_ID = c.num_client 
    JOIN Voitures v ON r.Car_ID = v.num_immatriculation";
$reservations_result = mysqli_query($conn, $reservations_sql);
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
                            <?php while ($client = mysqli_fetch_assoc($clients_result)) {
                                echo "<option value='{$client['num_client']}'>{$client['nom']}</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="car-id">Car</label>
                        <select id="car-id" name="car-id" required>
                            <option value="" disabled selected>Select Car</option>
                            <?php while ($car = mysqli_fetch_assoc($cars_result)) {
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
                        <?php while ($reservation = mysqli_fetch_assoc($reservations_result)) {
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

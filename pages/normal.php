<?php
session_start();

// Ensure the user is logged in and has a 'client' role
// if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'client') {
//     header("Location: login.php");
//     exit();
// }

include_once 'php.php';
include_once 'clients.php';

// Initialize Database and Client class
try {
    $db = new Database();
    $conn = $db->getConnection();
    $client = new Client($conn);
} catch (Exception $e) {
    die("Error initializing application: " . $e->getMessage());
}

// Debug: Turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch data for cars (mocked for now; replace with actual database table query)
try {
    $stmt = $conn->prepare("SELECT * FROM cars");
    $stmt->execute();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching cars: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/normal.css">
    <title>Cars Page</title>
</head>
<body>
    <div class="container">
        <?php include('../layout/_HEAD.php'); ?>

        <header class="header">
            <h1>Cars Available</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</p>
        </header>

        <main class="main-content">
            <section class="cars-list">
                <h2>List of Cars</h2>
                <?php if (!empty($cars)): ?>
                    <table class="cars-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Model</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($car['id']); ?></td>
                                    <td><?php echo htmlspecialchars($car['name']); ?></td>
                                    <td><?php echo htmlspecialchars($car['model']); ?></td>
                                    <td><?php echo htmlspecialchars($car['price']); ?></td>
                                    <td>
                                        <form action="requestCar.php" method="POST">
                                            <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                            <button type="submit" class="btn">Request</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No cars available at the moment.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>

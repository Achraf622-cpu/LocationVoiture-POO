<?php
session_start();
include 'php.php';  // Include database connection
include 'User.php'; // Include User class

// Initialize the user class (no arguments needed)
$user = new Client();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user-register'])) {
    try {
        // Collect and sanitize user inputs
        $email = trim($_POST['user-email']);
        $password1 = trim($_POST['user_password1']);
        $password2 = trim($_POST['user_password2']);
        
        // Attempt registration
        $user->register($email, $password1, $password2);

        // If registration is successful
        $_SESSION['success'] = "Registration successful! You can now log in.";
        header("Location: ../pages/login.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();  // Store error message in session
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/login.css">
    <title>Signup</title>
</head>
<body>
    <div class="container">
        <input type="checkbox" id="check">
        <div class="registration form">
            <header>Signup</header>
            <form action="" method="POST">
                <!-- Display error messages -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error">
                        <?php
                            echo htmlspecialchars($_SESSION['error']);
                            unset($_SESSION['error']); // Clear error after displaying it
                        ?>
                    </div>
                <?php endif; ?>

                <input type="email" id="user-email" name="user-email" placeholder="Enter your email" required>
                <input type="password" id="user_password1" name="user_password1" placeholder="Enter your password" required>
                <input type="password" id="user_password2" name="user_password2" placeholder="Confirm your password" required>
                
                <input type="submit" class="button" name="user-register" value="Register">
            </form>
            <div class="signup">
                <span class="signup">Already have an account? <a href="../pages/login.php">Login</a></span>
            </div>
        </div>
    </div>
</body>
</html>

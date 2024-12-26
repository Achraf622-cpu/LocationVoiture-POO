<?php
session_start();
include 'php.php';
include 'User.php';

// Initialize the database and user class
$db = new Database();
$user = new User($db->getConnection());

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user-login'])) {
    try {
        // Get user inputs
        $email = trim($_POST['user-email']);
        $password = trim($_POST['user_password']);

        // Attempt login
        $loggedInUser = $user->login($email, $password);

        // Set session data
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['user_email'] = $loggedInUser['email'];
        $_SESSION['user_role'] = ($loggedInUser['role_id'] == 1) ? 'admin' : 'user';

        // Redirect based on role
        if ($_SESSION['user_role'] === 'admin') {
            header("Location: admin_home.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } catch (Exception $e) {
        // Store the error message in the session
        $_SESSION['error'] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/login.css">
  <title>Login</title>
</head>
<body>
  <div class="container">
    <div class="login form">
      <header>Login</header>

      <!-- Display error messages -->
      <?php if (isset($_SESSION['error'])): ?>
        <div class="error">
          <?php 
            echo htmlspecialchars($_SESSION['error']);
            unset($_SESSION['error']); // Clear error after displaying it
          ?>
        </div>
      <?php endif; ?>

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="email" id="user-email" name="user-email" placeholder="Enter your email" required>
        <input type="password" id="user_password" name="user_password" placeholder="Enter your password" required>
        <input type="submit" class="button" name="user-login" value="Login">
      </form>
      <div class="signup">
        <span>Don't have an account? <a href="register.php">Signup</a></span>
      </div>
    </div>
  </div>
</body>
</html>
<?php
class User {
    protected $db;
    public $email;
    protected $password;
    protected $role; // Changed to protected

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
        $this->email = $email;
    }

    // Method to set and hash the password with validation
    public function setPassword($password) {
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long.");
        }
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Method to set the role
    public function setRole($role) {
        $validRoles = ['admin', 'user']; // Define valid roles
        if (!in_array($role, $validRoles)) {
            throw new Exception("Invalid role. Valid roles are: " . implode(", ", $validRoles));
        }
        $this->role = $role;
    }

    // Login method
    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                return $user;  // Return user data
            } else {
                throw new Exception("Invalid password.");
            }
        } else {
            throw new Exception("No account found with this email.");
        }
    }

public function register($email, $password1, $password2, $role = 'client') {
    // Validate role
    $validRoles = ['admin', 'client'];
    if (!in_array($role, $validRoles)) {
        throw new Exception("Invalid role. Valid roles are: " . implode(", ", $validRoles));
    }

    if ($password1 !== $password2) {
        throw new Exception("Passwords do not match.");
    }

    // Hash password
    $user_password = password_hash($password1, PASSWORD_BCRYPT);  
    $username = strstr($email, '@', true); 

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        throw new Exception("Email is already registered.");
    }

    // Insert user into the database with role
    $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $user_password, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);

    if ($stmt->execute()) {
        return true;  // Registration successful
    } else {
        throw new Exception("An error occurred during registration.");
    }
}

}
?>

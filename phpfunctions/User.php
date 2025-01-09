<?php
class Client {
    public $email;
    protected $password;

    // Set the email after validating it
    public function Email($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
        $this->email = $email;
    }

    // Set the password with hashing
    public function setPassword($password) {
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long.");
        }
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Login method to verify email and password
    public function login($email, $password) {
        global $conn;  // Use the global connection
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
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

    // Register a new user
    public function register($email, $password1, $password2) {
        global $conn;  // Use the global connection

        if ($password1 !== $password2) {
            throw new Exception("Passwords do not match.");
        }

        $user_password = password_hash($password1, PASSWORD_BCRYPT);
        $username = strstr($email, '@', true);  // Use the part before '@' as username

        // Check if the email already exists
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            throw new Exception("Email is already registered.");
        }

        // Insert the new user into the database without the role field
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $user_password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("An error occurred during registration.");
        }
    }

    // Delete a voiture by num_immatriculation
    public function deleteVoiture($num_immatriculation) {
        global $conn;  // Use the global connection
        $sql = "DELETE FROM voitures WHERE num_immatriculation = :num_immatriculation";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':num_immatriculation', $num_immatriculation, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Failed to delete voiture.");
        }
    }

    // Delete a client by email
    public function deleteClient($email) {
        global $conn;  // Use the global connection
        $sql = "DELETE FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Failed to delete client.");
        }
    }

    // Delete a contrat by id
    public function deleteContrat($id) {
        global $conn;  // Use the global connection
        $sql = "DELETE FROM contrats WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Failed to delete contrat.");
        }
    }

}
?>

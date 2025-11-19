<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password != $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if username already exists
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
        $checkStmt->execute([':username' => $username]);
        $existingUser = $checkStmt->fetch();

        if ($existingUser) {
            $error = "Username already exists!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $insertStmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            
            try {
                $insertStmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $hashed_password,
                ]);

                $_SESSION['message'] = "Registration successful! Please login.";
                header("Location: login.php");
                exit();
            } catch (PDOException $e) {
                if ((int)$e->getCode() === 23505) { // unique_violation in Postgres
                    $error = "Username or email already exists!";
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .container { max-width: 400px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>

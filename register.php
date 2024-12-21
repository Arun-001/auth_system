<?php
require 'includes/header.php';
require 'includes/Database.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->connect();
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $checkQuery = "SELECT * FROM users WHERE email = :email OR username = :username";
        $stmt = $db->prepare($checkQuery);
        $stmt->execute(['email' => $email, 'username' => $username]);

        if ($stmt->rowCount() > 0) {
            $error = "Username or email already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $insertQuery = "INSERT INTO users (username, email, password, created_at) VALUES (:username, :email, :password, NOW())";
            $stmt = $db->prepare($insertQuery);
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword
            ]);
            $success = "User registered successfully!";
        }
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>
<h1>Register</h1>
<form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Register</button>
</form>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php elseif (!empty($success)): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>
<?php
require 'includes/footer.php';
?>

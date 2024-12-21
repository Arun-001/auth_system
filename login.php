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
    
    $email_or_username = $_POST['email_or_username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email = :email_or_username OR username = :email_or_username";
    $stmt = $db->prepare($query);
    $stmt->execute(['email_or_username' => $email_or_username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid login credentials.";
    }
}
?>
<h1>Login</h1>
<form method="POST" action="">
    <label>Email or Username:</label><br>
    <input type="text" name="email_or_username" required><br><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<?php
require 'includes/footer.php';
?>

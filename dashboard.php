<?php
require 'includes/header.php';
require 'includes/auth_check.php';
?>
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
<?php
require 'includes/footer.php';
?>

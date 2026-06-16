<?php
session_start();
include 'db.php'; // Include database connection.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo "<script>
            alert('Log in successfully.');
            setTimeout(function() {
                window.location.href = 'index.php'; // Redirect to index.php after 3 seconds
            }, 1000);
          </script>";
    } else {
        echo "<script>
            alert('Invalid Credentials!!');
            setTimeout(function() {
                window.location.href = 'index.php'; // Redirect to index.php after 3 seconds
            }, 300);
          </script>";
    }
}
?>

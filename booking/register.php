<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    if ($stmt->execute([$username, $password])) {
        echo 'Registration successful.';
    } else {
        echo 'Error during registration.';
    }
}
?>

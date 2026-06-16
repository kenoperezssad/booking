<?php
session_start();
include 'db.php'; // Include database connection.

// Handle form submission logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT * FROM admins WHERE username = ?');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin) {
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
        echo "<script>
            alert('Admin log in successfully.');
            window.location.href = 'admin.php'; // Redirect to admin panel.
        </script>";
    } else {
        echo "Password did not match.";
    }
    } else {
        echo "<script>
            alert('Invalid Access!!');
            window.location.href = 'admin_login.php'; // Redirect back to login page.
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Add basic styling for the form */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        #loginForm {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }
        #loginForm input {
            width: 80%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        #loginForm button {
            width: 85%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        #loginForm button:hover {
            background-color: #0056b3;
        }
        #loginForm a {
            color: #007BFF;
            text-decoration: none;
        }
        #loginForm a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="loginForm">
        <h3>Admin Login</h3>
        <form method="POST" action="admin_login.php">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

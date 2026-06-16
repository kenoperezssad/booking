<?php
// Include database connection
require 'db.php';

// Start the session to store messages
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'] ?? null;
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert employee into the database
        $stmt = $conn->prepare("INSERT INTO employees (first_name, middle_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$first_name, $middle_name, $last_name, $email, $hashed_password]);

        // Success: Show alert and redirect to admin.php
        echo "<script>
                alert('Employee added successfully.');
                setTimeout(function() {
                    window.location.href = 'admin.php'; // Redirect to admin page
                }, 100);
              </script>";
        exit;

    } catch (PDOException $e) {
        // Error: Show alert and stay on the form page
        echo "<script>
                alert('Error: " . htmlspecialchars($e->getMessage()) . "');
                setTimeout(function() {
                    window.location.href = 'add_employee.php'; // Stay on the add employee page
                }, 100);
              </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" />
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6 bg-white shadow-lg rounded-md">
    <h2 class="text-2xl font-bold text-center mb-4">Add New Employee</h2>

    <!-- Employee Form -->
    <form method="POST" action="add_employee.php">
        <div class="mb-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" id="first_name" name="first_name" required class="mt-1 block w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name (Optional)</label>
            <input type="text" id="middle_name" name="middle_name" class="mt-1 block w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" id="last_name" name="last_name" required class="mt-1 block w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" required class="mt-1 block w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" required class="mt-1 block w-full px-4 py-2 border rounded-md">
        </div>

        <div class="flex justify-center space-x-4">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white font-bold rounded-md shadow-md hover:bg-blue-700">
                Add Employee
            </button>
            <a href="admin.php" class="px-6 py-2 bg-gray-500 text-white font-bold rounded-md shadow-md hover:bg-gray-700 text-center">
                Back
            </a>
        </div>
    </form>
</div>

</body>
</html>

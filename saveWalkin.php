<?php
// saveWalkin.php
require 'db.php';

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = trim(htmlspecialchars($_POST['name'] ?? ''));
    $contact = trim($_POST['contact'] ?? '');
    $time = $_POST['time'] ?? '';
    $status = 'Pending';  // Default status for walk-ins

    // Validation checks
    if (empty($name)) {
        echo "<script>
            alert('Name is required.');
            window.history.back();
          </script>";
        exit;
    }

    if (empty($contact) || !preg_match('/^[0-9+\-\s]{7,20}$/', $contact)) {
        echo "<script>
            alert('Please enter a valid contact number.');
            window.history.back();
          </script>";
        exit;
    }

    if (empty($time)) {
        echo "<script>
            alert('Please select a date and time.');
            window.history.back();
          </script>";
        exit;
    }

    try {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("INSERT INTO walkins (name, contact_number, appointment_date, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $contact, $time, $status]);

        echo "<script>
            alert('Walk-in appointment saved successfully.');
            window.location.href = 'index.php';
          </script>";
        exit;

    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo "<script>
            alert('An error occurred. Please try again later.');
            window.history.back();
          </script>";
        exit;
    }
} else {
    // Invalid request method - redirect to home
    header('Location: index.php');
    exit;
}
?>

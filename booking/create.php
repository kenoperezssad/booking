<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data from the form
    $name = $_POST['name'];
    $appointment_date = $_POST['time'];

    // Check which form is being submitted
    if (isset($_POST['contact'])) {
        $contact = $_POST['contact'];
        try {
            $stmt = $conn->prepare("INSERT INTO schedule (name, contact_number, appointment_date) VALUES (?, ?, ?)");
            $stmt->execute([$name, $contact, $appointment_date]);

            header('Location: appointmentList.php');
            exit;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // If contact is not set, it's a walk-in
        $status = 'Pending';
        try {
            $stmt = $conn->prepare("INSERT INTO walkins (name, datetime, status) VALUES (?, ?, ?)");
            $stmt->execute([$name, $appointment_date, $status]);

            header('Location: walkin.php');
            exit;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

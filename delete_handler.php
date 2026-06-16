<?php
require 'db.php';

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set JSON response header
header('Content-Type: application/json');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}
    // Get the action parameter
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($action === 'delete_walkin') {
        // Delete individual walk-in record
        $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : null;

        if ($id) {
            try {
                $stmt = $conn->prepare("DELETE FROM walkins WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Walk-in deleted successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete walk-in.']);
                }
            } catch (PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid walk-in ID.']);
        }
    } elseif ($action === 'delete_all_walkins') {
        // Delete all walk-ins
        try {
            $stmt = $conn->prepare("DELETE FROM walkins");
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'All walk-ins deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete walk-ins.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } elseif ($action === 'delete_appointment') {
        // Delete individual appointment record
        $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : null;

        if ($id) {
            try {
                $stmt = $conn->prepare("DELETE FROM schedule WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Appointment deleted successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete appointment.']);
                }
            } catch (PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid appointment ID.']);
        }
    } elseif ($action === 'delete_all_appointments') {
        // Delete all appointments
        try {
            $stmt = $conn->prepare("DELETE FROM schedule");
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'All appointments deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete appointments.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }
}

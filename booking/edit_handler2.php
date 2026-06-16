<?php
// WALK-INS TABLE EDIT HANDLER (PERSONAL)

// Include the database connection
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and validate inputs
    $input = json_decode(file_get_contents('php://input'), true);

    // Ensure all required fields are present
    if (!isset($input['id'], $input['name'], $input['contact_number'], $input['appointment_date'], $input['status'], $input['action'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Sanitize inputs to prevent XSS and other security risks
    $id = htmlspecialchars($input['id']);
    $name = htmlspecialchars($input['name']);
    $contact = htmlspecialchars($input['contact_number']);
    $date = htmlspecialchars($input['appointment_date']);
    $status = htmlspecialchars($input['status']);
    $action = htmlspecialchars($input['action']);

    // Table name (in this case, 'walkins' instead of 'schedule')
    $table = 'walkins';

    try {
        // Ensure the action matches the expected value
        if ($action === 'edit_walkin') {
            // Prepare the update query for the 'walkins' table
            $sql = "UPDATE $table 
                    SET name = :name, 
                        contact_number = :contact, 
                        appointment_date = :date, 
                        status = :status 
                    WHERE id = :id";

            // Prepare and bind parameters
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);

            // Execute the update query
            if ($stmt->execute()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Walk-in updated successfully.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update the walk-in record.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid action specified.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}

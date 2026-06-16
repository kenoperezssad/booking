<?php
// SCHEDULE TABLE EDIT HANDLER (PERSONAL)

// Include the database connection
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and validate inputs
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id'], $input['name'], $input['contact_number'], $input['appointment_date'], $input['status'], $input['action'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Sanitize inputs
    $id = htmlspecialchars($input['id']);
    $name = htmlspecialchars($input['name']);
    $contact = htmlspecialchars($input['contact_number']);
    $date = htmlspecialchars($input['appointment_date']);
    $status = htmlspecialchars($input['status']);
    $action = htmlspecialchars($input['action']);

    // Default table is `schedule` (for appointments)
    $table = 'schedule';

    try {
        if ($action === 'edit_appointment') {
            // Prepare the update query
            $sql = "UPDATE $table 
                    SET name = :name, 
                        contact_number = :contact, 
                        appointment_date = :date, 
                        status = :status 
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);

            // Execute the query
            if ($stmt->execute()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Record updated successfully.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update the record.'
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

<?php
// Include database connection
require 'db.php';

// Login check removed - allowing direct access

try {
    // Fetch data from the `schedule` table with a 'type' label as 'appointment'
    $scheduleStmt = $conn->query("SELECT id, name, contact_number, appointment_date, status, 'appointment' AS type FROM schedule");
    $scheduleData = $scheduleStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch data from the `walkins` table with a 'type' label as 'walk-in'
    $walkinsStmt = $conn->query("SELECT id, name, contact_number, appointment_date, status, 'walk-in' AS type FROM walkins");
    $walkinsData = $walkinsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Merge the data from both tables
    $appointments = array_merge($scheduleData, $walkinsData);

    // Sort the appointments by `appointment_date`
    usort($appointments, function ($a, $b) {
        return strtotime($a['appointment_date']) - strtotime($b['appointment_date']);
    });
} catch (PDOException $e) {
    echo "Error fetching appointments: " . htmlspecialchars($e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" />
    <style>
        body {
    padding: 20px;
    background-color: #f3f4f6;
    display: flex;
    justify-content: center; /* Align center horizontally */
    align-items: center; /* Align center vertically */
    min-height: 100vh;
    margin: 0;
}

.container {
    margin: auto;
    max-width: 1200px;
    padding: 20px;
    background: #ffffff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
}

.table-wrapper { 
    margin-top: 20px; 
}

table { 
    width: 100%; 
    border-collapse: collapse; 
}

th, td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

th { background-color: #f4f4f4; font-weight: bold; }
tr:hover { background-color: #f9fafb; }

.btn { 
    padding: 8px 16px; 
    border-radius: 4px; 
    font-weight: 500; 
    text-decoration: none; 
}

.btn-update { 
    background-color: #3b82f6; 
    color: #fff; 
}

.btn-delete { 
    background-color: #ef4444; 
    color: #fff; 
}

.hidden {
    display: none;
}

#overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

#edit-form {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* This keeps the form centered both horizontally and vertically */
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
    z-index: 1010;
    width: 100%;
    max-width: 500px; /* Ensure the form doesn't span the entire screen width */
}

#edit-form form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

#edit-form input, #edit-form select, #edit-form button {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

#edit-form button {
    background-color: #3b82f6;
    color: white;
    cursor: pointer;
}

#edit-form button[type="button"].btn-cancel {
    background-color: #ef4444; /* Red background */
    color: white;
    margin-top: 10px;
    cursor: pointer;
}


    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center text-xl font-bold">Appointments</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Contact Number</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['name']) ?></td>
                                <td><?= htmlspecialchars($appointment['contact_number']) ?></td>
                                <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                                <td><?= htmlspecialchars($appointment['status']) ?></td>
                                <td><?= htmlspecialchars($appointment['type']) ?></td>
                                <td>
                                    <button class="btn btn-update"
                                            data-id="<?= $appointment['id'] ?>"
                                            data-type="<?= $appointment['type'] ?>">Update</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No appointments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="text-center mt-4">
        <a href="employee_logout.php" class="btn btn-delete">Logout</a>
    </div>
        </div>
    </div>

    <div id="overlay" class="overlay hidden"></div>
<div id="edit-form" class="edit-form hidden">
    <h3>Edit Appointment</h3>
    <form>
        <label for="edit-name">Name:</label>
        <input type="text" id="edit-name" name="name" />
        <label for="edit-contact">Contact Number:</label>
        <input type="text" id="edit-contact" name="contact_number" />
        <label for="edit-date">Appointment Date:</label>
        <input type="datetime-local" id="edit-date" name="appointment_date" />
        <label for="edit-status">Status:</label>
        <select id="edit-status" name="status">
            <option value="Pending">Pending</option>
            <option value="Confirmed">Reschedule</option>
            <option value="Cancelled">Complete</option>
        </select>
        <button type="button" class="btn-save">Save</button>
        <button type="button" class="btn-cancel">Cancel</button>
    </form>
</div>


    <script>
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('overlay');
    const editForm = document.getElementById('edit-form');
    const btnSave = editForm.querySelector('.btn-save');
    const btnCancel = editForm.querySelector('.btn-cancel');
    let currentRow = null;

    // Attach event listeners to update buttons
    document.querySelectorAll('.btn-update').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const type = button.dataset.type; // "appointment" or "walk-in"

            // Fetch current row and its data
            currentRow = button.closest('tr');
            const name = currentRow.querySelector('td:nth-child(1)').innerText.trim();
            const contactNumber = currentRow.querySelector('td:nth-child(2)').innerText.trim();
            const appointmentDate = currentRow.querySelector('td:nth-child(3)').innerText.trim();
            const status = currentRow.querySelector('td:nth-child(4)').innerText.trim();

            // Populate the form fields with data
            editForm.querySelector('#edit-name').value = name;
            editForm.querySelector('#edit-contact').value = contactNumber;
            editForm.querySelector('#edit-date').value = appointmentDate;
            editForm.querySelector('#edit-status').value = status;

            // Show the form and overlay
            editForm.classList.remove('hidden');
            overlay.classList.remove('hidden');

            // Set save button click listener
            btnSave.onclick = () => {
                const updatedName = editForm.querySelector('#edit-name').value;
                const updatedContact = editForm.querySelector('#edit-contact').value;
                const updatedDate = editForm.querySelector('#edit-date').value;
                const updatedStatus = editForm.querySelector('#edit-status').value;

                // Prepare payload
                const payload = {
                    id: id,
                    name: updatedName,
                    contact_number: updatedContact,
                    appointment_date: updatedDate,
                    status: updatedStatus,
                    action: type === 'appointment' ? 'edit_appointment' : 'edit_walkin',
                };

                const endpoint = type === 'appointment' ? 'edit_handler.php' : 'edit_handler2.php';

                // Send update request
                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('Appointment updated successfully.');

                            // Update the table row values
                            currentRow.querySelector('td:nth-child(1)').innerText = updatedName;
                            currentRow.querySelector('td:nth-child(2)').innerText = updatedContact;
                            currentRow.querySelector('td:nth-child(3)').innerText = updatedDate;
                            currentRow.querySelector('td:nth-child(4)').innerText = updatedStatus;

                            // Close the form and overlay
                            closeEditForm();
                        } else {
                            alert('Error updating appointment: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Update failed:', error);
                        alert('An unexpected error occurred.');
                    });
            };

            // Cancel button listener
            btnCancel.onclick = () => {
                closeEditForm();
            };
        });
    });

    // Close edit form function
    function closeEditForm() {
        editForm.classList.add('hidden');
        overlay.classList.add('hidden');
        currentRow = null;
    }
});


    </script>
</body>
</html>

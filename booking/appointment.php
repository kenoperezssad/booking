<?php
// Include database connection
require 'db.php';

try {
    // Fetch data from the `schedule` table (appointments)
    $scheduleStmt = $conn->query("SELECT id, name, contact_number, appointment_date, status, 'appointment' AS type FROM schedule");
    $appointmentsData = $scheduleStmt->fetchAll(PDO::FETCH_ASSOC);

    // Sort the appointments by `appointment_date`
    usort($appointmentsData, function ($a, $b) {
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
    <title>Appointment List</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<div class="container">
    <div class="header">
        <button id="backBtn" class="btn btn-back">Back</button>
        <h1>Appointment List</h1>
    </div>

    <!-- Appointment Table -->
    <table id="appointmentTable">
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
            <?php foreach ($appointmentsData as $appointment): ?>
                <tr data-id="<?= $appointment['id'] ?>" 
                    data-name="<?= htmlspecialchars($appointment['name']) ?>" 
                    data-contact="<?= htmlspecialchars($appointment['contact_number']) ?>" 
                    data-date="<?= htmlspecialchars($appointment['appointment_date']) ?>" 
                    data-status="<?= htmlspecialchars($appointment['status']) ?>" 
                    data-type="<?= htmlspecialchars($appointment['type']) ?>">
                    <td class="editable" data-field="name"><?= htmlspecialchars($appointment['name']) ?></td>
                    <td class="editable" data-field="contact_number"><?= htmlspecialchars($appointment['contact_number']) ?></td>
                    <td class="editable" data-field="appointment_date"><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                    <td class="editable" data-field="status">
    <span class="status-text"><?= htmlspecialchars($appointment['status']) ?></span>
    <select class="status-dropdown" style="display: none;">
        <option value="Pending" <?= $appointment['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Reschedule" <?= $appointment['status'] === 'reschedule' ? 'selected' : '' ?>>Reschedule</option>
        <option value="Complete" <?= $appointment['status'] === 'complete' ? 'selected' : '' ?>>Complete</option>
    </select>
</td>

                    <td><?= htmlspecialchars($appointment['type']) ?></td>
                    <td>
    <div class="actions">
        <button class="edit-btn">Edit</button>
        <button class="delete-btn">Delete</button>
    </div>
</td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Delete All Button -->
    <button id="deleteAllBtn" class="btn btn-delete">Delete All Appointments</button>
</div>

<!-- Confirmation Modal -->
<div class="confirmation-modal" id="confirmationModal" style="display:none;">
    <div class="confirmation-box">
        <h3>Are you sure you want to delete all appointments?</h3>
        <button class="btn-delete" id="confirmDeleteBtn">Delete</button>
        <button class="btn-cancel" id="cancelDeleteBtn">Cancel</button>
    </div>
</div>

<script>
    const table = document.getElementById("appointmentTable");
    const deleteAllBtn = document.getElementById("deleteAllBtn");
    const confirmationModal = document.getElementById("confirmationModal");
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

    // Back button logic - redirects to admin.php
    document.getElementById("backBtn").addEventListener("click", function() {
        window.location.href = "admin.php"; // Redirect to the admin page
    });

    // Show confirmation modal when delete button is clicked
    deleteAllBtn.addEventListener("click", function() {
        confirmationModal.style.display = "flex"; // Show the confirmation modal
    });

    // Confirm delete action (delete all rows from the table and from database)
    confirmDeleteBtn.addEventListener("click", function() {
        const formData = new FormData();
        formData.append('action', 'delete_all_appointments');

        // Send the request to delete all appointments from the database
        fetch("delete_handler.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
                table.querySelector("tbody").innerHTML = ""; // Clear the table
                confirmationModal.style.display = "none";
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An unexpected error occurred.");
        });
    });

    // Cancel delete action
    cancelDeleteBtn.addEventListener("click", function() {
        confirmationModal.style.display = "none"; // Close the confirmation modal
    });

    // Delete individual appointment
    table.addEventListener("click", function(event) {
        if (event.target.classList.contains("delete-btn")) {
            const row = event.target.closest("tr");
            const appointmentId = row.dataset.id;

            if (confirm("Are you sure you want to delete this appointment?")) {
                const formData = new FormData();
                formData.append('action', 'delete_appointment');
                formData.append('id', appointmentId);

                fetch("delete_handler.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert(data.message);
                        row.remove();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An unexpected error occurred.");
                });
            }
        }
    });

    // Edit individual appointment
    table.addEventListener("click", function(event) {
    if (event.target.classList.contains("edit-btn")) {
        const row = event.target.closest("tr");
        const appointmentId = row.dataset.id;
        const editableFields = row.querySelectorAll(".editable");

        if (event.target.textContent === "Edit") {
            // Enable editable fields
            editableFields.forEach(field => {
                if (field.dataset.field === "status") {
                    field.querySelector(".status-text").style.display = "none";
                    field.querySelector(".status-dropdown").style.display = "inline-block";
                } else {
                    const input = document.createElement("input");
                    input.type = "text";
                    input.value = field.textContent.trim();
                    field.innerHTML = "";
                    field.appendChild(input);
                }
            });
            event.target.textContent = "Save";
        } else {
            // Collect updated data
            const updatedData = { id: appointmentId, action: "edit_appointment" };
            editableFields.forEach(field => {
                if (field.dataset.field === "status") {
                    const dropdown = field.querySelector(".status-dropdown");
                    updatedData.status = dropdown.value;
                    field.querySelector(".status-text").textContent = dropdown.value;
                    dropdown.style.display = "none";
                    field.querySelector(".status-text").style.display = "inline";
                } else {
                    const input = field.querySelector("input");
                    updatedData[field.dataset.field] = input.value;
                    field.textContent = input.value;
                }
            });

            // Send updated data to the server
            fetch("edit_handler.php", {
                method: "POST",
                body: JSON.stringify(updatedData),
                headers: { "Content-Type": "application/json" }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    event.target.textContent = "Edit";
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An unexpected error occurred.");
            });
        }
    }
});

</script>

</body>
</html>

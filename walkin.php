<?php
// Include database connection
require 'db.php';

try {
    // Fetch data from the `walkins` table
    $walkinsStmt = $conn->query("SELECT id, name, contact_number, appointment_date, status, 'walk-in' AS type FROM walkins");
    $walkinsData = $walkinsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Sort the walk-ins by `appointment_date`
    usort($walkinsData, function ($a, $b) {
        return strtotime($a['appointment_date']) - strtotime($b['appointment_date']);
    });
} catch (PDOException $e) {
    echo "Error fetching walk-ins: " . htmlspecialchars($e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walk-In List</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<div class="container">
    <div class="header">
        <button id="backBtn" class="btn btn-back">Back</button>
        <h1>Walk-In List</h1>
    </div>

    <!-- Walk-In Table -->
    <table id="walkinTable">
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
            <?php foreach ($walkinsData as $walkin): ?>
                <tr data-id="<?= $walkin['id'] ?>" 
                    data-name="<?= htmlspecialchars($walkin['name']) ?>" 
                    data-contact="<?= htmlspecialchars($walkin['contact_number']) ?>" 
                    data-date="<?= htmlspecialchars($walkin['appointment_date']) ?>" 
                    data-status="<?= htmlspecialchars($walkin['status']) ?>" 
                    data-type="<?= htmlspecialchars($walkin['type']) ?>">
                    <td class="editable" data-field="name"><?= htmlspecialchars($walkin['name']) ?></td>
                    <td class="editable" data-field="contact_number"><?= htmlspecialchars($walkin['contact_number']) ?></td>
                    <td class="editable" data-field="appointment_date"><?= htmlspecialchars($walkin['appointment_date']) ?></td>
                    <td class="editable" data-field="status">
    <span class="status-text"><?= htmlspecialchars($walkin['status']) ?></span>
    <select class="status-dropdown" style="display: none;">
        <option value="Pending" <?= $walkin['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Reschedule" <?= $walkin['status'] === 'reschedule' ? 'selected' : '' ?>>Reschedule</option>
        <option value="Complete" <?= $walkin['status'] === 'complete' ? 'selected' : '' ?>>Complete</option>
    </select>
</td>
                    <td><?= htmlspecialchars($walkin['type']) ?></td>
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
    <button id="deleteAllBtn" class="btn btn-delete">Delete All Walk-Ins</button>
</div>

<!-- Confirmation Modal -->
<div class="confirmation-modal" id="confirmationModal" style="display:none;">
    <div class="confirmation-box">
        <h3>Are you sure you want to delete all walk-ins?</h3>
        <button class="btn-delete" id="confirmDeleteBtn">Delete</button>
        <button class="btn-cancel" id="cancelDeleteBtn">Cancel</button>
    </div>
</div>

<script>
    const table = document.getElementById("walkinTable");
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
        formData.append('action', 'delete_all_walkins'); // Correct action for deleting all walk-ins

        // Send the request to delete all walk-ins from the database
        fetch("delete_handler.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message); // Show success message

                // Clear all rows from the table (front-end)
                const tbody = table.querySelector("tbody");
                tbody.innerHTML = ""; // Removes all rows

                // Close the confirmation modal
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

    // Delete individual walk-in
    table.addEventListener("click", function(event) {
        if (event.target.classList.contains("delete-btn")) {
            const row = event.target.closest("tr");
            const walkinId = row.dataset.id;

            if (confirm("Are you sure you want to delete this walk-in?")) {
                const formData = new FormData();
                formData.append('action', 'delete_walkin');
                formData.append('id', walkinId);

                fetch("delete_handler.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert(data.message);
                        row.remove(); // Remove the row from the table
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

    // Edit individual walk-in
    table.addEventListener("click", function(event) {
    if (event.target.classList.contains("edit-btn")) {
        const row = event.target.closest("tr");
        const walkinId = row.dataset.id;
        const editableFields = row.querySelectorAll(".editable");

        if (event.target.textContent === "Edit") {
            // Enable editing
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
            const updatedData = { id: walkinId, action: "edit_walkin" };

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
            fetch("edit_handler2.php", {
                method: "POST",
                body: JSON.stringify(updatedData),
                headers: { "Content-Type": "application/json" }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert("Update successful!");
                    event.target.textContent = "Edit";
                } else {
                    alert("Failed to update: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while saving changes.");
            });
        }
    }
});
</script>

</body>
</html>

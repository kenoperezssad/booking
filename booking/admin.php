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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" integrity="sha512-wnea99uKIC3TJF7v4eKk4Y+lMz2Mklv18+r4na2Gn1abDRPPOeef95xTzdwGD9e6zXJBteMIhZ1+68QC5byJZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
body {
    padding: 20px;
    background-color: #f3f4f6;
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

.hidden {
    display: none;
}

table {
    width: 100%;
    background-color: #fff;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
    margin-top: 20px;
}

th, td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

th {
    background-color: #f4f4f4;
    font-weight: bold;
    text-transform: uppercase; /* Optional: Makes table headers more prominent */
}

tr:hover {
    background-color: #f9fafb;
}

td {
    text-align: left; /* Center-align data that needs it */
}

td a {
    padding: 8px 16px;
    margin-right: 8px;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 500;
}

td a:hover {
    opacity: 0.8;
}

td a.update {
    background-color: #3b82f6;
    color: white;
    border: 1px solid #3b82f6;
}

td a.update:hover {
    background-color: #2563eb;
}

td a.delete {
    background-color: #ef4444;
    color: white;
    border: 1px solid #ef4444;
}

td a.delete:hover {
    background-color: #dc2626;
}

.logout-btn {
    display: block;
    text-align: center;
    background: #ef4444;
    color: white;
    padding: 12px 24px;
    border-radius: 5px;
    text-decoration: none;
    margin: 20px auto;
    max-width: 200px;
    font-weight: bold;
    text-transform: uppercase;
}

.logout-btn:hover {
    background: #dc2626;
}
    </style>
</head>
<body>
    <div class="container">
        <header class="flex justify-between items-center pb-5 border-b">
            <div class="text-lg font-bold">EXE</div>
            <nav>
                <a href="appointment.php" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md">Appointments</a>
                <a href="walkin.php" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md ml-4">Walk-Ins</a>
                <!-- Add employee button -->
                <a href="add_employee.php" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md ml-4">Create Employee</a>
            </nav>
        </header>

        <main>
            <!-- New Navigation Bar for toggling between Appointments, Employee, Unnamed, and Unnamed1 -->
            <div class="flex space-x-4 pt-5">
                <button id="appointment-btn" class="w-40 px-5 py-3 bg-blue-500 text-white font-bold rounded-md">Appointments</button>
                <button id="employee-btn" class="w-40 px-5 py-3 bg-gray-200 text-black font-bold rounded-md">Employee's</button>
            </div>

            <!-- Appointment Table -->
            <div id="appointment-table" class="table-wrapper">
                <h2 class="text-xl font-bold">Appointment's</h2>
                <table class="w-full bg-white shadow-md rounded-lg mt-3">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Customer Name</th>
                            <th class="py-2 px-4 border-b">Contact Number</th>
                            <th class="py-2 px-4 border-b">Appointment Date</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointments)): ?>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td class="py-2 px-4"><?= htmlspecialchars($appointment['name']) ?></td>
                                    <td class="py-2 px-4"><?= htmlspecialchars($appointment['contact_number']) ?></td>
                                    <td class="py-2 px-4"><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                                    <td class="py-2 px-4"><?= htmlspecialchars($appointment['status']) ?></td>
                                    <td class="py-2 px-4"><?= htmlspecialchars($appointment['type']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No appointments yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

<!-- Employee Table -->
<div id="employee-table" class="hidden table-wrapper">
    <h2 class="text-xl font-bold">Employees</h2>
    <table class="w-full bg-white shadow-md rounded-lg mt-3">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">First Name</th>
                <th class="py-2 px-4 border-b">Middle Name</th>
                <th class="py-2 px-4 border-b">Last Name</th>
                <th class="py-2 px-4 border-b">Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Fetch employee data from the database
                try {
                    $employeeStmt = $conn->query("SELECT first_name, middle_name, last_name, email FROM employees");
                    $employees = $employeeStmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($employees)):
                        foreach ($employees as $employee):
            ?>
                <tr>
                    <td class="py-2 px-4"><?= htmlspecialchars($employee['first_name']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($employee['middle_name'] ?? 'N/A') ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($employee['last_name']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($employee['email']) ?></td>
                </tr>
            <?php
                        endforeach;
                    else:
            ?>
                <tr>
                    <td colspan="4" class="text-center">No employees found.</td>
                </tr>
            <?php endif; ?>
                <?php
                } catch (PDOException $e) {
                    echo "Error fetching employee data: " . $e->getMessage();
                }
                ?>
        </tbody>
    </table>
</div>

            <!-- Logout Button Below the Table -->
<div class="mt-5 text-center">
    <a href="admin_logout.php" class="px-6 py-3 bg-red-500 text-white rounded-md shadow-md hover:bg-red-600">Logout</a>
</div>

        </main>
    </div>

    <script>
        document.getElementById("appointment-btn").addEventListener("click", function () {
            document.getElementById("appointment-table").classList.remove("hidden");
            document.getElementById("employee-table").classList.add("hidden");
        });

        document.getElementById("employee-btn").addEventListener("click", function () {
            document.getElementById("appointment-table").classList.add("hidden");
            document.getElementById("employee-table").classList.remove("hidden");
        });
    </script>
</body>
</html>
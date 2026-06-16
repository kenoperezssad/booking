<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Walk-In Appointment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Book Walk-In Appointment</h2>
        <form action="saveWalkin.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="contact">Contact Number:</label>
            <input type="tel" id="contact" name="contact" required>
            
            <label for="time">Appointment Date:</label>
            <input type="datetime-local" id="time" name="time" required>

            <button type="submit" class="btn">Submit</button>
        </form>

        <button id="backBtn" class="btn btn-back">Back</button>
    </div>

    <script>
        document.getElementById("backBtn").addEventListener("click", function () {
            window.location.href = "index.php"; // Go back to the index page
        });
    </script>
</body>
</html>

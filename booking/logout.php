<?php
session_start();

// Destroy the session and redirect to the login page
session_unset();
session_destroy();

// JavaScript to show a logout success message and redirect after a short delay
echo "<script>
            alert('Logged out successfully.');
            setTimeout(function() {
                window.location.href = 'index.php'; // Redirect to the login page or homepage after 1 second
            }, 500);
          </script>";
exit;
?>

<?php
session_start();
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session

// Display "Logout successful" message with a delay before redirect
echo "<script>
        alert('Logout successful');
        setTimeout(function() {
            window.location.href = 'admin_login.php';  // Redirect to login page after the delay
        }, 500);
      </script>";

exit();
?>

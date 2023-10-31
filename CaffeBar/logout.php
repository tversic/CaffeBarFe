<?php
// Clear the user-related cookies
setcookie("username", "", time() - 3600, "/"); // Adjust the expiration time in the past
// Add more cookie clearing if needed

// Redirect to the login page or any other appropriate page
header("Location: login.php"); // Change the URL to your login page
exit();
?>
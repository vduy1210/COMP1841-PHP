<?php
// Start the session
session_start();

// Destroy the session
session_unset();

// Redirect to homepage
header("Location: index.php");
exit;


?>
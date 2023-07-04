<?php
session_start();

session_unset(); // Unset $_SESSION variable for the run-time 
session_destroy(); // Destroy session data in storage
header('Location: /INIAP/login.php');
?>
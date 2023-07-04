<?php

$server = 'localhost:3308';
$username = 'root';
$password = 'Administrador;2023';
$database = 'iniap';
// Puerto predeterminado de MySQL es 3306
try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>
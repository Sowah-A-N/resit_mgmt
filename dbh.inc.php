<?php

$dsn = "mysql:host=localhost;dbname=resitportaldb";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Correctly reference $e in the catch block
    die("Connection failed: " . $e->getMessage());
}

// Initialize mysqli connection for compatibility with other parts of the code
$conn = new mysqli("localhost", "root", "", "resitportaldb");

// Check if the mysqli connection failed
if ($conn->connect_error) {
    die("Connection failed (MySQLi): " . $conn->connect_error);
}


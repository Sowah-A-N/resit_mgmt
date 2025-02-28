<?php
require_once '../dbh.inc.php';

if (isset($_GET['department'])) {
    $department = $_GET['department'];

    try {
        $stmt = $pdo->prepare("SELECT course_id, course_code, course_name FROM courses WHERE department = ?");
        $stmt->execute([$department]);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($courses);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
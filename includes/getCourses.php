<?php
require_once 'dbh.inc.php'; // Include your database connection file

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


try {
    $stmt = $pdo->query ("SELECT course_id,course_code, course_name FROM courses");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($courses);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

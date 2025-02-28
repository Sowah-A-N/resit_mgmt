<?php
require_once 'dbh.inc.php';

if (isset($_GET['department_id'])) {
    $departmentId = $_GET['department_id'];

    try {
        $stmt = $pdo->prepare("SELECT name FROM programs WHERE department = ? ORDER BY name ASC");
        $stmt->execute([$departmentId]);
        $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($programs);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
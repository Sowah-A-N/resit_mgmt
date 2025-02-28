<?php
require_once '../dbh.inc.php'; // Include database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $registrationId = $input['registration_id'] ?? null;

    if ($registrationId) {
        try {
            $stmt = $pdo->prepare("UPDATE resit_registrations SET status = 'Approved' WHERE registration_id = ?");
            $stmt->execute([$registrationId]);

            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid registration ID.']);
    }
}

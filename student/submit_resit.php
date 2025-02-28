<?php
require_once '../dbh.inc.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_SESSION['student_details']; // Assuming the student is logged in
    $selectedCourses = json_decode($_POST['selected_courses'], true); // Decode JSON to array

    if (!empty($selectedCourses) && is_array($selectedCourses)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO course_registration (student_id, course_id) VALUES (?, ?)");

            foreach ($selectedCourses as $courseId) {
                $stmt->execute([$studentId, $courseId]);
            }

            echo "Courses submitted successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "No courses selected. Please try again.";
    }
}


<?php
require_once 'dbh.inc.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $indexNumber = $_POST['index_number'];
    $receiptNumber = $_POST['receipt_num'];
    $amountPaid = $_POST['amount'];

    // Fetch student details to get email
    $stmt = $pdo->prepare("SELECT email FROM student_details WHERE index_number = ?");
    $stmt->execute([$indexNumber]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "<script>alert('Error: Student not found in database.'); window.history.back();</script>";
        exit();
    }

    $email = $student['email'];

    // Calculate the number of courses (1 course = 100 Cedis)
    $coursePrice = 100;
    $maxCourses = 5; // Maximum courses allowed
    $numberOfCourses = floor($amountPaid / $coursePrice);

    // Ensure max number of courses does not exceed 5
    if ($numberOfCourses > $maxCourses) {
        $numberOfCourses = $maxCourses;
    }

    if ($numberOfCourses < 1) {
        echo "<script>alert('Error: The amount paid is insufficient for at least one course.'); window.history.back();</script>";
        exit();
    }

    try {
        // Insert student payment details into the database
        $stmt = $pdo->prepare("INSERT INTO student_payment_info (index_number, receipt_num, amount, number_of_courses) VALUES (?, ?, ?, ?)");
        $stmt->execute([$indexNumber, $receiptNumber, $amountPaid, $numberOfCourses]);

        echo "<script>alert('Payment recorded successfully!'); window.location.href = 'student_payment.php';</script>";

        // Redirect to the main login page
        header("Location: ../cashier/register.php");
        
        echo "<script>alert('Payment recorded successfully!'); window.location.href = 'student_payment.php';</script>";
exit();
    } catch (PDOException $e) {
        echo "<script>alert('Database Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
}
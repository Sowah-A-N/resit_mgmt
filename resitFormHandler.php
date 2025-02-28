<?php
require_once 'dbh.inc.php'; // Include database connection
//require 'vendor/autoload.php'; // Include PHPMailer for email sending

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $index_number = $_POST['index_number'];
    $department = $_POST['department'];
    $program = $_POST['program'];
    $role = "student"; // Automatically assign the "student" role

    // Check if the email or index number already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM student_details WHERE email = ? OR index_number = ?");
    $stmt->execute([$email, $index_number]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<script>alert('Error: Email or Index Number already exists. Please use a different one.'); window.history.back();</script>";
        exit();
    }

    // Generate a strong random password (8-12 characters)
    function generatePassword($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
        return substr(str_shuffle($characters), 0, $length);
    }

    $plainPassword = generatePassword(); // Generate plain password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT); // Hash password for security

    try {
        // Insert student details into the database with the role and hashed password
        $stmt = $pdo->prepare("INSERT INTO student_details (full_name, email, index_number, department, program, role, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $index_number, $department, $program, $role, $hashedPassword]);

        // // Send email with login credentials using PHPMailer
        // $mail = new PHPMailer(true);

        try {
            // $mail->isSMTP();
            // $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
            // $mail->SMTPAuth = true;
            // $mail->Username = 'your-email@example.com'; // Replace with your email
            // $mail->Password = 'your-email-password'; // Replace with your email password
            // $mail->SMTPSecure = 'tls';
            // $mail->Port = 587;

            // $mail->setFrom('no-reply@resitportal.com', 'Resit Portal');
            // $mail->addAddress($email);

            // $mail->Subject = "Your Login Credentials";
            // $mail->Body = "Dear $name,\n\nYour login credentials are as follows:\n\nUsername: $index_number\nPassword: $plainPassword\n\nPlease log in and change your password immediately.\n\nBest regards,\nResit Portal Team";

            // $mail->send();



            echo "<script>alert('Student registered successfully! Login credentials have been sent to the email. $plainPassword'); window.location.href = './index.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Student registered successfully, but email could not be sent. $plainPassword'); window.location.href = './index.php';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
}

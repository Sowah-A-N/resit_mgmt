<?php
session_start();
require_once 'dbh.inc.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrIndex = $_POST['username']; // Single input field for both students and staff
    $Upassword = $_POST['password'];

    // First, check if the user exists in the `users` table (for non-student users)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$usernameOrIndex]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the hashed password for non-student users
        if ($Upassword = $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username']; // Store username for reference

            // Redirect based on user role
            redirectToDashboard($user['role']);
        } else {
            echo "<script>alert('Invalid password. Please try again'); window.history.back();</script>";
            exit();
        }
    } else {
        // If not found in `users`, check in `student_details` table
        $stmt = $pdo->prepare("SELECT * FROM student_details WHERE index_number = ?");
        $stmt->execute([$usernameOrIndex]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            // Verify the hashed password for students
            if (password_verify($Upassword, $student['password'])) {
                $_SESSION['user_id'] = $student['id'];
                $_SESSION['role'] = 'student';
                $_SESSION['index_number'] = $student['index_number'];
                $_SESSION['full_name'] = $student['full_name']; // Store full name for reference
                $_SESSION['email'] = $student['email'];

                // Redirect to student dashboard
                header('Location: ./student/dashboard.php');
                exit();
            } else {
                echo "<script>alert('Invalid password. Please try again.'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid username or index number. Please try again.'); window.history.back();</script>";
            exit();
        }
    }
}

// Function to determine and redirect to the appropriate dashboard based on user role
function redirectToDashboard($role) {
    switch ($role) {
        case 'admin':
            header('Location: admin_dashboard.php');
            break;
        case 'cashier':
            header('Location: ./cashier/dashboard.php');
            break;
        case 'HOD':
            header('Location: ./hod/index.php');
            break;
        case 'registrar':
            header('Location: registrar_dashboard.php');
            break;
        case 'exam_unit':
            header('Location: exam_unit_dashboard.php');
            break;
        // case 'student':
        //     header('Location: ./student/dashboard.php');
        //     break;
        default:
            header('Location: index.php');
            break;
    }
    exit(); // Ensure the script stops after redirection
}
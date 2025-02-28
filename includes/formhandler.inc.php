<?php
session_start();
require_once 'dbh.inc.php'; // Include your database connection file

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username is an index_number for students
    $studentSql = "SELECT * FROM users WHERE index_number = ?";
    $stmt = $conn->prepare($studentSql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $studentResult = $stmt->get_result();

    if ($studentResult->num_rows > 0) {
        // Login as student
        $user = $studentResult->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Correct password, start session and save user info
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            // Redirect to the student dashboard
            redirectToDashboard($user['role']);
        } else {
            echo "Invalid index number or password.";
        }
    } else {
        // Login as other user roles
        $userSql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($userSql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $userResult = $stmt->get_result();

        if ($userResult->num_rows > 0) {
            $user = $userResult->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Correct password, start session and save user info
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];

                // Redirect to the appropriate dashboard
                redirectToDashboard($user['role']);
            } else {
                echo "Invalid username or password.";
            }
        } else {
            echo "Invalid username or password.";
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
            header('Location: /resit_portal/cashier/index.php');
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
        case 'student':
            header('Location: ./student/index.php');
            break;
        default:
            header('Location: index.php');
            break;
    }
    exit(); // Ensure the script stops after redirection
}
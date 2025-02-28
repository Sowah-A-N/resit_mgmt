<?php
session_start();
require_once '../dbh.inc.php'; // Include database connection

// // Ensure the student is logged in
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
//     header('Location: ../index.php'); // Redirect to login if unauthorized
//     exit();
// }
$student_id = $_SESSION['user_id']; // Get logged-in student ID


try {
    // Fetch student details
    $stmt = $pdo->prepare("SELECT full_name, email, index_number, department, program FROM student_details WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("Error: Student details not found.");
    }
} catch (PDOException $e) {
    die("Error fetching student details: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="../student/dashboard.php">Dashboard</a></li>
            <li><a href="../student/register.php">Resit Registration</a></li>
            <li><a href="../student/Approval.php">Approval</a></li>
            <!-- <li><a href="profile.php" class="active">Profile</a></li> -->
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="profile-container">
            <h2>Student Profile</h2>
            <div class="profile-info">
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($student['full_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                <p><strong>Index Number:</strong> <?php echo htmlspecialchars($student['index_number']); ?></p>
                <p><strong>Department:</strong> <?php echo htmlspecialchars($student['department']); ?></p>
                <p><strong>Program:</strong> <?php echo htmlspecialchars($student['program']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>

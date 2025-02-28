<?php
session_start();

// // Ensure only students can access this page
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
//     header('Location: ../index.php'); // Redirect to login if unauthorized
//     print_r($_SESSION);
//     exit();
// }

require_once '../dbh.inc.php'; // Database connection

$student_id = $_SESSION['user_id'];
$index_number = $_SESSION['index_number'];
$full_name = $_SESSION['full_name'];

// Fetch student details
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total_courses FROM course_registration WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $resitStats = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT COUNT(*) AS pending_courses FROM course_registration WHERE student_id = ? AND status = 'Pending'");
    $stmt->execute([$student_id]);
    $pendingStats = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT c.course_code, c.course_name FROM course_registration cr 
                          JOIN courses c ON cr.course_id = c.course_id 
                          WHERE cr.student_id = ? AND cr.status = 'Approved'");
    $stmt->execute([$student_id]);
    $approvedCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/student.css">
</head>
<body>
    <div class="sidebar">
        <h2>Student</h2>
        <ul>
            <li><a href="../student/dashboard.php" class="active">Dashboard</a></li>
            <li><a href="../student/register.php">Resit Registration</a></li>
            <li><a href="../student/Approval.php">Approval</a></li>
            <li><a href="payment_history.php">Payment History</a></li>
            <!-- <li><a href="profile.php">Profile</a></li> -->
            <li><a href="../student/logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="dashboard-container">
            <h1>Welcome, <?php echo htmlspecialchars($full_name); ?>!</h1>
            <p>Index Number: <?php echo htmlspecialchars($index_number); ?></p>

            <!-- Summary Cards -->
            <div class="summary-container">
                <div class="card">
                    <h3>Total Resit Courses</h3>
                    <p><?php echo $resitStats['total_courses']; ?></p>
                </div>
                <div class="card">
                    <h3>Pending Approvals</h3>
                    <p><?php echo $pendingStats['pending_courses']; ?></p>
                </div>
            </div>

            <!-- Approved Courses Table -->
            <div class="upcoming-exams">
                <h2>Approved Resit Courses</h2>
                <?php if (!empty($approvedCourses)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($approvedCourses as $course): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No approved resit courses yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

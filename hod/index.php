<?php
require_once '../dbh.inc.php'; // Include database connection

session_start();

// Fetch student resit submissions with pending status
try {
    $stmt = $pdo->query("
        SELECT 
            cr.registration_id, 
            sd.full_name,  
            sd.index_number, 
            c.course_name, 
            c.course_code, 
            cr.status, 
            cr.date 
        FROM course_registration cr
        JOIN student_details sd ON cr.student_id = sd.student_id
        JOIN courses c ON cr.course_id = c.course_id
        WHERE cr.status = 'Pending'
        ORDER BY cr.date DESC
    ");
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching submissions: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard</title>
    <link rel="stylesheet" href="../css/cashier1.css">
</head>
<body data-dashboard-type="hod">
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="./index.php">Dashboard</a></li>
            <li><a href="./Reports.php">Reports</a></li>
            <li><a href="../hod/logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="dashboard-container">
            <h2>HOD Dashboard</h2>
            <p>Welcome, HOD! Below is the list of students awaiting approval:</p>

            <table id="resitTable">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Index Number</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Status</th>
                        <th>Submission Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($submissions)): ?>
                        <?php foreach ($submissions as $submission): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($submission['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($submission['index_number']); ?></td>
                                <td><?php echo htmlspecialchars($submission['course_code']); ?></td>
                                <td><?php echo htmlspecialchars($submission['course_name']); ?></td>
                                <td><?php echo htmlspecialchars($submission['status']); ?></td>
                                <td><?php echo htmlspecialchars($submission['submission_date']); ?></td>
                                <td>
                                    <button onclick="approveResit(<?php echo $submission['registration_id']; ?>)">Approve</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No resit submissions pending approval.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function approveResit(registrationId) {
            if (confirm("Are you sure you want to approve this resit request?")) {
                fetch('approve_resit.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ registration_id: registrationId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Resit submission approved!");
                        location.reload(); // Refresh the page to update the list
                    } else {
                        alert("Failed to approve submission: " + data.error);
                    }
                })
                .catch(error => {
                    console.error("Error approving submission:", error);
                    alert("An error occurred while approving the submission.");
                });
            }
        }
    </script>
</body>
</html>

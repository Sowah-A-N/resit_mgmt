<?php
require_once '../dbh.inc.php';
session_start();

// // Ensure the student is logged in
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
//     header('Location: ../index.php');
//     exit();
// }

$student_id = $_SESSION['user_id'];
var_dump($_SESSION['user_id']);

// Fetch the number of courses paid for
try {
    $stmt = $pdo->prepare("SELECT number_of_courses FROM student_payment_info WHERE index_number = (SELECT index_number FROM student_details WHERE id = ?) ORDER BY submission_date DESC LIMIT 1");
    $stmt->execute([$student_id]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);

    $maxCourses = $payment ? $payment['number_of_courses'] : 0; // Default to 0 if no payment found
} catch (PDOException $e) {
    die("Error fetching payment details: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Resit Form</title>
    <link rel="stylesheet" href="../css/cashier1.css">
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
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
        <div class="form-container">
            <h2>Available Courses</h2>
            <p>You can register for a maximum of <strong><?php echo $maxCourses; ?></strong> courses.</p>
            <table id="courseTable">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be dynamically added here -->
                </tbody>
            </table>
            <form id="resitForm" action="submit_resit.php" method="post">
                <input type="hidden" id="selectedCourses" name="selected_courses">
                <button type="submit">Submit Selected Courses</button>
            </form>
        </div>
    </div>

    <script>
        let maxCourses = <?php echo $maxCourses; ?>; // Maximum courses student can register
        let selectedCount = 0;

        // Fetch courses from the database via getCourses.php
        fetch('../includes/getCourses.php')
            .then(response => response.json())
            .then(data => {
                const courseTableBody = document.querySelector('#courseTable tbody');

                if (Array.isArray(data)) {
                    data.forEach(course => {
                        const row = document.createElement('tr');

                        row.innerHTML = `
                            <td>${course.course_id}</td>
                            <td>${course.course_code}</td>
                            <td>${course.course_name}</td>
                            <td><input type="checkbox" class="courseCheckbox" value="${course.course_id}"></td>
                        `;

                        courseTableBody.appendChild(row);
                    });

                    // Attach event listener to checkboxes
                    document.querySelectorAll('.courseCheckbox').forEach(checkbox => {
                        checkbox.addEventListener('change', function () {
                            if (this.checked) {
                                if (selectedCount < maxCourses) {
                                    selectedCount++;
                                } else {
                                    alert("You can only register for up to " + maxCourses + " courses.");
                                    this.checked = false;
                                }
                            } else {
                                selectedCount--;
                            }
                        });
                    });

                } else {
                    console.error('Unexpected response format:', data);
                }
            })
            .catch(error => console.error('Error fetching courses:', error));

        // Handle form submission
        document.getElementById('resitForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const selected = [];
            document.querySelectorAll('.courseCheckbox:checked').forEach(checkbox => {
                selected.push(checkbox.value);
            });

            if (selected.length === 0) {
                alert('Please select at least one course.');
                return;
            }

            document.getElementById('selectedCourses').value = JSON.stringify(selected);
            this.submit();
        });
    </script>
</body>
</html>
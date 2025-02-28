<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Form</title>
    <link rel="stylesheet" href="../css/cashier.css">
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="../cashier/dashboard.php">Dashboard</a></li>
            <li><a href="../cashier/register.php">Register Student</a></li>
            <li><a href="../cashier/Reports.php">Reports</a></li>
            <!-- <li><a href="process_payment.php">Process Payment</a></li> -->
            <li><a href="../cashier/logout.php">Logout</a></li>
        </ul>
    </div>
    
    <div class="content">
        <div class="form-container">
            <h2>Student Information Form</h2>
            <form id="studentForm" action="./studentHandler.php" method="post">
                
                <label for="indexNumber">Index Number:</label>
                <input type="text" id="index_number" name="index_number" placeholder="Index Number" required>
                
                <label for="receiptNumber">Receipt Number:</label>
                <input type="text" id="receipt_num" name="receipt_num" placeholder="Receipt Number" required>

                <label for="amountPaid">Amount Paid (Cedis):</label>
                <input type="number" id="amount" name="amount" placeholder="Enter Amount" min="100" step="100" required oninput="updateCourseCount()">

                <label for="number_of_courses">Number of Courses:</label>
                <input type="text" id="number_of_courses" name="number_of_courses" placeholder="Number Of Courses" readonly>
                
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        function updateCourseCount() {
            let amount = document.getElementById("amount").value;
            let coursePrice = 100; // 1 course = 100 Cedis
            let maxCourses = 5; // Maximum number of courses allowed

            let numberOfCourses = Math.floor(amount / coursePrice);

            // Ensure the max number of courses does not exceed 5
            if (numberOfCourses > maxCourses) {
                alert("You can register for a maximum of 5 courses (₵500).");
                document.getElementById("amount").value = maxCourses * coursePrice; // Reset amount to max allowed
                numberOfCourses = maxCourses;
            }

            document.getElementById("number_of_courses").value = numberOfCourses;
        }
    </script>
</body>
</html>

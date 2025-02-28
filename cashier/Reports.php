<?php
session_start();

// Ensure only the cashier can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'cashier') {
    header('Location: ../index.php');
    exit();
}

require_once '../dbh.inc.php'; // Database connection

// Function to get date range based on report type
function getDateRange($reportType) {
    $currentDate = new DateTime();
    switch ($reportType) {
        case 'daily':
            return $currentDate->format('Y-m-d');
        case 'weekly':
            return $currentDate->modify('-7 days')->format('Y-m-d');
        case 'monthly':
            return $currentDate->modify('-1 month')->format('Y-m-d');
        case 'half_year':
            return $currentDate->modify('-6 months')->format('Y-m-d');
        case 'full_year':
            return $currentDate->modify('-1 year')->format('Y-m-d');
        default:
            return null;
    }
}

// Default report type
$reportType = isset($_GET['report_type']) ? $_GET['report_type'] : 'daily';
$dateRange = getDateRange($reportType);

// Fetch payment statistics
try {
    $query = "SELECT COUNT(*) AS total_payments, SUM(amount) AS total_amount 
              FROM student_payment_info";

    $paymentQuery = "SELECT index_number, receipt_num, amount, number_of_courses, submission_date 
                     FROM student_payment_info";

    if ($dateRange) {
        $query .= " WHERE submission_date >= :date_range";
        $paymentQuery .= " WHERE submission_date >= :date_range";
    }

    $stmt = $pdo->prepare($query);
    if ($dateRange) $stmt->bindParam(':date_range', $dateRange);
    $stmt->execute();
    $paymentStats = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare($paymentQuery);
    if ($dateRange) $stmt->bindParam(':date_range', $dateRange);
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Reports</title>
    <link rel="stylesheet" href="../css/cashier1.css">
    <script>
        function exportToCSV() {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Index Number,Receipt Number,Amount (Cedis),Courses,Submission Date\n";

            const rows = document.querySelectorAll("#reportTable tbody tr");
            rows.forEach(row => {
                const cols = row.querySelectorAll("td");
                let rowData = [];
                cols.forEach(col => rowData.push(col.innerText));
                csvContent += rowData.join(",") + "\n";
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "cashier_reports.csv");
            document.body.appendChild(link);
            link.click();
        }

        function filterTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll("#reportTable tbody tr");

            rows.forEach(row => {
                let rowText = row.innerText.toLowerCase();
                row.style.display = rowText.includes(input) ? "" : "none";
            });
        }

        function updateReport() {
            const reportType = document.getElementById('reportType').value;
            window.location.href = `Reports.php?report_type=${reportType}`;
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h2>Cashier</h2>
        <ul>
            <li><a href="../cashier/dashboard.php">Dashboard</a></li>
            <li><a href="../cashier/register.php">Register Student</a></li>
            <li><a href="../cashier/Reports.php">Reports</a></li>
            <li><a href="../cashier/logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="dashboard-container">
            <h1>Reports</h1>

            <!-- Report Type Dropdown -->
            <div class="report-filter">
                <label for="reportType">Select Report Type: </label>
                <select id="reportType" onchange="updateReport()">
                    <option value="daily" <?php echo ($reportType == 'daily') ? 'selected' : ''; ?>>Daily</option>
                    <option value="weekly" <?php echo ($reportType == 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                    <option value="monthly" <?php echo ($reportType == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                    <option value="half_year" <?php echo ($reportType == 'half_year') ? 'selected' : ''; ?>>Half Year</option>
                    <option value="full_year" <?php echo ($reportType == 'full_year') ? 'selected' : ''; ?>>Full Year</option>
                </select>
            </div>

            <!-- Summary Cards -->
            <div class="summary-container">
                <div class="card">
                    <h3>Total Payments</h3>
                    <p><?php echo $paymentStats['total_payments'] ?: 0; ?></p>
                </div>
                <div class="card">
                    <h3>Total Amount Collected</h3>
                    <p>GHs <?php echo number_format($paymentStats['total_amount'] ?: 0, 2); ?></p>
                </div>
            </div>

            <!-- Search and Export Section -->
            <div class="actions">
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search reports...">
                <button onclick="exportToCSV()">Download CSV</button>
            </div>

            <!-- Reports Table -->
            <div class="transactions">
                <h2>Transaction Reports (<?php echo ucfirst(str_replace('_', ' ', $reportType)); ?>)</h2>
                <table id="reportTable">
                    <thead>
                        <tr>
                            <th>Index Number</th>
                            <th>Receipt Number</th>
                            <th>Amount (Cedis)</th>
                            <th>Courses</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($payment['index_number']); ?></td>
                                <td><?php echo htmlspecialchars($payment['receipt_num']); ?></td>
                                <td>GHs <?php echo number_format($payment['amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($payment['number_of_courses']); ?></td>
                                <td><?php echo htmlspecialchars($payment['submission_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

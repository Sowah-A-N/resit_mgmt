<?php
session_start();

require_once '../dbh.inc.php'; // Database connection

// Fetch payment statistics
try {
    // Total Payments
    $stmt = $pdo->query("SELECT COUNT(*) AS total_payments, SUM(amount) AS total_amount FROM student_payment_info");
    $paymentStats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Recent Transactions
    $stmt = $pdo->query("SELECT index_number, receipt_num, amount, number_of_courses, submission_date 
                         FROM student_payment_info 
                         ORDER BY submission_date DESC 
                         LIMIT 5");
    $recentPayments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard</title>
    <link rel="stylesheet" href="../css/cashier1.css">
</head>
<body>
    <div class="sidebar">
        <h2>Cashier</h2>
        <ul>
            <li><a href="../cashier/dashboard.php">Dashboard</a></li>
            <li><a href="../cashier/register.php">Register Student</a></li>
            <li><a href="../cashier/Reports.php">Reports</a></li>
            <!-- <li><a href="process_payment.php">Process Payment</a></li> -->
            <li><a href="../cashier/logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="dashboard-container">
            <h1>Welcome, Cashier</h1>

            <!-- Summary Cards -->
            <div class="summary-container">
                <div class="card">
                    <h3>Total Payments</h3>
                    <p><?php echo $paymentStats['total_payments']; ?></p>
                </div>
                <div class="card">
                    <h3>Total Amount (Cedis)</h3>
                    <p>GHs <?php echo number_format($paymentStats['total_amount'], 2); ?></p>
                </div>
            </div>

            <!-- Recent Transactions Table -->
            <div class="transactions">
                <h2>Recent Transactions</h2>
                <table>
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
                        <?php foreach ($recentPayments as $payment): ?>
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

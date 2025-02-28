<?php
require_once 'dbh.inc.php'; // Include database connection

// Fetch all unique department names and their corresponding IDs
try {
    $stmt = $pdo->query("SELECT id, name FROM department ORDER BY name ASC");
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching departments: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Resit Form</title>
    <link rel="stylesheet" href="./css/cashier.css">
</head>
<body>

    <div class="content">
        <div class="form-container">
            <h2>Exam Resit Form</h2>
            <form id="resitForm" action="resitFormHandler.php" method="post">
                <label for="full_name">Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter your Full Name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your Email" required>

                <label for="index_number">Index Number</label>
                <input type="text" id="index_number" name="index_number" placeholder="Enter your Index Number" required>

                <!-- Department Dropdown -->
                <label for="department">Department</label>
                <select id="department" name="department" required>
                    <option value="">Select Department</option>
                    <?php foreach ($departments as $dept) { ?>
                        <option value="<?php echo htmlspecialchars($dept['id']); ?>">
                            <?php echo htmlspecialchars($dept['name']); ?>
                        </option>
                    <?php } ?>
                </select>

                <!-- Program Dropdown (Initially Empty) -->
                <label for="program">Program</label>
                <select id="programs" name="program" required>
                    <option value="">Select a department first</option>
                </select>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('department').addEventListener('change', function() {
            let departmentId = this.value;
            let programDropdown = document.getElementById('programs');

            // Reset the program dropdown
            programDropdown.innerHTML = '<option value="">Loading...</option>';

            if (departmentId) {
                fetch(`fetch_programs.php?department_id=${departmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        programDropdown.innerHTML = '<option value="">Select Program</option>';
                        data.forEach(program => {
                            let option = document.createElement('option');
                            option.value = program.name;
                            option.textContent = program.name;
                            programDropdown.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching programs:", error);
                        programDropdown.innerHTML = '<option value="">Error loading programs</option>';
                    });
            } else {
                programDropdown.innerHTML = '<option value="">Select a department first</option>';
            }
        });
    </script>

</body>
</html>
// Function to validate login and handle role-based redirection
/*function validateLogin() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('error-message');

    const data = new FormData();
    data.append('username', username);
    data.append('password', password);

    fetch('includes/formhandler.inc.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to the respective dashboard based on role
            window.location.href = data.redirect_url;
        } else {
            errorMessage.textContent = data.message;  // Show error message
        }
    })
    .catch(error => {
        errorMessage.textContent = 'There was an error processing your request.';
    });
}
*/


// Function to generate course fields based on the number of courses selected by the student
function generateCourseFields() {
    const courseCount = document.getElementById("courseCount").value;
    const courseFieldsContainer = document.getElementById("courseFieldsContainer");
    courseFieldsContainer.innerHTML = ""; // Clear previous fields

    for (let i = 1; i <= courseCount; i++) {
        const label = document.createElement("label");
        label.textContent = `Course ${i}:`;

        const select = document.createElement("select");
        select.name = `course${i}`;

        // Placeholder options for courses; these will be dynamic later
        const placeholderOption = document.createElement("option");
        placeholderOption.value = "";
        placeholderOption.textContent = "Select a course";
        placeholderOption.disabled = true;
        placeholderOption.selected = true;

        const course1 = document.createElement("option");
        course1.value = "Course 1";
        course1.textContent = "Course 1";

        const course2 = document.createElement("option");
        course2.value = "Course 2";
        course2.textContent = "Course 2";

        select.appendChild(placeholderOption);
        select.appendChild(course1);
        select.appendChild(course2);

        courseFieldsContainer.appendChild(label);
        courseFieldsContainer.appendChild(select);
    }
}

// Placeholder function to handle form submission for the student resit form
function submitResitForm() {
    alert("Resit form submitted!");
    return false; // Prevent actual submission for now
}

// Function to load dashboard content based on user role
function loadDashboardContent() {
    const dashboardType = document.body.getAttribute("data-dashboard-type");

    if (dashboardType === "student") {
        // Load student-specific content (e.g., resit form)
        document.getElementById("studentContent").style.display = "block";
    } else if (dashboardType === "hod") {
        // Load HOD-specific content (e.g., approval list)
        document.getElementById("hodContent").style.display = "block";
    }
}

// Call loadDashboardContent on page load
window.onload = loadDashboardContent;

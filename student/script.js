function generateCourseFields() {
    const courseCount = document.getElementById("courseCount").value;
    const courseFieldsContainer = document.getElementById("courseFieldsContainer");
    courseFieldsContainer.innerHTML = ""; // Clear previous fields

    // Fetch courses from the server
    fetch("./includes/student/getCourses.php")
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(courses => {
            if (Array.isArray(courses)) {
                for (let i = 1; i <= courseCount; i++) {
                    const label = document.createElement("label");
                    label.textContent = `Courses ${i}:`;

                    const select = document.createElement("select");
                    select.name = `courses${i}`;

                    const placeholderOption = document.createElement("option");
                    placeholderOption.value = "";
                    placeholderOption.textContent = "Select a course";
                    placeholderOption.disabled = true;
                    placeholderOption.selected = true;
                    select.appendChild(placeholderOption);

                    // Populate courses dynamically
                    courses.forEach(course => {
                        const option = document.createElement("option");
                        option.value = course.course_id; // Use course ID as the value
                        option.textContent = course.course_code;
                        option.textContent = course.course_name;
                        select.appendChild(option);
                    });

                    courseFieldsContainer.appendChild(label);
                    courseFieldsContainer.appendChild(select);
                }
            } else {
                throw new Error('Invalid data received from server');
            }
        })
        .catch(error => {
            console.error('Error fetching courses:', error);
            courseFieldsContainer.innerHTML = `<p style="color: red;">Error loading courses. Please try again later.</p>`;
        });
}

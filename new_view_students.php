<?php
include('connect.php');
session_start();

// Check if the instructor ID is set in the session
if (isset($_SESSION['ins_id'])) {
    $ins_id = $_SESSION['ins_id'];
} else {
    // Redirect if instructor ID is not set
    header('Location: signup.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/view_student.css">
    <title>CSD-Learning Management System</title>
</head>
<body>
    <header>
        <h2>Instructor Portal</h2>
        <h3><?php echo 'Prof. ' . $_SESSION['name']; ?></h3>
    </header>
    <ul class="view">
    <center><h3 class="logo"><img src="CSD.png" alt="CSD E-LMS Logo"></h3></center>
        <hr>
        <li><a href="new_instructor_profile.php" class="active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg> My Courses</a></li>
        <li><a href="assignments.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg> Submissions</a></li>
        <hr class="signout">
        <li><a href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg> Sign out</a></li>
    </ul>
    <div class="container">
    <?php
    $students_per_page = 10; // Number of students per page

    if (isset($_GET['course_id']) && isset($_GET['section'])) {
        // Escape query parameters to prevent SQL injection
        $course_id = mysqli_real_escape_string($conn, $_GET['course_id']);
        $section = mysqli_real_escape_string($conn, $_GET['section']);

        // Retrieve the course name based on the course_id
        $course_name_sql = "SELECT course_name FROM course WHERE course_id = '$course_id'";
        $course_name_result = $conn->query($course_name_sql);

        if ($course_name_result && $course_name_result->num_rows > 0) {
            $course_name_row = $course_name_result->fetch_assoc();
            $course_name = htmlspecialchars($course_name_row['course_name'], ENT_QUOTES, 'UTF-8');

            // Display the course name in the heading
            echo '<h1>Students Enrolled in ' . $course_name . '</h1>';

            // Add the search bar
            echo '<input type="text" id="myInput" class="search" onkeyup="searchTable()" placeholder="Search for names or student IDs..">';
        } else {
            echo '<h1>Students Enrolled</h1>';
        }

        $student_sql = "SELECT student_id, name, course FROM student WHERE section = '$section'";
        $student_result = $conn->query($student_sql);

        if ($student_result && $student_result->num_rows > 0) {
            echo '<div class="table-container" style="margin-left: 80px">';
            echo '<table class="display" id="myTable">';
            echo '<thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Feedback</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
            
            while ($student = $student_result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($student['student_id'], ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($student['course'], ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>
                        <form action="submit_feedback.php" method="post">
                            <input type="text" name="content" placeholder="Enter Comment" class="feedback">
                            <input type="hidden" name="course_id" value="' . htmlspecialchars($course_id, ENT_QUOTES, 'UTF-8') . '">
                            <input type="hidden" name="student_id" value="' . htmlspecialchars($student['student_id'], ENT_QUOTES, 'UTF-8') . '">
                    </td>';
                echo '<td><button type="submit">Submit</button></form></td>';
                echo '</tr>';
            }
            
            echo '</tbody>
                </table>
                </div>';

        } else {
            echo '<p>No students enrolled in this course.</p>';
        }
    } else {
        echo '<p>Invalid course ID or section</p>';
    }

    $conn->close();
?>
</div>

<footer>
  <p>Created By <span class="yellow-text">CSD E Learning System</span> All Rights Reserved</p>
</footer>

    <br>

    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                tr[i].style.display = "none"; // Initially hide all rows
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = ""; // Show the row if any column matches the search
                            break; // No need to check other columns if one match is found
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>

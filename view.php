<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students Enrolled</title>
    <link rel="stylesheet" href="CSS/view.css">
</head>
<body>
    <?php
        include('connect.php');
        session_start();

        $students_per_page = 10; // Number of students per page

        if(isset($_GET['course_id'])) {
            $course_id = $_GET['course_id'];

            // Retrieve the course name based on the course_id
            $course_name_sql = "SELECT course_name FROM course WHERE course_id = $course_id";
            $course_name_result = $conn->query($course_name_sql);

            if ($course_name_result && $course_name_result->num_rows > 0) {
                $course_name_row = $course_name_result->fetch_assoc();
                $course_name = $course_name_row['course_name'];

                // Display the course name in the heading
                echo '<h1>Students Enrolled in "'.$course_name.'"</h1>';
            } else {
                echo '<h1>Students Enrolled</h1>';
            }

            $student_sql = "SELECT student.student_id, student.name, student.email_id, enroll.course_id
                            FROM student
                            INNER JOIN enroll ON student.student_id = enroll.student_id
                            WHERE enroll.course_id = $course_id";

            $student_result = $conn->query($student_sql);

            if ($student_result && $student_result->num_rows > 0) {
                // Pagination logic
                $total_students = $student_result->num_rows;
                $total_pages = ceil($total_students / $students_per_page);

                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }

                $offset = ($page - 1) * $students_per_page;

                // Fetch students for the current page
                $student_sql .= " LIMIT $offset, $students_per_page";
                $student_result = $conn->query($student_sql);

                echo '<div class="search-container">
                        <input type="text" id="myInput" onkeyup="searchTable()" placeholder="Search for names..">
                    </div>
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course ID</th> <!-- New column -->
                                <th>Feedback</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>';

                while ($student = $student_result->fetch_assoc()) {
                    echo '<form action="submit_feedback.php" method="post">
                            <tr>
                                <td>'.$student['student_id'].'</td>
                                <td>'.$student['name'].'</td>
                                <td>'.$student['email_id'].'</td>
                                <td>'.$student['course_id'].'</td>
                                <td><input type="text" name="content" placeholder="Enter Comment"></td>
                                <input type="hidden" name="course_id" value="'.$course_id.'">';          
                                echo '<td><input type="hidden" name="student_id" value="'.$student['student_id'].'">
                                    <button type="submit">Submit</button></td>
                            </tr>
                    </form>';
                }

                echo '</tbody>
                    </table>';

                // Pagination links
                if ($total_pages > 1) {
                    echo '<div class="pagination">';
                    if ($page > 1) {
                        echo '<a href="?course_id='.$course_id.'&page='.($page - 1).'">Previous</a>';
                    }
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo '<a href="?course_id='.$course_id.'&page='.$i.'"';
                        if ($i == $page) {
                            echo ' class="active"';
                        }
                        echo '>'.$i.'</a>';
                    }
                    if ($page < $total_pages) {
                        echo '<a href="?course_id='.$course_id.'&page='.($page + 1).'">Next</a>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<p>No students enrolled in this course.</p>';
            }
        } else {
            echo '<p>Invalid course ID</p>';
        }

        $conn->close();
    ?>

<br>
        <div class="navigation-buttons back-button">
            <a href="display.php">BACK</a>
        </div>
    </form>

    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>

    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Change index to match the column you want to search (Name column)
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>

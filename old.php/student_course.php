<?php
include('connect.php');
session_start();

// Check if the student is logged in and retrieve their ID from the session
if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    // Pagination
    $limit = 10; // Number of courses per page

    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page
    $start = ($page - 1) * $limit; // Offset

    // Fetch courses from database with limit and offset
    $sql = "SELECT * FROM course LIMIT $start, $limit";
    $result = mysqli_query($conn, $sql);

    $total_courses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM course"));
    $total_pages = ceil($total_courses / $limit); // Total pages
} else {
    // Redirect the user to the login page or handle the case where the student is not logged in
    header("Location: login.php");
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/stdCourse.css">
</head>
<body>
    <table class="center">
        <tr>
            <h3> ALL COURSES </h3>
            <th> Course Name </th>
            <th> Description </th>
            <th> Enroll </th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            $cid = $row['course_id'];
            $sql2 = mysqli_query($conn, "SELECT * FROM enroll WHERE student_id='$student_id' AND course_id = '$cid'");
            if ($row2 = mysqli_fetch_assoc($sql2)) {
                echo '<td>' . $row['course_name'] . '</td><td>' . $row['course_description'] . '</td>';
                echo '<form action="enroll_course.php" method = "POST">' .
                    '<input type="text" name="cid" value =' . $row["course_id"] . ' hidden >';
                echo '<td>' . '<input class="btn_disabled" type="button" name="submit" value = "Enroll" disabled>' . '</td>';
                echo ' </form>';
            } else {
                echo '<td>' . $row['course_name'] . '</td><td>' . $row['course_description'] . '</td>';
                echo '<td><button onclick="openEnrollModal(' . $row["course_id"] . ')">Enroll</button></td>';
            }
            echo '</tr>';
        }
        ?>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>

    <!-- Enroll Modal -->
    <div class="modal" id="enrollModal">
        <div class="modal-content">
            <span class="close" onclick="closeEnrollModal()">&times;</span>
            <h2 style="text-align: center;">Enter Subject Code</h2>
            <form action="enroll_course.php" method="POST" onsubmit="return validateSubjectCode()">
                <input type="text" id="subjectCodeInput" name="subject_code" placeholder="Enter Subject Code" required>
                <input type="text" id="courseIdInput" name="cid" hidden>
                <input type="submit" name="submit" value="Enroll">
            </form>
        </div>
    </div>

    <script>
        function openEnrollModal(courseId) {
            document.getElementById('courseIdInput').value = courseId;
            document.getElementById('enrollModal').style.display = "block";
        }

        function closeEnrollModal() {
            document.getElementById('enrollModal').style.display = "none";
        }

        function validateSubjectCode() {
            var subjectCode = document.getElementById('subjectCodeInput').value.trim();
            if (subjectCode === "") {
                alert("Please enter the subject code.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

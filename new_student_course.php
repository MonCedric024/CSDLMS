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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/new_styles.css">
    <link rel="stylesheet" href="CSS/card.css">
    <link rel="stylesheet" href="CSS/add_course.css">
    <link rel="stylesheet" href="CSS/footer.css">
    
    <title>Document</title>
</head>
<body>
  <header>
      <h2>Student Portal</h2>
      <h3><?php echo 'Hello! '.$_SESSION['name']; ?></h3>
  </header>

  <ul>
  <center><h3 class="logo"><img src="CSD.png" alt="CSD E-LMS Logo"></h3></center>
    <hr>
    <li><a href="new_student_profile.php"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M13.45 11.55l2.05 -2.05" /><path d="M6.4 20a9 9 0 1 1 11.2 0z" /></svg> Dashboard</a></li>
    <li><a href="new_mycourse.php" class="active"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg> My Subjects</a></li>
    <hr class="signout">  
    <li><a href="logout.php "> <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg> Sign out</a></li>
  </ul>
  <div>
  <h1>Select Subject <a href="new_mycourse.php"><button class = "add_course" style="float:right; margin-right:50px;">Back to my Subjects</button></a></h1>
  
  
  <div class="container table-container">
  <table class="display">
        <tr>
            <th> Subject Name </th>
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
                echo '<td><button class="btn"onclick="openEnrollModal(' . $row["course_id"] . ')">add</button></td>';
            }
            echo '</tr>';
        }
        ?>
    </table>

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
  </div>
  
  <div class="modal" id="enrollModal">
        <div class="modal-content">
            <span class="close" onclick="closeEnrollModal()">&times;</span>
            <h2 style="text-align: center; color:black">Enter Subject Code</h2>
            <form action="enroll_course.php" method="POST" onsubmit="return validateSubjectCode()">
            <input type="text" id="subjectCodeInput" name="course_code" placeholder="Enter Subject Code" required>
                <input type="text" id="courseIdInput" name="cid" hidden> <!-- Correct field for course_id -->
                <input type="submit" name="submit" value="Enroll">
            </form>

        </div>
    </div>

<footer>
  <p>Created By <span class="yellow-text">CSD E Learning System</span> All Rights Reserved</p>
</footer>

</body>
</html> 
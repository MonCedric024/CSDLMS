<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Courses</title>
    <link rel="stylesheet" href="CSS/displays.css">
    
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Courses</th>
                <th>Students Enrolled</th>
                <th>Students</th>
                <th>Create Lesson</th>
            </tr>
        </thead>
        <tbody>
        <?php
            include('connect.php');
            session_start();

            $sql = "SELECT course.course_id, course.course_name, COUNT(enroll.student_id) AS total_students
                    FROM course
                    LEFT JOIN enroll ON course.course_id = enroll.course_id
                    GROUP BY course.course_id";
            
            $result = $conn->query($sql);

            if($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $course_id = $row['course_id'];
                    $course_name = $row['course_name'];
                    $total_students = $row['total_students'];

                    echo '<tr>
                            <td>'.$course_name.'</td>
                            <td>'.$total_students.'</td>
                            <td><a href="view.php?course_id='.$course_id.'">View</a></td>
                            <td>
                                <form action="create_assignment.php" method="POST">
                                    <input type="hidden" name="course_id" value="' . $course_id . '">
                                    <input type="submit" name="submit" value="Create Lesson">
                                </form>
                            </td>
                          </tr>';
                }
            } else {
                echo "<tr><td colspan='4'>No courses found</td></tr>";
            }

            $conn->close();
        ?>
         </tbody>
    </table>
    <br>
        <div class="navigation">
    <div class="navigation-buttons">
        <a href="instructor_profile.php" class="button">BACK</a>
    </div>
</div>

<footer>
    <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
</footer>
       
</body>
</html>

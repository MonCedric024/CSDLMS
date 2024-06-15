<?php
include('connect.php');
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['assignment_id'])) {
    $assignment_id = $_GET['assignment_id'];
    $subject = $_GET['subject'];

    // Fetch assignment details and associated files
    $sql = "SELECT a.*, af.file_path FROM assignment a 
            LEFT JOIN assignment_files af ON a.assignment_id = af.assignment_id 
            WHERE a.assignment_id = '$assignment_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $assignment_files = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $assignment_description = $row['description'];
            $due_time = $row['due_time'];
            $assignment_files[] = $row['file_path'];
        }

        $student_id = $_SESSION['student_id'];
        $submit_query = "SELECT * FROM submit_assignment WHERE assignment_id = '$assignment_id' AND student_id = '$student_id'";
        $submit_result = mysqli_query($conn, $submit_query);

        if (mysqli_num_rows($submit_result) == 1) {
            $submission = mysqli_fetch_assoc($submit_result);
            $submission_status = "Submitted";
            $submission_marks = $submission['marks'] !== null ? $submission['marks'] : 'Not yet graded';
        } else {
            $submission_status = "Not yet submitted";
            $submission_marks = '';
        }
        
        // Check if the current time is before the due time
        $current_time = time();
        $due_timestamp = strtotime($due_time);
        $time_left = $due_timestamp - $current_time;
        $days_left = floor($time_left / (60 * 60 * 24));
        $hours_left = floor(($time_left % (60 * 60 * 24)) / (60 * 60));
        $is_past_due = $current_time > $due_timestamp;
    } else {
        echo "Assignment not found";
        exit();
    }
} else {
    echo "Assignment ID not provided";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/new_styles.css">
    <link rel="stylesheet" href="CSS/accordions.css">
    <title>Assignments</title>
</head>

<body>
    <header>
        <h2>Student Portal</h2>
        <h3><?php echo 'Hello! ' . htmlspecialchars($_SESSION['name']); ?></h3>
    </header>

    <!-- Navigation Menu -->
    <ul class="view" style="width: 410px;">
        <center><h3 class="logo"><img src="CSD.png" alt="CSD E-LMS Logo"></h3></center>
        <hr>
        <li><a href="new_student_profile.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M13.45 11.55l2.05 -2.05" />
                <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
            </svg> Dashboard</a></li>
        <li><a href="new_mycourse.php" class="active">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-book">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                <path d="M3 6l0 13" />
                <path d="M12 6l0 13" />
                <path d="M21 6l0 13" />
            </svg> My Courses</a></li>
        <li><a href="logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                <path d="M15 12h-12l3 -3" />
                <path d="M6 15l-3 -3" />
            </svg> Sign out</a></li>
    </ul>


    <ul class="course" style="width: 200px; margin-left: 300px;  margin-right: 10px;">
        <p class="course_name"><?php echo isset($_SESSION['course_name']) ? htmlspecialchars($_SESSION['course_name']) : ''; ?></p>
        <!-- <li><a href="new_view_course_home.php?subject=<?php echo $subject; ?>">Home</a></li> -->
        <li><a href="new_view_course.php?subject=<?php echo $subject; ?>">Modules</a></li>
        <li><a href="new_student_assignment.php?subject=<?php echo $subject; ?>" class="course_active">Assignments</a></li>
        <li><a href="new_feedback.php?course_id=<?php echo $course_id; ?>">Feedbacks</a></li>
    </ul>

    <!-- Assignment Details Section -->
    <div class="accordion_box" style="margin-left: 550px;">
        <h1>Assignment Details</h1>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($assignment_description); ?></p>
        <p><strong>Due Time:</strong> 
            <?php 
                echo htmlspecialchars($due_time); 
                // Display time left before the deadline
                if (!$is_past_due) {
                    echo " (";
                    if ($days_left > 0) {
                        echo $days_left . " day" . ($days_left != 1 ? "s" : "") . " ";
                    }
                    echo $hours_left . " hour" . ($hours_left != 1 ? "s" : "") . " left)";
                } else {
                    echo " (Expired)";
                }
            ?>
        </p>
        <p><strong>Submission Status:</strong> <?php echo htmlspecialchars($submission_status); ?></p>
        <p><strong>Marks:</strong> <?php echo htmlspecialchars($submission_marks); ?></p>

        <!-- File Download Links -->
        <p><strong>Assignment Files:</strong></p>
        <?php
            if (!empty($assignment_files)) {
                foreach ($assignment_files as $file_path) {
                    if (!empty($file_path)) {
                        echo '<a href="' . htmlspecialchars($file_path, ENT_QUOTES, 'UTF-8') . '" style="color: black;" download>' . htmlspecialchars(basename($file_path), ENT_QUOTES, 'UTF-8') . '</a><br>';
                    } else {
                        echo 'No file uploaded for this assignment<br>';
                    }
                }
            } else {
                echo 'No file uploaded for this assignment';
            }
        ?>
        <div style="margin-top: 30px;">
            <?php if ($submission_status === "Not yet submitted" && !$is_past_due): ?>
                <form action="submit_assignment.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="subject" value="<?php echo htmlspecialchars($subject); ?>">
                    <input type="hidden" name="aid" value="<?php echo htmlspecialchars($assignment_id); ?>">
                    <input type="hidden" name="cid" value="<?php echo htmlspecialchars($course_id); ?>">
                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                    <input type="file" name="file" required>
                    <input type="submit" name="submit" value="Submit Assignment">
                </form>
            <?php elseif ($is_past_due): ?>
                <p style="color: red;">The deadline for this assignment has passed. You can no longer submit your assignment.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

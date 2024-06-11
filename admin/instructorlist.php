<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$connection = new mysqli($servername, $username, $password, $database);

$course_duration = "";
$course_id = "";
$course_name = "";
$instructor_id = "";
$course_description = "";
$starting_time = "";

$errorMessage = "";
$successMessage = "";

$subject_id = htmlspecialchars($_GET['id']);
$course_id = htmlspecialchars($_GET['course_id']);

$sql = "SELECT * FROM course WHERE course_id = $course_id";
$result1 = $connection->query($sql);

if (!$result1) {
    die("Invalid query: " . $connection->error);
}

if ($result1->num_rows > 0) {
    $row = $result1->fetch_assoc();
    $course_name = $row['course_name'];
    $course_code = $row['course_code'];
} else {
    echo "<p>No course found with ID: $course_id</p>";
    exit;
}

// View Instructor
$sql = "
    SELECT 
        i.ID, 
        i.contact_no, 
        i.instructor_name, 
        i.instructor_id, 
        i.email_id, 
        i.password, 
        i.status,
        isub.subject_id,
        isub.section
    FROM 
        instructor_subject AS isub
    LEFT JOIN 
        instructor AS i 
    ON 
        isub.instructor_id = i.id 
    WHERE 
        isub.subject_id = $subject_id;
";
$resultinstructor = $connection->query($sql);
if (!$resultinstructor) {
    die("Invalid query: " . $connection->error);
}

// Add Instructor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $instructor_id = $_POST["instructor_id"];
    $section = $_POST["section"];

    if (empty($instructor_id)) {
        $errorMessage = "All the fields are required";
    } else {
        $sql = "INSERT INTO instructor_subject (subject_id, instructor_id, section) " . 
               "VALUES ('$subject_id', '$instructor_id', '$section')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        } else {
            $successMessage = "Added Successfully";
            header("location: ../admin/instructorlist.php?id=$subject_id&course_id=$course_id");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>ADMIN</title>
    <link rel = "stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <div class="row">
        <div class="col-md-5 justify-content-start">
            <h2 class="text-center">Assign New Instructor</h2>
            <?php
            if (!empty($errorMessage)) {
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
            ?>
            <form method="post" class="mx-auto" style="max-width: 100%;">
            <?php
                $query = "SELECT `ID`, `instructor_name` FROM `instructor` WHERE 1";
                $result = $connection->query($query);

                if ($result->num_rows > 0) {
                    echo '
                    <div class="mb-3">
                        <label class="form-label">Instructor</label>
                        <select class="form-control" name="instructor_id">
                            <option value="">Select an Instructor</option>';
                    
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['ID'] . '">' . $row['instructor_name'] . '</option>';
                    }

                    echo '
                        </select>
                    </div>';
                } else {
                    echo '
                    <div class="mb-3">
                        <label class="form-label">Instructor</label>
                        <select class="form-control" name="instructor_id">
                            <option value="">No instructors available</option>
                        </select>
                    </div>';
                }
                ?>
                <?php
                if (!empty($successMessage)) {  
                    echo "
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                    </div>";
                }
                ?>
                <div class="mb-3">
                    <label class="form-label">Section</label>
                    <select class="form-control" name="section">
                        <option value="<?php echo $course_code; ?>-A"><?php echo $course_code; ?>-A</option>
                        <option value="<?php echo $course_code; ?>-B"><?php echo $course_code; ?>-B</option>
                    </select>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a class="btn btn-outline-primary" href="subjectlist.php?id=<?php echo $course_id ?>" role="button">Cancel</a>
                </div>
            </form>
        </div>
        
        <div class="col-md-1">
        </div>

        <div class="col-md-6">
            <h2 class="text-center">Subject Instructor List</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>SECTION</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($resultinstructor->num_rows > 0) {
                            while ($row = $resultinstructor->fetch_assoc()) {
                                echo "
                                <tr>
                                    <td>{$row['instructor_id']}</td>
                                    <td>{$row['instructor_name']}</td>
                                    <td>{$row['email_id']}</td>
                                    <td>{$row['section']}</td>
                                    <td>
                                        <a href='editstudent.php?id={$row['ID']}' class='btn btn-success btn-sm me-2'>Edit</a>
                                        <a href='deletestudent.php?id={$row['ID']}' class='btn btn-danger btn-sm'>Delete</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "
                            <tr>
                                <td colspan='5' class='text-center'>No data available</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
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

$course_id = htmlspecialchars($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST["subject"];
    $description = $_POST["description"];

    if (empty($subject)|| empty($description)) {
        $errorMessage = "All the fields are required";
    } else {
        $sql = "INSERT INTO subject (course_id, title, description) " . 
               "VALUES ('$course_id', '$subject', '$description')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        } else {
            $successMessage = "Added Successfully";
            header("location: ../admin/subjectlist.php?id=$course_id");
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
        <h2 class="text-center">Insert Subject</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>
        <form method="post" class="mx-auto" style="max-width: 600px;">
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" class="form-control" name="subject" value="">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="8"></textarea>
            </div>
            <?php
            if (!empty($successMessage)) {  
                echo "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$successMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                </div>";
            }
            ?>
            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <a class="btn btn-outline-primary" href="subjectlist.php?id=<?php echo $course_id ?>" role="button">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
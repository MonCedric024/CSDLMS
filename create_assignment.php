<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/create_Assignments.css">


</head>

<style>

.modal {
    display: none; 
    position: fixed;
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0, 0, 0, 0.4); 
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 5px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
<body>

    <form action="upload_assignment.php" id="assignment_form" method="POST" enctype="multipart/form-data" onsubmit="return validateDate()">
        <?php
        include('connect.php');
        session_start();

        if (isset($_GET['course_id'])) {
            $_SESSION['course_id'] = $_GET['course_id']; 
            
        } else {
           
            header('Location: new_instructor_profile.php');
            exit();
        }
        ?>
        <br>
        <div>
            <label for="Assignment">Assignment Description : </label>
            <textarea name="description" id="assignment_form" cols="30" rows="4"></textarea>
        </div>
        <div>
            <input type="file" name="file">
        </div>
        <div>
            <input type="datetime-local" name="due_time" id="due_time">Due Date
            <p id="date-error" style="color: red;"></p>
        </div>
        <div>
            <button type="submit" name="submit"> Upload File</button>
        </div>
        <div class="navigation">
            <div class="navigation-buttons">
                <a href="new_instructor_profile.php" class="button">BACK</a>
                <a href="view_assignments.php?course_id=<?php echo $_GET['course_id']; ?>" class="button">View Assignments</a>
            </div>
        </div>
    </form>

    <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="modal-message"></p>
    </div>
</div>
    <?php
    // print_r($_POST);
    // print_r($_POST);
    ?>

    <br>
    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>


    <script>
function validateDate() {
    var inputDate = new Date(document.getElementById("due_time").value);
    var currentDate = new Date();
    if (inputDate < currentDate) {
        
        var modal = document.getElementById("myModal");
        var modalMessage = document.getElementById("modal-message");
        modalMessage.textContent = "Due date cannot be in the past.";
        modal.style.display = "block";

        
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        };

        
        return false;
    } else {
        return true;
    }
}
</script>
</body>

</html>


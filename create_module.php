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
    <form action="upload_module.php" id="assignment_form" method="POST" enctype="multipart/form-data" onsubmit="return validateDate()">
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
            <label for="Assignment">Module Description : </label>
            <textarea name="description" id="module_form" cols="30" rows="4"></textarea>
            <input type="hidden" name="section" value="<?php echo $_GET['section']; ?>">
            <input type="hidden" name="subject" value="<?php echo $_GET['subject']; ?>">
        </div>
        <div>
            <input type="file" name="files[]" id="fileInput" multiple onchange="updateFileList(this)">
        </div>
        <div id="fileList" style="margin-bottom: 30px;"></div> <!-- Container for the list of selected files -->
        <div>
            <button type="submit" name="submit"> Upload File</button>
        </div>
        <div class="navigation">
            <div class="navigation-buttons">
                <a href="new_instructor_profile.php" class="button">BACK</a>
                <a href="view_module.php?course_id=<?php echo $_GET['course_id']; ?>&section=<?php echo $_GET['section']; ?>&subject=<?php echo $_GET['subject']; ?>" class="button">View Modules</a>
            </div>  
        </div>
    </form>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>

    <br>
    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>

    <script>
    function updateFileList(input) {
        var fileListDiv = document.getElementById('fileList');
        fileListDiv.innerHTML = '';
        
        for (var i = 0; i < input.files.length; i++) {
            var file = input.files[i];
            var listItem = document.createElement('div');
            listItem.textContent = file.name;
            fileListDiv.appendChild(listItem);
        }
    }
    </script>
</body>
</html>


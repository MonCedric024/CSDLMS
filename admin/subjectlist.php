<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$course_id = htmlspecialchars($_GET['id']);

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT * FROM subject WHERE course_id = $course_id";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">

	<title>AdminHub</title>
</head>
<style>
.course-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.course-box {
    width: calc(50% - 10px); 
	height: 330px;
    background-color: #f9f9f9;
    border: 5px solid #ddd;
    border-radius: 30px;
    margin-bottom: 20px;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start; 
}

.course-info {
    flex: 1; 
}

.course-info p {
    margin: 5px 0;
}

.course-actions {
    display: flex;
    flex-direction: column; 
    align-items: flex-end; 
}

.edit-button,
.delete-button {
    color: #fff;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 3px;
    margin-top: 10px;
	width: 120px;
}

.edit-button {
    background-color: #007bff; 
}

.delete-button {
    background-color: #dc3545; 
}

.edit-button:hover,
.delete-button:hover {
    opacity: 0.8;
}

.course-actions .delete-button i {
    color: #fff;
    margin-right: 5px;
}
</style>
<body>
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">AdminHub</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="adminstudent.php">
					<i class='bx bxs-user-rectangle' ></i>
					<span class="text">Students</span>
				</a>
			</li>
			<li>
				<a href="admininstructor.php">
					<i class='bx bxs-user-badge' ></i>
					<span class="text">Instructor</span>
				</a>
			</li>
			<li class="active">
				<a href="admincourses.php">
					<i class='bx bxs-book-content' ></i>
					<span class="text">Courses</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
                    <h1>All Subjects of <?php echo $course_code; ?> - <?php echo $course_name; ?></h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.php">Dashboard</a>
						</li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
							<a href="admincourses.php">Courses</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="subjectlist.php">Subjects</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<a class='btn' href='addsubject.php?id=<?php echo $course_id; ?>' role button><i class='bx bx-plus' ></i></a>
					<span class="text">
						<a class='btn' href='addsubject.php?id=<?php echo $course_id; ?>' role='button'>New Subject</a>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Subject</h3>
						<!-- <i class='bx bx-search' ></i> -->
					</div>
					<div class="course-container">
						<?php
						while ($row = $result->fetch_assoc()) {
							echo "
								<div class='course-box'>
									<div class='course-info'>
										<p><strong>TITLE:</strong> {$row['title']}</p>
										<p><strong>COURSE DESCRIPTION:</strong> {$row['description']}</p>
									</div>	
									<div class='course-actions'>
										<a href='editcourse.php?id={$row['id']}' class='edit-button' style='margin-top: 175px;'><i class='bx bxs-edit'></i> Edit</a>
										<a href='deletecourse.php?id={$row['id']}' class='delete-button'><i class='bx bxs-trash-alt'></i> Delete</a>"; ?>
                                        <a href="instructorlist.php?id=<?php echo $row['id']; ?>&course_id=<?php echo $course_id; ?>" class="edit-button" style="background-color: green;"><i class="bx bxs-edit"></i> Instructor</a>
                        <?php
                            echo "
									</div>
								</div>";
							}
						?>
					</div>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
</html>
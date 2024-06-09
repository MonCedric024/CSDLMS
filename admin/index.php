<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql_student = "SELECT * FROM student";
$result_student = $connection->query($sql_student);

if (!$result_student) {
    die("Invalid query: " . $connection->error);
}

$sql_teacher = "SELECT * FROM instructor";
$result_teacher = $connection->query($sql_teacher);

if (!$result_teacher) {
    die("Invalid query: " . $connection->error);
}

$sql_course = "SELECT * FROM course";
$result_course = $connection->query($sql_course);

if (!$result_course) {
    die("Invalid query: " . $connection->error);
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
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">AdminHub</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
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
			<li>
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
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.php">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="index.html">Home</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-user-rectangle' ></i>
					<span class="text">
						<?php
							$dash_student_query = "SELECT * FROM student";
							$dash_student_query_run = mysqli_query($connection, $dash_student_query);

							if($student_total = mysqli_num_rows($dash_student_query_run)){
								echo '<h4 class="mb-0"> '.$student_total.' </h4>';
							}
							else {
								echo '<h4 class="mb-0"> No Data </h4>';
							}
						?>
						<p>STUDENTS</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-user-badge' ></i>
					<span class="text">
						<?php
							$dash_instructor_query = "SELECT * FROM instructor";
							$dash_instructor_query_run = mysqli_query($connection, $dash_instructor_query);

							if($instructor_total = mysqli_num_rows($dash_instructor_query_run)){
								echo '<h4 class="mb-0"> '.$instructor_total.' </h4>';
							}
							else {
								echo '<h4 class="mb-0"> No Data </h4>';
							}
						?>
						<p>INSTRUCTORS</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-book-content' ></i>
					<span class="text">
						<?php
							$dash_course_query = "SELECT * FROM course";
							$dash_course_query_run = mysqli_query($connection, $dash_course_query);

							if($course_total = mysqli_num_rows($dash_course_query_run)){
								echo '<h4 class="mb-0"> '.$course_total.' </h4>';
							}
							else {
								echo '<h4 class="mb-0"> No Data </h4>';
							}
						?>
						<p>COURSES</p>
					</span>
				</li>
				<li>
					<a class='btn' href='addadmin.php' role button><i class='bx bx-plus' ></i></a>
					<span class="text">
						<a class='btn' href='addadmin.php' role='button'>Add Admin</a>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<table>
					<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>List of Students</h3>
						<i class='bx bx-search' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>NAME</th>
								<th>CONTACT NO</th>
								<th>STUDENT ID</th>
								<th>COURSE</th>
							</tr>
						</thead>
						<tbody>
							<?php
                   			 while ($row = $result_student->fetch_assoc()) {
                       		 echo "
                        		<tr>
                          			 <td>{$row['name']}</td>
                           			 <td>{$row['contactno']}</td>
                           			 <td>{$row['student_id']}</td>
									 <td>{$row['course']}</td>
                        		</tr>";
                    		}
                    		?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Instructor List</h3>
						<i class='bx bx-search' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>CONTACT NO</th>
								<th>NAME</th>
								<th>INSTRUCTOR ID</th>
								<th>EMAIL</th>
							</tr>
						</thead>
						<tbody>
						<?php
                   		 while ($row = $result_teacher->fetch_assoc()) {
                       		 echo "
                       			 <tr>
                            		<td>{$row['contact_no']}</td>
                           			<td>{$row['instructor_name']}</td>
                            		<td>{$row['instructor_id']}</td>
                            		<td>{$row['email_id']}</td>
                        		</tr>";
                    		}
                    	?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Courses</h3>
						<i class='bx bx-search' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>COURSE DURATION</th>
								<th>COURSE ID</th>
								<th>COURSE NAME</th>
								<th>INSTRUCTOR ID</th>
								<th>COURSE TIME</th>
							</tr>
						</thead>
						<tbody>
							<?php
                   				while ($row = $result_course->fetch_assoc()) {
                       		 	echo "
                        			<tr>
                          			 	<td>{$row['course_duration']}</td>
                           			 	<td>{$row['course_id']}</td>
                           			 	<td>{$row['course_name']}</td>
                           			 	<td>{$row['instructor_id']}</td>
                           			 	<td>{$row['starting_time']}</td>
                        			</tr>";
                    			}
                    		?>
						</tbody>
					</table>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
</html>
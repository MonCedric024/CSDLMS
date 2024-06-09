<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT * FROM student";
$result = $connection->query($sql);

if (!$result) {
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
			<li>
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
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
					<h1>All Students</h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.php">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="adminstudent.php">Student</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<a class='btn' href='addstudent.php' role button><i class='bx bx-plus' ></i></a>
					<span class="text">
						<a class='btn' href='addstudent.php' role='button'>Add Student</a>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Student List</h3>
						<i class='bx bx-search' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>NAME</th>
								<th>CONTACT NO</th>
								<th>AGE</th>
								<th>ADDRESS</th>
								<th>EMAIL</th>
								<th>BIRTHDATE</th>
								<th>GENDER</th>
								<th>STUDENT ID</th>
								<th>COURSE</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
                   			 while ($row = $result->fetch_assoc()) {
                       		 echo "
                        		<tr>
                          			 <td>{$row['name']}</td>
                           			 <td>{$row['contactno']}</td>
                           			 <td>{$row['age']}</td>
                           			 <td>{$row['address']}</td>
                           			 <td>{$row['email_id']}</td>
                           			 <td>{$row['dob']}</td>
                            		 <td>{$row['gender']}</td>
                           			 <td>{$row['student_id']}</td>
									 <td>{$row['course']}</td>
                        	    	<td>
                              		 	<a href='editstudent.php?id={$row['student_id']}'><i class='bx bxs-edit' ></i></a>
                                	 	<a href='deletestudent.php?id={$row['student_id']}'><i class='bx bxs-trash-alt' ></i></a>
                            		</td>
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
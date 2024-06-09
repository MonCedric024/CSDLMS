<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT * FROM instructor";
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
			<li>
				<a href="adminstudent.php">
					<i class='bx bxs-user-rectangle' ></i>
					<span class="text">Students</span>
				</a>
			</li>
			<li class="active">
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
					<h1>All Instructor</h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.php">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="admininstructor.php">Instructor</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<a class='btn' href='addinstructor.php' role button><i class='bx bx-plus' ></i></a>
					<span class="text">
						<a class='btn' href='addinstructor.php' role='button'>Add Instructor</a>
					</span>
				</li>
			</ul>


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
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody>
						<?php
                   		 while ($row = $result->fetch_assoc()) {
                       		 echo "
                       			 <tr>
                            		<td>{$row['contact_no']}</td>
                           			<td>{$row['instructor_name']}</td>
                            		<td>{$row['instructor_id']}</td>
                            		<td>{$row['email_id']}</td>
                            		<td>
                              		 	<a href='editinstructor.php?id={$row['instructor_id']}'><i class='bx bxs-edit' ></i></a>
                                	 	<a href='deleteinstructor.php?id={$row['instructor_id']}'><i class='bx bxs-trash-alt' ></i></a>
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
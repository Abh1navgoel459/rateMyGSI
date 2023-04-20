<!DOCTYPE html>
<html>
<head>
	<title>Teacher Rating</title>
	<style>
		body {
			background-color: #f2f2f2;
		}
		#teacher-rating {
			display: flex;
			flex-direction: column;
			align-items: center;
			padding-top: 50px;
		}
		h1 {
			font-size: 60px;
			text-align: center;
			margin-bottom: 20px;
		}
		h2 {
			font-size: 40px;
			color: #002080;
			text-align: center;
			margin-bottom: 20px;
		}
		button[type="submit"] {
			font-size: 30px;
			padding: 10px 20px;
			border-radius: 5px;
			border: none;
			background-color: #002080;
			color: white;
			cursor: pointer;
		}
		button[type="submit"]:hover {
			background-color: #0040bf;
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<?php
		if(isset($_POST['firstName']) && isset($_POST['lastName'])) {
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];

			// Connect to the database
			$con = mysqli_connect('127.0.0.1', 'student', 'student123456789','teacher_rating_system');

			// Search for the teacher's ID in the database using their first and last name
			$sql = "SELECT teacher_id FROM teacher_ratings WHERE firstName = '$firstName' AND lastName = '$lastName'";
			$result = mysqli_query($con, $sql);

			if($result->num_rows > 0) {
				$row = mysqli_fetch_assoc($result);
				$teacher_id = $row['teacher_id'];
				// Get the average rating for the teacher from the database
				$sql = "SELECT avg_rating FROM teacher_ratings WHERE teacher_id = $teacher_id";
				$result = $con->query($sql);

				if($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$average_rating = round($row['avg_rating'], 2);
				} else {
					$average_rating = "N/A";
				}

				// Display teacher's name and rating
				echo '<div id="teacher-rating">';
				echo '<h1>' . $firstName . ' ' . $lastName . '</h1>';
				echo '<h2>' . $average_rating . ' out of 5</h2>';
				echo '<button type="submit" onclick="location.href = \'submit_rating1.php?firstName=' . urlencode($firstName) . '&lastName=' . urlencode($lastName) . '&teacher_id=' . urlencode($teacher_id) . '\';">Rate this GSI</button>';
				echo '</div>';
			} else {
				// Display message if teacher not found in the database
				echo '<h2>Teacher not found</h2>';
			}

			// Close database connection
			mysqli_close($con);
		}
		?>
	</div>
</body>
</html>
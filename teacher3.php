<!DOCTYPE html>
<html>
<head>
    <title>Teacher Rating</title>
    <style>
        body {
            background-color: #162447;
            margin: 0;
        }

        .container {
            padding: 20px;
            margin: 20px;
            text-align: left;
            color: white;
        }

        .title {
            font-family: 'DeliusUnicaseRegular', sans-serif;
            font-size: 36px;
            font-weight: normal;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-left: 20px;
        }

        .rate-button {
            height: 40px;
            border-radius: 5px;
            padding: 5px 15px;
            font-size: 14px;
            background-color: #9b730fb0;
            color: #ffffff;
            border: none;
            cursor: pointer;
            margin-left: 20px;
        }

        .line {
            height: 2px;
            background-color: #162447;
            width: calc(50% - 40px);
            margin-left: 20px;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer p {
            margin: 0;
        }

        .footer a {
            color: #9b730fb0;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if(isset($_POST['firstName'])) {
        $firstName = $_POST['firstName'];
        $studentId = $_SESSION['student_id'];

        // Connect to the database
        $con = mysqli_connect('127.0.0.1', 'student', 'student123456789','teacher_rating_system');

        // Search for the teacher's ID in the database using their first name
        $sql = "SELECT teacher_id FROM teacher_ratings WHERE firstName = '$firstName'";
        $result = mysqli_query($con, $sql);

        if($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $teacher_id = $row['teacher_id'];
            // Get the average rating for the teacher from the database
            $sql = "SELECT avg_rating, diff_rating, repeat_gsi, Class FROM teacher_ratings WHERE teacher_id = $teacher_id";
            $result = $con->query($sql);

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $average_rating = round($row['avg_rating'], 2);
                $difficulty_rating = round($row['diff_rating'], 2);
                $repeat_percentage = $row['repeat_gsi'];
            } else {
                $average_rating = "N/A";
                $difficulty_rating = "N/A";
                $repeat_percentage = "N/A";
            }

            // Get the number of ratings for the teacher
            $sql = "SELECT COUNT(*) as count FROM student_teacher WHERE teacher_id = $teacher_id";
            $result = $con->query($sql);
            $ratings_count = $result->fetch_assoc()['count'];

            echo '<div class="container">';
            echo '<h2 style="margin-left: 20px;">Average Rating: ' . $average_rating . '/5</h2>';
            echo '<h1 style="margin-left: 20px;">' . $firstName . '</h1>';
            echo '<p class="small-font" style="margin-left: 20px;">Teaches ' . $row['Class'] . '</p>';
            echo '<p class="small-font" style="margin-left: 20px;">Based on ' . $ratings_count . ' rating' . ($ratings_count != 1 ? 's' : '') . '</p>';
            echo '<p style="margin-left: 20px; display: inline-block;">Will take again: ' . $repeat_percentage . '%</p>';
            echo '<p style="margin-left: 10px; display: inline-block;">Difficulty Rating: ' . $difficulty_rating . '/5</p>';
            echo '<div class="line"></div>';
            echo '<form method="post" action="submit_rating1.php">';
            echo '<input type="hidden" name="teacher_id" value="' . $teacher_id . '">';
            echo '<input type="hidden" name="firstName" value="' . $firstName . '">'; // Include the firstName value
            echo '<button class="rate-button" type="submit">Rate ' . $firstName . '</button>';
            echo '</form>';
            echo '</div>';
        } else {
            // Display message if teacher not found in the database
            echo '<div class="container">';
            echo '<h2>Teacher not found</h2>';
            echo '<p><a href="https://docs.google.com/forms/d/e/1FAIpQLSdyOfBkm2ytZmNEVBNZLJ-SR1rpVre8_EbP0_zuJpSt4OsE_w/viewform?usp=sf_link/viewform">Add this teacher to our rating system now!</a></p>';
            echo '</div>';
        }

        // Close database connection
        mysqli_close($con);
    }
    ?>
</body>
</html>

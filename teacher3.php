<!DOCTYPE html>
<html>
<head>
    <title>Teacher Rating</title>
    <?php
    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // Redirect to the login page
        header('Location: login.html');
        exit();
    }
    ?>
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
            position: relative;
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

        .add-comments-button {
            height: 40px;
            border-radius: 5px;
            padding: 5px 15px;
            font-size: 14px;
            background-color: #162447;
            color: #ffffff;
            border: none;
            cursor: pointer;
            margin-left: 20px;
            margin-bottom: 20px;
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

        .comments-label {
            font-size: 18px;
            margin-top: 20px;
            margin-right: 150px;
            text-align: right;
            position: absolute;
            top: 0;
            right: 0;
            color: #FFD700;
        }

        .comment-container {
            padding: 10px;
            margin-right: 10px;
            background-color: #ffffff;
            color: #162447;
            width: calc(50% - 60px);
            float: right;
            clear: both;
        }

        .scroll-container {
            max-height: 400px;
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    $_SESSION['submitted'] = false;
    if(isset($_POST['firstName'])) {
        $firstName = $_POST['firstName'];
        $student_id = $_SESSION['student_id'];

        // Connect to the database
        $con = mysqli_connect('127.0.0.1', 'student', 'student123456789','teacher_rating_system');

        // Search for the teacher's ID in the database using their first name
        $sql = "SELECT teacher_id FROM teacher_ratings WHERE firstName = '$firstName'";
        $result = mysqli_query($con, $sql);

        if($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $teacher_id = $row['teacher_id'];
            // Get the average rating for the teacher from the database
            $sql = "SELECT avg_rating, diff_rating, repeat_gsi, avg_grade, Class FROM teacher_ratings WHERE teacher_id = $teacher_id";
            $result = $con->query($sql);

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $average_rating = round($row['avg_rating'], 2);
                $difficulty_rating = round($row['diff_rating'], 2);
                $repeat_percentage = $row['repeat_gsi'];
                $avg_grade = round($row['avg_grade'], 2);
            } else {
                $average_rating = "N/A";
                $difficulty_rating = "N/A";
                $repeat_percentage = "N/A";
                $avg_grade = "N/A";
            }

            // Get the number of ratings for the teacher
            $sql = "SELECT COUNT(*) as count FROM student_teacher WHERE teacher_id = $teacher_id";
            $result = $con->query($sql);
            $ratings_count = $result->fetch_assoc()['count'];

            // Display teacher information and ratings
            echo '<div class="container">';
            echo '<h2 style="margin-left: 20px;">Average Rating: ' . $average_rating . '/5</h2>';
            echo '<h1 style="margin-left: 20px;">' . $firstName . '</h1>';
            echo '<p class="small-font" style="margin-left: 20px;">Teaches ' . $row['Class'] . '</p>';
            echo '<p class="small-font" style="margin-left: 20px;">Based on ' . $ratings_count . ' rating' . ($ratings_count != 1 ? 's' : '') . '</p>';
            echo '<p style="margin-left: 20px; display: inline-block;">Will take again: ' . $repeat_percentage . '%</p>';
            echo '<p style="margin-left: 10px; display: inline-block;">Difficulty Rating: ' . $difficulty_rating . '/5</p>';
            echo '<p style="margin-left: 20px; display: inline-block;">Average GPA: ' . $avg_grade . '</p>';
            echo '<div class="line"></div>';

            // Get all comments for the teacher
            $sql = "SELECT comments FROM teacher_comments WHERE teacher_id = $teacher_id";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="scroll-container">'; // Add scroll-container div
                echo '<p class="comments-label">See what your fellow bears are saying about ' . $firstName . '</p>'; // Comments label
                while ($row = $result->fetch_assoc()) {
                    $comment = urldecode($row['comments']); // Decode the URL-encoded comment

                    // Display each comment in a separate container
                    echo '<div class="comment-container">';
                    echo '<p>' . htmlspecialchars($comment) . '</p>';
                    echo '</div>';
                }
                echo '</div>'; // Close scroll-container div
            } else {
                echo '<p class="comments-label">See what your fellow bears are saying about ' . $firstName . '</p>'; // Comments label when no comments available
            }
            echo '<div style="margin-left: 20px;">';
            // Rate Button
            echo '<form method="post" action="submit_rating1.php" style="display: inline-block;">';
            echo '<input type="hidden" name="teacher_id" value="' . $teacher_id . '">';
            echo '<input type="hidden" name="firstName" value="' . $firstName . '">'; // Include the firstName value
            echo '<button class="rate-button" type="submit">Rate ' . $firstName . '</button>';
            echo '</form>';

            // Add Comments Button
            echo '<form method="post" action="add_comments.php" style="display: inline-block; margin-left: 10px;">';
            echo '<input type="hidden" name="teacher_id" value="' . $teacher_id . '">';
            echo '<input type="hidden" name="firstName" value="' . $firstName . '">'; // Include the firstName value
            echo '<input type="hidden" name="student_id" value = "' . $student_id . '">';
            echo '<button class="rate-button" type="submit">Add Comments</button>';
            echo '</form>';

            echo '</div>';
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

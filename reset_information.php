<!DOCTYPE html>
<html>
<head>
    <title>Reset Information</title>
    <style>
        body {
            background-color: #162447;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 400px;
            padding: 20px;
            border: 1px solid black;
            text-align: center;
            background-color: white;
            color: black;
        }

        .title {
            font-family: 'DeliusUnicaseRegular', sans-serif;
            font-size: 36px;
            font-weight: normal;
            margin-bottom: 30px;
            letter-spacing: 2px;
            color: #162447;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="username"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #9b730fb0;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Get the email address from the URL parameter

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Get the user input from the form
            $newUsername = $_POST["username"];
            $newPassword = $_POST["password"];
            $email = $_POST["email"];

            // Connect to the database
            $con = mysqli_connect('127.0.0.1', 'student', 'student123456789', 'teacher_rating_system');

            // Check if the email exists in the students table
            $query = "SELECT * FROM students WHERE emailAddress = '$email'";
            $result = mysqli_query($con, $query);

            if ($result->num_rows > 0) {
                // Check if the new username or password already exists for the given email address
                $existingQuery = "SELECT * FROM students WHERE emailAddress = '$email' AND (username = '$newUsername' OR password = '$newPassword')";
                $existingResult = mysqli_query($con, $existingQuery);

                if ($existingResult->num_rows > 0) {
                    echo "You have already used either the username or password before.";
                } else {
                    // Update the record with the new username and password
                    $updateQuery = "UPDATE students SET username = '$newUsername', password = '$newPassword' WHERE emailAddress = '$email'";
                    if (mysqli_query($con, $updateQuery)) {
                        echo "Username and password updated successfully.";
                        echo '<button onclick="window.location.href = \'login.html\';">Go to Login</button>';
                    } else {
                        echo "Failed to update username and password.";
                    }
                }
            } else {
                echo "Email not found in the database.";
            }

            // Close the database connection
            mysqli_close($con);
        }
        ?>
    </div>
</body>
</html>

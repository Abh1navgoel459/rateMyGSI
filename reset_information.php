<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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

        .form-group input[type="email"],
        .form-group input[type="username"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #9b730fb0;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Check if the key parameter is present in the URL
        if (isset($_GET['key'])) {
            // Retrieve the key and email values from the URL
            $key = $_GET['key'];
            $email = $_GET['email'];

            // TODO: Validate the key and email in the database
            $con = mysqli_connect('127.0.0.1', 'student', 'student123456789','teacher_rating_system'); // Replace with your database credentials
            $key = mysqli_real_escape_string($con, $key);
            $email = mysqli_real_escape_string($con, $email);

            $sql = "SELECT * FROM password_reset_temp WHERE `key` = '$key' AND email = '$email'";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $expDate = $row['expDate'];

                // Compare the current date and time with the expiration date/time
                $currentDateTime = date('Y-m-d H:i:s');
                if ($currentDateTime <= $expDate) {
                    // Key and email are valid, and the reset link is not expired
                    echo '<h1 class="title">Reset Password</h1>';
                    echo '<form method="post" action="reset_information.php">';
                    echo '<input type="hidden" name="key" value="' . $key . '">';
                    echo '<div class="form-group">';
                    echo '<label for="email">Email:</label>';
                    echo '<input type="email" name="email" id="email" value="' . $email . '" readonly>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="username">New Username:</label>';
                    echo '<input type="username" name="username" id="username" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="password">New Password:</label>';
                    echo '<input type="password" name="password" id="password" required>';
                    echo '</div>';
                    echo '<input type="submit" value="Reset Password">';
                    echo '</form>';
                } else {
                    // Reset link has expired
                    echo '<p>The reset link has expired. Please generate a new one.</p>';
                }
            } else {
                // Key and email are invalid
                echo '<p>Invalid reset link. Please try again.</p>';
            }

            mysqli_close($con);
        } else {
            echo '<p>Invalid reset link. Please try again.</p>';
        }
        ?>
    </div>
</body>
</html>

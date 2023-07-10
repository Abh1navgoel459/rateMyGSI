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
            height: 250px;
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
    </style>
</head>
<body>
    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the email from the form
        $email = $_POST["email"];

        // TODO: Validate the email and perform necessary actions

        // Generate a random key
        $key = bin2hex(random_bytes(100));

        // Calculate the expiration date/time (1 day from the current date/time)
        $expDate = date('Y-m-d H:i:s', strtotime('+1 day'));

        // Store the email, key, and expDate in the password_reset_temp table
        $con = mysqli_connect('127.0.0.1', 'student', 'student123456789','teacher_rating_system'); // Replace with your database credentials
        $sql = "INSERT INTO password_reset_temp (email, `key`, expDate) VALUES ('$email', '$key', '$expDate')";
        mysqli_query($con, $sql);

        // Prepare the reset link with the unique key
        $resetLink = 'http://localhost:8888/ApacheGSI/reset_page.php?key=' . $key . '&email=' . urlencode($email);
        // Set up the email parameters
        $to = $email;
        $subject = 'Reset Your Password';
        $message = 'Click the following link to reset your password: ' . $resetLink;
        $headers = 'From: info.ratemygsi@gmail.com';

        // Send the email
        if (mail($to, $subject, $message, $headers)) {
            echo '<div class="container">';
            echo '<h2 class="title">Reset Information</h2>';
            echo '<p>Reset email sent.</p>';
            echo '</div>';
        } else {
            echo '<div class="container">';
            echo '<h2 class="title">Reset Information</h2>';
            echo '<p>Error sending reset email.</p>';
            echo '</div>';
        }

        exit();
    }
    ?>
</body>
</html>

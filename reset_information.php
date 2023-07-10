<?php
// Get the email address from the URL parameter
$email = $_GET["email"];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the user input from the form
    $newUsername = $_POST["newUsername"];
    $newPassword = $_POST["newPassword"];

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

<!DOCTYPE html>
<html>
<head>
    <title>Reset Information</title>
</head>
<body>
    <h1>Reset Information</h1>
    <form method="POST" action="">
        <label for="email">Email Address:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" readonly><br><br>
        <label for="newUsername">New Username:</label>
        <input type="text" name="newUsername" required><br><br>
        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" required><br><br>
        <button type="submit">Reset Username and Password</button>
    </form>
</body>
</html>

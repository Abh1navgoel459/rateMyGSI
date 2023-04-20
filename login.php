<?php
// Database connection details
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$con = mysqli_connect('127.0.0.1', 'student', 'student123456789', 'teacher_rating_system');

$username = $_POST['username'];
$password = $_POST['password'];

// Check if any of the fields are blank
if (empty($username) || empty($password)) {
    echo "Error: One or more fields are blank.";
} else {
    // Query the database to check if the username and password exist
    $sql = "SELECT * FROM students WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $sql);

    // Check for query errors
    if (!$result) {
        die("Query error: " . mysqli_error($con));
    }

    // If the query returns one row, then the username and password are correct
    if (mysqli_num_rows($result) == 1) {
        echo "Logging In...";
        // Start the session and redirect the user to the teacher rating website
        $student = mysqli_fetch_assoc($result);
        $student_id = $student['student_id'];
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['student_id'] = $student_id;
        header('Location: teacher2.html');
        exit();
    } else {
        // Display an error message if the username and password are incorrect
        echo "Invalid username or password.";
    }
}

// Close the database connection
mysqli_close($con);
?>

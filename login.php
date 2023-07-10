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
    // Prepare the SQL statement with placeholders
    $stmt = mysqli_prepare($con, "SELECT * FROM students WHERE username=? AND password=?");
    // Bind the parameters to the placeholders
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    // Get the result set from the prepared statement
    $result = mysqli_stmt_get_result($stmt);

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
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        header('Location: teacher2.html');
        exit();
    } else {
        // Display an error message if the username and password are incorrect
        echo "Invalid username or password.";
    }
}

// Close the prepared statement and the database connection
mysqli_stmt_close($stmt);
mysqli_close($con);
?>

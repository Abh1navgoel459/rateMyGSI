<?php
$conn = mysqli_connect('localhost', 'student', 'student123456789', 'teacher_rating_system');

// Get the teacher name from the search form
$teacher_name = mysqli_real_escape_string($conn, $_POST['teacher_name']);

// Separate the first and last name
$name_parts = explode(" ", $teacher_name);
$first_name = mysqli_real_escape_string($conn, $name_parts[0]);
$last_name = mysqli_real_escape_string($conn, $name_parts[1]);

// Query the database to see if the teacher exists
$sql = "SELECT * FROM teachers WHERE first_name = '$firstName' AND last_name = '$lastName'";
$result = mysqli_query($conn, $sql);

// Check if the teacher exists
if (mysqli_num_rows($result) > 0) {
    // Teacher exists, redirect to teacher viewing page
    $teacher = mysqli_fetch_assoc($result);
    header("Location: teacher.php?id=" . $teacher['id']);
    exit();
} else {
    // Teacher does not exist, show error message
    echo "Teacher not found.";
}

// Close database connection
mysqli_close($conn);
?>

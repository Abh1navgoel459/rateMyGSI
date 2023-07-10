<?php
// Connect to the database
$con = mysqli_connect('127.0.0.1', 'student', 'student123456789', 'teacher_rating_system');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['firstName'])) {
    $firstName = $_GET['firstName'];

    // Prepare and execute the SQL query
    $sql = "SELECT DISTINCT firstName, class FROM teacher_ratings WHERE firstName LIKE '$firstName%'";
    $result = mysqli_query($con, $sql);

    // Fetch the results into an array
    $teachers = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $teachers[] = $row;
    }

    // Convert the array to JSON and send the response
    echo json_encode($teachers);
}

// Close the database connection
mysqli_close($con);
?>

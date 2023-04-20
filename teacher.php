<?php
if(isset($_GET['teacher'])) {
    $teacher_name = $_GET['teacher'];

    // Connect to the database
    $conn = mysqli_connect('localhost', 'student', 'student123456789', 'teacher_rating_system');

    // Search for the teacher's ID in the database using their name
// Retrieve teacher's ID from the teacher_ratings table using their full name
$sql = "SELECT id FROM teacher_ratings WHERE CONCAT(first_name, ' ', last_name) = '$teacher_name'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $teacher_id = $row['id'];

    // Retrieve the average rating for the teacher from the student_teacher table
    $sql = "SELECT avg_rating as average_rating FROM teacher_ratings tr JOIN student_teacher st ON tr.id = st.teacher_id WHERE tr.id = '$teacher_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $average_rating = round($row['average_rating'], 2);
} else {
    // If no teacher is found, set the average rating to "N/A"
    $average_rating = "N/A";
}

// Display teacher's name and rating
echo '<div id="teacher-rating">';
echo '<h1 style="text-align: center;">' . $teacher_name . '</h1>';
echo '<h2 style="color: red; text-align: center;">' . $average_rating . ' out of 5</h2>';
echo '<button onclick="location.href = \'submit_rating.php?teacher=' . urlencode($teacher_name) . '\';">Rate this teacher</button>';
echo '</div>';

// Close the database connection
mysqli_close($conn);

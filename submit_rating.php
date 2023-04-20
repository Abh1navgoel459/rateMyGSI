<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Connect to database
$servername = "localhost";
$username = "student";
$password = "student123456789";
$dbname = "teacher_rating_system";

session_start(); 
$student_id = $_SESSION['student_id'];
$teacher_id = $_GET["teacher_id"];
$stars = $_GET["stars"];

$conn = mysqli_connect('127.0.0.1', 'student', 'student123456789', 'teacher_rating_system');

$sql = "SELECT * FROM student_teacher WHERE student_id =$student_id AND teacher_id = $teacher_id";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    // Insert rating data
    $sql = "INSERT INTO student_teacher(teacher_id, avg_rating, student_id, update_dt) VALUES ($teacher_id, '$stars', $student_id, curdate())";
    $rs = mysqli_query($conn, $sql);
    if ($rs) {
    echo "Rating submitted successfully";
    $sql = " UPDATE teacher_ratings
    SET avg_rating = (
        SELECT AVG(avg_rating)
        FROM student_teacher
        WHERE teacher_id = '$teacher_id'
    )
    WHERE teacher_id = '$teacher_id';";
    $rs = mysqli_query($conn, $sql);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $sql = "UPDATE student_teacher set avg_rating = '$stars' where student_id = $student_id and teacher_id = $teacher_id";
    $rs = mysqli_query($conn, $sql);
    if ($rs) {
        echo "Rating updated successfully!";
        $sql = " UPDATE teacher_ratings
        SET avg_rating = (
            SELECT AVG(avg_rating)
            FROM student_teacher
            WHERE teacher_id = '$teacher_id'
        )
        WHERE teacher_id = '$teacher_id';";
        $rs = mysqli_query($conn, $sql);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

mysqli_close($conn);
?>
<?php
if (isset($rs) && $rs) {
    echo '<form action="teacher2.html"><button type="submit">Rate more GSIs</button></form>';
}
?>
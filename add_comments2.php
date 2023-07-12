<?php
session_start();
    // Get the teacher ID from the form submission
    $teacher_id = $_SESSION['teacher_id'];
    $student_id = $_SESSION['student_id'];
    echo "hello";

    // Get the comment from the form submission
    $comment = $_POST["comment"];
    if($comment === '' || empty($comment)) {
        header('Location: add_comments.php');
        exit();
    }
    echo "Hello!!!";

    // Connect to the database
    $conn = mysqli_connect('127.0.0.1', 'student', 'student123456789', 'teacher_rating_system');

    // Check if the user has already made a comment for this teacher
    $existingComment = mysqli_query($conn, "SELECT * FROM teacher_comments WHERE teacher_id = '$teacher_id' AND student_id = '$student_id'");
    if (mysqli_num_rows($existingComment) > 0) {
        // Update the existing comment
        $sql = "UPDATE teacher_comments SET comments = '$comment' WHERE teacher_id = '$teacher_id' AND student_id = '$student_id'";
        $successMessage = "Comment updated successfully!";
    } else {
        // Insert a new comment
        $sql = "INSERT INTO teacher_comments (teacher_id, comments, student_id) VALUES ('$teacher_id', '$comment', '$student_id')";
        $successMessage = "Comment added successfully!";
    }

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Comment inserted or updated successfully
        mysqli_close($conn);
        
        // Display success message
        echo $successMessage;

        // Redirect the user back to the teacher2.html page after 2 seconds
        echo '<script>
            setTimeout(function() {
                window.location.href = "teacher2.php";
            }, 2000);
        </script>';
        exit;
    } else {
        // Error inserting or updating the comment
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        mysqli_close($conn);
    }
?>

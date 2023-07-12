<!DOCTYPE html>
<html>
<head>
    <title>Add Comment</title>
    <?php
    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // Redirect to the login page
        header('Location: login.html');
        exit();
    }
    
    ?>
    <style>
        body {
            background-color: #162447;
            color: white;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .submit-button {
            height: 40px;
            border-radius: 5px;
            padding: 5px 15px;
            font-size: 14px;
            background-color: #9b730fb0;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        $_SESSION['teacher_id'] = $_POST['teacher_id'];
        $_SESSION['student_id'] = $_POST['student_id']
    ?>
    <h2>Add Comment</h2>
    <form method="post" action="add_comments2.php">
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" rows="4" cols="50" required></textarea>
        </div>
        <div class="form-group">
            <button class="submit-button" type="submit">Submit Comment</button>
        </div>
    </form>
</body>
</html>

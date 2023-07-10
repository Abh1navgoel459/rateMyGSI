<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the user input from the form
    $enteredCode = $_POST["enteredCode"];

    // Retrieve the email from the session variable
    $email = $_SESSION["email"];

    // Retrieve the code from the session variable
    $code = $_SESSION["code"];

    // Check if the entered code matches the retrieved code
    if ($code == $enteredCode) {
        // Set the timestamp in session
        $_SESSION["correct_code_timestamp"] = time();

        // Redirect to reset_information.php with email in the URL
        header("Location: reset_information.php");
        exit();
    } else {
        // Set the timestamp in session
        $_SESSION["wrong_code_timestamp"] = time();
    }
}

// Check if the correct_code_timestamp is set in session
if (isset($_SESSION["correct_code_timestamp"])) {
    // Get the timestamp from session
    $timestamp = $_SESSION["correct_code_timestamp"];

    // Calculate the remaining time for the user to reset the password (60 seconds - elapsed time)
    $remainingTime = 60 - (time() - $timestamp);

    // Check if the remaining time is less than or equal to 0
    if ($remainingTime <= 0) {
        // Reset the correct_code_timestamp in session
        unset($_SESSION["correct_code_timestamp"]);
    }
}

// Check if the wrong_code_timestamp is set in session
if (isset($_SESSION["wrong_code_timestamp"])) {
    // Get the timestamp from session
    $timestamp = $_SESSION["wrong_code_timestamp"];

    // Calculate the remaining time for the user to reset the password (60 seconds - elapsed time)
    $remainingTime = 60 - (time() - $timestamp);

    // Check if the remaining time is less than or equal to 0
    if ($remainingTime <= 0) {
        // Reset the wrong_code_timestamp in session
        unset($_SESSION["wrong_code_timestamp"]);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Code Verification</title>
</head>
<body>
    <h1>Code Verification</h1>

    <?php if (isset($_SESSION["wrong_code_timestamp"]) && $remainingTime <= 0) : ?>
        <?php // Reset the wrong_code_timestamp in session ?>
        <?php unset($_SESSION["wrong_code_timestamp"]); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION["correct_code_timestamp"])) : ?>
        <?php // User entered the correct code ?>
        <?php // Redirect to reset_information.php with email in the URL ?>
        <?php header("Location: reset_information.php?email=" . urlencode($email)); ?>
        <?php exit(); ?>
    <?php elseif (isset($_SESSION["wrong_code_timestamp"])) : ?>
        <?php // User entered the wrong code ?>
        <?php // Calculate the remaining time for the user to reset the password (60 seconds - elapsed time) ?>
        <?php $remainingTime = 60 - (time() - $_SESSION["wrong_code_timestamp"]); ?>
        <p>Please wait for the timer to expire before attempting to reset again.</p>
        <p>Remaining time: <span id="timer"><?php echo $remainingTime; ?></span> seconds</p>
    <?php else : ?>
        <form method="POST" action="">
            <label for="enteredCode">Enter the code:</label>
            <input type="text" name="enteredCode" required>
            <button type="submit">Verify Code</button>
        </form>
    <?php endif; ?>

    <script>
        // JavaScript code for live timer
        var timerElement = document.getElementById("timer");
        var remainingTime = <?php echo $remainingTime ?? 0; ?>;

        // Function to update the timer every second
        function updateTimer() {
            // Display the updated timer
            timerElement.innerHTML = remainingTime;

            // Decrease the remaining time
            remainingTime--;

            // Stop the timer if time is up
            if (remainingTime < 0) {
                clearInterval(timerInterval);
                window.location.reload(); // Refresh the page to show the form again
            }
        }

        // Start the timer
        var timerInterval = setInterval(updateTimer, 1000);
    </script>
</body>
</html>

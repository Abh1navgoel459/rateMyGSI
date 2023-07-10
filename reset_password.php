<?php
// Check if the current session exists
if (isset($_SESSION["email"])) {
    // Destroy the current session
    session_destroy();
    // Start a new session
    session_start();
} else {
    // Start a new session
    session_start();
}

// Continue with the rest of the code
// ...

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the user input from the form
    $email = $_POST["email"];

    // Generate a random code between 1000 and 10000000
    $code = rand(1000, 10000000);

    // Store the email and code as session variables
    $_SESSION["email"] = $email;
    $_SESSION["code"] = $code;

    // Send the email with the code
    $to = $email;
    $subject = "Password Reset";
    $message = "Please type in the following code to reset your username or password: $code";
    $headers = "From: abhinavgoel459@berkeley.edu";

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        // Email sent successfully
        echo "Email sent successfully.";
    } else {
        // Failed to send the email
        echo "Failed to send the email.";
    }

    // Redirect to reset_page.php
    header("Location: reset_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Code Verification</title>
</head>
<body>
    <h1>Code Verification</h1>

    <form method="POST" action="">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" required>
        <button type="submit">Send Code</button>
    </form>
</body>
</html>

<?php
// database connection code
// $con = mysqli_connect('localhost', 'database_user', 'database_password','database');

$con = mysqli_connect('127.0.0.1', 'student', 'student123456789','teacher_rating_system');

// get the post records
$emailAddress = $_POST['emailAddress'];
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the email address or username already exists
$query = "SELECT * FROM students WHERE emailAddress = '$emailAddress' OR username = '$username'";
$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    // Email address or username already exists, display an error message
    echo '<style>
            body {
                background-color: #162447;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .container {
                width: 450px;
                height: 300px;
                padding: 20px;
                text-align: center;
                background-color: white;
                color: black;
            }

            .title {
                font-family: \'DeliusUnicaseRegular\', sans-serif;
                font-size: 36px;
                font-weight: normal;
                margin-bottom: 30px;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
        </style>
        <div class="container">
            <div class="title">Rate My GSI</div>
            <div style="text-align:center;font-size:30px;">Registration Failed! Email address or username already exists.</div>
            <br>
            <div style="text-align:center;"><button onclick="window.location.href=\'registration.html\'">Try Again</button></div>
        </div>';
} else {
    // Email address and username are unique, proceed with registration

    // database insert SQL code
    $sql = "INSERT INTO `students` (`emailAddress`, `username`, `password`) VALUES ('$emailAddress', '$username', '$password')";

    // insert in database 
    $rs = mysqli_query($con, $sql);

    if ($rs) {
        // Registration successful, display a success message
        echo '<style>
            body {
                background-color: #162447;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .container {
                width: 450px;
                height: 300px;
                padding: 20px;
                text-align: center;
                background-color: white;
                color: black;
            }

            .title {
                font-family: \'DeliusUnicaseRegular\', sans-serif;
                font-size: 36px;
                font-weight: normal;
                margin-bottom: 30px;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
        </style>
        <div class="container">
            <div class="title">Rate My GSI</div>
            <div style="text-align:center;font-size:30px;">Registered Successfully!</div>
            <br>
            <div style="text-align:center;"><button onclick="window.location.href=\'login.html\'">Login</button></div>
        </div>';
    } else {
        // Registration failed, display an error message
        echo '<style>
            body {
                background-color: #162447;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .container {
                width: 450px;
                height: 300px;
                padding: 20px;
                text-align: center;
                background-color: white;
                color: black;
            }

            .title {
                font-family: \'DeliusUnicaseRegular\', sans-serif;
                font-size: 36px;
                font-weight: normal;
                margin-bottom: 30px;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
        </style>
        <div class="container">
            <div class="title">Rate My GSI</div>
            <div style="text-align:center;font-size:30px;">Registration Failed!</div>
            <br>
            <div style="text-align:center;"><button onclick="window.location.href=\'registration.html\'">Try Again</button></div>
        </div>';
    }
}

// Close the database connection
mysqli_close($con);
?>

<?php
// database connection code
// $con = mysqli_connect('localhost', 'database_user', 'database_password','database');

$con = mysqli_connect('127.0.0.1', 'student', 'student123456789','teacher_rating_system');

// get the post records
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$emailAddress = $_POST['emailAddress'];
$phone_num = $_POST['phone_num'];
$username = $_POST['username'];
$password = $_POST['password'];
//echo $firstName;

// database insert SQL code
$sql = "INSERT INTO `students` (`firstName`, `lastName`, `emailAddress`, `phone_num`, `username`, `password`) VALUES ('$firstName', '$lastName', '$emailAddress', '$phone_num', '$username', '$password')";
//echo $sql;

// insert in database 
$rs = mysqli_query($con, $sql);

if ($rs) {
  // registration successful, display a login button
  echo '<div style="text-align:center;font-size:30px;">Registered Successfully!</div><br>';
  echo '<div style="text-align:center;"><button onclick="window.location.href=\'login.html\'">Login</button></div>';
} else {
  // registration failed
  echo '<div style="text-align:center;font-size:30px;">Registration Failed!</div>';
}

?>

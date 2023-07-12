<!DOCTYPE html>
<html>
<head>
  <title>Rate My GSI</title>
  <style>
    body {
      font-family: DeliusUnicaseRegular, Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #162447;
    }

    #header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      background-color: #c6b33ec8;
    }

    #logo {
      width: 50px;
      height: 50px;
      cursor: pointer;
    }

    #buttons {
      display: flex;
      gap: 10px;
    }

    #buttons a {
      padding: 10px 20px;
      background-color: #9b730fb0;
      color: white;
      font-weight: bold;
      text-decoration: none;
      border-radius: 5px;
    }

    h1 {
      color: white;
      font-size: 50px;
      text-align: center;
      margin-top: 40px;
    }
    p {
      font-size: 34px;
      margin: 20px auto;
      text-align: center;
      color: white;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: stretch;
      margin: 50px auto;
      max-width: 800px;
    }
    .box {
      background-color: #162447;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
      margin: 20px;
      padding: 20px;
      text-align: center;
      flex: 1;
    }
    .box img {
      height: 100px;
    }
    .box h2 {
      font-size: 24px;
      margin-top: 0;
      color: white;
    }
    .box p {
      font-size: 16px;
      margin-bottom: 0;
      color: white;
    }

    footer {
      background-color: #162447;
      color: #fff;
      padding: 25px;
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    footer a {
      color: #fff;
      text-decoration: none;
      margin: 0 20px;
      font-size: 20px; /* Updated font size */
    }
    footer hr {
      border: none;
      border-top: 0.5px solid #fff; /* Increased border thickness */
      margin: -17px;
      width: 100%; /* Set line width to 100% */
      position: absolute;
      left: 0;
    }
  </style>
</head>
<body>
  <div id="header">
    <a id="instagram-tab" href="https://www.instagram.com/ratemygsi"> <img src="instagram-logo.png" alt="Instagram Logo" width="40" height="40">     
    </a>
    <div id="buttons">
      <a href="registration.html">Sign Up</a>
      <a href="login.html">Log In</a>
    </div>
  </div>
  <h1>Rate My GSI</h1>
  <p>Rate your favorite (or least favorite) GSIs at Berkeley!</p>
  <div class="container">
    <div class="box">
      <img src="thumbs-up.png" alt="thumbs up">
      <h2 style="color: white;">Create and modify your ratings</h2>
      <p style="color: white;">Use our user-friendly interface to create, modify, and delete your ratings for GSIs at Berkeley.</p>
    </div>
    <div class="box">
      <img src="magnifying-glass.jpeg" alt="magnifying glass">
      <h2 style="color: white;">View other people's ratings</h2>
      <p style="color: white;">Browse and search through other people's ratings for GSIs at Berkeley to get a better sense of who to choose.</p>
    </div>
  </div>
  <footer>
    <hr>
    <a href="about.html">About</a>
    <a href="help.html">Help</a>
    <a href="guidelines.html">Guidelines</a>
  </footer>
</body>
</html>
<?php
    session_start();
    $_SESSION['logged_in'] = false;
?>

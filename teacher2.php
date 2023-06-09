<!DOCTYPE html>
<html>
<head>
    <title>Find Your GSI!</title>
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
            background-color: #b8860b;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .circle {
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background-color: white;
            border: 10px solid #9b730fb0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .circle h1 {
            font-size: 32px;
            margin-bottom: 50px;
            font-weight: bold;
        }

        .circle p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .search-container input[type="text"] {
            width: 200px;
            height: 30px;
            border-radius: 5px;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #e6e6e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            max-height: 200px;
            overflow-y: auto;
            width: 200px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .show {
            display: block;
        }

        .search-container button[type="submit"] {
            height: 40px;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 14px;
            background-color: #9b730fb0;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }

        .search-container button[type="submit"]:hover {
            background-color: #7e5b0ca3;
        }
    </style>
</head>
<body>
    <div class="circle">
        <h1>Find Your GSI!</h1>
        <p>Find a Graduate Student Instructor (GSI) at the University of California, Berkeley</p>
        <form name="frmContact" method="post" action="teacher3.php" class="search-container">
            <div style="display: flex; flex-direction: column; align-items: center;">
                <div style="margin-bottom: 10px;">
                    <label for="firstName">GSI Name:</label>
                    <input type="text" id="firstName" name="firstName" onkeyup="checkTeachers(this.value, 'firstName')" autocomplete="off">
                    <div class="dropdown-content" id="dropdown-content-firstName"></div>
                </div>
                <input type="hidden" name="student_id" value="<?php echo $_SESSION['student_id']; ?>">
                <button type="submit">Search</button>
            </div>
        </form>
    </div>

    <script>
        function checkTeachers(name, inputType) {
            const dropdownContentFirstName = document.getElementById("dropdown-content-firstName");

            if (name.length === 0) {
                dropdownContentFirstName.innerHTML = "";
                dropdownContentFirstName.style.display = "none";
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const teachers = JSON.parse(xhr.responseText);
                        displayTeachers(name, teachers, inputType);
                    } else {
                        console.error("Error: " + xhr.status);
                    }
                }
            };

            xhr.open("GET", "teacher5.php?" + inputType + "=" + encodeURIComponent(name), true);
            xhr.send();
        }

        function displayTeachers(name, teachers, inputType) {
            const dropdownContentFirstName = document.getElementById("dropdown-content-firstName");

            if (inputType === "firstName") {
                dropdownContentFirstName.innerHTML = "";

                if (teachers.length === 0) {
                    dropdownContentFirstName.style.display = "none";
                    return;
                }

                for (let i = 0; i < teachers.length; i++) {
                    const teacher = teachers[i];
                    const link = document.createElement("a");
                    link.href = "#";
                    link.textContent = teacher.firstName + ', ' + teacher.class;
                    link.onclick = function () {
                        document.getElementById("firstName").value = teacher.firstName;
                        dropdownContentFirstName.style.display = "none";
                        return false;
                    };
                    dropdownContentFirstName.appendChild(link);
                }

                dropdownContentFirstName.style.display = "block";
            }
        }
    </script>
</body>
</html>

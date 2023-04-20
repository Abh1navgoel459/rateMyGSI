<!DOCTYPE html>
<html>
<head>
    <title>Rate This GSI!</title>
    <style>
        body {
            background-color: #003262;
        }
        h1, p, button {
            text-align: center;
            font-size: 36px;
            color: white;
        }
        .stars {
            display: flex;
            justify-content: center;
            margin: 5px 0;
        }
        .stars span {
            font-size: 40px;
            cursor: pointer;
            color: gray;
        }
        .stars span:hover,
        .stars span.active {
            color: orange;
        }
        button {
            display: block;
            margin: 0 auto;
            color: black;
            font-family: Verdana, sans-serif;
        }
    </style>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Reading POST data
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $teacher_id = $_POST["teacher_id"];
    } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Reading GET data
        $firstName = $_GET["firstName"];
        $lastName = $_GET["lastName"];
        $teacher_id = $_GET["teacher_id"];
    }
    ?>
    <?php
        echo "<p>$firstName $lastName</p>";
    ?>
    <div class="stars">
        <span data-rating="1">&#9733;</span>
        <span data-rating="2">&#9733;</span>
        <span data-rating="3">&#9733;</span>
        <span data-rating="4">&#9733;</span>
        <span data-rating="5">&#9733;</span>
    </div><br><br>
    <button onclick="submitRating()">Submit</button>

    <br><br>
    <div id="teacherInfo"></div>
    <input type=hidden id="teacher_id" value = <?php echo $teacher_id ?>>
    <script>
        function updateStars(rating) {
          let stars = document.querySelectorAll(".stars span");
          stars.forEach(function(star) {
            if (star.getAttribute("data-rating") <= rating) {
              star.classList.add("active");
            } else {
              star.classList.remove("active");
            }
          });
        }

        function submitRating() {
            let teacher_id = document.getElementById("teacher_id").value;
            let stars = document.querySelectorAll(".stars span.active").length;
            location.href = "submit_rating.php?teacher_id=" + teacher_id + "&stars=" + stars;
        }

        let stars = document.querySelectorAll(".stars span");
        stars.forEach(function(star) {
            star.addEventListener("click", function() {
                updateStars(this.getAttribute("data-rating"));
            });
        });
    </script>
</body>
</html>

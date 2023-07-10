<!DOCTYPE html>
<html>
<head>
    <title>Rate This GSI!</title>
     <style>
        body {
            background-color: #003262;
            color: white;
        }

        .header {
            text-align: left;
            font-size: 36px;
            margin-bottom: 10px;
        }

        .subject {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .rating-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 10px;
            margin-left: 30px;
        }

        .stars {
            display: flex;
            justify-content: flex-start;
            margin-right: 10px;
        }

        .stars span {
            font-size: 30px;
            cursor: pointer;
            color: gray;
        }

        .stars span:hover,
        .stars span.active {
            color: orange;
        }

        .questions-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .question {
            margin-right: 20px;
        }
        .name-container {
            text-align: center;
        }

        .name-container p {
            font-size: 24px;
        }


        .submit-button {
            display: block;
            margin: 20px 0;
            padding: 10px 20px;
            font-size: 18px;
            background-color: white;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 30px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Reading POST data
        $firstName = $_POST["firstName"];
        $teacher_id = $_POST["teacher_id"];
    } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Reading GET data
        $firstName = $_GET["firstName"];
        $teacher_id = $_GET["teacher_id"];
    }
    ?>
    <?php
        echo '<div class="name-container"><p>'.$firstName.'</p></div>';
    ?>
    <form name="frmContact" method="post" action="submit_rating.php">
        <div class="rating-container">
            <div class="questions-container">
                <div class="question">
                    <label for="takeAgain">Would you take this GSI again?</label>
                    <div>
                        <input type="radio" id="takeAgainYes" name="takeAgain" value="yes">
                        <label for="takeAgainYes">Yes</label>
                        <input type="radio" id="takeAgainNo" name="takeAgain" value="no">
                        <label for="takeAgainNo">No</label>
                    </div>
                </div>

                <div class="question">
                    <label for="credit">Was this class taken for credit?</label>
                    <div>
                        <input type="radio" id="creditYes" name="credit" value="yes">
                        <label for="creditYes">Yes</label>
                        <input type="radio" id="creditNo" name="credit" value="no">
                        <label for="creditNo">No</label>
                    </div>
                </div>

                <div class="question">
                    <label for="attendance">Was attendance mandatory?</label>
                    <div>
                        <input type="radio" id="attendanceYes" name="attendance" value="yes">
                        <label for="attendanceYes">Yes</label>
                        <input type="radio" id="attendanceNo" name="attendance" value="no">
                        <label for="attendanceNo">No</label>
                    </div>
                </div>

                <div class="question">
                    <label for="textbooks">Did this professor use textbooks?</label>
                    <div>
                        <input type="radio" id="textbooksYes" name="textbooks" value="yes">
                        <label for="textbooksYes">Yes</label>
                        <input type="radio" id="textbooksNo" name="textbooks" value="no">
                        <label for="textbooksNo">No</label>
                    </div>
                </div>
            </div>

            <div class="stars">
                <span class="overallRatingStar" data-rating="1">&#9733;</span>
                <span class="overallRatingStar" data-rating="2">&#9733;</span>
                <span class="overallRatingStar" data-rating="3">&#9733;</span>
                <span class="overallRatingStar" data-rating="4">&#9733;</span>
                <span class="overallRatingStar" data-rating="5">&#9733;</span>
            </div>
            <label for="overallRating">Overall Rating</label>
        </div>

        <div class="rating-container">
            <div class="stars">
                <span class="difficultyRatingStar" data-rating="1">&#9733;</span>
                <span class="difficultyRatingStar" data-rating="2">&#9733;</span>
                <span class="difficultyRatingStar" data-rating="3">&#9733;</span>
                <span class="difficultyRatingStar" data-rating="4">&#9733;</span>
                <span class="difficultyRatingStar" data-rating="5">&#9733;</span>
            </div>
            <label for="difficultyRating">Difficulty Rating</label>
        </div>

        <div class="rating-container">
            <label for="grade">Grade Received:</label>
            <select id="grade" name="grade">
                <option value="A+">A+</option>
                <option value="A">A</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B">B</option>
                <option value="B-">B-</option>
                <option value="C+">C+</option>
                <option value="C">C</option>
                <option value="C-">C-</option>
                <option value="D+">D+</option>
                <option value="D">D</option>
                <option value="D-">D-</option>
                <option value="F">F</option>
                <option value="Audit/No Grade">Audit/No Grade</option>
                <option value="Drop/Withdrawal">Drop/Withdrawal</option>
                <option value="Incomplete">Incomplete</option>
                <option value="In progress">In progress</option>
                <option value="Prefer not to say">Prefer not to say</option>
            </select>
        </div>

        <div class="rating-container">
            <label for="comment">Add a comment <?php echo $firstName; ?>:</label>
            <textarea id="comment" name="comment" rows="4" cols="50"></textarea>
        </div>

        <input type="hidden" id="teacher_id" name="teacher_id" value="<?php echo $teacher_id ?>">
        <input type="hidden" id="overallRating" name="overallRating">
        <input type="hidden" id="difficultyRating" name="difficultyRating">
        <button class="submit-button" onclick="submitRating()">Submit</button>
        <div id="teacherInfo"></div>
    </form>

    <script>
        function updateStars(rating, starClass) {
          let stars = document.querySelectorAll(`.${starClass}`);
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
            let overallRating = document.querySelectorAll(".overallRatingStar.active").length;
            let difficultyRating = document.querySelectorAll(".difficultyRatingStar.active").length;
            let takeAgain = document.querySelector('input[name="takeAgain"]:checked').value === "yes" ? "yes" : "no";
            let credit = document.querySelector('input[name="credit"]:checked').value === "yes" ? "yes" : "no";
            let attendance = document.querySelector('input[name="attendance"]:checked').value === "yes" ? "yes" : "no";
            let textbooks = document.querySelector('input[name="textbooks"]:checked').value === "yes" ? "yes" : "no";
            let grade = encodeURIComponent(document.getElementById("grade").value);
            let comment = encodeURIComponent(document.getElementById("comment").value);
            document.getElementById("overallRating").value = overallRating;
            document.getElementById("difficultyRating").value = difficultyRating;
            document.getElementById("comment").value = comment;
        }

        let overallRatingStars = document.querySelectorAll(".overallRatingStar");
        overallRatingStars.forEach(function(star) {
            star.addEventListener("click", function() {
                updateStars(this.getAttribute("data-rating"), "overallRatingStar");
            });
        });

        let difficultyRatingStars = document.querySelectorAll(".difficultyRatingStar");
        difficultyRatingStars.forEach(function(star) {
            star.addEventListener("click", function() {
                updateStars(this.getAttribute("data-rating"), "difficultyRatingStar");
            });
        });
    </script>
</body>
</html>

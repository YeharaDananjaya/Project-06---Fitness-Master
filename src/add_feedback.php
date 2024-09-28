<?php
// Include navbar and database connection
include("navbar.php");
include("db.php");

// CREATE Feedback
if (isset($_POST['add_feedback'])) {
    $user_id = $_POST['user_id']; // Assumed to come from session or similar context
    $coach_id = $_POST['coach_id']; // Coach selected for feedback
    $rating = $_POST['rating']; // User's rating
    $system_rating = $_POST['system_rating']; // Rating for the system
    $comments = $_POST['comments'];
    $improvement_suggestions = $_POST['improvement_suggestions'];

    // Validate input data
    if (empty($user_id) || empty($coach_id) || empty($rating) || empty($system_rating) || empty($comments)) {
        $feedbackMessage = "All fields are required!";
    } else {
        // Prepare and execute the SQL insert statement
        $sql = "INSERT INTO feedbacks (user_id, coach_id, rating, system_rating, comments, improvement_suggestions) 
                VALUES (:user_id, :coach_id, :rating, :system_rating, :comments, :improvement_suggestions)";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':coach_id' => $coach_id,
            ':rating' => $rating,
            ':system_rating' => $system_rating,
            ':comments' => $comments,
            ':improvement_suggestions' => $improvement_suggestions
        ]);

         // Set the feedback message in the session
    session_start(); // Start session to store feedback message
    $_SESSION['feedbackMessage'] = "Feedback added successfully!";
    
    // Redirect to the same page to prevent resubmission
    header("Location: manage_feedbacks.php");
    exit(); // Terminate script after redirection
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Master - Add Feedback</title>
    <link rel="stylesheet" href="./styles/feedbackstyle.css"> <!-- External CSS -->
    <style>
    .star-rating {
        display: flex;
        justify-content: center;
        cursor: pointer;
    }
    .star {
        font-size: 50px; /* Increase the font size for larger stars */
        color: #ccc;
        transition: color 0.2s;
    }
    .star:hover,
    .star.selected {
        color: #500a0a; /* Yellow color for hovered and selected stars */
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Feedback</h1>

        <?php if (isset($feedbackMessage)) { ?>
            <div class="feedback-message"><?php echo $feedbackMessage; ?></div>
        <?php } ?>

        <div class="contact-form">
            <form method="POST" action="add_feedback.php" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="system_rating">Overall System Rating:</label>
                    <div class="star-rating" data-rating="0">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>
                    <input type="hidden" name="system_rating" class="system_rating" required>
                </div>

                <div class="form-group">
                    <label for="coach_id">Select Coach:</label>
                    <select name="coach_id" required class="form-select" id="coach_id">
                        <option value="">Choose a coach</option>
                        <?php
                        // Fetch coaches from the database
                        $sql = "SELECT coach_id, name FROM coaches";
                        $stmt = $con->query($sql);
                        while ($coach = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$coach['coach_id']}'>{$coach['name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <div class="star-rating" data-rating="0">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>
                    <input type="hidden" name="rating" class="rating" required>
                </div>
                
                <div class="form-group">
                    <label for="comments">Comments:</label>
                    <textarea name="comments" required class="form-textarea" id="comments"></textarea>
                </div>

                <div class="form-group">
                    <label for="improvement_suggestions">Improvement Suggestions:</label>
                    <textarea name="improvement_suggestions" class="form-textarea" id="improvement_suggestions"></textarea>
                </div>

                <div>
                    <input type="hidden" name="user_id" value="1"> <!-- Example user_id -->
                    <button type="submit" name="add_feedback" class="submit-button">Submit Feedback</button>
                </div>
            </form>
        </div>
        
        
    </div>

    <script>
        // Star rating functionality
        const starRatings = document.querySelectorAll('.star-rating');
        starRatings.forEach(rating => {
            const stars = rating.querySelectorAll('.star');
            stars.forEach(star => {
                star.addEventListener('mouseover', () => {
                    // Highlight stars on hover
                    stars.forEach(s => s.classList.remove('selected'));
                    star.classList.add('selected');
                    let previousSibling = star.previousElementSibling;
                    while (previousSibling) {
                        previousSibling.classList.add('selected');
                        previousSibling = previousSibling.previousElementSibling;
                    }
                });

                star.addEventListener('mouseout', () => {
                    // Remove hover effect
                    stars.forEach(s => s.classList.remove('selected'));
                    // Set back the rating based on previously selected value
                    const currentRating = rating.getAttribute('data-rating');
                    if (currentRating) {
                        stars.forEach(s => {
                            if (s.getAttribute('data-value') <= currentRating) {
                                s.classList.add('selected');
                            }
                        });
                    }
                });

                star.addEventListener('click', () => {
                    const ratingValue = star.getAttribute('data-value');
                    const ratingInput = rating.closest('.form-group').querySelector('input');
                    rating.setAttribute('data-rating', ratingValue);
                    ratingInput.value = ratingValue;

                    // Clear previous selected stars
                    stars.forEach(s => s.classList.remove('selected'));
                    star.classList.add('selected');
                    let previousSibling = star.previousElementSibling;
                    while (previousSibling) {
                        previousSibling.classList.add('selected');
                        previousSibling = previousSibling.previousElementSibling;
                    }
                });
            });
        });

        // Input validation
        function validateForm() {
            const coachId = document.getElementById("coach_id").value;
            const comments = document.getElementById("comments").value.trim();
            const systemRating = document.querySelector(".system_rating").value;
            const rating = document.querySelector(".rating").value;

            // Verify all fields are filled
            if (coachId === "") {
                alert("Please select a coach.");
                return false;
            }

            if (comments === "") {
                alert("Comments are required.");
                return false;
            }

            if (systemRating === "") {
                alert("Overall system rating is required.");
                return false;
            }

            if (rating === "") {
                alert("Rating is required.");
                return false;
            }

            return true; // All validations passed
        }
    </script>
</body>
</html>

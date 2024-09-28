<?php
// Include navbar and database connection
include("navbar.php");
include("db.php");

// READ Feedbacks
$sql = "SELECT f.*, u.name AS user_name, c.name AS coach_name 
        FROM feedbacks f 
        JOIN users u ON f.user_id = u.id 
        JOIN coaches c ON f.coach_id = c.coach_id";
$stmt = $con->query($sql);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// DELETE Feedback
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM feedbacks WHERE feedback_id = :id";
    $stmt = $con->prepare($sql);
    $stmt->execute([':id' => $id]);
    header('Location: manage_feedbacks.php');
    exit;
}

// Update Feedback
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_feedback'])) {
    $id = $_POST['feedback_id'];
    $rating = $_POST['rating'];
    $system_rating = $_POST['system_rating'];
    $comments = $_POST['comments'];
    $improvement_suggestions = $_POST['improvement_suggestions'];

    $sql = "UPDATE feedbacks SET rating = :rating, system_rating = :system_rating, comments = :comments, improvement_suggestions = :improvement_suggestions WHERE feedback_id = :id";
    $stmt = $con->prepare($sql);
    $stmt->execute([
        ':rating' => $rating,
        ':system_rating' => $system_rating,
        ':comments' => $comments,
        ':improvement_suggestions' => $improvement_suggestions,
        ':id' => $id,
    ]);
    header('Location: manage_feedbacks.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Master - Manage Feedbacks</title>
    <link rel="stylesheet" href="./styles/feedbacks.css">
    <style>
    /* Existing Modal Styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.6); /* Black w/ opacity */
        padding-top: 60px;
    }

    .modal-content {
        background-color: #ffffff;
        margin: 5% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        width: 90%; /* Adjusted for better responsiveness */
        max-width: 600px; /* Max width */
    }

    /* Close button styles */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    /* Close button hover effect */
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* New Styles for Form Elements */
    .form-group {
        margin-bottom: 15px; /* Spacing between fields */
    }

    .form-input,
    .form-textarea {
        width: 100%; /* Full width */
        padding: 10px; /* Padding */
        border: 1px solid #ccc; /* Border */
        border-radius: 5px; /* Rounded corners */
        box-sizing: border-box; /* Include padding in width */
        font-size: 16px; /* Font size */
    }

    .form-textarea {
        height: 100px; /* Height for textarea */
        resize: none; /* Disable resizing */
    }

    .modal-title {
        margin-bottom: 20px; /* Spacing below title */
        font-size: 24px; /* Title font size */
        color: #333; /* Title color */
    }

    .star-rating {
    display: flex;
    direction: ltr; /* Ensure the order of stars is left to right */
}

.star-rating input {
    display: none; /* Hide the radio buttons */
}

.star {
    font-size: 30px;
    color: lightgray; /* Default star color */
    cursor: pointer;
}

/* Star hover effect */
.star-rating .star:hover,
.star-rating .star:hover ~ .star {
    color: gold; /* Color for stars on hover */
}

/* Fill stars based on checked input */
.star-rating input:checked ~ label {
    color: gold; /* Fill stars to the right */
}

.star-rating input:checked + label,
.star-rating input:checked + label ~ label {
    color: gold; /* Fill stars to the left of the checked star */
}

/* This ensures all stars to the left of the selected one are also filled */
.star-rating input:checked ~ label {
    color: gold; /* Color for checked stars */
}




</style>

<body>
    <h1>Manage Feedbacks</h1>
    
    <div class="container">
        <div class="btn-container">
            <a href="add_feedback.php" class="btn">Give Feedback</a>
        </div>
        
        <div class="card-grid">
            <?php foreach ($feedbacks as $feedback) { ?>
                <div class="feedback-card">
                    <div class="card-header">
                        <h3><?php echo htmlspecialchars($feedback['coach_name']); ?></h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Rating:</strong> <span class="star-rating"><?php echo str_repeat("★", $feedback['rating']); ?></span></p>
                        <p><strong>System Rating:</strong> <span class="star-rating"><?php echo str_repeat("★", $feedback['system_rating']); ?></span></p>
                        <p><strong>Comments:</strong> <?php echo htmlspecialchars($feedback['comments']); ?></p>
                        <p><strong>Suggestions:</strong> <?php echo htmlspecialchars($feedback['improvement_suggestions']); ?></p>
                    </div>
                    <div class="card-footer">
                        <button class="btn edit" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($feedback)); ?>)">Edit</button>
                        <a href="?delete_id=<?php echo $feedback['feedback_id']; ?>" class="btn delete" onclick="return confirm('Are you sure?');">Delete</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

   <!-- The Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2 class="modal-title">Edit Feedback</h2>
        <form id="editFeedbackForm" method="POST">
            <input type="hidden" name="feedback_id" id="feedback_id">

            <div class="form-group">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" class="form-input" required>
                    <option value="">Select Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="form-group">
                <label for="system_rating">System Rating:</label>
                <select name="system_rating" id="system_rating" class="form-input" required>
                    <option value="">Select System Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="form-group">
                <label for="comments">Comments:</label>
                <textarea name="comments" id="comments" class="form-textarea" required></textarea>
            </div>

            <div class="form-group">
                <label for="improvement_suggestions">Suggestions for Improvement:</label>
                <textarea name="improvement_suggestions" id="improvement_suggestions" class="form-textarea" required></textarea>
            </div>

            <button type="submit" name="update_feedback" class="btn">Update Feedback</button>
        </form>
    </div>
</div>

    <script>
      function openEditModal(feedback) {
    document.getElementById('feedback_id').value = feedback.feedback_id;
    document.getElementById('comments').value = feedback.comments;
    document.getElementById('improvement_suggestions').value = feedback.improvement_suggestions;

    // Set the selected dropdown values for rating
    document.getElementById('rating').value = feedback.rating;
    document.getElementById('system_rating').value = feedback.system_rating;

    document.getElementById('editModal').style.display = "block";
}

        function closeEditModal() {
            document.getElementById('editModal').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>

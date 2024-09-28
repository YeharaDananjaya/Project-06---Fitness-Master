<?php
// Include navbar
include("navbar.php");
include("php/db.php");

// CREATE Feedback
if (isset($_POST['add_feedback'])) {
    $user_id = $_POST['user_id']; // Assumed to come from session or similar context
    $message = $_POST['message'];

    $sql = "INSERT INTO feedbacks (user_id, message) VALUES (:user_id, :message)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'message' => $message]);

    $feedbackMessage = "Feedback added successfully!";
}

// READ Feedbacks
$sql = "SELECT * FROM feedbacks";
$stmt = $conn->query($sql);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// DELETE Feedback
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM feedbacks WHERE feedback_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    header('Location: feedbacks.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Master - Feedbacks</title>
    <link rel="stylesheet" href="styles/style.css"> <!-- External CSS -->
    <script src="js/scripts.js" defer></script> <!-- External JavaScript -->
</head>
<body>
    <div class="container">
        <h1>Manage Feedbacks</h1>

        <?php if (isset($feedbackMessage)) { ?>
            <div class="feedback"><?php echo $feedbackMessage; ?></div>
        <?php } ?>

        <div class="contact-form">
            <h2>Add Feedback</h2>
            <form method="POST" action="">
                <input type="text" name="user_id" placeholder="User ID" required>
                <textarea name="message" placeholder="Feedback Message" required></textarea>
                <button type="submit" name="add_feedback">Add Feedback</button>
            </form>
        </div>

        <h2>Existing Feedbacks</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feedbacks as $feedback) { ?>
                    <tr>
                        <td><?php echo $feedback['feedback_id']; ?></td>
                        <td><?php echo $feedback['user_id']; ?></td>
                        <td><?php echo $feedback['message']; ?></td>
                        <td>
                            <a href="feedbacks.php?delete_id=<?php echo $feedback['feedback_id']; ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this feedback?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php
// Include footer
include("footer.php");
?>
</body>
</html>

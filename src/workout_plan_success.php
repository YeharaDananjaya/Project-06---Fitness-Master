<?php
// Include navbar
include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Plan Added Successfully</title>
    <link rel="stylesheet" href="./styles/feedbackstyle.css"> <!-- External CSS -->
</head>
<body>
    <div class="container">
        <h1>Workout Plan Added Successfully!</h1>
        <p>Your workout plan has been successfully added. Thank you!</p>
        <a href="view_workout_plans.php" class="submit-button">View All Workout Plans</a>
        <a href="add_workout_plan.php" class="submit-button">Add Another Workout Plan</a>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>

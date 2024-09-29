<?php
// Include navbar and database connection
include("navbar.php");
include("db.php"); // Make sure db.php sets up a MySQLi connection

// Start session to handle logged-in user
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Fetch coaches and diet plans to populate the dropdowns
$coach_sql = "SELECT coach_id, name FROM coaches";
$coach_result = $con->query($coach_sql);

$diet_sql = "SELECT diet_id, meal_plan FROM diet_plans";
$diet_result = $con->query($diet_sql);

// Handle schedule creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coach_id = (int)$_POST['coach_id'];
    $diet_id = (int)$_POST['diet_id'];
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);

    // Insert new schedule
    $insert_sql = "INSERT INTO schedules (coach_id, diet_id, start_date, end_date) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($insert_sql);
    $stmt->bind_param("iiss", $coach_id, $diet_id, $start_date, $end_date);
    
    if ($stmt->execute()) {
        $message = "Schedule added successfully!";
    } else {
        $error = "Error adding schedule: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Master - Add Schedule</title>
    <link rel="stylesheet" href="./styles/schedules.css">
</head>
<body>
    <div class="container">
        <h1>Add Schedule</h1>

        <?php if (isset($message)) echo "<p class='success'>$message</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="coach_id">Select Coach:</label>
                <select name="coach_id" id="coach_id" required>
                    <option value="">Choose Coach</option>
                    <?php while ($row = $coach_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['coach_id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="diet_id">Select Diet Plan:</label>
                <select name="diet_id" id="diet_id" required>
                    <option value="">Choose Diet Plan</option>
                    <?php while ($row = $diet_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['diet_id']; ?>"><?php echo $row['meal_plan']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" required>
            </div>

            <button type="submit">Add Schedule</button>
        </form>
    </div>
</body>
</html>

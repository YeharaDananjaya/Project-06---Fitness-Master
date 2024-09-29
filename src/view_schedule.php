<?php
// Include navbar and database connection
include("navbar.php");
include("db.php"); // Ensure db.php sets up a MySQLi connection

// Fetch all workout plans for the user
$user_id = 1; // Example user_id
$sql = "SELECT wp.plan_id, wp.start_date, wp.end_date, wp.session_count, wp.status, c.name as coach_name, mp.package_name 
        FROM workout_plans wp 
        JOIN coaches c ON wp.coach_id = c.coach_id 
        JOIN membership_packages mp ON wp.package_id = mp.package_id 
        WHERE wp.user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Master - View Schedule Plans</title>
    <link rel="stylesheet" href="./styles/feedbackstyle.css"> <!-- External CSS -->
</head>
<body>
    <div class="container">
        <h1>Your Schedule Plans</h1>

        <table>
            <thead>
                <tr>
                    <th>Plan ID</th>
                    <th>Coach</th>
                    <th>Package</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Sessions</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['plan_id']; ?></td>
                        <td><?php echo $row['coach_name']; ?></td>
                        <td><?php echo $row['package_name']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td><?php echo $row['end_date']; ?></td>
                        <td><?php echo $row['session_count']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php
// Include navbar
include("navbar.php");
include("php/db.php");

// CREATE Diet Plan
if (isset($_POST['add_diet'])) {
    $user_id = $_POST['user_id']; // Assumed to come from session or similar context
    $diet_description = $_POST['diet_description'];

    $sql = "INSERT INTO diet_plans (user_id, diet_description) VALUES (:user_id, :diet_description)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'diet_description' => $diet_description]);

    $message = "Diet Plan added successfully!";
}

// READ Diet Plans
$sql = "SELECT * FROM diet_plans";
$stmt = $conn->query($sql);
$dietPlans = $stmt->fetchAll(PDO::FETCH_ASSOC);

// DELETE Diet Plan
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM diet_plans WHERE diet_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    header('Location: diet_plans.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Master - Diet Plans</title>
    <link rel="stylesheet" href="styles/style.css"> <!-- External CSS -->
    <script src="js/scripts.js" defer></script> <!-- External JavaScript -->
</head>
<body>
    <div class="container">
        <h1>Manage Diet Plans</h1>

        <?php if (isset($message)) { ?>
            <div class="feedback"><?php echo $message; ?></div>
        <?php } ?>

        <div class="contact-form">
            <h2>Add a New Diet Plan</h2>
            <form method="POST" action="">
                <input type="text" name="user_id" placeholder="User ID" required>
                <textarea name="diet_description" placeholder="Diet Description" required></textarea>
                <button type="submit" name="add_diet">Add Diet</button>
            </form>
        </div>

        <h2>Existing Diet Plans</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Diet Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dietPlans as $dietPlan) { ?>
                    <tr>
                        <td><?php echo $dietPlan['diet_id']; ?></td>
                        <td><?php echo $dietPlan['user_id']; ?></td>
                        <td><?php echo $dietPlan['diet_description']; ?></td>
                        <td>
                            <a href="edit_diet.php?edit_id=<?php echo $dietPlan['diet_id']; ?>" class="action-btn edit">Edit</a>
                            <a href="diet_plans.php?delete_id=<?php echo $dietPlan['diet_id']; ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this diet plan?');">Delete</a>
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

<?php
// Start the session
session_start();

// Include your database connection file
require('db.php'); // Ensure db.php sets up a MySQLi connection

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}

$email = $_SESSION['email'];

// Fetch user information
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login after logout
    exit();
}

// Handle update logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $name = mysqli_real_escape_string($con, trim($_POST['name']));
    $gender = mysqli_real_escape_string($con, trim($_POST['gender']));
    $phone_number = mysqli_real_escape_string($con, trim($_POST['phone_number']));
    $new_password = mysqli_real_escape_string($con, trim($_POST['new_password']));

    $update_sql = "UPDATE users SET name='$name', gender='$gender', phone_number='$phone_number'" . 
                  ($new_password ? ", password='" . password_hash($new_password, PASSWORD_DEFAULT) . "'" : "") . 
                  " WHERE email='$email'";

    if (mysqli_query($con, $update_sql)) {
        $message = "Profile updated successfully.";
        // Refresh user data after update
        $user['name'] = $name;
        $user['gender'] = $gender;
        $user['phone_number'] = $phone_number;
    } else {
        $error = "Error updating profile: " . mysqli_error($con);
    }
}

// Handle account deletion
if (isset($_POST['delete'])) {
    $delete_sql = "DELETE FROM users WHERE email='$email'";
    if (mysqli_query($con, $delete_sql)) {
        session_destroy(); // Destroy the session
        header("Location: login.php"); // Redirect to login after deletion
        exit();
    } else {
        $error = "Error deleting account: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="styles/profile.css">
    <script>
        function toggleEditForm() {
            const editForm = document.getElementById('editForm');
            editForm.style.display = (editForm.style.display === 'block') ? 'none' : 'block';
        }

        function confirmAction(message, form) {
            if (confirm(message)) {
                form.submit();
            }
        }
    </script>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="main-container">
    <h1 class="welcome-message">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    
    <div class="card">
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>

        <div class="form-actions">
            <button class="button update" onclick="toggleEditForm()">Edit Profile</button>
            <form method="post" style="display: inline;">
                <button type="button" class="button delete" onclick="confirmAction('Are you sure you want to logout?', this.form)">Logout</button>
                <input type="hidden" name="logout">
            </form>
        </div>

        <?php if (isset($message)) { echo "<p class='success'>$message</p>"; } ?>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    </div>
</div>

<!-- Edit Profile Form Popup -->
<div id="editForm" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index: 1000;">
    <div class="popup-card">
        <h2>Edit Profile</h2>
        <form method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male" <?php echo ($user['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($user['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($user['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" placeholder="Leave blank to keep current password">
            </div>
            <div class="form-actions">
                <button type="submit" name="update" class="button update">Update Profile</button>
                <button type="button" class="button delete" onclick="toggleEditForm()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>

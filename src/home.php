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

include 'navbar.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/home.css">
    <title>Home</title>
</head>
<body>

<div class="home-container">
    <section class="hero">
        <h2>How Fitness Master helps you</h2>
        <p>At Fitness Master, we understand your goals and current lifestyle before creating a plan that works for YOU. 
        Your friend's choices aren't the best fit for you, and neither are generic plans.</p>
    </section>
    
    <section class="plans">
        <h2>The right plan for your health</h2>
        <p>Choose the perfect plan for your fitness needs. Flexible and easy to follow.</p>
        
        <div class="plan-cards">
            <div class="plan-card">
                <h3>Fitness and Nutrition Coaching</h3>
                <ul>
                    <li>Internationally certified coaches</li>
                    <li>Personalized workout plans</li>
                    <li>Nutrition advice tailored to your needs</li>
                    <li>Weekly check-ins with your coach</li>
                </ul>
                <button>View Coaches</button>
            </div>

            <div class="plan-card">
                <h3>Fitness and Nutrition Coaching</h3>
                <ul>
                    <li>Scientifically backed plans</li>
                    <li>Personalized based on your current fitness</li>
                    <li>Ongoing adjustments for progress</li>
                    <li>1-on-1 coaching support</li>
                </ul>
                <button>View Coaches</button>
            </div>

            <div class="plan-card">
                <h3>Fitness and Nutrition Coaching</h3>
                <ul>
                    <li>Advanced fitness strategies</li>
                    <li>Custom-tailored to your goals</li>
                    <li>Daily check-ins with your coach</li>
                    <li>Exclusive coaching advice</li>
                </ul>
                <button>View Coaches</button>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

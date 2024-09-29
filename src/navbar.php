<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensure proper scaling on mobile -->
    <title>Fitness Master</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif;">
    <header style="padding: 15px 0; background-color: #1c3d3f;">
        <div style="max-width: 1200px; margin: auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
            <div class="logo">
                <a href="#" style="text-decoration: none; color: white; font-size: 24px; font-weight: bold;">Fitness Master</a>
            </div>
            <nav>
                <ul style="list-style: none; padding: 0; display: flex; gap: 20px;">
                    <li>
                        <a href="home.php" style="text-decoration: none; color: white; font-weight: 600; padding: 10px 15px; border-radius: 5px; transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;">Home</a>
                    </li>
                    <li>
                        <a href="add_schedule.php" style="text-decoration: none; color: white; font-weight: 600; padding: 10px 15px; border-radius: 5px; transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;">Get a Coach</a>
                    </li>
                    <li>
                        <a href="tips.php" style="text-decoration: none; color: white; font-weight: 600; padding: 10px 15px; border-radius: 5px; transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;">Tips</a>
                    </li>
                    <li>
                        <a href="manage_feedbacks.php" style="text-decoration: none; color: white; font-weight: 600; padding: 10px 15px; border-radius: 5px; transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;">Feedbacks</a>
                    </li>
                    <li>
                        <a href="logout.php" style="text-decoration: none; color: white; font-weight: 600; padding: 10px 15px; border-radius: 5px; transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;">Logout</a>
                    </li>
                </ul>
            </nav>
            <div class="burger" style="display: none; cursor: pointer;">
                <div style="width: 25px; height: 3px; background: white; margin: 4px 0; transition: 0.4s;"></div>
                <div style="width: 25px; height: 3px; background: white; margin: 4px 0; transition: 0.4s;"></div>
                <div style="width: 25px; height: 3px; background: white; margin: 4px 0; transition: 0.4s;"></div>
            </div>
        </div>
    </header>

    <script src="js/scripts.js"></script> <!-- External JavaScript for Burger Menu -->
    
    <style>
        /* Inline styles for enhanced hover effects */
        nav ul li a:hover {
            background-color: #4ecdc4; /* Lighter teal on hover */
            color: #ffffff; /* Keep text white */
            transform: scale(1.1); /* Slightly scale up the link */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Add shadow */
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5); /* Subtle text shadow */
        }
    </style>
</body>
</html>

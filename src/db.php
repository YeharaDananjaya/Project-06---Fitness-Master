<?php
// PDO database connection
try {
    $con = new PDO("mysql:host=localhost;dbname=fitness_master", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();  // Stop further execution if connection fails
}
?>

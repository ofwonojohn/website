<?php
session_start();

// Check if the user is logged in and has the role of 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login page if not logged in or not admin
    exit;
}

include '../db.php'; // Include the database connection
include '../header.php'; // Include the header

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css"> <!-- Link to your CSS file -->
    <title>Admin Dashboard</title>
</head>
<body>
    <main>
        <h2>Welcome, Admin!</h2>
        <section>
            <h3>Manage System</h3>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_restaurants.php">Manage Restaurants</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="sales_report.php">View Sales Reports</a></li> 
            </ul>
        </section>
    </main>
    
    <?php include '../footer.php'; // Include the footer ?>
</body>
</html>

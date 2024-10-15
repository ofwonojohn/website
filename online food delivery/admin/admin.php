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
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        main {
            width: 80%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        section {
            margin-top: 20px;
        }
        ul {
            list-style: none; /* Remove bullet points */
            padding: 0;
        }
        ul li {
            margin-bottom: 15px;
        }
        ul li a {
            display: flex;
            align-items: center;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        ul li a:hover {
            background-color: #45a049;
        }
        ul li a i {
            margin-right: 10px;
        }
        .cta-section {
            text-align: center;
            margin-top: 30px;
        }
        .cta-section a {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .cta-section a:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <main>
        <h2>Welcome, Admin!</h2>
        <section>
            <h3>Manage System</h3>
            <ul>
                <li>
                    <a href="manage_users.php">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                </li>
                <li>
                    <a href="manage_restaurants.php">
                        <i class="fas fa-utensils"></i> Manage Restaurants
                    </a>
                </li>
                <li>
                    <a href="manage_orders.php">
                        <i class="fas fa-list"></i> Manage Orders
                    </a>
                </li>
                <li>
                    <a href="sales_report.php">
                        <i class="fas fa-chart-bar"></i> View Sales Reports
                    </a>
                </li>
            </ul>
        </section>

        <div class="cta-section">
            <a href="../index.php"><i class="fas fa-home"></i> Back to Home</a>
        </div>
    </main>

    <?php include '../footer.php'; // Include the footer ?>
</body>
</html>

<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

include 'db.php'; // Include the database connection
include 'header.php'; // Include the header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
    <title>Home - Online Food Delivery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        main {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #4CAF50;
            text-align: center;
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
        }
        .featured-restaurants {
            margin: 20px 0;
        }
        .restaurant {
            display: inline-block;
            width: 30%;
            margin: 1%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .restaurant img {
            max-width: 100%;
            border-radius: 5px;
        }
        .cta {
            text-align: center;
            margin-top: 30px;
        }
        .cta a {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .cta a:hover {
            background-color: #45a049;
        }
        .admin-button {
            text-align: center;
            margin-top: 20px;
        }
        .admin-button a {
            background-color: #FF5722;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .admin-button a:hover {
            background-color: #E64A19;
        }
    </style>
</head>
<body>
    <main>
        <div class="welcome-message">
            <h2>Welcome to Our Online Food Delivery Service!</h2>
            <p>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
            <p>We provide quick and easy food delivery from your favorite local restaurants.</p>
        </div>
        
        <div class="featured-restaurants">
            <h3>Featured Restaurants</h3>
            <div class="restaurant">
                <img src="images/restaurant1.jpg" alt="Restaurant 1">
                <h4>The Pearl Of Africa</h4>
                <p>Delicious cuisines and fast delivery!</p>
                <a href="view_restaurants.php">Order Now</a>
            </div>
            <div class="restaurant">
                <img src="images/restaurant3.jpg" alt="Restaurant 3">
                <h4>Kampala Grill</h4>
                <p>Try our chef's special menu for today!</p>
                <a href="view_restaurants.php">Order Now</a>
            </div>
        </div>

        <div class="cta">
            <h3>Ready to order?</h3>
            <a href="filter.php">Explore Restaurants</a>
        </div>

        <!-- Admin Button (Only visible to admins) -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div class="admin-button">
                <a href="admin/admin.php">Go to Admin Panel</a>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; // Include the footer ?>
</body>
</html>

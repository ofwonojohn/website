<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">  
    <title>Online Food Delivery</title>
</head>
<body>
    <header>
        <h1>Online Food Delivery</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>

                <?php
                // Check if the user is logged in
                if (isset($_SESSION['user_id'])) {
                    echo '<li><a href="login.php">Logout</a></li>'; // Logout link
                } else {
                    echo '<li><a href="register.php">Register</a></li>';
                    echo '<li><a href="login.php">Login</a></li>';
                }
                ?>
                
                <li><a href="filter.php">Filter Restaurants</a></li>
                <li><a href="view_restaurants.php">View Restaurants</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>

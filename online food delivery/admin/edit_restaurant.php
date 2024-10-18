<?php
include '../db.php'; // Include the database connection
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirect to login if not admin
    exit;
}

// Fetch the restaurant details based on the restaurant_id
if (isset($_GET['restaurant_id'])) {
    $restaurant_id = $_GET['restaurant_id'];
    
    // Fetch the restaurant data from the database
    $stmt = $pdo->prepare("SELECT * FROM Restaurants WHERE restaurant_id = ?");
    $stmt->execute([$restaurant_id]);
    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$restaurant) {
        echo "<p>Restaurant not found.</p>";
        exit;
    }
} else {
    echo "<p>No restaurant ID specified.</p>";
    exit;
}

// Handle form submission for updating the restaurant
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $description = $_POST['description'];

    // Update the restaurant record
    $stmt = $pdo->prepare("UPDATE Restaurants SET name = ?, address = ?, description = ? WHERE restaurant_id = ?");
    $stmt->execute([$name, $address, $description, $restaurant_id]);

    // Redirect back to the manage restaurants page after updating
    header("Location: manage_restaurants.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <title>Edit Restaurant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        main {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        a:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Edit Restaurant</h1>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?restaurant_id=" . $restaurant_id; ?>" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($restaurant['name']); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($restaurant['address']); ?>" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($restaurant['location']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($restaurant['description']); ?></textarea>

            <input type="submit" value="Update Restaurant">
        </form>
        <a href="manage_restaurants.php">Back to Manage Restaurants</a>
    </main>
</body>
</html>

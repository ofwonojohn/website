<?php
include '../db.php'; // Include the database connection
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirect to login if not admin
    exit;
}

// Fetch all restaurants
$stmt = $pdo->query("SELECT * FROM Restaurants");
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <title>Manage Restaurants</title>
</head>
<body>
    <header>
        <h1>Manage Restaurants</h1>
    </header>
    <main>
        <a href="add_restaurant.php" class="add-restaurant-btn">Add Restaurant</a> <!-- Add Restaurant Button -->
        <table>
            <thead>
                <tr>
                    <th>Restaurant ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($restaurants as $restaurant): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($restaurant['restaurant_id']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['name']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['address']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['description']); ?></td>
                        <td>
                            <a href="edit_restaurant.php?restaurant_id=<?php echo $restaurant['restaurant_id']; ?>">Edit</a>
                            <a href="?delete=<?php echo $restaurant['restaurant_id']; ?>" onclick="return confirm('Are you sure you want to delete this restaurant?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <style>
        .add-restaurant-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .add-restaurant-btn:hover {
            background-color: #45a049;
        }
    </style>
</body>
</html>

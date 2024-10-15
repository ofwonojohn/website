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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <title>Manage Restaurants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        main {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .add-restaurant-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 15px;
            margin: 20px auto; /* Centering the button with auto margins */
            display: block; /* Make it a block element */
            text-align: center; /* Center the text */
            width: 200px; /* Set a specific width */
        }
        .add-restaurant-btn:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #2196F3;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
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
                        <td class="actions">
                            <a href="edit_restaurant.php?restaurant_id=<?php echo $restaurant['restaurant_id']; ?>">Edit</a>
                            <a href="?delete=<?php echo $restaurant['restaurant_id']; ?>" onclick="return confirm('Are you sure you want to delete this restaurant?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <?php include '../footer.php'; // Include the footer ?>
</body>
</html>

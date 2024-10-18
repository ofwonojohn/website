<?php
include '../db.php'; // Include the database connection
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirect to login if not admin
    exit;
}

// Initialize variables
$restaurants = [];
$message = '';

// Fetch all restaurants with optional location filtering
if (isset($_GET['location'])) {
    $location = htmlspecialchars($_GET['location']);
    
    // Use the location directly for filtering
    $stmt = $pdo->prepare("SELECT * FROM Restaurants WHERE location LIKE ?");
    $stmt->execute(["%$location%"]); // Use LIKE for partial matching
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if any restaurants were found
    if (empty($restaurants)) {
        $message = "No results found for \"{$location}\"."; // Set message for no results
    }
} else {
    $stmt = $pdo->query("SELECT * FROM Restaurants");
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Define suggested locations
$suggested_locations = ["Kampala", "Wakiso", "Masaka"];
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
        .no-results {
            color: #ff0000; /* Red color for no results message */
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Restaurants</h1>
    </header>
    <main>
        <form method="GET" action="" style="margin-bottom: 20px;">
            <input type="text" name="location" list="locations" placeholder="Type your location or select from options" required>
            <datalist id="locations">
                <?php foreach ($suggested_locations as $suggested_location): ?>
                    <option value="<?php echo htmlspecialchars($suggested_location); ?>">
                <?php endforeach; ?>
            </datalist>
            <input type="submit" value="Filter">
        </form>

        <?php if ($message): ?>
            <div class="no-results"><?php echo $message; ?></div> <!-- Display no results message -->
        <?php endif; ?>

        <a href="add_restaurant.php" class="add-restaurant-btn">Add Restaurant</a> <!-- Add Restaurant Button -->

        <table>
            <thead>
                <tr>
                    <th>Restaurant ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Location</th> 
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
                        <td><?php echo htmlspecialchars($restaurant['location']); ?></td>
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

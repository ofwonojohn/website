<?php
include 'db.php'; // Include database connection

// Fetch all restaurants from the database
$stmt = $pdo->prepare("SELECT * FROM Restaurants");
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to external CSS file -->
    <title>View Restaurants</title>
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
        h1 {
            margin: 0;
        }
        h2 {
            color: #4CAF50;
            text-align: center;
        }
        .restaurant-list {
            margin-top: 20px;
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove default padding */
        }
        .restaurant-list li {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px 0;
            background-color: #f9f9f9;
            transition: background-color 0.3s;
        }
        .restaurant-list li:hover {
            background-color: #e0f7e0;
        }
        .restaurant-link {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
        .restaurant-link:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Online Food Delivery</h1>
    </header>
    <main>
        <h2>Available Restaurants</h2>

        <?php if (count($restaurants) > 0): ?>
            <ul class="restaurant-list">
                <?php foreach ($restaurants as $restaurant): ?>
                    <li>
                        <a class="restaurant-link" 
                           href="restaurant_details.php?restaurant_id=<?php echo $restaurant['restaurant_id']; ?>">
                            <?php echo htmlspecialchars($restaurant['name']); ?>
                        </a> 
                        - <?php echo htmlspecialchars($restaurant['description']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No restaurants found.</p>
        <?php endif; ?>
    </main>
</body>
</html>

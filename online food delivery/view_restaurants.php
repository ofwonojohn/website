<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
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
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 5px 0;
            background-color: #f9f9f9;
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
        
        <?php
        // Include the database connection
        include 'db.php'; 

        try {
            // Fetch all restaurants
            $stmt = $pdo->query("SELECT * FROM Restaurants");
            $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($restaurants) > 0) {
                echo "<ul class='restaurant-list'>";
                foreach ($restaurants as $restaurant) {
                    echo "<li>" . htmlspecialchars($restaurant['name']) . " - " . htmlspecialchars($restaurant['description']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No restaurants available at the moment.</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='error-message'>Failed to retrieve restaurants: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </main>
</body>
</html>

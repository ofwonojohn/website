<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css"> <!-- Adjust the path if necessary -->
    <title>Filter Restaurants</title>
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
        form {
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
    </style>
</head>
<body>
    <header>
        <h1>Online Food Delivery</h1>
    </header>
    <main>
        <h2>Filter Restaurants</h2>
        
        <?php
        // Include the database connection
        include 'db.php'; 

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $restaurant_name = isset($_GET['restaurant_name']) ? $_GET['restaurant_name'] : '';

            try {
                // Prepare SQL query with filtering
                $stmt = $pdo->prepare("SELECT * FROM Restaurants WHERE name LIKE ?");
                $stmt->execute(['%' . $restaurant_name . '%']);
                $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<h3>Filtered Restaurants</h3>";
                if (count($restaurants) > 0) {
                    echo "<ul class='restaurant-list'>";
                    foreach ($restaurants as $restaurant) {
                        echo "<li>" . htmlspecialchars($restaurant['name']) . " - " . htmlspecialchars($restaurant['description']) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No restaurants found.</p>";
                }
            } catch (PDOException $e) {
                echo "Filtering failed: " . $e->getMessage();
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <label for="restaurant_name">Restaurant Name:</label>
            <input type="text" id="restaurant_name" name="restaurant_name" placeholder="Enter restaurant name..."><br>

            <input type="submit" value="Filter">
        </form>
    </main>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
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
        h1, h2 {
            text-align: center;
            margin: 0;
            color: #4CAF50;
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
            list-style-type: none;
            padding: 0;
        }
        .restaurant-list li {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 5px 0;
            background-color: #f9f9f9;
        }
        .no-results {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Online Food Delivery</h1>
    </header>
    <main>
        <h2>Filter Restaurants</h2>

        <!-- Search Form -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <label for="restaurant_name">Restaurant Name:</label>
            <input type="text" id="restaurant_name" name="restaurant_name" placeholder="Enter restaurant name...">

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" list="locations" placeholder="Type location or select from options">
            <datalist id="locations">
                <?php
                $suggested_locations = ["Kampala", "Wakiso", "Masaka"];
                foreach ($suggested_locations as $location) {
                    echo "<option value='" . htmlspecialchars($location) . "'>";
                }
                ?>
            </datalist>

            <input type="submit" value="Filter">
        </form>

        <?php
        // Include the database connection
        include 'db.php';

        // Initialize variables
        $restaurants = [];
        $message = '';

        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $restaurant_name = isset($_GET['restaurant_name']) ? $_GET['restaurant_name'] : '';
            $location = isset($_GET['location']) ? $_GET['location'] : '';

            try {
                // Prepare SQL query with optional filtering by name and location
                $query = "SELECT * FROM Restaurants WHERE 1=1";
                $params = [];

                if (!empty($restaurant_name)) {
                    $query .= " AND name LIKE ?";
                    $params[] = '%' . $restaurant_name . '%';
                }

                if (!empty($location)) {
                    $query .= " AND location LIKE ?";
                    $params[] = '%' . $location . '%';
                }

                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<h3>Filtered Restaurants</h3>";
                if (!empty($restaurants)) {
                    echo "<ul class='restaurant-list'>";
                    foreach ($restaurants as $restaurant) {
                        echo "<li>" . htmlspecialchars($restaurant['name']) . " - " 
                             . htmlspecialchars($restaurant['description']) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    $message = "No restaurants found.";
                    echo "<p class='no-results'>$message</p>";
                }
            } catch (PDOException $e) {
                echo "Filtering failed: " . $e->getMessage();
            }
        }
        ?>
    </main>
</body>
</html>

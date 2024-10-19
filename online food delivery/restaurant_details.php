<?php
include 'db.php'; // Include database connection
session_start(); // Start the session

// Get the restaurant ID from the query string
$restaurant_id = $_GET['restaurant_id'] ?? null;

if (!$restaurant_id) {
    echo "Invalid restaurant selection.";
    exit;
}

// Fetch the restaurant details
$stmt = $pdo->prepare("SELECT * FROM Restaurants WHERE restaurant_id = ?");
$stmt->execute([$restaurant_id]);
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$restaurant) {
    echo "Restaurant not found.";
    exit;
}

// Fetch the menu items for the restaurant
$stmt = $pdo->prepare("SELECT * FROM Menus WHERE restaurant_id = ?");
$stmt->execute([$restaurant_id]);
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($restaurant['name']); ?></title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($restaurant['name']); ?></h1>
    <p><?php echo htmlspecialchars($restaurant['description']); ?></p>

    <h2>Menu</h2>
    <?php if (count($menu_items) > 0): ?>
        <ul>
            <?php foreach ($menu_items as $item): ?>
                <li>
                    <?php echo htmlspecialchars($item['item_name']); ?> - 
                    Shs <?php echo number_format($item['price'], 2); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No menu items available for this restaurant.</p>
    <?php endif; ?>
</body>
</html>

<?php
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $restaurant_id = $_POST['restaurant_id'];
    $menu_items = $_POST['menu_items'] ?? [];

    if (empty($menu_items)) {
        echo "No menu items selected.";
        exit;
    }

    // Insert the order into the Orders table
    $stmt = $pdo->prepare("INSERT INTO Orders (restaurant_id, order_date) VALUES (?, NOW())");
    $stmt->execute([$restaurant_id]);
    $order_id = $pdo->lastInsertId(); // Get the newly inserted order ID

    // Insert the selected menu items into the Order_Items table
    $item_stmt = $pdo->prepare("INSERT INTO Order_Items (order_id, menu_id) VALUES (?, ?)");
    foreach ($menu_items as $menu_id) {
        $item_stmt->execute([$order_id, $menu_id]);
    }

    echo "Order placed successfully!";
} else {
    echo "Invalid request.";
}
?>

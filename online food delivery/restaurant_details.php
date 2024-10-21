<?php
include 'db.php'; // Include the database connection

// Get the restaurant ID and simulate a logged-in user (replace with your logic)
$restaurant_id = $_GET['restaurant_id'] ?? 0;
$user_id = 1; // Replace with actual user ID from session or authentication

// Fetch the restaurant details
$stmt = $pdo->prepare("SELECT * FROM Restaurants WHERE restaurant_id = ?");
$stmt->execute([$restaurant_id]);
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$restaurant) {
    die("Restaurant not found.");
}

// Fetch the restaurant's menu items
$menu_stmt = $pdo->prepare("SELECT * FROM Menus WHERE restaurant_id = ?");
$menu_stmt->execute([$restaurant_id]);
$menu_items = $menu_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = $_POST['order'] ?? [];

    if (!empty($order)) {
        $pdo->beginTransaction(); // Start a transaction

        try {
            $total_price = 0;

            // Calculate the total price and prepare order item data
            foreach ($order as $menu_id => $quantity) {
                if ($quantity > 0) {
                    $item_stmt = $pdo->prepare("SELECT price FROM Menus WHERE menu_id = ?");
                    $item_stmt->execute([$menu_id]);
                    $item = $item_stmt->fetch(PDO::FETCH_ASSOC);

                    if ($item) {
                        $subtotal = $item['price'] * $quantity;
                        $total_price += $subtotal;
                    }
                }
            }

            // Insert the order into the Orders table
            $order_stmt = $pdo->prepare(
                "INSERT INTO Orders (user_id, restaurant_id, total_price, total_amount, order_status) 
                 VALUES (?, ?, ?, ?, 'pending')"
            );
            $order_stmt->execute([$user_id, $restaurant_id, $total_price, $total_price]);
            $order_id = $pdo->lastInsertId(); // Get the new order ID

            // Insert each item into the Order_Items table
            foreach ($order as $menu_id => $quantity) {
                if ($quantity > 0) {
                    $item_stmt = $pdo->prepare("SELECT price FROM Menus WHERE menu_id = ?");
                    $item_stmt->execute([$menu_id]);
                    $item = $item_stmt->fetch(PDO::FETCH_ASSOC);

                    if ($item) {
                        $subtotal = $item['price'] * $quantity;

                        $order_item_stmt = $pdo->prepare(
                            "INSERT INTO Order_Items (order_id, menu_id, quantity, price) 
                             VALUES (?, ?, ?, ?)"
                        );
                        $order_item_stmt->execute([$order_id, $menu_id, $quantity, $item['price']]);
                    }
                }
            }

            $pdo->commit(); // Commit the transaction
            echo "<p>Order placed successfully!</p>";

        } catch (Exception $e) {
            $pdo->rollBack(); // Roll back the transaction if there is an error
            echo "<p>Failed to place the order: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Please select at least one item to order.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($restaurant['name']); ?> - Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
            color: #4CAF50;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .quantity-input {
            width: 50px;
            margin-left: 10px;
        }
        .order-button {
            display: block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <main>
        <h1>Menu for <?php echo htmlspecialchars($restaurant['name']); ?></h1>
        <form method="POST" action="">
            <ul>
                <?php foreach ($menu_items as $item): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($item['item_name']); ?></strong> - 
                        Shs <?php echo number_format($item['price'], 2); ?><br>
                        <em><?php echo htmlspecialchars($item['description']); ?></em>

                        <?php if (!$item['is_available']): ?>
                            <span style="color: red;">(Not available)</span>
                        <?php else: ?>
                            <label>
                                Quantity:
                                <input type="number" name="order[<?php echo $item['menu_id']; ?>]" 
                                       class="quantity-input" min="0" value="0">
                            </label>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="submit" class="order-button">Place Order</button>
        </form>
    </main>
</body>
</html>

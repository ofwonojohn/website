<?php
include 'db.php'; // Include the database connection

$restaurant_id = $_GET['restaurant_id'] ?? 0;
$user_id = 1; // Replace with actual user ID

$stmt = $pdo->prepare("SELECT * FROM Restaurants WHERE restaurant_id = ?");
$stmt->execute([$restaurant_id]);
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$restaurant) {
    die("Restaurant not found.");
}

$menu_stmt = $pdo->prepare("SELECT * FROM Menus WHERE restaurant_id = ?");
$menu_stmt->execute([$restaurant_id]);
$menu_items = $menu_stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = $_POST['order'] ?? [];
    if (!empty($order)) {
        $pdo->beginTransaction();
        try {
            $total_price = 0;
            foreach ($order as $menu_id => $quantity) {
                if ($quantity > 0) {
                    $item_stmt = $pdo->prepare("SELECT price FROM Menus WHERE menu_id = ?");
                    $item_stmt->execute([$menu_id]);
                    $item = $item_stmt->fetch(PDO::FETCH_ASSOC);
                    $total_price += $item['price'] * $quantity;
                }
            }

            $order_stmt = $pdo->prepare(
                "INSERT INTO Orders (user_id, restaurant_id, total_price, total_amount, order_status) 
                 VALUES (?, ?, ?, ?, 'pending')"
            );
            $order_stmt->execute([$user_id, $restaurant_id, $total_price, $total_price]);
            $order_id = $pdo->lastInsertId();

            foreach ($order as $menu_id => $quantity) {
                if ($quantity > 0) {
                    $item_stmt = $pdo->prepare("SELECT price FROM Menus WHERE menu_id = ?");
                    $item_stmt->execute([$menu_id]);
                    $item = $item_stmt->fetch(PDO::FETCH_ASSOC);
                    $order_item_stmt = $pdo->prepare(
                        "INSERT INTO Order_Items (order_id, menu_id, quantity, price) 
                         VALUES (?, ?, ?, ?)"
                    );
                    $order_item_stmt->execute([$order_id, $menu_id, $quantity, $item['price']]);
                }
            }

            $pdo->commit();
            echo "<p>Order placed successfully!</p>";
        } catch (Exception $e) {
            $pdo->rollBack();
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
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        main {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            background-color: #fafafa;
            border-radius: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        li:hover {
            transform: scale(1.02);
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.15);
        }
        .item-details {
            flex: 1;
        }
        .item-name {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 5px;
        }
        .item-price {
            color: #4CAF50;
            font-weight: bold;
        }
        .quantity-input {
            width: 60px;
            margin-left: 10px;
        }
        .order-button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .order-button:hover {
            background-color: #45a049;
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
                        <div class="item-details">
                            <div class="item-name"><?php echo htmlspecialchars($item['item_name']); ?></div>
                            <div class="item-price">Shs <?php echo number_format($item['price'], 2); ?></div>
                            <div><?php echo htmlspecialchars($item['description']); ?></div>
                        </div>
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

<?php
include '../db.php'; // Database connection

// Fetch data for the report
$restaurants = $pdo->query("SELECT restaurant_id, name, address, phone FROM Restaurants ORDER BY restaurant_id")->fetchAll();
$menu_items = $pdo->query("SELECT r.restaurant_id, r.name AS restaurant_name, m.item_name, m.price, m.description FROM Restaurants r JOIN Menus m ON r.restaurant_id = m.restaurant_id ORDER BY r.restaurant_id, m.item_name")->fetchAll();
$total_orders = $pdo->query("SELECT r.restaurant_id, r.name AS restaurant_name, COUNT(o.order_id) AS total_orders FROM Restaurants r LEFT JOIN Orders o ON r.restaurant_id = o.restaurant_id GROUP BY r.restaurant_id ORDER BY total_orders DESC")->fetchAll();
$total_sales = $pdo->query("SELECT r.restaurant_id, r.name AS restaurant_name, SUM(oi.quantity * m.price) AS total_sales FROM Restaurants r LEFT JOIN Orders o ON r.restaurant_id = o.restaurant_id LEFT JOIN Order_Items oi ON o.order_id = oi.order_id LEFT JOIN Menus m ON oi.menu_id = m.menu_id GROUP BY r.restaurant_id ORDER BY total_sales DESC")->fetchAll();
$menu_summary = $pdo->query("SELECT restaurant_id, COUNT(item_name) AS total_items, AVG(price) AS average_price FROM Menus GROUP BY restaurant_id ORDER BY restaurant_id")->fetchAll();

// Output the report (basic HTML structure)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Restaurant Report</h1>

<h2>1. List of All Restaurants</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Restaurant Name</th>
        <th>Address</th>
        <th>Phone</th>
    </tr>
    <?php foreach ($restaurants as $r): ?>
    <tr>
        <td><?php echo $r['restaurant_id']; ?></td>
        <td><?php echo $r['name']; ?></td>
        <td><?php echo $r['address']; ?></td>
        <td><?php echo $r['phone']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>2. Menu Items for Each Restaurant</h2>
<table>
    <tr>
        <th>Restaurant ID</th>
        <th>Item Name</th>
        <th>Price</th>
        <th>Description</th>
    </tr>
    <?php foreach ($menu_items as $m): ?>
    <tr>
        <td><?php echo $m['restaurant_id']; ?></td>
        <td><?php echo $m['item_name']; ?></td>
        <td><?php echo $m['price']; ?></td>
        <td><?php echo $m['description']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>3. Total Orders Placed Per Restaurant</h2>
<table>
    <tr>
        <th>Restaurant ID</th>
        <th>Restaurant Name</th>
        <th>Total Orders</th>
    </tr>
    <?php foreach ($total_orders as $o): ?>
    <tr>
        <td><?php echo $o['restaurant_id']; ?></td>
        <td><?php echo $o['restaurant_name']; ?></td>
        <td><?php echo $o['total_orders']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>4. Total Sales Amount Per Restaurant</h2>
<table>
    <tr>
        <th>Restaurant ID</th>
        <th>Restaurant Name</th>
        <th>Total Sales</th>
    </tr>
    <?php foreach ($total_sales as $s): ?>
    <tr>
        <td><?php echo $s['restaurant_id']; ?></td>
        <td><?php echo $s['restaurant_name']; ?></td>
        <td><?php echo number_format($s['total_sales'], 2); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>5. Summary of Menu Items</h2>
<table>
    <tr>
        <th>Restaurant ID</th>
        <th>Total Items</th>
        <th>Average Price</th>
    </tr>
    <?php foreach ($menu_summary as $ms): ?>
    <tr>
        <td><?php echo $ms['restaurant_id']; ?></td>
        <td><?php echo $ms['total_items']; ?></td>
        <td><?php echo number_format($ms['average_price'], 2); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

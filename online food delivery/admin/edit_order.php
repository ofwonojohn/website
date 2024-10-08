<?php
include '../db.php'; // Include the database connection
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirect to login if not admin
    exit;
}

// Fetch the order details based on the order_id
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    
    // Fetch the order data from the database
    $stmt = $pdo->prepare("SELECT * FROM Orders WHERE order_id = ?");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo "<p>Order not found.</p>";
        exit;
    }
} else {
    echo "<p>No order ID specified.</p>";
    exit;
}

// Handle form submission for updating the order
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $restaurant_id = $_POST['restaurant_id'];
    $total_price = $_POST['total_price'];
    $order_status = $_POST['order_status'];

    // Update the order record
    $stmt = $pdo->prepare("UPDATE Orders SET user_id = ?, restaurant_id = ?, total_price = ?, order_status = ? WHERE order_id = ?");
    $stmt->execute([$user_id, $restaurant_id, $total_price, $order_status, $order_id]);

    // Redirect back to the manage orders page after updating
    header("Location: manage_orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <title>Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        main {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        select,
        textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
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
        a {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        a:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Edit Order</h1>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?order_id=" . $order_id; ?>" method="POST">
            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($order['user_id']); ?>" required>

            <label for="restaurant_id">Restaurant ID:</label>
            <input type="text" id="restaurant_id" name="restaurant_id" value="<?php echo htmlspecialchars($order['restaurant_id']); ?>" required>

            <label for="total_price">Total Price:</label>
            <input type="number" id="total_price" name="total_price" value="<?php echo htmlspecialchars($order['total_price']); ?>" required>

            <label for="order_status">Order Status:</label>
            <select id="order_status" name="order_status" required>
                <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Completed" <?php if ($order['order_status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                <option value="Cancelled" <?php if ($order['order_status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>

            <input type="submit" value="Update Order">
        </form>
        <a href="manage_orders.php">Back to Manage Orders</a>
    </main>
</body>
</html>

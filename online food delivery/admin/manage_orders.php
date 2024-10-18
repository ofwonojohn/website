<?php
include '../db.php'; // Include the database connection
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirect to login if not admin
    exit;
}

// Fetch all orders
$stmt = $pdo->query("SELECT * FROM Orders");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <title>Manage Orders</title>
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
        .search-container {
            margin-bottom: 20px;
            text-align: right; /* Align search bar to the right */
        }
        .search-container input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .search-container button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 5px;
        }
        .search-container button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #2196F3;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Orders</h1>
    </header>
    <main>
        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="search" placeholder="Search orders..." onkeyup="searchOrders()">
            <button onclick="searchOrders()">Search</button>
        </div>

        <table id="orderTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Restaurant ID</th>
                    <th>Total Price</th>
                    <th>Order Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['restaurant_id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($order['total_price']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                        <td class="actions">
                            <a href="edit_order.php?order_id=<?php echo $order['order_id']; ?>">Edit</a>
                            <a href="?delete=<?php echo $order['order_id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        function searchOrders() {
            const input = document.getElementById("search").value.toLowerCase();
            const table = document.getElementById("orderTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header
                const cells = rows[i].getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j]) {
                        const cellValue = cells[j].textContent || cells[j].innerText;
                        if (cellValue.toLowerCase().indexOf(input) > -1) {
                            found = true;
                            break; // Break the inner loop if a match is found
                        }
                    }
                }
                rows[i].style.display = found ? "" : "none"; // Show or hide the row
            }
        }
    </script>
</body>
</html>

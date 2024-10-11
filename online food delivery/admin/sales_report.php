<?php
session_start(); // Start the session

// Check if the user is logged in and has the role of 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login page if not logged in or not admin
    exit;
}

include '../db.php'; // Include the database connection
include '../header.php'; // Include the header

// Initialize variables
$totalSales = 0;
$totalOrders = 0;

// Handle form submission for date range
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    try {
        // Prepare SQL query to calculate total sales and orders in the date range for all restaurants
        $stmt = $pdo->prepare("
            SELECT SUM(total_amount) AS total_sales, COUNT(order_id) AS total_orders 
            FROM Orders 
            WHERE created_at BETWEEN ? AND ?
        ");
        $stmt->execute([$startDate, $endDate]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $totalSales = $result['total_sales'] ? $result['total_sales'] : 0;
            $totalOrders = $result['total_orders'] ? $result['total_orders'] : 0;
        }
    } catch (PDOException $e) {
        echo "Error fetching sales data: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Sales Reports</title>
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
        h2 {
            color: #4CAF50;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="date"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .report-summary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <main>
        <h2>Sales Reports</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
            <input type="submit" value="Generate Report">
        </form>

        <div class="report-summary">
            <h3>Report Summary</h3>
            <p>Total Sales: $<?php echo number_format($totalSales, 2); ?></p>
            <p>Total Orders: <?php echo $totalOrders; ?></p>
        </div>
    </main>
    
    <?php include '../footer.php'; // Include the footer ?>
</body>
</html>

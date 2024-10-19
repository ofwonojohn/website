<?php
session_start(); // Start the session

// Check if the user is logged in and has the role of 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login page if not logged in or not admin
    exit;
}

include '../db.php'; // Include the database connection

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
            SELECT SUM(total_price) AS total_sales, COUNT(order_id) AS total_orders 
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
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
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
            text-align: center;
        }
        header {
            text-align: center; /* Center the header content */
            padding: 20px;
        }
        header h1 {
            text-transform: uppercase; /* Make the header text uppercase */
            color: #4CAF50;
            margin: 0; /* Remove default margin */
        }
        form {
            margin-bottom: 20px;
            text-align: center; /* Center the form elements */
        }
        label {
            font-weight: bold;
        }
        input[type="date"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 0 10px; /* Adjust margins */
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px; /* Add more padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .report-summary {
            margin-top: 20px;
            text-align: center; /* Center the summary */
        }
        .report-summary h3 {
            color: #333;
        }
        .report-summary p {
            font-size: 1.2em; /* Increase font size for better readability */
        }
        .header-buttons {
            display: flex;
            justify-content: center; /* Center the buttons in the header */
            margin-top: 10px;
        }
        .header-buttons a {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 0 10px; /* Space between buttons */
            transition: background-color 0.3s;
        }
        .header-buttons a:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <header>
        <h1>SALES ANALYSIS</h1>
        <div class="header-buttons">
            <a href="../index.php"><i class="fas fa-home"></i> Home</a>
            <a href="../filter.php"><i class="fas fa-filter"></i> Filter</a>
            <a href="../view_restaurants.php"><i class="fas fa-eye"></i> View</a>
            <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </header>
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
            <p>Total Sales: Shs.<?php echo number_format($totalSales, 2); ?></p>
            <p>Total Orders: <?php echo $totalOrders; ?></p>
        </div>
    </main>
    
    <?php include '../footer.php'; // Include the footer ?>
</body>
</html>

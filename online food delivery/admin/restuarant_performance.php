<?php
include '../db.php'; // Include your database connection

// Fetch total amount for each restaurant
$stmt = $pdo->prepare("
    SELECT r.name AS restaurant_name, SUM(o.total_price) AS total_sales
    FROM Restaurants r
    LEFT JOIN Orders o ON r.restaurant_id = o.restaurant_id
    GROUP BY r.restaurant_id
    ORDER BY total_sales DESC
");
$stmt->execute();
$performance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$data = [];

// Prepare data for the chart
foreach ($performance_data as $row) {
    $labels[] = htmlspecialchars($row['restaurant_name']);
    $data[] = (float)$row['total_sales'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Performance</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px; /* Set a maximum width for the container */
            margin: 20px auto; /* Center the container */
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center; /* Center the title */
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Restaurant Performance</h1>
        <canvas id="performanceChart" width="400" height="200"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Total Sales (Shs)',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Sales (Shs)'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

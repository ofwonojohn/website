<?php
// Include the database connection
include('db.php');

// Fetch countries
$countryQuery = "SELECT code, name, size FROM countries";
$countryResult = $conn->query($countryQuery);

// Fetch airports
$airportQuery = "SELECT id, name, altitude, emergency_contact FROM airports";
$airportResult = $conn->query($airportQuery);

// Fetch airlines
$airlineQuery = "SELECT code, name FROM airlines";
$airlineResult = $conn->query($airlineQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviation System</title>
</head>
<body>
    <h1>East African Aviation System</h1>

    <h2>Countries</h2>
    <table border="1">
        <tr><th>Code</th><th>Name</th><th>Size (sq km)</th></tr>
        <?php while ($row = $countryResult->fetch_assoc()): ?>
        <tr><td><?= $row['code']; ?></td><td><?= $row['name']; ?></td><td><?= $row['size']; ?></td></tr>
        <?php endwhile; ?>
    </table>

    <h2>Airports</h2>
    <table border="1">
        <tr><th>ID</th><th>Name</th><th>Altitude</th><th>Emergency Contact</th></tr>
        <?php while ($row = $airportResult->fetch_assoc()): ?>
        <tr><td><?= $row['id']; ?></td><td><?= $row['name']; ?></td><td><?= $row['altitude']; ?></td><td><?= $row['emergency_contact']; ?></td></tr>
        <?php endwhile; ?>
    </table>

    <h2>Airlines</h2>
    <table border="1">
        <tr><th>Code</th><th>Name</th></tr>
        <?php while ($row = $airlineResult->fetch_assoc()): ?>
        <tr><td><?= $row['code']; ?></td><td><?= $row['name']; ?></td></tr>
        <?php endwhile; ?>
    </table>

    <?php $conn->close(); // Close the database connection ?>
</body>
</html>

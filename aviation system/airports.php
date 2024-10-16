<?php
include('db.php'); // Include DB connection
include "partials/header.php";

// Fetch airports from the database
$airportQuery = "SELECT id, name, altitude, emergency_contact FROM airports";
$airportResult = $conn->query($airportQuery);
?>

<h2>Airports</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Altitude</th>
        <th>Emergency Contact</th>
    </tr>
    <?php while ($row = $airportResult->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['altitude']; ?></td>
        <td><?= $row['emergency_contact']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<?php
include('partials/footer.php'); // Include footer
?>

<?php $conn->close(); ?>

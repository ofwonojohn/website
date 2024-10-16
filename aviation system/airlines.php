<?php
include('db.php'); // Include DB connection
include "partials/header.php";

// Fetch airlines from the database
$airlineQuery = "SELECT code, name FROM airlines";
$airlineResult = $conn->query($airlineQuery);
?>

<h2>Airlines</h2>
<table border="1">
    <tr>
        <th>Airline Code</th>
        <th>Airline Name</th>
    </tr>
    <?php while ($row = $airlineResult->fetch_assoc()): ?>
    <tr>
        <td><?= $row['code']; ?></td>
        <td><?= $row['name']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<?php
include('partials/footer.php'); // Include footer
?>

<?php $conn->close(); ?>

<?php
include "db.php";
include "partials/header.php";

//fetch countries from database
$countryQuery = "SELECT * FROM countries";
$countryResult = $conn->query($countryQuery);
?>

<h2>EAST AFRICA COUNTRIES</h2>
<table border="1">
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Size(sq km)</th>
    </tr>

    <?php while($row = $countryResult->fetch_assoc()): ?>
        <tr>
        <td><?= $row['code']; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['size']; ?></td>
    </tr>
    <?php endwhile; ?>
    <?php
include('partials/footer.php'); // Include footer
?>
</table>
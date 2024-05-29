<?php
$cars = json_decode(file_get_contents('cars.json'), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Listings - Woodland Wheels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <?php include 'header.php'; ?>

    <div class="heading">
        <h1>Available Cars</h1>
    </div>

    <div class="car-list">
        <?php
        if (!empty($cars)) {
            echo '<div class="car-grid">';
            foreach ($cars as $car) {
                echo "<div class='car-item'>";
                echo "<img src='images/" . $car['image'] . "' alt='" . $car['brand'] . " " . $car['model'] . "'>";
                echo "<h2>" . $car['brand'] . " " . $car['model'] . " (" . $car['year'] . ")</h2>";
                echo "<p>Price per Day: $" . $car['price_per_day'] . "</p>";
                echo "<p>Availability: " . $car['availability'] . "</p>";
                echo "<a href='reserve.php?id=" . $car['vehicle_ID'] . "'><button class='rent-button'>Rent</button></a>";
                echo "</div>";
            }
            echo '</div>';
        } else {
            echo "<p>No cars available at the moment.</p>";
        }
        ?>
    </div>

</div>

</body>
</html>

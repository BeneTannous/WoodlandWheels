<?php
$cars = json_decode(file_get_contents('cars.json'), true);
$type = isset($_GET['type']) ? $_GET['type'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';

$filtered_cars = array_filter($cars, function($car) use ($type, $brand) {
    return ($type && $car['type'] === $type) || ($brand && $car['brand'] === $brand);
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Cars - Woodland Wheels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <?php include 'header.php'; ?>

    <div class="heading">
        <h1>Filtered Cars</h1>
    </div>

    <div class="car-list">
        <?php
        if (!empty($filtered_cars)) {
            echo '<div class="car-grid">';
            foreach ($filtered_cars as $car) {
                echo "<div class='car-item'>";
                echo "<img src='images/" . $car['image'] . "' alt='" . $car['brand'] . " " . $car['model'] . "'>";
                echo "<div class='car-item-info'>";
                echo "<h2>" . $car['brand'] . " " . $car['model'] . "</h2>";
                echo "<p>Year model: " . $car['year'] . "</p>";
                echo "<p>Price per Day: $" . $car['price_per_day'] . "</p>";
                echo "</div>";
                if ($car['availability'] == 'Yes') {
                    echo "<p>Availability: Yes</p>";
                    echo "<a href='reserve.php?id=" . $car['vehicle_ID'] . "'><button class='rent-button'>Rent</button></a>";
                } else {
                    echo "<p>Availability: No</p>";
                    echo "<button class='rent-button unavailable' disabled>Unavailable</button>";
                }
                echo "<div class='description-overlay'>" . $car['description'] . "</div>"; // Description overlay
                echo "</div>";
            }         
            echo '</div>';
        } else {
            echo "<p>No cars found for this category.</p>";
        }
        ?>
    </div>

</div>

</body>
</html>

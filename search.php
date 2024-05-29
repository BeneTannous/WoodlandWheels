<?php
$cars = json_decode(file_get_contents('cars.json'), true);
$search_query = isset($_GET['q']) ? $_GET['q'] : '';

$search_results = array_filter($cars, function($car) use ($search_query) {
    // Iterate over each car value and check if it contains the search query
    foreach ($car as $key => $value) {
        // Skip the 'vehicle_ID' key
        if ($key === 'vehicle_ID') continue;
        
        // Check if the current value contains the search query
        if (stripos($value, $search_query) !== false) {
            return true; // Return true if any value matches the search query
        }
    }
    return false; // Return false if no match is found
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Woodland Wheels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <?php include 'header.php'; ?>

    <div class="heading">
        <h1>Search Results</h1>
    </div>

    <div class="car-list">
        <?php
        if (!empty($search_results)) {
            echo '<div class="car-grid">';
            foreach ($search_results as $car) {
                echo "<div class='car-item'>";
                echo "<img src='images/" . $car['image'] . "' alt='" . $car['brand'] . " " . $car['model'] . "'>";
                echo "<h2>" . $car['brand'] . " " . $car['model'] . "</h2>";
                echo "<p>Year model: " . $car['year'] . "</p>";
                echo "<p>Price per Day: $" . $car['price_per_day'] . "</p>";
                if ($car['availability'] == 'Yes') {
                    echo "<a href='reserve.php?id=" . $car['vehicle_ID'] . "'><button class='rent-button'>Rent</button></a>";
                } else {
                    echo "<button class='rent-button unavailable' disabled>Unavailable</button>";
                }
                echo "</div>";
            }                      
            echo '</div>';
        } else {
            echo "<p>No cars found for your search query.</p>";
        }
        ?>
    </div>

</div>

</body>
</html>

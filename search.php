<?php
$cars = json_decode(file_get_contents('cars.json'), true);
$search_query = isset($_GET['q']) ? $_GET['q'] : '';

// Function to calculate Levenshtein distance
function levenshtein_compare($str1, $str2) {
    return levenshtein(strtolower($str1), strtolower($str2));
}

$search_results = [];

// Loop through each car to find close matches
foreach ($cars as $car) {
    // Combine relevant fields into a single string
    $car_string = strtolower($car['brand'] . ' ' . $car['model'] . ' ' . $car['year'] . ' ' . $car['price_per_day'] . ' ' . $car['type'] . ' ' . $car['fuel_type'] . ' ' . $car['description']);
    
    // Check if the search query exactly matches any part of the car string
    if (stripos($car_string, $search_query) !== false) {
        $search_results[] = $car;
    }
}

// If no exact matches found, consider close matches
if (empty($search_results)) {
    // Array to store close matches
    $close_matches = [];

    foreach ($cars as $car) {
        // Calculate Levenshtein distance for each car brand and model
        $distance_brand = levenshtein_compare($search_query, $car['brand']);
        $distance_model = levenshtein_compare($search_query, $car['model']);

        // If distance is within a threshold (e.g., 3) for either brand or model, consider it a close match
        if ($distance_brand <= 3 || $distance_model <= 3) {
            $close_matches[] = $car;
        }
    }

    // Use close matches if found
    if (!empty($close_matches)) {
        $search_results = $close_matches;
    }
}
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
                if ($car['quantity'] > 0) {
                    echo "<a href='reserve.php?id=" . $car['vehicle_ID'] . "'><button class='rent-button'>Rent</button></a>";
                } else {
                    echo "<button class='rent-button unavailable' disabled>Unavailable</button>";
                }
                echo "<div class='description-overlay'>" . $car['description'] . "</div>"; // Description overlay
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

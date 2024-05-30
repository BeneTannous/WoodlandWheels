<?php
// Load cars from JSON file
$carsJson = file_get_contents('cars.json');
$cars = json_decode($carsJson, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woodland Wheels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <?php include 'header.php'; ?>

    <!-- Heading -->
    <div class="heading">
        <h1>Welcome to Woodland Wheels!</h1>
    </div>

    <!-- Car Grid View -->
    <div class="car-grid">
        <?php foreach ($cars as $car) { ?>
            <div class="car-item">
                <img src="images/<?php echo $car['image']; ?>" alt="<?php echo $car['model']; ?>">
                <h2><?php echo $car['brand'] . ' ' . $car['model']; ?></h2>
                <p>Year model: <?php echo  $car['year']; ?></p>
                <p>Price per Day: $<?php echo $car['price_per_day']; ?></p>
                <?php if ($car['quantity'] > 0) { ?>
                    <a href="reserve.php?id=<?php echo $car['vehicle_ID']; ?>"><button class="rent-button">Rent</button></a>
                <?php } else { ?>
                    <button class="rent-button unavailable" disabled>Unavailable</button>
                <?php } ?>
                <div class="description-overlay"><?php echo $car['description']; ?></div> <!-- Description overlay -->
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>

<?php
session_start();

$cars = json_decode(file_get_contents('cars.json'), true);

if (isset($_GET['vehicle_ID'])) {
    $car_id = $_GET['vehicle_ID'];
    $car = array_filter($cars, function($c) use ($car_id) {
        return $c['vehicle_ID'] == $car_id;
    });
    $car = reset($car);
    
    if (!$car) {
        die("Car not found.");
    }

    $_SESSION['reservation'] = $car;
} elseif (isset($_POST['reserve'])) {
    $_SESSION['reservation'] = array(
        'vehicle_ID' => $_POST['vehicle_ID'],
        'model' => $_POST['model'],
        'price_per_day' => $_POST['price_per_day'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date']
    );
}

$reservation = isset($_SESSION['reservation']) ? $_SESSION['reservation'] : null;

if (!$reservation) {
    die("No car selected for reservation.");
}

$total_price = 0;
if (isset($reservation['start_date']) && isset($reservation['end_date'])) {
    $start_date = new DateTime($reservation['start_date']);
    $end_date = new DateTime($reservation['end_date']);
    $interval = $start_date->diff($end_date);
    $days = $interval->days + 1;
    $total_price = $reservation['price_per_day'] * $days;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Car - Woodland Wheels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <?php include 'header.php'; ?>

    <div class="heading">
        <h1>Reserve Car</h1>
    </div>

    <div class="reservation-form">
        <form action="reserve.php" method="post">
            <input type="hidden" name="vehicle_ID" value="<?php echo $reservation['vehicle_ID']; ?>">
            <input type="hidden" name="model" value="<?php echo $reservation['model']; ?>">
            <input type="hidden" name="price_per_day" value="<?php echo $reservation['price_per_day']; ?>">

            <label for="model">Car Model:</label>
            <input type="text" id="model" name="model" value="<?php echo $reservation['model']; ?>" disabled>

            <label for="price_per_day">Price per Day:</label>
            <input type="text" id="price_per_day" name="price_per_day" value="<?php echo $reservation['price_per_day']; ?>" disabled>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <p>Total Price: $<?php echo $total_price; ?></p>

            <button type="submit" name="reserve">Reserve</button>
        </form>
    </div>

</div>

</body>
</html>

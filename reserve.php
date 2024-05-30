<?php
$carsJson = file_get_contents('cars.json');
$cars = json_decode($carsJson, true);

if (isset($_GET['id'])) {
    $car_id = $_GET['id'];
} elseif (isset($_COOKIE['reserved_vehicle_id'])) {
    $car_id = $_COOKIE['reserved_vehicle_id'];
}

$carFound = false;

if (isset($car_id)) {
    // Search for the car with the matching ID
    foreach ($cars as $car) {
        if ($car['vehicle_ID'] == $car_id) {
            // Found the matching car, assign it to $selected_car
            $selected_car = $car;
            $carFound = true;
            break; // Exit the loop once the car is found
        }
    }
}

// Redirect to index.php if the car is not found
if (!$carFound) {
    header("Location: index.php");
    exit();
}

if ($carFound) {
    setcookie("reserved_vehicle_id", $car_id, time() + (86400 * 30), "/"); // 86400 = 1 day
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation - Woodland Wheels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <?php include 'header.php'; ?>

    <div class="heading">
        <h1>Reservation</h1>
    </div>

    <div class="reserving-car-details">
    <!-- Display car information -->
        <?php if(isset($selected_car)) { ?>
            <div class="reserving-car-item">
                <div class="reserving-car-image">
                    <img src="images/<?php echo $selected_car['image']; ?>" alt="<?php echo $selected_car['model']; ?>">
                </div>
                <div class="reserving-car-info">
                    <h2><?php echo $selected_car['brand'] . ' ' . $selected_car['model']; ?></h2>
                    <p id="ppd">Price per Day: $<?php echo $selected_car['price_per_day']; ?></p>
                    <p><?php echo $selected_car['description']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>


    <div class="reservation-form">
        <form action="submit_reservation.php" method="post">
            <!-- Reservation form fields -->
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" required>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" onchange="validateStartDate()" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" onchange="validateEndDate()"required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="mobile">Mobile Number:</label>
            <input type="tel" id="mobile" name="mobile" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="license">Do you have a valid driver's license?</label>
            <select id="license" name="license" required>
                <option disabled selected>Please select:</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>

            <!-- Real-time rental cost calculation -->
            <p id="rental_cost">Rental Cost: $0.00</p>

            <button type="submit">Submit</button>
            <button type="button" onclick="cancelReservation()">Cancel</button>
        </form>
    </div>

</div>

<script src="scripts/validateDates.js"></script>
<script src="scripts/updateCost.js"></script>
<script src="scripts/validateReservationDetails.js"></script>
<script src="scripts/cancelReservation.js"></script>

</body>
</html>

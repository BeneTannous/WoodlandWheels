<?php
if (isset($_POST['car_id'])) {
    $carId = $_POST['car_id'];

    // Load the JSON file
    $json = file_get_contents('cars.json');
    $cars = json_decode($json, true);

    // Find the car by ID and get its quantity
    $quantity = 0;
    foreach ($cars as $car) {
        if ($car['vehicle_ID'] == $carId) {
            $quantity = $car['quantity'];
            break;
        }
    }

    echo json_encode(['quantity' => $quantity]);
}
?>

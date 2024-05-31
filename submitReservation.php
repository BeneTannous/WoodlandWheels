<?php
// Database configuration
include 'initTables.php';
// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vehicle_ID = $_COOKIE['reserved_vehicle_id'];
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $rent_start_date = $_POST['start_date'];
    $rent_end_date = $_POST['end_date'];
    $quantity = $_POST['quantity'];

    // Calculate the total price
    $carJson = file_get_contents('cars.json');
    $cars = json_decode($carJson, true);
    $selected_car = null;

    foreach ($cars as $car) {
        if ($car['vehicle_ID'] == $vehicle_ID) {
            $selected_car = $car;
            break;
        }
    }

    if ($selected_car) {
        $price_per_day = $selected_car['price_per_day'];
        $days = (strtotime($rent_end_date) - strtotime($rent_start_date)) / (60 * 60 * 24);
        $price = $days * $price_per_day * $quantity;

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare('INSERT INTO orders (order_id, vehicle_ID, user_name, user_email, rent_start_date, rent_end_date, quantity, price) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssssid', $vehicle_ID, $user_name, $user_email, $rent_start_date, $rent_end_date, $quantity, $price);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Redirect to the confirmReservation page with the order_id
            $order_id = $stmt->insert_id;
            echo '<script>window.location.replace("confirmReservation.php?order_id=' . $order_id . '");</script>';
        } else {
            echo 'Error: ' . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo '<script>alert("Car not found.");</script>';
        echo '<script>window.location.replace("index.php");</script>';
    }
}

// Close the database connection
$conn->close();
?>
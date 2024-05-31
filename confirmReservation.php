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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_order'])) {
    // Retrieve order ID from the form
    $order_id = $_POST['order_id'];

    // Update the status of the order to 'CONFIRMED'
    $stmt = $conn->prepare('UPDATE orders SET status = ? WHERE order_id = ?');
    $status_confirmed = 'CONFIRMED';
    $stmt->bind_param('si', $status_confirmed, $order_id);

    if ($stmt->execute()) {
        $carJson = file_get_contents('cars.json');
        $cars = json_decode($carJson, true);

        // Fetch the order details from the database
        $stmt_order = $conn->prepare('SELECT * FROM orders WHERE order_id = ?');
        $stmt_order->bind_param('i', $order_id);
        $stmt_order->execute();
        $result_order = $stmt_order->get_result();
        $order = $result_order->fetch_assoc();

        // Find the corresponding car in the JSON data and update quantity
        foreach ($cars as &$car) {
            if ($car['vehicle_ID'] == $order['vehicle_ID']) {
                $quantity = $order['quantity']; // Define $quantity here
                $car['quantity'] -= $quantity;
                break;
            }
        }
        file_put_contents('cars.json', json_encode($cars, JSON_PRETTY_PRINT));

        echo '<script>alert("Order confirmed!");</script>';
        echo '<script>window.location.replace("index.php");</script>';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    // Close the statements
    $stmt->close();
    $stmt_order->close();
}

// Retrieve order details from the database
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $stmt = $conn->prepare('SELECT * FROM orders WHERE order_id = ?');
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Reservation</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1 class="heading">Order Details</h1>
        <?php if (!empty($order)) : ?>
            <?php
            // Load car data from JSON file
            $carJson = file_get_contents('cars.json');
            $cars = json_decode($carJson, true);

            // Find the car details for the given vehicle ID
            $selected_car = null;
            foreach ($cars as $car) {
                if ($car['vehicle_ID'] == $order['vehicle_ID']) {
                    $selected_car = $car;
                    break;
                }
            }
            ?>
            <?php if ($selected_car) : ?>
                <div class="reserving-car-item">
                    <div class="reserving-car-image">
                        <img src="images/<?php echo $selected_car['image']; ?>" alt="Car Image">
                    </div>
                    <div class="reserving-car-info">
                        <div class="reservation-form">
                            <p>User Name: <?php echo $order['user_name']; ?></p>
                            <p>User Email: <?php echo $order['user_email']; ?></p>
                            <p>Rent Start Date: <?php echo $order['rent_start_date']; ?></p>
                            <p>Rent End Date: <?php echo $order['rent_end_date']; ?></p>
                            <p>Quantity: <?php echo $order['quantity']; ?></p>
                            <p>Price: <?php echo $order['price']; ?></p>
                            <p>Status: <?php echo $order['status']; ?></p>
                            <form method="post" action="">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <button type="submit" name="confirm_order" class="reservation-button">Confirm Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <p>No car details found for the given order.</p>
            <?php endif; ?>
        <?php else : ?>
            <p>No order found.</p>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
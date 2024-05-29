<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['reservation'])) {
    $reservation = $_SESSION['reservation'];

    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $license = $_POST['license'];
    $start_date = $reservation['start_date'];
    $end_date = $reservation['end_date'];
    $price = $reservation['price_per_day'];
    $status = 0; // Not confirmed

    $conn = new mysqli($servername, $username, $password, "assignment_2");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO orders (user_email, rent_start_date, rent_end_date, price, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdi", $email, $start_date, $end_date, $price, $status);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();
    $conn->close();

    $_SESSION['order_id'] = $order_id;
    header("Location: confirm.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order - Woodland Wheels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <?php include 'header.php'; ?>

    <div class="heading">
        <h1>Place Order</h1>
    </div>

    <div class="order-form">
        <form action="order.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="mobile">Mobile:</label>
            <input type="tel" id="mobile" name="mobile" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="license">Driver's License:</label>
            <input type="text" id="license" name="license" required>
            <button type="submit">Place Order</button>
        </form>
    </div>

</div>

</body>
</html>

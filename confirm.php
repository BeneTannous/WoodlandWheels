<?php
include 'config.php';

session_start();

if (!isset($_SESSION['order_id'])) {
    die("No order to confirm.");
}

$order_id = $_SESSION['order_id'];

$conn = new mysqli($servername, $username, $password, "assignment_2");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE orders SET status=1 WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->close();
$conn->close();

unset($_SESSION['reservation']);
unset($_SESSION['order_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Woodland Wheels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <?php include 'header.php'; ?>

    <div class="heading">
        <h1>Order Confirmed</h1>
    </div>

    <div class="confirmation">
        <p>Your order has been confirmed. Thank you for renting with Woodland Wheels!</p>
        <a href="index.php"><button>Back to Home</button></a>
    </div>

</div>

</body>
</html>

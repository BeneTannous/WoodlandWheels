<?php
include 'initDatabase.php';

// Check if products table exists
$tableExists = false;
$result = $conn->query("SHOW TABLES LIKE 'products'");
if ($result->num_rows > 0) {
    $tableExists = true;
}

// If products table does not exist, create it
if (!$tableExists) {
    // Read SQL file
    $sql_file = file_get_contents('products.sql');

    // Execute multi-query
    if ($conn->multi_query($sql_file)) {
        do {
            // Store first result set
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
        
        echo "<script>console.log('Database and table created successfully.');</script>";
    } else {
        echo "<script>console.error('Error creating tables: " . $conn->error . "');</script>";
    }
} else {
    echo "<script>console.log('Products table already exists.');</script>";
}

$sql_check_table = "SHOW TABLES LIKE 'order_details'";
$result = $conn->query($sql_check_table);

if ($result->num_rows == 0) {
    // Read SQL file for order_details table
    $sql_order_file = file_get_contents('order.sql');

    // Execute query
    if ($conn->query($sql_order_file) === TRUE) {
        echo "<script>console.log('Table order_details created successfully.');</script>";
    } else {
        echo "<script>console.error('Error creating order_details table: " . $conn->error. "');</script>";
    }
}

//$conn->close();
?>

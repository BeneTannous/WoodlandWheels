<?php
include 'initDatabase.php';

// Check if products table exists
$tableExists = false;
$result = $conn->query("SHOW TABLES LIKE 'orders'");
if ($result->num_rows > 0) {
    $tableExists = true;
}

// If products table does not exist, create it
if (!$tableExists) {
    // Read SQL file
    $sql_file = file_get_contents('orders.sql');

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
    echo "<script>console.log('Orders table already exists.');</script>";
}
?>

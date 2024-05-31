CREATE TABLE IF NOT EXISTS `orders` (
    `order_id` INT AUTO_INCREMENT PRIMARY KEY,
    `vehicle_ID` VARCHAR(10) NOT NULL,
    `user_name` VARCHAR(40) NOT NULL,
    `user_email` VARCHAR(40) NOT NULL,
    `rent_start_date` DATE NOT NULL,
    `rent_end_date` DATE NOT NULL,
    `quantity` INT NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `status` VARCHAR(12) NOT NULL DEFAULT 'UNCONFIRMED'
);

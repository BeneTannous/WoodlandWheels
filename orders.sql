CREATE TABLE IF NOT EXISTS `orders` (
    `vehicle_ID` VARCHAR(10) NOT NULL,
    `user_email` VARCHAR(40) NOT NULL,
    `rent_start_date` DATE NOT NULL,
    `rent_end_date` DATE NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL
    `status` BOOLEAN NOT NULL
);
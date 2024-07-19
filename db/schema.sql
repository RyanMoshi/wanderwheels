CREATE DATABASE transport_system;

USE transport_system;

-- Users Table
CREATE TABLE `users_tbl` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `role` enum('user','driver','admin') NOT NULL DEFAULT 'user',
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Trips Table
CREATE TABLE `trips_tbl` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `origin` varchar(255) NOT NULL,
    `destination` varchar(255) NOT NULL,
    `departure_time` datetime NOT NULL,
    `arrival_time` datetime DEFAULT NULL,
    `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_tbl` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Vehicles Table
CREATE TABLE `vehicles_tbl` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `driver_id` int(11) NOT NULL,
    `vehicle_type` varchar(255) NOT NULL,
    `license_plate` varchar(255) NOT NULL,
    `capacity` int(11) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `driver_id` (`driver_id`),
    CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `users_tbl` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Payments Table
CREATE TABLE `payments_tbl` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `trip_id` int(11) NOT NULL,
    `amount` decimal(10,2) NOT NULL,
    `payment_method` varchar(255) NOT NULL,
    `payment_status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `trip_id` (`trip_id`),
    CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips_tbl` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Reviews Table
CREATE TABLE `reviews_tbl` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `trip_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `rating` int(1) NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
    `comment` text DEFAULT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `trip_id` (`trip_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips_tbl` (`id`),
    CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users_tbl` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

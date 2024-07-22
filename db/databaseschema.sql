CREATE DATABASE wanderwheels;

USE wanderwheels;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'driver', 'admin') NOT NULL
);

INSERT INTO users (name, email, password, role) VALUES ('@AdminWanderWheel', 'admin@wanderwheel.com', 'hashed_password', 'admin');


CREATE TABLE drivers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    availability ENUM('yes', 'no') DEFAULT 'no',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    driver_id INT,
    origin VARCHAR(255),
    destination VARCHAR(255),
    date DATETIME,
    status ENUM('pending', 'authorized') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (driver_id) REFERENCES drivers(id)
);

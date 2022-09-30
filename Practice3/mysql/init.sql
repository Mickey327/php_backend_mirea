CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT,UPDATE,INSERT ON appDB.* TO 'user'@'localhost';
FLUSH PRIVILEGES;
USE appDB;
CREATE TABLE IF NOT EXISTS users(
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(10) NOT NULL
);
CREATE TABLE IF NOT EXISTS forecasts(
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    weather VARCHAR(100) NOT NULL,
    temp int NOT NULL,
    min_temp int NOT NULL,
    max_temp int NOT NULL,
    pressure int NOT NULL,
    wind_speed int NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO users(name, password, role) VALUES ('Pavel', 'aboba', 'admin'), ('Ivan', 'aboba2', 'user');
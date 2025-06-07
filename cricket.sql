-- Create the Database
CREATE DATABASE cricket;
USE cricket;

-- Users Table (For Registration & Login)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL
);

-- Admin Table (For Admin Login)
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Matches Table (Storing Match Information)
CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team1 VARCHAR(100) NOT NULL,
    team2 VARCHAR(100) NOT NULL,
    venue VARCHAR(255) NOT NULL,
    match_date DATE NOT NULL,
    total_tickets INT NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

-- Seats Table (To Store Available Seats for Each Match)
CREATE TABLE seats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    seat_number VARCHAR(10) NOT NULL UNIQUE,
    price DECIMAL(10,2) NOT NULL,
    status ENUM('available', 'booked') DEFAULT 'available',
    FOREIGN KEY (match_id) REFERENCES matches(id) ON DELETE CASCADE
);

-- Reservations Table (To Store Ticket Bookings)
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    match_id INT NOT NULL,
    seats VARCHAR(255) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'canceled') DEFAULT 'pending',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (match_id) REFERENCES matches(id) ON DELETE CASCADE
);

-- Insert Default Admin Credentials
INSERT INTO admin (username, password) VALUES ('admin', MD5('admin123'));

-- Insert Sample Matches
INSERT INTO matches (team1, team2, match_date, venue, total_tickets, price) VALUES
('India', 'Australia', '2025-03-20', 'Wankhede Stadium, Mumbai', 500, 800.00),
('England', 'Pakistan', '2025-04-05', 'Eden Gardens, Kolkata', 600, 700.00),
('South Africa', 'New Zealand', '2025-05-10', 'Chinnaswamy Stadium, Bangalore', 550, 750.00);

-- Insert Available Seats for Matches
INSERT INTO seats (match_id, seat_number, price, status) VALUES
(1, 'A1', 800.00, 'available'),
(1, 'A2', 800.00, 'available'),
(1, 'A3', 800.00, 'available'),
(2, 'B1', 700.00, 'available'),
(2, 'B2', 700.00, 'available'),
(3, 'C1', 750.00, 'available'),
(3, 'C2', 750.00, 'available');

-- Insert Sample Users
INSERT INTO users (name, email, password, phone) VALUES
('John Doe', 'john@example.com', MD5('password123'), '9876543210'),
('Alice Smith', 'alice@example.com', MD5('password456'), '9123456789');

-- Insert Sample Reservations
INSERT INTO reservations (user_id, match_id, seats, total_price, status) VALUES
(1, 1, 'A1, A2', 1600.00, 'confirmed'),
(2, 2, 'B1', 700.00, 'pending');

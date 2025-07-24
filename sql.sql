-- Create Database
CREATE DATABASE IF NOT EXISTS equipment_management;
USE equipment_management;

-- Create User Table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role ENUM('admin', 'staff', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reset_token VARCHAR(255) DEFAULT NULL,
    reset_token_expiry DATETIME DEFAULT NULL
);

-- Create Equipment Table
CREATE TABLE IF NOT EXISTS equipment (
    equipment_id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    brand VARCHAR(50) NOT NULL,
    borrowed_date DATE DEFAULT NULL,
    borrowed_by INT DEFAULT NULL,
    available_quantity INT NOT NULL DEFAULT 0,
    is_removed BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (borrowed_by) REFERENCES users(user_id)
);

-- Create Reservations Table
CREATE TABLE IF NOT EXISTS reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_id INT NOT NULL,
    reservation_name VARCHAR(100) NOT NULL,
    reservation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    usage_date DATE NOT NULL,
    quantity INT NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (equipment_id) REFERENCES equipment(equipment_id)
);

-- Create Borrowing Status Table
CREATE TABLE IF NOT EXISTS borrowingstatus (
    status_id INT AUTO_INCREMENT PRIMARY KEY,
    status_name VARCHAR(50) NOT NULL,
    status_description VARCHAR(100)
); 

-- Create Borrowing Table
CREATE TABLE IF NOT EXISTS borrowing (
    borrowing_id INT AUTO_INCREMENT PRIMARY KEY,
    borrower_type ENUM('Student', 'Faculty') NOT NULL,
    borrower_name VARCHAR(100) NOT NULL,
    id_number VARCHAR(50) NOT NULL,
    department VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    equipment_id INT NOT NULL,
    released_by INT NOT NULL,
    quantity INT NOT NULL, 
    returned BOOLEAN DEFAULT FALSE,
    return_date DATETIME DEFAULT NULL,
    borrowing_status INT NOT NULL, 
    FOREIGN KEY (equipment_id) REFERENCES equipment(equipment_id) ON DELETE CASCADE,
    FOREIGN KEY (released_by) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (borrowing_status) REFERENCES borrowingstatus(status_id) ON DELETE CASCADE
);

-- Create Borrowing Details Table
CREATE TABLE IF NOT EXISTS borrowingdetails (
    BorrowId INT NOT NULL,
    BorrowDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    EquipmentId INT NOT NULL,
    BorrowTime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (BorrowId, EquipmentId),
    FOREIGN KEY (BorrowId) REFERENCES borrowing(borrowing_id) ON DELETE CASCADE,
    FOREIGN KEY (EquipmentId) REFERENCES equipment(equipment_id) ON DELETE CASCADE
);

-- Insert Initial Equipment Data
INSERT INTO equipment (equipment_name, brand, quantity, borrowed_date, borrowed_by, available_quantity) VALUES
('LCD Projector', 'Epson', 3, NULL, NULL, 3),
('HDMI Cord', 'UGreen, HDTV Premium', 5, NULL, NULL, 5),
('Extension Cord', 'Omni', 5, NULL, NULL, 5),
('USB Flash Drive', 'SanDisk', 1, NULL, NULL, 1),
('Speaker', 'Creative', 1, NULL, NULL, 1),
('Hagibis Receiver', 'Hagibis', 7, NULL, NULL, 7),
('Laptop', 'Lenovo, Acer', 7, NULL, NULL, 7),
('Camera', 'Canon', 1, NULL, NULL, 1),
('USB Cable', 'Chinglung', 2, NULL, NULL, 2),
('Drawing Tablet', 'XP-Pen', 35, NULL, NULL, 35),
('Microphone', 'Borl', 1, NULL, NULL, 1);

-- Insert Initial Borrowing Status Data
INSERT INTO borrowingstatus (status_name, status_description) VALUES
    ('Borrowed', 'The item is currently being borrowed.'),
    ('Returned', 'The item has been returned to the library or the lender.'),
    ('Missing', 'The item has been reported as missing. Not returned.');
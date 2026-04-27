-- TABLE 1: users (authentication / staff)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLE 2: members (main entity)
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    membership_type ENUM('Basic', 'Standard', 'Premium') DEFAULT 'Basic',
    status ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLE 3: sessions (transaction table)
CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    user_id INT NOT NULL,
    session_type VARCHAR(100) NOT NULL,
    session_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    amount DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('Scheduled', 'Completed', 'Cancelled') DEFAULT 'Scheduled',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Default accounts
-- admin   username: admin    password: admin123
-- staff   username: staff1   password: staff123
INSERT INTO users (name, username, password, role) VALUES
('Admin User', 'admin',  'admin123', 'admin'),
('Staff One',  'staff1', 'staff123', 'staff');

-- Sample members
INSERT INTO members (full_name, email, phone, membership_type, status) VALUES
('Sam Ceremonia', 'sam@email.com', '09171234567', 'Premium', 'Active'),
('Kenjie Corcega', 'kenjie@email.com', '09281234567', 'Standard', 'Active'),
('Clyde Del Valle', 'clyde@email.com', '09391234567', 'Basic', 'Inactive');

-- Sample sessions
INSERT INTO sessions (member_id, user_id, session_type, session_date, start_time, end_time, amount, status) VALUES
(1, 1, 'Personal Training', '2025-04-15', '08:00:00', '09:00:00', 500.00, 'Completed'),
(2, 1, 'Yoga Class', '2025-04-16', '10:00:00', '11:00:00', 300.00, 'Completed'),
(3, 2, 'Zumba', '2025-04-17', '15:00:00', '16:00:00', 250.00, 'Scheduled');

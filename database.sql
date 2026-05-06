-- ============================================
-- GymTrack Database
-- Updated: Equipment Orders + Sentiment Analysis
-- ============================================

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

-- TABLE 3: orders (replaces sessions)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    user_id INT NOT NULL,
    equipment_name VARCHAR(150) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('Pending', 'Processing', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    feedback TEXT,
    sentiment ENUM('Positive', 'Neutral', 'Negative') DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- ============================================
-- SAMPLE DATA
-- ============================================

-- Default accounts (passwords stored as plain text for demo; use password_hash in production)
-- admin   username: admin    password: admin123
-- staff   username: staff1   password: staff123
INSERT INTO users (name, username, password, role) VALUES
('Admin User', 'admin',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Staff One',  'staff1', '$2y$10$TKh8H1.PyfSza7Cnl4/sMO7lhY/cMRoH6sC05EwRDiOcmkPEG5Jm2', 'staff');

-- Sample members
INSERT INTO members (full_name, email, phone, membership_type, status) VALUES
('Sam Ceremonia', 'sam@email.com', '09171234567', 'Premium', 'Active'),
('Kenjie Corcega', 'kenjie@email.com', '09281234567', 'Standard', 'Active'),
('Clyde Del Valle', 'clyde@email.com', '09391234567', 'Basic', 'Inactive');

-- Sample orders
INSERT INTO orders (member_id, user_id, equipment_name, quantity, price, status, feedback, sentiment) VALUES
(1, 1, 'Adjustable Dumbbell Set', 2, 2500.00, 'Delivered', 'Very good quality! Shipped on time.', 'Positive'),
(2, 1, 'Resistance Bands', 3, 450.00, 'Delivered', 'Okay lang, medyo late yung delivery.', 'Neutral'),
(3, 2, 'Jump Rope', 1, 350.00, 'Pending', NULL, NULL);

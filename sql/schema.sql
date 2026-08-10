-- Create Database
CREATE DATABASE IF NOT EXISTS student_db;
USE student_db;

-- Create Students Table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    matric_no VARCHAR(30) NOT NULL UNIQUE,
    department VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Sample Data for Immediate Testing
INSERT INTO students (full_name, matric_no, department, email) VALUES
('Musa Ibrahim', 'UG/20/1042', 'Computer Engineering', 'musa@futminna.edu.ng'),
('Aisha Bello', 'UG/21/1105', 'Cyber Security', 'aisha@futminna.edu.ng'),
('Emmanuel David', 'UG/20/0988', 'Electrical Engineering', 'emmanuel@futminna.edu.ng');

CREATE DATABASE IF NOT EXISTS it3220_php
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE it3220_php;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    dob DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students(code, full_name, email, dob) VALUES
('SV001','Nguyen Van A','a@gmail.com','2003-01-01'),
('SV002','Nguyen Van B','b@gmail.com','2003-02-02'),
('SV003','Nguyen Van C','c@gmail.com','2003-03-03'),
('SV004','Nguyen Van D','d@gmail.com','2003-04-04'),
('SV005','Nguyen Van E','e@gmail.com','2003-05-05');

CREATE DATABASE IF NOT EXISTS student_councile CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_councile;
CREATE TABLE IF NOT EXISTS users(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NOT NULL,email VARCHAR(190) NOT NULL UNIQUE,student_id VARCHAR(50) NULL UNIQUE,password_hash VARCHAR(255) NOT NULL,role ENUM('student','admin') NOT NULL DEFAULT 'student',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS queries(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,user_id INT UNSIGNED NOT NULL,subject VARCHAR(180) NOT NULL,category ENUM('Academic','Examination','Registration','Fees','Technical','General') NOT NULL DEFAULT 'General',message TEXT NOT NULL,status ENUM('pending','in_progress','resolved','closed') NOT NULL DEFAULT 'pending',admin_response TEXT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,CONSTRAINT fk_queries_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,INDEX(status),INDEX(user_id)) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS faqs(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,question VARCHAR(255) NOT NULL,answer TEXT NOT NULL,is_active TINYINT(1) NOT NULL DEFAULT 1,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB;
INSERT INTO faqs(question,answer) VALUES
('How do I submit a query?','Create an account, sign in, complete the query form and click Submit query.'),
('How can I check my query status?','Open My dashboard to view your queries and their current statuses.'),
('What do the statuses mean?','Pending means waiting for review; In progress means being handled; Resolved means answered; Closed means closed.'),
('Can I submit more than one query?','Yes, you can submit multiple queries from your dashboard.'),
('What if I cannot sign in?','Check your email and password, then contact the portal administrator if needed.');
-- Create admin: register on the website first, then run:
-- UPDATE users SET role='admin' WHERE email='your-registered-email@example.com';

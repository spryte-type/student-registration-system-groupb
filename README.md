# student-registration-system-groupb
FUTMINNA SIWES AWS Cloud Project — Student Registration System built with PHP, MySQL, and AWS.
# FUTMINNA SIWES AWS Cloud Project: Student Registration System (Group B)

## 📌 Project Overview
The **Student Registration System** is a decoupled two-tier web application built using PHP, HTML/CSS, and MySQL, deployed live on Amazon Web Services (AWS) infrastructure.
- **Compute / Web Server:** Apache (`httpd`) and PHP running on an Amazon EC2 Instance (Amazon Linux 2023).
- **Database Server:** Amazon RDS running a managed MySQL database (`groupb-student-db`).
- **Source Code Repository:** GitHub (`spryte-type/student-registration-system-groupb`).

---

## 🏗️ Architecture Diagram
[ Internet / User Browser ]
│
▼ (Port 80 HTTP)
┌───────────────────────┐
│    AWS EC2 Instance   │  <-- Apache (httpd) + PHP Web Server
│  (GroupB-Web-Server)  │  <-- App Code (/var/www/html)
└───────────┬───────────┘
│ (Port 3306 MySQL Inbound)
▼
┌───────────────────────┐
│    AWS RDS Instance   │  <-- Managed MySQL Database
│  (groupb-student-db)  │  <-- Database Name: student_db
└───────────────────────┘

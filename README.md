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

## 🚀 Deployment Steps Executed

### Phase 1: Managed Database Provisioning (Amazon RDS)
1. Provisioned an Amazon RDS MySQL instance named `groupb-student-db` using a Single-AZ setup (`db.t3.micro`).
2. Set Master Username as `admin` and disabled Public Access to enforce internal VPC security.
   ![RDS Database Summary](screenshots/rds-database-summary.png)
3. Created a dedicated security group `rds-sec-group` and initialized database `student_db`.
4. Extracted the live RDS Endpoint address once status changed to **Available**:
   `groupb-student-db.cotg0g886gp1.us-east-1.rds.amazonaws.com`
   ![RDS Endpoint](screenshots/rds-endpoint.png)

### Phase 2: Compute Provisioning & Security Group Cross-Linking (Amazon EC2)
1. Launched an Amazon EC2 instance named `GroupB-Web-Server` running Amazon Linux 2023 (`t2.micro`).
   ![EC2 Instance Summary](screenshots/ec2-instance-summary.png)
2. Configured security group `ec2-web-sec-group` to allow Inbound traffic on Port 22 (SSH) and Port 80 (HTTP).
   ![EC2 Security Group](screenshots/ec2-security-group.png)
3. **Cross-Linked Security Groups:** Updated `rds-sec-group` inbound rules to allow MySQL traffic (Port 3306) restricted specifically to `ec2-web-sec-group`.
   ![RDS Security Group Rules](screenshots/rds-security-group.png)

### Phase 3: Server Configuration & App Deployment
1. Connected to EC2 via SSH (`ec2-user@100.48.100.71`) and installed Apache (`httpd`), PHP, `php-mysqlnd`, Git, and the MariaDB/MySQL client tool via `dnf`.
   ![SSH Login and HTTPD Status](screenshots/ssh-login-status.png)
2. Cloned application repository directly into web root `/var/www/html/` and structured source files into root directory.
3. Imported `schema.sql` directly into RDS using the command-line client:

   mysql -h groupb-student-db.cotg0g886gp1.us-east-1.rds.amazonaws.com -u admin -p student_db < schema.sql

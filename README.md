# AWS PHP MySQL Demo

A simple PHP + MySQL CRUD application using AWS RDS. The app allows you to add students, display them in a table, update and delete records, and uses JSON API endpoints for fetching students. It also includes validation to prevent duplicate emails and has a modern UI design with animations.

---

## Project Features

- Connects to AWS RDS MySQL using PHP (mysqli)
- Add students with Name and Email
- Fetch students via API (JSON)
- Update student records
- Delete student records
- Prevent duplicate emails
- Modern UI styling with animations
- Works with local PHP server

---

## Project Structure

aws-php-mysql-demo/
│
├── index.php
└── logics/
├── dbconnection.php
├── fetch-students.php
├── process-update.php
├── update-student.php
└── delete-student.php


---

## Setup Instructions

### 1. Clone the repo
```bash
git clone <your-repo-url>
cd aws-php-mysql-demo

2. Configure database connection

Open logics/dbconnection.php and update your AWS RDS details:

$server   = "your-rds-endpoint";
$username = "your-username";
$password = "your-password";
$database = "your-database";

3. Create the students table

Run this SQL in your MySQL database:

CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE
);

4. Start PHP server
php -S localhost:8000

5. Open in browser
http://localhost:8000

How It Works
index.php

Displays the form for adding students

Shows table of students

Calls fetch-students.php using JavaScript fetch API

fetch-students.php

Returns all students as JSON

Used by the frontend to load data

process-update.php

Handles form submission

Inserts new student

Validates duplicate emails

Redirects with status success/duplicate

update-student.php

Updates student details (optional if you implement update feature)

delete-student.php

Deletes student records

Notes

Ensure you don’t print any debug messages in JSON API files (fetch-students.php), otherwise JSON parsing will fail.

Make sure AWS RDS security group allows your IP.

License

Open-source and free to use

<?php
$server   = "samuel-mysql.cxcdwsiglhfk.eu-west-1.rds.amazonaws.com";
$username = "admin";
$password = "2005samuel";
$database = "student"; // corrected to your DB

// Connect to MySQL
$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully\n";

// Drop table if exists
mysqli_query($conn, "DROP TABLE IF EXISTS enrollment");

// Create enrollment table
$sql = "CREATE TABLE enrollment (
    id INT NOT NULL AUTO_INCREMENT,
    fullname VARCHAR(45) NOT NULL,
    gender VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    course VARCHAR(45) NOT NULL,
    phonenumber VARCHAR(45) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB";

if (mysqli_query($conn, $sql)) {
    echo "Table 'enrollment' created successfully\n";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "\n";
}

// Insert demo records
$insert = "INSERT INTO enrollment (fullname, gender, email, course, phonenumber) VALUES
('Amanda Nunes','Male','anunes@ufc.com','AWS Solutions Architect','012345678910'),
('Alexander Volkanovski','Male','avolkanovski@ufc.com','AWS Solutions Architect','012345678910'),
('Khabib Nurmagomedov','Female','knurmagomedov@ufc.com','Cloud DevOps','012345678910'),
('Kamaru Usman','Male','kusman@ufc.com','Cloud DevOps','012345678910'),
('Israel Adesanya','Female','iadesanya@ufc.com','AWS Cloud Developer','012345678910'),
('Henry Cejudo','Female','hcejudo@ufc.com','AWS Solutions Architect','012345678910'),
('Valentina Shevchenko','Male','vshevchenko@ufc.com','AWS Solutions Architect','012345678910'),
('Tyron Woodley','Male','twoodley@ufc.com','AWS Solutions Architect','012345678910'),
('Rose Namajunas','Male','rnamajunas@ufc.com','AWS Cloud Developer','012345678910'),
('Tony Ferguson','Male','tferguson@ufc.com','AWS Cloud Developer','012345678910'),
('Jorge Masvidal','Female','jmasvidal@ufc.com','AWS Cloud Practitioner','012345678910'),
('Nate Diaz','Male','ndiaz@ufc.com','AWS Cloud Practitioner','012345678910'),
('Conor McGregor','Male','cmcGregor@ufc.com','AWS Solutions Architect','012345678910'),
('Cris Cyborg','Male','ccyborg@ufc.com','AWS Cloud Practitioner','012345678910'),
('Tecia Torres','Male','ttorres@ufc.com','AWS Cloud Practitioner','012345678910'),
('Ronda Rousey','Female','rrousey@ufc.com','AWS Cloud Practitioner','012345678910'),
('Holly Holm','Male','hholm@ufc.com','AWS Solutions Architect','012345678910'),
('Joanna Jedrzejczyk','Male','jjedrzejczyk@ufc.com','AWS Cloud Developer','012345678910')";

if (mysqli_query($conn, $insert)) {
    echo "Demo records inserted successfully\n";
} else {
    echo "Error inserting records: " . mysqli_error($conn) . "\n";
}

echo "Setup complete.\n";

mysqli_close($conn);
?>

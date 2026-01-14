<?php
// AWS RDS MySQL connection details
$server   = "samuel-mysql.cxcdwsiglhfk.eu-west-1.rds.amazonaws.com";
$username = "admin";
$password = "2005samuel";
$database = "student";

// Enable error reporting for PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Make mysqli throw exceptions on error
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($server, $username, $password, $database);
    echo "Connected successfully to MySQL database.\n";
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage() . "\n");
}
?>


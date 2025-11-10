<?php
// Database Configuration Template
// INSTRUCTIONS:
// 1. Copy this file and rename it to "connexion.php"
// 2. Fill in your actual database credentials below
// 3. NEVER commit connexion.php to Git (it's in .gitignore)

// For Local Development (XAMPP):
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "memora";
// $port = 3306;

// For Production (InfinityFree or other hosting):
$servername = "YOUR_DATABASE_HOST"; // e.g., sql101.infinityfree.com
$username = "YOUR_DATABASE_USERNAME"; // e.g., if0_40232630
$password = "YOUR_DATABASE_PASSWORD"; // Your secure password
$dbname = "YOUR_DATABASE_NAME"; // e.g., if0_40232630_memora
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>
<?php
require 'connexion.php';

header('Content-Type: application/json');

// Check if connection failed
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Fetch categories from the database
$query = "SELECT id, name FROM categories";
$result = $conn->query($query);

$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

echo json_encode($categories);

$conn->close();
?>
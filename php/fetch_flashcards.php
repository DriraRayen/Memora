<?php
require 'connexion.php';

header('Content-Type: application/json');

// Check if connection failed
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Check if the category ID is provided
if (isset($_GET['category_id'])) {
    $categoryId = intval($_GET['category_id']);
    error_log("Category ID: " . $categoryId); // Debugging

    // Fetch flashcard sets for the given category
    $query = "SELECT id, title FROM flashcard_sets WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    $flashcardSets = [];
    while ($row = $result->fetch_assoc()) {
        $flashcardSets[] = $row;
    }

    error_log("Flashcard Sets: " . json_encode($flashcardSets)); // Debugging
    echo json_encode($flashcardSets);
} else {
    error_log("No category ID provided"); // Debugging
    echo json_encode(['error' => 'Invalid category. Please select a valid category to view flashcard sets.']);
}

$conn->close();
?>
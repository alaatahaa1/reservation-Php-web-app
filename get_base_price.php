<?php
// Include database connection
include 'db_connect2.php';

// Check if the place is set in the POST request
if(isset($_POST['place'])) {
    // Sanitize the input to prevent SQL injection
    $place = $_POST['place'];

    // Prepare and execute SQL query to fetch the base price for the selected place
    $query = "SELECT basePrice FROM reservations WHERE place = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $place);
    $stmt->execute();
    $stmt->store_result();

    // Check if the place exists in the database
    if($stmt->num_rows > 0) {
        $stmt->bind_result($basePrice);
        $stmt->fetch();
        
        // Return the base price as a response
        echo $basePrice;
    } else {
        // If the place is not found, return an error response
        echo "Place not found";
    }

    // Close the statement
    $stmt->close();
} else {
    // If the place is not set in the POST request, return an error response
    echo "Invalid request";
}

// Close database connection
$conn->close();
?>

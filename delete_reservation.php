<?php
include 'db_connect2.php';

// Check if reservation ID is provided in the POST request
if(isset($_POST['id'])) {
    $reservation_id = $_POST['id'];
    
    // Prepare SQL statement to delete the reservation
    $sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservation_id);
    
    // Execute the SQL statement
    if($stmt->execute()) {
        // Reservation deleted successfully
        echo "Reservation deleted successfully.";
    } else {
        // Failed to delete reservation
        echo "Error deleting reservation: " . $conn->error;
    }
} else {
    // No reservation ID provided in the POST request
    echo "Reservation ID not provided.";
}

// Close database connection
$stmt->close();
$conn->close();
?>
